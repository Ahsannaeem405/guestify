<?php
class DebuggerApiToken extends AppModel {

    public $name = 'DebuggerApiToken';

    public $actsAs = array(
        'Containable'
    );


    // public $expiration_in_seconds = array(
    //     1 => 3600,
    //     2 => 600
    // );


    /**
    * get a list of statuses for an API token
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    // public function getTokenStatuses() {
    //     return array(
    //         0 => __('deactivated', true),
    //         1 => __('ready for usage', true),
    //         2 => __('used', true)
    //     );
    // }


    /**
    * generate a token for API-usage
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $query
    * @return mixed | false
    */
    // public function generateToken($api_key = null, $api_secret = null, $api_account = null,  $type = null, $poll = null) {
    //     if(!$api_key || !$api_secret || !$api_account || !$type) {
    //         return false;
    //     }

    //     $now = strtotime(date('Y-m-d H:i:s'));

    //     # request READ access
    //     if($type == 1) {
    //         $token = Security::hash($now . $api_secret . $api_key . $api_account['Account']['id']);
    //         $expires_in_seconds = $this->expiration_in_seconds[1];
    //         $expires = date('Y-m-d H:i:s', $now + $expires_in_seconds);
    //     }

    //     # request WRITE access
    //     if($type == 2) {
    //         $token = Security::hash($now . $api_secret . $api_key . $api_account['Account']['id']);
    //         $expires_in_seconds = $this->expiration_in_seconds[2];
    //         $expires = date('Y-m-d H:i:s', $now + $expires_in_seconds);
    //     }


    //     $data = array();
    //     $data['api_key']            = $api_key;
    //     $data['account_id']         = $api_account['Account']['id'];
    //     $data['type']               = $type;
    //     $data['token']              = $token;
    //     $data['model']              = 'Poll';
    //     $data['f_key']              = $poll['Poll']['id'];
    //     $data['expires_in_seconds'] = $expires_in_seconds;
    //     $data['expires']            = $expires;
    //     $data['status']             = 1;


    //     $this->create();
    //     if($this->save($data)) {
    //         $token = $this->findById($this->id);
    //         return $token;
    //     }

    //     return false;
    // }


    /**
    * update the status of a given token => 2
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $api_key, string $token_string
    * @return void
    */
    // public function markTokenAsUsed($api_key = null, $token_string = null) {

    //     $token = $this->find('first', array(
    //         'conditions' => array(
    //             'DebuggerApiToken.api_key' => $api_key,
    //             'DebuggerApiToken.token' => $token_string
    //         )
    //     ));

    //     if(empty($token)) {
    //         return false;
    //     }

    //     $this->id = $token['DebuggerApiToken']['id'];

    //     if($this->saveField('status', 2)) {
    //         return true;
    //     }

    //     return false;
    // }


}
