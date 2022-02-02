<?php
class AccountsController extends AppController {

    public $name = 'Accounts';

    public $uses = array('Account');

    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Session->check('Auth.User.id')) {
            $this->redirect('/');
        }
    }


    /**
    * add an account by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function adminAdd() {

        if($this->RequestHandler->isPost()) {
            $data = $this->data;

            if($this->Account->addByAdmin($data)) {
                if($data['User']['send_welcome'] == 1) {
                    # ...
                }
                $this->Session->setFlash(__('The account was added!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'adminView', $this->Account->id));
            }
        }

        $options_countries = $this->Account->Country->getCountryList($this->locale);
        $options_genders = $this->Account->User->getGenders();

        $this->set(compact('options_countries', 'options_genders'));

        $this->params['navtabs.main'] = 'accounts';
    }


    /**
    * show the account information of a logged in client
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function adminEdit($account_id = null) {
        if(!$account_id) {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPut()) {
            $data = $this->data;

            if($this->Account->edit($data)) {
                $this->Session->setFlash(__('Your changes have been saved!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'adminView', $account_id));
            } else {
                $this->Session->setFlash(__('Your changes could not be saved!', true), 'default', array('class' => 'alert alert-error'));
            }
        } else {
            $this->request->data = $this->Account->findById($account_id);
        }

        $account = $this->Account->findById($account_id);

        $options_countries = $this->Account->Country->getCountryList($this->locale);

        $this->set(compact('account', 'options_countries'));
    }


    /**
    * list all accounts
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return boolean
    */
    public function adminIndex() {

        $conditions = array();
        $conditions['Account.deleted'] = 0;

        $this->Account->virtualFields['count_hosts'] = 'SELECT COUNT(*) FROM hosts AS Host WHERE Host.account_id = Account.id';
        $this->Account->virtualFields['count_polls'] = 'SELECT COUNT(*) FROM polls AS Poll WHERE Poll.account_id = Account.id';
        $this->Account->virtualFields['count_users'] = 'SELECT COUNT(*) FROM users AS User WHERE User.account_id = Account.id';

        # paginate the list with manual options
        $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'Account.id DESC'
        );
        $accounts = $this->paginate('Account');

        $this->set(compact('accounts'));

        $this->params['navtabs.main'] = 'polls';
    }


    /**
    * show the account information by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function adminView($account_id = null) {
        if(!$account_id)  {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $account = $this->Account->findById($account_id);
        if(empty($account)) {
            throw new NotFoundException();
        }

        $countries = $this->Account->Country->getCountryList($this->locale);
        $options_locale = Configure::read('Locales');

        $users          = $this->Account->getAccountUsers($account_id);
        $genders        = $this->User->getGenders();
        $statuses_users = $this->User->getStatuses();

        $hosts          = $this->Account->getAccountHosts($account_id);
        $statuses_hosts = $this->Account->Host->getStatuses();

        $invoices           = $this->Account->getAccountInvoices($account_id);
        $statuses_invoices  = $this->Account->Invoice->getStatuses();

        $options_timezones = $this->Account->getTimezones();

        $this->set(compact('account', 'countries', 'genders', 'hosts', 'invoices', 'options_locale', 'options_timezones', 'statuses_invoices', 'statuses_users', 'users'));
    }


    /**
    * show the account information of a logged in client
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function edit($account_id = null) {
        if(!$account_id) {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        if($this->RequestHandler->isPut()) {
            $data = $this->data;

            $this->Account->id = intval($data['Account']['id']);
            if(!$this->Account->exists() || ($this->Account->field('id') != User::get('account_id'))) {
                $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
                $this->redirect($this->referer());
            }

            if($this->Account->edit($data)) {
                $this->Session->setFlash(__('Your changes have been saved!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'my_account'));
            } else {
                $this->Session->setFlash(__('Your changes could not be saved!', true), 'default', array('class' => 'alert alert-error'));
            }
        } else {
            $this->Account->id = intval($account_id);
            if(!$this->Account->exists() || ($this->Account->field('id') != User::get('account_id'))) {
                $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
                $this->redirect($this->referer());
            }
            $this->request->data = $this->Account->findById($account_id);
        }

        $account = $this->Account->findById($account_id);
        $options_countries = $this->Account->Country->getCountryList($this->locale);

        $this->set(compact('account', 'options_countries'));
    }


    /**
    * show the account information of a logged in client
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function my_account() {

        if(!$this->Permission->isClient()) {
            $this->redirect($this->referer());
        }

        $account = $this->Account->findById(User::get('account_id'));

        $countries = $this->Account->Country->getCountryList($this->locale);

        $this->set(compact('account', 'countries'));

    }


    /**
    * validate/save step 2 of the account-startup-wizard
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function saveStep1() {

        if($this->RequestHandler->isAjax()) {

            $this->Session->write('Wizard.current_step', 1);

            $data = array();
            $data['Host']['name']       = trim(strip_tags(rawurldecode($this->params->query('name'))));
            $data['Host']['address']    = trim(strip_tags(rawurldecode($this->params->query('address'))));
            $data['Host']['zipcode']    = trim(strip_tags(rawurldecode($this->params->query('zipcode'))));
            $data['Host']['city']       = trim(strip_tags(rawurldecode($this->params->query('city'))));
            $data['Host']['country_id'] = trim(strip_tags(rawurldecode($this->params->query('country_id'))));
            $data['Host']['account_id'] = User::get('account_id');
            $data['Host']['locale']     = $this->Session->read('Config.language');

            if(empty($data['Host']['name'])) {
                $this->Account->Host->invalidate('name', __('Please enter the name of your host!', true));
            }

            if($this->Account->Host->validates()) {

                $host = $this->Account->Host->find('first', array(
                    'conditions' => array(
                        'Host.deleted' => 0,
                        'Host.account_id' => User::get('account_id')
                    ),
                    'order' => 'Host.created ASC'
                ));

                if(empty($host)) {
                    $this->Account->Host->create();
                } else {
                    $this->Account->Host->id = $host['Host']['id'];
                }

                $this->Account->Host->save($data);

                Configure::write('debug', 0);
                $this->autoRender = false;
                return true;

            } else {

                $result = $this->Account->Host->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }

        return false;
    }


    /**
    * validate/save step 1 of the account-startup-wizard
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function saveStep2() {

        if($this->RequestHandler->isAjax()) {

            $this->Session->write('Wizard.current_step', 2);

            $data = array();
            $data['Account']['company_name'] = trim(strip_tags(rawurldecode($this->params->query('company_name'))));
            $data['Account']['address']     = trim(strip_tags(rawurldecode($this->params->query('address'))));
            $data['Account']['zipcode']     = trim(strip_tags(rawurldecode($this->params->query('zipcode'))));
            $data['Account']['city']        = trim(strip_tags(rawurldecode($this->params->query('city'))));
            $data['Account']['country_id']  = trim(strip_tags(rawurldecode($this->params->query('country_id'))));

            $this->Account->id = User::get('account_id');

            if(empty($data['Account']['company_name'])) {
                $this->Account->invalidate('company_name', __('Please enter your company name!', true));
            }

            if($this->Account->validates() && $this->Account->save($data)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return true;
            } else {
                $result = $this->Account->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }

        return false;
    }


    /**
    * validate/save step 1 of the account-startup-wizard
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function saveStep3() {

        if($this->RequestHandler->isAjax()) {

            $this->Session->write('Wizard.current_step', 3);

            $data = array();
            $data['Poll']['title']       = trim(strip_tags(rawurldecode($this->params->query('title'))));
            $data['Poll']['code']        = trim(strip_tags(rawurldecode($this->params->query('code'))));
            $data['Poll']['template_id'] = trim(strip_tags(rawurldecode($this->params->query('template_id'))));
            $data['Poll']['scale']       = trim(strip_tags(rawurldecode($this->params->query('scale'))));
            $data['Poll']['account_id'] = User::get('account_id');

            #pr($data);
            #exit;

            $host = $this->Account->Host->find('first', array(
                'conditions' => array(
                    'Host.deleted' => 0,
                    'Host.account_id' => User::get('account_id')
                ),
                'order' => 'Host.created ASC'
            ));
            $data['Poll']['host_id'] = $host['Host']['id'];

            if(empty($data['Poll']['title'])) {
                $this->Account->Poll->invalidate('title', __('Please enter a title for your poll!', true));
            }

            if(empty($data['Poll']['code'])) {
                $this->Account->Poll->invalidate('code', __('Please enter the pin-code you want to use for your poll!', true));
            } elseif(strlen($data['Poll']['code']) < 4) {
                $this->Account->Poll->invalidate('code', __('Please use at least 4 digits for your pin!!', true));
            }

            if(empty($data['Poll']['template_id'])) {
                $this->Account->Poll->invalidate('template_id', __('Please select a poll-template!', true));
            }

            $this->Account->Poll->Behaviors->disable('Translate');

            if($this->Account->Poll->validates()) {

                $this->Account->Poll->addPollFromTemplate($data['Poll']['template_id'], $data);

                # if one of first 50 accs => add a 0,- Euro invoice for the poll, so it's PRO for 1 year without costs!
                $free_slots = $this->Account->getFreeUpgradeSlots();
                if($free_slots > 0) {
                    $this->Account->Poll->upgradePollForFree($this->Account->Poll->id);
                }

                $this->Session->write('Wizard.complete', 1);

                Configure::write('debug', 0);
                $this->autoRender = false;
                return $this->Account->Poll->id;
            } else {
                $result = $this->Account->Poll->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }

        return false;
    }

}
