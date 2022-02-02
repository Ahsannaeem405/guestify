<?php
class Api extends AppModel {

    public $name = 'Api';

    public $useTable = false;

    public $actsAs = array(
        'Containable'
    );



    /**
    * gets an account record via API call
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return mixed | false
    */
    public function getAccount($account_id = null) {
        if(!$account_id) {
            return false;
        }

        $Account = ClassRegistry::init('Account');
        $account = $Account->find('first', array(
            'conditions' => array(
                'Account.id' => $account_id
            )
        ));

        return $account;
    }


    /**
    * gets a host record via API call
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $host_id
    * @return mixed | false
    */
    public function getHost($host_id = null) {
        if(!$host_id) {
            return false;
        }

        $Host = ClassRegistry::init('Host');
        $host = $Host->find('first', array(
            'conditions' => array(
                'Host.id' => $host_id
            )
        ));

        return $host;
    }


    /**
    * get a complete poll for show
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $hostname, int $poll_id
    * @return void
    */
    public function getPoll($poll_id = null, $locale = null) {

        $Poll = ClassRegistry::init('Poll');

        $Poll->locale = $locale;

        $Poll->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';

        # would be very good to cache this call...!
        $poll = $Poll->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.id' => $poll_id
            ),
            'fields' => array(
                'Poll.id',
                'Poll.alt_url',
                'Poll.code',
                'Poll.color',
                'Poll.host_id',
                'Poll.name',
                'Poll.ratings_received',
                'Poll.status',
                'Poll.text',
                'Poll.title',
                'Poll.api_accessible',
                #'Host.*',
                'Host.id',
                'Host.name',
                'Host.logo',
                'Host.address',
                'Host.zipcode',
                'Host.city',
                'Host.country_id',
                'Host.lat',
                'Host.lng',
                'Host.web',
                'Host.timezone',
                'Host.deleted',
            )
        ));

        // if($poll['Poll']['status'] == 0) {
        //     return 401;
        // }

        // if(empty($poll)) {
        //     return 404;
        // }

        if(!empty($poll['Host']['logo'])) {
            $poll['Host']['logo'] = Configure::read('CDN.Host') . $poll['Host']['logo'];
        }

        $Poll->Group->locale = $locale;

        $groups = $Poll->Group->find('all', array(
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
            return 403;
        }

        $poll['Groups'] = $groups;

        $Poll->Group->Question->locale = $locale;

        foreach($poll['Groups'] as $key => $group) {

            $questions = $Poll->Group->Question->find('all', array(
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

        # unset unwanted fields here!

        return $poll;
    }


   /**
    * gets a user record via API call
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $user_id
    * @return mixed | false
    */
    public function getUser($user_id = null) {
        if(!$user_id) {
            return false;
        }

        $User = ClassRegistry::init('User');
        $user = $User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            )
        ));

        return $user;
    }

}
