<?php
class DraftsGroup extends AppModel {

    public $name = 'DraftsGroup';

    public $displayField = 'name_eng';

    public $belongsTo = array(
		'Draft'
	);

    public $hasMany = array(
        'DraftsGroupsQuestion'
    );

    public $actsAs = array(
        'Containable'
    );


}
