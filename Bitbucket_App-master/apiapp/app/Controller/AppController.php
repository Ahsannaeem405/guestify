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
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    ),
                    'scope' => array(
                        'User.role_id' => array(1)
                    )
                )
            ),
            'logoutRedirect' => array(
                'controller' => 'pages',
                'action' => 'display', 'logout'
            )
        ),
        'Permission',
        'RequestHandler',
        'Session'
    );

    public $helpers = array(
        'Form',
        'Html',
        'Js',
        'Session'
    );

    public $locale = 'eng';

    public $formats = array();

    public $config = array();

    public $periods = array();

    public $firstPollId = 0;


    public function beforeFilter() {

        # check locale
        $locale = $this->Session->read('Config.language');
        if(empty($locale)) {
            $locale = Configure::read('Language.default');
            Configure::write('Config.language', $locale);
            $this->Session->write('Config.language', $locale);
        } else {
            Configure::write('Config.language', $locale);
            $this->Session->write('Config.language', $locale);
        }
        $this->locale = $locale;


        # check auth
        $this->currentUser = $this->Auth->user();
        $this->isAuthed = !empty($this->currentUser);

        if($this->isAuthed) {
            $this->Auth->allow();
        }

        if($this->Session->check('Auth.User.id')) {
            $this->loadModel('User');
            User::store($this->Auth->user());
        }


        # define standard formats for views
        switch($locale) {
            case 'eng':
                $this->formats['date'] = 'Y-m-d';
                $this->formats['date_placeholder'] = 'YYYY-mm-dd';
                $this->formats['time'] = 'H:i';
                $this->formats['year_month'] = 'Y-m';
                $this->formats['chart_month_day'] = '%m-%d';
                $this->formats['chart_year_month'] = '%y-%m';
                $this->formats['time_with_seconds'] = 'H:i:s';
                $this->formats['datetime'] = 'Y-m-d H:i:s';
                $this->formats['currency'] = array(
                    'places' => 2,
                    'before' => '€ ',
                    'escape' => false,
                    'decimals' => ',',
                    'thousands' => '.'
                );
                break;
            case 'deu':
                $this->formats['date'] = 'd.m.Y';
                $this->formats['date_placeholder'] = 'TT.MM.JJJJ';
                $this->formats['time'] = 'H:i';
                $this->formats['year_month'] = 'm.Y';
                $this->formats['chart_month_day'] = '%d.%m';
                $this->formats['chart_year_month'] = '%m.%y';
                $this->formats['time_with_seconds'] = 'H:i:s';
                $this->formats['datetime'] = 'd.m.Y H:i:s';
                $this->formats['currency'] = array(
                    'places' => 2,
                    'before' => '€ ',
                    'escape' => false,
                    'decimals' => ',',
                    'thousands' => '.'
                );
                break;
        }

    }


    public function beforeRender() {
        $this->set('formats', $this->formats);
        $this->set('config', $this->config);
    }

}
