<?php
App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');

class WidgetsController extends AppController {

    public $name = 'Widgets';


    public function beforeFilter(){
        parent::beforeFilter();
    }



    /**
    * show a message that the widget is not active 
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function deactivated(){
        
    }


    /**
    * get the widget with a given hash from the database
    * if not existent show the widget deactivated page
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_hash
    * @return void
    */
    public function show($widget_hash = null){
        if(!$widget_hash){
            $this->redirect(array('controller' => 'Widgets', 'action' => 'deactivated'));
        }

        $widget_hash = h(trim(strip_tags($widget_hash)));

        $widget = $this->Widget->getByHash($widget_hash);

        if(!empty($widget) || strpos($this->referer(), Configure::read('NON_SSL_HOST_APP')) !== false){
            $this->layout = 'widget';
            $this->set(compact('widget'));
        } else{
            $this->redirect(array('controller' => 'Widgets', 'action' => 'deactivated'));
        }
    }

}