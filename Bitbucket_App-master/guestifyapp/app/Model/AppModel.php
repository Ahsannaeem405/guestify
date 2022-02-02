<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public $recursive = -1;

    public $periods = array(
        'm' => '+ 1 month',
        'h' => '+ 6 month',
        'y' => '+ 1 year'
    );


    /**
    * get a list of timezones we can use for Cake's TimeHelper
    * set the Config by
    *       Configure::write('Config.timezone', 'Europe/London');
    * best place to set the config obviously AppController, when checked if a user is logged in
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTimezones() {

        //Our lovely list of Timezones
        $timezones = array(
            "Pacific/Kwajalein" => __("(GMT -12:00) Eniwetok, Kwajalein", true),
            "Pacific/Samoa" => __("(GMT -11:00) Midway Island, Samoa", true),
            "Pacific/Honolulu" => __("(GMT -10:00) Hawaii", true),
            "America/Anchorage" => __("(GMT -9:00) Alaska", true),
            "America/Los_Angeles" => __("(GMT -8:00) Pacific Time (US & Canada)", true),
            "America/Denver" => __("(GMT -7:00) Mountain Time (US & Canada)", true),
            "America/Chicago" => __("(GMT -6:00) Central Time (US & Canada), Mexico City", true),
            "America/New_York" => __("(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima", true),
            "Atlantic/Bermuda" => __("(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz", true),
            "Canada/Newfoundland" => __("(GMT -3:30) Newfoundland", true),
            "Brazil/East" => __("(GMT -3:00) Brazil, Buenos Aires, Georgetown", true),
            "Atlantic/Azores" => __("(GMT -2:00) Mid-Atlantic", true),
            "Atlantic/Cape_Verde" => __("(GMT -1:00 hour) Azores, Cape Verde Islands", true),
            "Europe/London" => __("(GMT) Western Europe Time, London, Lisbon, Casablanca", true),
            "Europe/Brussels" => __("(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris", true),
            "Europe/Helsinki" => __("(GMT +2:00) Kaliningrad, South Africa", true),
            "Asia/Baghdad" => __("(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg", true),
            "Asia/Tehran" => __("(GMT +3:30) Tehran", true),
            "Asia/Baku" => __("(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi", true),
            "Asia/Kabul" => __("(GMT +4:30) Kabul", true),
            "Asia/Karachi" => __("(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent", true),
            "Asia/Calcutta" => __("(GMT +5:30) Bombay, Calcutta, Madras, New Delhi", true),
            "Asia/Dhaka" => __("(GMT +6:00) Almaty, Dhaka, Colombo", true),
            "Asia/Bangkok" => __("(GMT +7:00) Bangkok, Hanoi, Jakarta", true),
            "Asia/Hong_Kong" => __("(GMT +8:00) Beijing, Perth, Singapore, Hong Kong", true),
            "Asia/Tokyo" => __("(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk", true),
            "Australia/Adelaide" => __("(GMT +9:30) Adelaide, Darwin", true),
            "Pacific/Guam" => __("(GMT +10:00) Eastern Australia, Guam, Vladivostok", true),
            "Asia/Magadan" => __("(GMT +11:00) Magadan, Solomon Islands, New Caledonia", true),
            "Pacific/Fiji" => __("(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka", true)
        );

        return $timezones;
    }


    /**
    * get a list of timezones we can use for Cake's TimeHelper
    * set the Config by
    *       Configure::write('Config.timezone', 'Europe/London');
    * best place to set the config obviously AppController, when checked if a user is logged in
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTimezoneNames() {

        //Our lovely list of Timezones
        $timezone_names = array(
            "Pacific/Kwajalein" => __('Pacific/Kwajalein', true),
            "Pacific/Samoa" => __('Pacific/Samoa', true),
            "Pacific/Honolulu" => __('Pacific/Honolulu', true),
            "America/Anchorage" => __('America/Anchorage', true),
            "America/Los_Angeles" => __('America/Los_Angeles', true),
            "America/Denver" => __('America/Denver', true),
            "America/Chicago" => __('America/Chicago', true),
            "America/New_York" => __('America/New_York', true),
            "Atlantic/Bermuda" => __('Atlantic/Bermuda', true),
            "Canada/Newfoundland" => __('Canada/Newfoundland', true),
            "Brazil/East" => __('Brazil/East', true),
            "Atlantic/Azores" => __('Atlantic/Azores', true),
            "Atlantic/Cape_Verde" => __('Atlantic/Cape_Verde', true),
            "Europe/London" => __('Europe/London', true),
            "Europe/Brussels" => __('Europe/Brussels', true),
            "Europe/Helsinki" => __('Europe/Helsinki', true),
            "Asia/Baghdad" => __('Asia/Baghdad', true),
            "Asia/Tehran" => __('Asia/Tehran', true),
            "Asia/Baku" => __('Asia/Baku', true),
            "Asia/Kabul" => __('Asia/Kabul', true),
            "Asia/Karachi" => __('Asia/Karachi', true),
            "Asia/Calcutta" => __('Asia/Calcutta', true),
            "Asia/Dhaka" => __('Asia/Dhaka', true),
            "Asia/Bangkok" => __('Asia/Bangkok', true),
            "Asia/Hong_Kong" => __('Asia/Hong_Kong', true),
            "Asia/Tokyo" => __('Asia/Tokyo', true),
            "Australia/Adelaide" => __('Australia/Adelaide', true),
            "Pacific/Guam" => __('Pacific/Guam', true),
            "Asia/Magadan" => __('Asia/Magadan', true),
            "Pacific/Fiji" => __('Pacific/Fiji', true)
        );

        return $timezone_names;
    }


    /**
    * get a list of timezones we can use for Cake's TimeHelper
    * set the Config by
    *       Configure::write('Config.timezone', 'Europe/London');
    * best place to set the config obviously AppController, when checked if a user is logged in
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTimezoneOffsets() {

        //Our lovely list of Timezones
        $timezones = array(
            "Pacific/Kwajalein" => -43200,
            "Pacific/Samoa" => -39600,
            "Pacific/Honolulu" => 36000,
            "America/Anchorage" => -32400,
            "America/Los_Angeles" => -28800,
            "America/Denver" => -25200,
            "America/Chicago" => -21600,
            "America/New_York" => -18000,
            "Atlantic/Bermuda" => -14400,
            "Canada/Newfoundland" => -12600,
            "Brazil/East" => -10800,
            "Atlantic/Azores" => -7200,
            "Atlantic/Cape_Verde" => -3600,
            "Europe/London" => 0,
            "Europe/Brussels" => 3600,
            "Europe/Helsinki" => 7200,
            "Asia/Baghdad" => 10800,
            "Asia/Tehran" => 12600,
            "Asia/Baku" => 14400,
            "Asia/Kabul" => 16200,
            "Asia/Karachi" => 18000,
            "Asia/Calcutta" => 19800,
            "Asia/Dhaka" => 21600,
            "Asia/Bangkok" => 25200,
            "Asia/Hong_Kong" => 28800,
            "Asia/Tokyo" => 32400,
            "Australia/Adelaide" => 34200,
            "Pacific/Guam" => 36000,
            "Asia/Magadan" => 39600,
            "Pacific/Fiji" => 43200
        );

        return $timezones;
    }


    /**
    * upload an image to the image server via ftp
    * $directory contains name of folder (e.g. 'products')
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $file, string $directory
    * @return string $file['name'] or NULL in case of errors
    */
    public function ftpupload($filename = null, $directory = null) {
        if(!$filename || !$directory) {
            return false;
        }


        $sizes = array(
            '300',
            '600',
            'original'
        );

        require_once APP . 'Vendor/aws/aws-autoloader.php';

        $client_options = array(
            'credentials' => array(
                'key' => Configure::read('S3_IMAGESERVER_KEY'),
                'secret' => Configure::read('S3_IMAGESERVER_SECRET')
            ),
            'region' => Configure::read('S3_IMAGESERVER_REGION'),
            'version' => Configure::read('S3_IMAGESERVER_VERSION')
        );

        $s3client = S3Client::factory($client_options);


        foreach($sizes as $key => $size) {

            $fullpath_local = APP . 'webroot' . DS . 'img' . DS . $directory . DS . $size . DS . $filename;
            $fullpath_s3    = strtolower(Configure::read('Environment')) . DS . $directory . DS . $size . DS . $filename;

            // pr($fullpath_local);
            // pr($fullpath_s3);
            // exit;

            try {

                $result = $s3client->putObject(array(
                    'Bucket'     => Configure::read('S3_IMAGESERVER_BUCKET'),
                    'Key'        => $fullpath_s3,
                    'SourceFile' => $fullpath_local,
                    'ACL'        => 'public-read'
                ));

            } catch (S3Exception $e) {

                pr($e->getMessage());
                exit;

                return false;
            }

            if($result == true) {
                unlink($fullpath_local);
            }
        }

        return true;
    }


    /**
    * geocode a given address-block
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $lookup
    * @return array | boolean false
    */
    public function geocodeAddress($lookup = null) {
        if(!$lookup) {
            return false;
        }

        # if information is missing, return false
        if(empty($lookup['address']) || empty($lookup['zipcode']) || empty($lookup['city']) || empty($lookup['country_id'])) {
            return false;
        }

        $Country = ClassRegistry::init('Country');
        $lookup['country_name'] = $Country->getCountryName($lookup['country_id']);

        # build address string
        $string = $lookup['address'].', '.$lookup['zipcode'] . ' ' . $lookup['city'] . ', ' . $lookup['country_name'];
        $prepared_address = str_replace(' ', '+', $string);

        # try geocoding via google API
        App::uses('HttpSocket', 'Network/Http');
        $http = new HttpSocket();
        $request = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . $prepared_address.'&sensor=false';
        $temp_result = $http->get($request);
        $result = json_decode($temp_result, true);

        # check if results given, if so return lat/lon data as simple array
        if(isset($result['results'][0]['geometry']['location']['lat']) && isset($result['results'][0]['geometry']['location']['lng'])) {
            $geocodes = array(
                'lat' => $result['results'][0]['geometry']['location']['lat'],
                'lng' => $result['results'][0]['geometry']['location']['lng']
            );
            return $geocodes;
        }

        return $result;
    }


    /**
    * get the comment choices for the widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $comment_choices
    */
    public function getCommentChoices(){
        $comment_choices = array(
            'none' => __('None'), 
            'last5' => __('Last 5'), 
            'top5' => __('Top 5'), 
            'last10' => __('Last 10'), 
            'top10' => __('Top 10')
        );
        return $comment_choices;
    }


    /**
    * get the comment choices keys for the widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $comment_choices
    */
    public function getCommentChoicesKeys(){
        $comment_choices = array(
            'none', 
            'last5', 
            'top5', 
            'last10', 
            'top10'
        );
        return $comment_choices;
    }


    /**
    * get the format choices for the widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $formats
    */
    public function getFormats(){
        $formats = array(
            'portrait' => __('Portrait'), 
            'landscape' => __('Landscape'), 
            'square' => __('Square')
        );
        return $formats;
    }


    /**
    * get the format choices keys for the widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $formats
    */
    public function getFormatsKeys(){
        $formats = array(
            'portrait', 
            'landscape', 
            'square'
        );
        return $formats;
    }


    /**
    * get all connected host ids by a given account_id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return array $host_ids
    */
    public function getHostIds($account_id = null) {
        if(!$account_id) {
            return array();
        }

        $Host = ClassRegistry::init('Host');

        $hosts = $Host->find('all', array(
            'conditions' => array(
                'Host.account_id' => $account_id
            )
        ));

        $host_ids = Set::ClassicExtract($hosts, '{n}.Host.id');

        return $host_ids;
    }


    /**
    * get all connected host ids by a given account_id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return array $host_ids
    */
    public function getHosts($account_id = null) {
        if(!$account_id) {
            return array();
        }

        $Host = ClassRegistry::init('Host');

        $hosts = $Host->find('all', array(
            'conditions' => array(
                'Host.account_id' => $account_id
            ),
            'order' => 'Host.name ASC'
        ));

        return $hosts;
    }


    /**
    * get the period choices for the widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $periods
    */
    public function getPeriods(){
        $periods = array(
            'week_1' => __('One week'),
            'month_1' => __('One month'), 
            'month_3' => __('Three months'), 
            'month_6' => __('Six months'), 
            'year_1' => __('One Year'), 
            'all' => __('From the beginning')
        );
        return $periods;
    }


    /**
    * get the period choices keys for the widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $periods
    */
    public function getPeriodsKeys(){
        $periods = array(
            'week_1',
            'month_1', 
            'month_3', 
            'month_6', 
            'year_1', 
            'all'
        );
        return $periods;
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
    * get the style choices for the widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $styles
    */
    public function getStyles(){
        $styles = array(
            'standard' => __('Standard'),
            'nubuck' => __('Nubuck'), 
            'retro' => __('Retro'), 
            'newage' => __('Newage'), 
            'party' => __('Party'), 
            'aquarell' => __('Aquarell')
        );
        return $styles;
    }


    /**
    * get the style choices keys for the widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $styles
    */
    public function getStylesKeys(){
        $styles = array(
            'standard',
            'nubuck', 
            'retro', 
            'newage', 
            'party', 
            'aquarell'
        );
        return $styles;
    }


    /**
    * get ratings in words
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getRatingsInWords() {
        return array(
            10 => array(
                'text' => __('Amazing!', true),
                'label' => 'success'
            ),
            9 => array(
                'text' => __('Excellent', true),
                'label' => 'success'
            ),
            8 => array(
                'text' => __('Good', true),
                'label' => 'success'
            ),
            7 => array(
                'text' => __('Satisfied', true),
                'label' => 'success'
            ),
            6 => array(
                'text' => __('Average', true),
                'label' => 'warning'
            ),
            5 => array(
                'text' => __('Not bad', true),
                'label' => 'warning'
            ),
            4 => array(
                'text' => __('Dissatisfied', true),
                'label' => 'warning'
            ),
            3 => array(
                'text' => __('Bad', true),
                'label' => 'danger'
            ),
            2 => array(
                'text' => __('Awful', true),
                'label' => 'danger'
            ),
            1 => array(
                'text' => __('Do you care?', true),
                'label' => 'danger'
            ),
            0 => array(
                'text' => __('No rating', true),
                'label' => 'default'
            )
        );
    }


    /**
    * get the widgetelements for a widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $types
    */
    public function getWidgetElementTypes(){
        $types = array(
            'gsi' => __('GSI'), 
            'trend' => __('Trend'), 
            'ratingcount' => __('Ratingcount'), 
            'ratinglabel' => __('Ratinglabel')
        );
        return $types;
    }


    /**
    * get the widgetelements keys for a widget
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array $types
    */
    public function getWidgetElementTypesKeys(){
        $types = array(
            'gsi', 
            'trend', 
            'ratingcount', 
            'ratinglabel'
        );
        return $types;
    }


    /**
    * remap an array to use the model id as array-key
    * neat little function to build datasets and increase
    * performance incredibly by avoiding contains on massive
    * datasets
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return mixed result
    */
    public function remapData($data = null, $model = null, $key = 'id') {

        $result = array();

        foreach($data as $rec) {
            $result[$rec[$model][$key]] = $rec;
        }

        return $result;
    }

    
    /**
    * translate the db entry of a commentchoice for displaying
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $choice
    * @return string $comment_choice
    */
    public function translateCommentChoice($choice = null){
        if(!$choice){
            return false;
        }
        
        switch ($choice){
            case 'none':
                $comment_choice = 'None';
                break;
            case 'last5':
                $comment_choice = 'Last 5 Comments';
                break;
            case 'top5':
                $comment_choice = 'Top 5 Comments';
                break;
            case 'last10':
                $comment_choice = 'Last 10 Comments';
                break;
            case 'top10':
                $comment_choice = 'Top 10 Comments';
                break;
            default:
                $comment_choice = 'error';
                break;
        }

        return $comment_choice;
    }

   
    /**
    * translate the db entry of a format for displaying
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $choice
    * @return string $format
    */
    public function translateFormat($choice = null){
        if(!$choice){
            return false;
        }

        switch ($choice){
            case 'portrait':
                $format = 'Portrait';
                break;
            case 'landscape':
                $format = 'Landscape';
                break;
            case 'square':
                $format = 'Square';
                break;
            default:
                $format = 'error';
                break;
        }

        return $format;
    }

    
    /**
    * translate the db entry of a period for displaying
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $choice
    * @return string $period
    */
    public function translatePeriod($choice = null){
        if(!$choice){
            return false;
        }

        switch ($choice){
            case 'week_1':
                $period = 'One week';
                break;
            case 'month_1':
                $period = 'One month';
                break;
            case 'month_3':
                $period = 'Three months';
                break;
            case 'month_6':
                $period = 'Six months';
                break;
            case 'year_1':
                $period = 'One year';
                break;
            case 'all':
                $period = 'From the beginning';
                break;
            default:
                $period = 'error';
                break;
        }

        return $period;
    }


    /**
    * translate the db entry of a style for displaying
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $choice
    * @return string $style
    */
    public function translateStyle($choice = null){
        if(!$choice){
            return false;
        }

        switch ($choice){
            case 'standard':
                $style = 'Standard';
                break;
            case 'nubuck':
                $style = 'Nubuck';
                break;
            case 'retro':
                $style = 'Retro';
                break;
            case 'newage':
                $style = 'Newage';
                break;
            case 'party':
                $style = 'Party';
                break;
            case 'aquarell':
                $style = 'Aquarell';
                break;
            default:
                $style = 'error';
                break;
        }

       return $style;
    }


    /**
    * translate the db entry of a widgetelementtype for displaying
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param array $widgetElement
    * @return string $type
    */
    public function translateWidgetElementType($widgetElement = null){
        if(!$widgetElement || !is_array($widgetElement)){
            return false;
        }

        switch ($widgetElement['type']){
            case 'gsi':
                $type = 'GSI';
                break;
            case 'trend':
                $type = 'Trend';
                break;
            case 'ratingcount':
                $type = 'Ratingcount';
                break;
            case 'ratinglabel':
                $type = 'Ratinglabel';
                break;
            case 'comment':
                $type = $this->translateCommentChoice($widgetElement['param']);
                break;
            default:
                $type = 'error';
                break;
        }

        return $type;
    }

}
