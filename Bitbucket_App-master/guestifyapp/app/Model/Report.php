<?php
class Report extends AppModel {

    public $name = 'Report';

    public $useTable = false;
    

    /**
    * test the weather-data gethering function (used by cron!)
    * use this to gather a one day forecast for the upcoming day
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function generateWeatherData($date = null) {

        if(!$date) {
            $date = date('Y-m-d');
        }

        $timestamp = strtotime($date);

        Configure::write('Weather.API_KEY', '58939f4b6506d3ed760a6b6c4d6e085d');
        $Weather = ClassRegistry::init('Weather');

        $hosts = $this->Host->find('all', array(
            'conditions' => array(
                'AND' => array(
                    array(
                        'Host.lat !=' => NULL,
                        'Host.lng !=' => NULL
                    ),
                    array(
                        'Host.lat !=' => '',
                        'Host.lng !=' => ''
                    )
                )
            )
        ));


        foreach($hosts as $host) {

            # try getting weather data via lat/lon
            $string_api_call = 'http://api.openweathermap.org/data/2.5/weather?lat='.round($host['Host']['lat'], 2).'&lon='.round($host['Host']['lng'], 2).'&units=metric&API_KEY='.Configure::read('Weather.API_KEY');
            $data = file_get_contents($string_api_call);
            if(empty($data)) {
                # add some logging here!
                continue;
            }

            $weather = array();
            $weather['Weather']['date']     = date('Y-m-d');
            $weather['Weather']['lat']      = $host['Host']['lat'];
            $weather['Weather']['lng']      = $host['Host']['lng'];
            $weather['Weather']['city']     = $host['Host']['city'];
            $weather['Weather']['zipcode']  = $host['Host']['zipcode'];
            $weather['Weather']['country_id'] = $host['Host']['country_id'];
            $weather['Weather']['data']     = $data;

            $Weather->create();
            $Weather->save($weather);
        }

        return;
    }

    /**
    * generate the weekly report
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $year, string $weeknumber
    * @return mixed $reports
    */
    public function generateWeeklyReports($year = null, $weeknumber = null, $env = null) {

        if(!$year) {
            $year = date('Y');
        }
        if(!$weeknumber) {
            $weeknumber = date('N');
        }

        if(!$env) {
            $env = 'LOCAL';
        }

        Configure::write('Environment', $env);

        $weeknumber = sprintf("%02u", $weeknumber);
        $week_start = date( "Y-m-d", strtotime($year."W".$weeknumber."1")); // First day of week
        $week_end   = date( "Y-m-d", strtotime($year."W".$weeknumber."7") ); 

        $week = array('start' => $week_start, 'end' => $week_end);

        # structure:
        # - Account 1
        #   - Host 1
        #       - Poll 1
        #       - Poll 2
        #       - ...
        #   - Host 2
        #       - Poll 1
        #       - Poll 2
        #       - ...

        $Account    = ClassRegistry::init('Account');
        $Host       = ClassRegistry::init('Host');
        $Poll       = ClassRegistry::init('Poll');


        # prefilter accounts by checking active polls
        $Poll->Behaviors->disable('Translate');
        $polls = $Account->Poll->find('all', array(
            'conditions' => array(
                'Poll.deleted' => 0,
                'Poll.status' => 1
            )
        ));
        $account_ids = Set::ClassicExtract($polls, '{n}.Poll.account_id');

        # get account details and every host including polls
        $accounts = $Account->find('all', array(
            'contain' => array(
                'Host' => array(
                    'Poll' => array(
                        'Invoice' => array(
                            'conditions' => array(
                                'Invoice.valid_until >' => date('Y-m-d H:i:s')
                            ),
                            'limit' => 1,
                            'order' => 'Invoice.valid_until DESC'
                        ),
                        'conditions' => array(
                            'Poll.deleted' => 0,
                            'Poll.status' => 1,
                        ),
                        'order' => 'Poll.title ASC'
                    ),
                    'conditions' => array(
                        'Host.deleted' => 0
                    ),
                    'order' => 'Host.name ASC'
                )
            ),
            'conditions' => array(
                'Account.id' => $account_ids
            )
        ));

        # remap to connect accounts with users later
        $accounts = $this->remapData($accounts, 'Account', 'id');

        # inject the report based on week (start date + end date) and poll
        foreach($accounts as $key_accounts => $account) {
            foreach($account['Host'] as $key_host => $host) {
                foreach($host['Poll'] as $key_poll => $poll) {
                    $report = $Account->Poll->getScorecardCounts($poll['id'], 'week', $week);
                    $report['max_scale'] = $Account->Poll->getPollsMaxScale($poll['id']);
                    $accounts[$key_accounts]['Host'][$key_host]['Poll'][$key_poll]['Report'] = $report;
                }
            }
        }

        # get all possible users as recipients
        $users = $Account->User->find('all', array(
            'conditions' => array(
                'User.deleted' => 0,
                'User.status' => 1
            )
        ));

        # inject the account/host/poll sets to each user so we have all we need for the email!
        foreach($users as $key => $user) {
            if(isset($accounts[$user['User']['account_id']])) {
                $users[$key] = array_merge($user, $accounts[$user['User']['account_id']]);
            } else {
                unset($users[$key]);
            }
        }

        $users = $this->remapData($users, 'User', 'id');

        return $users;
    }

}
