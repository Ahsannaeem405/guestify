<?php
class TokensController extends AppController {

    public $name = 'Tokens';

    public $uses = array('Token');


    public function beforeFilter() {
        parent::beforeFilter();
    }


    /**
    * rebuild the token-cache for a given locale
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $locale
    * @return void
    */
    public function rebuildTokenCache($locale = null) {
        $Token = ClassRegistry::init('Token');
        $tokens = $this->Token->getTokens('feedbackapp', $locale);
        Cache::write('tokens.feedbackapp.'.$locale, $tokens, 'default');
        $this->redirect($this->referer().'/true');
    }



}
