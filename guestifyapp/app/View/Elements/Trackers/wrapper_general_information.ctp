<dl class="dl-horizontal">
    <dt><?php echo __('Type', true); ?></dt>
    <dd>
        <?php echo $options_tracker_types[$tracker['Tracker']['type']]; ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Email', true); ?></dt>
    <dd>
        <?php echo $tracker['Tracker']['recipient_email']; ?>
        &nbsp;
    </dd>

    <dt><?php echo __('Email ID', true); ?></dt>
    <dd>
        <?php echo $tracker['Tracker']['email_id']; ?>
        &nbsp;
    </dd>

    <dt><?php echo __('Campaign ID', true); ?></dt>
    <dd>
        <?php echo $tracker['Tracker']['campaign_id']; ?>
        &nbsp;
    </dd>

    <dt><?php echo __('Sent from', true); ?></dt>
    <dd>
        <?php echo $tracker['Tracker']['sender_email']; ?>
        &nbsp;
    </dd>
</dl> 
