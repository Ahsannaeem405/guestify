<div class="clearfix text-center">
    <h1><span class="label label-<?php echo $statuses_labels[$tracker['Tracker']['status']]; ?>"><?php echo $statuses[$tracker['Tracker']['status']]; ?></span></h1>
    <h4><span class="label label-info"><?php echo $tracker['Tracker']['open_count']; ?>x <?php echo __('opened', true); ?></span></h4>
</div>

<dl>
    <dt><?php echo __('Email sent at', true); ?></dt>
    <dd>
        <?php echo $this->Time->format($formats['datetime'], $tracker['Tracker']['created']); ?> UTC
        &nbsp;
    </dd>

    <?php if(!empty($tracker['Tracker']['first_opened'])) { ?>
        <dt><?php echo __('Opened at', true); ?></dt>
        <dd>
            <?php echo $this->Time->format($formats['datetime'], $tracker['Tracker']['first_opened']); ?> UTC
        </dd>

        <dt><?php echo __('Time to open', true); ?></dt>
        <dd>
            <?php echo $this->Tracker->getNiceDuration($tracker['Tracker']['created'], $tracker['Tracker']['first_opened']); ?>
        </dd>
    <?php } ?>

    <?php if(!empty($tracker['Tracker']['user_agent'])) { ?>
        <dt><?php echo __('User agent', true); ?></dt>
        <dd>
            <?php echo $tracker['Tracker']['user_agent']; ?>
        </dd>
        <dt><?php echo __('IP', true); ?></dt>
        <dd>
            <?php echo $tracker['Tracker']['ip']; ?>
        </dd>
    <?php } ?>
</dl> 
