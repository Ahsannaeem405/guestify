<?php
    $this->set('title_for_layout', __('Poll', true).' - '.$poll['Poll']['name']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My Polls', true), array('controller' => 'polls', 'action' => 'index'), array('escape' => false));
    $this->Html->addCrumb($poll['Poll']['name']);

    echo $this->Html->script('vendors/flot/jquery.flot');
    echo $this->Html->script('vendors/flot/jquery.flot.time');
    echo $this->Html->script('vendors/flot/jquery.flot.axislabels');
    echo $this->Html->script('vendors/flot/JUMFlot.min');

    echo $this->Html->script('View/Polls/view', false);
?>


<div class="btn-toolbar pull-right">
    <?php
        echo $this->Html->link(__('Add feedback', true), array('action' => 'addFeedback', $poll['Poll']['id']), array('class' => 'btn btn-info'));
        echo $this->Html->link(__('Export XLS', true), '#', array('class' => 'btn btn-info', 'escape' => false));
        /*
        echo $this->Html->link(__('Edit', true), array('action' => 'edit', $poll['Poll']['id']), array('class' => 'btn btn-default'));
        if($poll['Poll']['status'] == 0) {
            echo $this->Html->link(__('Activate', true), array('action' => 'activate', $poll['Poll']['id']), array('class' => 'btn btn-success standard-activate'));
        } else {
            echo $this->Html->link(__('Deactivate', true), array('action' => 'deactivate', $poll['Poll']['id']), array('class' => 'btn btn-warning standard-deactivate'));
        }
        echo $this->Html->link(__('Delete', true), array('action' => 'delete', $poll['Poll']['id']), array('class' => 'btn btn-danger standard-delete'));
        */
    ?>
</div>

<h2><?php echo $poll['Poll']['name']; ?> #<?php echo $poll['Poll']['id']; ?></h2>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="clearfix">
    <p>
        <?php echo __('Status', true); ?>:
        <?php
            if($poll['Poll']['status'] == 0) {
                echo '<span class="label label-warning">'.$statuses[$poll['Poll']['status']].'</span>';
            } elseif ($poll['Poll']['status'] == 1) {
                echo '<span class="label label-success">'.$statuses[$poll['Poll']['status']].'</span>';
            }
        ?>
    </p>
</div>

<div class="row">
    <div class="col-xs-5"></div>

    <div class="col-xs-7">
        <div class="pull-right">
            <?php echo $this->element('Polls/navigation_main', array('poll_id' => $poll['Poll']['id'], 'active_period' => 'last_30')); ?>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <?php $count = 0; ?>
        <?php foreach($poll['Groups'] as $key => $group) { ?>
            <?php
                $count++;
                #if($count > 1) { continue; }
            ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3><?php echo $group['Group']['name']; ?></h3>

                    <?php #echo $this->element('Polls/group', array('group' => $group, 'group_id' => $group['Group']['id'])); ?>

                    <?php
                        echo $this->element('Polls/chart_group', array(
                            'questions' => $group['Questions'],
                            'group_id' => $group['Group']['id'],
                            'period' => 'month',
                            'option' => 'last_30'
                        ));
                    ?>
                </div>
            </div>
        <?php } ?>

    </div>
</div>



<div class="panel panel-default">
    <div class="panel-body">
        <?php echo $this->element('Polls/client_table'); ?>
    </div>
</div>

<p><?php echo __('Created', true); ?>: <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['created']); ?> / <?php echo __('Last modified', true); ?>: <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['modified']); ?></p>






<?php #echo $this->element('Widgets/standard_activate/main'); ?>
<?php #echo $this->element('Widgets/standard_deactivate/main'); ?>
<?php #echo $this->element('Widgets/standard_delete/main'); ?>
