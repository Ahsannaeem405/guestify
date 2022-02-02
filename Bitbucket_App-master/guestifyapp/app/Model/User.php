<?php
class User extends AppModel {

    public $name = 'User';

    public $belongsTo = array(
        'Account',
        'Role'
    );

    public $hasMany = array();

    public $actsAs = array(
        'Containable'
    );

    public $allowed_emails = array(
        'appadmin@guestify.net'
    );




    /**
    * check if a given email-address is already in use
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $email
    * @return boolean
    */
    public function checkUniqueUserEmail($email = null) {

        if(in_array($email, $this->allowed_emails)) {
            return true;
        }

        $check = $this->find('first', array(
            'conditions' => array(
                'User.deleted' => 0,
                'User.email' => $email
            )
        ));

        if(!empty($check)) {
            return false;
        }

        return true;
    }

    /**
    * get the currently logged in user instance
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $path
    * @return mixed $data
    */
    public static function get($path = false) {
        $data = User::getInstance();
        if($path) {
            if(strpos($path, 'User') !== false) {
                $path = sprintf('User.%s', $path);
            }
            $value = Set::ClassicExtract($data, $path);
            return $value;
        } else {
            return $data;
        }
    }

    /**
    * store/instantiate a user
    * used for User::get() function
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $user
    * @return $user
    */
    public static function store($user) {
        if(empty($user)) {
            return false;
        }
        return User::getInstance($user);
    }

    /**
    * activate a user's account (set status => 2)
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function activate($hash = null, $data = null) {

        if(!$hash || !$data) {
            return false;
        }

        $user = $this->find('first', array(
            'conditions' => array(
                'User.deleted' => 0,
                'User.activation_hash' => $hash,
                'User.status' => array(1, 2)
            )
        ));

        if(empty($user)) {
            return false;
        }


        if(empty($data['User']['p_1'])) {
            $this->invalidate('p_1', __('Please enter your password!', true));
        } elseif(strlen($data['User']['p_1']) < 8) {
            $this->invalidate('p_1', __('Please enter a password with at least 8 chars!', true));
        }

        if(empty($data['User']['p_2'])) {
            $this->invalidate('p_2', __('Please confirm you password!', true));
        } elseif(strlen($data['User']['p_2']) < 8) {
            $this->invalidate('p_2', __('Please enter a password with at least 8 chars!', true));
        }

        if(!empty($data['User']['p_1']) && !empty($data['User']['p_2'])) {
            if($data['User']['p_1'] != $data['User']['p_2']) {
                $this->invalidate('p_1', __('Your passwords do not match!', true));
                $this->invalidate('p_2', __('Your passwords do not match!', true));
            } else {
                $pass = Security::hash($data['User']['p_1'], null, true);
            }
        }

        if($this->validates()) {

            $this->id = $user['User']['id'];
            if($this->saveField('password', $pass) && $this->saveField('status', 1) && $this->saveField('valid_until', date("Y-m-d H:i:s")) && $this->saveField('activation_hash', NULL)) {
                return true;
            }
        }

        return false;
    }

    /**
    * edit a user's profile
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function edit($data = null) {
        if(!$data || !isset($this->id)) {
            return false;
        }


        if($data['User']['gender'] == '') {
            $this->invalidate('gender', __('Please select your gender!', true));
        }
        if(empty($data['User']['firstname'])) {
            $this->invalidate('firstname', __('Please enter your firstname!', true));
        }
        if(empty($data['User']['lastname'])) {
            $this->invalidate('lastname', __('Please enter your lastname!', true));
        }

        if(!empty($data['User']['email_new'])) {
            if(!filter_var($data['User']['email_new'], FILTER_VALIDATE_EMAIL)) {
                $this->invalidate('email_new', __('Please enter a valid email-address!', true));
            } elseif(empty($data['User']['email_new_confirm'])) {
                $this->invalidate('email_new_confirm', __('Please confirm your new email-address!', true));
            } elseif(!filter_var($data['User']['email_new_confirm'], FILTER_VALIDATE_EMAIL)) {
                $this->invalidate('email_new_confirm', __('Please enter a valid email-address!', true));
            } else {
                $data['User']['email'] = $data['User']['email_new'];
            }
        }

        if(isset($data['User']['pass_current']) && !empty($data['User']['pass_current'])) {
            if(Security::hash($data['User']['pass_current'], null, true) != $this->field('password')) {
                $this->invalidate('pass_current', __('Wrong current password!', true));
            } elseif(empty($data['User']['pass_new'])) {
                $this->invalidate('pass_new', __('Please enter your new password!', true));
            } elseif(strlen($data['User']['pass_new']) < 8) {
                $this->invalidate('pass_new', __('Please enter a password with at least 8 chars!', true));
            } elseif(empty($data['User']['pass_new_confirm'])) {
                $this->invalidate('pass_new_confirm', __('Please confirm your new password!', true));
            } elseif(strlen($data['User']['pass_new_confirm']) < 8) {
                $this->invalidate('pass_new', __('Please enter a password with at least 8 chars!', true));
            } elseif($data['User']['pass_new'] != $data['User']['pass_new_confirm']) {
                $this->invalidate('pass_new', __('Your passwords do not match!', true));
                $this->invalidate('pass_new_confirm', __('Your passwords do not match!', true));
            } else {
                $data['User']['password'] = Security::hash($data['User']['pass_new'], null, true);
            }
        }

        # add change of password here!

        if($this->validates()) {
            if($this->save($data)) {
                return true;
            }
        }

        return false;
    }

    /**
    * get an array of genders
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $genders
    */
    public function getGenders() {
        $genders = array(
            0 => __('Mr', true),
            1 => __('Mrs.', true),
            2 => __('Miss', true)
        );

        return $genders;
    }

    /**
    * get an array of statuses
    * standard-statuses; overwrite this method
    * if you need other stati in your models!
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getStatuses() {
        return array(
            0 => __('inactive', true),
            1 => __('active', true),
            2 => __('awaiting activation', true)
        );
    }


    /**
    * register a new account via public registration
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function register($data = null) {
        if(!$data) {
            return $data;
        }

        if($data['User']['gender'] == '') {
            $this->invalidate('gender', __('Please select your gender!', true));
        }
        if(empty($data['User']['firstname'])) {
            $this->invalidate('firstname', __('Please enter your firstname!', true));
        }
        if(empty($data['User']['lastname'])) {
            $this->invalidate('lastname', __('Please enter your lastname!', true));
        }

        # captcha validation
        // if($data['User']['captcha'] != $data['User']['captcha_ok']) {
        //     $this->invalidate('captcha', __('Please select the correct picture!', true));
        // }

        # email validation
        if(empty($data['User']['e_1'])) {
            $this->invalidate('e_1', __('Please enter your email-address!', true));
        }
        if(empty($data['User']['e_2'])) {
            $this->invalidate('e_2', __('Please confirm your email-address!', true));
        }

        if(!empty($data['User']['e_1']) && !empty($data['User']['e_2'])) {
            if($data['User']['e_1'] != $data['User']['e_2']) {
                $this->invalidate('e_1', __('Email-addresses do not match!', true));
                $this->invalidate('e_2', __('Email-addresses do not match!', true));
            } elseif(!filter_var($data['User']['e_1'], FILTER_VALIDATE_EMAIL)) {
                $this->invalidate('e_1', __('Please enter a valid email-address!', true));
            } elseif(!filter_var($data['User']['e_2'], FILTER_VALIDATE_EMAIL)) {
                $this->invalidate('e_2', __('Please enter a valid email-address!', true));
            } elseif(!$this->checkUniqueUserEmail($data['User']['e_1'])) {
                $this->invalidate('e_1', __('This email is already in use!', true));
                $this->invalidate('e_2', __('This email is already in use!', true));
            } else {
                $data['User']['email'] = $data['User']['e_1'];
            }
        }

        # password validation
        if(empty($data['User']['p_1'])) {
            $this->invalidate('p_1', __('Please enter your password!', true));
        } elseif(strlen($data['User']['p_1']) < 8) {
            $this->invalidate('p_1', __('Please enter a password with at least 8 chars!', true));
        }

        if(empty($data['User']['p_2'])) {
            $this->invalidate('p_2', __('Please confirm you password!', true));
        } elseif(strlen($data['User']['p_2']) < 8) {
            $this->invalidate('p_2', __('Please enter a password with at least 8 chars!', true));
        }

        if(!empty($data['User']['p_1']) && !empty($data['User']['p_2'])) {
            if($data['User']['p_1'] != $data['User']['p_2']) {
                $this->invalidate('p_1', __('Your passwords do not match!', true));
                $this->invalidate('p_2', __('Your passwords do not match!', true));
            } else {
                $data['User']['password'] = Security::hash($data['User']['p_1'], null, true);
            }
        }

        /*
        if(empty($data['User']['agree_terms'])) {
            $this->invalidate('agree_terms', __('You need to accept the terms & conditions in order to use this service!', true));
        }
        */

        # https://www.google.com/recaptcha/api/siteverify
        require(APP . 'Vendor/recaptcha/autoload.php');
        $recaptcha = new \ReCaptcha\ReCaptcha('6LdZihQTAAAAAMg-IPlscmA34AVcys2ScLz7rvUo');
        $resp = $recaptcha->verify($data['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

        if(!$resp->isSuccess()) {
            $errors = $resp->getErrorCodes();
            $this->invalidate('recaptcha', __('Are you a human?', true));
        }


        if($this->validates()) {

            # setup account
            $account = array();
            $account['Account']['company_name'] = '';
            $account['Account']['subdomain']    = '';

            $this->Account->create();

            # make this try-catch blocks!
            if(!$this->Account->save($account)) {
                pr($this->Account->invalidFields());
                exit;
            }

            # setup user
            $data['User']['account_id'] = $this->Account->id;
            $data['User']['role_id']    = 2;
            $data['User']['status']     = 1;    // active
            $data['User']['user_pin']   = 11111;
            $data['User']['activation_hash'] = md5(date("Y-m-d H:i:s")).$this->id;
            $data['User']['valid_until']     = date("Y-m-d H:i:s", strtotime("+7 days"));

            $this->create();

            # make this try-catch blocks!
            if(!$this->save($data)) {
                pr($this->invalidFields());
            }

            return true;
        }

        return false;
    }


    /**
    * recovery - setup new password for a user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function recovery($hash = null, $data = null) {

        if(!$hash || !$data) {
            return false;
        }

        $user = $this->find('first', array(
            'conditions' => array(
                'User.deleted' => 0,
                'User.activation_hash' => $hash,
                'User.status' => array(1, 2)
            )
        ));

        if(empty($user)) {
            return false;
        }


        if(empty($data['User']['p_1'])) {
            $this->invalidate('p_1', __('Please enter your password!', true));
        } elseif(strlen($data['User']['p_1']) < 8) {
            $this->invalidate('p_1', __('Please enter a password with at least 8 chars!', true));
        }

        if(empty($data['User']['p_2'])) {
            $this->invalidate('p_2', __('Please confirm you password!', true));
        } elseif(strlen($data['User']['p_2']) < 8) {
            $this->invalidate('p_2', __('Please enter a password with at least 8 chars!', true));
        }

        if(!empty($data['User']['p_1']) && !empty($data['User']['p_2'])) {
            if($data['User']['p_1'] != $data['User']['p_2']) {
                $this->invalidate('p_1', __('Your passwords do not match!', true));
                $this->invalidate('p_2', __('Your passwords do not match!', true));
            } else {
                $pass = Security::hash($data['User']['p_1'], null, true);
            }
        }

        if($this->validates()) {

            $this->id = $user['User']['id'];
            if($this->saveField('password', $pass) && $this->saveField('status', 1) && $this->saveField('valid_until', date("Y-m-d H:i:s")) && $this->saveField('activation_hash', NULL)) {
                return true;
            }
        }

        return false;
    }

    /**
    * set activation details for a given user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function setActivation($user_id = null) {
        if(!$user_id) {
            return false;
        }

        $this->id = $user_id;
        if(!$this->exists()) {
            return false;
        }

        $activation_hash    = md5(date("Y-m-d H:i:s")).$this->id;
        $valid_until        = date("Y-m-d H:i:s", strtotime("+7 days"));

        if($this->saveField('activation_hash', $activation_hash) && $this->saveField('valid_until', $valid_until)) {
            return true;
        }

        return false;
    }

    /**
    * get an instance of a user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $user
    * @return mixed $data
    */
    private static function getInstance($user = null) {
        static $data = array();
        if($user) {
            $data = $user;
        }
        if(!$data) {
            return false;
        }
        return $data;
    }

}
