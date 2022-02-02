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

    Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
    Router::connect('/en', array('controller' => 'pages', 'action' => 'display', 'home'));
    Router::connect('/de', array('controller' => 'pages', 'action' => 'display', 'home'));

    Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

    Router::connect('/dashboard', array('controller' => 'pages', 'action' => 'display', 'dashboard'));

    Router::connect('/admin_dashboard', array('controller' => 'pages', 'action' => 'display', 'admin_dashboard'));

    // Router::connect('/terms', array('controller' => 'pages', 'action' => 'display', 'terms'));
    Router::connect('/en/terms', array('controller' => 'pages', 'action' => 'display', 'terms'));
    Router::connect('/de/terms', array('controller' => 'pages', 'action' => 'display', 'terms'));
    

    Router::connect('/first-steps', array('controller' => 'pages', 'action' => 'display', 'first_steps'));
    Router::connect('/privacy', array('controller' => 'pages', 'action' => 'display', 'privacy'));
    Router::connect('/imprint', array('controller' => 'pages', 'action' => 'display', 'imprint'));

    Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
    Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));

    Router::connect('/register', array('controller' => 'users', 'action' => 'register'));

    Router::connect('/activate/:activation_hash', array('controller' => 'users', 'action' => 'activate'), array('pass' => array('activation_hash')));

    Router::connect('/forgot-password', array('controller' => 'users', 'action' => 'forgotPassword'));
    Router::connect('/recovery/:activation_hash', array('controller' => 'users', 'action' => 'recovery'), array('pass' => array('activation_hash')));

    #Router::connect('/polls/checkPin', array('controller' => 'polls', 'action' => 'checkPin'));

    Router::connect('/auth/:hash', array('controller' => 'polls', 'action' => 'auth'), array('pass' => array('hash')));

    Router::connect('/polls', array('controller' => 'polls', 'action' => 'index'));
    Router::connect('/polls/index', array('controller' => 'polls', 'action' => 'index'));
    Router::connect('/polls/view/:id', array('controller' => 'polls', 'action' => 'view'), array('pass' => array('id')));

    Router::connect('/hosts', array('controller' => 'hosts', 'action' => 'index'));
    Router::connect('/hosts/index', array('controller' => 'hosts', 'action' => 'index'));
    Router::connect('/hosts/view/:id', array('controller' => 'hosts', 'action' => 'view'), array('pass' => array('id')));

    Router::connect('/polls/upgrade-success', array('controller' => 'polls', 'action' => 'upgrade_success'));
    Router::connect('/polls/upgrade-problem', array('controller' => 'polls', 'action' => 'upgrade_problem'));

    Router::connect('/system', array('controller' => 'pages', 'action' => 'display', 'system'));

    #Router::connect('/tracker/pixel/:tracker_id/:email_id', array('controller' => 'trackers', 'action' => 'loadPixel'), array('pass' => array('tracker_id', 'email_id')));

    # catch all tracking pixels (tp)
    Router::connect('/tp', array('controller' => 'trackers', 'action' => 'loadPixel'));

    # catch all tracking links (tl)
    Router::connect('/tl', array('controller' => 'trackers', 'action' => 'trackLink'));

    # add catcher for email-logging (Amazon SNS)
    Router::connect('/logger/email', array('controller' => 'logs_emails', 'action' => 'logger_email'));



    ####################################################
    #########                API                 #######
    ####################################################

    # API routes for functions
    Router::connect('/api/v1/getToken', array('controller' => 'apis', 'action' => 'getToken'));

    Router::connect('/api/v1/hosts/getHost', array('controller' => 'apis', 'action' => 'getHost'));
    Router::connect('/api/v1/hosts/getPollsByHostId', array('controller' => 'apis', 'action' => 'getPollsByHostId'));
    
    Router::connect('/api/v1/accounts/getAccount', array('controller' => 'apis', 'action' => 'getAccount'));
    
    Router::connect('/api/v1/users/getUser', array('controller' => 'apis', 'action' => 'getUser'));

    Router::connect('/api/v1/polls/getPollAnswers', array('controller' => 'apis', 'action' => 'getPollAnswers'));
    Router::connect('/api/v1/polls/getPoll', array('controller' => 'apis', 'action' => 'getPoll'));
    Router::connect('/api/v1/polls/savePoll', array('controller' => 'apis', 'action' => 'savePoll'));

    # API routes for demos
    Router::connect('/api/v1/demos/polls/testGetPoll', array('controller' => 'apis', 'action' => 'testGetPoll'));

    

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
