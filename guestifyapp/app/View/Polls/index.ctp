<?php
    $this->set('title_for_layout', __('Polls', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('My Polls', true));

    echo $this->Html->script('View/Polls/index', false);
?>

<div class="clearfix">

    <div class="btn-toolbar pull-right clearfix">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Add poll', true), array('action' => 'add'), array('class' => 'add-poll btn btn-primary', 'escape' => false)); ?>
    </div>

    <h2><?php echo __('Polls');?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id');?></th>
                        <th width="30%"><?php echo $this->Paginator->sort('title', __('Title', true)); ?>/ <?php echo $this->Paginator->sort('Host.name', __('Host', true)); ?></th>
                        <th><?php echo __('Type', true); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('count_views', __('Views', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('ratings_received', __('Ratings/Limit', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th></th>
                        <th><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($polls as $poll) { ?>
                        <tr>
                            <td>
                                <p class="lead"><?php echo $poll['Poll']['id']; ?></p>
                            </td>
                            <td>
                                <strong class="lead"><?php echo $poll['Poll']['title']; ?></strong><br />
                                <p><?php echo __('PIN', true); ?>: <?php echo $poll['Poll']['code']; ?></p>
                                <small><span class="glyphicon glyphicon-home"></span> <?php echo $poll['Host']['name']; ?></small>
                            </td>
                            <td>
                                <?php if($poll['Poll']['type'] == 'free') { ?>
                                    <span class="label label-default"><?php echo __('Free', true); ?></span>
                                <?php } else { ?>
                                    <span class="label label-upgrade"><?php echo __('PRO', true); ?> <span class="glyphicon glyphicon-certificate"></span></span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                    if($poll['Poll']['status'] == 0) {
                                        echo '<span class="label label-warning">'.$statuses[$poll['Poll']['status']].'</span>';
                                    } elseif ($poll['Poll']['status'] == 1) {
                                        echo '<span class="label label-success">'.$statuses[$poll['Poll']['status']].'</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <p class="lead"><?php echo $poll['Poll']['count_views']; ?></p>
                            </td>
                            <td>
                                <strong class="lead"><?php echo $poll['Poll']['ratings_received']; ?> /
                                    <?php if($poll['Poll']['type'] == 'free') { ?>
                                        <?php echo $poll['Poll']['limit']; ?>
                                    <?php } elseif($poll['Poll']['type'] == 'unlimited') { ?>
                                        <?php echo __('No limit', true); ?>
                                    <?php } ?>
                                </strong><br />
                                <small><?php echo __('Remaining', true); ?>:
                                    <?php if($poll['Poll']['type'] == 'free') { ?>
                                        <?php echo $poll['Poll']['limit'] - $poll['Poll']['ratings_received']; ?>
                                    <?php } elseif($poll['Poll']['type'] == 'unlimited') { ?>
                                        <?php echo '-'; ?>
                                    <?php } ?>
                                </small>
                            </td>

                            <td>
                                <p class="lead"><?php echo $this->Time->format($formats['date'], $poll['Poll']['created']); ?></p>
                            </td>

                            <td>
                                <div class="btn-group-vertical">
                                    <?php
                                        echo $this->Html->link('<span class="glyphicon glyphicon-cog"></span> '.__('Settings', true), array('action' => 'settings', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-default', 'escape' => false));
                                        if($poll['Poll']['type'] == 'unlimited') {
                                            echo $this->Html->link('<span class="glyphicon glyphicon-certificate"></span> '.__('Extend', true), array('action' => 'upgrade', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-upgrade', 'escape' => false));
                                        } else {
                                            echo $this->Html->link('<span class="glyphicon glyphicon-certificate"></span> '.__('Upgrade', true), array('action' => 'upgrade', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-upgrade', 'escape' => false));
                                        }
                                        /*
                                        echo $this->Html->link(__('Edit', true), array('action' => 'edit', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-default'));

                                        if($poll['Poll']['status'] == 0) {
                                            echo $this->Html->link(__('Activate', true), array('action' => 'activate', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-success standard-activate'));
                                        } else {
                                            echo $this->Html->link(__('Deactivate', true), array('action' => 'deactivate', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-warning standard-deactivate'));
                                        }
                                        echo $this->Html->link(__('Delete', true), array('action' => 'delete', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                        */
                                    ?>
                                </div>
                            </td>
                            <td>
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-stats"></span> <br />'. __('Statistics', true), array('action' => 'showLast30', $poll['Poll']['id']), array('class' => 'btn btn-md btn-default', 'escape' => false)); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($polls)) { ?>
                        <tr>
                            <td colspan="10"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
            <?php echo $this->element('counting_paginator'); ?>
        </div>
    </div>
</div>

<?php #echo $this->element('Widgets/standard_activate/main'); ?>
<?php #echo $this->element('Widgets/standard_deactivate/main'); ?>
<?php #echo $this->element('Widgets/standard_delete/main'); ?>


<!-- add poll modal -->
<div id="modal-poll-add" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Add poll', true); ?></h3>
            </div>

            <div class="modal-body">
                <?php
                    echo $this->Form->input('Poll.host_id', array(
                        'label' => __('Host', true),
                        'empty' => __('Select a host...', true),
                        'type' => 'select',
                        'options' => $options_hosts,
                        'id' => 'polls-host_id',
                        'class' => 'form-control',
                        'div' => array('class' => 'form-group'),
                        'after' => '<div class="error-message">'.__('Please select a standard locale for the poll!', true).'</div>',
                        'escape' => false
                    ));
                ?>

                <div class="row">
                    <div class="col-xs-8">
                        <?php
                            echo $this->Form->input('Poll.title', array(
                                'label' => __('Title', true),
                                'type' => 'text',
                                'id' => 'polls-title',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'after' => '<div class="error-message">'.__('Please enter a title for the poll!', true).'</div>',
                                'escape' => false
                            ));
                        ?>
                    </div>
                    <div class="col-xs-4">
                        <?php
                            echo $this->Form->input('Poll.code', array(
                                'label' => __('PIN code', true),
                                'type' => 'text',
                                'id' => 'polls-code',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'after' => '<div class="error-message">'.__('Please enter the pin-code for the poll!', true).'</div>',
                                'escape' => false
                            ));
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <?php
                            echo $this->Form->input('Poll.template_id', array(
                                'label' => __('Template', true),
                                'type' => 'select',
                                'empty' => __('Select poll', true),
                                'options' => $options_templates,
                                'id' => 'polls-template_id',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                        ?>
                    </div>
                    <div class="col-xs-4">
                        <?php
                            echo $this->Form->input('Poll.scale', array(
                                'label' => __('Scale', true),
                                'type' => 'select',
                                'options' => $options_scales,
                                'id' => 'polls-scale',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <?php foreach($templates as $template_id => $template) { ?>
                            <div id="wrapper-template-<?php echo $template_id; ?>" class="wrapper-templates alert alert-info" style="display: none;">
                                <h4><?php echo $template['name'][$this->Session->read('Config.language')]; ?></h4>
                                <?php $group_count = count($template['Groups']); ?>
                                <?php foreach($template['Groups'] as $group_number => $group) { ?>
                                    <?php if($group_count > 1) { ?>
                                        <strong><?php echo $group_number; ?> - <?php echo $group['name'][$this->Session->read('Config.language')]; ?></strong>
                                    <?php } ?>
                                    <ul>
                                        <?php foreach($group['Questions'] as $question_number => $question) { ?>
                                            <li><?php echo $question['question'][$this->Session->read('Config.language')]; ?></li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-poll-add" style="display: none;"/>
                <button class="btn btn-default" id="poll-add-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="poll-add-confirm" type="button"><?php echo __('Add', true); ?></button>
            </div>
        </div>
    </div>
</div>
