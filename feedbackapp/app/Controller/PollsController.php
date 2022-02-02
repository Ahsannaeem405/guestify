<?php
class PollsController extends AppController {

    public $name = 'Polls';

    public $uses = array('Poll');

    public function beforeFilter() {
        parent::beforeFilter();
    }



    /**
    * send a notification when answers were made
    * (including answers and guest)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $poll_id, int $guest_id
    * @return boolean
    */
    public function __notifyAboutAnswer($poll_id = null, $guest_id = null) {

        $poll = $this->Poll->getPoll($poll_id);

        $account = $this->Poll->Account->findById($poll['Poll']['account_id']);
        $admin = $this->Poll->Account->User->find('first', array(
            'conditions' => array(
                'User.deleted' => 0,
                'User.account_id' => $account['Account']['id']
            )
        ));

        $guest = $this->Poll->Guest->findById($guest_id);

        $temp_answers = $this->Poll->getAnswers($poll_id, $guest_id);
        $answers = array();
        foreach($temp_answers as $answer) {
            $answers[$answer['Answer']['question_id']] = $answer;
        }

        $guest_types  = $this->Poll->getGuestTypes();
        $visit_times  = $this->Poll->getVisitTimes();

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('smtp_amazon');

        if(Configure::read('Environment') == 'LIVE') {
            $Email->to($admin['User']['email']);
        } else {
            $Email->to(Configure::read('Email.dev'));
        }

        $Email->subject(__('Your poll received answers from a guest!', true));
        $Email->template('notification_poll_answer');

        $Email->replyTo(Configure::read('Email.no_reply_email'));
        $Email->from(array(Configure::read('Email.no_reply_email') => Configure::read('Email.no_reply_name')));

        $formats = $this->formats;

        $Email->viewVars(compact('answers', 'formats', 'guest', 'guest_types', 'poll', 'visit_times'));

        // $this->set(compact('answers', 'formats', 'guest', 'guest_types', 'poll', 'visit_times'));
        // $this->layout = 'Emails/html/default';
        // $View = new View($this, false);
        // $html = $View->render('../Emails/html/notification_poll_answer');
        // print_r($html);
        // exit;

        try {
            $success = $Email->send();
        } catch(SocketException $e) {
            #$this->updateEmailLog($Email, $e);
            $success = false;
        }

        return $success;
    }


    /**
    * check a given pin and redirect to poll
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param $sting $hostname, int $poll_id
    * @return void
    */
    public function auth($hash = null) {

        if(!$hash) {
            return $this->redirect($this->referer());
        }

        $this->Poll->PollsView->addView($hash, $_SERVER, $this->Session->id());

        if($this->RequestHandler->isPost()) {

            $poll = $this->Poll->getPollByHash($hash);
            if(empty($poll)) {
                $this->Session->write('Offline.type', 'not_found');
                $this->redirect('/offline');
            }

            $data = $this->data;

            $code = trim(strip_tags($data['Poll']['code']));
            $hash = trim(strip_tags($data['Poll']['hash']));

            $this->Poll->Behaviors->detach('Translate');

            $errors = array();
            if(empty($code)) {
                $this->Poll->invalidate('code', __('Please enter your PIN!', true));
            } elseif(!$this->Poll->checkCodeForHash($code, $hash)) {
                $this->Poll->invalidate('code', __('Sorry, wrong PIN!', true));
            }

            # write hash to session and set authed = 1, then redirect
            if ($this->Poll->validates()) {

                $this->Session->write('Authed.'."'".$hash."'", 1);
                $check = $this->Session->read('Authed.'."'".$hash."'");
                $this->redirect('/'.$hash);

            } else {
                $this->Session->setFlash('<span class="icon icon-info-sign"></span> '.__('Some information is missing!', true), 'default', array('class' => 'message alert alert-danger', 'escape' => false));
            }
        }

        $this->Poll->virtualFields['ratings_received'] = 'SELECT COUNT(DISTINCT guest_id) FROM answers AS Answer WHERE Answer.poll_id = Poll.id';
        $poll = $this->Poll->getPollByHash($hash);

        if(empty($poll)) {
            $this->Session->write('Offline.type', 'not_found');
            $this->redirect('/offline');
        }

        if($poll['Poll']['status'] == 0) {
            $this->Session->write('Offline.type', 'deactivated');
            $this->redirect('/offline');
        }

        if($poll['Poll']['ratings_received'] >= $poll['Poll']['limit']) {
            $this->Session->write('Offline.type', 'limit_reached');
            $this->redirect('/offline');
        }

        $check_force_locale = $this->Session->read('Force.locale');
        if(empty($check_force_locale)) {
            if(isset($poll['Host']['locale']) && !empty($poll['Host']['locale'])) {
                $this->requestAction('users/changeLanguage/'.$poll['Host']['locale']);
            }
        }

        $this->set(compact('hash', 'poll'));
    }


    /**
    * show a poll-offline page
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function offline() {

        $type = $this->Session->write('Offline.type');

        $this->set(compact('type'));
    }


    /**
    * show a poll to a guest
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param sting $hash
    * @return void
    */
    public function showPoll($hash = null) {

        // $this->__notifyAboutAnswer(1, 1);
        // exit;

        # check if the prev. called auth function wrote access to session
        #$this->Session->write('Poll.done.'.$hash, 0);
        #$this->Session->write('Authed.'.$hash, 0);

        # add a view record for every calling of this function


        $authed = $this->Session->read('Authed.'."'".$hash."'");
        $done   = $this->Session->read('Poll.done.'."'".$hash."'");

        if($done != 1) {

            # sanitize any incoming data
            $hash = trim(strip_tags($hash));

            if(!$authed && !$done) {
                # add a view record for every calling of this function
                $this->redirect('/auth/'.$hash);
            }

            $poll_id = $this->Poll->getPollIdByHash($hash);

            if(!$poll_id) {
                $this->redirect('/');
            }

            $locale_overwrite = $this->Session->read('Poll.language');
            $poll = $this->Poll->getPollForShow($poll_id, $locale_overwrite);

            if(empty($poll)) {
                $this->Session->write('Offline.type', 'not_found');
                $this->redirect('/offline');
            }

            if($poll['Poll']['status'] == 0) {
                $this->Session->write('Offline.type', 'deactivated');
                $this->redirect('/offline');
            }

            if($poll['Poll']['ratings_received'] >= $poll['Poll']['limit']) {
                $this->Session->write('Offline.type', 'limit_reached');
                $this->redirect('/offline');
            }

            if($this->RequestHandler->isPost() || $this->RequestHandler->isPut()) {

                $data = $this->data;

                $data['Guest']['comment_customer'] = nl2br(strip_tags(trim($data['Guest']['comment_customer'])));

                # check if reset was triggered
                if(isset($data['reset'])) {
                    $this->redirect($this->here);
                }

                $errors = $this->Poll->checkMissingAnswers($poll_id, $data);

                if(is_array($errors)) {
                    $this->Session->setFlash('<span class="icon icon-info-sign"></span> '.__('Some information is missing!', true), 'default', array('class' => 'message alert alert-danger', 'escape' => false));
                    $this->set(compact('errors'));
                } else {
                    if(($done != 1) && $this->Poll->validatePoll($data)) {
                        
                        if($this->Poll->saveAnswers($data)) {

                            # send notification email to host-admin
                            $this->Poll->id = $poll_id;

                            # check if poll's notifications for answers is turned ON -> if so, send email
                            if($this->Poll->field('notify_on_answer') == 1) {
                                $this->__notifyAboutAnswer($poll_id, $this->Poll->Guest->id);
                            }

                            $this->Session->write('Poll.done.'."'".$hash."'", 1);
                            $this->Session->write('Authed.'."'".$hash."'", 0);
                            $this->redirect('/'.$hash);
                        }
                    } else {
                        $this->Session->setFlash('<span class="icon icon-info-sign"></span> '.__('Some information is missing!', true), 'default', array('class' => 'message alert alert-danger', 'escape' => false));
                    }
                }
            }

        } else {

            /*
            $locale = $this->Session->read('Poll.language');
            if(empty($locale)) {
                $locale = $this->Session->read('Config.language');
            }
            */

            $poll_id = $this->Poll->getPollIdByHash($hash);
            $poll = $this->Poll->getPollForShow($poll_id, $this->locale);
        }

        $socials = $this->Poll->Host->HostsSocial->getTypes();
        $values_socials = $this->Poll->Host->getSocialsValues($poll['Poll']['host_id']);

        $max_scale = $this->Poll->getPollsMaxScale($poll['Poll']['id']);

        $guest_types  = $this->Poll->getGuestTypes();
        $visit_times  = $this->Poll->getVisitTimes();

        $this->set(compact('done', 'max_scale', 'poll', 'guest_types', 'socials', 'values_socials', 'visit_times'));
    }


}
