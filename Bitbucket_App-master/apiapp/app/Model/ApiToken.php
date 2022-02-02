<?php
class ApiToken extends AppModel {

    public $name = 'ApiToken';

    public $belongsTo = array(
        'Account'
    );

    public $expiration_in_seconds = array(
        1 => 3600,
        2 => 600
    );


    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $debug_mode = Configure::read('Debugger');
        if($debug_mode) {
            $this->useTable = 'debugger_api_tokens';
        }
    }


    /**
    * get the navtabs-count for tokens (live/debugger)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getApiToken($id = null, $type = 'live') {
        if(!$id) {
            return false;
        }
        
        if($type == 'debugger') {
            $this->useTable = 'debugger_api_tokens';
        }

        $token = $this->find('first', array(
            'contain' => array(
                'Account'
            ),
            'conditions' => array(
                'ApiToken.id' => $id
            )
        ));

        if($token['ApiToken']['model'] == 'Poll') {
            $Poll = ClassRegistry::init('Poll');
            
            $poll = $Poll->find('first', array(
                'contain' => array(
                    'Host'
                ),
                'conditions' => array(
                    'Poll.id' => $token['ApiToken']['f_key']
                )
            ));
            
            $token['Poll'] = $poll['Poll'];
            $token['Host'] = $poll['Host'];
        }

        return $token;
    }


    /**
    * get the navtabs-count for tokens (live/debugger)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getNavtabCounts() {

        $counts = array();
        $counts['live'] = $this->find('count', array(
            'conditions' => array(
                'ApiToken.deleted' => 0
            )
        ));

        $DebuggerApiToken = ClassRegistry::init('DebuggerApiToken');
        $counts['debugger'] = $DebuggerApiToken->find('count', array(
            'conditions' => array(
                'DebuggerApiToken.deleted' => 0
            )
        ));

        return $counts;
    }


    /**
    * get a list of statuses for an API token
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTokenStatuses() {
        return array(
            0 => __('deactivated', true),
            1 => __('ready for use', true),
            2 => __('used', true)
        );
    }


    /**
    * get a list of statuses for an API token
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTokenStatusClasses() {
        return array(
            0 => 'warning',
            1 => 'info',
            2 => 'success'
        );
    }


    /**
    * get a list of types for an API token
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTokenTypes() {
        return array(
            1 => __('read', true),
            2 => __('write', true)
        );
    }


    /**
    * get a list of token labels for direct use
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTokenTypeLabels() {

        $types = $this->getTokenTypes();

        return array(
            1 => '<span class="label label-default">'.$types[1].'</span>',
            2 => '<span class="label label-warning">'.$types[2].'</span>'
        );
    }


    /**
    * generate a token for API-usage
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $query
    * @return mixed | false
    */
    public function generateToken($api_key = null, $api_secret = null, $api_account = null,  $type = null, $poll = null) {
        if(!$api_key || !$api_secret || !$api_account || !$type) {
            return false;
        }

        $now = strtotime(date('Y-m-d H:i:s'));

        # request READ access
        if($type == 1) {
            $token = Security::hash($now . $api_secret . $api_key . $api_account['Account']['id']);
            $expires_in_seconds = $this->expiration_in_seconds[1];
            $expires = date('Y-m-d H:i:s', $now + $expires_in_seconds);
        }

        # request WRITE access
        if($type == 2) {
            $token = Security::hash($now . $api_secret . $api_key . $api_account['Account']['id']);
            $expires_in_seconds = $this->expiration_in_seconds[2];
            $expires = date('Y-m-d H:i:s', $now + $expires_in_seconds);
        }


        $data = array();
        $data['api_key']            = $api_key;
        $data['account_id']         = $api_account['Account']['id'];
        $data['type']               = $type;
        $data['token']              = $token;
        $data['model']              = 'Poll';
        $data['f_key']              = $poll['Poll']['id'];
        $data['expires_in_seconds'] = $expires_in_seconds;
        $data['expires']            = $expires;
        $data['status']             = 1;


        $this->create();
        if($this->save($data)) {
            $token = $this->findById($this->id);
            return $token;
        }

        return false;
    }


    /**
    * update the status of a given token => 2
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $api_key, string $token_string
    * @return void
    */
    public function markTokenAsUsed($api_key = null, $token_string = null) {

        $token = $this->find('first', array(
            'conditions' => array(
                'ApiToken.api_key' => $api_key,
                'ApiToken.token' => $token_string
            )
        ));

        if(empty($token)) {
            return false;
        }

        $this->id = $token['ApiToken']['id'];

        if($this->saveField('status', 2)) {
            return true;
        }

        return false;
    }


}
