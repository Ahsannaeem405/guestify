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
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title><?php echo $title_for_layout;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body bgcolor="#f0f0f0" topmargin="20" leftmargin="20" style="font-family:  Helvetica, Arial, sans-serif; font-size: 10pt; color: #666; padding: 20px; background-color: #f0f0f0;">
        <style type="text/css" media="screen">
            body {
                font-family:  Helvetica, Arial, sans-serif;
                font-size: 10pt;
                color: #666;
                margin: 0;
                padding: 20px;
                background-color: #f0f0f0;
                }
            a, a:link, a:hover { color: #388f58; }
        </style>
        <table width="95%" cellpadding="0" cellspacing="0" border="0" class="bg" style="background-color: #f0f0f0; " >
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" width="610" border="0" align="center" class="main">
                        <tr>
                            <td valign="top">
                                <table cellpadding="0" cellspacing="0" width="610" border="0">
                                    <tr>
                                        <td width="98%" style="padding: 0px;">
                                            <div style="background-color: #059ec7; padding: 0; font-family:  Helvetica, Arial, sans-serif; boder:1px #fff solid; width: 590px; height: 170px; margin: 0px; ">
                                                <?php /*
                                                <a href="<?php echo Configure::read('NON_SSL_HOST'); ?>" style=" color: #eee; text-decoration: none; text-transform: uppercase; text-align: center; display: block;"></a>
                                                */ ?>
                                                <?php $image = '<img src="' . Configure::read('NON_SSL_HOST') . '/graphics/logos/300/guestify_logo_word_brand_regular_300.jpg" alt="guestify.net" width="300px" height"150px" border="0" style="margin: 10px; vertical-align: bottom;" />'; ?>
                                                <?php echo $this->Tracker->link($image, Configure::read('NON_SSL_HOST'), array('escape' => false)); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="98%" style="padding: 00px;">
                                            <div style="background-color: #fafafa; font-family:  Helvetica, Arial, sans-serif; padding: 20px;  boder:1px #fff solid; width: 550px; margin: 0;">
                                                <?php echo $this->fetch('content'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="98%" style="padding: 0px;">
                                            <div style="background-color: #cccccc; padding: 20px;  boder:1px #fff solid; width: 550px; margin: 0px;">
                                                <div style="display: block;">
                                                    <div style="font-family:  Helvetica, Arial, sans-serif; font-size: 12px; color: #666;">
                                                        <p style="text-align: right;">                                                           
                                                            <?php /*
                                                            <a href="https://www.facebook.com/guestifyapp" target="_blank" title="Follow us on Facebook" style="float: left;">
                                                                <img src="<?php echo Configure::read('NON_SSL_HOST'); ?>/graphics/own-social/48-facebook.png" alt="Facebook: guestifyapp" >
                                                            </a>
                                                            &nbsp;
                                                            */ ?>
                                                            
                                                            <?php /*
                                                            <a href="https://twitter.com/guestifyapp" target="_blank" title="Follow us on twitter" style="float: left;">
                                                                <img src="<?php echo Configure::read('NON_SSL_HOST'); ?>/graphics/own-social/48-twitter.png" alt="twitter: @guestifyapp">
                                                            </a>
                                                            &nbsp;
                                                            */ ?>

                                                            <?php $image = '<img src="' . Configure::read('NON_SSL_HOST') . '/graphics/own-social/48-facebook.png" alt="Facebook: guestifyapp">'; ?>
                                                            <?php echo $this->Tracker->link($image, 'https://www.facebook.com/guestifyapp', array('escape' => false, 'target' => 'blank', 'title' => 'Follow us on Facebook', 'style' => 'float: left;')); ?>
                                                            &nbsp;

                                                            <?php $image = '<img src="' . Configure::read('NON_SSL_HOST') . '/graphics/own-social/48-twitter.png" alt="twitter: @guestifyapp">'; ?>
                                                            <?php echo $this->Tracker->link($image, 'https://twitter.com/guestifyapp', array('escape' => false, 'target' => 'blank', 'title' => 'Follow us on Facebook', 'style' => 'float: left;')); ?>
                                                            &nbsp;
                                                            
                                                            <small style="font-size: 10px;">
                                                                <?php echo __('Copyright', true); ?> &copy; 2014 - <?php echo date('Y'); ?> 
                                                                <?php /*
                                                                <a href="https://guestify.net" style="color: #059ec7; text-decoration: none;">https://guestify.net</a>
                                                                */ ?>
                                                                <?php echo $this->Tracker->link('https://guestify.net', 'https://guestify.net', array('style' => 'color: #059ec7; text-decoration: none;')); ?>
                                                                <br />
                                                                <?php echo __('Application service from Michael Bisse, Raleigh, NC, USA', true); ?>
                                                            </small>
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                            <div>&nbsp;</div>
                                            <small style="font-size: 10px;">
                                                <?php echo __('If you have received this message in error and you have not signed up at guestify.net, then please email us via hello@guestify.net.'); ?><br />
                                                <?php echo __('Please do not reply to this email; this was sent from an automated email address. This message is a service email associated with your use of guestify.net'); ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <?php if(isset($tracker) && !empty($tracker)) { ?>
            <?php echo $this->Tracker->addTrackingPixel($tracker); ?>
        <?php } ?>

    </body>
</html>
