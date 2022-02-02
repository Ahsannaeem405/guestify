<?php
class Widget extends AppModel {
    public $name = 'Widget';

    public $belongsTo = array(
        'Account',
        'Host',
        'Poll'
    );

    public $hasMany = array(
        'WidgetElement' => array(
            'conditions' => array(
                'WidgetElement.deleted' => 0
            )
        )
    );

    public $actsAs = array(
        'Containable'
    );



    /**
    * activate a widget so it can be viewed on websites
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_id
    * @return boolean
    */
    public function activate($widget_id = null){
        if(!$widget_id){
            return false;
        }

        $widget_id = intval($widget_id);
        $this->id = $widget_id;
        if(!$this->exists()){
            return false;
        }

        if($this->saveField('status', 1)){
            return true;
        }

        return false;
    }


    /**
    * validate the data from the widget-add-form
    * restructure it for the widget- and widgetelement-db
    * and save the data
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param array $data
    * @return boolean
    */
    public function add($data = null){
        if(!$data || !is_array($data)){
            return false;
        }


        //security escape and validate the form data
        $data['Widget']['poll_id'] = intval($data['Widget']['poll_id']);

        if(empty($data['Widget']['poll_id'])){
            $this->invalidate('poll_id',__('Please select a Poll', true));
        } else{
            $account_id = User::get('account_id');
            $this->Poll->id = $data['Widget']['poll_id'];

            if(!$this->Poll->exists() || ($this->Poll->field('account_id') != $account_id)){
                $this->invalidate('poll_id',__('Please select a Poll', true)); 
            }

        }
            
        $data['Widget']['name'] = h(trim(strip_tags($data['Widget']['name'])));
        if(empty($data['Widget']['name'])){
            $this->invalidate('name',__('You have to enter a unique name', true));
        }

        $data['Widget']['period'] = h(trim(strip_tags($data['Widget']['period'])));
        $periods = $this->getPeriodsKeys();

        if(empty($data['Widget']['period']) || !in_array($data['Widget']['period'], $periods)){
            $this->invalidate('period',__('You have to choose a period', true));
        }

        $data['Widget']['format'] = h(trim(strip_tags($data['Widget']['format'])));
        $formats = $this->getFormatsKeys();
        if(empty($data['Widget']['format']) || !in_array($data['Widget']['format'], $formats)){
            $this->invalidate('format',__('You have to choose a format', true));
        }

        $data['Widget']['style'] = h(trim(strip_tags($data['Widget']['style'])));
        $styles = $this->getStylesKeys();
        if(empty($data['Widget']['style']) || !in_array($data['Widget']['style'], $styles)){
            $this->invalidate('style',__('You have to choose a style', true));
        }

        $data['Widget']['height'] = intval($data['Widget']['height']);
        if(empty($data['Widget']['height'])){
            $this->invalidate('height',__('Please enter a height in pixel', true));
        }

        $data['Widget']['width'] = intval($data['Widget']['width']);
        if(empty($data['Widget']['width'])){
            $this->invalidate('width',__('Please enter a width in pixel', true));
        }


        $types = $this->getWidgetElementTypesKeys();
        $has_widgetElement_data = false;

        foreach($types as $key => $value){
            if(isset($data['Widget'][$value])) {
                $has_widgetElement_data = true;
            }
        }

        if(!$has_widgetElement_data){
            $this->invalidate('WigdetElements', __('There was a problem with your Element(s)!'));
        }


        //after validation verifies prepare the data for saving
        if($this->validates()){

            $account_id = User::get('account_id');
            $host_id = $this->Poll->getPollsHostIdForWidget($data['Widget']['poll_id']);
            $record['Widget']['account_id'] = $account_id;
            $record['Widget']['host_id'] = $host_id;
            $record['Widget']['poll_id'] = $data['Widget']['poll_id'];
            $record['Widget']['name'] = $data['Widget']['name'];
            $record['Widget']['period'] = $data['Widget']['period'];
            $record['Widget']['format'] = $data['Widget']['format'];
            $record['Widget']['style'] = $data['Widget']['style'];
            $record['Widget']['height'] = $data['Widget']['height'];
            $record['Widget']['width'] = $data['Widget']['width'];
            $record['Widget']['hash'] = substr(md5($record['Widget']['account_id'].$record['Widget']['poll_id'].$record['Widget']['name']), 0, 20);
            

            //create a new widget and save its data
            $this->create();
            if($this->save($record)){
                $id = $this->id;
                //for saving specific parts of the widget, widgetelements are created if they were selected in the form
                $types = $this->getWidgetElementTypesKeys();
                foreach($types as $key => $value){
                    if(isset($data['Widget'][$value]) && intval($data['Widget'][$value]) == 1){
                        $this->WidgetElement->add($value, $id);
                    }
                }

                //restructure the data for the widgetelement if it is a comment
                if(isset($data['Widget']['select_comment_count'])){
                    $this->WidgetElement->add($data['Widget']['select_comment_count'], $id);
                }
    
                return true;
            }
        }

        return false;
    }


    /**
    * deactivate a widget so it will not be viewed on websites
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_id
    * @return boolean
    */
    public function deactivate($widget_id = null){
        if(!$widget_id){
            return false;
        }

        $widget_id = intval($widget_id);
        $this->id = $widget_id;
        if(!$this->exists()){
            return false;
        }

        if($this->saveField('status', 0)){
            return true;
        }

        return false;
    }


    /**
    * validate the data from the widget-edit-form
    * restructure it for the widget- and widgetelement-db
    * and save the data or activate/deactivate existing db-entries
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param array $data
    * @return boolean
    */
    public function edit($data = null){
        if(!$data || !is_array($data)){
            return false;
        }

        //security escape and validate the form data
        $data['Widget']['poll_id'] = intval($data['Widget']['poll_id']);
        if(empty($data['Widget']['poll_id'])){
            $this->invalidate('poll_id',__('Please select a Poll', true));
        } else{
            $account_id = User::get('account_id');
            $this->Poll->id = $data['Widget']['poll_id'];
            if(!$this->Poll->exists() || ($this->Poll->field('account_id') != $account_id)){
               $this->invalidate('poll_title',__('Do NOT edit this Field!!!', true)); 
            }
        }

        $data['Widget']['id'] = intval($data['Widget']['id']);
        if(empty($data['Widget']['id'])){
            $this->invalidate('id','',true);
        } else{
            $account_id = User::get('account_id');
            $this->id = $data['Widget']['id'];
            if(!$this->exists() || ($this->field('account_id') != $account_id)){
                $this->invalidate('id','',true);
            }
        }

        $data['Widget']['name'] = h(trim(strip_tags($data['Widget']['name'])));
        if(empty($data['Widget']['name'])){
            $this->invalidate('name',__('You have to enter a unique name', true));
        }

        $data['Widget']['period'] = h(trim(strip_tags($data['Widget']['period'])));
        $periods = $this->getPeriodsKeys();
        if(empty($data['Widget']['period']) || !in_array($data['Widget']['period'], $periods)){
            $this->invalidate('period',__('You have to choose a period', true));
        }

        $data['Widget']['format'] = h(trim(strip_tags($data['Widget']['format'])));
        $formats = $this->getFormatsKeys();
        if(empty($data['Widget']['format']) || !in_array($data['Widget']['format'], $formats)){
            $this->invalidate('format',__('You have to choose a format', true));
        }

        $data['Widget']['style'] = h(trim(strip_tags($data['Widget']['style'])));
        $styles = $this->getStylesKeys();
        if(empty($data['Widget']['style']) || !in_array($data['Widget']['style'], $styles)){
            $this->invalidate('style',__('You have to choose a style', true));
        }

        $data['Widget']['height'] = intval($data['Widget']['height']);
        if(empty($data['Widget']['height'])){
            $this->invalidate('height',__('Please enter a height in pixel', true));
        }

        $data['Widget']['width'] = intval($data['Widget']['width']);
        if(empty($data['Widget']['width'])){
            $this->invalidate('width',__('Please enter a width in pixel', true));
        }

        //after validation verifies prepare the data for saving
        if($this->validates()){
            $account_id = User::get('account_id');
            $host_id = $this->Poll->getPollsHostIdForWidget($data['Widget']['poll_id']);
            $record['Widget']['account_id'] = $account_id;
            $record['Widget']['host_id'] = $host_id;
            $record['Widget']['poll_id'] = $data['Widget']['poll_id'];
            $record['Widget']['id'] = $data['Widget']['id'];
            $record['Widget']['name'] = $data['Widget']['name'];
            $record['Widget']['period'] = $data['Widget']['period'];
            $record['Widget']['format'] = $data['Widget']['format'];
            $record['Widget']['style'] = $data['Widget']['style'];
            $record['Widget']['height'] = $data['Widget']['height'];
            $record['Widget']['width'] = $data['Widget']['width'];
            $record['Widget']['hash'] = substr(md5($record['Widget']['account_id'].$record['Widget']['poll_id'].$record['Widget']['name']), 0, 20);
            
            if($this->save($record)){
                $id = $data['Widget']['id'];
                //for editing specific parts of the widget, widgetelements are activated or deactivaded if they were changed in the form:
                $types = $this->getWidgetElementTypesKeys();
                foreach($types as $key => $value){
                    if(intval($data['Widget'][$value]) == 1){
                        $this->WidgetElement->activate($value, $id);
                    } else{
                        $this->WidgetElement->deactivate($value, $id);
                    }
                }
                
                //if the widgetelement is a comment editing will be processed here
                if(isset($data['Widget']['select_comment_count'])){
                    $comment_choices = $this->getCommentChoicesKeys();
                    foreach($comment_choices as $key => $value){
                        if($data['Widget']['select_comment_count'] == $value){
                            $this->WidgetElement->editCommentCount($value, $id);
                        }
                    }
                }
            
                return true;
            }
        }

        return false;
    }


    /**
    * get a complete widget, including widgetelements and its poll title,
    * for displaying by its id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_id
    * @return array $widget
    */
    public function getById($widget_id = null){
        if(!$widget_id){
            return false;
        }

        $widget_id = intval($widget_id);
        $this->id = $widget_id;
        if(!$this->exists()){
            return false;
        }

        $widget = $this->find('first', array(
            'conditions' => array(
                'Widget.deleted' => 0,
                'Widget.id' => $widget_id
            ),
            'contain' => array(
                'WidgetElement' => array(
                    'fields' => array(
                        'type',
                        'param'
                    )
                ),
                'Poll' => array(
                    'fields' => array(
                        'title'
                    )
                )
            ),
            'fields' => array(
                'name',
                'period',
                'format',
                'width',
                'height',
                'style',
                'status',
                'hash'
            )
        ));
        
        return $widget;
    }


    /**
    * get a complete widget, including restructured widgetelements, 
    * prepared for the edit-form, by its id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_id
    * @return array widget
    */
    public function getByIdForEdit($widget_id = null){
        if(!$widget_id){
            return false;
        }
        
        $widget_id = intval($widget_id);
        $this->id = $widget_id;
        if(!$this->exists()){
            return false;
        }

        $widget = $this->find('first', array(
            'conditions' => array(
                'Widget.deleted' => 0,
                'Widget.id' => $widget_id
            ),
            'contain' => array(
                'WidgetElement' => array(
                    'fields' => array(
                        'type',
                        'param'
                    )
                )
            )
        ));

        //to determine in the form whether the style can be changed or not, the poll type is set here
        //if the the type is comment, extra editing is required
        //all widgetelementdata is copied into the widget array
        $widget['Widget']['poll_type'] = $this->Poll->getType($widget['Widget']['poll_id']);
        $types = $this->getWidgetElementTypesKeys();
        foreach($widget['WidgetElement'] as $widget_element){
            if($widget_element['type'] == 'comment'){
                $widget['Widget']['select_comment_count'] = $widget_element['param'];
            } elseif(in_array($widget_element['type'], $types)){
                $widget['Widget'][$widget_element['type']] = 1;
            } else{
                throw new NotFoundException();
            }
        }
        //delete all widgetelements
        if(isset ($widget['WidgetElement'])){
            unset($widget['WidgetElement']);
        }

        return $widget;
    }


    /**
    * remove a widget by setting the delete flag
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $widget_id
    * @return boolean
    */
    public function remove($widget_id = null){
        if(!$widget_id){
            return false;
        }

        $widget_id = intval($widget_id);
        $this->id = $widget_id;
        if(!$this->exists()){
            return false;
        }

        if($this->saveField('deleted', 1)){
            return true;
        }

        return false;
    }    
    
}