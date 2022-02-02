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

<?php 
    echo $this->Html->docType('html5');
    $locale = $this->Session->read('Config.language');
?>
<html lang="<?php echo substr($locale, 0, 2); ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $this->Html->charset(); ?>
    <meta name="language" content="<?php echo substr($locale, 0, 2); ?>" />
    <title><?php echo __('Guestify - simple and valuable customer feedback & ratings for your restaurant'); ?></title>


    <?php if (Configure::read('Environment') == 'LIVE') { ?>
        <meta name="robots" content="index,follow" />
        <meta name="robots" content="all" />
        <meta name="allow-search" content="yes" />
    <?php } else { ?>
        <meta name="robots" content="noindex,nofollow" />
        <meta name="allow-search" content="no" />
    <?php } ?>

    <link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
    <link rel="manifest" href="/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <?php
        echo $this->Html->meta(array('name' => 'author', 'content' => 'guestify.net'));
        echo $this->Html->meta(array('name' => 'robots', 'content' => 'all'));
        echo $this->Html->meta(array('name' => 'allow-search', 'content' => 'yes'));
        echo $this->Html->meta(array('name' => 'revisit-after', 'content' => '7 days'));
        echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon'));
        #echo $this->Html->meta('favicon');

        echo $this->Html->css('bootstrap/css/bootstrap.min');
        #echo $this->Html->css('bootstrap-responsive');
        echo $this->Html->css('main');

       
        echo $this->Html->script('https://code.jquery.com/jquery-3.2.1.min.js');
        echo $this->Html->script('bootstrap.min');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>


    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,600' rel='stylesheet' type='text/css'>

</head>

    <body>
        <?php
            if(Configure::read('Environment') == 'LIVE') {
                echo $this->element('analyticstracking');
            }
        ?>
        <?php # contents of landing page are in Pages/home.ctp! ?>
        <?php echo $this->fetch('content'); ?>
        
        <?php 
            echo $this->Html->script('pace');
        ?>
    </body>

</html>
