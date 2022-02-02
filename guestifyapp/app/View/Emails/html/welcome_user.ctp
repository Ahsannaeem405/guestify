<?php $media_host = Configure::read('CDN.Host'); ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td valign="top" style="text-align: center; line-height: 150%;">
            <h2 style="font-size: 24px; margin: 0px 0px 15px 0; text-align: center;"><?php echo __('Hello', true).' '.$user['User']['firstname'].' '.$user['User']['lastname'].', ';?></h2>
            <h3 style="font-size: 18px; margin: 0px 0px 10px 0; text-align: center; color: #059ec7; padding: 0 50px;"><?php echo __('do not you want to get real ratings from your real guests?', true); ?></h3>
            <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center; padding: 0 50px;"><strong><?php echo __('Start now to get authentic ratings from guests who really have been at your place!'); ?></strong></p>
            <div style="background-color:#fff; padding: 10px; margin: 0 0 20px 0;">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td valign="top" width="50%">
                            <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
                                <img src="<?php echo Configure::read('NON_SSL_HOST'); ?>/graphics/demo/demo-iPhone-6.jpg" alt="iPhone Demo Guestify" />
                            </p>
                            <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
                                <?php echo __('You want to try? Here is our demo!'); ?>
                            </p>
                        </td>
                        <td valign="top" width="50%">
                            <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
                                <img src="<?php echo Configure::read('NON_SSL_HOST'); ?>/graphics/demo/qr-pizzeria-luigi_150.jpg" alt="QR Code Guestify" /><br>
                                <img src="<?php echo Configure::read('NON_SSL_HOST'); ?>/graphics/demo/arrows.jpg" alt="Arrows" />
                            </p>
                            <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
                                <a href="http://demo.guestify.net"><?php echo __('Open the survey'); ?></a><br>
                                <?php echo __('Click on the link above, type in the PIN 12345 and try the survey'); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center; padding: 0 50px;"><?php echo __('With Guestify you have the easiest and most secure way to get real customer feedback. Invite your clients to rate your restaurant with their smartphones while they are there.', true); ?></p>
            <h3 style="font-size: 18px; margin: 0px 0px 10px 0; text-align: center; color: #059ec7; padding: 0 50px;"><?php echo __('In the cockpit everything comes together', true); ?></h3>
            <p>
                <img src="<?php echo Configure::read('NON_SSL_HOST'); ?>/graphics/flat-mockup-template_500.png" alt="guestify cockpit" />
            </p>

            <?php echo $this->Html->tag('h2', __('We would like to invite you to try guestify!', true), array('style'=>'font-size: 24px; margin: 0px 0px 10px 0; text-align: center; color: #059ec7;' ));?>
            <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;"><?php echo __('With Guestify you are able to measure nearly everything what is important to you. Benchmark your food, the drinks, overall atmosphere, your staff, the cleanliness in order not only to get feedback but also to compare it over the time.'); ?></p>
        </td>
    </tr>
</table>


<div style="line-height: 150%;">
    <p style="text-align: center; font-size: 36px;"><?php echo __('3 months', true); ?>, 100% <?php echo __('FREE!'); ?> <br /><small style="font-size: 12px;"><strong><u><?php echo __('Offer is limited!', true); ?></u></strong> <?php echo __('No contract. No risk. No credit card required.', true); ?></small></p>
    <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
        <strong><?php echo __('Account valid for host:', true); ?></strong>
    </p>
    <p style="font-size: 18px; margin: 0px 0px 10px 0; text-align: center;">
        <?php if(!empty($user['Account']['Host'])) { ?>
            <?php foreach($user['Account']['Host'] as $host) { ?>
                <?php echo $host['name']; ?>
            <?php } ?>
        <?php } ?>
    </p>
    <p>&nbsp; </p>

    <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
        <?php echo __('Please use the following link to activate your account and set your password', true); ?>
    </p>
    <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
        <?php echo $this->Tracker->link(__('Activate your free account now', true), Configure::read('NON_SSL_HOST').'/activate/'.$user['User']['activation_hash'], array('style' => 'background-color: #059ec7; color: #fff; font-size: 20px; padding: 20px; margin: 10px; display: inline-block; text-decoration: none; '));?>
    </p>

    <h3 style="text-align: center; color: #059ec7;"><?php echo __('Need more information?', true); ?></h3>
    <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
        <?php echo __('In less then 5 minutes you can offer your guests a direct and easy way to rate your restaurant, bar or cafe. Via QR-Code or direct link over their smartphone your guest can access your individual score sheet to rate your food, atmosphere or service.', true); ?>
        <?php /*
        <a href="https://guestify.net/#explore" style="color: #059ec7;"><?php echo __('Have a look at our important features', true); ?></a>.
        */ ?>
        <?php echo $this->Tracker->link(__('Have a look at our important features', true), 'http://guestify.net/#explore', array('style' => 'color: #059ec7;')); ?>
    </p>
    <p>&nbsp;</p>

    <h3 style="text-align: center; color: #059ec7;"><?php echo __('You might want to chat?', true); ?></h3>
    <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
        <?php echo __('My name is Jean and I will be happy to help you.', true); ?><br /> <?php echo __('Please let me know if you have any questions or concerns about our service.', true); ?>
    </p>
    <p style="font-size: 16px; margin: 0px 0px 10px 0; text-align: center;">+49 (0)221 933 188 010</p>
    <p>&nbsp;</p>

    <p style="font-size: 16px; margin: 0px 0px 10px 0; text-align: center;">
        <?php echo __('Thank you', true); ?>
    </p>
    <p style="font-size: 14px; margin: 0px 0px 10px 0; text-align: center;">
        <?php echo __('With best regards', true); ?>, <?php echo __('your Guestify Team', true); ?>
    </p>
</div>
