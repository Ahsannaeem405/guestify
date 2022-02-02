<?php
class LogsEmail extends AppModel {

    public $useDbConfig = 'log_db_email';

    public $name = 'LogsEmail';

    public $actsAs = array(
        'Containable'
    );

}
