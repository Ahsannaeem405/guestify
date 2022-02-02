<div class="clearfix text-center">
    <h1>
        <?php $email_log['LogsEmail']['notification_type'] = 'Delivery'; ?>
        <?php if($email_log['LogsEmail']['notification_type'] == 'Delivery') { ?>
            <span class="label label-success"><?php echo __('Delivered', true); ?></span>
        <?php } elseif($email_log['LogsEmail']['notification_type'] == 'Delivery') { ?>
            <span class="label label-danger"><?php echo __('Bounce', true); ?></span>
        <?php } elseif($email_log['LogsEmail']['notification_type'] == 'Complaint') { ?>
            <span class="label label-warning"><?php echo __('Bounce', true); ?></span>
        <?php } ?>
    </h1>
</div>

<?php if($email_log['LogsEmail']['notification_type'] == 'Delivery') { ?>
    <?php $data_origin = json_decode($email_log['LogsEmail']['data_origin'], true); ?>
    <?php $mail = $data_origin['Message']['mail']; ?>
    <?php $delivery = $data_origin['Message']['delivery']; ?>
    
    <div class="clearfix">
        <h4><?php echo __('Sending MTA', true); ?></h4>
        <dl>
            <dt><?php echo __('Source', true); ?></dt>
            <dd>
                <?php echo $mail['source']; ?>
            </dd>
            <dt><?php echo __('Message ID', true); ?></dt>
            <dd>
                <?php echo $mail['messageId']; ?>
            </dd>
            <dt><?php echo __('Destination', true); ?></dt>
            <dd>
                <?php echo $mail['destination'][0]; ?>
            </dd>
        </dl>

        <hr />

        <h4><?php echo __('Receiving MTA', true); ?></h4>
        <dl>
            <dt><?php echo __('Timestamp', true); ?></dt>
            <dd>
                <?php echo $delivery['timestamp']; ?>
            </dd>
            <dt><?php echo __('Recipient(s)', true); ?></dt>
            <dd>
                <?php echo $delivery['recipients'][0]; ?>
            </dd>
            <dt><?php echo __('Processing time', true); ?> (ms)</dt>
            <dd>
                <?php echo $delivery['processingTimeMillis']; ?>
            </dd>
            <dt><?php echo __('SMTP-Response', true); ?></dt>
            <dd>
                <?php echo $delivery['smtpResponse']; ?>
            </dd>
            <dt><?php echo __('Reporting MTA', true); ?></dt>
            <dd>
                <?php echo $delivery['reportingMTA']; ?>
            </dd>
        </dl>
    </div>
<?php } ?>

<?php echo $this->Html->link(__('Show original data', true), '#', array('class' => 'toggle-data-origin btn btn-default')); ?>

<div class="clearfix">&nbsp;</div>

<div id="wrapper-data-origin" class="clearfix" style="display: none;">
    <pre>
        <?php print_r(json_decode($email_log['LogsEmail']['data_origin'], true)); ?>
    </pre>
</div> 
