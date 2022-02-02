<?php 
class WidgetElement extends AppModel {
    public $name = 'WidgetElement';

    public $belongsTo = array(
        'Widget'
    );

    public $actsAs = array(
        'Containable'
    );
    
    

    /**
    * activate a widgetelement when a widget was edited,
    * if it does not exists create a new one
    * (not for comments)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_id, string $type
    * @return boolean
    */
    public function activate($type = null, $widget_id = null){
        if(!$type || !$widget_id){
            return false;
        }

        $widget_id = intval($widget_id);
        //if project grows a check should be added if this widget_id exists
        $type = h(trim(strip_tags($type)));
        //check if widgetelement for this widget already exists and was deleted before, 
        //if so reactivate it, else add a new one
        if($this->doesExist($type, $widget_id)){
            $id = $this->getIdForEdit($type, $widget_id);
            $this->id = $id;
            if($this->field('deleted') == 1){
                $this->saveField('deleted', 0);
                return true;
            }
            return true;
        } else{
            $add = $this->add($widget_id, $type);
            return $add;
        }
        
        return false;
    }


    /**
    * save a widgetelement for a widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_id, string $type
    * @return boolean
    */
    public function add($type = null, $widget_id = null){
        if(!$type || !$widget_id){
            return false;
        }

        $widget_id = intval($widget_id);
        //if project grows a check should be added if this widget_id exists
        $type = h(trim(strip_tags($type)));
        $data['widget_id'] = $widget_id;
        $comment_choices = $this->getCommentChoicesKeys();
        //if the type is in the comment_choices key list the widgetelement data has to 
        //be modified before saving the new widgetelement
        if(in_array($type, $comment_choices)){
            $data['type'] = 'comment';
            $data['param'] = $type;
        } else{
            $data['type'] = $type;    
        }       

        $this->create();
        if($this->save($data)){
            return true;
        }

        return false;
    }


    /**
    * deactivate a widgetelement when a widget was edited
    * (not for comments)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_id, string $type
    * @return boolean
    */
    public function deactivate($type = null, $widget_id = null){
        if(!$type || !$widget_id){
            return false;
        }

        $widget_id = intval($widget_id);
        //if project grows a check should be added if this widget_id exists
        $type = h(trim(strip_tags($type)));
        if($this->doesExist($type, $widget_id)){
            $id = $this->getIdForEdit($type, $widget_id);
            $this->id = $id;
            if($this->field('deleted') == 0){
                //change from active to not active
                $this->saveField('deleted', 1);
                return true;
            }
            //already not active
            return true;
        }
        //not existing is equal to not active
        return true;
    }


    /**
    * check if the widgetelement already exists in the db
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param int $widget_id, string $type
    * @return boolean
    */
    private function doesExist($type = null, $widget_id = null){
        if(!$type || !$widget_id){
            return false;
        }
        
        $widget_id = intval($widget_id);
        //if project grows a check should be added if this widget_id 
        //exists and the type is valid
        $type = h(trim(strip_tags($type)));
        if($this->find('first', array(
            'conditions' => array(
                'widget_id' => $widget_id,
                'type' => $type
            )
        ))){
            return true;
        } else{
            return false;
        }
    }


    /**
    * change the comment widgetelement if one exists for this widget
    * (acts also as activate and deactivate for comments)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_id, string $type
    * @return boolean
    */
    public function editCommentCount($type = null, $widget_id = null){
        if(!$type || !$widget_id){
            return false;
        }

        $widget_id = intval($widget_id);
        //if project grows a check should be added if this widget_id exists
        $type = h(trim(strip_tags($type)));
        if($this->doesExist('comment', $widget_id)){
            //if a widgetelement with a type of comment exists, and the new type is none, 
            //deactivate the widgetelement, by setting the deleted flag
            $WidgetElement_id = $this->getIdForEdit('comment', $widget_id);
            $this->id = $WidgetElement_id;
            if($type == 'none'){
                $this->saveField('param', $type);
                $this->saveField('deleted', 1);
                return true;
            } else{
                if($this->isActive($WidgetElement_id)){
                    //if the new type has another value and the current one is active save the new type, 
                    $this->saveField('param', $type);
                    return true;
                } else{
                    //if its not acitve save the new type and activate it by unsetting the deleted flag
                    $this->saveField('param', $type);    
                    $this->saveField('deleted', 0);
                    return true;
                }
            }
        } elseif(!$this->doesExist('comment', $widget_id)){
            //if it does not exist, add it
            if($this->add($widget_id, $type)){
                return true;
            }

            return false;
        }

        return false;
    }


    /**
    * find the id for an existing widgetelement for editing
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param int $widget_id, string $type
    * @return boolean
    */
    private function getIdForEdit($type = null, $widget_id = null){
        if(!$type || !$widget_id){
            return false;
        }

        $widget_id = intval($widget_id);
        //if project grows a check should be added if this widget_id 
        //exists and the type is valid
        $type = h(trim(strip_tags($type)));
        $widget_element = $this->find('first', array(
                'conditions' => array(
                    'widget_id' => $widget_id,
                    'type' => $type
                )
        ));
        if(!empty($widget_element)){
            return $widget_element['WidgetElement']['id'];
        } else{
            return false;
        }

        return false;
    }


    /**
    * checks if a WidgetElement has the deleted flag set or not
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param int $WidgetElement_id
    * @return boolean
    */
    private function isActive($widget_element_id = null){
        if(!$widget_element_id){
            return false;
        }
       
        $widget_element_id = intval($widget_element_id);
        $this->id = $widget_element_id;
        if(!$this->exists()){
            return false;
        }
        if($this->field('deleted') == 0){
            return true;
        } else{
            return false;
        }

        return false;
    }
    
}