<?php
class TokensController extends AppController {

    public $name = 'Tokens';

    public $uses = array('Token');


    public function beforeFilter() {
        parent::beforeFilter();
        if(!$this->Session->check('Auth.User.id')) {
            $this->redirect('/');
        }
    }



    /**
    * list all languages in a paginated way
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $type
    * @return boolean
    */
    public function index($instance = 'guestifyapp', $locale = 'eng', $rebuild_referer = null) {

        if($rebuild_referer == true) {
            $this->Session->setFlash(__('Token-cache was rebuilt!', true), 'default', array('class' => 'alert alert-success'));
        }
        

        $conditions = array();
        $conditions['Token.deleted']    = 0;
        $conditions['Token.locale']     = $locale;
        $conditions['Token.instance']   = $instance;

        if($this->RequestHandler->isPost()) {
            $data = $this->data;

            if(!empty($data['Token']['search'])) {
                $conditions['OR'] = array(
                    'Token.token LIKE' => '%'.$data['Token']['search'].'%',
                    'Token.content LIKE' => '%'.$data['Token']['search'].'%'
                );
                $this->Session->write('Tokens.index.conditions', $conditions);
            } else {
                $this->Session->write('Tokens.index.conditions', '');
            }
        }

        $this->params['Tokens.index.tab_instance']  = $instance;
        $this->params['Tokens.index.tab_locale']    = $locale;

        $conditions_filter = $this->Session->read('Tokens.index.conditions');
        if(!empty($conditions_filter)) {
            $conditions = array_merge($conditions, $conditions_filter);
        }


        # paginate the list with manual options
        $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 5,
            'order' => array(
                'Token.token' => 'ASC'
            )
        );
        $tokens = $this->paginate('Token');

        $codes = Configure::read('Locales');

        $navtab_counts = $this->Token->getTabCounts($codes);

        $this->set(compact('char', 'codes', 'locale', 'instance', 'navtab_counts', 'tokens'));

        $this->params['navtabs.main'] = 'tokens';

        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->render('/Elements/Tokens/list', 'default');
            return;
        }
    }


    /**
    * rebuild the token cache for a specific locale
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $locale
    * @return boolean
    */
    public function rebuildCache($instance = 'guestifyapp', $locale = 'eng') {
        
        $tokens = $this->Token->getTokens($instance, $locale);
        Cache::write('tokens.'.$instance.'.'.$locale, $tokens, 'default');
        
        $this->Session->setFlash(__('Token-cache was rebuilt!', true), 'default', array('class' => 'alert alert-success'));
        $this->redirect($this->referer());
    }


    /**
    * list all languages in a paginated way
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function resetSearch() {
        $this->Session->write('Tokens.index.conditions', '');
        $this->redirect($this->referer());
    }


   /**
    * function to get a list of all templates with full paths 
    * to collect tokens (used in buildTokens-function!), fully
    * recursive
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $pattern, int $flags, string $path
    * @return array
    */
    public function rglob($pattern = '*', $flags = 0, $path = '') {
        $paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
        $files = glob($path.$pattern, $flags);
        if(empty($files)) {
            $files = array();
        }
        foreach ($paths as $path) {
            $files = array_merge($files, $this->rglob($pattern, $flags, $path));
        }
        return $files;
    }


    /**
    * update the token database by searching for tokens
    * in all (hardcoded) paths of the system
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param string $instance, string $locale
    * @return void
    */
    public function update($instance = 'guestifyapp', $locale = 'eng') {

        $counts             = array();
        $counts['new']      = 0;
        $counts['removed']  = 0;

        $existing = $this->Token->getExistingTokens($instance, $locale);

        if($instance == 'guestifyapp') {
            $backend_path = APP;
            $backend_ctp = $this->rglob('*.ctp', 0, $backend_path.'View/');
            $backend_php_controllers = $this->rglob('*.php', 0, $backend_path.'Controller/');
            $backend_php_shells = $this->rglob('*.php', 0, $backend_path.'Console/Command/');
            $backend_php_models = $this->rglob('*.php', 0, $backend_path.'Model/');

            $files = array_merge($backend_ctp, $backend_php_controllers, $backend_php_shells, $backend_php_models);
        }

        if($instance == 'feedbackapp') {
            $frontend_path = APP.'../../feedbackapp/app/';
            $frontend_ctp = $this->rglob('*.ctp', 0, $frontend_path.'View/');
            $frontend_php_controllers = $this->rglob('*.php', 0, $frontend_path.'Controller/');
            $frontend_php_shells = $this->rglob('*.php', 0, $frontend_path.'Console/Command/');
            $frontend_php_models = $this->rglob('*.php', 0, $frontend_path.'Model/');

            $files = array_merge($frontend_ctp, $frontend_php_controllers, $frontend_php_shells, $frontend_php_models);
        }

        if($instance == 'apiapp') {
            $frontend_path = APP.'../../apiapp/app/';
            $frontend_ctp = $this->rglob('*.ctp', 0, $frontend_path.'View/');
            $frontend_php_controllers = $this->rglob('*.php', 0, $frontend_path.'Controller/');
            $frontend_php_shells = $this->rglob('*.php', 0, $frontend_path.'Console/Command/');
            $frontend_php_models = $this->rglob('*.php', 0, $frontend_path.'Model/');

            $files = array_merge($frontend_ctp, $frontend_php_controllers, $frontend_php_shells, $frontend_php_models);
        }

        if($instance == 'widgetapp') {
            $frontend_path = APP.'../../widgetapp/app/';
            $frontend_ctp = $this->rglob('*.ctp', 0, $frontend_path.'View/');
            $frontend_php_controllers = $this->rglob('*.php', 0, $frontend_path.'Controller/');
            $frontend_php_shells = $this->rglob('*.php', 0, $frontend_path.'Console/Command/');
            $frontend_php_models = $this->rglob('*.php', 0, $frontend_path.'Model/');

            $files = array_merge($frontend_ctp, $frontend_php_controllers, $frontend_php_shells, $frontend_php_models);
        }

        $tokens = array();

        foreach($files as $file) {
            $handle = file_get_contents($file);
            preg_match_all("/__\(\'(.*?)\'/", $handle, $matches);
            if(isset($matches[1]) && is_array($matches[1])) {
                foreach($matches[1] as $token) {
                    if(!isset($tokens[$token])) {
                        $tokens[$token] = array();
                    }
                    if(!in_array($file, $tokens[$token])) {
                        array_push($tokens[$token], $file);
                    }
                }
            }
        }

        $new_tokens = array();
        foreach($tokens as $token => $files) {
            if(!in_array($token, $existing)) {
                $new_tokens[$token] = $tokens[$token];
            } else {
                unset($existing[array_search($token, $existing)]);
            }
        }


        // save tokens into db
        if(!empty($new_tokens)) {
            foreach($new_tokens as $token => $locations) {
                $record = array();
                $record['Token']['token']       = $token;
                $record['Token']['instance']    = $instance;
                $record['Token']['locale']      = $locale;
                $record['Token']['locations']   = str_replace(APP.'../../', '', implode($locations, ','));
                $record['Token']['content']     = '';

                $this->Token->create();
                if($this->Token->save($record)) {
                    $counts['new']++;
                }
            }
        }

        # remove tokens that are not existing anymore
        if(!empty($existing)) {
            foreach($existing as $token) {
                if($this->Token->removeToken($token, $instance, $locale)) {
                    $counts['removed']++;
                }
            }
        }

        # count new tokens
        $this->Session->setFlash($counts['new'].' '.__('token(s) added', true).', '.$counts['removed'].' '.__('token(s) removed!', true), 'default', array('class' => 'alert alert-success'));
        $this->redirect($this->referer());
    }


    /**
    * update a token via ajax
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return boolean
    */
    public function updateToken() {
        if($this->RequestHandler->isAjax()) {

            $token_id = $this->params->query('token_id');
            $content = urldecode($this->params->query('content'));

            if($this->Token->updateToken($token_id, $content)) {
                Configure::write('debug', 0);
                $this->autoRender = false;
                return true;
            } else {
                $result = $this->Token->invalidFields();
                Configure::write('debug', 0);
                $this->autoRender = false;
                return false;
            }
        }

        return false;
    }

}
