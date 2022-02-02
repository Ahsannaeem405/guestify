<?php
class PermissionComponent extends Object {

    var $components = array('Session');

    # needed placeholder functions
    public function initialize(Controller $controller, $settings = array()) {
        $this->controller = $controller;
    }

    public function startup(Controller $controller) {
    }

    public function shutdown(Controller $controller) {
    }

    public function beforeRender(Controller $controller) {
    }

    public function beforeRedirect(Controller $controller) {
    }



    public function isAdmin() {
        if(!class_exists('User')) {
            return false;
        }

        $role_id = User::get('role_id');
        if(empty($role_id)) {
            return false;
        }
        if($role_id == 1) {
            return true;
        }
        return false;
    }


    public function isClient() {
        if(!class_exists('User')) {
            return false;
        }
        $role_id = User::get('role_id');
        if(empty($role_id)) {
            return false;
        }
        if($role_id == 2) {
            return true;
        }
        return false;
    }


    public function isPremiumPoll($poll_id = null) {
        if(!class_exists('User')) {
            return false;
        }

        if(!$poll_id) {
            return false;
        }

        # check if a valid invoice is found with valid until > now
        $Invoice = ClassRegistry::init('Invoice');
        $check = $Invoice->find('first', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.poll_id' => $poll_id,
                'Invoice.status' => array(0, 1, 2),
                'Invoice.valid_until >' => date('Y-m-d H:i:s')
            )
        ));
        if(!empty($check)) {
            return true;
        }

        # check if a valid upgrade is found with valid until > now
        $Upgrade = ClassRegistry::init('Upgrade');
        $check = $Upgrade->find('first', array(
            'conditions' => array(
                'Upgrade.deleted' => 0,
                'Upgrade.poll_id' => $poll_id,
                'Upgrade.valid_until >' => date('Y-m-d H:i:s')
            )
        ));

        if(!empty($check)) {
            return true;
        }
        
        return false;
    }

}
