<?php
/**
 * Target model
 *
 * @package app
 * @subpackage models
 */
class Target extends AppModel {

    public $name = 'Target';

    public $actsAs = array(
        'Containable'
    );

    public $belongsTo = array(
        'Account'
    );
    
    

    /**
    * scrape some restaurants to import for guestify
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getCategories() {
        
        return array(
            1 => __('Restaurants', true),
            2 => __('Hotels', true)
        );

    }


    /**
    * scrape some restaurants to import for guestify
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getNavtabCounts($category_id = null) {

        $counts = array();
        $counts['list'] = $this->find('count', array(
            'conditions' => array(
                'Target.deleted' => 0,
                'Target.prepared' => 0,
                'Target.transfer' => 0,
                'Target.category_id' => $category_id
            )
        ));
        $counts['prepared'] = $this->find('count', array(
            'conditions' => array(
                'Target.deleted' => 0,
                'Target.prepared' => 1,
                'Target.transfer' => 0,
                'Target.category_id' => $category_id
            )
        ));

        return $counts;
    }


    /**
    * transfer a target as host to an existing account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function transfer($data = null) {
        if(!$data) {
            return false;
        }

        # account part
        if(empty($data['Host']['name'])) {
            $this->Account->Host->invalidate('name', __('Please enter the name of the host!', true));
        }

        if(empty($data['Host']['account_id'])) {
            $this->Account->Host->invalidate('account_id', __('Please enter the account id for the transfer!', true));
        } else {
            $this->Account->id = intval($data['Host']['account_id']);
            if(!$this->Account->exists()) {
                $this->Account->Host->invalidate('account_id', __('Invalid Account-ID!', true));
            }
        }

        # add intval (integer) check for user-pin!
        if($this->Account->Host->validates()) {

            $this->Account->Host->create();
            if($this->Account->Host->save($data['Host'])) {
                $this->id = $data['Host']['target_id'];
                $this->saveField('transfer', 1);
                $this->saveField('account_id', $data['Host']['account_id']);
                return true;
            }

            return true;
        }
    }


    /**
    * transform a target into an account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function transform($data = null) {
        if(!$data) {
            return false;
        }

        # account part
        if(empty($data['Account']['company_name'])) {
            $this->Account->invalidate('company_name', __('Please enter the name of the company!', true));
        }
        if(empty($data['Account']['country_id'])) {
            $this->Account->invalidate('company_name', __('Please select the country of the company!', true));
        }


        # user part
        if($data['User']['gender'] == '') {
            $this->Account->User->invalidate('gender', __('Please select the gender of the account-user!', true));
        }
        if(empty($data['User']['firstname'])) {
            $this->Account->User->invalidate('firstname', __('Please enter the firstname of the account-user!', true));
        }
        if(empty($data['User']['lastname'])) {
            $this->Account->User->invalidate('lastname', __('Please enter the lastname of the account-user!', true));
        }

        if(empty($data['User']['e_1'])) {
            $this->Account->User->invalidate('e_1', __('Please enter the email of the account-user!', true));
        }
        if(empty($data['User']['e_2'])) {
            $this->Account->User->invalidate('e_2', __('Please confirm the email of the account-user!', true));
        }

        if(!empty($data['User']['e_1']) && !empty($data['User']['e_2'])) {
            if($data['User']['e_1'] != $data['User']['e_2']) {
                $this->Account->User->invalidate('e_1', __('Email-addresses do not match!', true));
                $this->Account->User->invalidate('e_2', __('Email-addresses do not match!', true));
            } elseif(!filter_var($data['User']['e_1'], FILTER_VALIDATE_EMAIL)) {
                $this->Account->User->invalidate('e_1', __('Please enter a valid email-address!', true));
            } elseif(!filter_var($data['User']['e_2'], FILTER_VALIDATE_EMAIL)) {
                $this->Account->User->invalidate('e_2', __('Please enter a valid email-address!', true));
            } else {
                $data['User']['email'] = $data['User']['e_1'];
            }
        }
        if(empty($data['User']['user_pin'])) {
            $this->Account->User->invalidate('user_pin', __('Please enter a user-pin for the account-user!', true));
        } elseif(strlen($data['User']['user_pin']) < 5) {
            $this->Account->User->invalidate('user_pin', __('Please use at least 5 digits for the user-pin!', true));
        }

        $data['Host'] = $data['Target'];

        # host part
        if(empty($data['Host']['name'])) {
            $this->invalidate('name', __('Please enter a name for the host!', true));
        }


        # add intval (integer) check for user-pin!
        if($this->Account->validates() && $this->Account->User->validates() && $this->Account->Host->validates()) {

            $this->id = $data['Target']['id'];

            # create the account record
            $data['Account']['subdomain'] = '';

            $this->Account->create();
            if(!$this->Account->save($data['Account'])) {
                pr($this->Account->invalidFields());
                exit;
            }

            # create the user record
            $data['User']['account_id']         = $this->Account->id;
            $data['User']['role_id']            = 2;
            $data['User']['status']             = 2;    // awaiting activation
            $data['User']['password']           = md5(date("Y-m-d H:i:s"));
            $data['User']['activation_hash']    = md5(date("Y-m-d H:i:s")).$this->Account->id;
            $data['User']['valid_until']        = date("Y-m-d H:i:s", strtotime("+7 days"));
            $data['Host']['locale']             = 'deu';

            $this->Account->User->create();
            if(!$this->Account->User->save($data['User'])) {
                pr($this->Account->User->invalidFields());
                exit;
            }

            unset($data['Host']['id']);
            $data['Host']['account_id'] = $this->Account->id;
            $data['Host']['locale']     = 'deu';
            $data['Host']['timezone']   = $this->field('timezone');

            $this->Account->Host->create();
            if(!$this->Account->Host->save($data['Host'])) {
                pr($this->Account->Host->invalidFields());
                exit;
            }

            $this->saveField('transfer', 1);
            $this->saveField('account_id', $this->Account->id);


            return true;
        }

        return false;
    }

}
