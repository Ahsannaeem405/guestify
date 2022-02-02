<?php
class TrackersController extends AppController {

    public $name = 'Trackers';

    public $uses = array('Tracker');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'loadPixel',
            'trackLink'
        ));
    }



    /**
    * delete a tracker
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id
    * @return void
    */
    public function delete($tracker_id = null) {
        if(!$tracker_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $this->Tracker->id = $tracker_id;
        if(!$this->Tracker->exists()) {
            throw new NotFoundException();
        }

        if($this->Tracker->saveField('deleted', 1)) {
            $this->Session->setFlash(__('The tracker was deleted!', true), 'default', array('class' => 'alert alert-success'));
            $this->redirect(array('action' => 'index_system'));
        } else {
            $this->Session->setFlash(__('The tracker could not be deleted!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }
        
    }

    /**
    * delete a tracker-link
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_link_id
    * @return void
    */
    public function deleteLink($tracker_link_id = null) {
        if(!$tracker_link_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $this->Tracker->TrackersLink->id = $tracker_link_id;
        if(!$this->Tracker->TrackersLink->exists()) {
            throw new NotFoundException();
        }

        if($this->Tracker->TrackersLink->saveField('deleted', 1)) {
            $this->Session->setFlash(__('The tracker was deleted!', true), 'default', array('class' => 'alert alert-success'));
            $this->redirect(array('action' => 'view', $this->Tracker->TrackersLink->field('tracker_id')));
        } else {
            $this->Session->setFlash(__('The tracker could not be deleted!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }
    }


    /**
    * index list of trackers defined by a given type
    * standard type: welcome_user (may change in the future)
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return void
    */
    public function index_system($type = null) {

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        if(!$type) {
            $type = 'welcome_user';
        }

        $conditions = array();
        $conditions['Tracker.deleted']  = 0;
        $conditions['Tracker.type']     = $type;

        $this->paginate = array(
            'contain' => array(
                'TrackersLink' => array(
                    'conditions' => array(
                        'TrackersLink.deleted' => 0
                    )
                )
            ),
            'conditions' => $conditions,
            'order' => 'Tracker.created',
            'limit' => 50
        );
        $trackers = $this->paginate('Tracker');

        $statuses = $this->Tracker->getStatuses();
        $statuses_labels = $this->Tracker->getStatusesLabels();

        $navtab_counts = $this->Tracker->getNavtabCounts();

        $types = $this->Tracker->getTypes();

        $this->set(compact('navtab_counts', 'statuses', 'statuses_labels', 'trackers', 'types'));

        $this->params['Tracker.selected'] = 'welcome_email';

        $this->params['Targets.index.tab'] = 'system';

        $scorecard = $this->Tracker->getScorecardByType($type);
        $this->set(compact('scorecard'));
    }


    /**
    * load the tracking pixel
    * This function will get called when emails connected to a tracker
    * are opened. When the pixel is loaded, certain values in the DB will
    * get updated so we know the email was openend and what the context
    * was the email was opened
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function loadPixel() {

        // check params and update the corresponding tracker
        $query = $this->params->query;
        
        $this->Tracker->log('CHECK ME!', LOG_DEBUG);

        if(isset($query['t_id']) && isset($query['e_id'])) {
            # upate the corresponding tracker record
            $this->Tracker->trackerOpened($query['t_id'], $query['e_id']);
        }

        // create and return the generated 1x1 tracking pixel
        $im = imagecreate(1, 1);                        // Create an image, 1x1 pixel in size
        $white = imagecolorallocate($im,255,255,255);   // Set the background colour
        imagesetpixel($im, 1, 1, $white);               // Allocate the background colour
        $check = imagejpeg($im);                                 // Create a JPEG file from the image

        // set headers and return the image
        $this->autoRender = false;
        $this->response->type('jpg');
        $this->response->body($check);
        return $this->response;
    }


    /**
    * load the search results into the results
    * element
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $search_term
    * @return void
    */
    public function loadSearchResults($search_term = null) {

        $search_term = h(strip_tags(trim(urldecode($search_term))));
        $search_results = $this->Tracker->loadSearchResults($search_term);

        $this->set(compact('search_results', 'search_term'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Trackers/wrapper_search_results', 'ajax');
            return;
        }

        return false;
    }


    /**
    * load the general information from a tracker
    * and return the result as json object
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return json object | boolean
    */
    public function loadTrackerGeneralInformation() {

        if($this->RequestHandler->isAjax()) {

            $data = $this->data;

            if(!isset($data['tracker_id']) || empty($data['tracker_id'])) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode(false);
            }

            $tracker_id = $data['tracker_id'];
            $tracker = $this->Tracker->getTrackerDetails($tracker_id);

            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($tracker);
        }

        return false;
    }


    /**
    * load the opening information from a tracker
    * and return the result as json object
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return json object | boolean
    */
    public function loadTrackerOpeningInformation() {

        if($this->RequestHandler->isAjax()) {

            $data = $this->data;

            if(!isset($data['tracker_id']) || empty($data['tracker_id'])) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode(false);
            }

            $tracker_id = $data['tracker_id'];
            $tracker = $this->Tracker->getTrackerDetails($tracker_id);

            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($tracker);
        }

        return false;
    }


    /**
    * load the details of a trackers link into
    * the depending element
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $linktracker_id
    * @return void
    */
    public function loadTrackersLinkDetails($linktracker_id = null) {
        if(!$linktracker_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }
        
        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $linktracker_details = $this->Tracker->TrackersLink->getLinkDetails($linktracker_id);
        $formats = $this->formats;
        $tracking_link_statuses = $this->Tracker->getStatuses();
        $tracking_link_statuses_labels = $this->Tracker->getStatusesLabels();

        $this->set(compact('formats', 'linktracker_details', 'tracking_link_statuses', 'tracking_link_statuses_labels'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Trackers/trackers_link_details', 'ajax');
            return;
        }
    }


    /**
    * load the details of a trackers link as json object
    * for use within the JS code to pre-populate the modal-form
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $linktracker_id
    * @return void
    */
    public function loadTrackersLinkDetailsForEdit($linktracker_id = null) {
        
        if($this->RequestHandler->isAjax()) {
            
            $trackers_link_id = $this->params->query('trackers_link_id');

            $trackers_link = $this->Tracker->TrackersLink->getLinkDetails($trackers_link_id);

            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($trackers_link);
        }

        return false;
    }

    /**
    * save the general information of a tracker
    * via ajax
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return json object | boolean
    */
    public function saveTrackerGeneralInformation() {

        if($this->RequestHandler->isAjax()) {

            $data = $this->params->query;
            foreach($data as $key => $value) {
                $data[$key] = urldecode($value);
            }

            if($this->Tracker->saveTrackerGeneralInformation($data)) {
                $result = true;
            } else {
                $result = $this->Tracker->invalidFields();
            }

            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($result);
        }

        return false;
    }


    /**
    * save the opening information of a tracker
    * via ajax
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return json object | boolean
    */
    public function saveTrackerOpeningInformation() {

        if($this->RequestHandler->isAjax()) {

            $data = $this->params->query;
            foreach($data as $key => $value) {
                $data[$key] = urldecode($value);
            }

            if($this->Tracker->saveTrackerOpeningInformation($data)) {
                $result = true;
            } else {
                $result = $this->Tracker->invalidFields();
            }

            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($result);
        }

        return false;
    }


    /**
    * save the details of a trackers link via
    * ajax
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return json object | boolean
    */
    public function saveTrackersLinkDetails() {

        if($this->RequestHandler->isAjax()) {

            # remap data, decode encoded strings
            $data = $this->params->query;
            foreach($data as $key => $val) {
                $data[$key] = urldecode($val);
            }

            $this->Tracker->TrackersLink->id = $data['trackers_link_id'];
            
            # check if record exists
            if(!$this->Tracker->TrackersLink->exists()) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return json_encode(false);
            }

            # validation/saving
            if($this->Tracker->TrackersLink->edit($data)) {
                $result = true;
            } else {
                $result = $this->Tracker->TrackersLink->invalidFields();
            }

            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($result);
        }

        return false;
    }


    /**
    * set the recipient of a tracker-record to a
    * given one via ajax
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return json object | boolean
    */
    public function setTrackerRecipient() {

        if($this->RequestHandler->isAjax()) {

            $tracker_id     = urldecode($this->params->query('tracker_id'));
            $recipient_id   = urldecode($this->params->query('recipient_id'));

            if($this->Tracker->setRecipient($tracker_id, $recipient_id)) {
                $result = true;
            } else {
                $result = $this->Tracker->invalidFields();
            }

            Configure::write('debug', 0);
            $this->autoRender = false;
            return json_encode($result);
        }

        return false;
    }


    /**
    * catch a tracking-link and update its status,
    * then redirect to the corresponding link
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function trackLink() {

        $query = $this->params->query;

        if(!isset($query['t_id']) || !isset($query['e_id']) || !isset($query['l_id'])) {
            # maybe add logging of incorrect tracking-links here...
            $this->redirect('/');
        }

        unset($this->params->query);

        // inject client IP
        if(Configure::read('Environment') == 'LOCAL') {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }

        // bundle all information and update tracker-link entry
        $tracker_update = array(
            't_id' => $query['t_id'],
            'e_id' => $query['e_id'],
            'l_id' => $query['l_id'],
            'ip' => $ip,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'lang' => $_SERVER['HTTP_ACCEPT_LANGUAGE']
        );


        if($this->Tracker->updateLinkTracker($tracker_update)) {
            $original_url = $this->Tracker->TrackersLink->field('url');
            $this->redirect($original_url);
        }

        $this->redirect('/');
    }


    /**
    * update the wrapper of a tracker's general
    * information and render it into the corresponding
    * view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id
    * @return void
    */
    public function updateWrapperTrackerGeneralInformation($tracker_id = null) {
        if(!$tracker_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $tracker = $this->Tracker->getTrackerDetails($tracker_id);
        $options_tracker_types = $this->Tracker->getSystemTypes();

        $this->set(compact('tracker', 'options_tracker_types'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Trackers/wrapper_general_information', 'ajax');
            return;
        }
    }


    /**
    * update the wrapper of a tracker's opening
    * information and render it into the corresponding
    * view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id
    * @return void
    */
    public function updateWrapperTrackerOpeningInformation($tracker_id = null) {
        if(!$tracker_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $tracker = $this->Tracker->getTrackerDetails($tracker_id);
        $statuses = $this->Tracker->getStatuses();
        $statuses_labels = $this->Tracker->getStatusesLabels();

        $this->set(compact('tracker', 'statuses', 'statuses_labels'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Trackers/wrapper_opening_information', 'ajax');
            return;
        }
    }


    /**
    * update the wrapper of a tracker's recipient
    * information and render it into the corresponding
    * view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id
    * @return void
    */
    public function updateWrapperTrackerRecipient($tracker_id = null) {
        if(!$tracker_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $recipient = $this->Tracker->getRecipientByTracker($tracker_id);

        $this->set(compact('recipient'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Trackers/wrapper_tracker_recipient', 'ajax');
            return;
        }
    }


    /**
    * update the wrapper of a tracker's connected
    * tracking-links and render it into the corresponding
    * element
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $tracker_id
    * @return void
    */
    public function updateWrapperTrackingLinks($tracker_id = null) {
        if(!$tracker_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $tracking_links = $this->Tracker->getTrackerLinks($tracker_id);
        $trackers_link_statuses = $this->Tracker->TrackersLink->getStatuses();
        $trackers_link_statuses_labels = $this->Tracker->TrackersLink->getStatusesLabels();

        $this->set(compact('tracking_links', 'trackers_link_statuses', 'trackers_link_statuses_labels'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Trackers/wrapper_tracking_links', 'ajax');
            return;
        }
    }


    /**
    * update the row of a trackers link after editing it
    * and render it into the corresponding view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $trackers_link_id
    * @return void
    */
    public function updateWrapperTrackingLinksRow($trackers_link_id = null) {
        if(!$trackers_link_id)  {
            $this->Session->setFlash(__('Invalid ID!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }

        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $link = $this->Tracker->TrackersLink->getLinkById($trackers_link_id);
        $trackers_link_statuses = $this->Tracker->TrackersLink->getStatuses();
        $trackers_link_statuses_labels = $this->Tracker->TrackersLink->getStatusesLabels();

        $this->set(compact('link', 'trackers_link_statuses', 'trackers_link_statuses_labels'));

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Trackers/wrapper_tracking_links_row', 'ajax');
            return;
        }
    }


    /**
    * view a tracker record and all its sub-information
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $id
    * @return void
    */
    public function view($id = null) {

        if(!$id)  {
            $this->Session->setFlash(__('Invalid request!', true), 'default', array('class' => 'alert alert-error'));
            $this->redirect($this->referer());
        }


        if(!$this->Permission->isAdmin()) {
            throw new NotFoundException();
        }

        $tracker = $this->Tracker->getTrackerDetails($id);
        $recipient = $this->Tracker->getRecipientByTracker($id);
        
        $tracking_links = $this->Tracker->getTrackerLinks($id);
        $email_log = $this->Tracker->getEmailLog($id);

        $statuses = $this->Tracker->getStatuses();
        $statuses_labels = $this->Tracker->getStatusesLabels();

        $options_tracker_types = $this->Tracker->getSystemTypes();

        $trackers_link_statuses = $this->Tracker->TrackersLink->getStatuses();
        $trackers_link_statuses_labels = $this->Tracker->TrackersLink->getStatusesLabels();

        $this->set(compact('email_log', 'options_trackers_link_status', 'options_tracker_types', 'recipient', 'statuses', 'statuses_labels', 
            'tracker', 'tracking_links', 'trackers_link_statuses', 'trackers_link_statuses_labels'));
    }

}
