<?php
class UsersController extends AppController {

    public $name = 'Users';

    public $uses = array('User');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'login',
            'logout',
            'setInterfaceLanguage'
        ));
    }



   /**
    * Login method for the auth component
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function login() {

        if($this->Session->check('Auth.User.id')) {
            if($this->Permission->isAdmin()) {
                $this->redirect('/admin_dashboard');
            } elseif($this->Permission->isClient()) {
                $this->redirect('/dashboard');
            }
        }

        if($this->RequestHandler->isPost()) {

            if($this->Auth->login()) {

                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));

                $this->requestAction('/users/setInterfaceLanguage/'.$this->User->field('locale'));

                $this->User->saveField('last_login', date('Y-m-d H:i:s'));

                if($this->Auth->redirect() == 'pages/logout') {
                    $this->redirect('/');
                }
                if($this->Auth->user('role_id') == 1) {
                    $this->redirect('/admin_dashboard');
                } elseif($this->Auth->user('role_id') == 2) {
                    $this->Session->write('Dashboard.selected_poll_id', '');
                    $this->redirect('/dashboard');
                }
                #$this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Login failed! Wrong username or password?', true), 'default', array('class' => 'alert alert-danger'));
            }
        }

        return;
    }


   /**
    * logout method for the auth component
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function logout() {
        $this->Auth->logout();
        $this->Session->delete('Auth');

        $this->Session->setFlash(__('You have been logged out successfully!', true), 'default', array('class' => 'alert alert-success'));
        return;
    }


   /**
    * my_profile function
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function my_profile() {

        $user = $this->User->findById(User::get('id'));

        $genders = $this->User->getGenders();
        $statuses = $this->User->getStatuses();

        $this->set(compact('genders', 'statuses', 'user'));
    }



    /**
    * show the account information of a logged in client
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function profileEdit() {

        if($this->RequestHandler->isPut()) {
            $data = $this->data;

            $this->User->id = User::get('id');
            if(!$this->User->exists()) {
                $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
                $this->redirect($this->referer());
            }

            if($this->User->edit($data)) {
                $this->Session->write('Auth.User.firstname', $data['User']['firstname']);
                $this->Session->setFlash(__('Your changes have been saved!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'my_profile'));
            } else {
                $this->Session->setFlash(__('Your changes could not be saved!', true), 'default', array('class' => 'alert alert-error'));
            }
        } else {
            $this->User->id = User::get('id');
            if(!$this->User->exists()) {
                $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
                $this->redirect($this->referer());
            }

            $this->request->data = $this->User->find('first', array(
                'conditions' => array(
                    'User.deleted' => 0,
                    'User.id' => User::get('id')
                ),
                'fields' => array(
                    'User.id',
                    'User.gender',
                    'User.firstname',
                    'User.lastname',
                    'User.email'
                )
            ));
        }

        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.deleted' => 0,
                'User.id' => User::get('id')
            ),
            'fields' => array(
                'User.gender',
                'User.firstname',
                'User.lastname',
                'User.email'
            )
        ));

        $genders = $this->User->getGenders();

        $this->set(compact('genders', 'user'));
    }


    /**
    * set the interface language
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $code
    * @return void
    */
    public function setInterfaceLanguage($code = null) {

        if(!empty($code)) {
            Configure::write('Language.default', $code);
            Configure::write('Config.language', $code);

            $this->Session->write('Config.language', $code);

            #$this->ilocale = $code;
            if($this->Session->check('Auth.User.id')) {
                $this->User->id = User::get('id');
                $this->User->saveField('locale', $code);
            }
        } else {
            Configure::write('Language.default', 'eng');
            $this->Session->write('Config.language', 'eng');
            $this->locale = 'eng';
        }

        # make it possible to trigger action by other controller actions
        if(!empty($this->request->params['requested'])) {
            return;
        }

        $this->redirect($this->referer());
    }


}
