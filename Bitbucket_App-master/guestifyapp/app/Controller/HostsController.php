<?php
class HostsController extends AppController {

    public $name = 'Hosts';

    public $uses = array('Host');

    public $components = array('Images');

    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Session->check('Auth.User.id')) {
            $this->redirect('/');
        }
    }


    /**
    * test facebook page-rating api
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function testFacebook() {

        require APP . 'Vendor/facebook/facebook.php';

        $facebook = new Facebook(array(
          'appId'  => '673519069413073',
          'secret' => 'f2be94898ab2c3cbced2a09dc54c6f44',
        ));

        $access_token =  $facebook->getAccessToken();
        $facebook->setAccessToken($access_token);

        $result = $facebook->api('/haxenhaus/ratings', 'GET');
        pr($result);
        exit;

        // Get User ID
        #$user = $facebook->getUser();
    }


    /**
    * add a host by client
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function add() {

        if($this->RequestHandler->isAjax()) {

            $data = array();
            $data['Host']['name']       = trim(strip_tags(rawurldecode($this->params->query('name'))));
            $data['Host']['locale']     = trim(strip_tags(rawurldecode($this->params->query('locale'))));
            $data['Host']['timezone']     = trim(strip_tags(rawurldecode($this->params->query('timezone'))));

            $data['Host']['account_id'] = User::get('account_id');

            if($this->Host->add($data)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return $this->Host->id;
            } else {
                $result = $this->Host->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }

        return false;
    }


    /**
    * add a host by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function adminAdd() {

        if($this->RequestHandler->isAjax()) {

            $data = array();
            $data['Host']['name']       = trim(strip_tags(rawurldecode($this->params->query('name'))));
            $data['Host']['locale']     = trim(strip_tags(rawurldecode($this->params->query('locale'))));
            $data['Host']['timezone']   = trim(strip_tags(rawurldecode($this->params->query('timezone'))));
            $data['Host']['account_id'] = intval($this->params->query('account_id'));

            if($this->Host->add($data)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return $this->Host->id;
            } else {
                $result = $this->Host->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode($result);
            }
        }

        return false;
    }


    /**
    * edit a host record (by account owner)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $host_id
    * @return void
    * @copyright 2014 digitalcube GmbH Co KG
    */
    public function adminEdit($host_id = null) {
        if(!$host_id) {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPut()) {
            $data = $this->data;

            $this->Host->id = intval($data['Host']['id']);
            if(!$this->Host->exists()) {
                throw new NotFoundException();
            }

            // check if logo should be removed
            if(isset($data['Host']['logo_remove']) && ($data['Host']['logo_remove'] == 1))  {
                $data['Host']['logo'] = NULL;
            // if not, check the given file, resize it and upload it via ftp
            } elseif(!empty($data['Host']['logo_edit']['name'])) {
                $file = explode('.', $data['Host']['logo_edit']['name']);
                $extension = end($file);
                $filename = Security::hash(strtotime(date("Y-m-d H:i:s")). md5(uniqid()), null, true).'.'.$extension;

                move_uploaded_file($data['Host']['logo_edit']['tmp_name'] , APP.'webroot/img/temp/'. $filename );
                $filename = $this->Images->createResizings($filename, 'hosts');

                if($this->User->ftpupload($filename, 'hosts')) {
                    $data['Host']['logo'] = $filename;
                } else {
                    $data['Host']['logo'] = $this->Host->field('logo');
                }
            } else {
                $data['Host']['logo'] = $this->Host->field('logo');
            }

            if($this->Host->edit($data)) {
                $this->Session->setFlash(__('Your changes were saved!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'adminView', $host_id));
            } else {
                $this->Session->setFlash(__('Your changes could not be saved!', true), 'default', array('class' => 'alert alert-error'));
            }
        } else {
            $this->request->data = $this->Host->findById($host_id);
        }

        $this->Host->id = $host_id;
        if(!$this->Host->exists()) {
            throw new NotFoundException();
        }

        $host = $this->Host->findById($host_id);
        if(empty($host)) {
            throw new NotFoundException();
        }

        $statuses = $this->Host->getStatuses();
        $options_locale = Configure::read('Locales');

        $socials = $this->Host->HostsSocial->getTypes();
        $values_socials = $this->Host->getSocialsValues($host_id);

        $options_countries = $this->Host->Country->getCountryList($this->locale);

        $this->set(compact('host', 'options_countries', 'options_locale', 'socials', 'statuses', 'values_socials'));
    }


    /**
    * list all hosts
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function adminIndex() {

        $conditions = array();
        $conditions['Host.deleted']     = 0;

        $this->Host->virtualFields['count_polls'] = 'SELECT COUNT(*) FROM polls AS Poll WHERE Poll.host_id = Host.id';

        # paginate the list with manual options
        $this->paginate = array(
            'contain' => array(
                'Account'
            ),
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'Host.id DESC'
        );
        $hosts = $this->paginate('Host');

        $statuses = $this->Host->getStatuses();

        $this->set(compact('hosts', 'statuses'));

        $this->params['navtabs.main'] = 'hosts';
    }


    /**
    * view a host by admin
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $host_id
    * @throws NotFoundException
    * @return void
    * @copyright 2014 digital:cube GmbH Co KG / gravity dev GmbH
    */
    public function adminView($host_id = null) {
        if(!$host_id)  {
            throw new NotFoundException();
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        # get/check and update host record
        $host = $this->Host->getHost($host_id);
        if(empty($host)) {
            throw new NotFoundException();
        }

        if(!empty($host['Host']['country_id'])) {
            $host['Host']['country_name'] = $this->Host->Country->getCountryName($host['Host']['country_id'], $this->locale);
        } else {
            $host['Host']['country_name'] = '';
        }

        if(!empty($host['Account']['country_id'])) {
            $host['Account']['country_name'] = $this->Host->Account->Country->getCountryName($host['Account']['country_id'], $this->locale);
        } else {
            $host['Account']['country_name'] = '';
        }

        $socials = $this->Host->HostsSocial->getTypes();
        $values_socials = $this->Host->getSocialsValues($host_id);
        $statuses_polls = $this->Host->Poll->getStatuses();

        $polls = $this->Host->getHostPolls($host_id);

        $timezones = $this->Host->getTimezones();
        $timezone_names = $this->Host->getTimezoneNames();

        $this->set(compact('host', 'polls', 'socials', 'statuses_polls', 'timezones', 'timezone_names', 'values_socials'));

        Configure::write('Config.timezone', $host['Host']['timezone']);
    }


    /**
    * edit a host record (by account owner)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $host_id
    * @return void
    * @copyright 2014 digitalcube GmbH Co KG
    */
    public function edit($host_id = null) {
        if(!$host_id) {
            throw new NotFoundException();
        }

        if($this->RequestHandler->isPut()) {
            $data = $this->data;

            $this->Host->id = intval($data['Host']['id']);
            if(!$this->Host->exists() || ($this->Host->field('account_id') != User::get('account_id'))) {
                throw new NotFoundException();
            }

            // check if logo should be removed
            if(isset($data['Host']['logo_remove']) && ($data['Host']['logo_remove'] == 1))  {
                $data['Host']['logo'] = NULL;
            // if not, check the given file, resize it and upload it via ftp
            } elseif(!empty($data['Host']['logo_edit']['name'])) {
                $file = explode('.', $data['Host']['logo_edit']['name']);
                $extension = end($file);
                $filename = Security::hash(strtotime(date("Y-m-d H:i:s")). md5(uniqid()), null, true).'.'.$extension;

                move_uploaded_file($data['Host']['logo_edit']['tmp_name'] , APP.'webroot/img/temp/'. $filename );
                $filename = $this->Images->createResizings($filename, 'hosts');

                if($this->User->ftpupload($filename, 'hosts')) {
                    $data['Host']['logo'] = $filename;
                } else {
                    $data['Host']['logo'] = $this->Host->field('logo');
                }
            } else {
                $data['Host']['logo'] = $this->Host->field('logo');
            }

            if($this->Host->edit($data)) {
                $this->Session->setFlash(__('Your changes were saved!', true), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'view', $host_id));
            } else {
                $this->Session->setFlash(__('Your changes could not be saved!', true), 'default', array('class' => 'alert alert-error'));
            }
        } else {
            $this->request->data = $this->Host->findById($host_id);
        }

        $this->Host->id = $host_id;
        if(!$this->Host->exists() ||($this->Host->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }


        $host = $this->Host->findById($host_id);
        if(empty($host)) {
            throw new NotFoundException();
        }

        $statuses = $this->Host->getStatuses();
        $options_locale = Configure::read('Locales');

        $socials = $this->Host->HostsSocial->getTypes();
        $values_socials = $this->Host->getSocialsValues($host_id);

        $options_countries = $this->Host->Country->getCountryList($this->locale);

        Configure::write('Config.timezone', $host['Host']['timezone']);

        $this->set(compact('host', 'options_countries', 'options_locale', 'socials', 'statuses', 'values_socials'));
    }


    /**
    * list all hosts belonging to an account (account owner)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    * @copyright 2014 digitalcube GmbH Co KG
    */
    public function index() {

        $host_ids = $this->Host->getHostIds(User::get('account_id'));

        $this->Host->virtualFields['count_polls'] = 'SELECT COUNT(*) FROM polls AS Poll WHERE Poll.host_id = Host.id';

        $conditions = array();
        $conditions['Host.id'] = $host_ids;

        # paginate the list with manual options
        $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 20,
            'order' => 'Host.name ASC'
        );
        $hosts = $this->paginate('Host');

        $options_locale = Configure::read('Locales');
        $options_timezones = $this->Host->getTimezones();

        $this->set(compact('hosts', 'options_locale', 'options_timezones'));

        $this->params['navtabs.main'] = 'hosts';
    }


    /**
    * view a host
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $host_id
    * @throws NotFoundException
    * @return void
    * @copyright 2014 digital:cube GmbH Co KG / gravity dev GmbH
    */
    public function view($host_id = null) {
        if(!$host_id)  {
            throw new NotFoundException();
        }

        $this->Host->id = $host_id;
        if(!$this->Host->exists() || ($this->Host->field('account_id') != User::get('account_id'))) {
            throw new NotFoundException();
        }

        $host = $this->Host->getHost($host_id);
        if(empty($host)) {
            throw new NotFoundException();
        }

        if(!empty($host['Host']['country_id'])) {
            $host['Host']['country_name'] = $this->Host->Country->getCountryName($host['Host']['country_id'], $this->locale);
        } else {
            $host['Host']['country_name'] = '';
        }

        $socials = $this->Host->HostsSocial->getTypes();
        $values_socials = $this->Host->getSocialsValues($host_id);

        $timezones = $this->Host->getTimezones();
        $timezone_names = $this->Host->getTimezoneNames();

        Configure::write('Config.timezone', $host['Host']['timezone']);

        $this->set(compact('host', 'socials', 'timezones', 'timezone_names', 'values_socials'));
    }

}
