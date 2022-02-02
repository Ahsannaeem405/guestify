<?php $media_host = Configure::read('image_path'); ?>

<table cellpadding="0" cellspacing="0" width="460">
	<tr>
		<td valign="top">
			<h2 style="font-size: 18px; margin: 0px 0px 10px 0;"><?php  echo __('Status report from cronjob:'); ?></h2>
            <h2 style="font-size: 18px; margin: 0px 0px 10px 0;"><?php  echo $job; ?></h2>
			<h3 style="font-size: 14px; margin: 0px 0px 5px 0;">
				<?php echo __('Dear admins', true).','; ?>
			</h3>
		</td>
	</tr>
</table>
<p style="font-size: 12px; margin: 0 0 5px 0;">
    <?php echo __('this is a status update for an executed cron.', true); ?><br />
    <?php echo __('The cron was executed on', true).' '.'<strong>'.$date.'</strong>'; ?>
</p>

<p style="font-size: 12px; margin: 0 0 5px 0;">
    <?php echo __('Amount of emails I sent throughout the cron: ', true); ?> <strong><?php echo $count; ?></strong>
</p>

<p style="font-size: 12px; margin: 0 0 5px 0;">
    <?php
        if(!empty($errors)) {
            foreach($errors as $error) {
                echo __('I could not send emails to the following addresses: ', true).'<br />';
                echo '<strong>'.$error['email'].'</strong>';
            }
        }
    ?>
</p>

<p style="font-size: 12px; margin: 0 0 5px 0;">
    <?php echo __('See you soon!', true); ?>
</p>
