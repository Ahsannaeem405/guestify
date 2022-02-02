<?php
class Account extends AppModel {

    public $name = 'Account';

    public $belongsTo = array();
    
    public $hasMany = array(
        'Host',
        'Poll',
        'Question',
        'User'
    );

    public $actsAs = array(
        'Containable'
    );


}
