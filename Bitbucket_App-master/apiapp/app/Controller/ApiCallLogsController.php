<?php
/**
 * ApiCallLogs controller
 *
 * @package app
 * @subpackage controllers
 */
class ApiCallLogsController extends AppController {

    public $name = 'ApiCallLogs';

    public $uses = array('ApiCallLog', 'DebuggerApiCallLog');

    public function beforeFilter() {
        parent::beforeFilter();	// not used here to speed up requests
    }



    /**
    * list all api tokens (depending on selected tab)
    * -> live: all live tokens from table api_tokens
    * -> debugger: all debugger tokens from table debugger_api_tokens
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return void
    */
    public function adminIndex($type = 'live') {

        $model = 'ApiCallLog';
        if($type == 'debugger') {
            $model =  'DebuggerApiCallLog';
        }

        $conditions = array();
        $conditions[$model.'.deleted'] = 0;

        # paginate the list with manual options
        $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 50,
            'order' => array(
                $model.'.id' => 'DESC'
            )
        );

        $apiCallLogs = $this->paginate($model);

        $navtabCounts = $this->ApiCallLog->getNavtabCounts();

        $this->set(compact('apiCallLogs', 'navtabCounts'));

        $this->params['ApiCallLogs.index.tab'] = $type;
    }


    /**
    * view an API call log record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $apiCallLogId
    * @return void
    */
    public function adminView($apiCallLogId = null, $type = 'live') {
        if(!$apiCallLogId)  {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $apiCallLog = $this->ApiCallLog->getApiCallLog($apiCallLogId, $type);

        $this->set(compact('apiCallLog', 'type'));
    }


}

