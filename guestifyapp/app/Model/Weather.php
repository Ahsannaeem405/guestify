<?php
class Weather extends AppModel {

    public $name = 'Weather';

    public $belongsTo = array();
    
    public $hasMany = array();

    public $actsAs = array(
        'Containable'
    );

    /**
    * test the weather-data gethering function (used by cron!)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function generateWeatherData($date = null, $env = null) {

        if(!$env) {
            $env = 'local';
        }

        if(!$date) {
            $date = date('Y-m-d');
        }

        Configure::write('Weather.API_KEY', '58939f4b6506d3ed760a6b6c4d6e085d');
        $Host = ClassRegistry::init('Host');
        $Host->setDataSource($env);

        $hosts = $Host->find('all', array(
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

        $results = array();

        foreach($hosts as $host) {

            # try getting weather data via lat/lon
            $string_api_call = 'http://api.openweathermap.org/data/2.5/weather?lat='.round($host['Host']['lat'], 2).'&lon='.round($host['Host']['lng'], 2).'&units=metric&API_KEY='.Configure::read('Weather.API_KEY');
            $data = file_get_contents($string_api_call);
            if(empty($data)) {
                # add some logging here!
                continue;
            }

            $weather = array();
            $weather['Weather']['date']     = $date;
            $weather['Weather']['lat']      = $host['Host']['lat'];
            $weather['Weather']['lng']      = $host['Host']['lng'];
            $weather['Weather']['city']     = $host['Host']['city'];
            $weather['Weather']['zipcode']  = $host['Host']['zipcode'];
            $weather['Weather']['country_id'] = $host['Host']['country_id'];
            $weather['Weather']['data']     = $data;

            $this->setDataSource($env);
            $this->create();
            $this->save($weather);

            $weather['Host'] = $host['Host'];

            array_push($results, $weather);
        }

        return $results;
    }

}
