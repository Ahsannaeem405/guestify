<?php
class DraftsGroupsQuestion extends AppModel {

    public $name = 'DraftsGroupsQuestion';

    public $displayField = 'name_eng';

    public $belongsTo = array(
		'DraftsGroup'
	);


    public $actsAs = array(
        'Containable'
    );


}
