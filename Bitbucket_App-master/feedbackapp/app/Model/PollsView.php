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
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $hash, mixed $serverdata
    * @return void
    */
    public function addView($hash = null, $serverdata = null, $session_id) {

        $poll_id = $this->Poll->getPollIdByHash($hash);
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

        $this->create();
        $this->save($record);
        return;
    }

}