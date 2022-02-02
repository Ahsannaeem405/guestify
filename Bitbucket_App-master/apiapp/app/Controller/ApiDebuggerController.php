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
        parent::beforeFilter();
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

        $selected_function = '';
        if(isset($query['selected_function'])) {
            $selected_function = urldecode($query['selected_function']);
        }

        $api_key = '';
        if(isset($query['api_key'])) {
            $api_key = urldecode($query['api_key']);
        }

        $api_secret = '';
        if(isset($query['api_secret'])) {
            $api_secret = urldecode($query['api_secret']);
        }

        $locale = '';
        if(isset($query['locale'])) {
            $locale = urldecode($query['locale']);
        }

        $token = '';
        if(isset($query['token'])) {
            $token = urldecode($query['token']);
        }

        $token_type = '';
        if(isset($query['token_type'])) {
            $token_type = urldecode($query['token_type']);
        }

        $payload = array();
        if(isset($query['payload'])) {
            $temp_payload = array();
            $temp = urldecode($query['payload']);
            parse_str($temp, $temp_payload);

            $temp_payload = $temp_payload['data']['ApiDebugger']['payload'];

            foreach($temp_payload as $key => $entry) {
                if(!empty($entry['key']) && !empty($entry['value'])) {
                    $payload[strip_tags(urldecode($entry['key']))] = strip_tags(urldecode($entry['value']));
                }
            }
        }


        if($selected_function == 'getToken') {
            # obtain an access token for the API by calling the getToken()-function (WRITE!)
            $url_params = array(
                'api_key' => $api_key,
                'api_secret' => $api_secret,
                'type' => $token_type,
                'debugger' => 1
            );
            $http_query = http_build_query($url_params);
            $request_url = Configure::read('NON_SSL_API') . '/v1/getToken.json?' . $http_query;

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
            $return['request_url']      = str_replace('&debugger=1', '', $request_url);
            $return['request_result']   = $result;

            return json_encode($return);
        }


        if($selected_function == 'getPoll') {

            $url_params = array(
                'api_key' => $api_key,
                'token' => $token,
                'locale' => $locale,
                'debugger' => 1
            );
            $http_query = http_build_query($url_params);
            $request_url = Configure::read('NON_SSL_API') . '/v1/polls/getPoll.json?' . $http_query;

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
            $return['request_url']      = str_replace('&debugger=1', '', $request_url);
            $return['request_result']   = $result;
            
            return json_encode($return);
        }


        if($selected_function == 'savePoll') {

            $url_params = array(
                'api_key' => $api_key,
                'token' => $token,
                'locale' => $locale,
                'debugger' => 1
            );
            $url_params = array_merge($url_params, $payload);
            $http_query = http_build_query($url_params);
            $request_url = Configure::read('NON_SSL_API') . '/v1/polls/savePoll.json?' . $http_query;

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
            $return['request_url']      = str_replace('&debugger=1', '', $request_url);
            $return['request_result']   = $result;
            
            return json_encode($return);
        }

    }

}

