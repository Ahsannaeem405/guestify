<?php
class UsersController extends AppController {

    public $name = 'Users';

    public $uses = array('User');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'activate',
            'captcha',
            'debugRecoveryMail',
            'debugWelcomeMail',
            'forgotPassword',
            'login',
            'logout',
            'recovery',
            'register',
            'setInterfaceLanguage'
        ));
    }



   /**
    * send a confirmation with invoice PDF attached to upgrade user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param int $user_id
    * @return boolean
    */
    private function __notifyAboutRegistration($user_id = null) {

        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            )
        ));

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('smtp_amazon');

        if(Configure::read('Environment') == 'LIVE') {
            $Email->to($user['User']['email']);
        } else {
            $Email->to(Configure::read('Email.dev'));
        }

        $Email->subject(__('A new user just signed up!', true));
        $Email->template('new_registration');

        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));

        $genders = $this->User->getGenders();
        $formats = $this->formats;

        # uncomment this to see the debug version of the email (email will NOT be sent!)
        // $this->set(compact('formats', 'genders', 'user'));
        // $this->layout = 'Emails/html/default';
        // $View = new View($this, false);
        // $html = $View->render('../Emails/html/new_registration');
        // print_r($html);
        // exit;

        $Email->viewVars(compact('formats', 'genders', 'user'));

        try {
            
            $success = $Email->send();

        } catch(SocketException $e) {
            
            #$this->updateEmailLog($Email, $e);
            return false;
        }

        return true;
    }


   /**
    * send a confirmation with invoice PDF attached to upgrade user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param int $invoice_id
    * @return boolean
    */
    private function __sendReactivationLink($user_id = null) {

        $user = $this->User->findById($user_id);

        $genders = $this->User->getGenders();

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('smtp_amazon');

        if(Configure::read('Environment') == 'LIVE') {
            $Email->to($user['User']['email']);
        } else {
            $Email->to(Configure::read('Email.dev'));
        }

        $Email->subject(__('Your guestify password-recovery information', true));
        $Email->template('forgot_password');

        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));

        $formats = $this->formats;

        $Email->viewVars(compact('formats', 'genders', 'user'));

        try {
            $Email->send();
        } catch(SocketException $e) {
            #$this->updateEmailLog($Email, $e);
            return false;
        }

        return true;
    }


   /**
    * send a confirmation with invoice PDF attached to upgrade user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access private
    * @param int $invoice_id
    * @return boolean
    */
    private function __sendWelcomeMail($user_id = null) {

        $user = $this->User->find('first', array(
            'contain' => array(
                'Account' => array(
                    'Host' => array(
                        'Poll' => array(
                            'conditions' => array(
                                'Poll.deleted' => 0
                            )
                        ),
                        'conditions' => array(
                            'Host.deleted' => 0
                        )
                    )
                )
            ),
            'conditions' => array(
                'User.id' => $user_id
            )
        ));

        # don't forget to set the correct locale for the user, and set the interface back to the
        # origin locale of the admin after the sending is done!

        # $locale_backup = $this->Session->read('Config.language');
        # $this->Session->write('Config.language', $user['User']['locale']);
        # Configure::write('Config.language', $user['User']['locale']);
        # Configure::write('Language.default', $user['User']['locale']);

        $genders = $this->User->getGenders();

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('smtp_amazon');

        if(Configure::read('Environment') == 'LIVE') {
            $Email->to($user['User']['email']);
        } else {
            #$Email->to(Configure::read('Email.dev'));
            $Email->to($user['User']['email']);
        }

        $Email->subject(__('Your guestify account has been set up!', true));
        $Email->template('welcome_user');

        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));

        $formats = $this->formats;


        $Email->viewVars(compact('formats', 'genders', 'user'));

        # all that's needed to setup a tracker within the controller
        $Email = $this->setupSingleTracker($Email, 'User', $user['User']['id']);

        try {
            $result = $Email->send();
        } catch(SocketException $e) {
            #$this->updateEmailLog($Email, $e);
        }


        # $this->Session->write('Config.language', $locale_backup);
        # Configure::write('Config.language', $locale_backup);
        # Configure::write('Language.default', $locale_backup);

        return $result;
    }


   /**
    * Validate activation link (hash) and 48hrs barrier,
    * activates a user (uses model function to set status to active)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $hash
    * @return void
    */
    public function activate($hash = null) {

        if(!$hash || empty($hash)) {
            $this->Session->setFlash(__('Invalid request!', true), 'default', array('class' => 'negative alert alert-danger'));
            $this->redirect($this->referer());
        }

        if($this->Session->check('Auth.User.id')) {
            $this->Auth->logout();
        }

        if($this->RequestHandler->isPost()) {
            $data = $this->data;
            if($this->User->activate($hash, $data)) {
                $this->Session->setFlash(__('Your account has been updated, please login!', true), 'default', array('class' => 'positive alert alert-success'));
                $this->redirect('/login');
            } else {
                $this->Session->setFlash(__('Could not activate your account!', true), 'default', array('class' => 'negative alert alert-danger'));
            }
        }

        $user = $this->User->find('first', array(
            'contain' => false,
            'conditions' => array(
                'User.deleted' => 0,
                'User.activation_hash' => $hash,
                'User.status' => array(1, 2)
            )
        ));

        # check empty user
        if(empty($user)) {
            $this->Session->setFlash(__('Your activation-link is invalid!', true), 'default', array('class' => 'negative alert alert-danger'));
            $this->redirect('/');
        }
        /*
         else {
            # check valid_until field 
            $this->User->id = $user['User']['id'];
            if(strtotime($this->User->field('valid_until')) < strtotime(date("Y-m-d H:i:s"))) {
                $this->Session->setFlash(__('The activation link is out of date!', true), 'default', array('class' => 'negative alert alert-danger'));
                $this->redirect('/');
            }
        }
        */

        # always reset password inputs when displaying the form
        $this->request->data['User']['p_1'] = '';
        $this->request->data['User']['p_2'] = '';

        $this->set(compact('user'));
    }


    /**
    * show the account information of a logged in client
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function adminEdit($user_id = null) {
        if(!$user_id) {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPut()) {
            $data = $this->data;
            $this->User->id = $user_id;

            if($this->User->edit($data)) {
                $this->Session->setFlash(__('Changes have been saved!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'adminView', $this->User->id));
            } else {
                $this->Session->setFlash(__('Changes could not be saved!', true), 'default', array('class' => 'alert alert-error'));
            }
        } else {
            $this->request->data = $this->User->find('first', array(
                'conditions' => array(
                    'User.deleted' => 0,
                    'User.id' => $user_id
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
                'User.id' => $user_id
            ),
            'fields' => array(
                'User.id',
                'User.gender',
                'User.firstname',
                'User.lastname',
                'User.email'
            )
        ));

        $genders = $this->User->getGenders();
        $statuses = $this->User->getStatuses();

        $this->set(compact('genders', 'statuses', 'user'));
    }


    /**
    * list all users
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function adminIndex() {

        $conditions = array();
        $conditions['User.deleted']     = 0;
        $conditions['User.role_id >']   = 1;

        # paginate the list with manual options
        $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'User.id DESC'
        );
        $users = $this->paginate('User');

        $genders = $this->User->getGenders();
        $statuses = $this->User->getStatuses();

        $this->set(compact('genders', 'statuses', 'users'));

        $this->params['navtabs.main'] = 'users';
    }


   /**
    * view a user by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $user_id
    * @return void
    */
    public function adminView($user_id = null) {
        if(!$user_id)  {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $user = $this->User->find('first', array(
            'contain' => array(
                'Account'
            ),
            'conditions' => array(
                'User.deleted' => 0,
                'User.id' => $user_id
            )
        ));

        if(empty($user)) {
            throw new NotFoundException();
        }

        $genders = $this->User->getGenders();
        $statuses = $this->User->getStatuses();

        $user['Account']['country_name'] = $this->User->Account->Country->getCountryName($user['Account']['country_id'], $this->locale);

        $this->set(compact('genders', 'statuses', 'user'));
    }



    /**
    * captcha function to interact with cake
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function captcha() {

        Configure::write('debug', 0);
        $this->autoRender = false;

        $house      = __('House', true);
        $key        = __('Key', true);
        $flag       = __('Flag', true);
        $clock      = __('Clock', true);
        $butterfly  = __('Butterfly', true);
        $pen        = __('Pen', true);
        $lightbulb  = __('Lightbulb', true);
        $umbrella   = __('Umbrella', true);
        $heart      = __('Heart', true);
        $world      = __('World', true);

        $images = array(
            $house       => Configure::read('NON_SSL_HOST').'/img/captchaImages/01.png',
            $key         => Configure::read('NON_SSL_HOST').'/img/captchaImages/04.png',
            $flag        => Configure::read('NON_SSL_HOST').'/img/captchaImages/06.png',
            $clock       => Configure::read('NON_SSL_HOST').'/img/captchaImages/15.png',
            $butterfly   => Configure::read('NON_SSL_HOST').'/img/captchaImages/16.png',
            $pen         => Configure::read('NON_SSL_HOST').'/img/captchaImages/19.png',
            $lightbulb   => Configure::read('NON_SSL_HOST').'/img/captchaImages/21.png',
            $umbrella    => Configure::read('NON_SSL_HOST').'/img/captchaImages/40.png',
            $heart       => Configure::read('NON_SSL_HOST').'/img/captchaImages/43.png',
            $world       => Configure::read('NON_SSL_HOST').'/img/captchaImages/99.png'
        );

        $this->Session->write('simpleCaptchaAnswer', null);
        $this->Session->write('simpleCaptchaAnswer', time());
        $timestamp = $this->Session->read('simpleCaptchaTimestamp');
        $SALT = "o^Gj" . $timestamp . "7%8Wkhiugrzabjkiqf";
        $resp = array();

        header("Content-Type: application/json");

        if (!isset($images) || !is_array($images) || sizeof($images) < 3) {
            $resp['error'] = "There aren\'t enough images!";
            echo json_encode($resp);
            exit;
        }

        if (isset($_POST['numImages']) && strlen($_POST['numImages']) > 0) {
            $numImages = intval($_POST['numImages']);
        } else if (isset($_GET['numImages']) && strlen($_GET['numImages']) > 0) {
            $numImages = intval($_GET['numImages']);
        }
        $numImages = ($numImages > 0)?$numImages:5;
        $size = sizeof($images);
        $num = min(array($size, $numImages));

        $keys = array_keys($images);
        $used = array();
        mt_srand(((float) microtime() * 587) / 33);
        for ($i=0; $i<$num; ++$i) {
            $r = rand(0, $size-1);
            while (array_search($keys[$r], $used) !== false) {
                $r = rand(0, $size-1);
            }
            array_push($used, $keys[$r]);
        }
        $selectText = $used[rand(0, $num-1)];
        
        $this->Session->write('simpleCaptchaAnswer', sha1($selectText . $SALT));

        $resp['text'] = ''.$selectText;
        $resp['images'] = array();

        shuffle($used);
        for ($i=0; $i<sizeof($used); ++$i) {
            array_push($resp['images'], array(
                'hash'=>sha1($used[$i] . $SALT),
                'file'=>$images[$used[$i]]
            ));
        }
        echo json_encode($resp);
        exit;
    }


   /**
    * debug the recovery email
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $user_id
    * @return void
    */
    public function debugRecoveryMail($user_id) {

        $user = $this->User->find('first', array(
            'contain' => array(
                'Account'
            ),
            'conditions' => array(
                'User.id' => $user_id
            )
        ));

        $this->set(compact('user'));

        $this->layout = 'Emails/html/default';
        $View = new View($this, false);
        $html = $View->render('../Emails/html/forgot_password');
        print_r($html);
        exit;
    }


   /**
    * test-generation of the weekly report
    * (uses last 7 days scorecard to provide all needed information)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $user_id
    * @return void
    */
    public function debugWelcomeMail($user_id) {

        $user = $this->User->find('first', array(
            'contain' => array(
                'Account' => array(
                    'Host' => array(
                        'Poll' => array(
                            'conditions' => array(
                                'Poll.deleted' => 0
                            )
                        ),
                        'conditions' => array(
                            'Host.deleted' => 0
                        )
                    )
                )
            ),
            'conditions' => array(
                'User.id' => $user_id
            )
        ));

        $this->set(compact('user'));

        $this->layout = 'Emails/html/test';
        $View = new View($this, false);
        $html = $View->render('../Emails/html/welcome_user_test');
        print_r($html);
        exit;
    }


    /**
    * test-function for deploy script
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function deploy() {
        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }


        /**
         * GIT DEPLOYMENT SCRIPT
         *
         * Used for automatically deploying websites via github or bitbucket, more deets here:
         *
         *      https://gist.github.com/1809044
         */

        #$path = '/home/guestify/web/stage.guestify.net/public_html';
        $path_root = APP.'../..';

        #$path_backup = '/home/guestify/web/stage.guestify.net/private';
        $path_backup = $path_root.'/private';

        $timestamp = date('Y_m_d-H_i_s');

        $env = strtolower(Configure::read('Environment'));

        App::uses('ConnectionManager', 'Model');
        $dataSource = ConnectionManager::getDataSource('default');
        $db_user = $dataSource->config['login'];
        $db_pass = $dataSource->config['password'];
        $db_db   = $dataSource->config['database'];
        $db_host = $dataSource->config['host'];

        // The commands
        $commands = array(
            'echo $PWD',
            'whoami',
            'cd '.$path_root.'; zip -r '.$timestamp.'_backup_guestifyapp.zip '.$path_root.'/guestifyapp; mv '.$timestamp.'_backup_guestifyapp.zip '.$path_backup.'/',
            'cd '.$path_root.'; zip -r '.$timestamp.'_backup_feedbackapp.zip '.$path_root.'/feedbackapp; mv '.$timestamp.'_backup_feedbackapp.zip '.$path_backup.'/',
            // 'cd '.$path_root.'; zip -r '.$timestamp.'_backup_widgetapp.zip '.$path_root.'/widgetapp; mv '.$timestamp.'_backup_widgetapp.zip '.$path_backup.'/',
            'cd '.$path_root.'; mysqldump -u '.$db_user.' -p'.$db_pass.' -h '.$db_host.' '.$db_db.' | gzip > '.$timestamp.'_backup_db.sql.gz; mv '.$timestamp.'_backup_db.sql.gz '.$path_backup.'/',
            'git fetch --all',
            'git reset --hard origin/master',
            'chmod -R 777 '.$path_root.'/guestifyapp/app/tmp/',
            'chmod -R 777 '.$path_root.'/guestifyapp/app/files/',
            'chmod -R 777 '.$path_root.'/feedbackapp/app/tmp/',
            'chmod -R 777 '.$path_root.'/feedbackapp/app/files/',
            // 'chmod -R 777 '.$path_root.'/widgetapp/app/tmp/',
            // 'chmod -R 777 '.$path_root.'/widgetapp/app/files/',
            'php '.$path_root.'/guestifyapp/app/Console/cake.php Migrations.migration '.$env
        );

        // Run the commands for output
        $output = '';
        foreach($commands AS $command) {
            // Run it
            $tmp = shell_exec($command);
            // Output
            $output .= '<p>';
            $output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span><br/>";
            $output .= htmlentities(trim($tmp)) . "\n";
            $output .= '</p>';
        }

        pr($output);
        exit;

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('smtp_amazon');

        $Email->to(Configure::read('Email.dev'));
        $Email->subject(__('Deploy routine status email', true));
        $Email->template('deploy/deploy');

        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));

        $formats = $this->formats;

        $Email->viewVars(compact('env', 'formats', 'output'));

        try {
            $Email->send();
        } catch(SocketException $e) {
            #$this->updateEmailLog($Email, $e);
            return false;
        }

        $this->Session->setFlash(__('An email with the log-output has been sent to the admins!', true), 'default', array('class' => 'alert alert-success'));
        $this->redirect($this->referer());
    }


    /**
    * forgot password: generate a new activation link and send it to the user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function forgotPassword() {

        if($this->RequestHandler->isPost()) {
            $data = $this->data;
            $data['User']['email'] = h(trim(strip_tags($data['User']['email'])));

            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.deleted' => 0,
                    'User.status' => 1,
                    'User.email' => $data['User']['email']
                )
            ));

            if(empty($user)) {
                $this->User->invalidate('email', __('Sorry, no user found for this email!', true));
            } else {
                $this->User->id = $user['User']['id'];

                # maybe check if record exists here...

                if(!$this->User->setActivation($this->User->id)) {
                    $this->Session->setFlash(__('We could not generate your reactivation link! Please try again!', true), 'default', array('class' => 'alert alert-error'));
                } elseif($this->__sendReactivationLink($this->User->id)) {
                    $this->Session->setFlash(__('An email with instructions to reset your password has been sent to you!', true), 'default', array('class' => 'alert alert-success'));
                    $this->redirect('/login');
                } else {
                    $this->Session->setFlash(__('We were not able to send you an email with your recovery information! Please try again!', true), 'default', array('class' => 'alert alert-error'));
                }
            }

        }

        return true;
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

        // pr(Security::Hash('lalalala', null, true));
        // exit;

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
    * Validate activation link (hash) and 48hrs barrier,
    * activates a user (uses model function to set status to active)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $hash
    * @return void
    */
    public function recovery($hash = null) {

        if(!$hash || empty($hash)) {
            $this->Session->setFlash(__('Invalid request!', true), 'default', array('class' => 'negative alert alert-danger'));
            $this->redirect($this->referer());
        }

        $hash = h(strip_tags(trim($hash)));

        if($this->Session->check('Auth.User.id')) {
            $this->Auth->logout();
        }

        if($this->RequestHandler->isPost()) {
            $data = $this->data;

            if($this->User->recovery($hash, $data)) {
                $this->Session->setFlash(__('Your password has been updated, please login!', true), 'default', array('class' => 'positive alert alert-success'));
                $this->redirect('/login');
            } else {
                $this->Session->setFlash(__('Could not update your password. Please try again!', true), 'default', array('class' => 'negative alert alert-danger'));
            }
        }

        $user = $this->User->find('first', array(
            'contain' => false,
            'conditions' => array(
                'User.deleted' => 0,
                'User.activation_hash' => $hash,
                'User.status' => array(1, 2)
            )
        ));

        # check empty user
        if(empty($user)) {
            $this->Session->setFlash(__('Your activation-link is invalid!', true), 'default', array('class' => 'negative alert alert-danger'));
            $this->redirect('/');
        } else {
            # check valid_until field 
            $this->User->id = $user['User']['id'];
            if(strtotime($this->User->field('valid_until')) < strtotime(date("Y-m-d H:i:s"))) {
                $this->Session->setFlash(__('The activation link is out of date!', true), 'default', array('class' => 'negative alert alert-danger'));
                $this->redirect('/');
            }
        }

        # always reset password inputs when displaying the form
        $this->request->data['User']['p_1'] = '';
        $this->request->data['User']['p_2'] = '';
    }


   /**
    * register a new account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function register() {

        // $this->__notifyAboutRegistration(7);
        // exit;

        if($this->RequestHandler->isPost()) {

            $data = $this->data;

            # do some sanitizing of input data here...
            $data['User']['firstname']  = $this->request->data['User']['firstname'] = strip_tags($data['User']['firstname']);
            $data['User']['lastname']   = $this->request->data['User']['lastname'] = strip_tags($data['User']['lastname']);
            $data['User']['e_1']        = $this->request->data['User']['e_1'] = strip_tags($data['User']['e_1']);
            $data['User']['e_2']        = $this->request->data['User']['e_2'] = strip_tags($data['User']['e_2']);
            $data['User']['p_1']        = $this->request->data['User']['p_1'] = strip_tags($data['User']['p_1']);
            $data['User']['p_2']        = $this->request->data['User']['p_2'] = strip_tags($data['User']['p_2']);

            $data['User']['locale'] = $this->locale;

            $data['User']['captcha_ok'] = $this->Session->read('simpleCaptchaAnswer');  // "correct" captcha that had to be selected

            # validate captcha
            // $captcha_error = false;
            // if($data['User']['captcha'] != $data['User']['captcha_ok']) {
            //     $captcha_error = true;
            //     $this->User->invalidate('captcha', __('Please select the correct image', true));
            //     $this->set(compact('captcha_error'));
            // }

            # try register
            if($this->User->register($data)) {

                #$data['User']['password'] = $this->request->data['User']['password'] = $this->User->field('password');
                $data['User']['email']      = $this->request->data['User']['email'] = $data['User']['e_1'];
                $data['User']['password']   = $this->request->data['User']['password'] = $data['User']['p_1'];

                $this->Session->write('Testlogin', $data);

                $this->Session->write('Dashboard.selected_poll_id', '');

                $this->__notifyAboutRegistration($this->User->id);
                #$this->__sendRegularRegistrationWelcomeEmail($this->User->id);

                if($this->Auth->login()) {
                    $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                    $this->redirect('/dashboard');
                } else {
                    pr('could not login user!');
                    exit;
                }

            } else {
                $this->Session->setFlash(__('Some information is missing', true), 'default', array('class' => 'alert alert-danger'));
                $this->request->data['User']['p_1'] = '';
                $this->request->data['User']['p_2'] = '';
                $this->request->data['User']['agree_terms'] = 0;

                $inv_fields = $this->User->invalidFields();
                if(isset($inv_fields['recaptcha'][0]) && !empty($inv_fields['recaptcha'][0])) {
                    $captcha_error = $inv_fields['recaptcha'][0];
                    $this->set(compact('captcha_error'));
                }
            }
        }

        $options_genders    = $this->User->getGenders();
        $options_countries  = $this->User->Account->Country->getCountryList();
        $options_timezones  = $this->User->getTimezones();

        $this->set(compact('options_countries', 'options_genders', 'options_timezones'));
    }


    /**
    * send the welcome (activation) mail to a given user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $user_id
    * @return void
    */
    public function sendActivationLink($user_id = null) {

        $user_id = intval($user_id);

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        // if(!$this->User->setActivation($user_id)) {
        //     throw new NotFoundException();
        // }


        if($this->__sendWelcomeMail($user_id)) {

            $welcome_count = $this->User->field('welcome_mail_count') + 1;
            $this->User->saveField('welcome_mail_count', $welcome_count);
            $this->Session->setFlash(__('Welcome-mail was sent to user!', true), 'default', array('class' => 'alert alert-success'));

        } else {

            $this->Session->setFlash(__('Welcome-mail could not be sent to user!', true), 'default', array('class' => 'alert alert-error'));

        }

        $this->redirect($this->referer());
    }


    /**
    * activate a user by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $user_id
    * @return void
    */
    public function setActivate($user_id = null) {
        if(!$user_id)  {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $this->User->id = $user_id;
        if(!$this->User->exists()) {
            throw new NotFoundException();
        }

        if($this->User->saveField('status', 1)) {
            $this->Session->setFlash(__('The user was (re)activated!', true), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The user could not be activated!', true), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect($this->referer());
    }


    /**
    * deactivate a user by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function setInactivate($user_id = null) {
        if(!$user_id)  {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $this->User->id = $user_id;
        if(!$this->User->exists()) {
            throw new NotFoundException();
        }

        if($this->User->saveField('status', 0)) {
            $this->Session->setFlash(__('The user was deactivated!', true), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The user could not be deactivated!', true), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect($this->referer());
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
