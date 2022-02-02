<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            Guestify - <?php echo $title_for_layout; ?>
        </title>
        <?php
            echo $this->Html->meta('icon');
            echo $this->Html->css('bootstrap/css/bootstrap.min');
            echo $this->Html->css('main_authed');
            #echo $this->Html->css('common');

            echo $this->Html->script('jquery-1.11.1.min');
            echo $this->Html->script('../css/bootstrap/js/bootstrap.min');
            echo $this->Html->script('common');

            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,600' rel='stylesheet' type='text/css'>
        <meta name="viewport" content="width=device-width" />
    </head>

    <body <?php if($this->Session->check('Auth.User.id')) { ?> class="authed" <?php } ?>>
        <?php
            // if(($_SERVER['HTTP_HOST'] == 'guestify.net') || ($_SERVER['HTTP_HOST'] == 'www.guestify.net')) {
            //     echo $this->element('analyticstracking');
            // }
        ?>

        <div class="container">
            <?php if($this->Session->check('Auth.User.id')) { ?>
                <div id="header">
                    <?php echo $this->element('header'); ?>
                </div>
            <?php } ?>

            <div id="content">
                <?php echo $this->Session->flash(); ?>
                <div clasS="crumbs"><?php echo $this->Html->getCrumbs(' › '); ?></div>
                <?php echo $this->fetch('content'); ?>
            </div>

            <div id="footer">
                <?php echo $this->element('footer'); ?>
            </div>
        </div>
        <p>&nbsp;</p>
        <div class="container bg-warning">
            <?php echo $this->element('sql_dump'); ?>
        </div>

    </body>
</html>
