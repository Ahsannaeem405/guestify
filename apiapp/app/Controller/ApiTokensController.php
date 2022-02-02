<?php
/**
 * ApiTokens controller
 *
 * @package app
 * @subpackage controllers
 */
class ApiTokensController extends AppController {

    public $name = 'ApiTokens';

    public $uses = array('ApiToken', 'DebuggerApiToken');

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

        $model = 'ApiToken';
        if($type == 'debugger') {
            $model =  'DebuggerApiToken';
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

        $apiTokens = $this->paginate($model);

        $tokenStatuses = $this->ApiToken->getTokenStatuses();
        $tokenStatusClasses = $this->ApiToken->getTokenStatusClasses();

        $navtabCounts = $this->ApiToken->getNavtabCounts();

        $this->set(compact('apiTokens', 'navtabCounts', 'tokenStatuses', 'tokenStatusClasses'));

        $this->params['ApiTokens.index.tab'] = $type;
    }


    /**
    * view an API token record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $apiTokenId
    * @return void
    */
    public function adminView($apiTokenId = null, $type = 'live') {
        if(!$apiTokenId)  {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        // if(!$this->ApiToken->exists($apiTokenId)) {
        //     throw new NotFoundException();
        // }

        $apiToken = $this->ApiToken->getApiToken($apiTokenId, $type);

        $tokenStatuses = $this->ApiToken->getTokenStatuses();
        $tokenStatusClasses = $this->ApiToken->getTokenStatusClasses();

        $tokenTypes = $this->ApiToken->getTokenTypes();
        $tokenTypeLabels = $this->ApiToken->getTokenTypeLabels();

        $this->set(compact('apiToken', 'tokenStatuses', 'tokenStatusClasses', 'type', 'tokenTypes', 'tokenTypeLabels'));
    }

}

