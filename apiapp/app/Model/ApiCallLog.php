<?php
class ApiCallLog extends AppModel {

    public $name = 'ApiCallLog';

    public $actsAs = array(
        'Containable'
    );


    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $debug_mode = Configure::read('Debugger');
        if($debug_mode) {
            $this->useTable = 'debugger_api_call_logs';
        }
    }


    /**
    * get a complete api log call record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getApiCallLog($id = null, $type = 'live') {
        if(!$id) {
            return false;
        }

        if($type == 'debugger') {
            $this->useTable = 'debugger_api_call_logs';
        }

        $log = $this->find('first', array(
            'conditions' => array(
                'ApiCallLog.id' => $id
            )
        ));

        return $log;
    }


    /**
    * get the navtabs-count for call logs (live/debugger)
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
                'ApiCallLog.deleted' => 0
            )
        ));

        $DebuggerApiCallLog = ClassRegistry::init('DebuggerApiCallLog');
        $counts['debugger'] = $DebuggerApiCallLog->find('count', array(
            'conditions' => array(
                'DebuggerApiCallLog.deleted' => 0
            )
        ));

        return $counts;
    }

}
