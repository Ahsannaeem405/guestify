<?php
class Tracker extends AppModel {

    public $name = 'Tracker';

    public $hasMany = array(
        'TrackersLink'
    );

    public $actsAs = array(
        'Containable'
    );



    /**
    * create a tracker link entry based on a given tracker
    * and its sub-information (url, tracker string)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $tracker
    * @return boolean
    */
    public function saveTrackerGeneralInformation($data = null) {
        
        if(!isset($data['tracker_id']) || empty($data['tracker_id'])) {
            return false;
        }

        $this->id = $data['tracker_id'];

        if($data['type'] == '') {
            $this->invalidate('type', __('Please select a type!', true));
        }
        if(empty($data['recipient_email'])) {
            $this->invalidate('recipient_email', __('Please enter the email-address of the recipient!', true));
        }
        if(empty($data['email_id'])) {
            $this->invalidate('email_id', __('Please enter the email-id for the link-tracker!', true));
        }
        if(empty($data['sender_email'])) {
            $this->invalidate('sender_email', __('Please enter the email-address of the sender!', true));
        }

        if($this->validates()) {
            if($this->save($data)) {
                return true;
            }
        }

        return false;
    }


    /**
    * set the recipient (model/fkey) for a given tracker
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id, int $recipient_id
    * @return boolean
    */
    public function setRecipient($tracker_id = null, $recipient_id = null) {
        if(!$tracker_id || !$recipient_id) {
            return false;
        }

        $this->id = $tracker_id;
        if($this->saveField('recipient_model', 'User') && $this->saveField('recipient_f_key', $recipient_id)) {
            return true;
        }

        return false;
    }


    /**
    * load search results by a given search term
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return json object | boolean
    */
    public function loadSearchResults($search_term = null) {
        
        if(!$search_term) {
            $search_term = ' m 80c0m h2298ncu';
        }

        $conditions = array();
        $conditions['User.deleted']     = 0;
        $conditions['User.role_id >']   = 1;
        
        # check if search term is an integer -> search by id
        if(!empty(intval($search_term))) {
            $conditions['User.id'] = intval($search_term);
        } else {
            # if not, try like searches for other attributes
            $conditions['OR'] = array(
                array(
                    'User.lastname LIKE' => '%'.$search_term.'%'
                ),
                array(
                    'User.email LIKE' => '%'.$search_term.'%'
                ),
                array(
                    'Account.company_name LIKE' => '%'.$search_term.'%'
                ),
            );
        }

        $search_results = array();

        $User = ClassRegistry::init('User');
        $search_results['users'] = $User->find('all', array(
            'contain' => array(
                'Account' => array(
                    'fields' => array(
                        'Account.company_name'
                    )
                )
            ),
            'conditions' => $conditions,
            'order' => array(
                'User.id' => 'ASC'
            ),
            'fields' => array(
                'User.id',
                'User.gender',
                'User.firstname',
                'User.lastname',
                'User.email',
            ),
            'limit' => 11
        ));


        # inject gender label
        $genders = $User->getGenders();
        foreach($search_results['users'] as $key => $user) {
            if(isset($genders[$user['User']['gender']])) {
                $user['User']['gender_label'] = $genders[$user['User']['gender']];
                $search_results['users'][$key] = $user;
            }
        }

        $search_results['count'] = $User->find('count', array(
            'contain' => array(
                'Account' => array(
                    'fields' => array(
                        'Account.company_name'
                    )
                )
            ),
            'conditions' => $conditions,
            'order' => array(
                'User.id' => 'ASC'
            )
        ));

        return $search_results;
    }


    /**
    * create a tracker link entry based on a given tracker
    * and its sub-information (url, tracker string)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $tracker
    * @return boolean
    */
    public function saveTrackerOpeningInformation($data = null) {
        
        if(!isset($data['tracker_id']) || empty($data['tracker_id'])) {
            return false;
        }

        $this->id = $data['tracker_id'];

        if($data['status'] == '') {
            $this->invalidate('status', __('Please select a status!', true));
        }
        if(empty($data['created'])) {
            $this->invalidate('created', __('Please enter the creation date of the tracker!', true));
        }

        if($this->validates()) {
            if($this->save($data)) {
                return true;
            }
        }

        return false;
    }


    /**
    * create all link-entries for the link-tracker of an email
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id, array $links
    * @return boolean
    */
    // public function createLinkTrackers($tracker_id, $links) {

    //  $tracker = $this->findById($tracker_id);

    //  foreach($links as $link) {
    //      $entry = array();
    //      $entry['tracker_id']    = $tracker['Tracker']['id'];
    //      $entry['campaign_id']   = $tracker['Tracker']['campaign_id'];
    //      $entry['email_id']      = $tracker['Tracker']['email_id'];
    //      $entry['link']          = h($link);

    //      $this->TrackersLink->create();
    //      $this->TrackersLink->save($entry);
    //  }
    // }


   /**
    * get the scorecard for a given type of tracker
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type (Note: will be used when more than one tracker-type is available)
    * @return array
    */
    public function getScorecardByType($type = null) {

        $scorecard = array();


        $trackers = $this->find('all', array(
            'conditions' => array(
                'Tracker.deleted' => 0,
                'Tracker.type' => $type
            ),
            'fields' => array(
                'Tracker.id',
                'Tracker.type'
            )
        ));

        $tracker_ids = Set::ClassicExtract($trackers, '{n}.Tracker.id');


        $scorecard['count_overall'] = $this->find('count', array(
            'conditions' => array(
                'Tracker.id' => $tracker_ids,
                'Tracker.deleted' => 0,
                'Tracker.type' => $type
            )
        ));

        $scorecard['count_openend'] = $this->find('count', array(
            'conditions' => array(
                'Tracker.id' => $tracker_ids,
                'Tracker.deleted' => 0,
                'Tracker.type' => $type,
                'Tracker.open_count >' => 0
            )
        ));

        $scorecard['rate_opened'] = round(($scorecard['count_openend']/$scorecard['count_overall'])*100, 1);


        # activation link
        $scorecard['count_links_activation'] = $this->TrackersLink->find('count', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $tracker_ids,
                'TrackersLink.url LIKE' => '%/activate/%',
            )
        ));

        $scorecard['count_links_activation_clicked'] = $this->TrackersLink->find('count', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $tracker_ids,
                'TrackersLink.url LIKE' => '%/activate/%',
                'TrackersLink.visit_count >' => 0
            )
        ));

        $scorecard['rate_link_activation_clicked'] = round(($scorecard['count_links_activation_clicked']/$scorecard['count_links_activation'])*100, 1);

        # facebook link
        $scorecard['count_links_facebook'] = $this->TrackersLink->find('count', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $tracker_ids,
                'TrackersLink.url LIKE' => '%www.facebook.com%',
            )
        ));

        $scorecard['count_links_facebook_clicked'] = $this->TrackersLink->find('count', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $tracker_ids,
                'TrackersLink.url LIKE' => '%www.facebook.com%',
                'TrackersLink.visit_count >' => 0
            )
        ));

        $scorecard['rate_link_facebook_clicked'] = round(($scorecard['count_links_facebook_clicked']/$scorecard['count_links_facebook'])*100, 1);

        # twitter link
        $scorecard['count_links_twitter'] = $this->TrackersLink->find('count', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $tracker_ids,
                'TrackersLink.url LIKE' => '%twitter.com%',
            )
        ));

        $scorecard['count_links_twitter_clicked'] = $this->TrackersLink->find('count', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $tracker_ids,
                'TrackersLink.url LIKE' => '%twitter.com%',
                'TrackersLink.visit_count >' => 0
            )
        ));

        $scorecard['rate_link_twitter_clicked'] = round(($scorecard['count_links_twitter_clicked']/$scorecard['count_links_twitter'])*100, 1);


        # explore (more info)
        $scorecard['count_links_explore'] = $this->TrackersLink->find('count', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $tracker_ids,
                'TrackersLink.url LIKE' => '%#explore%',
            )
        ));

        $scorecard['count_links_explore_clicked'] = $this->TrackersLink->find('count', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $tracker_ids,
                'TrackersLink.url LIKE' => '%#explore%',
                'TrackersLink.visit_count >' => 0
            )
        ));

        $scorecard['rate_link_explore_clicked'] = round(($scorecard['count_links_explore_clicked']/$scorecard['count_links_explore'])*100, 1);

        return $scorecard;
    }


   /**
    * create a tracker for a given type
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param array $options
    * @return array
    */
    public function createTrackerSingle($options) {

        $tracker = array();

        $tracker['type']    = $options['type'];

        if(isset($options['sender_email'])) {
            $tracker['sender_email']    = $options['sender_email'];
        }

        # recipient definition
        if(isset($options['recipient_email'])) {
            $tracker['recipient_email'] = $options['recipient_email'];
        }
        if(isset($options['recipient_model'])) {
            $tracker['recipient_model'] = $options['recipient_model'];
        }
        if(isset($options['recipient_f_key'])) {
            $tracker['recipient_f_key'] = $options['recipient_f_key'];
        }

        $tracker['email_id'] = md5(date('Y-m-d H:i:s') . $tracker['type'] . $tracker['recipient_email'] . Configure::read('Security.salt'));

        # set the initial status of the tracker to 0 => unopened
        $tracker['status'] = 0;

        $this->create();
        if($this->save($tracker)) {
            $tracker = $this->findById($this->id);
            return $tracker;
        }

        return null;
    }


    /**
    * create a tracker link entry based on a given tracker
    * and its sub-information (url, tracker string)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $tracker
    * @return boolean
    */
    public function createTrackingLink($tracker = null) {
        if(!$tracker) {
            return false;
        }

        $link = array();
        $link['tracker_id']     = $tracker['Tracker']['id'];
        $link['email_id']       = $tracker['Tracker']['email_id'];
        $link['link_id']        = $tracker['Tracker']['link_id'];

        $link['url']            = $tracker['Tracker']['url'];
        $link['tracker_string'] = $tracker['Tracker']['tracker_string'];

        $this->TrackersLink->create();
        $this->TrackersLink->save($link);

        return true;
    }


    /**
    * get the countings for the tabs in trackers index
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getNavtabCounts() {

        $counts = array();

        $system_types = $this->getSystemTypes();

        $counts['system'] = $this->find('count', array(
            'conditions' => array(
                'Tracker.deleted' => 0,
                'Tracker.type' => $system_types
            )
        ));

        $counts['weekly_report'] = $this->find('count', array(
            'conditions' => array(
                'Tracker.deleted' => 0,
                'Tracker.type' => 'weekly_report'
            )
        ));

        $counts['newsletter'] = $this->find('count', array(
            'conditions' => array(
                'Tracker.deleted' => 0,
                'Tracker.type' => 'newsletter'
            )
        ));

        return $counts;
    }


   /**
    * get an email log for a given tracker
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id
    * @return mixed
    */
    public function getEmailLog($tracker_id = null) {
        if(!$tracker_id) {
            return array();
        }

        $this->id = $tracker_id;

        if(empty($this->field('mail_message_id'))) {
            return array();
        }

        $mail_message_id = $this->field('mail_message_id');
        
        $LogsEmail = ClassRegistry::init('LogsEmail');
        $log = $LogsEmail->find('first', array(
            'conditions' => array(
                'LogsEmail.mail_message_id' => $mail_message_id
            )
        ));

        return $log;
    }


   /**
    * get a recipient by a given tracker
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id
    * @return mixed
    */
    public function getRecipientByTracker($tracker_id = null) {
        if(!$tracker_id) {
            return array();
        }


        $this->id = $tracker_id;
        $model = $this->field('recipient_model');

        if($model == 'User') {
            $User = ClassRegistry::init('User');
            $user = $User->find('first', array(
                'contain' => array(
                    'Account'
                ),
                'conditions' => array(
                    'User.id' => $this->field('recipient_f_key')
                )
            ));

            $genders = $User->getGenders();
            if(isset($genders[$user['User']['gender']])) {
                $user['User']['gender_label'] = $genders[$user['User']['gender']];
            } else {
                $user['User']['gender_label'] = '';
            }

            return $user;
        }

        return false;
    }


   /**
    * get an array of statuses
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getStatuses() {

        return array(
            0 => __('unopened', true),
            1 => __('opened', true),
            2 => __('bounced', true)
        );

    }


   /**
    * get an array of status labels
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getStatusesLabels() {

        return array(
            0 => 'warning',
            1 => 'success',
            2 => 'danger'
        );

    }


   /**
    * get an array of system-types
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getSystemTypes() {

        # system types
        $types_system = $this->find('all', array(
            'conditions' => array(
                'Tracker.deleted' => 0
            ),
            'fields' => array(
                'DISTINCT(Tracker.type)'
            )
        ));

        $types_system = Set::ClassicExtract($types_system, '{n}.Tracker.type');
        if(is_array($types_system)) {
            $types_system = array_unique($types_system);
        }

        $types = array();
        foreach($types_system as $key => $type) {
            $types[$type] = $type;
        }

        return $types;
    }


   /**
    * get a tracker with all details
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id
    * @return mixed
    */
    public function getTrackerDetails($tracker_id) {

        $tracker = $this->find('first', array(
            'conditions' => array(
                'Tracker.id' => $tracker_id
            )
        ));

        return $tracker;
    }


   /**
    * get all links for a given tracker
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id
    * @return mixed
    */
    public function getTrackerLinks($tracker_id = null) {
        if(!$tracker_id) {
            return array();
        }

        $links = $this->TrackersLink->find('all', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $tracker_id
            ),
            'order' => 'TrackersLink.id ASC'
        ));

        return $links;
    }


   /**
    * get an array of types
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTypes() {

        # system types
        $types_system = $this->find('all', array(
            'conditions' => array(
                'Tracker.deleted' => 0
            ),
            'fields' => array(
                'DISTINCT(Tracker.type)'
            )
        ));

        $types_system = Set::ClassicExtract($types_system, '{n}.Tracker.type');
        if(is_array($types_system)) {
            $types_system = array_unique($types_system);
        }

        $options = array(
            __('System', true) => $types_system
        );

        return $options;
    }


   /**
    * update a link tracker
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param array $options
    * @return boolean
    */
    public function updateLinkTracker($query = null) {


        $link_tracker = $this->TrackersLink->find('first', array(
            'conditions' => array(
                'TrackersLink.deleted' => 0,
                'TrackersLink.tracker_id' => $query['t_id'],
                'TrackersLink.email_id' => $query['e_id'],
                'TrackersLink.link_id' => $query['l_id']
            )
        ));


        if(empty($link_tracker)) {
            return false;
        }

        $this->TrackersLink->id = $link_tracker['TrackersLink']['id'];

        $record = array();
        $record['id'] = $link_tracker['TrackersLink']['id'];
        $record['status'] = 1;  // set to "clicked"

        if($link_tracker['TrackersLink']['visit_count'] == 0) {
            $record['visit_count']  = 1;
            $record['first_visit']  = date('Y-m-d H:i:s');
            $record['last_visit']   = $record['first_visit'];
            $record['user_agent']   = $query['user_agent'];
            $record['ip']           = $query['ip'];
            $record['lang']         = $query['lang'];
        } else {
            $record['visit_count']   = $link_tracker['TrackersLink']['visit_count'] + 1;
            $record['last_visit']    = date('Y-m-d H:i:s');
        }

        if($this->TrackersLink->save($record)) {
            return true;
        }

        return false;
    }


   /**
    * update tracker status to opened and set
    * some other flags 
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id, int $email_id
    * @return boolean
    */
    public function trackerOpened($tracker_id, $email_id) {

        $tracker = $this->find('first', array(
            'conditions' => array(
                'Tracker.deleted' => 0,
                'Tracker.id' => $tracker_id,
                'Tracker.email_id' => $email_id
            )
        ));

        # tracker not found => return
        if(empty($tracker)) {
            return;
        }

        $this->id = $tracker['Tracker']['id'];

        $now = date('Y-m-d H:i:s');

        if($tracker['Tracker']['status'] == 0) {
            $this->saveField('status', 1);  // set to opened
            $this->saveField('first_opened', $now); // save timestamp

            if(Configure::read('Environment') == 'LOCAL') {
                $ip = $_SERVER['REMOTE_ADDR'];
            } else {
                $ip = $_SERVER['HTTP_X_REAL_IP'];
            }
            $this->saveField('ip', $ip);

            $this->saveField('user_agent', $_SERVER['HTTP_USER_AGENT']);
        }

        $this->saveField('last_opened', $now); // save timestamp

        $tracker['Tracker']['open_count']++;
        $this->saveField('open_count', $tracker['Tracker']['open_count']);

        return true;
    }


}
