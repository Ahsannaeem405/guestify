<?php
class TrackersLink extends AppModel {

    public $name = 'TrackersLink';

	public $belongsTo = array(
		'Tracker'
	);

    public $actsAs = array(
        'Containable'
    );



   /**
    * edit a trackers link record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return boolean
    */
    public function edit($data = null) {
        if(!$data || !isset($this->id)) {
            return false;
        }


        if(empty($data['tracker_id'])) {
            $this->invalidate('tracker_id', __('Tracker-ID missing!', true));
        }
        if(empty($data['email_id'])) {
            $this->invalidate('email_id', __('Email-ID missing!', true));
        }
        if(empty($data['tracker_string'])) {
            $this->invalidate('tracker_string', __('Tracker-string missing!', true));
        }
        if(empty($data['link_id'])) {
            $this->invalidate('link_id', __('Link-ID missing!', true));
        }
        if(empty($data['url'])) {
            $this->invalidate('url', __('URL missing!', true));
        }
        if(empty($data['created'])) {
            $this->invalidate('created', __('Created missing!', true));
        }
        if(empty($data['modified'])) {
            $this->invalidate('modified', __('Modified missing!', true));
        }

        if($this->validates()) {
            if($this->save($data)) {
                return true;
            }
        }

        return false;
    }


   /**
    * get a tracker-link by its id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $link_id
    * @return array
    */
    public function getLinkById($link_id = null) {

        $link = $this->find('first', array(
            'conditions' => array(
                'TrackersLink.id' => $link_id
            )
        ));

        return $link;
    }


   /**
    * get an array of statuses
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getStatuses() {

        return array(
            0 => __('not visited yet', true),
            1 => __('visited', true)
        );
    }


   /**
    * get an array of statuses
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getStatusesLabels() {

        return array(
            0 => 'warning',
            1 => 'success'
        );
    }


   /**
    * get a complete link record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $link_id
    * @return mixed
    */
    public function getLinkDetails($link_id = null) {
        if(!$link_id) {
            return false;
        }

        $link = $this->find('first', array(
            'conditions' => array(
                'TrackersLink.id' => $link_id
            )
        ));

        return $link;
    }

}
