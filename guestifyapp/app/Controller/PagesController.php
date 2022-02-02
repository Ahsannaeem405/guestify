<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

	public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display');
    }


	/**
	 * Displays a view
	 *
	 * @param mixed What page to display
	 * @return void
	 * @throws NotFoundException When the view file could not be found
	 *	or MissingViewException in debug mode.
	 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}

		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}

        switch($page) {
            case 'dashboard':

                $render_default = false;

                if(!$this->Session->check('Auth.User.id')) {
            		$this->redirect('/');
            	}

                if($this->Permission->isClient()) {
                    
                    if($this->RequestHandler->isPost() || $this->RequestHandler->isPut()) {
                        
                        $Account = ClassRegistry::init('Account');
                        $data = $this->data;
                        $account_setup_data = $Account->getAccountSetupData(User::get('account_id'));

                        if(isset($data['Account'])) {
                            $Account->id = User::get('account_id');
                            if($Account->save($data)) {
                                $this->Session->setFlash(__('Great! Now setup your host!', true), 'default', array('class' => 'alert alert-success'));
                                $this->redirect('/dashboard');
                            }
                        } elseif(isset($data['Host'])) {

                            $Host = ClassRegistry::init('Host');

                            $data['Host']['account_id'] = User::get('account_id');

                            if(!isset($account_setup_data['Host']['id'])) {
                                $Host->create();
                            } else {
                                $Host->id = $account_setup_data['Host']['id'];
                            }

                            $data['Host']['locale'] = $this->locale;

                            if($Host->save($data)) {
                                if(!empty($data['Host']['name'])) {
                                    $this->Session->setFlash(__('Great! Now setup your first poll!', true), 'default', array('class' => 'alert alert-success'));
                                } else {
                                    $this->Session->setFlash(__('Your changes have been saved!', true), 'default', array('class' => 'alert alert-success'));
                                }
                                $this->redirect('/dashboard');
                            }
                        }
                    }


                    $Poll = ClassRegistry::init('Poll');
                    $polls_selectable = $Poll->getSelectablePollsList(User::get('Account.id'), $this->locale);
                    $this->set(compact('polls_selectable'));

                    #$this->Session->write('Dashboard.selected_poll_id', 1);
                    $selected_poll_id = $this->Session->read('Dashboard.selected_poll_id');

                    $polls_selectable_plain = $Poll->getSelectablePollsList(User::get('Account.id'), $this->locale, $plain = true);

                    if(empty($selected_poll_id) && isset(array_keys($polls_selectable_plain)[0])) {
                        $selected_poll_id = array_keys($polls_selectable_plain)[0];
                        $this->Session->write('Dashboard.selected_poll_id', $selected_poll_id);
                    }

                    #Configure::write('Config.timezone', $poll['Host']['timezone']);

                    $Account = ClassRegistry::init('Account');
                    if(!empty($selected_poll_id)) {
                        $scorecard = $Account->getDashboardCounts($selected_poll_id, User::get('Account.id'));
                        $this->set(compact('scorecard'));

                        $poll = $Poll->getPoll($selected_poll_id, $this->locale);
                        $this->set(compact('poll'));

                        $grouplist = $Poll->getGrouplist($selected_poll_id, $this->locale);
                        $this->set(compact('grouplist'));

                        $max_scale = $Poll->getPollsMaxScale($selected_poll_id);
                        $this->set(compact('max_scale'));
                    }


                    $options_countries = $Poll->Account->Country->getCountryList($this->locale);
                    $options_scales = $Poll->getScaleOptions();
                    $options_templates = $Poll->getTemplatesList($this->locale);
                    $options_timezones = $Poll->Account->getTimezones();

                    $templates = $Poll->getTemplates();

                    $this->set(compact('options_countries', 'options_scales', 'options_templates', 'options_timezones', 'polls_selectable_plain', 'templates'));

                    $this->request->data = $account_setup_data = $Poll->Account->getAccountSetupData(User::get('account_id'));

                    $free_slots = $Account->getFreeUpgradeSlots();

                    #$hasOnePoll = $Poll->checkAvailablePollsCount()

                    $this->set(compact('account_setup_data', 'free_slots'));
                }

                if($this->Permission->isAdmin()) {
                    $this->redirect('/admin_dashboard');
                }


            	break;
            case 'admin_dashboard':
                if(!$this->Permission->isAdmin()) {
                    $this->redirect('/');
                }

                $Poll = ClassRegistry::init('Poll');
                $scorecard = $Poll->getAdminDashboardCounts();
                $this->set(compact('scorecard'));

                $conversion_rates = $Poll->getConversionRatesAdmin();

                $this->set(compact('conversion_rates'));


                break;
            case 'system':
                if(!$this->Permission->isAdmin()) {
                    $this->redirect('/');
                }
                break;
            case 'home':
                if($this->Session->check('Auth.User.id')) {
                    $this->redirect('/dashboard');
                }

                break;
            case 'logout':
                break;
            case 'terms':
                break;
        }

		if(!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

        try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}

	}


}
