<?php $media_host = Configure::read('CDN.Host'); ?>
<table cellpadding="0" cellspacing="0" width="460">
    <tr>
        <td valign="top">
            <h3 style="font-size: 15px; margin: 0px 0px 10px 0;"><?php echo __('Early access signup notification', true); ?></h3>
        </td>
    </tr>
</table>

<h4><?php echo __('Hello admins', true); ?>,</h4>
<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <strong><?php echo __('A user signed up for early access!', true); ?></strong>
</p>

<p>
    <?php echo __('Email-address', true); ?>: <strong><?php echo $email; ?></strong>
</p>


<p>
    <?php echo __('See you!', true); ?>
</p>
