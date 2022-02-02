<?php
/**
 * APIs controller
 *
 * @package app
 * @subpackage controllers
 */
class ApisController extends AppController {

    public $name = 'Apis';

    public $uses = array(
        'Api', 
        'ApiCallLog',
        'ApiToken', 
        'Answer', 
        // 'DebuggerApi', 
        // 'DebuggerApiCallLog',
        // 'DebuggerApiToken', 
        'Poll'
    );

    public $components = array('RequestHandler');

    public $version = 1;


    # holder for API-calls
    public $apicall_key = '';

    public $apicall_secret = '';

    public $apicall_type = '';

    public $apicall_token_string = '';

    public $apicall_poll_id = '';

    public $apicall_poll = '';

    public $apicall_function = '';

    public $apicall_account = array();

    public $debugger = false;


    # setup model names to use with the API
    public $model_api = 'Api';

    public $model_api_token = 'ApiToken';

    public $model_api_call_log = 'ApiCallLog';


    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'testGetHost',
            'getHost',
            'getPoll',
            'getPollsByHostId',
            'testGetPoll',
            'getToken',
            'savePoll'
        ));

        $query = $this->params->query;
        if(isset($query['debugger']) && ($query['debugger'] == true)) {
            Configure::write('Debugger', 1);    // used in models to switch DB tables
            $this->debugger == true;
        } else {
            Configure::write('Debugger', 0);
            $this->debugger == false;
        }
    }


    /**
    * list all functions the API currently supports
    * and link their detail-views
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function functions() {
        return true;
    }


    /**
    * get a complete poll record for futher use
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getPoll() {

        # validate caller-query
        $params = $this->params;
        $query = $params->query;
        
        if(!isset($query['api_key'])) {
            $errors = array(
                'code' => '200',
                'error' => __('Missing parameter: api_key')
            );
            $this->showErrors($errors);
        }
        $this->apicall_key          = $query['api_key'];


        if(!isset($query['token'])) {
            $errors = array(
                'code' => '201',
                'error' => __('Missing parameter: token')
            );
            $this->showErrors($errors);
        }
        $this->apicall_token_string = $query['token'];


        $this->apicall_locale = 'deu';
        if(isset($query['locale']) && !empty($query['locale'])) {
            $this->apicall_locale = $query['locale'];
        }

        $this->apicall_function     = $params['action'];

        $token = $this->{$this->model_api_token}->find('first', array(
            'conditions' => array(
                $this->model_api_token.'.api_key' => $this->apicall_key,
                $this->model_api_token.'.token' => $this->apicall_token_string,
            )
        ));

        if(empty($token)) {
            $errors = array(
                'code' => '202',
                'error' => __('Token could not be found')
            );
            $this->showErrors($errors);
        }


        if($token[$this->model_api_token]['status'] == 2) {
            $errors = array(
                'code' => '203',
                'error' => __('Token has already been used')
            );
            $this->showErrors($errors);
        }

        if($token[$this->model_api_token]['status'] == 0) {
            $errors = array(
                'code' => '204',
                'error' => __('Token has been marked invalid')
            );
            $this->showErrors($errors);
        }

        if(strtotime($token[$this->model_api_token]['expires']) < strtotime(date('Y-m-d H:i:s'))) {
            $errors = array(
                'code' => '205',
                'error' => __('Token is expired')
            );
            $this->showErrors($errors);
        }

        $this->apicall_account    = $this->Poll->Account->findById($token[$this->model_api_token]['account_id']);

        $this->apicall_poll_id  = $token[$this->model_api_token]['f_key'];

        $poll = $this->Api->getPoll($this->apicall_poll_id, $this->apicall_locale);

        if(empty($poll)) {
            $errors = array(
                'code' => '206',
                'error' => __('Poll could not be identified for given api_key/token combination')
            );
            $this->showErrors($errors);
        }

        if($poll['Poll']['api_accessible'] == 0) {
            $errors = array(
                'code' => '207',
                'error' => __('Poll is not accessible by API request')
            );
            $this->showErrors($errors);
        }

        $result = array(
            'code' => '200',
            'result' => 'success',
            'timestamp' => strtotime(date('Y-m-d H:i:s')),
            'data' => $poll
        );

        $this->logCall($this->params, $_SERVER);

        $this->{$this->model_api_token}->markTokenAsUsed($this->apicall_key, $this->apicall_token_string);    // set it to "used"

        $this->autoRender = false;
        $this->set('_serialize', array('result'));
        echo json_encode($result);
    }


    /**
    * obtain a token to use the guestify API
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getToken() {

        $query = $this->params->query;

        # validate existence of app-secret in API call
        if(!isset($query['api_key'])) {
            $errors = array(
                'code' => '1000',
                'error' => __('Missing parameter: api_key')
            );
            $this->showErrors($errors);
        }

        $this->apicall_key = $query['api_key'];

        # validate existence of app-secret in API call
        if(!isset($query['api_secret'])) {
            $errors = array(
                'code' => '1001',
                'error' => __('Missing parameter: api_secret')
            );
            $this->showErrors($errors);
        }

        $this->apicall_secret = $query['api_secret'];


        # validate the type of the token-request
        if(!isset($query['type'])) {
            $errors = array(
                'code' => '1002',
                'error' => __('Missing parameter: type')
            );
            $this->showErrors($errors);
        }

        if(!in_array($query['type'], array(1, 2))) {
            $errors = array(
                'code' => '1003',
                'error' => __('Invalid value for parameter: type (possible values: 1, 2)')
            );
            $this->showErrors($errors);
        }

        $this->apicall_type = $query['type'];

        # validate the caller (e.g. account that belongs to the API call)
        $poll = $this->Poll->getPollByApiKeyAndSecret($this->apicall_key, $this->apicall_secret);

        if(empty($poll)) {
            $errors = array(
                'code' => '1004',
                'error' => __('No poll identified by key/secret combination!')
            );
            $this->showErrors($errors);
        }

        if($poll['Poll']['status'] == 0) {
            $errors = array(
                'code' => '1005',
                'error' => __('Identified poll is currently deactivated')
            );
            $this->showErrors($errors);
        }

        if(!$poll['Poll']['api_accessible']) {
            $errors = array(
                'code' => '1006',
                'error' => __('Identified poll is not activated for API access')
            );
            $this->showErrors($errors);
        }


        $this->apicall_poll = $poll;
        $this->apicall_poll_id = $poll['Poll']['id'];

        # get the account which is calling the API and validate access rights
        $account = $this->Poll->Account->findById($poll['Poll']['account_id']);

        # validate account information here...
        # validate the connected account information to the API-call
        if(empty($account)) {
            $errors = array(
                'code' => '1007',
                'error' => __('The owning account of the poll could not be identified')
            );
            $this->showErrors($errors);
        }
        $this->apicall_account = $account;


        $api_token = $this->{$this->model_api_token}->generateToken(
            $this->apicall_key, 
            $this->apicall_secret, 
            $this->apicall_account,
            $this->apicall_type,
            $this->apicall_poll
        );


        $api_token_return = array();
        $api_token_return['token']      = $api_token[$this->model_api_token]['token'];
        $api_token_return['expires']    = strtotime($api_token[$this->model_api_token]['expires']);


        $result = array(
            'code' => '200',
            'result' => 'success',
            'timestamp' => strtotime(date('Y-m-d H:i:s')),
            'token' => $api_token_return
        );

        $this->autoRender = false;
        $this->set('_serialize', array('result'));
        echo json_encode($result);
    }


    /**
    * obtain a token to use the guestify API
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function logCall($params, $server) {

        $query = $params->query;

        $call_log = array();
        
        $env = Configure::read('Environment');
        if($env == 'LOCAL') {
            $call_log['request_uri'] = $server['SCRIPT_URL'];
        } else {
            $call_log['request_uri'] = $server['REDIRECT_URL'];
        }

        $call_log['action']      = $params['action'];

        if(isset($query['api_key'])) {
            $call_log['api_key']     = $query['api_key'];
        }

        $call_log['query'] = json_encode($query);

        if($call_log['action'] == 'getPoll') {
            $poll = $this->Poll->find('first', array(
                'conditions' => array(
                    'Poll.api_key' => $call_log['api_key']
                )
            ));

            $call_log['model'] = 'Poll';
            $call_log['f_key'] = $poll['Poll']['id'];
        }

        if($call_log['action'] == 'savePoll') {
            $poll = $this->Poll->find('first', array(
                'conditions' => array(
                    'Poll.api_key' => $call_log['api_key']
                )
            ));

            $call_log['model'] = 'Poll';
            $call_log['f_key'] = $poll['Poll']['id'];
        }

        $this->{$this->model_api_call_log}->create();
        $this->{$this->model_api_call_log}->save($call_log);

        return;
    }


    /**
    * general function to prepare api-calls
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    // public function prepareApiCall($params) {

    //     # validate caller-query
    //     $query = $params->query;
    //     $this->validateQuery($query);

    //     $this->apicall_locale = 'deu';
    //     if(isset($query['locale']) && !empty($query['locale'])) {
    //         $this->apicall_locale = $query['locale'];
    //     }

    //     $this->apicall_key        = $query['api_key'];
    //     $this->apicall_function   = $params['action'];
    //     $this->apicall_token_string = $query['token'];

    //     #$this->validateToken($this->apicall_key, $this->apicall_token_string, $this->apicall_function);

    //     if(!$this->apicall_key || empty($this->apicall_key)) {
    //         $errors = array(
    //             'code' => '100',
    //             'error' => __('Invalid API-Call or missing api-key parameter!')
    //         );
    //         $this->showErrors($errors);
    //     }

    //     if(!$this->apicall_token_string || empty($this->apicall_token_string)) {
    //         $errors = array(
    //             'code' => '103',
    //             'error' => __('Invalid or missing access-token!')
    //         );
    //         $this->showErrors($errors);
    //     }

    //     if(!$this->apicall_function || empty($this->apicall_function)) {
    //         $errors = array(
    //             'code' => '105',
    //             'error' => __('Invalid or undefined api-function!')
    //         );
    //         $this->showErrors($errors);
    //     }



    //     $token = $this->{$this->model_api_token}->find('first', array(
    //         'conditions' => array(
    //             $this->model_api_token.'.api_key' => $this->apicall_key,
    //             $this->model_api_token.'.token' => $this->apicall_token_string,
    //         )
    //     ));

    //     if(empty($token)) {
    //         $errors = array(
    //             'code' => '201',
    //             'error' => __('Invalid token!')
    //         );
    //         $this->showErrors($errors);
    //     }

    //     if($token[$this->model_api_token]['status'] == 2) {
    //         $errors = array(
    //             'code' => '202',
    //             'error' => __('This token has already been used!')
    //         );
    //         $this->showErrors($errors);
    //     }

    //     if($token[$this->model_api_token]['status'] == 0) {
    //         $errors = array(
    //             'code' => '203',
    //             'error' => __('This token has been marked invalid!')
    //         );
    //         $this->showErrors($errors);
    //     }

    //     if(strtotime($token[$this->model_api_token]['expires']) < strtotime(date('Y-m-d H:i:s'))) {
    //         $errors = array(
    //             'code' => '205',
    //             'error' => __('This token has expired its lifetime!')
    //         );
    //         $this->showErrors($errors);
    //     }

    //     $this->apicall_account    = $this->Poll->Account->findById($token[$this->model_api_token]['account_id']);

    //     $this->apicall_poll_id  = $token[$this->model_api_token]['f_key'];

    //     return;
    // }


    /**
    * save a complete poll record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function savePoll() {

        $this->apicall_function = $this->params['action'];

        # validate caller-query
        $query = $this->params->query;

        # decode all parameters in case they are url-encoded
        foreach($query as $key => $value) {
            $query[strip_tags(urldecode($key))] = strip_tags(urldecode($value));
        }


        $this->apicall_locale = 'deu';
        if(isset($query['locale']) && !empty($query['locale'])) {
            $this->apicall_locale = $query['locale'];
        }



        if(!isset($query['api_key'])) {
            $errors = array(
                'code' => '3000',
                'error' => __('Missing api-key!')
            );
            $this->showErrors($errors);
        }
        $this->apicall_key = $query['api_key'];

        if(!isset($query['token'])) {
            $errors = array(
                'code' => '3001',
                'error' => __('Missing access-token!')
            );
            $this->showErrors($errors);
        }
        $this->apicall_token_string = $query['token'];


        #$this->validateToken($this->apicall_key, $this->apicall_token_string, $this->apicall_function);

        $token = $this->{$this->model_api_token}->find('first', array(
            'conditions' => array(
                $this->model_api_token.'.api_key' => $this->apicall_key,
                $this->model_api_token.'.token' => $this->apicall_token_string
            )
        ));

        if(empty($token) || !isset($token[$this->model_api_token]['status'])) {
            $errors = array(
                'code' => '3002',
                'error' => __('Token could not be found!')
            );
            $this->showErrors($errors);
        }

        if($token[$this->model_api_token]['status'] == 2) {
            $errors = array(
                'code' => '3003',
                'error' => __('Token has already been used')
            );
            $this->showErrors($errors);
        }

        if($token[$this->model_api_token]['status'] == 0) {
            $errors = array(
                'code' => '3004',
                'error' => __('Token has been marked invalid')
            );
            $this->showErrors($errors);
        }

        if(strtotime($token[$this->model_api_token]['expires']) < strtotime(date('Y-m-d H:i:s'))) {
            $errors = array(
                'code' => '3005',
                'error' => __('Token is expired')
            );
            $this->showErrors($errors);
        }


        $this->apicall_poll_id      = $token[$this->model_api_token]['f_key'];
        $this->apicall_account_id   = $token[$this->model_api_token]['account_id'];
        $this->apicall_account      = $this->Poll->Account->findById($this->apicall_account_id);


        # get the poll the answer-set belongs to
        $poll = $this->Api->getPoll($this->apicall_poll_id, $this->apicall_locale);

        if(empty($poll)) {
            $errors = array(
                'code' => '3006',
                'error' => __('Poll could not be identified for given api_key/token combination')
            );
            $this->showErrors($errors);
        }



        # validate answer-set 
        # 1. extract answers
        $answers_given = array();
        foreach($query as $key => $value) {
            if(strpos($key, 'q_') !== false) {
                $answers_given[$key] = intval($value);
            }
        }

        if(empty($answers_given)) {
            $errors = array(
                'code' => '701',
                'error' => __('No answers given in transferred data!')
            );
            $this->showErrors($errors);
        }

        # check for missing answers
        foreach($answers_given as $key => $value) {
            if(empty($value)) {
                $errors = array(
                    'code' => '702',
                    'error' => __('At least one answer is missing!')
                );
                $this->showErrors($errors);
            }
        }

        $questions_origin = $this->Poll->getPollQuestions($this->apicall_poll_id);
        $questions_origin = $this->Poll->remapData($questions_origin, 'Question');

        if(count($answers_given) != count($questions_origin)) {
            $errors = array(
                'code' => '702',
                'error' => __('The given answer-count does not match the question-count of the given poll!')
            );
            $this->showErrors($errors);
        }


        # check each given answer for existence and validity
        foreach($answers_given as $key => $value) {

            $temp = explode('_', $key);
            $q_id = $temp[1];

            if(!isset($questions_origin[$q_id]) || empty($questions_origin[$q_id])) {
                $errors = array(
                    'code' => '702',
                    'error' => __('The answers given do not match the questions from the given poll!')
                );
                $this->showErrors($errors);
            }

            $question_origin = $questions_origin[$q_id];
            if($question_origin['Question']['scale'] < $value) {
                $errors = array(
                    'code' => '704',
                    'error' => __('At least one answer has a vote higher than the given question-scale!')
                );
                $this->showErrors($errors);
            }
        }

        // pr($query);
        // exit;

        # validate the guest data
        if(!isset($query['guest_type'])) {
            $errors = array(
                'code' => '900',
                'error' => __('Guest-type parameter is missing!')
            );
            $this->showErrors($errors);
        }
        if(!in_array($query['guest_type'], array(1, 2, 3, 4))) {
            $errors = array(
                'code' => '901',
                'error' => __('Guest-type parameter is out of bounds!')
            );
            $this->showErrors($errors);
        }

        if(!isset($query['guest_visit_time'])) {
            $errors = array(
                'code' => '902',
                'error' => __('Guest-visit-time  parameter is missing!')
            );
            $this->showErrors($errors);
        }
        if(!in_array($query['guest_visit_time'], array(1, 2, 3))) {
            $errors = array(
                'code' => '903',
                'error' => __('Guest-visit time parameter is out of bounds!')
            );
            $this->showErrors($errors);
        }


        # sanitize data
        if(isset($query['guest_comment_customer']) && !empty($query['guest_comment_customer'])) {
            $query['guest_comment_customer'] = h(strip_tags(urldecode($query['guest_comment_customer'])));
        } else {
            $query['guest_comment_customer'] = NULL;
        }

        if(isset($query['guest_name']) && !empty($query['guest_name'])) {
            $query['guest_name'] = h(strip_tags($query['guest_name']));
        } else {
            $query['guest_name'] = NULL;
        }

        # check if email is set -> if so, validate email-address syntax
        if(isset($query['guest_email']) && !empty($query['guest_email'])) {
            $query['guest_email'] = strip_tags(urldecode($query['guest_email']));
            if(!filter_var($query['guest_email'], FILTER_VALIDATE_EMAIL)) {
                $errors = array(
                    'code' => '904',
                    'error' => __('The given email-address is not a valid email-address!')
                );
                $this->showErrors($errors);
            }
        } else {
            $query['guest_email'] = NULL;
        }


        if($this->debugger == true) {
            
            $result = array(
                'code' => '200',
                'result' => 'success',
                'timestamp' => strtotime(date('Y-m-d H:i:s')),
            );

            $this->logCall($this->params, $_SERVER);

            $this->{$this->model_api_token}->markTokenAsUsed($this->apicall_key, $this->apicall_token_string);    // set it to "used"

            $this->autoRender = false;
            $this->set('_serialize', array('result'));
            echo json_encode($result);

        } else {


            ### from here on, it's all good and we can build & save the given poll-data

            # build guest record
            $guest = array();
            $guest['Guest']['guest_type']   = $query['guest_type'];
            $guest['Guest']['visit_time']   = $query['guest_visit_time'];
            $guest['Guest']['name']         = $query['guest_name'];
            $guest['Guest']['email']        = $query['guest_email'];
            $guest['Guest']['poll_id']      = $this->apicall_poll_id;
            $guest['Guest']['comment_customer'] = $query['guest_comment_customer'];
            $guest['Guest']['api_account_id']   = $this->apicall_account['Account']['id'];


            # set standards for unused fields
            $guest['Guest']['pin']          = 0;
            $guest['Guest']['user_agent']   = '';
            $guest['Guest']['ip']           = '';
            $guest['Guest']['referrer']     = '';
            $guest['Guest']['language']     = '';

            $this->Poll->Guest->create();
            if(!$this->Poll->Guest->save($guest)) {
                return false;
                $errors = array(
                    'code' => '920',
                    'error' => __('Saving of guest-data failed, please try again!')
                );
                $this->showErrors($errors);
            }


            # build & save the answer records
            foreach($answers_given as $key => $rating) {

                $temp = explode('_', $key);
                $question_id = $temp[1];

                $answer = array();
                $answer['Answer']['poll_id']        = $this->apicall_poll_id;
                $answer['Answer']['guest_id']       = $this->Poll->Guest->id;
                $answer['Answer']['question_id']    = $question_id;
                $answer['Answer']['rating']         = $rating;
                $answer['Answer']['ip']             = '';
                $answer['Answer']['api_account_id'] = $this->apicall_account['Account']['id'];

                $this->Poll->Answer->create();
                if(!$this->Poll->Answer->save($answer)) {
                    $errors = array(
                        'code' => '1001',
                        'error' => __('Saving of answers failed, please try again!')
                    );
                }
            }

            $result = array(
                'code' => '200',
                'result' => 'success',
                'timestamp' => strtotime(date('Y-m-d H:i:s')),
            );

            $this->logCall($this->params, $_SERVER);

            $this->{$this->model_api_token}->markTokenAsUsed($this->apicall_key, $this->apicall_token_string);    // set it to "used"

            $this->autoRender = false;
            $this->set('_serialize', array('result'));
            echo json_encode($result);
        }
    }


    /**
    * general function to return API-call errors
    * (currently returning all errors as json-objects)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param array $errors
    * @return void
    */
    public function showErrors($errors) {

        $errors['result'] = 'failed';
        $errors['timestamp'] = strtotime(date('Y-m-d H:i:s'));

        $this->set(compact('errors'));

        $this->layout = 'json';
        $this->render('/Apis/api_request_errors');

        $this->response->send();
        $this->_stop();
    }


    /**
    * test API-function "getPoll" and return the result
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function testGetPoll() {

        if($this->RequestHandler->isPost()) {

            # obtain an access token for the API by calling the getToken()-function (WRITE!)
            $url_params = array(
                'api_key' => 'cec50ff799',
                'api_secret' => 'efb9e27deabc9726141d',
                'type' => 2
            );
            $http_query = http_build_query($url_params);
            $url_access_request = Configure::read('NON_SSL_HOST') . '/api/v1/getToken.json?'.$http_query;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // switch this when SSL is applied!
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url_access_request);
            $result = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($result, true);

            if(!isset($result['token']) || ($result['code'] != 200)) {
                die('Error obtaining token!');
            }

            # build the API-call for saving the poll-answers
            $data = $this->data;

            $url_params = array();
            $url_params['api_key']  = 'cec50ff799';
            $url_params['token']    = $result['token']['token'];

            # prepare needed poll data
            #$url_params['poll_id'] = $data['Poll']['id'];

            # prepare needed answers
            $answers = $data['Answers'];
            foreach($answers as $question_id => $vote) {
                $url_params['q_'.$question_id] = $vote;
            }

            # prepare needed guest data
            $url_params['guest_type']             = $data['Guest']['guest_type'];
            $url_params['guest_visit_time']       = $data['Guest']['visit_time'];
            $url_params['guest_comment_customer'] = $data['Guest']['comment_customer'];
            $url_params['guest_name']             = $data['Guest']['name'];
            $url_params['guest_email']            = $data['Guest']['email'];


            $http_query = http_build_query($url_params);
            $url_save_poll = Configure::read('NON_SSL_HOST') . '/api/v1/polls/savePoll.json?' . $http_query;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // switch this when SSL is applied!
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url_save_poll);
            $result = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($result, true);

            pr($result);
            exit;
        }


        # obtain an access token for the API by calling the getToken()-function (READ!)
        $url_params = array(
            'api_key' => 'cec50ff799',
            'api_secret' => 'efb9e27deabc9726141d',
            'type' => 1
        );
        $http_query = http_build_query($url_params);
        $url_access_request = Configure::read('NON_SSL_HOST') . '/api/v1/getToken.json?'.$http_query;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // switch this when SSL is applied!
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url_access_request);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        if(!isset($result['token']) || ($result['code'] != 200)) {
            die('Error obtaining token!');
        }


        # make the actual API call and get the poll including all groups and questions
        $url_params = array(
            'api_key' => 'cec50ff799',
            'token' => $result['token']['token'],
            'locale' => 'deu'
        );
        $http_query = http_build_query($url_params);
        $url_api_call = Configure::read('NON_SSL_HOST') . '/api/v1/polls/getPoll.json?' . $http_query;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // switch this when SSL is applied!
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url_api_call);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        if($result['code'] != 200) {
            pr($result);
            exit;
        }


        # set all neccessary data for the view
        $this->set(compact('result', 'url_access_request', 'url_api_call'));


        # define layout/template to use for poll-display
        $this->render('/Apis/demos/get_poll');
    }


    /**
    * validate access privileges depending on a given API key
    * and a function name
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    private function validateAccess($api_key = null, $api_token = null, $function = null) {

        if(!$api_key || empty($api_key)) {
            $errors = array(
                'code' => '100',
                'error' => __('Missing api-key for API call!')
            );
            $this->showErrors($errors);
        }

        $api_account = $this->ApiAccount->find('first', array(
            'conditions' => array(
                'ApiAccount.api_key' => $api_key
            )
        ));


        if(empty($api_account)) {
            $errors = array(
                'code' => '101',
                'error' => __('No api-account found for given api-key!')
            );
            $this->showErrors($errors);
        }


        if($api_account['ApiAccount']['api_access_status'] == 0) {
            $errors = array(
                'code' => '101',
                'error' => __('Api-account is deactivated!')
            );
            $this->showErrors($errors);
        }

        
        # implement detailed permission-control by checking function-access for any api-account
        // $accessible_functions = $this->ApiAccount->getAccessibleFunctionsByAccountId($api_account['ApiAccount']['id']);
        // if(!in_array($function, $accessible_functions)) {
        //     $errors = array(
        //         'code' => '102',
        //         'error' => __('The called API-function is not accessible for your account!')
        //     );
        //     $this->showErrors($errors);
        // }

        return $api_account;
    }


    /**
    * validate the contents of a given api-call
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    private function validateQuery($query) {

        $valid = true;

        if(!isset($query['api_key'])) {
            $errors = array(
                'code' => '100',
                'error' => __('Invalid API-Call or missing api-key parameter!')
            );
            $this->showErrors($errors);
        }

        return true;
    }


    /**
    * validate the contents of a given api-call
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    private function validateToken($api_key = null, $token_string = null, $function = null) {

        // pr($api_key);
        // pr($token_string);
        // pr($function);
        // exit;

        if(!$api_key || empty($api_key)) {
            $errors = array(
                'code' => '100',
                'error' => __('Invalid API-Call or missing api-key parameter!')
            );
            $this->showErrors($errors);
        }

        if(!$token_string || empty($token_string)) {
            $errors = array(
                'code' => '103',
                'error' => __('Invalid or missing access-token!')
            );
            $this->showErrors($errors);
        }

        if(!$function || empty($function)) {
            $errors = array(
                'code' => '105',
                'error' => __('Invalid or undefined api-function!')
            );
            $this->showErrors($errors);
        }

        $token = $this->{$this->model_api_token}->find('first', array(
            'conditions' => array(
                $this->model_api_token.'.api_key' => $api_key,
                $this->model_api_token.'.token' => $token_string,
            )
        ));

        if(empty($token)) {
            $errors = array(
                'code' => '201',
                'error' => __('Invalid token!')
            );
            $this->showErrors($errors);
        }

        if($token[$this->model_api_token]['status'] == 2) {
            $errors = array(
                'code' => '202',
                'error' => __('This token has already been used!')
            );
            $this->showErrors($errors);
        }

        if($token[$this->model_api_token]['status'] == 0) {
            $errors = array(
                'code' => '203',
                'error' => __('This token has been marked invalid!')
            );
            $this->showErrors($errors);
        }

        if(strtotime($token[$this->model_api_token]['expires']) < strtotime(date('Y-m-d H:i:s'))) {
            $errors = array(
                'code' => '205',
                'error' => __('This token has expired its lifetime!')
            );
            $this->showErrors($errors);
        }


        # check if token may access function on read/write level
        // if($token[$this->model_api_token]['type'] != $functions_by_type[$function]) {
        //     $errors = array(
        //         'code' => '208',
        //         'error' => __('This token cannot be used for the given function (read/write permission!')
        //     );
        //     $this->showErrors($errors);
        // }

        return true;
    }

}
