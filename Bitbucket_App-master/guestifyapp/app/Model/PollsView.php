<?php
class PollsView extends AppModel {

    public $name = 'PollsView';

    public $useTable = 'polls_views';

    public $belongsTo = array(
        'Poll'
    );

    public $actsAs = array(
        'Containable'
    );


    /**
    * add a polls_views record to the DB
    *
    * @author   digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access   public
    * @param    string $hash
    * @param    mixed $serverdata
    * @return   boolean
    */
    public function addView($poll_id = null, $serverdata = null, $session_id = null, $created = null) {

        if(!$poll_id) {
            return false;
        }

        // $poll_id = $this->Poll->getPollIdByHash($hash);

        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists()) {
            return;
        }


        $record = array();
        $record['poll_id']         = $poll_id;
        $record['user_agent']   = $serverdata['HTTP_USER_AGENT'];
        $record['session_id']   = $session_id;
        $record['ip']           = $serverdata['REMOTE_ADDR'];
        $record['language']     = $serverdata['HTTP_ACCEPT_LANGUAGE'];

        // add created-override when manual feedback is added
        if($created) {
            $record['created']  = $created;
            $record['modified'] = $created;
        }

        $this->create();
        if($this->save($record)) {
            return true;
        }

        return false;
    }

}
