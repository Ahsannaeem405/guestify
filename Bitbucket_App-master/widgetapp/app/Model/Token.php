<?php
class Token extends AppModel {

    public $name = 'Token';



    /**
    * get all tokens based on a given locale for the FE
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return string
    */
    public function getTokens($instance, $locale) {
        
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
    }

}
