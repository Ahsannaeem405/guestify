<?php
class Group extends AppModel {

    public $name = 'Group';

    public $displayField = 'name';

    public $belongsTo = array(
        'Poll'
    );

    public $hasMany = array(
        'Question'
    );

    public $actsAs = array(
        'Containable',
        'Translate' => array(
            'name' => 'translatedName'
        )
    );


}
