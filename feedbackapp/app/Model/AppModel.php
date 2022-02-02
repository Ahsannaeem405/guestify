<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    
    public $recursive = -1;

    /**
    * remap an array to use the model id as array-key
    * neat little function to build datasets and increase 
    * performance incredibly by avoiding contains on massive 
    * datasets
    * 
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return mixed result
    */
    public function remapData($data = null, $model = null, $key = 'id') {

        $result = array();

        foreach($data as $rec) {
            $result[$rec[$model][$key]] = $rec;
        }

        return $result;
    }

}
