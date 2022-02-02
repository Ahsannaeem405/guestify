<?php
App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');

class WidgetsController extends AppController {
    public $name = 'Widgets';

    public function beforeFilter(){
        parent::beforeFilter();
    }



    /**
    * activate a widget so it can be viewed on websites
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $id
    * @return void
    */
    public function activate($id = null){
        if(!$id){
            throw new NotFoundException();
        }

        $id = intval($id);
        $this->Widget->id = $id;
        //check if the user has permission to activate the widget
        if(!$this->Permission->isAdmin() && ($this->Widget->field('account_id') != User::get('account_id'))){
            return $this->redirect(array('controller' => 'Widgets', 'action' => 'index'));
        }

        if($this->Widget->activate($id)){
            return $this->redirect($this->referer());
        } else{
            $this->Session->setFlash(__('Could not be activated'));
        }
    }


    /**
    * create a new widget and prepare data for the add form
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param post data
    * @return void
    */
    public function add(){
        //modify the form depending on the selected poll (see the add.js in webroot/js/view/widgets)
        if($this->request->is('ajax')){
            $result = $this->Widget->Poll->getType($this->params->query['poll_id']);
            $this->autoRender = false;
            return json_encode($result);
        }

        //if the request is a post request call the add function of the widgetmodel
        if($this->request->is('post')){
            //if the style was disabled no parameter will be transmitted from the form thus it has to be set here
            if(!isset($this->request->data['Widget']['style'])){
                $this->request->data['Widget']['style'] = 'standard';
            }
            $data = $this->request->data;
            if($this->Widget->add($data)){
                $this->Session->setFlash(__('Your Widget has been saved'));
                return $this->redirect(array('controller' => 'Widgets', 'action' => 'index'));
            }

            $this->Session->setFlash(__('Unable to save the widget!'));
        }

        //set parameters for the add form
        $account_id = User::get('account_id');
        $comment_choice = $this->Widget->getCommentChoices();
        $format = $this->Widget->getFormats();
        $period = $this->Widget->getPeriods();
        $polls = $this->Widget->Poll->getPollsListForWidget($account_id);
        $style = $this->Widget->getStyles();
        $widget_element_types = $this->Widget->getWidgetElementTypes();

        //pass the parameters to the view
        $this->set(compact('comment_choice', 'format', 'period', 'polls', 'style', 'widget_element_types'));
    }


    /**
    * deactivate a widget so it will not be viewed on websites
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $id
    * @return void
    */
    public function deactivate($id = null){
        if(!$id){
            throw new NotFoundException();
        }

        $id = intval($id);
        $this->Widget->id = $id;
        //check if the user has permission to deactivate the widget
        if(!$this->Permission->isAdmin() && ($this->Widget->field('account_id') != User::get('account_id'))){
            return $this->redirect(array('controller' => 'Widgets', 'action' => 'index'));
        }

        if($this->Widget->deactivate($id)){
            return $this->redirect($this->referer());
        } else{
            $this->Session->setFlash(__('Could not be deactivated'));
        }
    }


    /**
    * edit an existing widget and prepare data for the edit form
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $id
    * @return void
    */
    public function edit($id = null){
        if(!$id){
            throw new NotFoundException();
        }

        $id = intval($id);
        $this->Widget->id = $id;
        if(!$this->Widget->exists()){
            $this->Session->setFlash(__('There is no such Widget!'));
            return $this->redirect($this->referer());
        }

        //check if the user has permission to edit the widget
        if(!$this->Permission->isAdmin() && ($this->Widget->field('account_id') != User::get('account_id'))){
            return $this->redirect(array('controller' => 'Widgets', 'action' => 'index'));
        }

        //if the request is a put request send the data to the edit function of the widgetmodel
        if($this->request->is('put')){
            //if the style was disabled no parameter will be transmitted from the form thus it has to be set here
            if(!isset($this->request->data['Widget']['style'])){
                $this->request->data['Widget']['style'] = 'standard';
            }
            $data = $this->request->data;
            if($this->Widget->edit($data)){
                return $this->redirect(array('controller' => 'Widgets', 'action' => 'settings', $this->request->data['Widget']['id']));
            } else{
                $this->Session->setFlash(__('The data could not be saved. Please, try again.'));
            }
        } else{
            //get and set the request data so the form can be populated for editing
            $widget = $this->Widget->getByIdForEdit($id);
            $poll = $this->Widget->Poll->getPollsTitleForWidget($widget['Widget']['poll_id']);
            $widget['Widget']['poll_title'] = $poll['Poll']['title'];
            $this->request->data = $widget;
        }

        //set parameters for the edit form
        $comment_choice = $this->Widget->getCommentChoices();
        $format = $this->Widget->getFormats();
        $period = $this->Widget->getPeriods();
        $style = $this->Widget->getStyles();
        $widget_element_types = $this->Widget->getWidgetElementTypes();

        //pass the parameters to the view
        $this->set(compact('comment_choice', 'format', 'period', 'style', 'widget_element_types'));
    }


    /**
    * list the widgets for an account and prepare data for the index view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return mixed data
    */
    public function index(){

        $account_id = User::get('account_id');
        //paginate the list with manual options
        $this->paginate = array(
            'contain' => array(
                'Host' => array(
                    'conditions' => array(
                        'Host.deleted' => 0
                    ),
                    'fields' => array(
                        'id',
                        'name'
                    )
                ),
                'Poll' => array(
                    'conditions' => array(
                        'Poll.deleted' => 0,
                        'Poll.status' => 1
                    ),
                    'fields' => array(
                        'id',
                        'title'
                    )
                )
            ),
            'conditions' => array(
                'Widget.deleted' => 0,
                'Widget.account_id' => $account_id
            ),
            'fields' => array(
                'id',
                'name',
                'status',
                'views',
                'created'
            ),
            'limit' => 5,
            'order' => 'Widget.id ASC'
        );
        //get parameters for the view
        $has_poll = $this->Widget->Poll->checkIfPollExists($account_id);
        $statuses = $this->Widget->getStatuses();
        $widgets = $this->paginate('Widget');

        //pass the parameters to the view
        $this->set(compact('has_poll', 'statuses', 'widgets'));
    }


    /**
    * remove a widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $id
    * @return void
    */
    public function remove($id = null){
        if(!$id){
            throw new NotFoundException();
        }

        $id = intval($id);
        $this->Widget->id = $id;
        //check if the user has permission to remove the widget
        if(!$this->Permission->isAdmin() && ($this->Widget->field('account_id') != User::get('account_id'))){
            return $this->redirect(array('controller' => 'Widgets', 'action' => 'index'));
        }

        //redirect to index after removal was succesfull or show a message
        if($this->Widget->remove($id)){
            return $this->redirect(array('controller' => 'Widgets', 'action' => 'index'));
        } else{
            $this->Session->setFlash(__('Could not be deleted!'));
        }
    }


    /**
    * view the content of a single widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $id
    * @return void
    */
    public function settings($id = null){
        if(!$id){
            throw new NotFoundException();
        }

        $id = intval($id);
        $this->Widget->id = $id;
        //check if the user has permission to view the widget
        if(!$this->Permission->isAdmin() && ($this->Widget->field('account_id') != User::get('account_id'))){
            return $this->redirect(array('controller' => 'Widgets', 'action' => 'index'));
        }

        //collect and prepare the widget data for display
        $widget = $this->Widget->getById($id);
        $widget['Widget']['period'] = $this->Widget->translatePeriod($widget['Widget']['period']);
        $widget['Widget']['format'] = $this->Widget->translateFormat($widget['Widget']['format']);
        $widget['Widget']['style'] = $this->Widget->translateStyle($widget['Widget']['style']);
        foreach ($widget['WidgetElement'] as $key => $widget_element){
            $widget['WidgetElement'][$key]['type'] = $this->Widget->translateWidgetElementType($widget_element);
        }

        //pass the widget data to the view
        $this->set(compact('widget'));
    }

}
