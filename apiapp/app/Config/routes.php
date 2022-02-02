<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

    Router::connect('/', array('controller' => 'users', 'action' => 'login'));

    Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

    Router::connect('/dashboard', array('controller' => 'pages', 'action' => 'display', 'dashboard'));

    Router::connect('/admin_dashboard', array('controller' => 'pages', 'action' => 'display', 'admin_dashboard'));

    Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
    Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));


    ####################################################
    #########                API                 #######
    ####################################################

    # API routes for functions
    Router::connect('/v1/getToken', array('controller' => 'apis', 'action' => 'getToken'));

    Router::connect('/v1/hosts/getHost', array('controller' => 'apis', 'action' => 'getHost'));
    Router::connect('/v1/hosts/getPollsByHostId', array('controller' => 'apis', 'action' => 'getPollsByHostId'));
    
    Router::connect('/v1/accounts/getAccount', array('controller' => 'apis', 'action' => 'getAccount'));
    
    Router::connect('/v1/users/getUser', array('controller' => 'apis', 'action' => 'getUser'));

    Router::connect('/v1/polls/getPollAnswers', array('controller' => 'apis', 'action' => 'getPollAnswers'));
    Router::connect('/v1/polls/getPoll', array('controller' => 'apis', 'action' => 'getPoll'));
    Router::connect('/v1/polls/savePoll', array('controller' => 'apis', 'action' => 'savePoll'));

    # API routes for demos
    Router::connect('/v1/demos/polls/testGetPoll', array('controller' => 'apis', 'action' => 'testGetPoll'));

    Router::parseExtensions('json', 'xml');
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
    CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
    require CAKE . 'Config' . DS . 'routes.php';
