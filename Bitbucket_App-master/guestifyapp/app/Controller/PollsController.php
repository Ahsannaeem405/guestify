<?php
App::uses('CakeTime', 'Utility');

class PollsController extends AppController {

    public $name = 'Polls';

    #public $uses = array('Poll');

    public $components = array('Paypal');



    /**
    * activate a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function activate($poll_id = null, $redirect = false) {

        if(!$poll_id) {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        if($this->Poll->saveField('status', 1)) {
            $this->Session->setFlash(__('The poll was activated!', true), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The poll could not be activated!', true), 'default', array('class' => 'alert alert-danger'));
        }

        if($redirect) {
            $this->redirect('/' . $redirect);
        }

        $this->redirect($this->referer());
    }


    /**
    * activate API-access for a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function activateApiAccess($poll_id = null) {

        if(!$poll_id) {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        $api_key = $this->Poll->generateApiKey('poll', User::get('account_id'), $this->Poll->field('host_id'), $this->Poll->id);
        $api_secret = $this->Poll->generateApiSecret('poll', User::get('account_id'), $this->Poll->field('host_id'), $this->Poll->id);

        if($this->Poll->saveField('api_accessible', 1) && $this->Poll->saveField('api_key', $api_key) && $this->Poll->saveField('api_secret', $api_secret)) {
                $this->Session->setFlash(__('The poll is now activated for API-access!', true), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The poll could not be activated for API-access!', true), 'default', array('class' => 'alert alert-danger'));
        }

        $this->redirect($this->referer());
    }


    /**
    * deactivate API-access for a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function deactivateApiAccess($poll_id = null) {

        if(!$poll_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        if($this->Poll->saveField('api_accessible', 0) && $this->Poll->saveField('api_key', NULL) && $this->Poll->saveField('api_accessible', NULL)) {
                $this->Session->setFlash(__('The poll was deactivated for API-access!', true), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The poll could not be deactivated for API-access!', true), 'default', array('class' => 'alert alert-danger'));
        }

        $this->redirect($this->referer());
    }


    /**
    * add a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function add() {

        if($this->RequestHandler->isAjax()) {

            $data = array();
            $data['Poll']['title']      = trim(strip_tags(rawurldecode($this->params->query('title'))));
            $data['Poll']['host_id']    = trim(strip_tags(rawurldecode($this->params->query('host_id'))));
            $data['Poll']['template_id'] = trim(strip_tags(rawurldecode($this->params->query('template_id'))));
            $data['Poll']['scale']      = trim(strip_tags(rawurldecode($this->params->query('scale'))));

            $data['Poll']['locale']     = trim(strip_tags(rawurldecode($this->params->query('locale'))));
            $data['Poll']['code']       = trim(strip_tags(rawurldecode($this->params->query('code'))));
            $data['Poll']['account_id'] = User::get('account_id');

            if($this->Poll->add($data)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return $this->Poll->id;
            } else {
                $result = $this->Poll->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }

        return false;
    }

    /**
    * add feedback manually to a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function addFeedback($poll_id = null) {

        if(!$poll_id) {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        if($this->RequestHandler->isPost()) {

            #http://api.openweathermap.org/data/2.5/weather?lat=35&lon=139 58939f4b6506d3ed760a6b6c4d6e085d

            $data = $this->data;

            $errors = array();

            # validate the given date
            if(empty($data['Poll']['date'])) {
                $errors['date'] = __('Please select the date when the answer(s) have been given!', true);
            } else {
                $data['Poll']['date'] = date('Y-m-d', strtotime($data['Poll']['date']));
                $temp = explode('-', $data['Poll']['date']);
                if(count($temp) != 3) {
                    $errors['date'] = __('Please select a valid date (YYYY-MM-DD)!', true);
                } elseif(!checkdate($temp[1], $temp[2], $temp[0])) {
                    $errors['date'] = __('Please select a valid date (YYYY-MM-DD)!', true);
                }
            }

            $scale_max = 0;
            $poll = $this->Poll->getPoll($data['Poll']['poll_id']);
            #Configure::write('Config.timezone', $poll['Host']['timezone']);

            foreach($poll['Groups'] as $key => $group) {
                foreach($group['Questions'] as $question) {
                    if($question['Question']['scale'] > $scale_max) {
                        $scale_max = $question['Question']['scale'];
                    }
                }
            }


            $data['PollsView'] = array();
            $data['PollsView']['poll_id']       = $poll_id;
            $data['PollsView']['serverdata']    = $_SERVER;
            $data['PollsView']['session_id']    = $this->Session->read('Config.userAgent');
            $data['PollsView']['created']       = $data['Poll']['date'];

            # validate the answers (currenty
            foreach($data['Poll']['answers'] as $set_number => $set) {
                $set_count = count($set['answer']);

                $has_answers = 0;
                foreach($set['answer'] as $answer_number => $answer) {
                    if(!empty($answer)) {
                        $has_answers = 1;
                    }
                }

                if($has_answers) {

                    if(empty($data['Guest'][$set_number]['visit_time'])) {
                        $errors[$set_number] = __('Please select a guest visit time!', true);
                    }
                    if(empty($data['Guest'][$set_number]['guest_type'])) {
                        $errors[$set_number] = __('Please select a guest type!', true);
                    }

                    foreach($set['answer'] as $answer_number => $answer) {
                        if(empty($answer)) {
                            $errors[$set_number] = __('Please complete the answer-set!', true);
                        } else {
                            if((intval($answer) < 1) || (intval($answer) > $scale_max)) {
                                $errors[$set_number] = __('Please enter only numbers from 1 to', true).' '.$scale_max.'!';
                            }
                        }
                    }
                }
            }

            $this->Poll->locale = $this->locale;

            if(empty($errors)) {

                if($this->Poll->saveManualFeedback($data)) {

                    $this->Session->setFlash('<span class="icon icon-info-sign"></span> '.__('The feedback was added!', true), 'default', array('class' => 'message alert alert-success', 'escape' => false));
                    $this->redirect(array('action' => 'addFeedback', $poll_id));
                }

            } else {
                $this->Session->setFlash('<span class="icon icon-info-sign"></span> '.__('Some information is missing!', true), 'default', array('class' => 'message alert alert-danger', 'escape' => false));
                $this->set(compact('errors'));
            }
        }

        $poll = $this->Poll->getPoll($poll_id, $this->locale);
        $max_scale = $this->Poll->getPollsMaxScale($poll_id);

        $statuses = $this->Poll->getStatuses();
        $guest_types = $this->Poll->getGuestTypes();
        $visit_times = $this->Poll->getVisitTimes();

        $this->set(compact('guest_types', 'max_scale', 'poll', 'statuses', 'visit_times'));
    }

    /**
    * add a poll by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function adminAdd() {

        if($this->RequestHandler->isAjax()) {

            $data = array();
            $data['Poll']['title']      = trim(strip_tags(rawurldecode($this->params->query('title'))));
            $data['Poll']['host_id']    = trim(strip_tags(rawurldecode($this->params->query('host_id'))));
            $data['Poll']['locale']     = trim(strip_tags(rawurldecode($this->params->query('locale'))));
            $data['Poll']['code']       = trim(strip_tags(rawurldecode($this->params->query('code'))));

            $this->Poll->Host->id = $data['Poll']['host_id'];
            $data['Poll']['account_id'] = $this->Poll->Host->field('account_id');

            if($this->Poll->add($data)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return $this->Poll->id;
            } else {
                $result = $this->Poll->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }

        return false;
    }

    /**
    * edit a poll record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    * @copyright 2014 digitalcube GmbH Co KG
    */
    public function adminEdit($poll_id = null) {
        if(!$poll_id) {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPut()) {
            $data = $this->data;

            $data['Poll']['color'] = str_replace('#', '', $data['Poll']['color']);

            $this->Poll->id = intval($data['Poll']['id']);
            if(!$this->Poll->exists()) {
                throw new NotFoundException();
            }

            if($this->Poll->edit($data)) {
                $this->Session->setFlash(__('Your changes were saved!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'adminSettings', $poll_id));
            } else {
                $this->Session->setFlash(__('Your changes could not be saved!', true), 'default', array('class' => 'alert alert-danger'));
            }
        } else {
            $this->request->data = $this->Poll->findById($poll_id);
        }

        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }

        $poll = $this->Poll->findById($poll_id);
        if(empty($poll)) {
            throw new NotFoundException();
        }

        $statuses = $this->Poll->getStatuses();
        $options_themes = $this->Poll->getThemes();

        $this->set(compact('poll', 'statuses', 'options_themes'));
    }

    /**
    * list all polls
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function adminIndex() {

        $conditions = array();
        $conditions['Poll.deleted']     = 0;

        $this->Poll->virtualFields['count_ratings'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';
        $this->Poll->virtualFields['count_views'] = 'SELECT COUNT(*) FROM polls_views AS PollsView WHERE PollsView.poll_id = Poll.id';

        # paginate the list with manual options
        $this->paginate = array(
            'contain' => array(
                'Account',
                'Host',
                'Invoice'
            ),
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'Poll.id DESC'
        );
        $polls = $this->paginate('Poll');

        #pr($polls);
        #exit;

        $statuses = $this->Poll->getStatuses();

        $this->set(compact('polls', 'statuses'));

        $this->params['navtabs.main'] = 'polls';
    }

    /**
    * view the settings of a poll by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function adminSettings($poll_id = null) {
        if(!$poll_id) {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }

        $this->Poll->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';
        $this->Poll->virtualFields['count_views'] = 'SELECT COUNT(*) FROM polls_views AS PollsView WHERE PollsView.poll_id = Poll.id';

        $poll = $this->Poll->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.deleted' => 0,
                'Poll.id' => $poll_id
            )
        ));

        if(empty($poll)) {
            throw new NotFoundException();
        }

        $statuses = $this->Poll->getStatuses();
        $upgrade_periods = $this->config['periods'];

        $this->set(compact('poll', 'statuses', 'upgrade_periods'));


        # QR-Code section
        $filename_300 = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'_300.png';
        $filename_150 = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'_150.png';
        $filename_80 = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'_80.png';

        # make some qr-code magic with the google api
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$filename_300)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '300x300';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$filename_300);
        }
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$filename_150)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '150x150';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$filename_150);
        }
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$filename_80)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '80x80';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$filename_80);
        }

        $this->set(compact('filename_300', 'filename_150', 'filename_80'));


        $type = $this->Poll->getType($poll_id);
        $invoices = $this->Poll->getInvoices($poll_id);
        $themes = $this->Poll->getThemes();

        $statuses_invoices = $this->Poll->Invoice->getStatuses();

        $this->set(compact('invoices', 'statuses_invoices', 'themes', 'type'));

        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $max_scale = $this->Poll->getPollsMaxScale($poll_id);
        $this->set(compact('max_scale'));

        $upgrade_history = $this->Poll->getUpgradeHistory($poll_id);
        $this->set(compact('upgrade_history'));
    }

    /**
    * upgdede a poll by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function adminUpgrade() {

        if($this->RequestHandler->isAjax()) {

            $poll_id = intval($this->params->query('poll_id'));
            $period = $this->params->query('period');

            $this->Poll->id = $poll_id;

            $record = array();
            $record['account_id']   = $this->Poll->field('account_id');
            $record['host_id']      = $this->Poll->field('host_id');
            $record['poll_id']      = $poll_id;

            # add check for existing upgrades/invoices here (do it like the normal upgrade function!)
            $latest_upgrade = $this->Poll->getLatestUpgrade($poll_id);
            if(!empty($latest_upgrade) && isset($latest_upgrade['valid_until'])) {
                $record['valid_from'] = $latest_upgrade['valid_until'];
                $record['valid_until'] = date('Y-m-d H:i:s', strtotime($record['valid_from'].' '.$this->config['periods'][$period]));
            } else {
                $record['valid_from'] = date('Y-m-d H:i:s');
                $record['valid_until'] = date('Y-m-d H:i:s', strtotime($record['valid_from'].' '.$this->config['periods'][$period]));
            }

            $this->Poll->Upgrade->create();
            if($this->Poll->Upgrade->save($record)) {
                $result = true;
            } else {
                $result = $this->Poll->Upgrade->invalidFields();
            }

            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($result);
        }

    }

    /**
    * list all upgrades by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function adminUpgrades() {

        # paginate the list with manual options
        $this->paginate = array(
            'contain' => array(
                'Account',
                'Host',
                'Poll'
            ),
            'conditions' => array(
                'Upgrade.deleted' => 0
            ),
            'limit' => 20,
            'order' => 'Upgrade.created DESC'
        );
        $upgrades = $this->paginate('Upgrade');

        $this->set(compact('upgrades'));
    }

    /**
    * called before any controller action is called
    * will invoke the app_controller's beforeFilter()-method (parent)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Session->check('Auth.User.id')) {
            $this->redirect('/');
        }
    }

    /**
    * confirm a paypal upgrade
    * referer comes from paypal, take the data/token
    * and initiate the actual payment
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function confirmUpgradePaypal() {

        if(!isset($_SESSION['TOKEN'])) {
            $this->Session->setFlash(__('Authentication token lost during redirect! Please try again! (Nothing was charged so far!)', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect(array('controller' => 'polls', 'action' => 'upgrade_problem'));
        }

        $this->setupPaypal();

        # get all details of the checkout for further actions + write them to session
        $transaction = array();
        $shipping_details = $this->Paypal->GetExpressCheckoutDetails($_SESSION['TOKEN']);    // get the payment data incl. PAYERID
        $shipping_details['TAXPERCENT'] = $this->config['tax_percent_standard'];

        foreach($shipping_details as $key => $value) {
            $shipping_details[$key] = urldecode($value);
        }

        $this->Session->write('Upgrade.Shipping', $shipping_details);

        # validation 1st step: check if checkout was successful
        $ack = strtoupper($shipping_details["ACK"]);

        #$ack = 'FAILED';   // uncomment for error-testing!

        # catch failed transactions
        if(($ack != "SUCCESS") && ($ack != "SUCCESSWITHWARNING")) {

            $this->Poll->log('Shipping details fetching failed!', 'paypal_log');
            $this->Poll->log($transaction, 'paypal_log');

            $upgrade = $this->Session->read('Upgrade');
            $upgrade['Problem']['type'] = 'shipping_details_failed';
            $this->Session->write('Upgrade', $upgrade);

            $this->Session->setFlash(__('Could not retrieve checkout details from Paypal! Nothing was charged so far, please try again!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect(array('action' => 'upgrade_problem'));
        }

        $_SESSION['PAYERID'] = $shipping_details['PAYERID'];

        $temp_transaction = $this->Paypal->DoExpressCheckoutPayment($_SESSION['TOKEN']);    // do the actual checkout and charge the user

        $transaction = array();
        foreach($temp_transaction as $key => $value) {
            $transaction[$key] = urldecode($value);
        }


        # validation 2nd step: check if payment was done successful
        $ack = strtoupper($temp_transaction["ACK"]);

        #$ack = 'FAILED';   // uncomment for error-testing!

        # catch failed DoExpressCheckout AND already completed transaction (FF sending-twice bug fallback!)
        if(($ack != "SUCCESS") && ($ack != "SUCCESSWITHWARNING")) {
            if(!isset($transaction['PAYMENT_L_ERRORCODE0']) || ($transaction['PAYMENT_L_ERRORCODE0'] != '10415')) {

                $this->Poll->log('DoExpressCheckout failed!', 'paypal_log');
                $this->Poll->log($transaction, 'paypal_log');

                $upgrade = $this->Session->read('Upgrade');
                $upgrade['Problem']['type'] = 'do_express_checkout_failed';
                $upgrade['Transaction'] = $transaction;
                $this->Session->write('Upgrade', $upgrade);

                $this->Session->setFlash(__('Your paypal account could not be charged! Please try again!', true), 'default', array('class' => 'negative'));
                $this->redirect(array('action' => 'upgrade_problem'));
            }
        }


        $this->Session->write('Upgrade.Transaction', $transaction);


        # get all needed data from session AND paypal (have been thrown together just before!)
        $upgrade = $this->Session->read('Upgrade');

        # read the session data and create the invoice/payment records and update account
        if($this->Poll->upgradePoll($upgrade)) {

            $upgrade = $this->Session->read('Upgrade');
            $invoice = $this->Poll->Invoice->getInvoice($this->Poll->Invoice->id);
            $upgrade['UpgradeInvoice'] = $invoice;
            $this->Session->write('Upgrade', $upgrade);

            $this->__confirmationMailUpgrade($this->Poll->Invoice->id);
            $this->__confirmationMailUpgradeAdmins($this->Account->Invoice->id);

            $this->Session->setFlash(__('Your poll has been upgraded!', true), 'default', array('class' => 'alert alert-success'));
            $this->redirect(array('action' => 'upgrade_success'));
        } else {
            $this->Poll->log('Upgrade failed!', 'paypal_log');
            $this->Poll->log($this->Poll->Invoice->invalidFields(), 'paypal_log');

            $this->Session->setFlash(__('We could not upgrade your poll! Please contact our customer-support to resolve this issue!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect(array('action' => 'upgrade_problem'));
        }
    }

    /**
    * deactivate a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function deactivate($poll_id = null) {
        if(!$poll_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        if($this->Poll->saveField('status', 0)) {
            $this->Session->setFlash(__('The poll was deactivated!', true), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The poll could not be deactivated!', true), 'default', array('class' => 'alert alert-danger'));
        }

        $this->redirect($this->referer());
    }

   /**
    * send an upgrade notice to the admins
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id, boolean $send_email
    * @return void | exception $e
    */
    public function debuConfirmationMailUpgradeAdmins($invoice_id = null, $send_email = false) {

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        # get invoice and all containing information
        $invoice = $this->Poll->Invoice->getInvoice($invoice_id);
        $invoice['Invoice']['country_name'] = $this->Poll->Invoice->Country->getCountryName($invoice['Invoice']['country_id'], $this->locale);

        # meta-data
        $payment_types = $this->Poll->Invoice->getPaymentTypes();
        $periods = $this->config['periods_by_name'];
        $formats = $this->formats;

        if($send_email == true) {
            $filename = $this->generateUpgradeInvoice($invoice_id);

            App::uses('CakeEmail', 'Network/Email');
            $Email = new CakeEmail('smtp_amazon');
            $Email->to(Configure::read('Email.payment_notification'));

            # build subject prefix if needed (all but live version!)
            $subject = '';
            $env = Configure::read('Environment');
            if($env != 'LIVE') {
                $subject .= '['.strtoupper($env).'] - ';
            }
            $subject .= __('A poll was upgraded to PREMIUM!', true);

            $Email->subject($subject);
            $Email->template('upgrade_poll_admins');
            $Email->replyTo(Configure::read('Email.no_reply_email'));
            $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));
            $Email->attachments(array(APP . 'files' . DS . $filename));
            $Email->viewVars(compact('formats', 'invoice', 'payment_types', 'periods'));

            try {
                $Email->send();

            } catch(SocketException $e) {

                #$this->updateEmailLog($Email, $e);

                // pr($e);
                // exit;
            }
        }

        $this->set(compact('formats', 'invoice', 'payment_types', 'periods'));

        $this->layout = 'Emails/html/default';
        $View = new View($this, false);
        $html = $View->render('../Emails/html/upgrade_poll_admins');
        print_r($html);
        exit;
    }

   /**
    * test-generation of the weekly report
    * (uses last 7 days scorecard to provide all needed information)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $date
    * @return mixed $reports
    */
    public function debugWeeklyReport($user_id = null, $year = null, $weeknumber = null, $locale = null) {

        if(!$year) {
            $year = date('Y');
        }
        if(!$weeknumber) {
            $weeknumber = date('W');
        }
        if(!$locale) {
            $locale = 'eng';
        }

        $Report = ClassRegistry::init('Report');
        $reports = $Report->generateWeeklyReports($year, $weeknumber);
        $report = $reports[$user_id];

        $formats['eng']['date'] = 'Y-m-d';
        $formats['deu']['date'] = 'd.m.Y';

        $week_start = date( "Y-m-d", strtotime($year."W".$weeknumber."1")); // First day of week
        $week_end   = date( "Y-m-d", strtotime($year."W".$weeknumber."7") );

        $this->set(compact('formats', 'locale', 'report', 'week_end', 'week_start'));

        $this->layout = 'Emails/html/default';
        $View = new View($this, false);
        $html = $View->render('../Emails/html/cron/weekly_report');
        print_r($html);
        exit;
    }

    /**
    * delete a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function delete($poll_id = null) {
        if(!$poll_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        if($this->Poll->saveField('deleted', 1)) {
            $this->Session->setFlash(__('The poll was deleted!', true), 'default', array('class' => 'alert alert-success'));
            if($this->Permission->isAdmin()) {
                $this->redirect(array('action' => 'adminIndex'));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->Session->setFlash(__('The poll could not be deleted!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }
    }


    /**
    * download table card
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $format
    * @return void
    */
    public function downloadCard($poll_id = null, $format = null, $debug = false) {
        // mPDF class has many notices - suppress them
        error_reporting(0);


        $poll = $this->Poll->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.id' => $poll_id
            )
        ));

        if($format == 'LANG') {
            $type = 'lang';
        } else {
            $type = strtolower($format);
        }

        $filename = 'pollcard_'.$poll['Poll']['id'].'_'.md5(strtotime(date('Y-m-d H:i:s'))).'_'.$type.'.pdf';

        $formats = $this->formats;

        ### move this into a subfunction so we can use it everywhere! ###

        # QR-Code section
        $qrcode_300 = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'_300.png';
        $qrcode_150 = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'_150.png';
        $qrcode_80 = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'_80.png';

        # make some qr-code magic with the google api
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$qrcode_300)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '300x300';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$qrcode_300);
        }
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$qrcode_150)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '150x150';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$qrcode_150);
        }
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$qrcode_80)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '80x80';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$qrcode_80);
        }

        $this->set(compact('formats', 'poll', 'qrcode_300', 'qrcode_150', 'qrcode_80'));

        # render all html into variable
        #$this->layout = 'pollcard_pdf';
        $View = new View($this, false);
        $html = $View->element("Pollcards/pollcard_".$type);

        if($debug == true) {
            print_r($html);
            exit;
        }

        include(APP . 'Vendor/mpdf/mpdf.php');
        if($format == 'LANG') {
            $mpdf = new mPDF('',array(100,210),'', '', '1', '1', '1', '1');
        } else {
            $mpdf = new mPDF('', $type, '', '', '1', '1', '1', '1');
        }

        $stylesheet = file_get_contents(APP . 'View/Elements/Pollcards/pollcard_'.$type.'.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html, 2);

        #$mpdf->WriteHTML($html);
        $mpdf->Output(APP. 'files/'.$filename);


        # make that shit downloadable...
        $name = explode('.', $filename);
        $complete_path = APP . 'files/' . $filename;
        $filesize = filesize($complete_path);

        $this->viewClass = 'Media';
        $params = array(
            'id' => $filename,
            'name' => 'pollcard_'.strtolower($format),
            'size' => $filesize,
            'download' => true,
            'extension' => 'pdf',
            'path' => APP . 'files' . DS
        );

        $this->set($params);

        #pr($filename);
        #exit;


        #$this->autoRender = false;
        /*
        App::import('Vendor','xtcpdf_pollcard');

        switch($format) {
            case 'A6':


                # create a dummy TCPDF object to work with
                $pdf_page_orientation = 'P';
                $pdf_unit = 'mm';
                $pdf_page_format = 'A6';
                $tcpdf = new XTCPDF($pdf_page_orientation, $pdf_unit, $pdf_page_format, true, 'UTF-8', false);

                # set the format type (see APP/Vendor/xtcpdf_pollcard.php for header/footer functions!)
                $tcpdf->type = 'A6';

                # PDF metadata settings (could be removed as well...)
                $tcpdf->SetCreator(PDF_CREATOR);
                $tcpdf->SetAuthor("guestify.net");
                $tcpdf->SetTitle('guestify pollcard');
                $tcpdf->SetSubject('Pollcard - ' . $poll['Poll']['title']);

                # standard margin definition for whole page
                $pdf_margin_top     = 5;
                $pdf_margin_right   = 5;
                $pdf_margin_left    = 5;
                $tcpdf->SetMargins($pdf_margin_left, $pdf_margin_top, $pdf_margin_right, true);

                # header definition => see APP/Vendor/xtcpdf_pollcard.php for header (and footer) definitions!
                $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $tcpdf->xheadertext = $poll['Host']['name'];

                # footer definition
                $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                $tcpdf->xfootertext = 'Add some useful footertext here...';

                # handle page-breaks
                $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                # create the page with the desired orientation/size (defined as DIN!)
                $tcpdf->AddPage('P', 'A6');

                # render all html into variable
                $View = new View($this, false);
                $html = $View->element("Polls/pollcard_a6");

                # uncomment to see the raw html output (can be used to debug data and to see all styles BEFORE tcpdf will render it as PDF)


                #$this->layout = 'ajax';
                #$this->autoRender = false;
                #$this->render('/Elements/Polls/pollcard_a6', 'ajax');
                #return;

                break;
        }


        # write the actual pdf and save it to disk
        $tcpdf->writeHTML($html, true, false, true, false, '');
        $tcpdf->Output(APP. 'files/'.$filename, 'F');


        pr($filename);
        exit;
        */

        # return filename -> pass to download function and set a nice name!
        #return $filename;
    }

    /**
    * edit a poll record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    * @copyright 2014 digitalcube GmbH Co KG
    */
    public function edit($poll_id = null) {
        if(!$poll_id) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPut()) {
            $data = $this->data;

            $data['Poll']['color'] = str_replace('#', '', $data['Poll']['color']);

            $this->Poll->id = intval($data['Poll']['id']);
            if(!$this->Poll->exists() || ($this->Poll->field('account_id') != User::get('account_id'))) {
                throw new NotFoundException();
            }

            if($this->Poll->edit($data)) {
                $this->Session->setFlash(__('Your changes were saved!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'settings', $poll_id));
            } else {
                $this->Session->setFlash(__('Your changes could not be saved!', true), 'default', array('class' => 'alert alert-danger'));
            }
        } else {
            $this->request->data = $this->Poll->findById($poll_id);
        }

        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists() ||($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        $this->Poll->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';
        $poll = $this->Poll->findById($poll_id);
        if(empty($poll)) {
            throw new NotFoundException();
        }

        $statuses = $this->Poll->getStatuses();
        $options_themes = $this->Poll->getThemes();
        $options_scales = $this->Poll->getScaleOptions();
        $max_scale = $this->Poll->getPollsMaxScale($poll_id);

        $this->set(compact('max_scale', 'poll', 'statuses', 'options_scales', 'options_themes'));
    }

    /**
    * edit a poll record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    * @copyright 2014 digitalcube GmbH Co KG
    */
    public function exportExcel($poll_id = null, $type = null, $date_value = null, $date_value_additional = null) {

        if(!$poll_id) {
            throw new NotFoundException();
        }

        # check permissions
        $this->Poll->id = $poll_id;
        if(!$this->Permission->isAdmin()) {

            if(!$this->Poll->exists() || ($this->Poll->field('account_id') != User::get('account_id'))) {
                throw new NotFoundException();
            }
            if(!$this->Permission->isPremiumPoll($poll_id)) {
                throw new NotFoundException();
            }
        }


        # make this ONE model function!
        $poll = $this->Poll->getPoll($poll_id, $this->locale, $date_value);
        $poll_data = $this->Poll->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.id' => $poll_id
            )
        ));

        switch($type) {
            case 'last30':
                $report_type = __('Last 30 days');
                if(!$date_value) {
                    $date_value = date('Y-m-d');
                }

                $day_last = date('Y_m_d', strtotime($date_value));
                $day_first = date('Y_m_d', strtotime($date_value.' - 30 days'));
                # format correctly here!

                $period_last = date($this->formats['date'], strtotime($date_value));
                $period_first = date($this->formats['date'], strtotime($date_value.' - 30 days'));;

                $filename = $poll_data['Host']['name'].'_'.$poll_data['Poll']['title'].'_'.$day_first.'-'.$day_last;
                $period = $period_first.' - '.$period_last;

                $scorecard = $this->Poll->getScorecardCounts($poll_id, 'last30', $date_value);
                $answers = $this->Poll->getPollAnswers($poll_id, $this->locale, $type = 'last30', $date_value);

                break;

            case 'day':
                $report_type = __('Day');
                if(!$date_value) {
                    $date_value = date('Y-m-d');
                }

                $filename = $poll_data['Host']['name'].'_'.$poll_data['Poll']['title'].'_'.$date_value;
                $period = date($this->formats['date'], strtotime($date_value));;

                $answers = $this->Poll->getPollAnswers($poll_id, $this->locale, $type = 'day', $date_value);
                $scorecard = $this->Poll->getScorecardCounts($poll_id, 'day', $date_value);

                break;

            case 'week':
                $report_type = __('Week');
                $year = $date_value;
                $weeknumber = $date_value_additional;

                if(!$date_value && !$date_value_additional) {
                    $year = date('Y');
                    $weeknumber = date('N');
                }

                $filename = $poll_data['Host']['name'].'_'.$poll_data['Poll']['title'].'_'.$year.'_W'.$weeknumber;

                $period = date($this->formats['year_month'], strtotime($date_value));;
                $period = $year.', W'.$weeknumber.' ('.date($this->formats['date'], strtotime($year."W".$weeknumber."1")).' - '.date($this->formats['date'], strtotime($year."W".$weeknumber."7")).')';

                $weeknumber = sprintf("%02u", $weeknumber);
                $week_start = date( "Y-m-d", strtotime($year."W".$weeknumber."1")); // First day of week
                $week_end   = date( "Y-m-d", strtotime($year."W".$weeknumber."7") );

                $answers = $this->Poll->getPollAnswers($poll_id, $this->locale, $type = 'week', $date = $week_start);

                $groups = $this->Poll->getGrouplist($poll_id, $this->locale);

                $week = array(
                    'start' => $week_start,
                    'end' => $week_end
                );
                $scorecard = $this->Poll->getScorecardCounts($poll_id, 'week', $week);

                $answers = $this->Poll->getPollAnswers($poll_id, $this->locale, $type = 'month', $date_value);
                $scorecard = $this->Poll->getScorecardCounts($poll_id, 'month', $date_value);

                break;

            case 'month':
                $report_type = __('Month');
                if(!$date_value) {
                    $date_value = date('Y-m');
                }

                $filename = $poll_data['Host']['name'].'_'.$poll_data['Poll']['title'].'_'.$date_value;
                $period = date($this->formats['year_month'], strtotime($date_value));;

                $answers = $this->Poll->getPollAnswers($poll_id, $this->locale, $type = 'month', $date_value);
                $scorecard = $this->Poll->getScorecardCounts($poll_id, 'month', $date_value);

                break;
        }

        $answers = Set::sort($answers, '{n}.Guest.created', 'asc');
        $max_scale = $this->Poll->getPollsMaxScale($poll_id);
        $groups = $this->Poll->getGrouplist($poll_id, $this->locale);


        # get needed additional data
        $labels = array(0 => 'primary', 1 => 'info', 2 => 'warning');
        $count = 0;
        $guest_types = $this->Poll->getGuestTypes();
        $visit_times = $this->Poll->getVisitTimes();
        ## end of to-move part ##

        # import the time helper
        #App::import('Helper', 'Time');
        #$Time = new TimeHelper();


        $extension = 'xls';
        $path = APP.'files/exports_excel/';
        $complete_path = $path . $filename.'.'.$extension;
        $fh = fopen($path . $filename.'.'.$extension, 'w') or die("can't open file");

        $header  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>'."\n";
        $header .= '<html>'."\n";
        $header .= '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>'."\n";


        $body = '';

        # preamble with general information and overall scores
        $body .= '<table style="margin: 0; padding: 0; font-size: 9pt;">';

            $body .= '<tr>';
                $body .= '<td>'.__('guestify Rating Export', true).' - '.$report_type.'</td>';
            $body .= '</tr>';

            $body .= $this->exportGetBlankLine('tr');

            $body .= '<tr>';
                $body .= '<td>'.$poll_data['Host']['name'].' - '.$poll_data['Poll']['title'].'</td>';
            $body .= '</tr>';

            $body .= '<tr>';
                $body .= '<td>'.__('Export created', true).': '.date($this->formats['datetime']).'</td>';
            $body .= '</tr>';

            $body .= $this->exportGetBlankLine('tr');

            $body .= '<tr>';
                $body .= '<td>'.__('Period', true).': '.$period.'</td>';
            $body .= '</tr>';

            $body .= $this->exportGetBlankLine('tr');

        $body .= '</table>';

        $body .= '<table style="margin: 0; padding: 0; font-size: 9pt;">';
            $body .= '<thead>';
                $body .= '<tr>';
                    $body .= '<th>'.__('Scores', true).'</th>';
                    $body .= '<th>'.__('Current', true).'</th>';
                    $body .= '<th>'.__('Prev', true).'</th>';
                $body .= '</tr>';
            $body .= '<thead>';

            $body .= '<tbody>';
                $body .= '<tr>';
                    $body .= '<td>'.__('GSI', true).'</td>';
                    $body .= '<td>'.round($scorecard['current']['average_overall']*(10/$max_scale), 2).'</td>';
                    $body .= '<td>'.round($scorecard['prev']['average_overall']*(10/$max_scale), 2).'</td>';
                $body .= '</tr>';

                $body .= '<tr>';
                    $body .= '<td>'.__('Overall score', true).'</td>';
                    $body .= '<td>'.$scorecard['current']['average_overall'].'</td>';
                    $body .= '<td>'.$scorecard['prev']['average_overall'].'</td>';
                $body .= '</tr>';

                $body .= '<tr>';
                    $body .= '<td>'.__('Views', true).'</td>';
                    $body .= '<td>'.$scorecard['views']['current'].'</td>';
                    $body .= '<td>'.$scorecard['views']['prev'].'</td>';
                $body .= '</tr>';

                $body .= '<tr>';
                    $body .= '<td>'.__('Ratings', true).'</td>';
                    $body .= '<td>'.$scorecard['current']['guest_count_overall'].'</td>';
                    $body .= '<td>'.$scorecard['prev']['guest_count_overall'].'</td>';
                $body .= '</tr>';
            $body .= '<tbody>';

        $body .= '</table>';

        $body .= $this->exportGetBlankLine();

        $body .= '<table style="margin: 0; padding: 0; font-size: 9pt;">';
            $body .= '<thead>';
                $body .= '<tr>';
                    $body .= '<th>'.__('Averages by group', true).'</th>';
                    $body .= '<th>'.__('Current', true).'</th>';
                    $body .= '<th>'.__('Prev', true).'</th>';
                $body .= '</tr>';
            $body .= '</thead>';

            $body .= '<tbody>';
                foreach($scorecard['current']['average_by_group'] as $group_id => $rating) {
                    $body .= '<tr>';
                        $body .= '<td>'.$groups[$group_id].'</td>';
                        $body .= '<td>'.$scorecard['current']['average_by_group'][$group_id].'</td>';
                        $body .= '<td>'.$scorecard['prev']['average_by_group'][$group_id].'</td>';
                    $body .= '</tr>';
                }
            $body .= '</tbody>';

        $body .= '</table>';

        $body .= $this->exportGetBlankLine();


        # table header
        $body .= '<table style="margin: 0; padding: 0; font-size: 9pt;">';
            $body .= '<thead>';
                $body .= '<tr>';
                    $body .= '<th></th>';
                    foreach($poll['Groups'] as $key => $group) {
                        $body .= '<th colspan="'.count($group['Questions']).'">';
                            $body .= $group['Group']['name'];
                        $body .= '</th>';
                    }
                    $body .= '<th colspan="5"></th>';
                $body .= '</tr>';

                $body .= '<tr>';
                    $body .= '<th>'.__('Guest ID', true).'</th>';
                    foreach($poll['Groups'] as $group) {
                        foreach($group['Questions'] as $question) {
                            $body .= '<th class="text-center">';
                                $body .= 'G'.$group['Group']['order'].' '.__('Q', true).$question['Question']['order'];
                            $body .= '</th>';
                        }
                    }
                    $body .= '<th>'.__('Visit time', true).'</th>';
                    $body .= '<th>'.__('Guest type', true).'</th>';
                    $body .= '<th>'.__('Guest comment', true).'</th>';
                    $body .= '<th>'.__('Created', true).'</th>';
                    $body .= '<th></th>';
                $body .= '</tr>';
            $body .= '</thead>';

            $averages = array();

            $body .= '<tbody>';
                foreach($answers as $answer) {
                    $body .= '<tr>';
                        $body .= '<td>'.$answer['Guest']['id'].'</td>';
                        foreach($poll['Groups'] as $key => $group) {
                            foreach($group['Questions'] as $question) {
                                $body .= '<td class="text-center">';
                                    if(isset($answer['Answers'][$question['Question']['id']])) {
                                        $body .= $answer['Answers'][$question['Question']['id']];
                                        if($answer['Guest']['status'] == 1) {
                                            if(!isset($averages[$question['Question']['id']])) {
                                                $averages[$question['Question']['id']] = array();
                                            }
                                            array_push($averages[$question['Question']['id']], $answer['Answers'][$question['Question']['id']]);
                                        }
                                    }
                                $body .= '</td>';
                            }
                        }
                        $body .= '<td>'.$visit_times[$answer['Guest']['visit_time']].'</td>';
                        $body .= '<td>'.$guest_types[$answer['Guest']['guest_type']].'</td>';

                        $body .= '<td>';
                            if(!empty($answer['Guest']['comment_customer'])) {
                                $body .= $answer['Guest']['comment_customer'];
                            }
                        $body .= '</td>';

                        $body .= '<td>'.date($this->formats['datetime'], strtotime($answer['Guest']['created'])).'</td>';
                    $body .= '</tr>';
                }
            $body .= '</tbody>';


            $body .= '<tfoot>';
                $body .= '<tr>';
                    $body .= '<td class="text-center lead">';
                        $body .= '&empty;';
                    $body .= '</td>';
                        foreach($poll['Groups'] as $group) {
                            foreach($group['Questions'] as $question) {
                                $body .= '<td class="text-center lead">';
                                    if(isset($averages[$question['Question']['id']])) {
                                        $count = count($averages[$question['Question']['id']]);
                                        $overall = 0;
                                        foreach($averages[$question['Question']['id']] as $av) {
                                            $overall += $av;
                                        }
                                        if($count > 0) {
                                            $body .= round($overall/$count, 1);
                                        } else {
                                            $body .= '-';
                                        }
                                    } else {
                                        $body .= '-';
                                    }
                                $body .= '</td>';
                            }
                        }
                    $body .= '<td colspan="5"></td>';
                $body .= '</tr>';
            $body .= '</tfoot>';

        $body .= '</table>';

        $body .= $this->exportGetBlankLine();

        // encode file to UTF-8
        $data = "\xEF\xBB\xBF". $header . $body;

        fwrite($fh, $data);
        fclose($fh);

        #$complete_path = APP . 'files/' . $filename;
        $filesize = filesize($complete_path);

        $this->viewClass = 'Media';
        $params = array(
            'id' => $filename.'.'.$extension,
            'name' => $filename,
            'size' => $filesize,
            'download' => true,
            'extension' => 'pdf',
            'path' => APP . 'files/exports_excel/' . DS
        );

        $this->set($params);
    }

    /**
    * edit a poll record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    * @copyright 2014 digitalcube GmbH Co KG
    */
    public function exportExcelYear($poll_id = null, $year = null) {

        if(!$poll_id) {

        }

        if(!$year) {
            $year = date('Y');
        }

        # make this ONE model function!
        $poll = $this->Poll->getPoll($poll_id, $this->locale, $year);

        $answers = $this->Poll->getPollAnswers($poll_id, $this->locale, $type = 'year', $year);
        $scorecard = $this->Poll->getScorecardCounts($poll_id, 'year', $year);
        $groups = $this->Poll->getGrouplist($poll_id, $this->locale);
        $max_scale = $this->Poll->getPollsMaxScale($poll_id);

        $poll_data = $this->Poll->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.id' => $poll_id
            )
        ));

        $report_type = __('Year');

        $filename = $poll_data['Host']['name'].'_'.$poll_data['Poll']['title'].'_'.$year;

        $period = $year;

        $answers = Set::sort($answers, '{n}.Guest.created', 'asc');

        # get needed additional data
        $labels = array(0 => 'primary', 1 => 'info', 2 => 'warning');
        $count = 0;
        $guest_types = $this->Poll->getGuestTypes();
        $visit_times = $this->Poll->getVisitTimes();


        $extension = 'xls';
        $path = APP.'files/exports_excel/';
        $complete_path = $path . $filename.'.'.$extension;
        $fh = fopen($path . $filename.'.'.$extension, 'w') or die("can't open file");

        $header  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>'."\n";
        $header .= '<html>'."\n";
        $header .= '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>'."\n";


        $body = '';

        # preamble with general information and overall scores
        $body .= '<table style="margin: 0; padding: 0; font-size: 9pt;">';

            $body .= '<tr>';
                $body .= '<td>'.__('guestify Rating Export', true).' - '.$report_type.'</td>';
            $body .= '</tr>';

            $body .= $this->exportGetBlankLine('tr');

            $body .= '<tr>';
                $body .= '<td>'.$poll_data['Host']['name'].' - '.$poll_data['Poll']['title'].'</td>';
            $body .= '</tr>';

            $body .= '<tr>';
                $body .= '<td>'.__('Export created', true).': '.date($this->formats['datetime']).'</td>';
            $body .= '</tr>';

            $body .= $this->exportGetBlankLine('tr');

            $body .= '<tr>';
                $body .= '<td>'.__('Period', true).': '.$period.'</td>';
            $body .= '</tr>';

            $body .= $this->exportGetBlankLine('tr');

        $body .= '</table>';

        $body .= '<table style="margin: 0; padding: 0; font-size: 9pt;">';
            $body .= '<thead>';
                $body .= '<tr>';
                    $body .= '<th>'.__('Scores', true).'</th>';
                    $body .= '<th>'.__('Current', true).'</th>';
                    $body .= '<th>'.__('Prev', true).'</th>';
                $body .= '</tr>';
            $body .= '<thead>';

            $body .= '<tbody>';
                $body .= '<tr>';
                    $body .= '<td>'.__('GSI', true).'</td>';
                    $body .= '<td>'.round($scorecard['current']['average_overall']*(10/$max_scale), 2).'</td>';
                    $body .= '<td>'.round($scorecard['prev']['average_overall']*(10/$max_scale), 2).'</td>';
                $body .= '</tr>';

                $body .= '<tr>';
                    $body .= '<td>'.__('Views', true).'</td>';
                    $body .= '<td>'.$scorecard['views']['current'].'</td>';
                    $body .= '<td>'.$scorecard['views']['prev'].'</td>';
                $body .= '</tr>';

                $body .= '<tr>';
                    $body .= '<td>'.__('Ratings', true).'</td>';
                    $body .= '<td>'.$scorecard['current']['guest_count_overall'].'</td>';
                    $body .= '<td>'.$scorecard['prev']['guest_count_overall'].'</td>';
                $body .= '</tr>';
            $body .= '<tbody>';

        $body .= '</table>';

        $body .= $this->exportGetBlankLine();

        $body .= '<table style="margin: 0; padding: 0; font-size: 9pt;">';
            $body .= '<thead>';
                $body .= '<tr>';
                    $body .= '<th>'.__('Averages by group', true).'</th>';
                    $body .= '<th>'.__('Current', true).'</th>';
                    $body .= '<th>'.__('Prev', true).'</th>';
                $body .= '</tr>';
            $body .= '</thead>';

            $body .= '<tbody>';
                foreach($scorecard['current']['average_by_group'] as $group_id => $rating) {
                    $body .= '<tr>';
                        $body .= '<td>'.$groups[$group_id].'</td>';
                        $body .= '<td>'.$scorecard['current']['average_by_group'][$group_id].'</td>';
                        $body .= '<td>'.$scorecard['prev']['average_by_group'][$group_id].'</td>';
                    $body .= '</tr>';
                }
            $body .= '</tbody>';

        $body .= '</table>';

        $body .= $this->exportGetBlankLine();


        $averages_overall = array();

        $body .= '<table style="margin: 0; padding: 0; font-size: 9pt;">';
            $body .= '<tbody>';
            $count_months_with_ratings = 0;
            foreach($answers as $month_number => $answer) {
                if(!empty($answer)) { $count_months_with_ratings++; }

                    $body .= '<tr>';
                        $body .= '<td>';
                            $body .= $month_number;
                        $body .= '</td>';
                        foreach($poll['Groups'] as $key => $group) {
                            foreach($group['Questions'] as $question) {
                                $body .= '<td>';
                                    if(isset($answer['Answers'][$question['Question']['id']]['rating_overall'])) {
                                        $average = round($answer['Answers'][$question['Question']['id']]['rating_overall']/$answer['Answers'][$question['Question']['id']]['rating_count'], 1);
                                        $body .= $average;
                                        if(!isset($averages_overall[$question['Question']['id']])) {
                                            $averages_overall[$question['Question']['id']] = 0;
                                        }
                                        $averages_overall[$question['Question']['id']] += $average;
                                    } else {
                                        $body .= '-';
                                    }
                                $body .= '</td>';
                            }
                        }
                    $body .= '</tr>';
                }
            $body .= '</tbody>';

            $body .= '<tfoot>';
                $body .= '<tr>';
                    $body .= '<td>&empty;</td>';
                    foreach($poll['Groups'] as $group) {
                        foreach($group['Questions'] as $question) {
                            $body .= '<td>';
                            if(isset($averages_overall[$question['Question']['id']])) {
                                $body .= $averages_overall[$question['Question']['id']]/$count_months_with_ratings;
                            } else {
                                $body .= '-';
                            }
                        $body .= '</td>';
                        }
                    }
                $body .= '</tr>';
            $body .= '</tfoot>';

        $body .= '</table>';

        $body .= $this->exportGetBlankLine();

        // encode file to UTF-8
        $data = "\xEF\xBB\xBF". $header . $body;

        fwrite($fh, $data);
        fclose($fh);

        #$complete_path = APP . 'files/' . $filename;
        $filesize = filesize($complete_path);

        $this->viewClass = 'Media';
        $params = array(
            'id' => $filename.'.'.$extension,
            'name' => $filename,
            'size' => $filesize,
            'download' => true,
            'extension' => 'pdf',
            'path' => APP . 'files/exports_excel/' . DS
        );

        $this->set($params);
    }

    /**
    * get a blank line for any excel export
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return string $blank_line
    * @copyright 2014 digitalcube GmbH Co KG
    */
    public function exportGetBlankLine($type = null) {
        if($type == 'tr') {
            return $blank_line = '<tr><td></td></tr>';
        }

        return $blank_line = '<table>'."\n".'<tr>'."\n".'<td> </td>'."\n".'</tr>'."\n".'</table>'."\n";
    }

    /**
    * get the answers to a given array of questions (by their ids)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getAnswers() {

        $group_id = $this->params->query('group_id');
        $period = $this->params->query('period');
        $option = $this->params->query('option');
        $date   = $this->params->query('date');

        #$this->locale = 'deu';

        $datasets = $this->Poll->getGroupAnswersDataset($group_id, $period, $this->locale, $option, $date);

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($datasets);
    }

    /**
    * get the answers to a given array of questions (by their ids)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getAnswersDay() {

        $group_id = $this->params->query('group_id');

        $this->Poll->Group->id = $group_id;
        $poll = $this->Poll->getPoll($this->Poll->Group->field('poll_id'));
        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $date = CakeTime::format('Y-m-d', strtotime($this->params->query('date')));

        $datasets = $this->Poll->getGroupAnswersDatasetDay($group_id, $this->locale, $date);

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($datasets);
    }

    /**
    * get the answers to a given array of questions (by their ids)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return string (json)
    */
    public function getAnswersLast30() {

        $group_id = $this->params->query('group_id');
        $date   = $this->params->query('date');

        $this->Poll->Group->id = $group_id;
        $poll = $this->Poll->getPoll($this->Poll->Group->field('poll_id'));
        Configure::write('Config.timezone', $poll['Host']['timezone']);
        $date = CakeTime::format('Y-m-d', strtotime($date));

        $datasets = $this->Poll->getGroupAnswersDatasetLast30($group_id, $this->locale, $date);
        #pr($datasets);
        #exit;

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($datasets);
    }

    /**
    * get the answers to a given array of questions (by their ids)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getAnswersMonth() {

        $group_id = $this->params->query('group_id');
        $year_month   = $this->params->query('year_month');

        $this->Poll->Group->id = $group_id;
        $poll = $this->Poll->getPoll($this->Poll->Group->field('poll_id'));
        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $datasets = $this->Poll->getGroupAnswersDatasetMonth($group_id, $this->locale, $year_month);

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($datasets);
    }

    /**
    * get the answers to a given array of questions (by their ids)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getAnswersWeek() {

        $group_id = $this->params->query('group_id');
        $year   = $this->params->query('year');
        $weeknumber   = $this->params->query('weeknumber');

        $datasets = $this->Poll->getGroupAnswersDatasetWeek($group_id, $this->locale, $year, $weeknumber);

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($datasets);
    }

    /**
    * get the answers to a given array of questions (by their ids)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getAnswersYear() {

        $group_id   = $this->params->query('group_id');
        $year       = $this->params->query('year');
        $datasets   = $this->Poll->getGroupAnswersDatasetYear($group_id, $this->locale, $year);

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($datasets);
    }

    /**
    * get the admin stats for last 30 days
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getLast30StatsAdmin() {

        $last30_stats_admin = $this->Poll->getLast30StatsAdmin();

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($last30_stats_admin);
    }

    /**
    * get the answers to a given array of questions (by their ids)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getLast7Average() {

        $poll_id = intval($this->params->query('poll_id'));

        $last_7_rating_chart = $this->Poll->getRatingLast7Average($poll_id);

        #pr($last_7_rating_chart);
        #exit;

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($last_7_rating_chart);
    }

    /**
    * get the answers to a given array of questions (by their ids)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getLast7ViewsAndRatings() {

        $poll_id = intval($this->params->query('poll_id'));

        $last_7_views_and_ratings = $this->Poll->getLast7ViewsAndRatings($poll_id);

        #pr($last_7_rating_chart);
        #exit;

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($last_7_views_and_ratings);
    }

    /**
    * get the overall average chart depending on the given type
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function getOverallAverage() {

        $type = $this->params->query('type');
        $poll_id = $this->params->query('poll_id');

        $poll = $this->Poll->getPoll($poll_id);
        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $date_value = $this->params->query('date_value');

        switch($type) {
            case 'last30':
                $overall_average_chart = $this->Poll->getOverallAverageChartLast30($poll_id, $type, $date_value);
                break;
            case 'day':
                $overall_average_chart = $this->Poll->getOverallAverageChartDay($poll_id, $type, $date_value);
                break;
            case 'week':
                $overall_average_chart = $this->Poll->getOverallAverageChartWeek($poll_id, $type, $date_value);
                break;
            case 'month':
                $overall_average_chart = $this->Poll->getOverallAverageChartMonth($poll_id, $type, $date_value);
                break;
            case 'year':
                $overall_average_chart = $this->Poll->getOverallAverageChartYear($poll_id, $type, $date_value);
                break;
        }

        Configure::write('debug', 0);
        $this->autoRender = false;
        return json_encode($overall_average_chart);
    }

    /**
    * list all polls belonging to a user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return boolean
    */
    public function index() {

        # check if applicable!

        $host_ids = $this->Poll->getHostIds(User::get('account_id'));

        $conditions = array();
        $conditions['Poll.deleted'] = 0;
        $conditions['Poll.host_id'] = $host_ids;

        $this->Poll->locale = $this->locale;

        $this->Poll->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';
        $this->Poll->virtualFields['count_views'] = 'SELECT COUNT(*) FROM polls_views AS PollsView WHERE PollsView.poll_id = Poll.id';
        #$this->Poll->virtualFields['ratings_remaining'] = 'SELECT limit - (SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id)';


        # paginate the list with manual options
        $this->paginate = array(
            'contain' => array(
                'Host',
                'Invoice' => array(
                    'conditions' => array(
                        'Invoice.deleted' => 0
                    ),
                    'order' => 'Invoice.created DESC'
                ),
                'Upgrade' => array(
                    'conditions' => array(
                        'Upgrade.deleted' => 0
                    ),
                    'order' => 'Upgrade.created DESC'
                )
            ),
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'Host.name ASC'
        );
        $polls = $this->paginate('Poll');

        #pr($polls);
        #exit;

        foreach($polls as $key => $poll) {
            if(
                (!empty($poll['Invoice']) && isset($poll['Invoice'][0]['valid_until']) && ($poll['Invoice'][0]['valid_until'] > date('Y-m-d H:i:s'))) ||
                (!empty($poll['Upgrade']) && isset($poll['Upgrade'][0]['valid_until']) && ($poll['Upgrade'][0]['valid_until'] > date('Y-m-d H:i:s')))
                ) {
                    $polls[$key]['Poll']['type'] = 'unlimited';
            } else {
                $polls[$key]['Poll']['type'] = 'free';
            }
        }

        $options_hosts = $this->Poll->Account->Host->getHostListByAccountId(User::get('account_id'));
        $options_locale = Configure::read('Locales');
        $options_templates = $this->Poll->getTemplatesList($this->locale);
        $options_scales = $this->Poll->getScaleOptions();
        $statuses = $this->Poll->getStatuses();
        $templates = $this->Poll->getTemplates();

        $this->set(compact('options_locale', 'options_hosts', 'options_scales', 'options_templates', 'polls', 'statuses', 'templates'));

        $this->params['navtabs.main'] = 'polls';
    }

    /**
    * update the payment method wrapper for the upgrade view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $guest_id
    * @return void
    */
    public function loadRatingInfo($guest_id = null) {

        $this->Poll->Guest->id = $guest_id;

        if(!$this->Poll->Guest->exists()) {
            return false;
        }

        $poll_id = $this->Poll->id = $this->Poll->Guest->field('poll_id');


        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            return false;
        }

        $poll = $this->Poll->getPoll($poll_id, $this->locale);

        Configure::write('Config.timezone', $poll['Host']['timezone']);     // centralize this anyhow!

        $rating_info = $this->Poll->getRatingInfo($guest_id);
        // pr($rating_info);

        $answers = $rating_info['Answer'];
        unset($rating_info['Answer']);
        $rating_info['Answer'] = array();
        foreach($answers as $answer) {
            $rating_info['Answer'][$answer['question_id']] = $answer;
        }

        $statuses_ratings = $this->Poll->getStatuses();
        $guest_types = $this->Poll->getGuestTypes();
        $visit_times = $this->Poll->getVisitTimes();

        $this->set(compact('guest_types', 'poll', 'rating_info', 'statuses_ratings', 'visit_times'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Polls/wrapper_rating_info', 'ajax');
            return;
        }
    }

    /**
    * set a rating to invalid by using provided guest_id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function ratingMarkDelete() {

        if($this->RequestHandler->isAjax()) {

            $guest_id = trim(strip_tags(rawurldecode($this->params->query('guest_id'))));

            $this->Poll->Answer->Guest->id = $guest_id;

            if($this->Poll->Answer->Guest->saveField('deleted', 1)) {
                if($this->Poll->Answer->updateAll(array('Answer.status' => 0, 'Answer.deleted' => 1), array('Answer.guest_id' => $guest_id))) {
                    Configure::write('debug', 0);
                    $this->autoRender = false;
                    return true;
                }
            }

            Configure::write('debug', 0);
            $this->autoRender = false;
            return false;
        }

        return false;
    }

    /**
    * set a rating to invalid by using provided guest_id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function ratingMarkInvalid() {

        if($this->RequestHandler->isAjax()) {

            $guest_id = trim(strip_tags(rawurldecode($this->params->query('guest_id'))));

            $this->Poll->Answer->Guest->id = $guest_id;

            if($this->Poll->Answer->Guest->saveField('status', 0)) {
                if($this->Poll->Answer->updateAll(array('Answer.status' => 0), array('Answer.guest_id' => $guest_id))) {
                    Configure::write('debug', 0);
                    $this->autoRender = false;
                    return true;
                }
            }

            Configure::write('debug', 0);
            $this->autoRender = false;
            return false;
        }

        return false;
    }

    /**
    * set a rating to invalid by using provided guest_id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function ratingMarkValid() {

        if($this->RequestHandler->isAjax()) {

            $guest_id = trim(strip_tags(rawurldecode($this->params->query('guest_id'))));

            $this->Poll->Answer->Guest->id = $guest_id;

            if($this->Poll->Answer->Guest->saveField('status', 1)) {
                if($this->Poll->Answer->updateAll(array('Answer.status' => 1), array('Answer.guest_id' => $guest_id))) {
                    Configure::write('debug', 0);
                    $this->autoRender = false;
                    return true;
                }
            }

            Configure::write('debug', 0);
            $this->autoRender = false;
            return false;
        }

        return false;
    }

    /**
    * settings for polls -> mainly view with qr code etc., will be
    * extended with edit and other functions
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function settings($poll_id = null) {
        if(!$poll_id) {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }


        $this->Poll->id = $poll_id;

        if(!$this->Permission->isAdmin()) {
            if(!$this->Poll->exists() || ($this->Poll->field('account_id') != User::get('account_id'))) {
                $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
                $this->redirect($this->referer());
            }
        }


        $this->Poll->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';
        $this->Poll->virtualFields['count_views'] = 'SELECT COUNT(*) FROM polls_views AS PollsView WHERE PollsView.poll_id = Poll.id';

        $poll = $this->Poll->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.deleted' => 0,
                'Poll.id' => $poll_id
            )
        ));

        if(empty($poll)) {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $statuses = $this->Poll->getStatuses();

        $type = $this->Poll->getType($poll_id);

        $invoices = $this->Poll->getInvoices($poll_id);
        $themes = $this->Poll->getThemes();

        $latest_invoice = $this->Poll->getLatestInvoice($poll_id);

        $this->set(compact('invoices', 'latest_invoice', 'poll', 'statuses', 'themes', 'type'));


        # QR-Code section
        $filename_300 = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'_300.png';
        $filename_150 = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'_150.png';
        $filename_80 = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'_80.png';

        # make some qr-code magic with the google api
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$filename_300)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '300x300';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$filename_300);
        }
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$filename_150)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '150x150';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$filename_150);
        }
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$filename_80)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '80x80';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$filename_80);
        }

        $this->set(compact('filename_300', 'filename_150', 'filename_80'));

        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $max_scale = $this->Poll->getPollsMaxScale($poll_id);
        $this->set(compact('max_scale'));

        $upgrade_history = $this->Poll->getUpgradeHistory($poll_id);
        $this->set(compact('upgrade_history'));

        # check if coming from setup-wizard (uncomment to simulate modal display!)
        #$this->Session->write('Wizard.complete', 1);

        $show_wizard_complete_modal = $this->Session->read('Wizard.complete');
        if(!empty($show_wizard_complete_modal)) {
            $this->Session->write('Wizard.complete', '');
            $this->set(compact('show_wizard_complete_modal'));
        }
    }

    /**
    * setup paypal for a poll upgrade
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function setupPaypal($poll_id = null) {

        $env = Configure::read('Environment');

        /* set the localecode for the paypal component */
        $locales = array(
            'eng' => 'GB',
            'deu' => 'DE'
        );

        if(isset($locales[$this->locale])) {
            $this->Paypal->API_Localecode = $locales[$this->locale];
        } else {
            $this->Paypal->API_Localecode = 'GB';
        }

        $this->Paypal->API_Sandbox                  = Configure::read('Paypal.API_Sandbox');
        $this->Paypal->API_Endpoint                 = Configure::read('Paypal.API_Endpoint');
        $this->Paypal->API_UserName                 = Configure::read('Paypal.API_UserName');
        $this->Paypal->API_Password                 = Configure::read('Paypal.API_Password');
        $this->Paypal->API_Signature                = Configure::read('Paypal.API_Signature');
        $this->Paypal->API_Version                  = Configure::read('Paypal.API_Version');
        $this->Paypal->URL_PAYPAL                   = Configure::read('Paypal.URL_PAYPAL');
        $this->Paypal->URL_POLLUPGRADE_RETURN       = Configure::read('Paypal.URL_POLLUPGRADE_RETURN');
        $this->Paypal->URL_POLLUPGRADE_CANCEL       = Configure::read('Paypal.URL_POLLUPGRADE_CANCEL').$poll_id;

        return;
    }

    /**
    * view a poll (today)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return boolean
    */
    public function showDay($id = null, $date = null) {

        if(!$id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }


        # permission check
        $this->Poll->id = $id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        $poll = $this->Poll->getPoll($id, $this->locale, $date);
        Configure::write('Config.timezone', $poll['Host']['timezone']);

        $statuses = $this->Poll->getStatuses();
        $this->set(compact('poll', 'statuses'));

        # stop data gathering when poll is NOT premium (saves the load on DB...)
        #if($this->Permission->isPremiumPoll($id)) {

            if(!$date) {
                $date = CakeTime::format('Y-m-d', time());
            } else {
                $date = CakeTime::format('Y-m-d', strtotime($date));
            }

            $answers = $this->Poll->getPollAnswers($id, $this->locale, $type = 'day', $date);
            $scorecard = $this->Poll->getScorecardCounts($id, 'day', $date);
            $groups = $this->Poll->getGrouplist($id, $this->locale);

            $guest_types = $this->Poll->getGuestTypes();
            $visit_times = $this->Poll->getVisitTimes();

            $type = $this->Poll->getType($id);

            $this->set(compact('answers', 'date', 'groups', 'guest_types', 'poll', 'statuses', 'type', 'visit_times', 'scorecard'));

            $max_scale = $this->Poll->getPollsMaxScale($id);
            $this->set(compact('max_scale'));
        #}

    }

    /**
    * view a poll (last 30)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return boolean
    */
    public function showLast30($id = null, $date = null) {

        if(!$id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        # permission check
        $this->Poll->id = $id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        $poll = $this->Poll->getPoll($id, $this->locale);

        Configure::write('Config.timezone', $poll['Host']['timezone']);

        if(!$date) {
            $date = CakeTime::format('Y-m-d', time());
        }

        $answers = $this->Poll->getPollAnswers($id, $this->locale, $type = 'last30', $date);
        $groups = $this->Poll->getGrouplist($id, $this->locale);

        $scorecard = $this->Poll->getScorecardCounts($id, 'last30', $date);

        $statuses = $this->Poll->getStatuses();
        $guest_types = $this->Poll->getGuestTypes();
        $visit_times = $this->Poll->getVisitTimes();

        $type = $this->Poll->getType($id);

        $this->set(compact('answers', 'groups', 'guest_types', 'poll', 'statuses', 'type', 'visit_times', 'year_month', 'scorecard'));

        $max_scale = $this->Poll->getPollsMaxScale($id);
        $this->set(compact('max_scale'));

        // pr($poll['Groups']);
        // $rating_info = $this->Poll->getRatingInfo(384);

        // pr($rating_info);
        // exit;
        // exit;
    }

    /**
    * view a poll (today)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return boolean
    */
    public function showMonth($id = null, $year_month = null) {

        if(!$id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }


        # permission check
        $this->Poll->id = $id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }


        $poll = $this->Poll->getPoll($id, $this->locale);
        Configure::write('Config.timezone', $poll['Host']['timezone']);
        #Configure::write('Config.timezone', 'Asia/Calcutta');

        $statuses = $this->Poll->getStatuses();
        $this->set(compact('poll', 'statuses'));

        #if($this->Permission->isPremiumPoll($id)) {
            if(!$year_month) {
                $year_month = date('Y-m');
            }
            $answers = $this->Poll->getPollAnswers($id, $this->locale, $type = 'month', $year_month);

            $groups = $this->Poll->getGrouplist($id, $this->locale);

            $scorecard = $this->Poll->getScorecardCounts($id, 'month', $year_month);

            $statuses = $this->Poll->getStatuses();
            $guest_types = $this->Poll->getGuestTypes();
            $visit_times = $this->Poll->getVisitTimes();

            $type = $this->Poll->getType($id);

            $this->set(compact('answers', 'groups', 'guest_types', 'poll', 'statuses', 'type', 'visit_times', 'year_month', 'scorecard'));

            $max_scale = $this->Poll->getPollsMaxScale($id);
            $this->set(compact('max_scale'));
        #}
    }

    /**
    * view a poll (today)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return boolean
    */
    public function showWeek($poll_id = null, $year = null, $weeknumber = null) {

        if(!$poll_id)  {
            $this->Session->setFlash(__('Invalid Request!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $poll_id = intval($poll_id);

        # permission check
        $this->Poll->id = $poll_id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }


        $poll = $this->Poll->getPoll($poll_id, $this->locale);
        $statuses = $this->Poll->getStatuses();
        $this->set(compact('poll', 'statuses'));

        if(!$year) {
            $year = date('Y');
        }
        if(!isset($weeknumber)) {
            $weeknumber = date('W');
        }

        $weeknumber = sprintf("%02u", $weeknumber);
        $week_start = date( "Y-m-d", strtotime($year."W".$weeknumber."1")); // First day of week
        $week_end   = date( "Y-m-d", strtotime($year."W".$weeknumber."7") );

        $answers = $this->Poll->getPollAnswers($poll_id, $this->locale, $type = 'week', $date = $week_start);

        $groups = $this->Poll->getGrouplist($poll_id, $this->locale);

        $week = array(
            'start' => $week_start,
            'end' => $week_end
        );
        $scorecard = $this->Poll->getScorecardCounts($poll_id, 'week', $week);

        $statuses = $this->Poll->getStatuses();
        $guest_types = $this->Poll->getGuestTypes();
        $visit_times = $this->Poll->getVisitTimes();

        $type = $this->Poll->getType($poll_id);

        $this->set(compact('answers', 'groups', 'guest_types', 'poll', 'statuses', 'type', 'visit_times', 'year', 'weeknumber', 'week_start', 'scorecard'));

        $max_scale = $this->Poll->getPollsMaxScale($poll_id);
        $this->set(compact('max_scale'));

        Configure::write('Config.timezone', $poll['Host']['timezone']);
    }

    /**
    * view a poll (today)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $date
    * @return boolean
    */
    public function showWeekTemp($poll_id = null, $date = null) {

        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $weeknumber = date('W', strtotime($date));

        if(($weeknumber == 1) && ($month == 12)) {
            $year = $year + 1;
        }

        $this->redirect(array('action' => 'showWeek', $poll_id, $year, $weeknumber));
    }

    /**
    * view a poll (year)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return boolean
    */
    public function showYear($id = null, $year = null) {

        if(!$id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        # permission check
        $this->Poll->id = $id;
        if(!$this->Poll->exists()) {
            throw new NotFoundException();
        }
        if(!$this->Permission->isAdmin() && ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        $poll = $this->Poll->getPoll($id, $this->locale);
        $statuses = $this->Poll->getStatuses();
        $this->set(compact('poll', 'statuses'));

        if(!$year) {
            $year = date('Y');
        }

        $answers = $this->Poll->getPollAnswers($id, $this->locale, $type = 'year', $year);
        $scorecard = $this->Poll->getScorecardCounts($id, 'year', $year);
        $groups = $this->Poll->getGrouplist($id, $this->locale);

        $statuses = $this->Poll->getStatuses();
        $guest_types = $this->Poll->getGuestTypes();
        $visit_times = $this->Poll->getVisitTimes();

        $type = $this->Poll->getType($id);

        $this->set(compact('answers', 'groups', 'guest_types', 'poll', 'statuses', 'type', 'visit_times', 'year', 'scorecard'));

        $max_scale = $this->Poll->getPollsMaxScale($id);
        $this->set(compact('max_scale'));

        Configure::write('Config.timezone', $poll['Host']['timezone']);
    }

    /**
    * switch the poll on the dashboard by setting the poll id to session
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function switchPollOnDashboard($poll_id = null) {

        $this->Poll->id = intval($poll_id);

        if(!$this->Poll->exists() || ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        $this->Session->write('Dashboard.selected_poll_id', $poll_id);
        $this->redirect($this->referer());
    }

   /**
    * test-generation of the weekly report
    * (uses last 7 days scorecard to provide all needed information)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $date
    * @return mixed $reports
    */
    public function testWeeklyReport($year = null, $weeknumber = null) {

        if(!$year) {
            $year = date('Y');
        }
        if(!$weeknumber) {
            $weeknumber = date('N');
        }

        $Report = ClassRegistry::init('Report');
        $reports = $Report->generateWeeklyReports($year, $weeknumber);
    }

    /**
    * update the payment method wrapper for the upgrade view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $period, int $country_id
    * @return void
    */
    public function updatePaymentMethodWrapper($period, $country_id) {

        $g_taxes_apply = false;
        $g_taxes = $this->config['tax_percent_standard'];

        $price = $this->config['prices'][$period];
        if($country_id == 225) {
            $price = round($price + ($price/100)*$this->config['tax_percent_standard'], 2);
            $g_taxes_apply = true;
        }


        $this->set(compact('g_taxes_apply', 'g_taxes', 'price'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Polls/wrapper_payment_methods', 'ajax');
            return;
        }
    }

    /**
    * update the payment method wrapper for the upgrade view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, string $period
    * @return void
    */
    public function updatePeriodWrapper($poll_id, $period) {

        # add this block to updater function, too!
        $latest_upgrade = $this->Poll->getLatestUpgrade($poll_id);
        if(!empty($latest_upgrade) && isset($latest_upgrade['valid_until'])) {
            $valid_from = $latest_upgrade['valid_until'];
            $valid_until = date('Y-m-d H:i:s', strtotime($valid_from.' '.$this->config['periods'][$period]));
        } else {
            $valid_from = date('Y-m-d H:i:s');
            $valid_until = date('Y-m-d H:i:s', strtotime($valid_from.' '.$this->config['periods'][$period]));
        }

        $this->set(compact('latest_upgrade', 'valid_from', 'valid_until'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Polls/wrapper_period', 'ajax');
            return;
        }
    }

    /**
    * upgrade a poll to premium
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function upgrade($poll_id = null) {

        if(!$poll_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $this->Poll->id = intval($poll_id);
        if(!$this->Poll->exists() || ($this->Poll->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPost() || $this->RequestHandler->isPut()) {

            $data = $this->data;
            $data['Poll']['id']         = $poll_id;
            $data['Poll']['user_id']    = User::get('id');
            $data['Poll']['account_id'] = User::get('account_id');
            $data['Poll']['host_id']    = $this->Poll->field('host_id');


            if(isset($data['Poll']['upgrade']) && !empty($data['Poll']['upgrade']) && !empty($data['Invoice']['payment_type'])) {
                $selected_period = $data['Poll']['upgrade'];
            } else {
                $selection_error = __('Please select a period for your upgrade!', true);
                $this->set(compact('selection_error'));
            }


            if(!isset($selection_error) && $this->Poll->validateUpgrade($data)) {

                $data['Poll']['prices'] = $this->config['prices'];
                $data['Poll']['mwst']   = $this->config['tax_percent_standard'];

                $this->Session->write('Upgrade', $data);

                if($data['Invoice']['payment_type'] == 1) {

                    # VIA PAYPAL

                    # inject the invoice data to have the amounts
                    $invoice = $this->Poll->upgradePoll($data, $pregenerate = true);
                    $data['Invoice'] = $invoice['Invoice'];
                    $this->Session->write('Upgrade', $data);

                    # setup paypal, send nvp string and check the response
                    $this->setupPaypal($data['Poll']['id']);
                    $nvpstr = $this->Paypal->prepareExpressCheckout($data);
                    $result = $this->Paypal->SetExpressCheckout($nvpstr);

                    $ack = strtoupper($result["ACK"]);

                    #$ack = 'FAILED';   // uncomment for error-testing!

                    if($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
                        # save all responses to the session!
                        $_SESSION['TOKEN'] = urldecode($result['TOKEN']);
                        $this->Paypal->RedirectToPayPal($_SESSION['TOKEN']);
                    } else {

                        $upgrade = $this->Session->read('Upgrade');
                        $upgrade['Problem']['type'] = 'paypal_redirect_failed';
                        $this->Session->write('Upgrade', $upgrade);

                        $this->Session->setFlash(__('We are sorry but we could not redirect you to the paypal website. Please, try again!', true), 'default', array('class' => 'alert alert-danger'));
                        #$this->redirect('/polls/upgrade-problem');
                        $this->redirect(array('action' => 'upgrade_problem'));
                    }

                } elseif($data['Invoice']['payment_type'] == 2) {

                    # VIA ACCOUNT

                    if($this->Poll->upgradePoll($data)) {

                        $upgrade = $this->Session->read('Upgrade');
                        $invoice = $this->Poll->Invoice->getInvoice($this->Poll->Invoice->id);
                        $upgrade['UpgradeInvoice'] = $invoice;
                        $this->Session->write('Upgrade', $upgrade);

                        $this->__confirmationMailUpgrade($this->Poll->Invoice->id);
                        $this->__confirmationMailUpgradeAdmins($this->Poll->Invoice->id);

                        # show some love...
                        $this->Session->setFlash(__('Your poll has been upgraded!', true), 'default', array('class' => 'alert alert-success'));
                        $this->redirect(array('action' => 'upgrade-success'));

                    } else {

                        $this->Session->setFlash(__('We could not upgrade your poll! Please contact our customer support to get assistance on your upgrade!', true), 'default', array('class' => 'alert alert-danger'));
                        $this->redirect(array('controller' => 'polls', 'action' => 'payment_problem'));

                        // pr($this->Poll->Invoice->invalidFields());
                        // exit;
                    }

                }

            } else {
                $this->Session->setFlash(__('Some information is missing!', true), 'default', array('class' => 'alert alert-danger'));
            }

        } else {

            // check for existing invoice (last one)
            $latest_invoice = $this->Poll->getLatestInvoice($poll_id);

            // if invoice exists, use the information given there
            if(!empty($latest_invoice)) {

                # add invoice data to form so it is prefilled with the latest information
                $this->request->data['Invoice']['gender']      = $latest_invoice['Invoice']['gender'];
                $this->request->data['Invoice']['firstname']   = $latest_invoice['Invoice']['firstname'];
                $this->request->data['Invoice']['lastname']    = $latest_invoice['Invoice']['lastname'];

                $this->request->data['Invoice']['address']     = $latest_invoice['Invoice']['address'];
                $this->request->data['Invoice']['address_additional']     = $latest_invoice['Invoice']['address_additional'];
                $this->request->data['Invoice']['zipcode']     = $latest_invoice['Invoice']['zipcode'];
                $this->request->data['Invoice']['city']        = $latest_invoice['Invoice']['city'];
                $this->request->data['Invoice']['country_id']  = $latest_invoice['Invoice']['country_id'];

                $this->request->data['Invoice']['email']    = $latest_invoice['Invoice']['email'];
                $this->request->data['Invoice']['company']  = $latest_invoice['Invoice']['company'];
                $this->request->data['Invoice']['ustid']    = $latest_invoice['Invoice']['ustid'];

            } else {

                // else use the information from the logged in user (and the connected account)
                $this->request->data['Invoice']['gender']      = User::get('gender');
                $this->request->data['Invoice']['firstname']   = User::get('firstname');
                $this->request->data['Invoice']['lastname']    = User::get('lastname');

                $this->request->data['Invoice']['address']     = User::get('Account.address');
                $this->request->data['Invoice']['zipcode']     = User::get('Account.zipcode');
                $this->request->data['Invoice']['city']        = User::get('Account.city');
                $this->request->data['Invoice']['country_id']  = User::get('Account.country_id');

                $this->request->data['Invoice']['email']    = User::get('email');
                $this->request->data['Invoice']['company']  = User::get('Account.company_name');
                $this->request->data['Invoice']['ustid']    = User::get('Account.ust_id');
            }

            $selected_period = 'h';
        }

        $poll = $this->Poll->getPoll($poll_id);

        # check the beginning of a projected upgrade - check invoices
        /*
        $latest_invoice = $this->Poll->getLatestInvoice($poll_id);
        if(!empty($latest_invoice)) {
            if($latest_invoice['Invoice']['valid_until'] > date('Y-m-d H:i:s')) {
                $valid_from = $latest_invoice['Invoice']['valid_until'];
                $valid_until = date('Y-m-d H:i:s', strtotime($valid_from.' '.$this->config['periods'][$selected_period]));
            }
        }

        # check the beginning of a projected upgrade - check upgrades
        $latest_upgrade = $this->Poll->getLatestUpgrade($poll_id);
        if(!empty($latest_upgrade)) {
            if($latest_upgrade['Upgrade']['valid_until'] > date('Y-m-d H:i:s')) {
                $valid_from = $latest_upgrade['Upgrade']['valid_until'];
                $valid_until = date('Y-m-d H:i:s', strtotime($valid_from.' '.$this->config['periods']['y']));
            }
        }
        */

        $latest_upgrade = $this->Poll->getLatestUpgrade($poll_id);
        if(!empty($latest_upgrade) && isset($latest_upgrade['valid_until'])) {
            $valid_from = $latest_upgrade['valid_until'];
            $valid_until = date('Y-m-d H:i:s', strtotime($valid_from.' '.$this->config['periods'][$selected_period]));
        } else {
            $valid_from = date('Y-m-d H:i:s');
            $valid_until = date('Y-m-d H:i:s', strtotime($valid_from.' '.$this->config['periods'][$selected_period]));
        }

        $this->set(compact('latest_upgrade', 'valid_from', 'valid_until'));

        $options_genders = $this->Poll->Account->User->getGenders();
        $options_countries = $this->Poll->Invoice->Country->getCountryList($this->locale);

        $price = 0;
        $g_taxes_apply = false;

        if(isset($selected_period)) {
            $price = $this->config['prices'][$selected_period];
            if(isset($this->data['Invoice']['country_id']) && ($this->data['Invoice']['country_id']) == 1) {
                $price = round($price + ($price/100)*$this->config['tax_percent_standard'], 2);
                $g_taxes_apply = true;
            }
        }

        $this->set(compact('g_taxes_apply', 'options_countries', 'options_genders', 'poll', 'price', 'selected_period'));
    }

    /**
    * show the problem page for upgraded polls
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function upgrade_problem() {

        $upgrade = $this->Session->read('Upgrade');
        if(empty($upgrade) || !isset($upgrade['Poll']['id'])) {
            $this->redirect('/');
        }

        $poll = $this->Poll->getPoll($upgrade['Poll']['id']);

        $this->set(compact('poll', 'upgrade'));
    }

    /**
    * show success page for upgraded polls
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id
    * @return void
    */
    public function upgrade_success() {

        $upgrade = $this->Session->read('Upgrade');
        $data = $upgrade['UpgradeInvoice'];

        /*
        $poll = $this->Poll->find('first', array(
            'contain' => array(
                'Host'
            ),
            'conditions' => array(
                'Poll.deleted' => 0,
                'Poll.id' => $upgrade['Poll']['id']
            )
        ));
        */

        $this->set(compact('data'));
    }

    /**
    * view a poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return boolean
    */
    public function view($id = null) {

        if(!$id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-danger'));
            $this->redirect($this->referer());
        }

        $poll = $this->Poll->getPoll($id, $this->locale);
        $answers = $this->Poll->getPollAnswers($id, $this->locale, $type = 'month', $date = date('Y-m-d'), $option = 'last_30');

        $answers = Set::Sort($answers, '{n}.Guest.created', 'desc');

        $statuses = $this->Poll->getStatuses();
        $guest_types = $this->Poll->getGuestTypes();
        $visit_times = $this->Poll->getVisitTimes();
        $themes = $this->Poll->getThemes();

        #App::import('Vendor', 'phpqrcode/phpqrcode');
        #QRcode::png('https://polls.guestify.net/'.$poll['Poll']['hash'], APP . 'webroot/img/qrcodes/'.$filename, QR_ECLEVEL_H, 4, 2); // creates file

        $this->set(compact('answers', 'guest_types', 'poll', 'statuses', 'themes', 'visit_times'));

        # check if QR code exists, otherwise create it
        $filename = Security::hash($poll['Poll']['id'].$poll['Poll']['hash']).'.png';


        # make some qr-code magic with the google api
        if(!file_exists(APP . 'webroot/img/qrcodes/'.$filename)) {
            $data = 'https://polls.guestify.net/'.$poll['Poll']['hash'];
            $size = '300x300';
            $logo = APP . 'webroot/images/logo.png';

            // Get QR Code image from Google Chart API
            // https://code.google.com/apis/chart/infographics/docs/qr_codes.html
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            imagepng($QR, APP . 'webroot/img/qrcodes/'.$filename);
        }

        $this->set(compact('filename'));
    }

   /**
    * send a confirmation with invoice PDF attached to upgrade user
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id
    * @return boolean
    */
    private function __confirmationMailUpgrade($invoice_id = null) {

        $invoice = $this->Poll->Invoice->getInvoice($invoice_id);
        $invoice['Invoice']['country_name'] = $this->Poll->Invoice->Country->getCountryName($invoice['Invoice']['country_id'], $this->locale);

        $filename = $this->generateUpgradeInvoice($invoice_id);

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('smtp_amazon');

        if(Configure::read('Environment') == 'live') {
            $Email->to($invoice['Invoice']['email']);
        } else {
            $Email->to(Configure::read('Email.dev'));
        }

        $Email->subject(__('Your guestify poll has been upgraded!', true));
        $Email->template('upgrade_poll');
        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));
        $Email->attachments(array(APP . 'files' . DS . $filename));

        $formats = $this->formats;

        $Email->viewVars(compact('formats', 'invoice'));

        try {
            $Email->send();
        } catch(SocketException $e) {
            #$this->updateEmailLog($Email, $e);
            return false;
        }
        return true;
    }

   /**
    * send a confirmation with invoice PDF attached to admins
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id
    * @return boolean
    */
    private function __confirmationMailUpgradeAdmins($invoice_id = null) {

        # get invoice and all containing data, generate the pdf
        $invoice = $this->Poll->Invoice->getInvoice($invoice_id);
        $invoice['Invoice']['country_name'] = $this->Poll->Invoice->Country->getCountryName($invoice['Invoice']['country_id'], $this->locale);
        $filename = $this->generateUpgradeInvoice($invoice_id);

        # additional data
        $payment_types = $this->Poll->Invoice->getPaymentTypes();
        $periods = $this->config['periods_by_name'];
        $formats = $this->formats;

        # define email
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('smtp_amazon');

        # build subject prefix if needed (all but live version!)
        $subject = '';
        $env = Configure::read('Environment');
        if($env != 'LIVE') {
            $subject .= '['.strtoupper($env).'] - ';
        }
        $subject .= __('A poll was upgraded to PREMIUM!', true);
        $Email->subject($subject);
        $Email->to(Configure::read('Email.payment_notification'));
        $Email->template('upgrade_poll_admins');
        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));
        $Email->attachments(array(APP . 'files' . DS . $filename));
        $Email->viewVars(compact('formats', 'invoice', 'payment_types', 'periods'));

        # try sending email, catch any errors
        try {
            $Email->send();
        } catch(SocketException $e) {
            #$this->updateEmailLog($Email, $e);
            return false;
        }

        return true;
    }

}
