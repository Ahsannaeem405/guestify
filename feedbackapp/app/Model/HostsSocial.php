<?php
class HostsSocial extends AppModel {

    public $name = 'HostsSocial';

    public $useTable = 'hosts_socials';

    public $belongsTo = array(
        #'Account',
        'Host'
    );

    public $actsAs = array(
        'Containable'
    );

    /**
    * get a list of all possible types
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getTypes() {
        return array(
            1 => 'Facebook',
            2 => 'twitter',
            3 => 'LinkedIn',
            4 => 'Xing',
            5 => 'foursquare',
            6 => 'yelp',
            7 => 'tripadvisor',
            8 => 'qype',
            9 => 'restaurant kritik',
        );
    }

}