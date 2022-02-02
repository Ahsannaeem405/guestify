<?php $media_host = Configure::read('CDN.Host'); ?>
<table cellpadding="0" cellspacing="0" width="460">
    <tr>
        <td valign="top">
            <h3 style="font-size: 15px; margin: 0px 0px 10px 0;"><?php echo __('Password recovery information', true); ?></h3>
            <?php #echo $this->Html->tag('h2', __('Welcome to guestify!', true), array('style'=>'font-size: 18px; margin: 0px 0px 5px 0;'));?>
        </td>
    </tr>
</table>

<h4><?php echo __('Hello', true); ?> <?php echo $user['User']['firstname']; ?>!</h4>
<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <strong><?php echo __('You receive this email because you used the password-recovery function of guestify!', true); ?></strong>
</p>


<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <?php echo __('Please use the following link to setup a new password for your account', true); ?>: 
</p>
<p>
    <?php echo $this->Html->link(__('Reset your password', true), Configure::read('NON_SSL_HOST').'/recovery/'.$user['User']['activation_hash']);?>
</p>

<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <?php echo __('If you have any questions regarding this process, contact us any time!', true); ?>
</p>
<p>
    <?php echo __('With best regards', true); ?><br />
    <?php echo __('Your guestify Team', true); ?>
</p>
