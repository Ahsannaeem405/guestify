<?php
class Account extends AppModel {

    public $name = 'Account';

    public $belongsTo = array(
        'Country'
    );
    
    public $hasMany = array(
        'Host',
        'Invoice',
        'Poll',
        'Question',
        'Target',
        'Upgrade',
        'User',
        'Widget'
    );

    public $actsAs = array(
        'Containable'
    );

}
