<?php
class Answer extends AppModel {

    public $name = 'Answer';

    public $belongsTo = array(
        'Poll',
        'Question'
    );
    
    public $hasMany = array(

    );

    public $actsAs = array(
        'Containable'
    );


}
