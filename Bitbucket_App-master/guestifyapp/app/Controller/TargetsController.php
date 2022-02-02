<?php
class TargetsController extends AppController {

    public $name = 'Targets';

    public $uses = array('Target');

    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Session->check('Auth.User.id')) {
            $this->redirect('/');
        }
        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }
    }



    /**
    * delete a target
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $target_id
    * @return void
    */
    public function adminDelete($target_id = null) {
        if(!$target_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }


        $this->Target->id = $target_id;
        if(!$this->Target->exists()) {
            throw new NotFoundException();
        }

        if($this->Target->saveField('deleted', 1)) {
            $this->Session->setFlash(__('The target was deleted!', true), 'default', array('class' => 'alert alert-success'));
            $this->redirect(array('action' => 'adminIndex'));
        } else {
            $this->Session->setFlash(__('The target could not be deleted!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }
        
    }


    /**
    * list all targets by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function adminIndex($category_id = 1, $type = 'list') {

        $conditions = array();
        $conditions['Target.deleted']     = 0;
        $conditions['Target.transfer']    = 0;
        $conditions['Target.category_id'] = $category_id;
        
        if($type == 'list') {
            $conditions['Target.prepared']= 0;
        } else {
            $conditions['Target.prepared']= 1;
        }

        if($this->RequestHandler->isPost()) {
            $data = $this->data;
            
            if(!isset($data['reset'])) {

                $conditions_plain = $conditions;

                if(isset($data['Target']['id']) && !empty($data['Target']['id'])) {
                    $conditions['Target.id'] = $data['Target']['id'];
                    $conditions_plain['Target.id'] = $data['Target']['id'];
                    $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.id', $data['Target']['id']);
                } else {
                    $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.id', '');
                }
                
                if(isset($data['Target']['name']) && !empty($data['Target']['name'])) {
                    $conditions['Target.name LIKE'] = '%'.$data['Target']['name'].'%';
                    $conditions_plain['Target.name'] = $data['Target']['name'];
                    $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.name', $data['Target']['name']);
                } else {
                    $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.name', '');
                }

                if(isset($data['Target']['zipcode']) && !empty($data['Target']['zipcode'])) {
                    $conditions['Target.zipcode LIKE'] = '%'.$data['Target']['zipcode'].'%';
                    $conditions_plain['Target.zipcode'] = $data['Target']['zipcode'];
                    $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.zipcode', $data['Target']['zipcode']);
                } else {
                    $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.zipcode', '');
                }

                if(isset($data['Target']['city']) && !empty($data['Target']['city'])) {
                    $conditions['Target.city LIKE'] = '%'.$data['Target']['city'].'%';
                    $conditions_plain['Target.city'] = $data['Target']['city'];
                    $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.city', $data['Target']['city']);
                } else {
                    $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.city', '');
                }

                $this->Session->write('Targets.conditions.'.$category_id.'.'.$type, $conditions);
            } else {
                $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.id', '');
                $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.name', '');
                $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.zipcode', '');
                $this->Session->write('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.city', '');
                $this->Session->write('Targets.conditions.'.$category_id.'.'.$type, '');
            }

        } else {
            $search_conditions = $this->Session->read('Targets.conditions.'.$category_id.'.'.$type);
            if(!empty($search_conditions)) {
                $conditions = array_merge($conditions, $search_conditions);
            }
        }
        
        #$conditions = array();
        #pr($conditions);
        #exit;

        # paginate the list with manual options
        $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'Target.name ASC'
        );
        $targets = $this->paginate('Target');

        $categories = $this->Target->getCategories();

        $navtab_counts = $this->Target->getNavtabCounts($category_id, $type);

        $this->set(compact('categories', 'category_id', 'navtab_counts', 'targets', 'type'));

        $this->params['navtabs.main'] = 'targets';
        $this->params['Targets.index.tab'] = $type;
    }


    /**
    * transform a target into a new account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $target_id
    * @return void
    */
    public function adminTransfer($target_id = null) {
        if(!$target_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        $this->Target->id = $target_id;
        if(!$this->Target->exists()) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPost()) {

            $data = $this->data;

            if($this->Target->transfer($data)) {
                $this->Session->setFlash(__('The target has been transfered as host to the given account!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('controller' => 'hosts', 'action' => 'adminView', $this->Target->Account->Host->id));
            } else {
                $this->Session->setFlash(__('Some information is missing!', true), 'default', array('class' => 'alert alert-error'));
                /*
                pr($this->Target->Account->invalidFields());
                pr($this->Target->Account->User->invalidFields());
                pr($this->Target->Account->Host->invalidFields());
                exit;
                */
            }
        } else {
            $target = $this->Target->findById($target_id);
            $this->request->data['Host'] = $target['Target'];
            $this->request->data['Host']['id'] = null;
            $this->request->data['Host']['target_id'] = $target['Target']['id'];
            
            #$this->request->data['Host']['name'] = $target['Target']['name'];
            $this->request->data['Host']['locale'] = 'deu';
            #$this->request->data['Host']['timezone'] = $target['Target']['timezone'];
        }

        $target = $this->Target->findById($target_id);
        
        $Country = ClassRegistry::init('Country');
        $options_countries  = $Country->getCountryList($this->locale);
        $options_states     = $Country->getStates(1);
        $options_timezones  = $Country->Host->getTimezones();
        $options_locale = Configure::read('Locales');

        $this->set(compact('options_countries', 'options_locale', 'options_states', 'options_timezones', 'target'));
    }


    /**
    * transfer a target to an existing account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function adminTransform($target_id = null) {
        if(!$target_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        $this->Target->id = $target_id;
        if(!$this->Target->exists()) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPut()) {

            $data = $this->data;
            $this->Target->id = $data['Target']['id'];

            if($this->Target->transform($data)) {
                $this->Session->setFlash(__('The account has been created!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('controller' => 'accounts', 'action' => 'adminView', $this->Target->Account->id));
            } else {
                $this->Session->setFlash(__('Some information is missing!', true), 'default', array('class' => 'alert alert-error'));
                /*
                pr($this->Target->Account->invalidFields());
                pr($this->Target->Account->User->invalidFields());
                pr($this->Target->Account->Host->invalidFields());
                exit;
                */
            }
        } else {
            $this->request->data = $this->Target->findById($target_id);

            $this->request->data['Account']['company_name'] = $this->request->data['Target']['name'];
            $this->request->data['Account']['address']      = $this->request->data['Target']['address'];
            $this->request->data['Account']['zipcode']      = $this->request->data['Target']['zipcode'];
            $this->request->data['Account']['city']         = $this->request->data['Target']['city'];
            $this->request->data['Account']['phone']        = $this->request->data['Target']['phone'];
            $this->request->data['Account']['fax']          = $this->request->data['Target']['fax'];

            if(empty($this->request->data['Target']['email'])) {
                $this->request->data['User']['e_1'] = Configure::read('Email.dev');
                $this->request->data['User']['e_2'] = Configure::read('Email.dev');
            }

            if(empty($this->request->data['Target']['email'])) {
                $this->request->data['Target']['email'] = Configure::read('Email.dev');
            }
        }

        $target = $this->Target->findById($target_id);

        $Country = ClassRegistry::init('Country');
        $options_countries  = $Country->getCountryList($this->locale);
        $options_genders    = $Country->Account->User->getGenders();
        $options_states     = $Country->getStates(1);
        $options_timezones  = $Country->Host->getTimezones();

        $this->set(compact('options_countries', 'options_genders', 'options_states', 'options_timezones', 'target'));
    }


    /**
    * view a target record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $target_id
    * @return void
    */
    public function adminView($target_id = null) {
        if(!$target_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        $this->Target->id = $target_id;
        if(!$this->Target->exists()) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPut()) {
            $data = $this->data;
            $this->Target->id = $data['Target']['id'];
            if($this->Target->save($data)) {
                $this->Session->setFlash(__('Your changes have been saved!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect($this->referer());
            } else {
                pr($this->Target->invalidFields());
                exit;
            }
        } else {
            $this->request->data = $this->Target->findById($target_id);
        }

        $target = $this->Target->findById($target_id);

        $categories = $this->Target->getCategories();
        $Country = ClassRegistry::init('Country');
        $countries = $Country->getCountryList();
        $states = $Country->getStates(1);
        $timezones = $Country->Host->getTimezones();

        $this->set(compact('categories', 'countries', 'states', 'target', 'timezones'));
    }


}

