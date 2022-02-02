<?php
    $this->set('title_for_layout', __('Polls', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('Polls', true));

    #echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">

    <div class="btn-toolbar pull-right clearfix">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> '.__('Upgrades', true), array('action' => 'adminUpgrades'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
    </div>

    <h2><?php echo __('Polls');?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id');?></th>
                        <th><?php echo $this->Paginator->sort('title', __('Title', true)); ?></th>
                        <th><?php echo __('Type', true); ?></th>
                        <th><?php echo $this->Paginator->sort('Host.name', __('Host', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('Account.company_name', __('Account', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('code', __('Code', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('count_views', __('Views', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('count_ratings', __('Ratings', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($polls as $poll) { ?>
                        <tr>
                            <td>
                                <?php echo $poll['Poll']['id']; ?>
                            </td>
                            <td>
                                <?php echo $poll['Poll']['title']; ?>
                            </td>
                            <td>
                                <?php if(isset($poll['Invoice'][0]['id'])) { ?>
                                    <span class="glyphicon glyphicon-certificate"></span>
                                <?php } else { ?>
                                    &nbsp;
                                <?php } ?>
                            </td>
                            <td>
                                <?php echo $poll['Host']['name']; ?>
                            </td>
                            <td>
                                <?php echo $poll['Account']['company_name'].' ('.$poll['Account']['id'].')'; ?>
                            </td>
                            <td>
                                <?php echo $poll['Poll']['code']; ?>
                            </td>
                            <td>
                                <?php echo $poll['Poll']['count_views']; ?>
                            </td>
                            <td>
                                <?php echo $poll['Poll']['count_ratings']; ?>
                            </td>
                            <td>
                                <?php if($poll['Poll']['status'] == 1) { ?>
                                    <span class="label label-success"><?php echo $statuses[$poll['Poll']['status']]; ?></span>
                                <?php } elseif($poll['Poll']['status'] == 0) { ?>
                                    <span class="label label-warning"><?php echo $statuses[$poll['Poll']['status']]; ?></span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['created']); ?>
                            </td>
                            <td class="">
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'showLast30', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-default'));
                                        echo $this->Html->link('<span class="glyphicon glyphicon-cog"></span>', array('action' => 'adminSettings', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-default', 'escape' => false));
                                        #echo $this->Html->link(__('Edit', true), array('action' => 'edit', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-default'));
                                        #echo $this->Html->link(__('Delete', true), array('action' => 'delete', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($polls)) { ?>
                        <tr>
                            <td colspan="11"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
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
