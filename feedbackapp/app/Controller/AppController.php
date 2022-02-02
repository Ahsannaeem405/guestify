<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package     app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $components = array(
        'RequestHandler',
        'Session',
        /*
        'DebugKit.Toolbar' => array(
            'cache' => array('engine' => 'Apc')
        ),
        */
    );

    public $helpers = array(
        'Form',
        'Html',
        'Js',
        'Session'
    );

    public $locale = 'eng';

    public function beforeFilter() {

        #$this->Session->write('Poll.language', '');
        #$this->Session->write('Force.locale', '');

        $force_locale = $this->Session->read('Force.locale');

        if(!empty($force_locale)) {
            $locale = $force_locale;
            Configure::write('Language.default', $locale);
            Configure::write('Config.language', $locale);
            $this->Session->write('Config.language', $locale);
            $this->Session->write('Poll.language', $locale);
        } else {
            $locale = $this->Session->read('Poll.language');
            if(!empty($locale)) {
                Configure::write('Language.default', $locale);
                Configure::write('Config.language', $locale);
                $this->Session->write('Config.language', $locale);
            } else {
                $locale = 'eng';
                Configure::write('Language.default', $locale);
                Configure::write('Config.language', $locale);
                $this->Session->write('Config.language', $locale);
            }
        }

        $this->locale = $locale;
    }


    public function beforeRender() {
        #$this->set('formats', $this->locale);
    }


    public function changeLanguage($code = null) {

        if(!$code) {
            $this->redirect($this->referer());
        }

        Configure::write('Language.default', $code);
        Configure::write('Config.language', $code);
        $this->Session->write('Config.language', $code);
        $this->Session->write('Poll.language', $code);
        $this->Session->write('Force.locale', $code);

        if(isset($this->params['requested'])) {
            return;
        }

        $this->redirect($this->referer());
    }


}
