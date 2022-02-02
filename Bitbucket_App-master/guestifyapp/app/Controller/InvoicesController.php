<?php
/**
 * Invoices controller
 *
 * @package app
 * @subpackage controllers
 */
class InvoicesController extends AppController {

    public $name = 'Invoices';

    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Session->check('Auth.User.id')) {
            $this->redirect('/');
        }
    }


    /**
    * download an invoice as pdf
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id
    * @return void
    */
    public function adminDownload($invoice_id = null) {

        if(!$invoice_id) {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $this->Invoice->id = $invoice_id;
        if(!$this->Invoice->exists()) {
            throw new NotFoundException();
        }

        $filename = $this->generateUpgradeInvoice($invoice_id);
        $name = explode('.', $filename);

        $complete_path = APP . 'files/' . $filename;
        $filesize = filesize($complete_path);

        $this->viewClass = 'Media';
        $params = array(
            'id' => $filename,
            'name' => $name[0],
            'size' => $filesize,
            'download' => true,
            'extension' => 'pdf',
            'path' => APP . 'files' . DS
        );

        $this->set($params);
    }


    /**
    * list all invoices by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function adminIndex() {

        $conditions = array();
        $conditions['Invoice.deleted']     = 0;

        # paginate the list with manual options
        $this->paginate = array(
            'contain' => array(
                'Host',
                'Poll'
            ),
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'Invoice.id DESC'
        );
        $invoices = $this->paginate('Invoice');

        $statuses = $this->Invoice->getStatuses();

        $amount_pending = $this->Invoice->getPendingAmountOverall();
        $amount_revenues = $this->Invoice->getRevenuesAmountOverall();

        $this->set(compact('amount_pending', 'amount_revenues', 'invoices', 'statuses'));

        $this->params['navtabs.main'] = 'invoices';
    }


    /**
    * mark an invoice as paid by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function adminMarkPaid() {

        if($this->RequestHandler->isAjax()) {

            $invoice_id = intval($this->params->query('invoice_id'));

            $this->Invoice->id = $invoice_id;
            if(!$this->Invoice->exists()) {
                throw new NotFoundException();
            }

            if(!$this->Permission->isAdmin()) {
                throw new NotFoundException();
            }

            if($this->Invoice->saveField('status', 2)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return true;
            }
        }

        return false;
    }


    /**
    * mark an invoice as refunded by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function adminMarkRefunded() {

        if($this->RequestHandler->isAjax()) {

            $invoice_id = intval($this->params->query('invoice_id'));

            $this->Invoice->id = $invoice_id;
            if(!$this->Invoice->exists()) {
                throw new NotFoundException();
            }

            if(!$this->Permission->isAdmin()) {
                throw new NotFoundException();
            }

            if($this->Invoice->saveField('status', 5)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return true;
            }
        }

        return false;
    }


    /**
    * mark an invoice as unpaid by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function adminMarkUnpaid() {

        if($this->RequestHandler->isAjax()) {

            $invoice_id = intval($this->params->query('invoice_id'));

            $this->Invoice->id = $invoice_id;
            if(!$this->Invoice->exists()) {
                throw new NotFoundException();
            }

            if(!$this->Permission->isAdmin()) {
                throw new NotFoundException();
            }

            if($this->Invoice->saveField('status', 1)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return true;
            }
        }

        return false;
    }


    /**
    * view a invoice record by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id
    * @return void
    */
    public function adminView($invoice_id = null) {
        if(!$invoice_id) {
            throw new NotFoundException();
        }

        $this->Invoice->id = $invoice_id;
        if(!$this->Invoice->exists()) {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $invoice = $this->Invoice->getInvoice($invoice_id);
        if(!$invoice) {
            throw new NotFoundException();
        }

        $invoice['Invoice']['country_name'] = $this->Invoice->Country->getCountryName($invoice['Invoice']['country_id'], $this->locale);

        $polls = $this->Invoice->Poll->getPollsList(User::get('account_id'), $this->locale);

        $genders = $this->Invoice->Account->User->getGenders();

        $this->set(compact('genders', 'invoice', 'polls'));
    }


    /**
    * download an invoice as pdf
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id
    * @return void
    */
    public function download($invoice_id = null) {

        if(!$invoice_id) {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'negative'));
            $this->redirect($this->referer());
        }

        $this->Invoice->id = $invoice_id;
        if(!$this->Invoice->exists() || ($this->Invoice->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        $filename = $this->generateUpgradeInvoice($invoice_id);
        $name = explode('.', $filename);

        $complete_path = APP . 'files/' . $filename;
        $filesize = filesize($complete_path);

        $this->viewClass = 'Media';
        $params = array(
            'id' => $filename,
            'name' => $name[0],
            'size' => $filesize,
            'download' => true,
            'extension' => 'pdf',
            'path' => APP . 'files' . DS
        );

        $this->set($params);
    }


    /**
    * list all invoices of a certain host
    * (or any when called as admin)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function index() {

        $conditions = array();
        $conditions['Invoice.deleted'] = 0;
        $conditions['Invoice.account_id'] = User::get('account_id');

        $this->paginate = array(
            'contain' => array(
                'Account',
                'Host',
                #'Payment',
                'Poll',
            ),
            'conditions' => $conditions,
            'order' => array(
                'Invoice.created' => 'DESC'
            )
        );

        $invoices = $this->paginate('Invoice');

        $statuses = $this->Invoice->getStatuses();
        #$scorecard = $this->Invoice->getScorecard();

        $amount_pending = $this->Invoice->getPendingAmountOverall();

        $this->set(compact('amount_pending', 'invoices', 'scorecard', 'statuses'));
    }


    /**
    * list all invoices of a certain account
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function my_invoices() {

        $conditions = array();
        $conditions['Invoice.deleted'] = 0;
        $conditions['Invoice.account_id'] = User::get('account_id');

        $this->paginate = array(
            'contain' => array(
                'Account',
                #'Host',
                'Poll',
                #'Payment'
            ),
            'conditions' => $conditions,
            'order' => array(
                'Invoice.created' => 'DESC'
            )
        );

        $invoices = $this->paginate('Invoice');

        $hosts = $this->Invoice->Host->getHostListByAccountId(User::get('account_id'));
        $polls = $this->Invoice->Poll->getPollsList(User::get('account_id'), $this->locale);

        $statuses = $this->Invoice->getStatuses();
        #$scorecard = $this->Invoice->getScorecard();

        $amount_pending = $this->Invoice->getPendingAmount(User::get('account_id'));

        $this->set(compact('amount_pending', 'hosts', 'invoices', /*'scorecard',*/ 'polls', 'statuses'));
    }


    /**
    * mark an invoice ad paid
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $id
    * @return void
    */
    public function setStatus($status = null, $id = null) {
        if (!$status || !$id) {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'negative'));
            $this->redirect($this->referer());
        }

        if(!$this->Permission->isAdmin()) {
            $this->Session->setFlash(__('Invalid request!', true), 'default', array('class' => 'negative'));
            $this->redirect($this->referer());
        }

        $this->Invoice->id = $id;
        if(!$this->Invoice->exists()) {
            $this->Session->setFlash(__('Invalid request!', true), 'default', array('class' => 'negative'));
            $this->redirect($this->referer());
        }

        if($this->Invoice->saveField('status', $status)) {
            switch ($status) {
                case 1:
                    $this->Session->setFlash(__('Invoice marked as pending!', true), 'default', array('class' => 'positive'));
                    break;
                case 2:
                    $this->Session->setFlash(__('Invoice marked as paid!', true), 'default', array('class' => 'positive'));
                    break;
                case 5:
                    $this->Session->setFlash(__('Invoice marked as refunded!', true), 'default', array('class' => 'positive'));
                    break;
            }
        } else {
            $this->Session->setFlash(__('Could not mark invoice as paid!', true), 'default', array('class' => 'negative'));
        }

        $this->redirect($this->referer());
    }


    /**
    * view a invoice record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id
    * @return void
    */
    public function view($invoice_id = null) {
        if(!$invoice_id) {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'negative'));
            $this->redirect($this->referer());
        }

        $this->Invoice->id = $invoice_id;
        if(!$this->Invoice->exists() || ($this->Invoice->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        $invoice = $this->Invoice->getInvoice($invoice_id);
        if(!$invoice) {
            throw new NotFoundException();
        }

        $invoice['Invoice']['country_name'] = $this->Invoice->Country->getCountryName($invoice['Invoice']['country_id'], $this->locale);
        $statuses = $this->Invoice->getStatuses();
        $polls = $this->Invoice->Poll->getPollsList(User::get('account_id'), $this->locale);
        $genders = $this->Invoice->Account->User->getGenders();

        $this->set(compact('genders', 'invoice', 'polls', 'statuses'));
    }


}
