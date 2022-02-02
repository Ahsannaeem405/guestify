<?php
    function __($singular, $args = null) {
        if (!$singular) {
            return;
        }

        $instance = Configure::read('Instance');
        $locale = Configure::read('Config.language');

        if(empty($instance)) {
            $instance = 'guestifyapp';
        }
        if(empty($locale)) {
            $locale = Configure::read('Language.default');
        }

        try {
            APP::import('Model', 'Token');
            $Token = new Token();
        } catch (Exception $e) {
            return vsprintf($singular, $args);
        }

        # token structure: $tokens[$token]!
        # try to get the token-translation from the cached tokens stack
        $tokens = Cache::read('tokens.'.$instance.'.'.$locale);
        if(empty($tokens)) {
            $tokens = $Token->getTokens($instance, $locale);
            if(!empty($tokens)) {
                Cache::write('tokens.'.$instance.'.'.$locale, $tokens, 'default');
            }
        }


        if(isset($tokens[$singular]) && !empty($tokens[$singular])) {
            return strip_tags($tokens[$singular]);
        }

        # detect special chars and do NOT use vsprintf otherwise it will break!
        if(strpos($singular,'%') !== false) {
            return $singular;
        }

        return vsprintf(htmlspecialchars($singular), $args);

        # if token was not found within the stack, search for new translation in DB
        /*
        $temp = $Token->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Token.token' => $singular,
                'Token.instance' => $instance,
                'Token.locale' => $locale,
                'Token.deleted' => 0
            )
        ));

        if(empty($temp) || $temp['Token']['content'] == '') {
            $result = $singular;
        } else {
            $result = $temp['Token']['content'];
        }

        return vsprintf($result, $args);
        */
    } 
?>