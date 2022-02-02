<?php
class Host extends AppModel {

    public $name = 'Host';

    public $belongsTo = array(
        'Account'
    );
    
    public $hasMany = array(
        'HostsSocial',
        'Poll'
    );

    public $actsAs = array(
        'Containable'
    );


    /**
    * show a poll to a guest
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param $sting $hostname, int $code
    * @return void
    */
    public function getPollId($hostname = null, $code = null) {
        if(!$hostname || !$code) {
            return false;
        }
        
        $host = $this->find('first', array(
            'conditions' => array(
                'Host.name' => $hostname
            )
        ));
        
        $poll = $this->Poll->find('first', array(
            'conditions' => array(
                'Poll.deleted' => 0,
                'Poll.status' => 1,
                'Poll.host_id' => $host['Host']['id'],
                'Poll.code' => $code
            )
        ));
        
        if(isset($poll['Poll']['id'])) {
            return $poll['Poll']['id'];
        }
        
        return false;
    }


    /**
    * get a list of all social values for a given poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return boolean | array
    */
    public function getSocialsValues($host_id = null) {
        if(!$host_id) {
            return false;
        }

        $entries = $this->HostsSocial->find('all', array(
            'conditions' => array(
                'HostsSocial.deleted' => 0,
                'HostsSocial.host_id' => $host_id
            )
        ));

        $entries = $this->remapData($entries, 'HostsSocial', 'type_id');

        $socials = $this->HostsSocial->getTypes();

        $result = array();
        foreach($socials as $type_id => $name) {
            $result[$type_id] = '';
            if(isset($entries[$type_id])) {
                $result[$type_id] = $entries[$type_id]['HostsSocial']['link'];
            }
        }

        return $result;
    }



}
