<?php
class Host extends AppModel {

    public $name = 'Host';

    public $belongsTo = array(
        'Account',
        'Country'
    );

    public $hasMany = array(
        'Poll'
    );


    /**
    * add a host record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean 
    */
    public function add($data = null) {
        if(!$data) {
            return false;
        }

        if(empty($data['Host']['name'])) {
            $this->invalidate('name', __('Please enter a name for the host!', true));
        }
        if(empty($data['Host']['locale'])) {
            $this->invalidate('locale', __('Please select a standard locale for polls!', true));
        }
        if(empty($data['Host']['account_id'])) {
            $this->invalidate('account_id', __('You account id is NOT set!', true));
        }

        if($this->validates()) {
            $this->create();
            if($this->save($data)) {
                return true;
            }
        }

        return false;
    }

    /**
    * edit a host record
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

        if(empty($data['Host']['name'])) {
            $this->invalidate('name', __('Please enter a name for the host!', true));
        }

        if($this->validates()) {

            # try geocoding
            $geocodes = $this->geocodeAddress(array(
                'address'   => $data['Host']['address'],
                'zipcode'   => $data['Host']['zipcode'],
                'city'      => $data['Host']['city'],
                'country_id'=> $data['Host']['country_id'],

            ));

            if($geocodes != false) {
                $data['Host']['lat'] = $geocodes['lat'];
                $data['Host']['lng'] = $geocodes['lng'];
            }

            if($this->save($data)) {
                
                if(isset($data['PollsSocial']) && !empty($data['PollsSocial'])) {
                    foreach($data['PollsSocial'] as $type_id => $link) {

                        $check = $this->HostsSocial->find('first', array(
                            'conditions' => array(
                                'HostsSocial.deleted' => 0,
                                'HostsSocial.host_id' => $this->id,
                                'HostsSocial.type_id' => $type_id
                            )
                        ));

                        if(!empty($check)) {
                            $this->HostsSocial->id = $check['HostsSocial']['id'];
                            $this->HostsSocial->saveField('link', $link);
                        } else {
                            $entry = array();
                            $entry['host_id']   = $this->id;
                            $entry['type_id']   = $type_id;
                            $entry['link']      = $link;
                            $this->HostsSocial->create();
                            $this->HostsSocial->save($entry);
                        }
                    }
                }
                return true;
            }
        }

        return false;
    }

    /**
    * get a host record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $host_id
    * @return mixed $host
    */
    public function getHost($host_id = null) {
        if(!$host_id) {
            return false;
        }

        $host = $this->find('first', array(
            'contain' => array(
                'Account'
            ),
            'conditions' => array(
                'Host.id' => $host_id,
                'Host.deleted' => 0
            )
        ));

        return $host;
    }

    /**
    * get all host ids from given account od
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return array $host_ids
    */
    public function getHostIdsByAccountId($account_id = null) {

        $hosts = $this->find('all', array(
            'conditions' => array(
                'Host.account_id' => $account_id
            )
        ));

        $host_ids = Set::ClassicExtract($hosts, '{n}.Host.id');

        return $host_ids;
    }

    /**
    * get a list of hosts for a given account id
    * (used mainly by dropdowns)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return array $hosts
    */
    public function getHostListByAccountId($account_id = null) {

        $hosts = $this->find('list', array(
            'conditions' => array(
                'Host.deleted' => 0,
                'Host.account_id' => $account_id
            ),
            'order' => 'Host.name ASC'
        ));

        return $hosts;
    }

    /**
    * get all polls belonging to a given host
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return mixed $hosts
    */
    public function getHostPolls($host_id = null) {
        if(!$host_id) {
            return array();
        }

        $this->Poll->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';
        $this->Poll->virtualFields['count_views'] = 'SELECT COUNT(*) FROM polls_views AS PollsView WHERE PollsView.poll_id = Poll.id';

        $polls = $this->Poll->find('all', array(
            'conditions' => array(
                'Poll.deleted' => 0,
                'Poll.host_id' => $host_id
            ),
            'order' => 'Poll.created ASC'
        ));

        return $polls;
    }

    /**
    * get a poll id by hostname and code
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $hostname, int $code
    * @return int $poll['Poll']['id'] or false
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
