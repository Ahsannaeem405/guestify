<?php

App::uses('CakeTime', 'Utility');

class Poll extends AppModel {

    public $name = 'Poll';

    public $displayField = 'name';

    public $belongsTo = array(
        'Account',
        'Answer',
        'Host'
    );

    public $hasMany = array(
        'Guest',
        'Group',
        'Invoice',
        'PaymentPP',
        'PollsView',
        'Question',
        'Upgrade',
        'Widget'
    );

    public $actsAs = array(
        'Containable',
        'Translate' => array(
            'name' => 'translatedName'
        )
    );


    // define the poll-templates (could be provided as json or xml soon...)
    public $templates = array(
        1 => array(
            'name' => array(
                'deu' => 'Restaurant 1',
                'eng' => 'Restaurant 1'
            ),
            'Groups' => array(
                1 => array(
                    'name' => array(
                        'deu' => 'Essen & Getränke',
                        'eng' => 'Food & Drinks'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Angebot der Speisen',
                                'eng' => 'Range of food',
                            ),
                            'scale' => 4
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Qualität der Speisen',
                                'eng' => 'Quality of food',
                            ),
                            'scale' => 4
                        ),
                        3 => array(
                            'question' => array(
                                'deu' => 'Präsentation',
                                'eng' => 'Presentation of food'
                            ),
                            'scale' => 4
                        ),
                        4 => array(
                            'question' => array(
                                'deu' => 'Getränke-/Weinangebot',
                                'eng' => 'Range of beverages and wines'
                            ),
                            'scale' => 4
                        ),
                    )
                ),
                2 => array(
                    'name' => array(
                        'deu' => 'Restaurant',
                        'eng' => 'Restaurant'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Ambiente & Dekoration',
                                'eng' => 'Ambience & decor'
                            ),
                            'scale' => 4
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Wartezeiten',
                                'eng' => 'Waiting time'
                            ),
                            'scale' => 4
                        ),
                        3 => array(
                            'question' => array(
                                'deu' => 'Preis-/Leistungsverhältnis',
                                'eng' => 'Value for money'
                            ),
                            'scale' => 4
                        )
                    )
                ),
                3 => array(
                    'name' => array(
                        'deu' => 'Service',
                        'eng' => 'Service'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Freundlichkeit',
                                'eng' => 'Friendliness'
                            ),
                            'scale' => 4
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Kompetenz',
                                'eng' => 'Competence'
                            ),
                            'scale' => 4
                        ),
                        3 => array(
                            'question' => array(
                                'deu' => 'Flexibilität',
                                'eng' => 'Flexibility'
                            ),
                            'scale' => 4
                        ),
                        4 => array(
                            'question' => array(
                                'deu' => 'Serviceleistungen',
                                'eng' => 'Service'
                            ),
                            'scale' => 4
                        )
                    )
                )
            )
        ),
        2 => array(
            'name' => array(
                'deu' => 'Restaurant 2',
                'eng' => 'Restaurant 2'
            ),
            'Groups' => array(
                1 => array(
                    'name' => array(
                        'deu' => 'Standard',
                        'eng' => 'Standard'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Geschmack',
                                'eng' => 'Taste',
                            ),
                            'scale' => 6
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Optik',
                                'eng' => 'Look'
                            ),
                            'scale' => 6
                        ),
                        3 => array(
                            'question' => array(
                                'deu' => 'Wartezeit',
                                'eng' => 'Waiting time'
                            ),
                            'scale' => 6
                        ),
                        4 => array(
                            'question' => array(
                                'deu' => 'Personal',
                                'eng' => 'Service'
                            ),
                            'scale' => 6
                        ),
                        5 => array(
                            'question' => array(
                                'deu' => 'Atmosphäre',
                                'eng' => 'Atmosphere'
                            ),
                            'scale' => 6
                        ),
                        6 => array(
                            'question' => array(
                                'deu' => 'Gesamteindruck',
                                'eng' => 'Overall Impression'
                            ),
                            'scale' => 6
                        ),
                    )
                )
            )
        ),
        3 => array(
            'name' => array(
                'deu' => 'Restaurant 3',
                'eng' => 'Restaurant 3'
            ),
            'Groups' => array(
                1 => array(
                    'name' => array(
                        'deu' => 'Qualität vom Essen',
                        'eng' => 'Food Quality'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Speisen sind frisch',
                                'eng' => 'Food is fresh',
                            ),
                            'scale' => 5
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Menü ist vielfältig',
                                'eng' => 'The menu is diverse',
                            ),
                            'scale' => 5
                        ),
                        3 => array(
                            'question' => array(
                                'deu' => 'Gerichte sind gut gekocht',
                                'eng' => 'Dishes are well cooked'
                            ),
                            'scale' => 5
                        )
                    )
                ),
                2 => array(
                    'name' => array(
                        'deu' => 'Servicequalität',
                        'eng' => 'Service Quality'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Bestellung ist schnell erfasst',
                                'eng' => 'Orders are taken without delay'
                            ),
                            'scale' => 5
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Bedienung ist höflich',
                                'eng' => 'Waiters are well-mannered'
                            ),
                            'scale' => 5
                        ),
                        3 => array(
                            'question' => array(
                                'deu' => 'Tische sind sauber',
                                'eng' => 'Tables are clean'
                            ),
                            'scale' => 5
                        ),
                        4 => array(
                            'question' => array(
                                'deu' => 'Das Essen ist tadellos serviert',
                                'eng' => 'Food is served impeccably'
                            ),
                            'scale' => 5
                        ),
                        5 => array(
                            'question' => array(
                                'deu' => 'Restaurant Atmosphäre ist angenehm',
                                'eng' => 'Restaurant atmosphere is pleasant'
                            ),
                            'scale' => 5
                        )
                    )
                ),
                3 => array(
                    'name' => array(
                        'deu' => 'Service',
                        'eng' => 'Price levels'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Preise sind akzeptabel',
                                'eng' => 'Prices are acceptable'
                            ),
                            'scale' => 5
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Preis-/Leistungsverhältnis',
                                'eng' => 'Value for money'
                            ),
                            'scale' => 5
                        )
                    )
                )
            )
        ),
        4 => array(
            'name' => array(
                'deu' => 'Bistro',
                'eng' => 'Bistro'
            ),
            'Groups' => array(
                1 => array(
                    'name' => array(
                        'deu' => 'Umfrage',
                        'eng' => 'Survey'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Auswahl Essen',
                                'eng' => 'Choice of food',
                            ),
                            'scale' => 6
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Qualität vom Essen',
                                'eng' => 'Quality of Food'
                            ),
                            'scale' => 6
                        ),
                        3 => array(
                            'question' => array(
                                'deu' => 'Frische',
                                'eng' => 'Freshness'
                            ),
                            'scale' => 6
                        ),
                        4 => array(
                            'question' => array(
                                'deu' => 'Personal',
                                'eng' => 'Service'
                            ),
                            'scale' => 6
                        ),
                        5 => array(
                            'question' => array(
                                'deu' => 'Preis',
                                'eng' => 'Price'
                            ),
                            'scale' => 6
                        ),
                        6 => array(
                            'question' => array(
                                'deu' => 'Gesamteindruck',
                                'eng' => 'Overall Impression'
                            ),
                            'scale' => 6
                        ),
                    )
                )
            )
        ),
        5 => array(
            'name' => array(
                'deu' => 'Café',
                'eng' => 'Café'
            ),
            'Groups' => array(
                1 => array(
                    'name' => array(
                        'deu' => 'Umfrage',
                        'eng' => 'Survey'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Auswahl Kaffee',
                                'eng' => 'Choice of coffee',
                            ),
                            'scale' => 6
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Qualität vom Kaffee',
                                'eng' => 'Quality of coffee'
                            ),
                            'scale' => 6
                        ),
                        3 => array(
                            'question' => array(
                                'deu' => 'Frische',
                                'eng' => 'Freshness'
                            ),
                            'scale' => 6
                        ),
                        4 => array(
                            'question' => array(
                                'deu' => 'Kreativität',
                                'eng' => 'Creativity'
                            ),
                            'scale' => 6
                        ),
                        5 => array(
                            'question' => array(
                                'deu' => 'Personal',
                                'eng' => 'Service'
                            ),
                            'scale' => 6
                        ),
                        6 => array(
                            'question' => array(
                                'deu' => 'Preis',
                                'eng' => 'Price'
                            ),
                            'scale' => 6
                        ),
                        7 => array(
                            'question' => array(
                                'deu' => 'Gesamteindruck',
                                'eng' => 'Overall Impression'
                            ),
                            'scale' => 6
                        ),
                    )
                )
            )
        ),
        6 => array(
            'name' => array(
                'deu' => 'Bar',
                'eng' => 'Bar'
            ),
            'Groups' => array(
                1 => array(
                    'name' => array(
                        'deu' => 'Umfrage',
                        'eng' => 'Survey'
                    ),
                    'Questions' => array(
                        1 => array(
                            'question' => array(
                                'deu' => 'Auswahl Getränken',
                                'eng' => 'Choice of drinks',
                            ),
                            'scale' => 6
                        ),
                        2 => array(
                            'question' => array(
                                'deu' => 'Qualität der Getränke',
                                'eng' => 'Quality of drinks'
                            ),
                            'scale' => 6
                        ),
                        3 => array(
                            'question' => array(
                                'deu' => 'Kreativität',
                                'eng' => 'Creativity'
                            ),
                            'scale' => 6
                        ),
                        4 => array(
                            'question' => array(
                                'deu' => 'Ambiente',
                                'eng' => 'Ambiance'
                            ),
                            'scale' => 6
                        ),
                        5 => array(
                            'question' => array(
                                'deu' => 'Publikum',
                                'eng' => 'Crowd'
                            ),
                            'scale' => 6
                        ),
                        6 => array(
                            'question' => array(
                                'deu' => 'Musik',
                                'eng' => 'Music'
                            ),
                            'scale' => 6
                        ),
                        7 => array(
                            'question' => array(
                                'deu' => 'Personal',
                                'eng' => 'Service'
                            ),
                            'scale' => 6
                        ),
                        8 => array(
                            'question' => array(
                                'deu' => 'Preis',
                                'eng' => 'Price'
                            ),
                            'scale' => 6
                        ),
                        9 => array(
                            'question' => array(
                                'deu' => 'Gesamteindruck',
                                'eng' => 'Overall Impression'
                            ),
                            'scale' => 6
                        ),
                    )
                )
            )
        )
    );


    /**
    * generate a unique API key for a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function generateApiKey($type = 'poll', $account_id = null, $host_id = null, $poll_id = null) {
        $api_key = substr(Security::hash(date('Y-m-d H:i:s') . $account_id . $host_id . $poll_id . rand(1,100)), 0, 10);
        return $api_key;
    }


    /**
    * generate a unique API secret for a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function generateApiSecret($type = 'poll', $account_id = null, $host_id = null, $poll_id = null) {
        $api_secret = substr(Security::hash(date('Y-m-d H:i:s') . $account_id . $host_id . $poll_id . rand(1,100)), 0, 20);
        return $api_secret;
    }


    /**
    * get a poll by api-key and secret
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function getPollByApiKeyAndSecret($api_key = null, $api_secret = null) {

        $poll = $this->find('first', array(
            'conditions' => array(
                'Poll.api_key' => $api_key,
                'Poll.api_secret' => $api_secret
            )
        ));

        return $poll;
    }


    /**
    * add a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function add($data = null) {
        if(!$data) {
            return false;
        }

        $this->Behaviors->disable('Translate');

        if(empty($data['Poll']['title'])) {
            $this->invalidate('title', __('Please enter a title for your poll!', true));
        }

        if(empty($data['Poll']['host_id'])) {
            $this->invalidate('host_id', __('Please select a host for your poll!', true));
        }

        if(empty($data['Poll']['code'])) {
            $this->invalidate('code', __('Please enter the pin-code your guests should use to rate your host!', true));
        } elseif(strlen($data['Poll']['code']) < 4) {
            $this->invalidate('code', __('Please use at least 5 digits for the pin-code to avoid unauthorized ratings!', true));
        }

        if(empty($data['Poll']['account_id'])) {
            $this->invalidate('account_id', __('You account id is NOT set!', true));
        }

        if($this->validates()) {

            if($this->addPollFromTemplate($data['Poll']['template_id'], $data)) {
                return true;
            }
        }

        return false;
    }

    /**
    * add a poll from a templaten given by its id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $template_id, mixed $data
    * @return boolean
    */
    public function addPollFromTemplate($template_id = null, $data = null) {

        $I18nModel = ClassRegistry::init('I18nModel');

        #$template = $this->templates[$template_id];
        $template = $this->getTemplate($template_id);

        $this->Behaviors->disable('Translate');

        $account_id = $data['Poll']['account_id'];
        $host_id    = $data['Poll']['host_id'];

        $poll = $data;

        $poll['Poll']['draft_id'] = $template_id;   // add the draft id which was used to generate the poll

        if(isset($data['Poll']['scale']) && (!empty($data['Poll']['scale']))) {
            $scale = $data['Poll']['scale'];
        } else {
            $scale = 4;
        }

        $unique = false;
        while(!$unique) {
            $poll['Poll']['hash'] = substr(Security::hash(strtotime(date("Y-m-d H:i:s")). md5(uniqid()), null, true), 0, 4);
            $check = $this->find('first', array(
                'conditions' => array(
                    'Poll.hash' => $poll['Poll']['hash']
                )
            ));
            if(empty($check)) {
                $unique = true;
            }
        }


        # will be dynamized soon....
        $poll['Poll']['theme_id']   = 1;
        $poll['Poll']['color']      = '000000';

        # check if it is the first poll for the account => set limit
        $poll['Poll']['limit'] = 50;
        $first_poll_id = $this->getFirstPollId($account_id);
        if(intval($first_poll_id) > 0) {
            $poll['Poll']['limit'] = 50;
        }

        $this->create();
        $this->save($poll);
        $poll_id = $this->id;

        # setup poll
        # build i18n records for poll
        $i18n = array();
        $i18n['I18nModel']['model'] = 'Poll';
        $i18n['I18nModel']['foreign_key'] = $poll_id;
        $i18n['I18nModel']['locale'] = 'deu';
        $i18n['I18nModel']['field'] = 'name';
        $i18n['I18nModel']['content'] = $template['name']['deu'];

        $I18nModel->create();
        $I18nModel->save($i18n);

        $i18n['I18nModel']['locale'] = 'eng';
        $i18n['I18nModel']['content'] = $template['name']['eng'];
        $I18nModel->create();
        $I18nModel->save($i18n);

        # add groups
        foreach($template['Groups'] as $order_group => $group_data) {

            $group = array();
            $group['Group']['poll_id']  = $poll_id;
            $group['Group']['order']    = $order_group;
            $group['Group']['status']   = 1;

            $this->Group->Behaviors->disable('Translate');
            $this->Group->create();
            $this->Group->save($group);

            $i18n = array();
            $i18n['I18nModel']['model']         = 'Group';
            $i18n['I18nModel']['foreign_key']   = $this->Group->id;
            $i18n['I18nModel']['locale']        = 'deu';
            $i18n['I18nModel']['field']         = 'name';
            $i18n['I18nModel']['content']       = $group_data['name']['deu'];

            $I18nModel->create();
            $I18nModel->save($i18n);

            $i18n['I18nModel']['locale']    = 'eng';
            $i18n['I18nModel']['content']   = $group_data['name']['eng'];
            $I18nModel->create();
            $I18nModel->save($i18n);


            foreach($group_data['Questions'] as $order_question => $question_data) {

                $question = array();
                $question['Question']['account_id'] = $account_id;
                $question['Question']['host_id']    = $host_id;
                $question['Question']['poll_id']    = $poll_id;
                $question['Question']['group_id']   = $this->Group->id;
                $question['Question']['order']      = $order_question;
                $question['Question']['scale']      = $scale;
                $question['Question']['status']     = 1;

                $this->Group->Question->Behaviors->disable('Translate');
                $this->Group->Question->create();
                $this->Group->Question->save($question);

                $i18n = array();
                $i18n['I18nModel']['model']         = 'Question';
                $i18n['I18nModel']['foreign_key']   = $this->Group->Question->id;
                $i18n['I18nModel']['locale']        = 'deu';
                $i18n['I18nModel']['field']         = 'question';
                $i18n['I18nModel']['content']       = $question_data['question']['deu'];

                $I18nModel->create();
                $I18nModel->save($i18n);

                $i18n['I18nModel']['locale']    = 'eng';
                $i18n['I18nModel']['content']   = $question_data['question']['eng'];
                $I18nModel->create();
                $I18nModel->save($i18n);

            }
        }

        return true;
    }

    /**
    * prebuild an array for a given type (and conditions)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return array $data
    */
    public function buildDataArray($type = null, $option = null, $date = null) {

        $data = array();

        if(!$date) {
            $date = CakeTime::format('Y-m-d', time());
        }

        switch($type) {
            case 'month':

                if(!empty($option) && ($option == 'last_30')) {
                    $day_last   = date('Y-m-d');
                    $day_first  = date('Y-m-d', strtotime($day_last . '- 29 days'));
                } else {
                    $day_first  = date('Y-m-01', strtotime($date));
                    $day_last   = date('Y-m-t', strtotime($date));
                }


                # inject first day
                $data[(strtotime($day_first))*1000] = array();

                for($i = 1; $i < 32; $i++) {
                    $day = date('Y-m-d', strtotime($day_first . '+ '.$i.'days'));
                    if($day <= $day_last) {
                        $data[(strtotime($day))*1000] = array();
                    }
                }

                break;

            case 'week':
                if(!empty($option) && ($option == 'last_7')) {
                    $today = CakeTime::format('Y-m-d', time());
                    $border  = date('Y-m-d', strtotime($today . '- 6 days'));
                    $week_array = array();
                    $week_array['week_start']   = $border;
                    $week_array['week_end']     = $today;
                } else {
                    $weeknumber = date('W', strtotime($date));
                    $year = date('Y', strtotime($date));
                    $week_array = $this->getStartAndEndDateFromWeeknumber($weeknumber, $year);
                }

                $data[(strtotime($week_array['week_start']))*1000] = array();
                for($i = 1; $i < 7; $i++) {
                    $day = date('Y-m-d', strtotime($week_array['week_start'] . '+ '.$i.'days'));
                    if($day <= $week_array['week_end']) {
                        $data[(strtotime($day))*1000] = array();
                    }
                }

                break;

            case 'day':
                $date = date('Y-m-d');
                $start = $date;

                $data[(strtotime($start))*1000] = array();

                for($i = 1; $i < 24; $i++) {
                    $hours = $i;
                    $time = date('Y-m-d H:i', strtotime($start . '+'.$hours.' hours'));

                    if($time <= date('Y-m-d H:i:s', strtotime($date.' 23:59:59'))) {
                        $data[(strtotime($time))*1000] = array();
                    }
                }
                break;

            case 'year':
                $date = date('Y-m-d');

                $month_first = date('Y-01', strtotime($date));
                $month_last = date('Y-12', strtotime($date));

                # inject first day
                $data[(strtotime($month_first))*1000] = array();


                for($i = 1; $i < 12; $i++) {
                    $month = date('Y-m', strtotime($month_first . '+ '.$i.'months'));
                    if($month <= $month_last) {
                        $data[(strtotime($month))*1000] = array();
                    }
                }
                break;
        }


        return $data;
    }

    /**
    * get the conditions for answer-search by
    * a given period (will be extended via date-passing soon)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $period
    * @return mixed $conditions
    */
    public function buildPeriodConditions($period = null, $option = null, $date = null) {

        $conditions = array();

        # use the current day (replace this with a given date!)
        if(!$date) {

            Configure::write('Config.timezone', 'America/New_York');
            // called as CakeTime
            App::uses('CakeTime', 'Utility');
            $now = date('Y-m-d');
            $date = CakeTime::format('Y-m-d', time());
            #$date = date('Y-m-d');
        }

        #pr($date);
        #exit;

        switch($period) {
            case 'day':
                $conditions['DATE(Answer.created)'] = $date;
                break;
            case 'week':
                if($option == 'last_7') {
                    $today = $date;
                    $border  = date('Y-m-d', strtotime($today . '- 6 days'));
                    $week_array = array();
                    $week_array['week_start']   = $border;
                    $week_array['week_end']     = $today;
                } else {
                    $weeknumber = date('W', strtotime($date));
                    $year = date('Y', strtotime($date));
                    $week_array = $this->getStartAndEndDateFromWeeknumber($weeknumber, $year);
                }

                $conditions['DATE(Answer.created) >='] = $week_array['week_start'];
                $conditions['DATE(Answer.created) <='] = $week_array['week_end'];

                break;
            case 'month':
                if($option == 'last_30') {
                    $end    = date('Y-m-d');
                    $begin  = date('Y-m-d', strtotime($end . '- 29 days'));

                    $conditions['DATE(Answer.created) >='] = $begin;
                    $conditions['DATE(Answer.created) <='] = $end;

                } else {

                    $year = date('Y', strtotime($date));
                    $month = date('m', strtotime($date));
                    $day_first = date('Y-m-01', strtotime($date));
                    $day_last = date('Y-m-t', strtotime($date));

                    $conditions['YEAR(Answer.created)'] = $year;
                    $conditions['MONTH(Answer.created)'] = $month;
                }

                break;
            case 'year':
                $conditions['YEAR(Answer.created)'] = date('Y', strtotime($date));
                break;
        }

        return $conditions;
    }


    /**
    * check if the account has at least one poll (not deleted)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return array
    */
    public function checkIfPollExists($account_id = null){
        if(!$account_id){
            return false;
        }

        $account_id = intval($account_id);
        //find the first not deleted poll of that account
        $poll = $this->find('first', array(
            'conditions' => array(
                'Poll.account_id' => $account_id,
                'Poll.deleted' => 0
            ),
            'order' => 'Poll.created ASC'
        ));

        //if a poll was found return true
        if(isset($poll['Poll']['id']) && !empty($poll['Poll']['id'])){
            return true;
        }

        return false;
    }


    /**
    * check if all questions were answered
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, mixed $data
    * @return boolean true or array $errors
    */
    public function checkMissingAnswers($poll_id = null, $data = null, $locale = null) {

        #$poll = $this->getPollForShow($poll_id);
        $poll = $this->getPoll($poll_id, $locale);

        $missing_question_ids = array();

        foreach($data['Poll']['answer'] as $question_id => $answer) {
            if(empty($answer)) {
                array_push($missing_question_ids, $question_id);
            }
        }

        if(!empty($missing_question_ids)) {
            return $missing_question_ids;
        } else {
            return false;
        }
    }


    /**
    * add a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function edit($data = null) {
        if(!$data || !isset($this->id)) {
            return false;
        }

        $this->Behaviors->disable('Translate');

        if(empty($data['Poll']['title'])) {
            $this->invalidate('title', __('Please enter a title for your poll!', true));
        }

        if(empty($data['Poll']['code'])) {
            $this->invalidate('code', __('Please enter the pin-code your guests should use to rate your host!', true));
        } elseif(strlen($data['Poll']['code']) < 4) {
            $this->invalidate('code', __('Please use at least 5 digits for the pin-code to avoid unauthorized ratings!', true));
        }

        if($this->validates()) {
            if($this->save($data)) {

                if(isset($data['Poll']['scale'])) {
                    $this->Question->Behaviors->disable('Translate');
                    $this->Question->updateAll(
                        array(
                            'Question.scale' => $data['Poll']['scale']
                        ),
                        array(
                            'Question.poll_id' => $this->id
                    ));
                }

                return true;
            }
        }

        return false;
    }

    /**
    * get the dashboard counts for admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return mixed $scorecard
    */
    public function getAdminDashboardCounts() {

        # presets
        $scorecard = array();
        $scorecard['guests']                = 0;
        $scorecard['polls']                 = 0;
        $scorecard['polls_premium']         = 0;
        $scorecard['polls_premium_active']  = 0;
        $scorecard['hosts']                 = 0;
        $scorecard['revenue']               = 0;


        # get the guest count by counting guests and throwing out all "manual"-added guests
        $User = ClassRegistry::init('User');
        $users = $User->find('all', array(
            'conditions' => array(
                'User.deleted' => 0
            ),
            'fields' => array(
                'User.user_pin'
            )
        ));
        $pins = Set::ClassicExtract($users, '{n}.User.user_pin');
        $scorecard['guests'] = $this->Guest->find('count', array(
            'conditions' => array(
                'Guest.deleted' => 0
            )
        ));
        $scorecard['guests_mobile'] = $this->Guest->find('count', array(
            'conditions' => array(
                'Guest.deleted' => 0,
                'NOT' => array(
                    'Guest.pin' => $pins
                )
            )
        ));
        $scorecard['guests_manual'] = $this->Guest->find('count', array(
            'conditions' => array(
                'Guest.deleted' => 0,
                'Guest.pin' => $pins
            )
        ));

        # get the global poll count
        $scorecard['polls'] = $this->find('count', array(
            'conditions' => array(
                'Poll.deleted' => 0
            )
        ));

        # polls -> premium: search by invoices (easiest approach)
        $invoices = $this->Invoice->find('all', array(
            'conditions' => array(
                'Invoice.status' => array(0,1,2),
            ),
            'fields' => array(
                'Invoice.poll_id',
                'Invoice.valid_until',
            )
        ));
        $poll_ids = Set::ClassicExtract($invoices, '{n}.Invoice.poll_id');
        if(is_array($poll_ids)) {
            $poll_ids = array_unique($poll_ids);
        } else {
            $poll_ids = array();
        }
        $scorecard['polls_premium'] = count($invoices);


        # polls -> premium and CURRENTLY ACTIVE
        $scorecard['polls_premium_active'] = 0;
        foreach($invoices as $invoice) {
            if($invoice['Invoice']['valid_until'] > date('Y-m-d H:i:s')) {
                $scorecard['polls_premium_active']++;
            }
        }

        # hosts -> global hosts count
        $scorecard['hosts'] = $this->Host->find('count', array(
            'conditions' => array(
                #'Host.deleted' => 0
            )
        ));

        # revenue: sum all invoices that are marked as PAID
        $invoices = $this->Invoice->find('all', array(
            'conditions' => array(
                'Invoice.status' => array(0,1,2),
            ),
            'fields' => array(
                'SUM(final_total) AS revenue'
            )
        ));

        $scorecard['revenue'] = $invoices[0][0]['revenue'];

        return $scorecard;
    }

    /**
    * get the first poll id of a given account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getFirstPollId($account_id = null) {

        $poll = $this->find('first', array(
            'conditions' => array(
                'Poll.account_id' => $account_id,
            ),
            'order' => 'Poll.created ASC'
        ));

        if(isset($poll['Poll']['id']) && !empty($poll['Poll']['id'])) {
            return $poll['Poll']['id'];
        }

        return false;
    }

    /**
    * get a pre-formatted dataset of answers
    * to use by the flot chart-plugin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getGroupAnswersDataset($group_id = null, $period = null, $locale = null, $option = null, $date = nulll) {

        $datasets = array();
        $datasets = new stdClass();

        $this->Group->Question->locale = $locale;

        $colors = Configure::read('Colors');

        $Answer = ClassRegistry::init('Answer');

        $i = 0;

        $questions = $this->Group->Question->find('all', array(
            'conditions' => array(
                'Question.group_id' => $group_id
            )
        ));

        $question_ids = Set::ClassicExtract($questions, '{n}.Question.id');

        $conditions = $this->buildPeriodConditions($period, $option, $date);
        $conditions['Answer.status'] = 1;

        # iterate through questions (belonging to given group)
        foreach($question_ids as $key => $question_id) {

            # get the question record (we need the label and some other data...)
            $question = $this->Group->Question->find('first', array(
                'conditions' => array(
                    'Question.deleted' => 0,
                    'Question.id' => $question_id,
                    'Question.deleted' => 0,
                )
            ));

            # merge conditions (period + question_id)
            $conditions = array_merge(
                $conditions,
                array(
                    'Answer.question_id' => $question_id
                )
            );

            # get all answers for the given period and question (by id)
            $answers = $Answer->find('all', array(
                'conditions' => $conditions
            ));

            # build an "empty" holder-array for the data-subsets
            $data = $this->buildDataArray($period, $option, $date);

            # add all ratings to the holder-array
            if($period == 'day') {
                foreach($answers as $answer) {
                    if(isset($data[(strtotime(CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))))*1000])) {
                        array_push($data[(strtotime(CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                    } else {
                        $data[(strtotime(CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))))*1000] = array();
                        #pr(date('Y-m-d H:i', strtotime($answer['Answer']['created'].':00')));
                        array_push($data[(strtotime(CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                    }
                }
            } elseif($period == 'year') {
                foreach($answers as $answer) {
                    if(isset($data[(strtotime(CakeTime::format('Y-m', strtotime($answer['Answer']['created']))))*1000])) {
                        array_push($data[(strtotime(CakeTime::format('Y-m', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                    } else {
                        $data[(strtotime(CakeTime::format('Y-m', strtotime($answer['Answer']['created']))))*1000] = array();
                        array_push($data[(strtotime(CakeTime::format('Y-m', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                    }
                }
            } else {
                foreach($answers as $answer) {
                    /*
                    if(isset($data[(strtotime(date('Y-m-d', strtotime($answer['Answer']['created']))))*1000])) {
                        array_push($data[(strtotime(date('Y-m-d', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                    } else {
                        $data[(strtotime(date('Y-m-d', strtotime($answer['Answer']['created']))))*1000] = array();
                        array_push($data[(strtotime(date('Y-m-d', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                    }
                    */

                    if(isset($data[(strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))))*1000])) {
                        array_push($data[(strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                    } else {
                        $data[(strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))))*1000] = array();
                        array_push($data[(strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                    }
                    #$date = CakeTime::format('Y-m-d', time());
                }

            }

            #arsort($data);
            #pr($data);
            #exit;

            # prepare the real data-subset with timestamp and average rating
            $data_prepared = array();
            foreach($data as $timestamp => $ratings) {
                $ratings_avg = 0;
                foreach($ratings as $rate) {
                    $ratings_avg += $rate;
                }
                if(count($ratings) > 0) {
                    $ratings_avg = round($ratings_avg/count($ratings), 1);
                } else {
                    $ratings_avg = 0;
                }
                array_push($data_prepared, array($timestamp, $ratings_avg));
            }

            # build the complete dataset record (series)
            $set = array();
            $set['label'] = $question['Question']['question'];

            if(($i == 0) && ($period == 'week')) {
                $set['xaxis'] = 2;
            }

            $set['color'] = $colors[$i];

            $set['data'] = $data_prepared;

            $set['points'] = new stdClass();
            $set['points']->fillColor = '#ffffff';
            $set['points']->radius = 4;

            $set['points']->show = true;
            $set['points']->shadow = true;

            $set['lines'] = new stdClass();
            $set['lines']->show = true;
            $set['lines']->lineWidth = 3;

            $i++;

            $datasets->$question_id = $set;
        }

        #pr($datasets);
        #exit;

        return $datasets;
    }

    /**
    * get a pre-formatted dataset of answers
    * to use by the flot chart-plugin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getGroupAnswersDatasetDay($group_id = null, $locale = null, $date = nulll) {


        $datasets = new stdClass();

        $this->Group->Question->locale = $locale;

        $colors = Configure::read('Colors');

        $Answer = ClassRegistry::init('Answer');

        $i = 0;

        $questions = $this->Group->Question->find('all', array(
            'conditions' => array(
                'Question.group_id' => $group_id
            )
        ));

        $question_ids = Set::ClassicExtract($questions, '{n}.Question.id');

        $conditions = $this->buildPeriodConditions('day', null, $date);
        $conditions['Answer.status'] = 1;

        # iterate through questions (belonging to given group)
        foreach($question_ids as $key => $question_id) {

            # get the question record (we need the label and some other data...)
            $question = $this->Group->Question->find('first', array(
                'conditions' => array(
                    'Question.deleted' => 0,
                    'Question.id' => $question_id,
                    'Question.deleted' => 0,
                )
            ));

            # merge conditions (period + question_id)
            $conditions = array_merge(
                $conditions,
                array(
                    'Answer.question_id' => $question_id
                )
            );

            # get all answers for the given period and question (by id)
            $answers = $Answer->find('all', array(
                'conditions' => $conditions
            ));

            # build an "empty" holder-array for the data-subsets
            $data = array();

            $start = $date;

            $data[(strtotime($start))*1000] = array();

            for($hour = 1; $hour < 24; $hour++) {
                $hours = $hour;
                $time = date('Y-m-d H:i', strtotime($start . '+'.$hours.' hours'));

                if($time <= date('Y-m-d H:s', strtotime($date.' 23:59:59'))) {
                    $data[(strtotime($time))*1000] = array();
                }
            }


            # add all ratings to the holder-array
            foreach($answers as $answer) {
                if(isset($data[(strtotime(CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))))*1000])) {
                    array_push($data[(strtotime(CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                } else {
                    $data[(strtotime(CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))))*1000] = array();
                    #pr(date('Y-m-d H:i', strtotime($answer['Answer']['created'].':00')));
                    array_push($data[(strtotime(CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                }
            }

            # prepare the real data-subset with timestamp and average rating
            $data_prepared = array();
            foreach($data as $timestamp => $ratings) {
                $ratings_avg = 0;
                foreach($ratings as $rate) {
                    $ratings_avg += $rate;
                }
                if(count($ratings) > 0) {
                    $ratings_avg = round($ratings_avg/count($ratings), 1);
                } else {
                    $ratings_avg = 0;
                }
                array_push($data_prepared, array($timestamp, $ratings_avg));
            }

            # build the complete dataset record (series)
            $set = array();
            #$set['label'] = $question['Question']['question'].'__'.$question['Question']['id'];
            $set['label'] = $question['Question']['question'];

            if($i == 0) {
                #$set['xaxis'] = 2;
            }

            $set['color'] = $colors[$i];

            $set['data'] = $data_prepared;

            $set['points'] = new stdClass();
            $set['points']->fillColor = '#ffffff';
            $set['points']->radius = 4;
            $set['points']->show = true;
            $set['points']->shadow = false;

            $set['lines'] = new stdClass();
            $set['lines']->show = true;
            $set['lines']->shadow = false;
            $set['lines']->lineWidth = 3;

            $i++;

            $datasets->$question_id = $set;
        }

        return $datasets;
    }

    /**
    * get a pre-formatted dataset of answers
    * to use by the flot chart-plugin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getGroupAnswersDatasetLast30($group_id = null, $locale = null, $date = null) {

        $datasets = array();
        $datasets = new stdClass();

        $this->Group->Question->locale = $locale;

        $colors = Configure::read('Colors');

        $Answer = ClassRegistry::init('Answer');

        $i = 0;

        $questions = $this->Group->Question->find('all', array(
            'conditions' => array(
                'Question.group_id' => $group_id
            )
        ));

        $question_ids = Set::ClassicExtract($questions, '{n}.Question.id');

        #$conditions = $this->buildPeriodConditions($period, $option, $date);


        $date_end = CakeTime::format('Y-m-d', strtotime($date));
        $date_start   = CakeTime::format('Y-m-d', strtotime($date . ' -29days'));

        $conditions = array();
        $conditions['DATE(Answer.created) >='] = $date_start;
        $conditions['DATE(Answer.created) <='] = $date_end;
        $conditions['Answer.status'] = 1;


        # iterate through questions (belonging to given group)
        foreach($question_ids as $key => $question_id) {

            # get the question record (we need the label and some other data...)
            $question = $this->Group->Question->find('first', array(
                'conditions' => array(
                    'Question.deleted' => 0,
                    'Question.id' => $question_id,
                    'Question.deleted' => 0,
                )
            ));

            # merge conditions (period + question_id)
            $conditions = array_merge(
                $conditions,
                array(
                    'Answer.question_id' => $question_id
                )
            );

            # get all answers for the given period and question (by id)
            $answers = $Answer->find('all', array(
                'conditions' => $conditions
            ));

            $day_first  = $date_start;
            $day_last   = $date_end;

            # inject first day
            $data[(strtotime($day_first))*1000] = array();

            for($j = 0; $j < 31; $j++) {
                $day = CakeTime::format('Y-m-d', strtotime($day_first . '+ '.$j.' days'));
                if($day <= $day_last) {
                    $data[(strtotime($day))*1000] = array();
                }
            }

            foreach($answers as $answer) {
                if(isset($data[(strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))))*1000])) {
                    array_push($data[(strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                } else {
                    $data[(strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))))*1000] = array();
                    array_push($data[(strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))))*1000], (int)$answer['Answer']['rating']);
                }
            }

            # prepare the real data-subset with timestamp and average rating
            $data_prepared = array();
            foreach($data as $timestamp => $ratings) {
                $ratings_avg = 0;
                foreach($ratings as $rate) {
                    $ratings_avg += $rate;
                }
                if(count($ratings) > 0) {
                    $ratings_avg = round($ratings_avg/count($ratings), 1);
                } else {
                    $ratings_avg = 0;
                }
                array_push($data_prepared, array($timestamp, $ratings_avg));
            }


            # build the complete dataset record (series)
            $set = array();
            $set['label'] = $question['Question']['question'];

            if($i == 0) {
                #$set['xaxis'] = 2;
            }

            $set['color'] = $colors[$i];

            $set['data'] = $data_prepared;

            $set['points'] = new stdClass();
            $set['points']->fillColor = '#ffffff';
            $set['points']->radius = 4;
            $set['points']->show = true;
            $set['points']->shadow = true;

            $set['lines'] = new stdClass();
            $set['lines']->show = true;
            $set['lines']->lineWidth = 3;

            $datasets->$question_id = $set;
            $i++;
        }

        #exit;

        #pr($datasets);
        #exit;

        return $datasets;
    }

    /**
    * get a pre-formatted dataset of answers
    * to use by the flot chart-plugin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getGroupAnswersDatasetMonth($group_id = null, $locale = null, $year_month = null) {

        $datasets = array();
        $datasets = new stdClass();

        $this->Group->Question->locale = $locale;

        $colors = Configure::read('Colors');

        $Answer = ClassRegistry::init('Answer');

        $i = 0;

        $questions = $this->Group->Question->find('all', array(
            'conditions' => array(
                'Question.group_id' => $group_id
            )
        ));

        $question_ids = Set::ClassicExtract($questions, '{n}.Question.id');

        #$conditions = $this->buildPeriodConditions($period, $option, $date);


        $year = CakeTime::format('Y', strtotime($year_month));
        $month = CakeTime::format('m', strtotime($year_month));

        $conditions = array();
        $conditions['YEAR(Answer.created)'] = $year;
        $conditions['MONTH(Answer.created)'] = $month;
        $conditions['Answer.status'] = 1;


        # iterate through questions (belonging to given group)
        foreach($question_ids as $key => $question_id) {

            # get the question record (we need the label and some other data...)
            $question = $this->Group->Question->find('first', array(
                'conditions' => array(
                    'Question.deleted' => 0,
                    'Question.id' => $question_id,
                    'Question.deleted' => 0,
                )
            ));

            # merge conditions (period + question_id)
            $conditions = array_merge(
                $conditions,
                array(
                    'Answer.question_id' => $question_id
                )
            );

            # get all answers for the given period and question (by id)
            $answers = $Answer->find('all', array(
                'conditions' => $conditions
            ));

            $day_first  = CakeTime::format('Y-m-01', strtotime($year_month));
            $day_last   = CakeTime::format('Y-m-t', strtotime($year_month));

            # inject first day
            $data[strtotime($day_first)*1000] = array();

            for($j = 0; $j < 31; $j++) {
                $day = CakeTime::format('Y-m-d', strtotime($day_first . '+ '.$j.' days'));
                #pr($day);
                if($day <= $day_last) {
                    $data[strtotime($day)*1000] = array();
                }
            }
            #exit;


            foreach($answers as $answer) {
                if(isset($data[strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created'])))*1000])) {
                    array_push($data[strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created'])))*1000], (int)$answer['Answer']['rating']);
                } else {
                    $data[strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created'])))*1000] = array();
                    array_push($data[strtotime(CakeTime::format('Y-m-d', strtotime($answer['Answer']['created'])))*1000], (int)$answer['Answer']['rating']);
                }
            }

            # prepare the real data-subset with timestamp and average rating
            $data_prepared = array();
            foreach($data as $timestamp => $ratings) {
                $ratings_avg = 0;
                foreach($ratings as $rate) {
                    $ratings_avg += $rate;
                }
                if(count($ratings) > 0) {
                    $ratings_avg = round($ratings_avg/count($ratings), 1);
                } else {
                    $ratings_avg = 0;
                }
                array_push($data_prepared, array($timestamp, $ratings_avg));
            }


            # build the complete dataset record (series)
            $set = array();
            $set['label'] = $question['Question']['question'];

            if($i == 0) {
                #$set['xaxis'] = 2;
            }

            $set['color'] = $colors[$i];

            $set['data'] = $data_prepared;

            $set['points'] = new stdClass();
            $set['points']->fillColor = '#ffffff';
            $set['points']->radius = 4;
            $set['points']->show = true;
            $set['points']->shadow = true;

            $set['lines'] = new stdClass();
            $set['lines']->show = true;
            $set['lines']->lineWidth = 3;

            $i++;

            $datasets->$question_id = $set;
        }

        #exit;

        #pr($datasets);
        #exit;

        return $datasets;
    }

    /**
    * get a pre-formatted dataset of answers
    * to use by the flot chart-plugin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getGroupAnswersDatasetWeek($group_id = null, $locale = null, $year = null, $weeknumber = nulll) {

        $datasets = array();
        $datasets = new stdClass();

        $this->Group->Question->locale = $locale;

        $colors = Configure::read('Colors');

        $Answer = ClassRegistry::init('Answer');

        $i = 0;

        $questions = $this->Group->Question->find('all', array(
            'conditions' => array(
                'Question.group_id' => $group_id
            )
        ));

        $question_ids = Set::ClassicExtract($questions, '{n}.Question.id');

        #$conditions = $this->buildPeriodConditions($period, $option, $date);

        $weeknumber = sprintf("%02u", $weeknumber);

        $week_start = date( "Y-m-d", strtotime($year."W".$weeknumber."1")); // First day of week
        $week_end   = date( "Y-m-d", strtotime($year."W".$weeknumber."7") );

        $conditions['DATE(Answer.created) >='] = $week_start;
        $conditions['DATE(Answer.created) <='] = $week_end;
        $conditions['Answer.status'] = 1;

        # iterate through questions (belonging to given group)
        foreach($question_ids as $key => $question_id) {

            # get the question record (we need the label and some other data...)
            $question = $this->Group->Question->find('first', array(
                'conditions' => array(
                    'Question.deleted' => 0,
                    'Question.id' => $question_id,
                    'Question.deleted' => 0,
                )
            ));

            # merge conditions (period + question_id)
            $conditions = array_merge(
                $conditions,
                array(
                    'Answer.question_id' => $question_id
                )
            );

            # get all answers for the given period and question (by id)
            $answers = $Answer->find('all', array(
                'conditions' => $conditions
            ));

            # build an "empty" holder-array for the data-subsets
            #$data = $this->buildDataArray($period, $option, $date);
            $data = array();
            $data[strtotime($week_start)*1000] = array();
            for($days = 1; $days < 7; $days++) {
                $day = date('Y-m-d', strtotime($week_start . '+ '.$days.'days'));
                if($day <= $week_end) {
                    $data[strtotime($day)*1000] = array();
                }
            }

            foreach($answers as $answer) {
                if(isset($data[strtotime(date('Y-m-d', strtotime($answer['Answer']['created'])))*1000])) {
                    array_push($data[strtotime(date('Y-m-d', strtotime($answer['Answer']['created'])))*1000], (int)$answer['Answer']['rating']);
                } else {
                    $data[strtotime(date('Y-m-d', strtotime($answer['Answer']['created'])))*1000] = array();
                    array_push($data[strtotime(date('Y-m-d', strtotime($answer['Answer']['created'])))*1000], (int)$answer['Answer']['rating']);
                }
            }

            # prepare the real data-subset with timestamp and average rating
            $data_prepared = array();
            foreach($data as $timestamp => $ratings) {
                $ratings_avg = 0;
                foreach($ratings as $rate) {
                    $ratings_avg += $rate;
                }
                if(count($ratings) > 0) {
                    $ratings_avg = round($ratings_avg/count($ratings), 1);
                } else {
                    $ratings_avg = 0;
                }
                array_push($data_prepared, array($timestamp, $ratings_avg));
            }

            # build the complete dataset record (series)
            $set = array();
            $set['label'] = $question['Question']['question'];

            if($i == 0) {
                #$set['xaxis'] = 2;
            }

            $set['color'] = $colors[$i];

            $set['data'] = $data_prepared;

            $set['points'] = new stdClass();
            $set['points']->fillColor = '#ffffff';
            $set['points']->radius = 4;
            $set['points']->show = true;
            $set['points']->shadow = true;

            $set['lines'] = new stdClass();
            $set['lines']->show = true;
            $set['lines']->lineWidth = 3;

            $i++;

            $datasets->$question_id = $set;
        }

        #exit;

        #pr($datasets);
        #exit;

        return $datasets;
    }

    /**
    * get a pre-formatted dataset of answers
    * to use by the flot chart-plugin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getGroupAnswersDatasetYear($group_id = null, $locale = null, $year = null) {

        $datasets = array();
        $datasets = new stdClass();

        $this->Group->Question->locale = $locale;

        $colors = Configure::read('Colors');

        $Answer = ClassRegistry::init('Answer');

        $i = 0;

        $questions = $this->Group->Question->find('all', array(
            'conditions' => array(
                'Question.group_id' => $group_id
            )
        ));

        $question_ids = Set::ClassicExtract($questions, '{n}.Question.id');

        $conditions = array();
        $conditions['YEAR(Answer.created)'] = $year;
        $conditions['Answer.status'] = 1;


        # iterate through questions (belonging to given group)
        foreach($question_ids as $key => $question_id) {

            # get the question record (we need the label and some other data...)
            $question = $this->Group->Question->find('first', array(
                'conditions' => array(
                    'Question.deleted' => 0,
                    'Question.id' => $question_id,
                    'Question.deleted' => 0,
                )
            ));

            # merge conditions (period + question_id)
            $conditions = array_merge(
                $conditions,
                array(
                    'Answer.question_id' => $question_id
                )
            );

            # get all answers for the given period and question (by id)
            $answers = $Answer->find('all', array(
                'conditions' => $conditions
            ));

            $month_first = $year.'-01';
            $month_last = $year.'-12';

            # inject first day
            $data[strtotime($month_first)*1000] = array();

            for($j = 1; $j < 12; $j++) {
                $month = date('Y-m', strtotime($month_first . '+ '.$j.'months'));
                if($month <= $month_last) {
                    $data[strtotime($month)*1000] = array();
                }
            }

            foreach($answers as $answer) {
                if(isset($data[strtotime(date('Y-m', strtotime($answer['Answer']['created'])))*1000])) {
                    array_push($data[strtotime(date('Y-m', strtotime($answer['Answer']['created'])))*1000], (int)$answer['Answer']['rating']);
                } else {
                    $data[strtotime(date('Y-m', strtotime($answer['Answer']['created'])))*1000] = array();
                    array_push($data[strtotime(date('Y-m', strtotime($answer['Answer']['created'])))*1000], (int)$answer['Answer']['rating']);
                }
            }

            # prepare the real data-subset with timestamp and average rating
            $data_prepared = array();
            foreach($data as $timestamp => $ratings) {
                $ratings_avg = 0;
                foreach($ratings as $rate) {
                    $ratings_avg += $rate;
                }
                if(count($ratings) > 0) {
                    $ratings_avg = round($ratings_avg/count($ratings), 1);
                } else {
                    $ratings_avg = 0;
                }
                array_push($data_prepared, array($timestamp, $ratings_avg));
            }


            # build the complete dataset record (series)
            $set = array();
            $set['label'] = $question['Question']['question'];

            if($i == 0) {
                #$set['xaxis'] = 2;
            }

            $set['color'] = $colors[$i];

            $set['data'] = $data_prepared;

            $set['points'] = new stdClass();
            $set['points']->fillColor = '#ffffff';
            $set['points']->radius = 4;
            $set['points']->show = true;
            $set['points']->shadow = true;

            $set['lines'] = new stdClass();
            $set['lines']->show = true;
            $set['lines']->lineWidth = 3;

            $i++;

            $datasets->$question_id = $set;
        }

        #exit;

        #pr($datasets);
        #exit;

        return $datasets;
    }

    /**
    * get a list of groups for a given poll by its id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $locale
    * @return array
    */
    public function getGrouplist($poll_id = null, $locale = null) {
        if(!$poll_id) {
            return array();
        }

        if(!$locale) {
            $locale = Configure::read('Language.default');
        }

        $this->Group->locale = $locale;

        $groups = $this->Group->find('list', array(
            'conditions' => array(
                'Group.poll_id' => $poll_id
            ),
            'order' => 'Group.id ASC'
        ));

        return $groups;
    }

    /**
    * get an array of options for visit amounts
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getGuestTypes() {
        return array(
            1 => __('This is my first visit', true),
            2 => __('I am rarely here', true),
            3 => __('I am occasionally here', true),
            4 => __('I am a regular guest', true)
        );
    }

    /**
    * get all invoices belonging to a given poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return mixed $invoices
    */
    public function getInvoices($poll_id = null) {
        if(!$poll_id) {
            return array();
        }

        $invoices = $this->Invoice->find('all', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.poll_id' => $poll_id,
            ),
            'order' => 'Invoice.created DESC'
        ));

        return $invoices;
    }


    public function getConversionRatesAdmin() {

        $conversion_rates = array();
        $conversion_rates['today'] = 0;
        $conversion_rates['last_7'] = 0;
        $conversion_rates['last_30'] = 0;
        $conversion_rates['this_year'] = 0;

        $conversion_rates['yesterday'] = 0;
        $conversion_rates['last_7_before'] = 0;
        $conversion_rates['last_30_before'] = 0;
        $conversion_rates['last_year'] = 0;

        # today
        $conditions = array();
        $conditions['DATE(PollsView.created)'] = date('Y-m-d');

        $views = $this->PollsView->find('count', array(
            'conditions' => $conditions
        ));

        $conditions = array();
        $conditions['DATE(Guest.created)'] = date('Y-m-d');;
        $conditions['Guest.status'] = 1;

        $guests = $this->Answer->Guest->find('count', array(
            'conditions' => $conditions
        ));
        if(!empty($views)) {
            $conversion_rates['today'] = round($guests/$views * 100, 2);
        } else {
            $conversion_rates['today'] = '0';
        }


        # yesterday
        $conditions = array();
        $conditions['DATE(PollsView.created)'] = date('Y-m-d', strtotime('- 1 day'));

        $views = $this->PollsView->find('count', array(
            'conditions' => $conditions
        ));

        $conditions = array();
        $conditions['DATE(Guest.created)'] = date('Y-m-d', strtotime('- 1 day'));
        $conditions['Guest.status'] = 1;

        $guests = $this->Answer->Guest->find('count', array(
            'conditions' => $conditions
        ));
        if(!empty($views)) {
            $conversion_rates['yesterday'] = round($guests/$views * 100, 2);
        } else {
            $conversion_rates['yesterday'] = '0';
        }


        # last 7 days
        $day_last = date('Y-m-d');
        $day_first  = date('Y-m-d', strtotime($day_last . '- 6 days'));

        $conditions = array();
        $conditions['DATE(PollsView.created) >='] = $day_first;
        $conditions['DATE(PollsView.created) <='] = $day_last;

        $views = $this->PollsView->find('count', array(
            'conditions' => $conditions
        ));

        $conditions = array();
        $conditions['DATE(Guest.created) >='] = $day_first;
        $conditions['DATE(Guest.created) <='] = $day_last;
        $conditions['Guest.status'] = 1;

        $guests = $this->Answer->Guest->find('count', array(
            'conditions' => $conditions
        ));
        if(!empty($views)) {
            $conversion_rates['last_7'] = round($guests/$views * 100, 2);
        } else {
            $conversion_rates['last_7'] = '--';
        }


        # last 30 days
        $day_last = date('Y-m-d');
        $day_first  = date('Y-m-d', strtotime($day_last . '- 29 days'));

        $conditions = array();
        $conditions['DATE(PollsView.created) >='] = $day_first;
        $conditions['DATE(PollsView.created) <='] = $day_last;

        $views = $this->PollsView->find('count', array(
            'conditions' => $conditions
        ));

        $conditions = array();
        $conditions['DATE(Guest.created) >='] = $day_first;
        $conditions['DATE(Guest.created) <='] = $day_last;
        $conditions['Guest.status'] = 1;

        $guests = $this->Answer->Guest->find('count', array(
            'conditions' => $conditions
        ));
        if(!empty($views)) {
            $conversion_rates['last_30'] = round($guests/$views * 100, 2);
        } else {
            $conversion_rates['last_30'] = '--';
        }


        # this year
        $conditions = array();
        $conditions['YEAR(PollsView.created)'] = date('Y');

        $views = $this->PollsView->find('count', array(
            'conditions' => $conditions
        ));

        $conditions = array();
        $conditions['YEAR(Guest.created)'] = date('Y');
        $conditions['Guest.status'] = 1;

        $guests = $this->Answer->Guest->find('count', array(
            'conditions' => $conditions
        ));


        if(!empty($views)) {
            $conversion_rates['this_year'] = round($guests/$views * 100, 2);
        } else {
            $conversion_rates['this_year'] = '--';
        }


        # last year
        $conditions = array();
        $conditions['YEAR(PollsView.created)'] = date('Y') - 1;

        $views = $this->PollsView->find('count', array(
            'conditions' => $conditions
        ));

        $conditions = array();
        $conditions['YEAR(Guest.created)'] = date('Y') - 1;
        $conditions['Guest.status'] = 1;

        $guests = $this->Answer->Guest->find('count', array(
            'conditions' => $conditions
        ));
        if(!empty($views)) {
            $conversion_rates['last_year'] = round($guests/$views * 100, 2);
        } else {
            $conversion_rates['last_year'] = '0';
        }

        return $conversion_rates;
    }


    /**
    * get an overall rating chart for the last 7 days
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getLast30StatsAdmin() {

        $holder_object = new stdClass();

        $day_last = date('Y-m-d');
        $day_first  = date('Y-m-d', strtotime($day_last . '- 29 days'));

        $conditions = array();
        $conditions['DATE(PollsView.created) >='] = $day_first;
        $conditions['DATE(PollsView.created) <='] = $day_last;

        $views = $this->PollsView->find('all', array(
            'conditions' => $conditions
        ));


        # predefine the resultset (we need a set of 30 timestamps here!)
        $result = array();
        for($i = 0; $i <= 30; $i++) {
            $date = date('Y-m-d', strtotime($day_first . '+ '.$i.' days'));
            if($date <= $day_last) {
                $result[strtotime($date)*1000] = 0;
            }
        }

        foreach($views as $view) {
            $result[strtotime(date('Y-m-d', strtotime($view['PollsView']['created'])))*1000]++;
        }

        # build the actual dataset
        $dataset = array();
        foreach($result as $timestamp => $view_count) {
            array_push($dataset, array($timestamp, $view_count));
        }


        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Views', true);

        $set['xaxis'] = 1;

        // $set['color'] = '#333';
        $set['data'] = $dataset;

        // $set['points'] = new stdClass();
        // $set['points']->fillColor = '#FFF';
        // $set['points']->show = true;
        // $set['points']->shadow = true;

        // $set['lines'] = new stdClass();
        // $set['lines']->fillColor = '#DDD';
        // $set['lines']->show = true;

        $i = 1;
        $holder_object->$i = $set;





        $conditions = array();
        $conditions['DATE(Guest.created) >='] = $day_first;
        $conditions['DATE(Guest.created) <='] = $day_last;
        $conditions['Guest.status'] = 1;

        $guests = $this->Answer->Guest->find('all', array(
            'conditions' => $conditions
        ));


        # predefine the resultset (we need a set of 30 timestamps here!)
        $result = array();
        for($i = 0; $i <= 30; $i++) {
            $date = date('Y-m-d', strtotime($day_first . '+ '.$i.' days'));
            if($date <= $day_last) {
                $result[strtotime($date)*1000] = 0;
            }
        }

        foreach($guests as $guest) {
            $result[strtotime(date('Y-m-d', strtotime($guest['Guest']['created'])))*1000]++;
        }

        # build the actual dataset
        $dataset = array();
        foreach($result as $timestamp => $view_count) {
            array_push($dataset, array($timestamp, $view_count));
        }


        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Ratings', true);
        $set['xaxis'] = 1;

        // $set['color'] = '#428BCA';
        $set['data'] = $dataset;

        // $set['points'] = new stdClass();
        // $set['points']->fillColor = '#FFF';
        // $set['points']->show = true;
        // $set['points']->shadow = true;

        // $set['lines'] = new stdClass();
        // $set['lines']->fillColor = '#BBDDFA';
        // $set['lines']->show = true;

        $i = 2;
        $holder_object->$i = $set;

        return $holder_object;
    }

    /**
    * get the latest invoice of a given poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return mixed $invoice
    */
    public function getLatestInvoice($poll_id = null) {
        if(!$poll_id) {
            return array();
        }

        $invoice = $this->Invoice->find('first', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.status' => array(0, 1, 2),
                'Invoice.poll_id' => $poll_id
            ),
            'order' => 'Invoice.created DESC'
        ));

        return $invoice;
    }

    /**
    * get the latest upgrade of a given poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return mixed $invoice
    */
    public function getLatestUpgrade($poll_id = null) {
        if(!$poll_id) {
            return array();
        }

        $valid_from = date('Y-m-d H:i:s');

        $record = array();

        $invoice = $this->Invoice->find('first', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.poll_id' => $poll_id,
                'Invoice.status' => array(0, 1, 2),
                'Invoice.valid_until >' => date('Y-m-d H:i:s')
            ),
            'order' => 'Invoice.created DESC'
        ));

        $upgrade = $this->Upgrade->find('first', array(
            'conditions' => array(
                'Upgrade.deleted' => 0,
                'Upgrade.poll_id' => $poll_id,
                'Upgrade.valid_until >' => date('Y-m-d H:i:s')
            ),
            'order' => 'Upgrade.created DESC'
        ));

        if(empty($invoice) && empty($upgrade)) {
            return array();
        }

        if(!empty($invoice) && empty($upgrade)) {
            $record = $invoice['Invoice'];
        }

        if(empty($invoice) && !empty($upgrade)) {
            $record = $upgrade['Upgrade'];
        }

        if(!empty($invoice) && !empty($upgrade)) {
            if($invoice['Invoice']['valid_until'] > $upgrade['Upgrade']['valid_until']) {
                $record = $invoice['Invoice'];
            } else {
                $record = $upgrade['Upgrade'];
            }
        }

        return $record;
    }

    /**
    * get an overall rating chart for a given month
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $type
    * @return object $holder_object
    */
    public function getOverallAverageChartDay($poll_id = null, $type = null, $date = null) {

        $date_start = $date.' 00:00';

        $conditions['DATE(Answer.created)'] = $date;
        $conditions['Answer.poll_id']       = $poll_id;
        $conditions['Answer.status']        = 1;

        $answers = $this->Answer->find('all', array(
            'conditions' => $conditions
        ));

        $question_ids   = array();

        $result = array();

        $dataset = array();

        $check = array();

        for($i = 0; $i < 24; $i++) {
            $hour_target = date('Y-m-d H:00', strtotime($date_start . '+ '.$i.' hours'));   // do NOT shift here otherwise array breaks!
            $result[strtotime($hour_target)*1000] = 0;
            $check[$hour_target] = 0;
        }

        $poll = $this->getPoll($poll_id);
        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $preresult = array();

        foreach($answers as $answer) {

            if(!isset($preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))])) {
                $preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))] = array();
                $check[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))] = array();
            }
            if(!in_array($answer['Answer']['question_id'], $question_ids)) {
                array_push($question_ids, $answer['Answer']['question_id']);
            }

            if(!isset($preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))]['rating'])) {
                $preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))]['rating'] = 0;
            }

            $preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))]['rating'] += $answer['Answer']['rating'];

            if(!isset($preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))]['guests'])) {
                $preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))]['guests'] = array();
            }
            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }

            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m-d H:00', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }
        }

        # inject question_ids
        foreach($preresult as $key => $res) {
            $preresult[$key]['questions'] = $question_ids;
            $preresult[$key]['average'] = ($res['rating']/count($question_ids))/count($res['guests']);

            $result[strtotime($key)*1000] = round($preresult[$key]['average'], 2);

            $check[$key] = round($preresult[$key]['average'], 2);

            //array_push($dataset, array(strtotime($key)*1000, round($preresult[$key]['average'], 2)));
        }

        // sort the array by key because php/flot is a bitch...
        ksort($result);

        foreach($result as $timestamp => $average) {
            array_push($dataset, array($timestamp, $average));
        }

        $holder_object = new stdClass();

        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Overall average', true);

        $set['xaxis'] = 1;

        $set['color'] = '#333';
        $set['data'] = $dataset;

        $set['points'] = new stdClass();
        $set['points']->fillColor = '#FFF';
        $set['points']->show = true;
        $set['points']->shadow = true;

        $set['lines'] = new stdClass();
        $set['lines']->fillColor = '#DDD';
        $set['lines']->show = true;

        $i = 1;     // only one series will be plot here
        $holder_object->$i = $set;

        return $holder_object;
    }

    /**
    * get an overall rating chart for the last 7 days
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getOverallAverageChartLast30($poll_id = null, $type = null) {

        $date_end = CakeTime::format('Y-m-d', time());
        $date_start  = CakeTime::format('Y-m-d', strtotime($date_end . '- 29 days'));

        $conditions['DATE(Answer.created) >='] = $date_start;
        $conditions['DATE(Answer.created) <='] = $date_end;
        $conditions['Answer.status']    = 1;
        $conditions['Answer.poll_id']   = $poll_id;

        $days_to_step = 30;

        $answers = $this->Answer->find('all', array(
            'conditions' => $conditions
        ));


        $question_ids   = array();

        $result = array();

        $dataset = array();

        for($i = 0; $i < $days_to_step; $i++) {
            $date_target = CakeTime::format('Y-m-d', strtotime($date_start . '+ '.$i.' days'));
            if($date_target <= $date_end) {
                $result[strtotime($date_target)*1000] = 0;
            }
        }

        $preresult = array();

        foreach($answers as $answer) {

            if(!isset($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))])) {
                $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))] = array();
            }
            if(!in_array($answer['Answer']['question_id'], $question_ids)) {
                array_push($question_ids, $answer['Answer']['question_id']);
            }

            if(!isset($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['rating'])) {
                $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['rating'] = 0;
            }

            $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['rating'] += $answer['Answer']['rating'];

            if(!isset($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'] = array();
            }
            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }

            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }
        }

        # inject question_ids
        foreach($preresult as $key => $res) {
            $preresult[$key]['questions'] = $question_ids;
            $preresult[$key]['average'] = ($res['rating']/count($question_ids))/count($res['guests']);

            $result[strtotime($key)*1000] = round($preresult[$key]['average'], 2);

            //array_push($dataset, array(strtotime($key)*1000, round($preresult[$key]['average'], 2)));
        }

        foreach($result as $timestamp => $average) {
            array_push($dataset, array($timestamp, $average));
        }

        $holder_object = new stdClass();

        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Overall average', true);

        $set['xaxis'] = 1;

        $set['color'] = '#333';
        $set['data'] = $dataset;

        $set['points'] = new stdClass();
        $set['points']->fillColor = '#FFF';
        $set['points']->show = true;
        $set['points']->shadow = true;

        $set['lines'] = new stdClass();
        $set['lines']->fillColor = '#DDD';
        $set['lines']->show = true;

        $i = 1;
        $holder_object->$i = $set;

        return $holder_object;
    }

    /**
    * get an overall rating chart for a given month
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $type
    * @return object $holder_object
    */
    public function getOverallAverageChartMonth($poll_id = null, $type = null, $year_month = null) {


        $date_start = CakeTime::format('Y-m-01', strtotime($year_month));
        $date_end  = CakeTime::format('Y-m-t', strtotime($date_start));


        $conditions['DATE(Answer.created) >='] = $date_start;
        $conditions['DATE(Answer.created) <='] = $date_end;
        $conditions['Answer.poll_id']   = $poll_id;
        $conditions['Answer.status']    = 1;

        $days_to_step = 31;

        $answers = $this->Answer->find('all', array(
            'conditions' => $conditions
        ));


        $question_ids   = array();

        $result = array();

        $dataset = array();

        for($i = 0; $i <= $days_to_step; $i++) {
            $date_target = CakeTime::format('Y-m-d', strtotime($date_start . '+ '.$i.' days'));
            if($date_target <= $date_end) {
                $result[strtotime($date_target)*1000] = 0;
            }
        }

        $preresult = array();

        foreach($answers as $answer) {

            if(!isset($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))])) {
                $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))] = array();
            }
            if(!in_array($answer['Answer']['question_id'], $question_ids)) {
                array_push($question_ids, $answer['Answer']['question_id']);
            }

            if(!isset($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['rating'])) {
                $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['rating'] = 0;
            }

            $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['rating'] += $answer['Answer']['rating'];

            if(!isset($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'] = array();
            }
            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }

            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }
        }

        # inject question_ids
        foreach($preresult as $key => $res) {
            $preresult[$key]['questions'] = $question_ids;
            $preresult[$key]['average'] = ($res['rating']/count($question_ids))/count($res['guests']);

            $result[strtotime($key)*1000] = round($preresult[$key]['average'], 2);

            //array_push($dataset, array(strtotime($key)*1000, round($preresult[$key]['average'], 2)));
        }

        foreach($result as $timestamp => $average) {
            array_push($dataset, array($timestamp, $average));
        }

        $holder_object = new stdClass();

        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Overall average', true);

        $set['xaxis'] = 1;

        $set['color'] = '#333';
        $set['data'] = $dataset;

        $set['points'] = new stdClass();
        $set['points']->fillColor = '#FFF';
        $set['points']->show = true;
        $set['points']->shadow = true;

        $set['lines'] = new stdClass();
        $set['lines']->fillColor = '#DDD';
        $set['lines']->show = true;

        $i = 1;
        $holder_object->$i = $set;

        return $holder_object;
    }

    /**
    * get an overall rating chart for a given month
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $type
    * @return object $holder_object
    */
    public function getOverallAverageChartWeek($poll_id = null, $type = null, $year_weeknumber = null) {

        $temp = explode('_', $year_weeknumber);
        $year = $temp[0];
        $weeknumber = $temp[1];

        $weeknumber = sprintf("%02u", $weeknumber);
        $date_start = date( "Y-m-d", strtotime($year."W".$weeknumber."1")); // First day of week
        $date_end   = date( "Y-m-d", strtotime($year."W".$weeknumber."7") );


        $conditions['DATE(Answer.created) >='] = $date_start;
        $conditions['DATE(Answer.created) <='] = $date_end;
        $conditions['Answer.poll_id']   = $poll_id;
        $conditions['Answer.status']    = 1;

        $days_to_step = 7;

        $answers = $this->Answer->find('all', array(
            'conditions' => $conditions
        ));


        $question_ids   = array();

        $result = array();

        $dataset = array();

        for($i = 0; $i <= $days_to_step; $i++) {
            $date_target = date('Y-m-d', strtotime($date_start . '+ '.$i.' days'));
            if($date_target <= $date_end) {
                $result[strtotime($date_target)*1000] = 0;
            }
        }

        $preresult = array();

        foreach($answers as $answer) {

            if(!isset($preresult[date('Y-m-d', strtotime($answer['Answer']['created']))])) {
                $preresult[date('Y-m-d', strtotime($answer['Answer']['created']))] = array();
            }
            if(!in_array($answer['Answer']['question_id'], $question_ids)) {
                array_push($question_ids, $answer['Answer']['question_id']);
            }

            if(!isset($preresult[date('Y-m-d', strtotime($answer['Answer']['created']))]['rating'])) {
                $preresult[date('Y-m-d', strtotime($answer['Answer']['created']))]['rating'] = 0;
            }

            $preresult[date('Y-m-d', strtotime($answer['Answer']['created']))]['rating'] += $answer['Answer']['rating'];

            if(!isset($preresult[date('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                $preresult[date('Y-m-d', strtotime($answer['Answer']['created']))]['guests'] = array();
            }
            if(!in_array($answer['Answer']['guest_id'], $preresult[date('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[date('Y-m-d', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }

            if(!in_array($answer['Answer']['guest_id'], $preresult[date('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[date('Y-m-d', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }
        }

        # inject question_ids
        foreach($preresult as $key => $res) {
            $preresult[$key]['questions'] = $question_ids;
            $preresult[$key]['average'] = ($res['rating']/count($question_ids))/count($res['guests']);

            $result[strtotime($key)*1000] = round($preresult[$key]['average'], 2);

            //array_push($dataset, array(strtotime($key)*1000, round($preresult[$key]['average'], 2)));
        }

        foreach($result as $timestamp => $average) {
            array_push($dataset, array($timestamp, $average));
        }

        $holder_object = new stdClass();

        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Overall average', true);

        $set['xaxis'] = 1;

        $set['color'] = '#333';
        $set['data'] = $dataset;

        $set['points'] = new stdClass();
        $set['points']->fillColor = '#FFF';
        $set['points']->show = true;
        $set['points']->shadow = true;

        $set['lines'] = new stdClass();
        $set['lines']->fillColor = '#DDD';
        $set['lines']->show = true;

        $i = 1;
        $holder_object->$i = $set;

        return $holder_object;
    }

    /**
    * get an overall rating chart for a given month
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $type
    * @return object $holder_object
    */
    public function getOverallAverageChartYear($poll_id = null, $type = null, $year = null) {

        $date_start = CakeTime::format('Y-m-d', strtotime($year.'-01-01'));
        $date_end   = CakeTime::format('Y-m-d', strtotime($year.'-12-31'));

        $conditions['YEAR(Answer.created)'] = $year;
        $conditions['Answer.poll_id']       = $poll_id;
        $conditions['Answer.status']        = 1;

        $answers = $this->Answer->find('all', array(
            'conditions' => $conditions
        ));

        $question_ids   = array();

        $result = array();

        $dataset = array();

        for($i = 0; $i < 12; $i++) {
            $month_target = CakeTime::format('Y-m', strtotime($date_start . '+ '.$i.' months'));
            $result[strtotime($month_target)*1000] = 0;
        }

        $preresult = array();

        foreach($answers as $answer) {

            if(!isset($preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))])) {
                $preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))] = array();
            }
            if(!in_array($answer['Answer']['question_id'], $question_ids)) {
                array_push($question_ids, $answer['Answer']['question_id']);
            }

            if(!isset($preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))]['rating'])) {
                $preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))]['rating'] = 0;
            }

            $preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))]['rating'] += $answer['Answer']['rating'];

            if(!isset($preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))]['guests'])) {
                $preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))]['guests'] = array();
            }
            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }

            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }
        }

        # inject question_ids
        foreach($preresult as $key => $res) {
            $preresult[$key]['questions'] = $question_ids;
            $preresult[$key]['average'] = ($res['rating']/count($question_ids))/count($res['guests']);

            $result[strtotime($key)*1000] = round($preresult[$key]['average'], 2);

            //array_push($dataset, array(strtotime($key)*1000, round($preresult[$key]['average'], 2)));
        }

        foreach($result as $timestamp => $average) {
            array_push($dataset, array($timestamp, $average));
        }

        $holder_object = new stdClass();

        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Overall average', true);

        $set['xaxis'] = 1;

        $set['color'] = '#333';
        $set['data'] = $dataset;

        $set['points'] = new stdClass();
        $set['points']->fillColor = '#FFF';
        $set['points']->show = true;
        $set['points']->shadow = true;

        $set['lines'] = new stdClass();
        $set['lines']->fillColor = '#DDD';
        $set['lines']->show = true;

        $i = 1;
        $holder_object->$i = $set;

        return $holder_object;
    }

    /**
    * get an array of statuses
    * standard-statuses; overwrite this method
    * if you need other stati in your models!
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getStatuses() {
        return array(
            0 => __('inactive', true),
            1 => __('active', true)
        );
    }

    /**
    * get a complete poll for view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $locale
    * @return mixed $poll or false
    */
    public function getPoll($poll_id = null, $locale = 'eng') {

        $this->virtualFields['count_views'] = 'SELECT COUNT(*) FROM polls_views AS PollsView WHERE PollsView.poll_id = Poll.id';
        $this->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';

        $this->locale = $locale;

        $poll = $this->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.id' => $poll_id,
                'Poll.deleted' => 0,
                #'Poll.status' => 1
            )
        ));

        if(empty($poll)) {
            return false;
        }

        $this->Host->id = $poll['Poll']['host_id'];

        $this->Group->locale = $this->locale;

        $groups = $this->Group->find('all', array(
            'conditions' => array(
                'Group.deleted' => 0,
                'Group.status' => 1,
                'Group.poll_id' => $poll_id
            ),
            'order' => 'Group.order ASC'
        ));

        if(empty($groups)) {
            return false;
        }


        $poll['Groups'] = $groups;

        $this->Group->Question->locale = $this->locale;

        foreach($poll['Groups'] as $key => $group) {

            $questions = $this->Group->Question->find('all', array(
                'conditions' => array(
                    'Question.deleted' => 0,
                    'Question.status' => 1,
                    'Question.poll_id' => $poll_id,
                    'Question.group_id' => $group['Group']['id']
                ),
                'order' => 'Question.order ASC'
            ));

            $poll['Groups'][$key]['Questions'] = $questions;

        }

        return $poll;
    }


    /**
    * get a preformatted array of guests and answers
    * (used for the overview table of all answers in
    * poll-detail-view)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $locale, string $date_type, string $date_value
    * @return mixed $guests
    */
    public function getPollAnswers($poll_id = null, $locale = null, $date_type, $date_value, $option = null) {

        $this->locale = $locale;

        $conditions = array();
        $conditions['Answer.poll_id'] = $poll_id;
        $conditions['Answer.deleted'] = 0;


        #setup conditions based on given type and date
        switch($date_type) {
            case 'day':
                $conditions['DATE(Answer.created)'] = $date_value;
                break;
            case 'week':
                $weeknumber = date('W', strtotime($date_value));
                $year = date('Y', strtotime($date_value));
                $week_array = $this->getStartAndEndDateFromWeeknumber($weeknumber, $year);
                $conditions['DATE(Answer.created) >='] = $week_array['week_start'];
                $conditions['DATE(Answer.created) <='] = $week_array['week_end'];
                break;
            case 'month':
                if($option == 'last_30') {
                    $end   = $date_value;
                    $begin  = date('Y-m-d', strtotime($end . '- 29 days'));
                    $conditions['DATE(Answer.created) >='] = $begin;
                    $conditions['DATE(Answer.created) <='] = $end;
                } else {
                    $conditions['YEAR(Answer.created)'] = date('Y', strtotime($date_value));
                    $conditions['MONTH(Answer.created)'] = date('m', strtotime($date_value));
                }
                break;
            case 'year':
                $conditions['YEAR(Answer.created)'] = $date_value;
                $conditions['Answer.status'] = 1;
                break;
            case 'last30':
                $end   = $date_value;
                $begin  = date('Y-m-d', strtotime($end . '- 29 days'));
                $conditions['DATE(Answer.created) >='] = $begin;
                $conditions['DATE(Answer.created) <='] = $end;
                break;
        }

        $answers = $this->Answer->find('all', array(
            'conditions' => $conditions,
            'order' => 'Answer.created DESC'
        ));

        if($date_type != 'year') {

            $guest_ids = Set::ClassicExtract($answers, '{n}.Answer.guest_id');
            if(is_array($guest_ids)) {
                $guest_ids = array_unique($guest_ids);
            }

            $guests = $this->Answer->Guest->find('all', array(
                'conditions' => array(
                    'Guest.id' => $guest_ids
                )
            ));

            $guests = $this->remapData($guests, 'Guest', 'id');

            foreach($answers as $answer) {
                if(!isset($guests[$answer['Answer']['guest_id']]['Answers'][$answer['Answer']['question_id']])) {
                    $guests[$answer['Answer']['guest_id']]['Answers'][$answer['Answer']['question_id']] = $answer['Answer']['rating'];
                }
            }

            # sort the dataset by guest created (should be same datetime as answer created)
            $guests = Set::sort($guests, '{n}.Guest.created', 'desc');
        } else {

            for($i = 1; $i < 13; $i++) {
                $monthly_averages[sprintf("%02s", $i)] = array();
            }

            foreach($answers as $answer) {
                if(!isset($monthly_averages[date('m', strtotime($answer['Answer']['created']))]['Answers'][$answer['Answer']['question_id']])) {
                    $monthly_averages[date('m', strtotime($answer['Answer']['created']))]['Answers'][$answer['Answer']['question_id']]['rating_overall'] = 0;
                    $monthly_averages[date('m', strtotime($answer['Answer']['created']))]['Answers'][$answer['Answer']['question_id']]['rating_count'] = 0;
                }
                $monthly_averages[date('m', strtotime($answer['Answer']['created']))]['Answers'][$answer['Answer']['question_id']]['rating_overall'] += $answer['Answer']['rating'];
                $monthly_averages[date('m', strtotime($answer['Answer']['created']))]['Answers'][$answer['Answer']['question_id']]['rating_count']++;
            }

            ksort($monthly_averages);

            return $monthly_averages;
        }

        return $guests;
    }


    /**
    * get a complete poll for view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $locale
    * @return mixed $poll or false
    */
    public function getPollQuestions($poll_id = null, $locale = 'eng') {

        $this->Group->Question->locale = $locale;

        $questions = $this->Group->Question->find('all', array(
            'conditions' => array(
                'Question.poll_id' => $poll_id,
                'Question.status' => 1,
                'Question.deleted' => 0
            ),
            'order' => array(
                'Question.order' => 'ASC'
            )
        ));

        return $questions;
    }


    /**
    * get the host_id of a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return int $host_id
    */
    public function getPollsHostIdForWidget($poll_id = null){
        if(!$poll_id){
            return false;
        }

        $host_id = $this->find('first', array(
            'conditions' => array(
                'Poll.id' => $poll_id,
                'Poll.status' => 1,
                'Poll.deleted' => 0
            ),
            'fields' => array(
                'host_id'
            )
        ));
        $host_id = $host_id['Poll']['host_id'];
        return $host_id;
    }


    /**
    * get a list of all polls for a given account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getPollsList($account_id = null, $locale = null) {
        if(!$account_id) {
            return false;
        }

        if(!$locale) {
            $locale = Configure::read('Language.default');
        }

        $this->locale = $locale;

        $polls = $this->find('list', array(
            'conditions' => array(
                'Poll.account_id' => $account_id
            )
        ));

        return $polls;
    }


    /**
    * get a list of all polls for a given account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return array $polls
    */
    public function getPollsListForWidget($account_id = null){
        if(!$account_id){
            return false;
        }

        $account_id = intval($account_id);
        $this->Account->id = $account_id;
        if(!$this->Account->exists()){
            return false;
        }

        //list all polls under their host (formated for a drop down menu)
        $polls = $this->find('list', array(
            'conditions' => array(
                'Poll.account_id' => $account_id,
                'Poll.status' => 1,
                'Poll.deleted' => 0
            ),
            'contain' => array(
                'Host' => array(
                    'conditions' => array(
                        'Host.deleted' => 0
                    ),
                    'fields' => array(
                        'name'
                    )
                )
            ),
            'fields' => array(
                'Poll.id',
                'Poll.title',
                'Host.name'
            ),
            'recursive' => 1,
            'order' => 'Host.name ASC',
            'order' => 'Poll.title ASC'
        ));

        return $polls;
    }


    /**
    * get the max scale of a given poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return int $max_scale
    */
    public function getPollsMaxScale($poll_id = null) {
        $max_scale = 0;
        $poll = $this->getPoll($poll_id);
        if(isset($poll['Groups'])) {
            foreach($poll['Groups'] as $key => $group) {
                foreach($group['Questions'] as $question) {
                    if($question['Question']['scale'] > $max_scale) {
                        $max_scale = $question['Question']['scale'];
                    }
                }
            }
        }

        return $max_scale;
    }


    /**
    * get the id and title of a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return mixed $poll
    */
    public function getPollsTitleForWidget($poll_id = null){
        if(!$poll_id){
            return false;
        }

        $poll_id = intval($poll_id);
        $this->id = $poll_id;
        if(!$this->exists()){
            return false;
        }

        $poll = $this->find('first', array(
            'conditions' => array(
                'Poll.id' => $poll_id,
                'Poll.status' => 1,
                'Poll.deleted' => 0
            ),
            'fields' => array(
                'id',
                'title'
            )
        ));

        return $poll;
    }


    /**
    * get the rating info by a given guest_id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $guest_id
    * @return mixed $rating_info
    */
    public function getRatingInfo($guest_id = null) {

        $rating_info = $this->Guest->find('first', array(
            'contain' => array(
                'Answer'
            ),
            'conditions' => array(
                'Guest.id' => $guest_id
            )
        ));

        return $rating_info;
    }


    /**
    * get an overall rating chart for the last 7 days
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getRatingLast7Average($poll_id = null) {

        # this will set the timezone for ANY following functions when using Cake::Time() !
        $poll = $this->getPoll($poll_id);
        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $holder_object = new stdClass();

        // Get the average of RATINGS of the last 7 days for each poll
        // BEGIN

        // called as CakeTime
        $today  = CakeTime::format('Y-m-d', time());
        $border = CakeTime::format('Y-m-d', strtotime($today . '- 6 days'));

        $conditions = array();
        $conditions['DATE(Answer.created) >='] = $border;
        $conditions['DATE(Answer.created) <='] = $today;
        $conditions['Answer.poll_id']   = $poll_id;
        $conditions['Answer.status']    = 1;

        $answers = $this->Answer->find('all', array(
            'conditions' => $conditions
        ));

        $question_ids   = array();
        $result = array();
        $dataset = array();

        for($i = 0; $i <= 6; $i++) {
            $date = date('Y-m-d', strtotime($today . '- '.$i.' days'));
            if($date >= $border) {
                $result[(strtotime($date)) *1000] = 0;
            }
        }

        $preresult = array();

        foreach($answers as $answer) {

            if(!isset($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))])) {
                $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))] = array();
            }
            if(!in_array($answer['Answer']['question_id'], $question_ids)) {
                array_push($question_ids, $answer['Answer']['question_id']);
            }
            if(!isset($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['rating'])) {
                $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['rating'] = 0;
            }

            $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['rating'] += $answer['Answer']['rating'];

            if(!isset($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'] = array();
            }
            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }

            if(!in_array($answer['Answer']['guest_id'], $preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'])) {
                array_push($preresult[CakeTime::format('Y-m-d', strtotime($answer['Answer']['created']))]['guests'], $answer['Answer']['guest_id']);
            }
        }

        # inject question_ids
        foreach($preresult as $key => $res) {
            $preresult[$key]['questions'] = $question_ids;
            $preresult[$key]['average'] = ($res['rating']/count($question_ids))/count($res['guests']);
            $result[(strtotime($key))*1000] = round($preresult[$key]['average'], 2);
        }


        foreach($result as $timestamp => $average) {
            array_push($dataset, array($timestamp, $average));
        }

        // $holder_object = new stdClass();

        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Overall average', true);
        $set['xaxis'] = 1;
        $set['data'] = $dataset;

        // $set['color'] = '#333';
        // $set['points'] = new stdClass();
        // $set['points']->fillColor = '#FFF';
        // $set['points']->show = true;
        // $set['points']->shadow = true;

        // $set['lines'] = new stdClass();
        // $set['lines']->fillColor = '#DDD';
        // $set['lines']->show = true;

        $i = 1;
        $holder_object->$i = $set;

        // END
        // Get the average of RATINGS of the last 7 days for each poll

        return $holder_object;
    }



    /**
    * get an overall rating chart for the last 7 days
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getLast7ViewsAndRatings($poll_id = null) {

        # this will set the timezone for ANY following functions when using Cake::Time() !
        $poll = $this->getPoll($poll_id);
        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $holder_object = new stdClass();


        // Get the amount of views of the last 7 days for each poll
        // BEGIN

        $day_last   = CakeTime::format('Y-m-d', time());
        $day_first  = CakeTime::format('Y-m-d', strtotime($day_last . '- 6 days'));


        $conditions = array();
        $conditions['PollsView.poll_id']          = $poll_id;
        $conditions['DATE(PollsView.created) >='] = $day_first;
        $conditions['DATE(PollsView.created) <='] = $day_last;

        $views = $this->PollsView->find('all', array(
            'conditions' => $conditions
        ));

        # predefine the resultset (we need a set of 30 timestamps here!)
        $result = array();
        for($i = 0; $i <= 6; $i++) {

            $date = date('Y-m-d', strtotime($day_first . '+ '.$i.' days'));
            $date = CakeTime::format('Y-m-d', strtotime($day_first . '+ '.$i.' days'));

            if($date <= $day_last) {
                $result[strtotime($date)*1000] = 0;
            }
        }

        foreach($views as $view) {
            $result[strtotime(date('Y-m-d', strtotime($view['PollsView']['created'])))*1000]++;
        }

        # build the actual dataset
        $dataset = array();
        foreach($result as $timestamp => $view_count) {
            array_push($dataset, array($timestamp, $view_count));
        }

        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Views', true);
        $set['xaxis'] = 1;
        $set['data'] = $dataset;

        // $set['color'] = '#333';

        // $set['points'] = new stdClass();
        // $set['points']->fillColor = '#FFF';
        // $set['points']->show = true;
        // $set['points']->shadow = true;

        // $set['lines'] = new stdClass();
        // $set['lines']->fillColor = '#DDD';
        // $set['lines']->show = true;

        $i = 1;
        $holder_object->$i = $set;

        // END
        // Get the amount of VIEWS of the last 7 days for each poll


        // Get the amount of RATINGS of the last 7 days for each poll
        // BEGIN

        $conditions = array();
        $conditions['DATE(Guest.created) >='] = $day_first;
        $conditions['DATE(Guest.created) <='] = $day_last;
        $conditions['Guest.poll_id']         = $poll_id;
        $conditions['Guest.status']           = 1;

        $guests = $this->Answer->Guest->find('all', array(
            'conditions' => $conditions
        ));


        # predefine the resultset (we need a set of 7 timestamps here!)
        $result = array();
        for($i = 0; $i <= 6; $i++) {
            $date = date('Y-m-d', strtotime($day_first . '+ '.$i.' days'));
            if($date <= $day_last) {
                $result[strtotime($date)*1000] = 0;
            }
        }

        foreach($guests as $guest) {
            $result[strtotime(date('Y-m-d', strtotime($guest['Guest']['created'])))*1000]++;
        }

        # build the actual dataset
        $dataset = array();
        foreach($result as $timestamp => $view_count) {
            array_push($dataset, array($timestamp, $view_count));
        }


        # build the complete dataset record (series)
        $set = array();
        $set['label'] = __('Ratings', true);
        $set['xaxis'] = 1;
        $set['data']    = $dataset;

        // $set['color'] = '#428BCA';
        // $set['points'] = new stdClass();
        // $set['points']->fillColor = '#FFF';
        // $set['points']->show = true;
        // $set['points']->shadow = true;

        // $set['lines'] = new stdClass();
        // $set['lines']->fillColor = '#BBDDFA';
        // $set['lines']->show = true;

        $i = 2;
        $holder_object->$i = $set;

        // END
        // Get the amount of RATINGS of the last 7 days for each poll

        return $holder_object;
    }

    /**
    * get an array of scale options for a poll-template
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getScaleOptions() {
        return array(
            4 => 4,
            5 => 5,
            6 => 6
        );
    }

    /**
    * get the dashboard counts per account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return mixed $counts
    */
    public function getScorecardCounts($poll_id = null, $type = null, $date = null) {

        $groups = $this->Host->Poll->Group->find('all', array(
            'contain' => array(
                'Question' => array(
                    'Answer' => array(
                        'conditions' => array(
                            'Answer.status' => 1
                        )
                    )
                )
            ),
            'conditions' => array(
                'Group.poll_id' => $poll_id
            )
        ));


        $groups = $this->remapData($groups, 'Group', 'id');

        $answer_count       = 0;

        $rating         = 0;
        $rating_current = 0;
        $rating_prev    = 0;

        $guest_ids = array();     // inject guest_ids here

        $answers_current    = array();
        $answers_prev       = array();

        $guest_ids_current  = array();
        $guest_ids_prev     = array();

        $answer_count_current  = 0;
        $answer_count_prev     = 0;


        $count_by_group = array();


        # split all answers into two arrays for answers: current period + previous period
        foreach($groups as $group_id => $group) {

            $count_by_group[$group_id] = count($group['Question']);

            foreach($group['Question'] as $key_question => $question) {

                foreach($question['Answer'] as $answer) {

                    # inject group_id to make handling below easier
                    $answer['group_id'] = $group_id;

                    if($type == 'day') {
                        # CASE: DAY
                        # all answers given for the day

                        $created = date('Y-m-d', strtotime($answer['created']));

                        if(date('Y-m-d', strtotime($created)) == $date) {
                            array_push($answers_current, $answer);
                        }

                        # all answers given for the day BEFORE (e.g. given date - 1 day)
                        $day_before = date('Y-m-d', strtotime($date.' -1day'));
                        if($created == date('Y-m-d', strtotime($date.' -1day'))) {
                            array_push($answers_prev, $answer);
                        }

                        # polls_views conditions
                        $conditions_polls_views_current = array();
                        $conditions_polls_views_current['PollsView.poll_id']        = $poll_id;
                        $conditions_polls_views_current['DATE(PollsView.created)']  = $date;

                        $conditions_polls_views_prev = array();
                        $conditions_polls_views_prev['PollsView.poll_id']        = $poll_id;
                        $conditions_polls_views_prev['DATE(PollsView.created)']  = $day_before;
                    }

                    if($type == 'week') {
                        # actual week

                        $created = date('Y-m-d', strtotime($answer['created']));
                        if((strtotime($created) >= strtotime($date['start'])) && (strtotime($created) <= strtotime($date['end']))) {
                            array_push($answers_current, $answer);
                        }

                        $week_before_start = date('Y-m-d', strtotime($date['start'].' -1week'));
                        $week_before_end = date('Y-m-d', strtotime($date['end'].' -1week'));
                        if((strtotime($created) >= strtotime($week_before_start)) && (strtotime($created) <= strtotime($week_before_end))) {
                            array_push($answers_prev, $answer);
                        }

                        # polls_views conditions
                        $conditions_polls_views_current = array();
                        $conditions_polls_views_current['PollsView.poll_id']          = $poll_id;
                        $conditions_polls_views_current['DATE(PollsView.created) >='] = $date['start'];
                        $conditions_polls_views_current['DATE(PollsView.created) <='] = $date['end'];

                        $conditions_polls_views_prev = array();
                        $conditions_polls_views_prev['PollsView.poll_id']          = $poll_id;
                        $conditions_polls_views_prev['DATE(PollsView.created) >='] = $week_before_start;
                        $conditions_polls_views_prev['DATE(PollsView.created) <='] = $week_before_end;
                    }

                    if($type == 'month') {

                        $created = date('Y-m', strtotime($answer['created']));

                        if($created == $date) {
                            array_push($answers_current, $answer);
                        }

                        $month_before = date('Y-m', strtotime($date.' -1month'));

                        if($created == $month_before) {
                            array_push($answers_prev, $answer);
                        }

                        $conditions_polls_views_current = array();
                        $conditions_polls_views_current['PollsView.poll_id']            = $poll_id;
                        $conditions_polls_views_current['YEAR(PollsView.created)'] = date('Y', strtotime($date));
                        $conditions_polls_views_current['MONTH(PollsView.created)'] = date('m', strtotime($date));

                        $conditions_polls_views_prev = array();
                        $conditions_polls_views_prev['PollsView.poll_id']            = $poll_id;
                        $conditions_polls_views_prev['YEAR(PollsView.created)'] = date('Y', strtotime($month_before));
                        $conditions_polls_views_prev['MONTH(PollsView.created)'] = date('m', strtotime($month_before));
                    }

                    if($type == 'last30') {

                        $date_end   = $date;
                        $date_start = date('Y-m-d', strtotime($date_end . '- 29 days'));

                        $last30_before_end = date('Y-m-d', strtotime($date_start . '- 1 day'));
                        $last30_before_start = date('Y-m-d', strtotime($last30_before_end . '- 29 days'));

                        $created = date('Y-m-d', strtotime($answer['created']));

                        if((strtotime($created) >= strtotime($date_start)) && (strtotime($created) <= strtotime($date_end))) {
                            array_push($answers_current, $answer);
                        }

                        if((strtotime($created) >= strtotime($last30_before_start)) && (strtotime($created) <= strtotime($last30_before_end))) {
                            array_push($answers_prev, $answer);
                        }

                        # polls_views conditions
                        $conditions_polls_views_current = array();
                        $conditions_polls_views_current['PollsView.poll_id']          = $poll_id;
                        $conditions_polls_views_current['DATE(PollsView.created) >='] = $date_start;
                        $conditions_polls_views_current['DATE(PollsView.created) <='] = $date_end;

                        $conditions_polls_views_prev = array();
                        $conditions_polls_views_prev['PollsView.poll_id']          = $poll_id;
                        $conditions_polls_views_prev['DATE(PollsView.created) >='] = $last30_before_start;
                        $conditions_polls_views_prev['DATE(PollsView.created) <='] = $last30_before_end;
                    }

                    if($type == 'year') {

                        $created = date('Y', strtotime($answer['created']));

                        if($created == $date) {
                            array_push($answers_current, $answer);
                        }

                        $year_before = date('Y', strtotime($date.' -1year'));

                        if($created == $year_before) {
                            array_push($answers_prev, $answer);
                        }


                        $conditions_polls_views_current = array();
                        $conditions_polls_views_current['PollsView.poll_id']        = $poll_id;
                        $conditions_polls_views_current['YEAR(PollsView.created)']  = $date;

                        $conditions_polls_views_prev = array();
                        $conditions_polls_views_prev['PollsView.poll_id']       = $poll_id;
                        $conditions_polls_views_prev['YEAR(PollsView.created)'] = $year_before;
                    }

                }
            }
        }

        if(isset($conditions_polls_views_current)) {
            $scorecard['views']['current'] = $this->PollsView->find('count', array(
                'conditions' => $conditions_polls_views_current
            ));
        } else {
            $scorecard['views']['current'] = 0;
        }

        if(isset($conditions_polls_views_prev)) {
            $scorecard['views']['prev'] = $this->PollsView->find('count', array(
                'conditions' => $conditions_polls_views_prev
            ));
        } else {
            $scorecard['views']['prev'] = 0;
        }


        // prepare the ratings by group for current and prev period
        $groups = $this->getGrouplist($poll_id);
        $rating_current_by_group = array();
        $rating_prev_by_group = array();

        foreach($groups as $group_id => $group_name) {
            $rating_current_by_group[$group_id] = 0;
            $rating_prev_by_group[$group_id] = 0;
        }


        # inject the actual data
        foreach($answers_current as $cur) {
            if(!in_array($cur['guest_id'], $guest_ids_current)) {
                array_push($guest_ids_current, $cur['guest_id']);
            }
            $answer_count_current++;
            $rating_current += $cur['rating'];
            $rating_current_by_group[$cur['group_id']] += $cur['rating'];
        }

        foreach($answers_prev as $prev) {
            if(!in_array($prev['guest_id'], $guest_ids_prev)) {
                array_push($guest_ids_prev, $prev['guest_id']);
            }
            $answer_count_prev++;
            $rating_prev += $prev['rating'];
            $rating_prev_by_group[$prev['group_id']] += $prev['rating'];
        }


        # CURRENT PART
        $scorecard['current']['guest_count_overall']  = count($guest_ids_current);

        if($answer_count_current > 0) {
            $scorecard['current']['average_overall'] = round($rating_current/$answer_count_current, 2);
        } else {
            $scorecard['current']['average_overall'] = 0;
        }

        foreach($rating_current_by_group as $group_id => $count) {
            if(($count > 0) && ($scorecard['current']['guest_count_overall'] > 0)) {
                $scorecard['current']['average_by_group'][$group_id] = round($rating_current_by_group[$group_id]/$count_by_group[$group_id]/$scorecard['current']['guest_count_overall'], 2);
            } else {
                $scorecard['current']['average_by_group'][$group_id] = 0;
            }
        }


        # PREV PART
        $scorecard['prev']['guest_count_overall']  = count($guest_ids_prev);

        if($answer_count_prev > 0) {
            $scorecard['prev']['average_overall'] = round($rating_prev/$answer_count_prev, 2);
        } else {
            $scorecard['prev']['average_overall'] = 0;
        }

        foreach($rating_prev_by_group as $group_id => $count) {
            if(($count > 0) && ($scorecard['prev']['guest_count_overall'] > 0)) {
                $scorecard['prev']['average_by_group'][$group_id] = round($rating_prev_by_group[$group_id]/$count_by_group[$group_id]/$scorecard['prev']['guest_count_overall'], 2);
            } else {
                $scorecard['prev']['average_by_group'][$group_id] = 0;
            }
        }

        $guests_current = $this->Host->Poll->Answer->Guest->find('all', array(
            'conditions' => array(
                'Guest.id' => $guest_ids_current
            )
        ));

        $scorecard['current']['guests_evening']    = 0;
        $scorecard['current']['guests_midday']     = 0;
        $scorecard['current']['guests_morning']    = 0;

        $scorecard['current']['guests_regular']    = 0;
        $scorecard['current']['guests_occ']        = 0;
        $scorecard['current']['guests_rarely']     = 0;
        $scorecard['current']['guests_first']      = 0;

        foreach($guests_current as $guest) {

            if($guest['Guest']['visit_time'] == 1) {
                $scorecard['current']['guests_evening']++;
            } elseif($guest['Guest']['visit_time'] == 2) {
                $scorecard['current']['guests_midday']++;
            } elseif($guest['Guest']['visit_time'] == 3) {
                $scorecard['current']['guests_morning']++;
            }

            if($guest['Guest']['guest_type'] == 1) {
                $scorecard['current']['guests_first']++;
            } elseif($guest['Guest']['guest_type'] == 2) {
                $scorecard['current']['guests_rarely']++;
            } elseif($guest['Guest']['guest_type'] == 3) {
                $scorecard['current']['guests_occ']++;
            } elseif($guest['Guest']['guest_type'] == 4) {
                $scorecard['current']['guests_regular']++;
            }

        }



        $guests_prev = $this->Host->Poll->Answer->Guest->find('all', array(
            'conditions' => array(
                'Guest.id' => $guest_ids_prev
            )
        ));

        $scorecard['prev']['guests_evening']    = 0;
        $scorecard['prev']['guests_midday']     = 0;
        $scorecard['prev']['guests_morning']    = 0;

        $scorecard['prev']['guests_regular']    = 0;
        $scorecard['prev']['guests_occ']        = 0;
        $scorecard['prev']['guests_rarely']     = 0;
        $scorecard['prev']['guests_first']      = 0;

        foreach($guests_prev as $guest) {

            if($guest['Guest']['visit_time'] == 1) {
                $scorecard['prev']['guests_evening']++;
            } elseif($guest['Guest']['visit_time'] == 2) {
                $scorecard['prev']['guests_midday']++;
            } elseif($guest['Guest']['visit_time'] == 3) {
                $scorecard['prev']['guests_morning']++;
            }

            if($guest['Guest']['guest_type'] == 1) {
                $scorecard['prev']['guests_first']++;
            } elseif($guest['Guest']['guest_type'] == 2) {
                $scorecard['prev']['guests_rarely']++;
            } elseif($guest['Guest']['guest_type'] == 3) {
                $scorecard['prev']['guests_occ']++;
            } elseif($guest['Guest']['guest_type'] == 4) {
                $scorecard['prev']['guests_regular']++;
            }

        }

        return $scorecard;
    }

    /**
    * get an overall rating chart for the last 7 days
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $group_id, string $period, string $locale
    * @return mixed $datasets
    */
    public function getSelectablePollsList($account_id = null, $locale = null, $plain = false, $show_id = true) {
        if(!$account_id) {
            return false;
        }

        if(!$locale) {
            $locale = Configure::read('Language.default');
        }


        $this->locale = $locale;
        $polls = $this->find('all', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.deleted' => 0,
                'Poll.account_id' => $account_id
            )
        ));

        $list = array();

        if(!$plain) {
            foreach($polls as $poll) {
                if(!isset($list[$poll['Host']['name']])) {
                    $list[$poll['Host']['name']] = array();
                }
                if($show_id == true) {
                    $list[$poll['Host']['name']][$poll['Poll']['id']] = $poll['Poll']['title'].' (ID: '.$poll['Poll']['id'].')';
                } else {
                    $list[$poll['Host']['name']][$poll['Poll']['id']] = $poll['Poll']['title'];
                }
            }

            ksort($list);
        } else {
            foreach($polls as $poll) {
                if($show_id == true) {
                    $list[$poll['Poll']['id']] = $poll['Host']['name'].' - '.$poll['Poll']['title'].' ('.$poll['Poll']['id'].')';
                } else {
                    $list[$poll['Poll']['id']] = $poll['Host']['name'].' - '.$poll['Poll']['title'];
                }
            }
        }

        return $list;
    }

    /**
    * calculate the start and end dates of a week
    * by the number and year
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $week, int $year
    * @return array
    */
    public function getStartAndEndDateFromWeeknumber($week, $year) {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }


    /**
    * get all available poll templates as complete records
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return mixed $templates
    */
    public function getTemplate($draft_id = null) {
        if(!$draft_id) {
            return false;
        }

        $Draft = ClassRegistry::init('Draft');


        $draft = $Draft->getDraftById($draft_id);

        $template = array();
        $template['name']['eng'] = $draft['Draft']['name_eng'];
        $template['name']['deu'] = $draft['Draft']['name_deu'];

        $template['Groups'] = array();

        foreach($draft['DraftsGroup'] as $key_group => $group) {
            $template['Groups'][$key_group + 1] = array();
            $template['Groups'][$key_group + 1]['name']['eng'] = $group['name_eng'];
            $template['Groups'][$key_group + 1]['name']['deu'] = $group['name_deu'];

            $template['Groups'][$key_group + 1]['Questions'] = array();

            foreach($group['DraftsGroupsQuestion'] as $key_question => $question) {
                $template['Groups'][$key_group + 1]['Questions'][$key_question + 1] = array();

                $template['Groups'][$key_group + 1]['Questions'][$key_question + 1]['scale'] = $question['scale'];

                $template['Groups'][$key_group + 1]['Questions'][$key_question + 1]['question'] = array();
                $template['Groups'][$key_group + 1]['Questions'][$key_question + 1]['question']['eng'] = $question['question_eng'];
                $template['Groups'][$key_group + 1]['Questions'][$key_question + 1]['question']['deu'] = $question['question_deu'];
            }
        }

        return $template;
    }


    /**
    * get all available poll templates as complete records
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return mixed $templates
    */
    public function getTemplates() {

        $templates = $this->templates;

        $Draft = ClassRegistry::init('Draft');
        $drafts = $Draft->find('all', array(
            'conditions' => array(
                'Draft.deleted' => 0,
                'Draft.status' => 1
            )
        ));

        $templates = array();

        foreach($drafts as $draft) {

            $draft = $Draft->getDraftById($draft['Draft']['id']);

            $templates[$draft['Draft']['id']] = array();
            $templates[$draft['Draft']['id']]['name']['eng'] = $draft['Draft']['name_eng'];
            $templates[$draft['Draft']['id']]['name']['deu'] = $draft['Draft']['name_deu'];

            $templates[$draft['Draft']['id']]['Groups'] = array();

            foreach($draft['DraftsGroup'] as $key_group => $group) {
                $templates[$draft['Draft']['id']]['Groups'][$key_group + 1] = array();
                $templates[$draft['Draft']['id']]['Groups'][$key_group + 1]['name']['eng'] = $group['name_eng'];
                $templates[$draft['Draft']['id']]['Groups'][$key_group + 1]['name']['deu'] = $group['name_deu'];

                $templates[$draft['Draft']['id']]['Groups'][$key_group + 1]['Questions'] = array();

                foreach($group['DraftsGroupsQuestion'] as $key_question => $question) {
                    $templates[$draft['Draft']['id']]['Groups'][$key_group + 1]['Questions'][$key_question + 1] = array();

                    $templates[$draft['Draft']['id']]['Groups'][$key_group + 1]['Questions'][$key_question + 1]['scale'] = $question['scale'];

                    $templates[$draft['Draft']['id']]['Groups'][$key_group + 1]['Questions'][$key_question + 1]['question'] = array();
                    $templates[$draft['Draft']['id']]['Groups'][$key_group + 1]['Questions'][$key_question + 1]['question']['eng'] = $question['question_eng'];
                    $templates[$draft['Draft']['id']]['Groups'][$key_group + 1]['Questions'][$key_question + 1]['question']['deu'] = $question['question_deu'];
                }
            }
        }

        return $templates;
    }


    /**
    * get all available poll templates as list
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTemplatesList($locale = null) {

        if(!$locale) {
            $locale = Configure::read('Language.default');
        }

        $templates = array();

        $temp_templates = $this->templates;

        foreach($temp_templates as $id => $template) {
            $templates[$id] = $template['name'][$locale];
        }

        $Draft = ClassRegistry::init('Draft');
        $drafts = $Draft->find('all', array(
            'conditions' => array(
                'Draft.deleted' => 0,
                'Draft.status' => 1
            )
        ));

        $templates = array();

        foreach($drafts as $draft) {
            $templates[$draft['Draft']['id']] = $draft['Draft']['name_'.$locale];
        }

        return $templates;
    }


    /**
    * return an array of available themes
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getThemes() {
        return array(
             1 => __('Standard', true),
            2 => __('Black', true),
            3 => __('Stars Yellow', true),
            4 => __('Stars Blue', true),
            5 => __('Stars Grey', true),
            6 => __('Stars Black', true),
            7 => __('Blue Ribbon', true),
            8 => __('Grey Ribbon', true),
            9 => __('Green Lime', true),
            10 => __('Ice Cream', true),
            11 => __('Cakes', true),
            12 => __('Muffins', true),
            13 => __('Cookies', true),
            14 => __('Blue Smiley', true),
        );
    }


    /**
    * get the type of a poll: can be "free" or paid => unlimited ratings
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return boolean | string $type
    */
    public function getType($poll_id = null) {
        if(!$poll_id) {
            return false;
        }

        $poll_id = intval($poll_id);
        $this->id = $poll_id;
        if (!$this->exists()) {
            return false;
        }

        $invoice = $this->Invoice->find('first', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.poll_id' => $poll_id,
                'Invoice.status' => array(0, 1, 2),
                'Invoice.valid_until >' => CakeTime::format('Y-m-d H:i:s', time())
            )
        ));

        if(!empty($invoice)) {
            return 'unlimited';
        }

        $upgrade = $this->Upgrade->find('first', array(
            'conditions' => array(
                'Upgrade.deleted' => 0,
                'Upgrade.poll_id' => $poll_id,
                'Upgrade.valid_until >' => CakeTime::format('Y-m-d H:i:s', time())
            )
        ));

        if(!empty($upgrade)) {
            return 'unlimited';
        }

        return 'limited';
    }


    /**
    * get the complete upgrade history of a poll given by its id
    * (contains invoices AND system-made upgrades!)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return mixed $templates
    */
    public function getUpgradeHistory($poll_id = null) {
        if(!$poll_id) {
            return array();
        }

        $upgrade_history = array();

        # gather all invoices
        $invoices = $this->Invoice->find('all', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.poll_id' => $poll_id
            ),
            'order' => 'Invoice.created DESC'
        ));


        foreach($invoices as $key => $invoice) {
            $invoice['Invoice']['type'] = 'Invoice';
            array_push($upgrade_history, $invoice['Invoice']);
        }

        # gather all system upgrades
        $upgrades = $this->Upgrade->find('all', array(
            'conditions' => array(
                'Upgrade.deleted' => 0,
                'Upgrade.poll_id' => $poll_id
            ),
            'order' => 'Upgrade.created DESC'
        ));

        foreach($upgrades as $key => $upgrade) {
            $upgrade['Upgrade']['type'] = 'Upgrade';
            array_push($upgrade_history, $upgrade['Upgrade']);
        }

        return $upgrade_history;
    }


    /**
    * get an array of options for visit times
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getVisitTimeHours() {
        return array(
            1 => '19:00:00',
            2 => '13:00:00',
            3 => '10:00:00'
        );
    }


    /**
    * get an array of options for visit times
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getVisitTimes() {
        return array(
            1 => __('Evening', true),
            2 => __('Midday', true),
            3 => __('Morning', true)
        );
    }


    /**
    * inject the remaining ratings for a set of given polls
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $polls
    * @return mixed $polls
    */
    public function injectRemainingRating($polls = null) {

        if(!is_array($polls)) {
            return false;
        }

        $poll_ids = Set::ClassicExtract($polls, '{n}.Poll.id');

        $answers = $this->Answer->find('all', array(
            'conditions' => array(
                'Answer.poll_id' => $poll_ids
            ),
            'group' => array(
                'Answer.guest_id'
            )
        ));

        $ratings = array();
        foreach($answers as $answer) {
            if(!isset($ratings[$answer['Answer']['poll_id']])) {
                $ratings[$answer['Answer']['poll_id']] = 0;
            }
            $ratings[$answer['Answer']['poll_id']]++;
        }

        foreach($polls as $key => $poll) {
            if(isset($ratings[$poll['Poll']['id']])) {
                $polls[$key]['Poll']['ratings_received'] = $ratings[$poll['Poll']['id']];
            } else {
                $polls[$key]['Poll']['ratings_received'] = 0;
            }
            $polls[$key]['Poll']['ratings_remaining'] = $polls[$key]['Poll']['limit'] - $polls[$key]['Poll']['ratings_received'];
        }

        return $polls;
    }

    /**
    * save an answer-pack
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function saveAnswers($data = null) {
        if(!$data) {
            return false;
        }

        $guest = array();
        $guest['Guest']['guest_type']   = $data['Guest']['guest_type'];
        $guest['Guest']['visit_time']   = $data['Guest']['visit_time'];
        $guest['Guest']['poll_id']      = $data['Poll']['poll_id'];
        $guest['Guest']['pin']          = '0000';
        $guest['Guest']['user_agent']   = $_SERVER['HTTP_USER_AGENT'];
        $guest['Guest']['ip']           = $_SERVER['REMOTE_ADDR'];
        $guest['Guest']['referrer']     = $_SERVER['HTTP_REFERER'];
        $guest['Guest']['language']     = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        $this->Guest->create();
        if(!$this->Guest->save($guest)) {
            return false;
        }

        foreach($data['Poll']['answer'] as $id => $rating) {

            $answer = array();
            $answer['Answer']['poll_id']        = $data['Poll']['poll_id'];
            $answer['Answer']['guest_id']       = $this->Guest->id;
            $answer['Answer']['question_id']    = $id;
            $answer['Answer']['rating']         = $rating;
            $answer['Answer']['ip']             = $_SERVER['REMOTE_ADDR'];

            $this->Answer->create();
            $this->Answer->save($answer);
        }

        return true;
    }

    /**
    * save an answer-pack
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function saveManualFeedback($data = null) {
        if(!$data) {
            return false;
        }


        $pollsview_data = $data['PollsView'];
        unset($data['PollsView']);

        // $this->PollsView->addView($pollsview_data['poll_id'], $pollsview_data['serverdata'], $pollsview_data['session_id']);
        // exit;


        $Guest = ClassRegistry::init('Guest');

        $poll_id = $data['Poll']['poll_id'];
        $poll = $this->getPoll($data['Poll']['poll_id']);

        $timezone_offsets = $this->getTimezoneOffsets();
        $offset = $timezone_offsets[$poll['Host']['timezone']] * (-1);

        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $date = date('Y-m-d', strtotime($data['Poll']['date']));


        foreach($data['Poll']['answers'] as $set_number => $set) {

            foreach($set as $ratings) {

                if(in_array("", $ratings, true)) {
                    continue;
                }

                $hours  = $this->getVisitTimeHours();
                $hour   = $hours[$data['Guest'][$set_number]['visit_time']];

                # setup datetime as "timezoned" time and CONVERT it to UTC!
                $datetime = date('Y-m-d H:i:s', strtotime($date.' '.$hour));    // we need the seconds for shifting here!
                $timezoned_date_object = DateTime::createFromFormat('Y-m-d H:i:s', $datetime, new DateTimeZone($poll['Host']['timezone']));
                $timezoned_date_object->setTimeZone(new DateTimeZone('UTC'));
                $datetime = $timezoned_date_object->format('Y-m-d H:i:s');

                # guest record
                $guest = array();
                $guest['Guest']['guest_type']   = $data['Guest'][$set_number]['guest_type'];
                $guest['Guest']['visit_time']   = $data['Guest'][$set_number]['visit_time'];
                $guest['Guest']['comment_customer'] = strip_tags($data['Guest'][$set_number]['comment']);
                $guest['Guest']['poll_id']      = $poll_id;
                $guest['Guest']['pin']          = User::get('user_pin');
                $guest['Guest']['user_agent']   = $_SERVER['HTTP_USER_AGENT'];
                $guest['Guest']['ip']           = $_SERVER['REMOTE_ADDR'];
                $guest['Guest']['referrer']     = $_SERVER['HTTP_REFERER'];
                $guest['Guest']['language']     = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
                $guest['Guest']['created']      = $datetime;
                $guest['Guest']['modified']     = $datetime;

                $Guest->create();
                $Guest->save($guest);

                foreach($ratings as $question_id => $rating) {
                    $answer = array();
                    $answer['Answer']['poll_id']        = $poll_id;
                    $answer['Answer']['guest_id']       = $Guest->id;
                    $answer['Answer']['question_id']    = $question_id;
                    $answer['Answer']['rating']         = $rating;
                    $answer['Answer']['ip']             = $_SERVER['REMOTE_ADDR'];
                    $answer['Answer']['created']        = $datetime;
                    $answer['Answer']['modified']       = $datetime;

                    $this->Answer->create();
                    $this->Answer->save($answer);
                }

                // save pollsview-record

                $this->PollsView->addView($pollsview_data['poll_id'], $pollsview_data['serverdata'], $pollsview_data['session_id'], $pollsview_data['created']);
            }
        }

        return true;
    }

    /**
    * upgrade a poll with given data from the controller
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function upgradePoll($data = null, $pregenerate = false) {

        if(!$data) {
            return false;
        }

        $periods_description = array(
            'm' => __('1 month', true),
            'h' => __('6 months', true),
            'y' => __('1 year', true)
        );

        $latest_upgrade = $this->getLatestUpgrade($data['Poll']['id']);
        if(!empty($latest_upgrade) && isset($latest_upgrade['valid_until'])) {
            $valid_from = $latest_upgrade['valid_until'];
            $valid_until = date('Y-m-d H:i:s', strtotime($valid_from.' '.$this->periods[$data['Poll']['upgrade']]));
        } else {
            $valid_from = date('Y-m-d H:i:s');
            $valid_until = date('Y-m-d H:i:s', strtotime($valid_from.' '.$this->periods[$data['Poll']['upgrade']]));
        }

        $description = $periods_description[$data['Poll']['upgrade']].' '.__('unlimited ratings', true);

        $price_regular_net = $data['Poll']['prices'][$data['Poll']['upgrade']];

        $invoice = array();

        $invoice['Invoice']['account_id']   = $data['Poll']['account_id'];
        $invoice['Invoice']['host_id']      = $data['Poll']['host_id'];
        $invoice['Invoice']['poll_id']      = $data['Poll']['id'];

        $invoice['Invoice']['invoice_number']       = $this->Invoice->getNextInvoiceNumber();

        $invoice['Invoice']['valid_from']           = $valid_from;
        $invoice['Invoice']['valid_until']          = $valid_until;

        $invoice['Invoice']['gender']               = $data['Invoice']['gender'];
        $invoice['Invoice']['firstname']            = $data['Invoice']['firstname'];
        $invoice['Invoice']['lastname']             = $data['Invoice']['lastname'];
        $invoice['Invoice']['address']              = $data['Invoice']['address'];
        $invoice['Invoice']['address_additional']   = $data['Invoice']['address_additional'];
        $invoice['Invoice']['zipcode']              = $data['Invoice']['zipcode'];
        $invoice['Invoice']['city']                 = $data['Invoice']['city'];
        $invoice['Invoice']['country_id']           = $data['Invoice']['country_id'];
        $invoice['Invoice']['email']                = $data['Invoice']['email'];
        $invoice['Invoice']['company']              = $data['Invoice']['company'];
        $invoice['Invoice']['ustid']                = $data['Invoice']['ustid'];
        $invoice['Invoice']['description']          = $description;

        $invoice['Invoice']['payment_type']         = $data['Invoice']['payment_type'];

        # define the payment type
        if($invoice['Invoice']['payment_type'] == 1) {
            $invoice['Invoice']['status'] = 2;      // paid (paypal)
        } elseif($invoice['Invoice']['payment_type'] == 2) {
            $invoice['Invoice']['status'] = 1;      // pending (on account)
        }

        # setup VAT
        $add_taxes = $this->Invoice->Country->isGermany($data['Invoice']['country_id']);
        if($add_taxes) {
            $invoice['Invoice']['price_vat_percent'] = $data['Poll']['mwst'];
        } else {
            $invoice['Invoice']['price_vat_percent'] = 0;
        }

        # calculate prices (apply VAT)
        $invoice['Invoice']['price_total']   = round($price_regular_net + (($price_regular_net/100)*$invoice['Invoice']['price_vat_percent']), 2);
        $invoice['Invoice']['price_vat']     = round((($price_regular_net/100)*$invoice['Invoice']['price_vat_percent']), 2);
        $invoice['Invoice']['price_netto']   = $invoice['Invoice']['price_total'] - $invoice['Invoice']['price_vat'];

        # at this point, the final price will match the normal item price (price_total etc.)
        $invoice['Invoice']['final_total']   = $invoice['Invoice']['price_total'];
        $invoice['Invoice']['final_vat']     = $invoice['Invoice']['price_vat'];
        $invoice['Invoice']['final_netto']   = $invoice['Invoice']['price_netto'];


        if($pregenerate) {
            return $invoice;
        }

        $this->Invoice->create();

        if($this->Invoice->save($invoice)) {

            # setup payment-record if its a paypal payment (or cc soon)
            if($invoice['Invoice']['payment_type'] == 1) {

                $payment = array();
                $payment['PaymentPP']['invoice_id'] = $this->Invoice->id;
                $payment['PaymentPP']['account_id'] = $data['Poll']['account_id'];
                $payment['PaymentPP']['host_id']    = $data['Poll']['host_id'];
                $payment['PaymentPP']['poll_id']    = $data['Poll']['id'];
                $payment['PaymentPP']['user_id']    = $data['Poll']['user_id'];

                $payment['PaymentPP'] = array_merge($payment['PaymentPP'], $data['Shipping']);
                $payment['PaymentPP'] = array_merge($payment['PaymentPP'], $data['Transaction']);

                if(isset($payment['PaymentPP']['DESC'])) {
                    $payment['PaymentPP']['DESCRIPTION'] = $payment['PaymentPP']['DESC'];
                    unset($payment['PaymentPP']['DESC']);
                }

                $this->Invoice->PaymentPP->create();
                if($this->Invoice->PaymentPP->save($payment)) {
                    return true;
                }

                return false;
            }

            return true;
        }

        return false;
    }


    /**
    * upgrade a poll for free: add upgrade-record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return boolean
    */
    public function upgradePollForFree($poll_id = null) {
        if(!$poll_id) {
            return false;
        }

        $this->id = $poll_id;

        $record = array();
        $record['account_id']   = $this->field('account_id');
        $record['host_id']      = $this->field('host_id');
        $record['poll_id']      = $this->id;
        $record['valid_from']   = date("Y-m-d H:i:s");
        $record['valid_until']  = date("Y-m-d H:i:s", strtotime("+1 year"));

        $this->Upgrade->create();
        if($this->Upgrade->save($record)) {
            return true;
        }

        return false;
    }


    /**
    * validate a poll-record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function validatePoll($data = null) {

        if(!$data) {
            return false;
        }

        if($data['Guest']['guest_type'] == '') {
            $this->Guest->invalidate('guest_type', __('Please select!', true));
        }
        if($data['Guest']['visit_time'] == '') {
            $this->Guest->invalidate('visit_time', __('Please select!', true));
        }

        if($this->Guest->validates()) {
            return true;
        }

        return false;

    }

    /**
    * validate an upgrade process
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function validateUpgrade($data = null) {
        if(!$data) {
            return false;
        }

        if(empty($data['Invoice']['firstname'])) {
            $this->Invoice->invalidate('firstname', __('Please enter your firstname!', true));
        }
        if(empty($data['Invoice']['lastname'])) {
            $this->Invoice->invalidate('lastname', __('Please enter your lastname!', true));
        }
        if(empty($data['Invoice']['address'])) {
            $this->Invoice->invalidate('address', __('Please enter your address!', true));
        }
        if(empty($data['Invoice']['zipcode'])) {
            $this->Invoice->invalidate('zipcode', __('Please enter your zipcode!', true));
        }
        if(empty($data['Invoice']['city'])) {
            $this->Invoice->invalidate('city', __('Please enter your city!', true));
        }
        if(empty($data['Invoice']['country_id'])) {
            $this->Invoice->invalidate('country_id', __('Please select your country!', true));
        }
        if(empty($data['Invoice']['email'])) {
            $this->Invoice->invalidate('email', __('Please enter your email!', true));
        } elseif(!filter_var($data['Invoice']['email'], FILTER_VALIDATE_EMAIL)) {
            $this->Invoice->invalidate('email', __('Please enter a valid email!', true));
        }

        if($this->Invoice->validates()) {
            return true;
        }

        return false;
    }

}
