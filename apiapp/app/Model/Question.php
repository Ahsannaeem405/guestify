<?php
class Question extends AppModel {

    public $name = 'Question';

    public $belongsTo = array(
        'Account',
        'Poll',
        'Group'
    );

    public $hasMany = array(
        'Answer'
    );

    public $actsAs = array(
        'Containable',
        'Translate' => array(
            'question' => 'translatedQuestion'
        )
    );


}
