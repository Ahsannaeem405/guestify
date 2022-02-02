<?php
class ReportsShell extends Shell {

    public function sendWeeklyReports() {

        #require_once(APP . 'Vendor/gettext_tokenizer.php');

        $date = date('Y-m-d H:i:s');

        # Configure::read not working from console, take arg to determine
        # the environment
        if(isset($this->args[0])) {
            $env = $this->args[0];
        } else {
            $env = 'LOCAL';
        }

        if(isset($this->args[1])) {
            $year = $this->args[1];
        } else {
            $year = date('Y');
        }

        if(isset($this->args[2])) {
            $current_weeknumber = $this->args[2];
        } else {
            $current_weeknumber = date('W');
        }

        # REMOVE THIS WHEN DEPLOYING!
        #$current_weeknumber++;

        $current_weeknumber = sprintf("%02u", $current_weeknumber);
        $current_week_start = date( "Y-m-d", strtotime($year."W".$current_weeknumber."1")); // First day of week

        $week_start = date( "Y-m-d", strtotime($current_week_start . "- 7 days"));
        $week_end   = date( "Y-m-d", strtotime($week_start . "+ 6 days") ); 
        
        $weeknumber = date('W', strtotime($week_start));
        $weeknumber = sprintf("%02u", $weeknumber);

        $year = date('Y', strtotime($week_start));

        # shell configuration
        Configure::write('debug', 1);
        Configure::write('Environment', $env);

        Configure::write('dev_email', 'dev@digital-cube.de');

        Configure::write('Email.no_reply_email', 'noreply@guestify.net');
        Configure::write('Email.no_reply_name', 'guestify.net');

        Configure::write('Email.setting_standard', 'smtp_amazon');

        Configure::write('Cache.disable', true);
        Configure::write('Cache.check', false);

        // invoike app_controller
        App::uses('CakeRequest', 'Network');
        App::uses('CakeResponse', 'Network');
        App::uses('Controller', 'Controller');
        App::uses('AppController', 'Controller');


        // request/response may be optional, depends on your use
        $controller = new AppController(new CakeRequest(), new CakeResponse());
        $controller->constructClasses();
        $controller->startupProcess();


        switch($env) {
            # DEV
            case 'LOCAL':
                $server = 'http://guestify';
                Configure::write('CDN.Host', 'https://s3.eu-central-1.amazonaws.com/media-guestify-net/local/');
                Configure::write('NON_SSL_HOST', 'http://guestify');
                break;
            # STAGE
            case 'STAGE':
                $server = 'http://stage.guestify.net';
                Configure::write('CDN.Host', 'https://s3.eu-central-1.amazonaws.com/media-guestify-net/stage/');
                Configure::write('NON_SSL_HOST', 'http://stage.guestify.net');
                break;
            # LIVE
            case 'LIVE':
                $server = 'http://www.guestify.net';
                Configure::write('CDN.Host', 'https://s3.eu-central-1.amazonaws.com/media-guestify-net/live/');
                Configure::write('NON_SSL_HOST', 'http://www.guestify.net');
                break;
            default: 
                $server = 'http://guestify';
                Configure::write('CDN.Host', 'https://s3.eu-central-1.amazonaws.com/media-guestify-net/local/');
                Configure::write('NON_SSL_HOST', 'http://guestify');
                break;
        }

        Configure::write('NON_SSL_HOST', $server);

        # needed models
        $Report = ClassRegistry::init('Report');
        $reports = $Report->generateWeeklyReports($year, $weeknumber, $env);

        $formats['eng']['date'] = 'Y-m-d';
        $formats['deu']['date'] = 'd.m.Y';

        $count = 0;
        $errors = array();
        $job = 'Weekly Report';

        # initialize email
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail(Configure::read('Email.setting_standard'));


        foreach($reports as $report) {

            # set user specific locale for email
            if(!empty($report['User']['locale'])) {
                $locale = $report['User']['locale'];
            } else {
                $locale = 'eng';
            }

            Configure::write('Config.language', $locale);
            Configure::write('Language.default', $locale);
            $controller->Session->write('Config.language', $locale);

            # configure needed invidual settings
            if($env != 'LIVE') {
                $Email->to(Configure::read('dev_email'));
            } else {
                $Email->to($report['User']['email']);
            }

            $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));
            $Email->replyTo(Configure::read('Email.no_reply_email'));
            $Email->subject(__('guestify Weekly Report', true));
            $Email->template('cron/weekly_report');
            $Email->layout = 'default';

            $Email->viewVars(compact('dateformat', 'formats', 'locale', 'report', 'week_end', 'week_start'));


            try {
                $success = $Email->send();
            } catch(SocketException $e) {
                #$controller->updateEmailLog($Email, $e);   // implement that bitch ASAP!
            }

            if($success) {
                $count++;
            } else {
                $error = array();
                $error['email'] = $report['User']['email'];
                array_push($errors, $error);
            }
        }


        Configure::write('Config.language', 'eng');
        Configure::write('Language.default', 'eng');
        $controller->Session->write('Config.language', 'eng');

        # keep the dev team informed about status of cron
        $Email->to(Configure::read('dev_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));
        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->subject(__('Status report for cronjob', true).': '.$job);
        $Email->template('cron/status');
        $Email->layout = 'default';

        $Email->viewVars(compact('count', 'date', 'errors', 'job'));

        try {
            $success = $Email->send();
        } catch(SocketException $e) {
            $controller->updateEmailLog($Email, $e);
        }

        exit(0);
    }

}
