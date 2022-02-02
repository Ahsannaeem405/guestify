<?php
class Role extends AppModel {

    public $name = 'Role';

    public $belongsTo = array();
    
    public $hasMany = array(
        'User'
    );

    public $actsAs = array(
        'Containable'
    );


}
