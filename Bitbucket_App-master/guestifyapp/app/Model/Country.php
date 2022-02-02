<?php
/**
 * Country model
 *
 * @package app
 * @subpackage models
 */
class Country extends AppModel {

    public $displayField = 'name';

    public $name = 'Country';

    public $hasMany = array(
        'Account',
        'Host',
        'Invoice'
    );

    public $actsAs = array(
        'Containable',
        'Translate' => array(
            'name' => 'translatedName'
        )
    );

    /**
    * get a list of all countries
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $loclae
    * @return array $countries;
    */
    public function getCountryList($locale = null) {

        if(!$locale) {
            $locale = Configure::read('Language.default');
        }

        $this->locale = $locale;

        $countries  = $this->find('list', array(
            'order' => array(
                'Country.id' => 'ASC'
            )
        ));

        return $countries;
    }

    /**
    * get the name of a country (i18n)
    * 
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $country_id, string $locale
    * @return string
    */
    public function getCountryName($country_id = null, $locale = null) {
        if(!$locale) {
            $locale = Configure::read('Config.language');
        }
        $this->locale = $locale;

        $country = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Country.id' => $country_id
            )
        ));

        if(isset($country['Country']['name'])) {
            return($country['Country']['name']);
        }

        return '';
    }

    /**
    * get a list of states
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $loclae
    * @return array $countries;
    */
    public function getStates($country_id = null) {

        $states = array(
            1 => array(
                1 => __('Baden-Württemberg', true),
                2 => __('Bayern', true),
                3 => __('Berlin', true),
                4 => __('Brandenburg', true),
                5 => __('Bremen', true),
                6 => __('Hamburg', true),
                7 => __('Hessen', true),
                8 => __('Mecklenburg-Vorpommern', true),
                9 => __('Niedersachsen', true),
                10 => __('Nordrhein-Westfalen', true),
                11 => __('Rheinland-Pfalz', true),
                12 => __('Saarland', true),
                13 => __('Sachsen', true),
                14 => __('Sachsen-Anhalt', true),
                15 => __('Schleswig-Holstein', true),
                16 => __('Thüringen', true),
            )
        );

        return $states[$country_id];
    }

    /**
    * check if a country given by the country_id is Germany or not
    * (used to check wether to add taxes or not)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $country_id
    * @return boolean
    */
    public function isGermany($country_id = null) {
        if(!$country_id) {
            return false;
        }

        $country = $this->find('first', array(
            'conditions' => array(
                'Country.id' => $country_id
            )
        ));

        if(isset($country['Country']['name'])) {
            if(($country['Country']['name'] == 'Germany') || ($country['Country']['name'] == 'Deutschland')) {
                return true;
            }
        }

        return false;
    }

}
