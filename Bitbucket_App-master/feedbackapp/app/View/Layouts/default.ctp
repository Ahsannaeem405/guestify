<?php
/**
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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<!doctype html>

<head data-template-set="html5-reset">
    <?php echo $this->Html->charset(); ?>

    <title><?php echo __('Guestify - simple and valuable customer feedback & ratings for your restaurant', true); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="title" content="Guestify" />
    <meta name="description" content="<?php echo __('We invite you to give us your feedback', true); ?>" />
    <meta name="author" content="Guestify" />
    <!-- Google will often use this as its description of your page/site. Make it good. -->

    <meta name="Copyright" content="Guestify" />

    <link rel="shortcut icon" href="/img/favicon.ico" />

    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>

    <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write("<script src='_/js/jquery-1.9.1.min.js'>\x3C/script>")</script>

    <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap/css/bootstrap.min');
        #echo $this->Html->css('bootstrap/bootstrap-responsive');
        echo $this->Html->css('common');

        echo $this->Html->script('/css/bootstrap/js/bootstrap.min');
        echo $this->Html->script('fastclick');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
</head>

<body>
    <?php
        if($_SERVER['HTTP_HOST'] == 'polls.guestify.net') {
            echo $this->element('analyticstracking');
        }
    ?>
    <div class="wrapper">
        <?php #pr($this->params); ?>
        <?php if($this->params['controller']=='polls')  { ?>
            <?php echo $this->fetch('content'); ?>
        <?php } else { ?>
            <div class="container">
                <div class="jumbotron">
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <h1 class="text-center">guestify.net</h1>
                    <p class="text-center"><?php echo __('Please go to our product page for more information.', true);?> <br /><a href="<?php echo Configure::read('NON_SSL_HOST'); ?>">guestify.net</a></p>
                </div>
            </div>
        <?php } ?>

        <?php echo $this->element('sql_dump'); ?>
        <?php echo $this->Js->writeBuffer(); ?>
        <script>
            $(function() {
                FastClick.attach(document.body);
            });
        </script>
    </div>

</body>
