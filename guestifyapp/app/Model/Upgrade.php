<?php
class Upgrade extends AppModel {

    public $name = 'Upgrade';

    public $belongsTo = array(
        'Account',
        'Host',
        'Poll'
    );
    
    public $actsAs = array(
        'Containable'
    );


}
