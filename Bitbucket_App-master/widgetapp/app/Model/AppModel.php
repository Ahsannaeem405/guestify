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

    public $actsAs = array(
        'Containable'
    );



    /**
    * get ratings in words
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getRatingsInWords() {
        return array(
            10 => array(
                'text' => __('Amazing!', true),
                'label' => 'success'
            ),
            9 => array(
                'text' => __('Excellent', true),
                'label' => 'success'
            ),
            8 => array(
                'text' => __('Good', true),
                'label' => 'success'
            ),
            7 => array(
                'text' => __('Satisfied', true),
                'label' => 'success'
            ),
            6 => array(
                'text' => __('Average', true),
                'label' => 'warning'
            ),
            5 => array(
                'text' => __('Not bad', true),
                'label' => 'warning'
            ),
            4 => array(
                'text' => __('Dissatisfied', true),
                'label' => 'warning'
            ),
            3 => array(
                'text' => __('Bad', true),
                'label' => 'danger'
            ),
            2 => array(
                'text' => __('Awful', true),
                'label' => 'danger'
            ),
            1 => array(
                'text' => __('Do you care?', true),
                'label' => 'danger'
            ),
            0 => array(
                'text' => __('No rating', true),
                'label' => 'default'
            )
        );
    }


    /**
    * get the startdate for a poll and a time period selected
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $period
    * @param int $poll_id
    * @return date $start
    */
    public function getStartDate($period = null, $poll_id = null){
        if(!$period || !$poll_id){
            return false;
        }

        $today = date('Y-m-d');
        switch ($period){
            case 'week_1':
                $start = date('Y-m-d', strtotime($today . ' - 1 week'));
                break;
            case 'month_1':
                $start = date('Y-m-d', strtotime($today . ' - 1 month'));
                break;
            case 'month_3':
                $start = date('Y-m-d', strtotime($today . ' - 3 month'));
                break;
            case 'month_6':
                $start = date('Y-m-d', strtotime($today . ' - 6 month'));
                break;
            case 'year_1':
                $start = date('Y-m-d', strtotime($today . ' - 12 month'));
                break;
            case 'all':
                //if 'from the begining' is selected
                $Poll = ClassRegistry::init('Poll');
                $data = $Poll->find('first', array(
                    'conditions' => array(
                        'Poll.id' => $poll_id
                    ),
                    'fields' => array(
                        'created'
                    )
                ));
                
                $start = date('Y-m-d', strtotime($data['Poll']['created']));
                break;
            default:
                return false;
                break;
        } 

        return $start;
    }


    /**
    * get the widgetelementkeys for a widget
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $types
    */
    public function getWidgetElementTypesKeys(){
        $types = array(
            'gsi', 
            'trend', 
            'ratingcount', 
            'ratinglabel'
        );
        return $types;
    }
    
}