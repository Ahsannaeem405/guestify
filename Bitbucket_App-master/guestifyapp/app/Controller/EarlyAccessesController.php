<?php
class EarlyAccessesController extends AppController {

    public $name = 'EarlyAccesses';

    public $uses = array('EarlyAccess');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'debugEarylAccessMail',
            'validateEmail'
        ));
    }


   /**
    * send a confirmation with invoice PDF attached to upgrade user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id
    * @return boolean
    */
    private function __sendEarlyAccessNotification($email = null) {


        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('smtp_amazon');

        $Email->to(Configure::read('Email.dev'));
        $Email->subject(__('A user signed up for early access!', true));
        $Email->template('notification_early_access');
        
        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));

        $Email->viewVars(compact('email'));

        try {
            $Email->send();
        } catch(SocketException $e) {
            #$this->updateEmailLog($Email, $e);
            return false;
        }

        return true;
    }


   /**
    * test-generation of the weekly report
    * (uses last 7 days scorecard to provide all needed information)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $user_id
    * @return void
    */
    public function debugEarylAccessMail($email) {

        $this->set(compact('email'));

        $this->layout = 'Emails/html/default';
        $View = new View($this, false);
        $html = $View->render('../Emails/html/notification_early_access');
        print_r($html);
        exit;
    }


    /**
    * validate and add an early access entry
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function validateEmail() {
        
        if($this->RequestHandler->isAjax()) {
            
            $email = $this->params->query('email');
            $email = strip_tags(trim(urldecode($email)));

            $result = 1;
            if(empty($email)) {
                $result = __('Please enter your email-address!', true);
            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result = __('Please enter a valid email-address!', true);
            } else {
                $check = $this->EarlyAccess->find('first', array(
                    'conditions' => array(
                        'EarlyAccess.email' => $email
                    )
                ));

                if(!empty($check)) {
                    $result = __('Your email is already registered!', true);
                }
            }

            if($result == 1) {
                
                $record = array();
                $record['email'] = $email;

                $this->EarlyAccess->create();
                $this->EarlyAccess->save($record);

                $this->__sendEarlyAccessNotification($email);

                $this->Session->write('EaryAccess', 1);
            }

            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($result);
        }

        $this->redirect($this->referer());
    }

}
