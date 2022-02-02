<?php
class Host extends AppModel {

    public $name = 'Host';

    public $belongsTo = array(
        'Account'
    );

    public $hasMany = array(
        'Widget'
    );


}
