<?php
class UsersController extends AppController {

    public $name = 'Users';

    public $uses = array('User');

    public function beforeFilter() {
        parent::beforeFilter();
    }

}
