<?php $media_host = Configure::read('CDN.Host'); ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td valign="top" style="text-align: left; line-height: 150%;">
            <?php echo $this->Html->tag('h2', __('Hello Admins', true), array('style'=>'font-size: 18px; margin: 0px 0px 5px 0; text-align: left; color: #059ec7;' )); ?>
            <p style="font-size: 14px; margin: 0px 0px 5px 0; "><strong><?php echo __('A new user has just signed up for guestify!', true); ?> </strong></p>
        </td>
    </tr>
</table>


<div style="line-height: 150%;">
    <p style="font-size: 16px; margin: 0px 0px 5px 0;">    
        <?php echo $this->Html->link($genders[$user['User']['gender']] . ' ' . $user['User']['firstname'] . ' ' . $user['User']['lastname'], '/users/adminView/' . $user['User']['id'], array('')); ?>
    </p>
</div>

<h3 style="font-size: 18px; margin: 0px 0px 10px 0; text-align: left; color: #059ec7; "><?php echo __('See you soon!', true); ?></h3>