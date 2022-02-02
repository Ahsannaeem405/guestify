<?php
class Answer extends AppModel {

    public $name = 'Answer';

    public $belongsTo = array(
        'Guest',
        'Poll',
        'Question'
    );

    public $hasMany = array(

    );

    public $actsAs = array(
        'Containable'
    );


}
