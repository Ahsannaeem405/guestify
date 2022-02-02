<?php
class Poll extends AppModel {

    public $name = 'Poll';

    public $belongsTo = array(
        'Account',
        'Host'
    );

    public $hasMany = array(
        'Answer',
        'Guest',
        'Group',
        'PollsView'
    );

    public $actsAs = array(
        'Containable',
        'Translate' => array(
            'name' => 'translatedName'
        )
    );


    /**
    * check if a given code and hash match
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $code, string $hash
    * @return boolean
    */
    public function checkCodeForHash($code = null, $hash = null) {
        if(!$code || !$hash) {
            return false;
        }

        $poll = $this->find('first', array(
            'conditions' => array(
                'Poll.deleted' => 0,
                'Poll.code' => $code,
                'Poll.hash' => $hash,
            )
        ));

        if(!empty($poll) && isset($poll['Poll']['id'])) {
            return true;
        }

        return false;
    }


    /**
    * get a set of answers depending on a given poll and guest
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, int $guest_id
    * @return mixed
    */
    public function getAnswers($poll_id = null, $guest_id = null) {
        if(!$poll_id || !$guest_id) {
            return array();
        }

        $answers = $this->Answer->find('all', array(
            'conditions' => array(
                'Answer.deleted' => 0,
                'Answer.poll_id' => $poll_id,
                'Answer.guest_id' => $guest_id
            ),
            'order' => 'Answer.question_id ASC'
        ));

        return $answers;
    }


    /**
    * get the id of a poll via a given hash
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $hash
    * @return mixed $poll
    */
    public function getPollByHash($hash = null) {
        if(!$hash) {
            return false;
        }

        $poll = $this->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.hash' => $hash
            )
        ));

        return $poll;
    }


    /**
    * get the id of a poll via a given hash
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $hash
    * @return int $poll_id
    */
    public function getPollIdByHash($hash = null) {
        if(!$hash) {
            return false;
        }

        $poll = $this->find('first', array(
            'conditions' => array(
                'Poll.hash' => $hash
            )
        ));

        if(!empty($poll) && isset($poll['Poll']['id'])) {
            return $poll['Poll']['id'];
        }

        return false;
    }


    /**
    * get a complete poll for show
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $hostname, int $poll_id
    * @return void
    */
    public function getPollForShow($poll_id = null, $locale_overwrite = null) {


        $this->locale = $locale_overwrite;

        $this->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';
        $poll = $this->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.id' => $poll_id,
                'Poll.deleted' => 0,
                'Poll.status' => 1
            )
        ));

        if(empty($poll)) {
            return false;
        }

        $this->Host->id = $poll['Poll']['host_id'];

        if(empty($locale_overwrite)) {
            $locale = $this->Host->field('locale');
        } else {
            $locale = $locale_overwrite;
        }

        if(empty($locale)) {
            $locale = Configure::read('Language.default');
        }

        $this->Group->locale = $locale;

        $groups = $this->Group->find('all', array(
            'conditions' => array(
                'Group.deleted' => 0,
                'Group.status' => 1,
                'Group.poll_id' => $poll_id
            ),
            'order' => array(
                'Group.order' => 'ASC'
            )
        ));

        if(empty($groups)) {
            return false;
        }

        $poll['Groups'] = $groups;

        $this->Group->Question->locale = $locale;

        foreach($poll['Groups'] as $key => $group) {

            $questions = $this->Group->Question->find('all', array(
                'conditions' => array(
                    'Question.deleted' => 0,
                    'Question.status' => 1,
                    'Question.poll_id' => $poll_id,
                    'Question.group_id' => $group['Group']['id']
                ),
                'order' => array(
                    'Question.order' => 'ASC'
                )
            ));

            $poll['Groups'][$key]['Questions'] = $questions;

        }

        return $poll;
    }


    /**
    * get an array of options for visit amounts
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getGuestTypes() {
        return array(
            1 => __('This is my first visit', true),
            2 => __('I am rarely here', true),
            3 => __('I am occasionally here', true),
            4 => __('I am a regular guest', true)
        );
    }


    /**
    * get an array of options for visit times
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getVisitTimes() {
        return array(
            1 => __('Evening', true),
            2 => __('Midday', true),
            3 => __('Morning', true)
        );
    }


    /**
    * get a complete poll for view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $locale
    * @return mixed $poll or false
    */
    public function getPoll($poll_id = null, $locale = null) {

        $this->virtualFields['count_views'] = 'SELECT COUNT(*) FROM polls_views AS PollsView WHERE PollsView.poll_id = Poll.id';

        $poll = $this->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.id' => $poll_id,
                'Poll.deleted' => 0,
                #'Poll.status' => 1
            )
        ));

        if(empty($poll)) {
            return false;
        }

        $this->Host->id = $poll['Poll']['host_id'];

        $this->Group->locale = $this->locale;
        $groups = $this->Group->find('all', array(
            'conditions' => array(
                'Group.deleted' => 0,
                'Group.status' => 1,
                'Group.poll_id' => $poll_id
            ),
            'order' => 'Group.order ASC'
        ));

        if(empty($groups)) {
            return false;
        }

        $poll['Groups'] = $groups;

        $this->Group->Question->locale = $this->locale;

        foreach($poll['Groups'] as $key => $group) {

            $questions = $this->Group->Question->find('all', array(
                'conditions' => array(
                    'Question.deleted' => 0,
                    'Question.status' => 1,
                    'Question.poll_id' => $poll_id,
                    'Question.group_id' => $group['Group']['id']
                ),
                'order' => 'Question.order ASC'
            ));

            $poll['Groups'][$key]['Questions'] = $questions;

        }

        return $poll;
    }


    /**
    * get the max scale of a given poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return int $max_scale
    */
    public function getPollsMaxScale($poll_id = null) {
        $max_scale = 0;
        $poll = $this->getPoll($poll_id);
        foreach($poll['Groups'] as $key => $group) {
            foreach($group['Questions'] as $question) {
                if($question['Question']['scale'] > $max_scale) {
                    $max_scale = $question['Question']['scale'];
                }
            }
        }

        return $max_scale;
    }


    /**
    * save an answer-pack
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function saveAnswers($data = null) {
        if(!$data) {
            return false;
        }

        $guest = array();
        $guest['Guest']['guest_type']   = $data['Guest']['guest_type'];
        $guest['Guest']['visit_time']   = $data['Guest']['visit_time'];
        $guest['Guest']['name']         = $data['Guest']['name'];
        $guest['Guest']['email']        = $data['Guest']['email'];
        $guest['Guest']['poll_id']      = $data['Guest']['poll_id'];
        $guest['Guest']['pin']          = $data['Guest']['pin'];
        $guest['Guest']['user_agent']   = $_SERVER['HTTP_USER_AGENT'];
        if(isset($_SERVER['HTTP_X_REAL_IP'])) {
            $guest['Guest']['ip']           = $_SERVER['HTTP_X_REAL_IP'];
        } else {
            $guest['Guest']['ip']           = $_SERVER['REMOTE_ADDR'];
        }
        
        $guest['Guest']['referrer']     = $_SERVER['HTTP_REFERER'];
        $guest['Guest']['language']     = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $guest['Guest']['comment_customer']      = $data['Guest']['comment_customer'];

        $this->Guest->create();
        if(!$this->Guest->save($guest)) {
            return false;
        }

        foreach($data['Poll']['answer'] as $id => $rating) {

            $answer = array();
            $answer['Answer']['poll_id']        = $data['Guest']['poll_id'];
            $answer['Answer']['guest_id']       = $this->Guest->id;
            $answer['Answer']['question_id']    = $id;
            $answer['Answer']['rating']         = $rating;
            
            if(isset($_SERVER['HTTP_X_REAL_IP'])) {
                $answer['Answer']['ip']             = $_SERVER['HTTP_X_REAL_IP'];
            } else {
                $answer['Answer']['ip']             = $_SERVER['REMOTE_ADDR'];
            }

            $this->Answer->create();
            $this->Answer->save($answer);
        }

        return true;
    }


    /**
    * validate a poll-record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function validatePoll($data = null) {

        if(!$data) {
            return false;
        }


        if($data['Guest']['guest_type'] == '') {
            $this->Guest->invalidate('guest_type', __('Please select!', true));
        }
        if($data['Guest']['visit_time'] == '') {
            $this->Guest->invalidate('visit_time', __('Please select!', true));
        }

        if(!empty($data['Guest']['email']) && !filter_var($data['Guest']['email'], FILTER_VALIDATE_EMAIL)) {
            $this->Guest->invalidate('email', __('Please enter a valid email-address!', true));
        }

        if($this->Guest->validates()) {
            return true;
        }

        return false;

    }


    /**
    * check if all questions were answered
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, mixed $data
    * @return boolean true or array $errors
    */
    public function checkMissingAnswers($poll_id = null, $data = null) {

        $poll_id = $data['Guest']['poll_id'];
        $poll = $this->getPollForShow($poll_id);

        $missing_question_ids = array();

        foreach($data['Poll']['answer'] as $question_id => $answer) {
            if(empty($answer)) {
                array_push($missing_question_ids, $question_id);
            }
        }

        if(empty($data['Guest']['guest_type'])) {
            $this->Guest->invalidate('guest_type', __('Please select an option!', true));
        }
        if(empty($data['Guest']['visit_time'])) {
            $this->Guest->invalidate('visit_time', __('Please select an option!', true));
        }

        if(!empty($data['Guest']['email']) && !filter_var($data['Guest']['email'], FILTER_VALIDATE_EMAIL)) {
            $this->Guest->invalidate('email', __('Please enter a valid email-address!', true));
        }

        if(!empty($missing_question_ids)) {
            return $missing_question_ids;
        } else {
            return false;
        }
    }


}
