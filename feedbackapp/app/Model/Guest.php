<?php
class Guest extends AppModel {

    public $name = 'Guest';

    public $belongsTo = array(
        'Poll'
    );
    
    public $hasMany = array(

    );

    public $actsAs = array(
        'Containable'
    );


}
