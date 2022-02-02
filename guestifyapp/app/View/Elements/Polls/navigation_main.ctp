<?php

    $periods = array('last30', 'day', 'week', 'month', 'year');

    $classes = array();
    foreach($periods as $period) {
        $classes[$period] = '';
        if(isset($active_period) && ($period == $active_period)) {
            $classes[$period] = ' active';
        }
    }
?>

<div class="pull-left">
    <ul class="nav nav-tabs tabs-white" role="tablist">
        <?php #echo $this->Html->link(__('Examine', true), array('action' => '', $group['Group']['id']), array('class' => 'btn btn-info pull-right')); ?>
        <li class="<?php echo $classes['last30']; ?>"><?php echo $this->Html->link(__('Last 30', true), array('action' => 'showLast30', $poll_id), array('class' => '')); ?></li>
        <li class="<?php echo $classes['day']; ?>"><?php echo $this->Html->link(__('Day', true), array('action' => 'showDay', $poll_id), array('class' => '')); ?></li>
        <li class="<?php echo $classes['week']; ?>"><?php echo $this->Html->link(__('Week', true), array('action' => 'showWeek', $poll_id), array('class' => '')); ?></li>
        <li class="<?php echo $classes['month']; ?>"><?php echo $this->Html->link(__('Month', true), array('action' => 'showMonth', $poll_id), array('class' => '')); ?></li>
        <li class="<?php echo $classes['year']; ?>"><?php echo $this->Html->link(__('Year', true), array('action' => 'showYear', $poll_id), array('class' => '')); ?></li>
    </ul>
</div>
