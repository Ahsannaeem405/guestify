<?php
/**
 * ApiDebugger controller
 *
 * @package app
 * @subpackage controllers
 */
class ApiDebuggerController extends AppController {

    public $name = 'ApiDebugger';

    public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();	// not used here to speed up requests
    }


    /**
    * debugger for all API functions
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function debugger() {
        return true;
    }


    /**
    * debugger for all API functions
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function prepareDebuggerCall() {

        $query = $this->params->query;

        $selected_function = $query['selected_function'];
        // $this->Session->write('ApiDebugger.selected_function', $selected_function);

        $api_key    = $query['api_key'];
        $api_secret = $query['api_secret'];
        $token      = $query['token'];
        $token_type = $query['token_type'];

        if(isset($query['payload'])) {
            $payload    = $query['payload'];

            // sanitize the payload keys/values!
        }


        if($selected_function == 'getToken') {
            # obtain an access token for the API by calling the getToken()-function (WRITE!)
            $url_params = array(
                'api_key' => $api_key,
                'api_secret' => $api_secret,
                'type' => $token_type
            );
            $http_query = http_build_query($url_params);
            #$request_url = Configure::read('NON_SSL_HOST') . '/api/v1/getToken.json?'.$http_query;
            $request_url = Configure::read('NON_SSL_HOST') . '/api/v1/getToken?'.$http_query;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // switch this when SSL is applied!
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $request_url);
            $result = curl_exec($ch);
            curl_close($ch);


            # prepare returning of the given result-data
            Configure::write('debug', 0);
            $this->autoRender = false;

            $return = array();
            $return['request_url']      = $request_url;
            $return['request_result']   = $result;

            return json_encode($return);
        }


        if($selected_function == 'getPoll') {

            $url_params = array(
                'api_key' => $api_key,
                'token' => $token,
                'locale' => 'deu'
            );
            $http_query = http_build_query($url_params);
            #$request_url = Configure::read('NON_SSL_HOST') . '/api/v1/polls/getPoll.json?' . $http_query;
            $request_url = Configure::read('NON_SSL_HOST') . '/api/v1/polls/getPoll?' . $http_query;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // switch this when SSL is applied!
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $request_url);
            $result = curl_exec($ch);

            curl_close($ch);


            # prepare returning of the given result-data
            Configure::write('debug', 0);
            $this->autoRender = false;
            
            $return = array();
            $return['request_url']      = $request_url;
            $return['request_result']   = $result;
            
            return json_encode($return);
        }

    }

}

