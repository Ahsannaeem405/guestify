<?php $media_host = Configure::read('CDN.Host'); ?>
<table cellpadding="0" cellspacing="0" width="460">
    <tr>
        <td valign="top">
            <h3 style="font-size: 15px; margin: 0px 0px 10px 0;"><?php echo __('Account setup confirmation', true); ?></h3>
            <?php #echo $this->Html->tag('h2', __('Welcome to guestify!', true), array('style'=>'font-size: 18px; margin: 0px 0px 5px 0;'));?>
        </td>
    </tr>
</table>

<h4><?php echo __('Hallo', true); ?> Max!</h4>
<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <strong>Vielen Dank für deine Registrierung!</strong>
</p>

<h5><?php echo __('Deine Daten', true); ?></h5>
<p>
    <ul>
        <li>Max Mustermann</li>
        <li>Musterweg 1</li>
        <li>0815 Musterstadt</li>
        <li>Wunderland</li>
    </ul>
</p>

<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <?php echo __('Du kannst folgenden Link benutzen, um dich einzuloggen', true); ?>: <?php echo $this->Html->link(__('Login', true), Configure::read('NON_SSL_HOST').'/activate/'.$user['User']['activation_hash']);?>
</p>

<p>
    <?php echo __('Beste Grüße,', true); ?><br />
    <?php echo __('deine Webanwendung', true); ?>
</p>
