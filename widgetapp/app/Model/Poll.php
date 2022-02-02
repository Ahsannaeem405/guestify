<?php

#App::uses('CakeTime', 'Utility');

class Poll extends AppModel {

    public $name = 'Poll';

    public $displayField = 'name';

    public $belongsTo = array(
        'Account',
        'Answer',
        'Host'
    );

    public $hasMany = array(
        'Guest',
        'Group',
        'Invoice',
        'PaymentPP',
        'PollsView',
        'Question',
        'Upgrade',
        'Widget'
    );

    public $actsAs = array(
        'Containable',
        'Translate' => array(
            'name' => 'translatedName'
        )
    );



    /**
    * get a complete poll for view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $locale
    * @return mixed $poll or false
    */
    public function getPoll($poll_id = null, $locale = 'eng') {

        $this->virtualFields['count_views'] = 'SELECT COUNT(*) FROM polls_views AS PollsView WHERE PollsView.poll_id = Poll.id';
        $this->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';

        $this->locale = $locale;

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

}
