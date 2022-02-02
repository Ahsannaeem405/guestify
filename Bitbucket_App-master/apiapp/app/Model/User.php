<?php
class User extends AppModel {

    public $name = 'User';

    public $belongsTo = array(
        'Account',
        'Role'
    );

    public $actsAs = array(
        'Containable'
    );

    public $allowed_emails = array(
        'dev@digital-cube.de',
        'appadmin@guestify.net'
    );



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
