<?php
class Token extends AppModel {

    public $name = 'Token';

    public $actsAs = array(
        'Containable'
    );

    /**
    * Get all existing tokens from database
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return string
    */
    public function getExistingTokens($instance, $locale) {

        $existing = $this->find('list', array(
            'recursive' => -1,
            'conditions' => array(
                'Token.deleted' => 0
            ),
            'fields' => array(
                'Token.id',
                'Token.token'
            ),
            'conditions' => array(
                'Token.deleted' => 0,
                'Token.locale' => $locale,
                'Token.instance' => $instance
            )
        ));

        return $existing;
    }

    /**
    * get the navtab counts for the token section
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param array $codes
    * @return int $navtab_counts
    */
    public function getTabCounts($codes = null, $dummy = null) {

        $navtab_counts = array();

        foreach($codes as $locale => $name) {

            $navtab_counts['guestifyapp'][$locale] = $this->find('count', array(
                'conditions' => array(
                    'Token.deleted' => 0,
                    'Token.locale' => $locale,
                    'Token.instance' => 'guestifyapp'
                )
            ));

            $navtab_counts['feedbackapp'][$locale] = $this->find('count', array(
                'conditions' => array(
                    'Token.deleted' => 0,
                    'Token.locale' => $locale,
                    'Token.instance' => 'feedbackapp'
                )
            ));
        }

        $navtab_counts['guestifyapp']['overall'] = 0;
        foreach($navtab_counts['guestifyapp'] as $locale => $count) {
            $navtab_counts['guestifyapp']['overall'] += $count;
        }
        
        $navtab_counts['feedbackapp']['overall'] = 0;
        foreach($navtab_counts['feedbackapp'] as $locale => $count) {
            $navtab_counts['feedbackapp']['overall'] += $count;;
        }

        return $navtab_counts;
    }

    /**
    * get all tokens based on a given locale for the FE
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return string
    */
    public function getTokens($instance, $locale) {
        
        try {
            $tokens = $this->find('all', array(
                'conditions' => array(
                    'Token.deleted' => 0,
                    'Token.instance' => $instance,
                    'Token.locale' => $locale
                ),
                'fields' => array(
                    'Token.token',
                    'Token.content'
                )
            ));

            $result = array();
            
            foreach($tokens as $record) {
                $result[$record['Token']['token']] = $record['Token']['content'];
            }

            return $result;
        } catch (Exception $e) {
            return array();
        }

        return array();
    }

    /**
    * remove a token from the database
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $token, string $locale
    * @return boolean
    */
    public function removeToken($token = null, $instance = null, $locale = null) {
        if(!$token || !$instance || !$locale) {
            return false;
        }

        $record = $this->find('first', array(
            'conditions' => array(
                'Token.token' => $token,
                'Token.instance' => $instance,
                'Token.locale' => $locale,
                'Token.deleted' => 0
            )
        ));

        if(empty($record)) {
            return false;
        }

        $this->id = $record['Token']['id'];
        if($this->saveField('deleted', 1)) {
            return true;
        }

        return false;
    }

    /**
    * update a token record
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $token_id, string $content
    * @return boolean
    */
    public function updateToken($token_id = null, $content = null) {
        if(!$token_id) {
            return false;
        }

        $this->id = $token_id;
        
        if(!$this->exists()) {
            return false;
        }
        
        if(empty($content)) {
            $content = '';
        }
        
        if($this->saveField('content', $content)) {
            return true;
        }

        return false;
    }

}
