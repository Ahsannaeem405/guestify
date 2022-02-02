<?php
class WeathersShell extends Shell {


    public function generateDailyWeather() {

        #require_once(APP . 'Vendor/gettext_tokenizer.php');

        $date = date('Y-m-d H:i:s');

        # Configure::read not working from console, take arg to determine
        # the environment
        if(isset($this->args[0])) {
            $env = $this->args[0];
        } else {
            $env = 'local';
        }

        if(isset($this->args[1])) {
            $date_weather = $this->args[1];
        } else {
            $date_weather = date('Y-m-d');
        }

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
            case 'local':
                $server = 'http://guestify';
                Configure::write('CDN.Host', 'https://s3.eu-central-1.amazonaws.com/media-guestify-net/local/');
                Configure::write('NON_SSL_HOST', 'http://guestify');
                break;
            # STAGE
            case 'stage':
                $server = 'http://stage.guestify.cloudcontrolled.com';
                Configure::write('CDN.Host', 'https://s3.eu-central-1.amazonaws.com/media-guestify-net/stage/');
                Configure::write('NON_SSL_HOST', 'http://stage.guestify.cloudcontrolled.com');
                break;
            # LIVE
            case 'live':
                $server = 'http://www.guestify.net';
                Configure::write('CDN.Host', 'https://s3.eu-central-1.amazonaws.com/media-guestify-net/live/');
                Configure::write('NON_SSL_HOST', 'http://www.guestify.net');
                break;
            # LOCAL
            default: 
                $server = 'http://guestify';
                Configure::write('CDN.Host', 'https://s3.eu-central-1.amazonaws.com/media-guestify-net/local/');
                Configure::write('NON_SSL_HOST', 'http://guestify');
                break;
        }

        Configure::write('NON_SSL_HOST', $server);

        # needed models
        $Weather = ClassRegistry::init('Weather');
        $results = $Weather->generateWeatherData($date_weather, $env);

        $job = 'Daily Weather Generation';

        # initialize email
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail(Configure::read('Email.setting_standard'));

        Configure::write('Config.language', 'eng');
        Configure::write('Language.default', 'eng');
        $controller->Session->write('Config.language', 'eng');

        # keep the dev team informed about status of cron
        $Email->to(Configure::read('dev_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));
        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->subject(__('Status report for cronjob', true).': '.$job);
        $Email->template('cron/status_weather_daily');
        $Email->layout = 'default';

        $Email->viewVars(compact('date', 'job', 'results'));

        try {
            $success = $Email->send();
        } catch(SocketException $e) {
            $controller->updateEmailLog($Email, $e);
        }

        exit(0);
    }

}
