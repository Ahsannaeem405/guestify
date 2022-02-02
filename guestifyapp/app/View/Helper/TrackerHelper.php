<?php
/*
*  Helper to decide wether a user is allowed to see
*  specified elements or not
*/ 
App::uses('HtmlHelper', 'View/Helper');
class TrackerHelper extends HtmlHelper {

    public $helpers = array('Session');


    /**
    * create a CakePHP-link and convert it to a tracking link
    * if tracking-information is given
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $title, string $url, array $options, boolean $confirmMessage
    * @return string
    */
	public function link($title, $url = null, $options = array(), $confirmMessage = false) {
		
		$escapeTitle = true;
		if ($url !== null) {
			$url = $this->url($url);
		} else {
			$url = $this->url($title);
			$title = htmlspecialchars_decode($url, ENT_QUOTES);
			$title = h(urldecode($title));
			$escapeTitle = false;
		}

		if (isset($options['escapeTitle'])) {
			$escapeTitle = $options['escapeTitle'];
			unset($options['escapeTitle']);
		} elseif (isset($options['escape'])) {
			$escapeTitle = $options['escape'];
		}

		if ($escapeTitle === true) {
			$title = h($title);
		} elseif (is_string($escapeTitle)) {
			$title = htmlentities($title, ENT_QUOTES, $escapeTitle);
		}

		if (!empty($options['confirm'])) {
			$confirmMessage = $options['confirm'];
			unset($options['confirm']);
		}
		if($confirmMessage) {
			$options['onclick'] = $this->_confirm($confirmMessage, 'return true;', 'return false;', $options);
		} elseif (isset($options['default']) && !$options['default']) {
			if (isset($options['onclick'])) {
				$options['onclick'] .= ' ';
			} else {
				$options['onclick'] = '';
			}
			$options['onclick'] .= 'event.returnValue = false; return false;';
			unset($options['default']);
		}


		# implement link tracking
		if(isset($this->_View->viewVars['tracker']) && !empty($this->_View->viewVars['tracker'])) {

			$tracker = $this->_View->viewVars['tracker'];
			$tracker['Tracker']['link_id'] = md5($url . date('Y-m-d H:i:s') . $tracker['Tracker']['id'] . $tracker['Tracker']['email_id'] . Configure::read('Security.salt'));
			$tracker['Tracker']['url'] 	= $url;

			$tracker_string = 'tl?t_id=' . $tracker['Tracker']['id'] . '&e_id=' . $tracker['Tracker']['email_id'] . '&l_id=' . $tracker['Tracker']['link_id'];
			$url = Configure::read('NON_SSL_HOST') . '/' . $tracker_string;
			$tracker['Tracker']['tracker_string'] 	= $tracker_string;

			# save the tracking link
			$Tracker = ClassRegistry::init('Tracker');
			$Tracker->createTrackingLink($tracker);

			#$url .= $tracker_string;
			
			unset($options['tracker']);
		}

		return sprintf($this->_tags['link'], $url, $this->_parseAttributes($options), $title);
	}


    /**
    * creates a formatted tracking-pixel link as html-string
    * inherits tracking information if set to view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return string
    */
    public function addTrackingPixel() {

        if(isset($this->_View->viewVars['tracker']) && !empty($this->_View->viewVars['tracker'])) {
        	$tracker = $this->_View->viewVars['tracker'];
        } else {
        	return '';
        }

        if(!isset($tracker['Tracker']['id']) || !isset($tracker['Tracker']['email_id'])) {
        	return '';
        }

        $tag = '<img src="'.Configure::read('NON_SSL_HOST') . '/tp?t_id=' . $tracker['Tracker']['id'] . '&e_id=' . $tracker['Tracker']['email_id'] . '" />';

        return $tag;
    }


    /**
    * creates a formatted tracking-pixel link (google version) as html-string
    * inherits tracking information if set to view
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return string
    */
    public function addTrackingPixelGoogle() {

        if(isset($this->_View->viewVars['tracker']) && !empty($this->_View->viewVars['tracker'])) {
        	$tracker = $this->_View->viewVars['tracker'];
        } else {
        	return '';
        }

        if(!isset($tracker['Tracker']['type']) || !isset($tracker['Tracker']['email'])) {
        	return '';
        }

        $tag = '<img src="'.Configure::read('NON_SSL_HOST') . '/tracker/pixel/' . $tracker['Tracker']['id'] . '/' . $tracker['Tracker']['email_id'] . '" />';

        return $tag;
    }


    /**
    * returns a string with a well-formatted duration-description
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $datetime_start, string $datetime_end, 
    * @return string
    */
	public function getNiceDuration($datetime_start, $datetime_end) {

		$durationInSeconds = strtotime($datetime_end) - strtotime($datetime_start);

		$duration = '';
		$days = floor($durationInSeconds / 86400);
		$durationInSeconds -= $days * 86400;
		$hours = floor($durationInSeconds / 3600);
		$durationInSeconds -= $hours * 3600;
		$minutes = floor($durationInSeconds / 60);
		$seconds = $durationInSeconds - $minutes * 60;

		if($days > 0) {
			if($days == 1) { 
				$duration .= $days . ' ' . __('day', true);
			} else {
				$duration .= $days . ' ' . __('days', true);
			}
		}

		if($hours > 0) {
			if($hours == 1) { 
				$duration .= ' ' . $hours . ' ' . __('hour', true);
			} else {
				$duration .= ' ' . $hours . ' ' . __('hours', true);
			}
		}

		if($minutes > 0) {
			if($minutes == 1) { 
				$duration .= ' ' . $minutes . ' ' . __('minute', true);
			} else {
				$duration .= ' ' . $minutes . ' ' . __('minutes', true);
			}
		}

		if($seconds > 0) {
			if($seconds == 1) { 
				$duration .= ' ' . $seconds . ' ' . __('second', true);
			} else {
				$duration .= ' ' . $seconds . ' ' . __('seconds', true);
			}
		} else {
			$duration = '0' . ' ' . __('seconds', true);
		}

		return $duration;
	}

}
