<?php
class Account extends AppModel {

    public $name = 'Account';

    public $belongsTo = array(
        'Country'
    );
    
    public $hasMany = array(
        'ApiToken',
        'Poll',
        'Question'
    );

    public $actsAs = array(
        'Containable'
    );


}
