<?php $media_host = Configure::read('CDN.Host'); ?>
<table cellpadding="0" cellspacing="0" width="460">
    <tr>
        <td valign="top">
            <h3 style="font-size: 15px; margin: 0px 0px 10px 0;"><?php echo __('Deploy routine', true); ?></h3>
        </td>
    </tr>
</table>

<h4><?php echo __('Hello admins', true); ?>,</h4>
<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <strong><?php echo __('This is a deploy message!', true); ?></strong>
</p>

<p>
    <h3><?php echo __('Environment', true); ?>: <?php echo strtoupper($env); ?></h3>
</p>

<p>
    <?php echo __('output of the deploy routine', true); ?>:
</p>

<p>
    <?php print_r($output); ?>
</p>

<p>
    <?php echo __('See you!', true); ?>
</p>
