<?php
class User extends AppModel {

    public $name = 'User';

    public $belongsTo = array(
        'Account',
        'Role'
    );
    
    public $hasMany = array();

    public $actsAs = array(
        'Containable'
    );


}
