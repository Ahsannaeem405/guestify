<?php
class Account extends AppModel {

    public $name = 'Account';

    public $belongsTo = array(
        'Country'
    );

    public $hasMany = array(
        'Host',
        'Invoice',
        'Poll',
        'Question',
        'Target',
        'Upgrade',
        'User',
        'Widget'
    );

    public $actsAs = array(
        'Containable'
    );

    /**
    * add an account via admin-form
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function addByAdmin($data = null) {
        if(!$data) {
            return false;
        }

        if(empty($data['Account']['company_name'])) {
            $this->invalidate('company_name', __('Please enter the name of the company!', true));
        }
        if(empty($data['Account']['country_id'])) {
            $this->invalidate('company_name', __('Please select the country of the company!', true));
        }

        if($data['User']['gender'] == '') {
            $this->User->invalidate('gender', __('Please select the gender of the account-user!', true));
        }
        if(empty($data['User']['firstname'])) {
            $this->User->invalidate('firstname', __('Please enter the firstname of the account-user!', true));
        }
        if(empty($data['User']['lastname'])) {
            $this->User->invalidate('lastname', __('Please enter the lastname of the account-user!', true));
        }

        if(empty($data['User']['e_1'])) {
            $this->User->invalidate('e_1', __('Please enter the email of the account-user!', true));
        }
        if(empty($data['User']['e_2'])) {
            $this->User->invalidate('e_2', __('Please confirm the email of the account-user!', true));
        }

        if(!empty($data['User']['e_1']) && !empty($data['User']['e_2'])) {
            if($data['User']['e_1'] != $data['User']['e_2']) {
                $this->User->invalidate('e_1', __('Email-addresses do not match!', true));
                $this->User->invalidate('e_2', __('Email-addresses do not match!', true));
            } elseif(!filter_var($data['User']['e_1'], FILTER_VALIDATE_EMAIL)) {
                $this->User->invalidate('e_1', __('Please enter a valid email-address!', true));
            } elseif(!filter_var($data['User']['e_2'], FILTER_VALIDATE_EMAIL)) {
                $this->User->invalidate('e_2', __('Please enter a valid email-address!', true));
            } elseif(!$this->User->checkUniqueUserEmail($data['User']['e_1'])) {
                $this->User->invalidate('e_1', __('This email is already in use!', true));
                $this->User->invalidate('e_2', __('This email is already in use!', true));
            } else {
                $data['User']['email'] = $data['User']['e_1'];
            }
        }

        # validate user-pin
        if(empty($data['User']['user_pin'])) {
            $this->User->invalidate('user_pin', __('Please enter a user-pin for the account-user!', true));
        } elseif(strlen($data['User']['user_pin']) < 4) {
            $this->User->invalidate('user_pin', __('Please use at least 5 digits for the user-pin!', true));
        }
        # add intval (integer) check for user-pin!

        if($this->validates() && $this->User->validates()) {

            # create the account record
            $data['Account']['subdomain'] = '';

            $this->create();
            if(!$this->save($data['Account'])) {
                pr($this->invalidFields());
                exit;
            }

            # create the user record
            $data['User']['account_id']         = $this->id;
            $data['User']['role_id']            = 2;
            $data['User']['status']             = 2;    // awaiting activation
            $data['User']['password']           = md5(date("Y-m-d H:i:s"));
            $data['User']['activation_hash']    = md5(date("Y-m-d H:i:s")).$this->id;
            $data['User']['valid_until']        = date("Y-m-d H:i:s", strtotime("+7 days"));
            $data['User']['locale']             = 'eng';

            $this->User->create();
            if(!$this->User->save($data['User'])) {
                pr($this->User->invalidFields());
                exit;
            }

            return true;
        }

        return false;
    }


    /**
    * edit an account record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function edit($data = null) {
        if(!$data) {
            return false;
        }

        if(empty($data['Account']['company_name'])) {
            $this->invalidate('company_name', __('Please enter the name of your company!', true));
        }

        if($this->validates()) {
            if($this->save($data)) {
                return true;
            }
        }

        return false;
    }

    /**
    * get all hosts belonging to a given account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return mixed $hosts
    */
    public function getAccountHosts($account_id = null) {
        if(!$account_id) {
            return array();
        }

        $this->Host->virtualFields['count_polls'] = 'SELECT COUNT(*) FROM polls AS Poll WHERE Poll.host_id = Host.id';

        $hosts = $this->Host->find('all', array(
            'conditions' => array(
                'Host.deleted' => 0,
                'Host.account_id' => $account_id
            ),
            'order' => 'Host.created DESC'
        ));

        return $hosts;
    }

    /**
    * get all hosts belonging to a given account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return mixed $hosts
    */
    public function getAccountInvoices($account_id = null) {
        if(!$account_id) {
            return array();
        }

        $invoices = $this->Invoice->find('all', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.account_id' => $account_id
            ),
            'order' => 'Invoice.created DESC'
        ));

        return $invoices;
    }

    /**
    * get all account information by a given account_id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return mixed $data
    */
    public function getAccountSetupData($account_id = null) {

        $data = $this->find('first', array(
            'contain' => array(
                'Host' => array(
                    'limit' => 1,
                    'order' => 'Host.created ASC'
                ),
                'Poll' => array(
                    'limit' => 1,
                    'order' => 'Poll.created ASC'
                ),
            ),
            'conditions' => array(
                'Account.deleted' => 0,
                'Account.id' => $account_id
            )
        ));

        if(isset($data['Host'][0]['id'])) {
            $data['Host'] = $data['Host'][0];
            unset($data['Host'][0]);
        }

        return $data;
    }

    /**
    * get all users belonging to a given account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return mixed $users
    */
    public function getAccountUsers($account_id = null) {
        if(!$account_id) {
            return array();
        }

        $users = $this->User->find('all', array(
            'conditions' => array(
                'User.deleted' => 0,
                'User.account_id' => $account_id
            ),
            'order' => 'User.created DESC'
        ));

        return $users;
    }

    /**
    * get the dashboard counts per account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return mixed $counts
    */
    public function getDashboardCounts($poll_id = null, $account_id = null) {

        $groups = $this->Host->Poll->Group->find('all', array(
            'contain' => array(
                'Question' => array(
                    'Answer' => array(
                        'conditions' => array(
                            'Answer.status' => 1
                        )
                    )
                )
            ),
            'conditions' => array(
                'Group.poll_id' => $poll_id
            )
        ));


        $groups = $this->remapData($groups, 'Group', 'id');

        $answer_count       = 0;

        $rating             = 0;

        #$rating_food        = 0;
        #$rating_restaurant  = 0;
        #$rating_staff       = 0;

        $last_7_answer_count       = 0;
        $last_7_rating             = 0;

        #$last_7_rating_food        = 0;
        #$last_7_rating_restaurant  = 0;
        #$last_7_rating_staff       = 0;

        # prepare date range for last 7 days
        $day_last   = date('Y-m-d');
        $day_first  = date('Y-m-d', strtotime($day_last . '- 7 days'));

        $guest_ids = array();     // inject guest_ids here
        $last_7_guest_ids = array();

        $count_by_group = array();

        $ratings_by_group = array();

        $ratings_last_7_by_group = array();

        foreach($groups as $group_id => $group) {

            $count_by_group[$group_id] = count($group['Question']);

            $ratings_by_group[$group_id]        = 0;
            $ratings_last_7_by_group[$group_id] = 0;

            foreach($group['Question'] as $key_question => $question) {

                foreach($question['Answer'] as $answer) {

                    # overall part
                    if(!in_array($answer['guest_id'], $guest_ids)) {
                        array_push($guest_ids, $answer['guest_id']);
                    }

                    $answer_count++;
                    $rating += $answer['rating'];


                    $ratings_by_group[$group_id] += $answer['rating'];

                    # last 7 days part
                    if((date('Y-m-d', strtotime($answer['created'])) >= $day_first) && (date('Y-m-d', strtotime($answer['created'])) <= $day_last)) {

                        if(!in_array($answer['guest_id'], $last_7_guest_ids)) {
                            array_push($last_7_guest_ids, $answer['guest_id']);
                        }

                        $last_7_answer_count++;

                        $last_7_rating += $answer['rating'];

                        $ratings_last_7_by_group[$group_id] += $answer['rating'];
                    }

                }
            }
        }


        # overall
        $all_guest_ids = $guest_ids;

        $scorecard = array();
        $scorecard['guest_count_overall'] = count($guest_ids);

        if($answer_count > 0) {
            $scorecard['average_overall'] = round($rating/$answer_count, 2);
        } else {
            $scorecard['average_overall'] = 0;
        }

        foreach($groups as $group_id => $group_name) {
            if(($count_by_group[$group_id] > 0) && ($scorecard['guest_count_overall'] > 0))  {
                $scorecard['overall']['average_by_group'][$group_id] = round($ratings_by_group[$group_id]/$count_by_group[$group_id]/$scorecard['guest_count_overall'], 2);
            } else {
                $scorecard['overall']['average_by_group'][$group_id] = 0;
            }
        }

        # last 7 days
        $scorecard['last_7_guest_count'] = count($last_7_guest_ids);
        if($last_7_answer_count != 0) {
            $scorecard['last_7_average_overall'] = round($last_7_rating/$last_7_answer_count, 2);
        } else {
            $scorecard['last_7_average_overall'] = 0;
        }

        foreach($groups as $group_id => $group_name) {
            if(($count_by_group[$group_id] > 0) && ($scorecard['last_7_guest_count'] > 0))  {
                $scorecard['last_7']['average_by_group'][$group_id] = round($ratings_last_7_by_group[$group_id]/$count_by_group[$group_id]/$scorecard['last_7_guest_count'], 2);
            } else {
                $scorecard['last_7']['average_by_group'][$group_id] = 0;
            }
        }


        $day_last   = date('Y-m-d');
        $day_first  = date('Y-m-d', strtotime($day_last . '- 7 days'));

        $scorecard['views']['last_7'] = $this->Poll->PollsView->find('count', array(
            'conditions' => array(
                'PollsView.poll_id' => $poll_id,
                'DATE(PollsView.created) >=' => $day_first,
                'DATE(PollsView.created) <=' => $day_last
            )
        ));

        $scorecard['views']['overall'] = $this->Poll->PollsView->find('count', array(
            'conditions' => array(
                'PollsView.poll_id' => $poll_id
            )
        ));

        # last 7 days guest visit time / guest type data
        $today = date('Y-m-d');
        $border  = date('Y-m-d', strtotime($today . '- 7 days'));

        $answers = $this->Host->Poll->Answer->find('all', array(
            'conditions' => array(
                'Answer.poll_id' => $poll_id,
                'DATE(Answer.created) >=' => $border,
                'Answer.status' => 1
            )
        ));

        $guest_ids = Set::ClassicExtract($answers, '{n}.Answer.guest_id');
        if(is_array($guest_ids)) {
            $guest_ids = array_unique($guest_ids);
        }

        $guests = $this->Host->Poll->Answer->Guest->find('all', array(
            'conditions' => array(
                'Guest.id' => $guest_ids,
                'Guest.status' => 1
            )
        ));


        #$scorecard['guests_overall'] = count($guests);

        $scorecard['guests_evening']    = 0;
        $scorecard['guests_midday']     = 0;
        $scorecard['guests_morning']    = 0;

        $scorecard['guests_regular']    = 0;
        $scorecard['guests_occ']        = 0;
        $scorecard['guests_rarely']     = 0;
        $scorecard['guests_first']      = 0;


        foreach($guests as $guest) {

            if($guest['Guest']['visit_time'] == 1) {
                $scorecard['guests_evening']++;
            } elseif($guest['Guest']['visit_time'] == 2) {
                $scorecard['guests_midday']++;
            } elseif($guest['Guest']['visit_time'] == 3) {
                $scorecard['guests_morning']++;
            }

            if($guest['Guest']['guest_type'] == 1) {
                $scorecard['guests_first']++;
            } elseif($guest['Guest']['guest_type'] == 2) {
                $scorecard['guests_rarely']++;
            } elseif($guest['Guest']['guest_type'] == 3) {
                $scorecard['guests_occ']++;
            } elseif($guest['Guest']['guest_type'] == 4) {
                $scorecard['guests_regular']++;
            }

        }


        $scorecard['overall_guests_evening']    = 0;
        $scorecard['overall_guests_midday']     = 0;
        $scorecard['overall_guests_morning']    = 0;

        $scorecard['overall_guests_regular']    = 0;
        $scorecard['overall_guests_occ']        = 0;
        $scorecard['overall_guests_rarely']     = 0;
        $scorecard['overall_guests_first']      = 0;

        $guests = $this->Host->Poll->Answer->Guest->find('all', array(
            'conditions' => array(
                'Guest.id' => $all_guest_ids,
                'Guest.status' => 1
            )
        ));

        foreach($guests as $guest) {

            if($guest['Guest']['visit_time'] == 1) {
                $scorecard['overall_guests_evening']++;
            } elseif($guest['Guest']['visit_time'] == 2) {
                $scorecard['overall_guests_midday']++;
            } elseif($guest['Guest']['visit_time'] == 3) {
                $scorecard['overall_guests_morning']++;
            }

            if($guest['Guest']['guest_type'] == 1) {
                $scorecard['overall_guests_first']++;
            } elseif($guest['Guest']['guest_type'] == 2) {
                $scorecard['overall_guests_rarely']++;
            } elseif($guest['Guest']['guest_type'] == 3) {
                $scorecard['overall_guests_occ']++;
            } elseif($guest['Guest']['guest_type'] == 4) {
                $scorecard['overall_guests_regular']++;
            }
        }

        #pr($scorecard);
        #exit;

        return $scorecard;
    }


    /**
    * get the amount of free slots available for free upgrades
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return int $slots
    */
    public function getFreeUpgradeSlots() {

        $upgrade_count = $this->Upgrade->find('count', array(
            'conditions' => array(
                'Upgrade.deleted' => 0
            )
        ));

        $limit = 100;

        return $limit - $upgrade_count;
    }

}
