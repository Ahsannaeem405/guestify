<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

error_reporting(E_ERROR | E_WARNING | ~E_STRICT);

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */
CakePlugin::load('Migrations');
CakePlugin::load('DebugKit');

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *      'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *      'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *      array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *      array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));


if(!isset($_SERVER['argv'][3])) {
    if(isset($_SERVER['HTTP_HOST'])) {
        $filename = APP . 'Config/Bootstrap/' . $_SERVER['HTTP_HOST'];
        if (file_exists($filename)) {
            require_once($filename);
        } else {
            require_once(APP . 'Config/Bootstrap/widget.guestify');
        }
    } else {
        
        # no other domains
        #header("HTTP/1.0 404 Not Found");
        #echo "404 - Page not found";
        #exit(0);
    }
} else {

    if(in_array($_SERVER['argv'][3], array('LOCAL', 'STAGE', 'LIVE'))) {
        Configure::write('Environment', $_SERVER['argv'][3]);
    }
}


function __($singular, $args = null) {
    if (!$singular) {
        return;
    }


    $instance   = Configure::read('Instance');
    $locale     = Configure::read('Config.language');


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
        #return strip_tags($tokens[$singular]);
        return $tokens[$singular];
    }

    # detect special chars and do NOT use vsprintf otherwise it will break!
    if(strpos($singular,'%') !== false) {
        return $singular;
    }



    return vsprintf($singular, $args);

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


Configure::write('Language.default', 'eng');
Configure::write('Config.language', 'eng');

Configure::write('Locales', array(
    'deu' => __('German', true),
    'eng' => __('English', true)
));



/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
    'engine' => 'File',
    'types' => array('notice', 'info', 'debug'),
    'file' => 'debug',
));
CakeLog::config('error', array(
    'engine' => 'File',
    'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
    'file' => 'error',
));

Configure::write('Colors', array(
    0 => '#308CDE',
    1 => '#E8008C',
    2 => '#FF6900',
    3 => '#1CFF00',
    4 => '#D98E04',
    5 => '#1CFFED',
    6 => '#AAA',
    7 => '#BBB',
    8 => '#CCC',
    9 => '#DDD',
));
