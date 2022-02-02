<?php
    $this->set('title_for_layout', __('Drafts', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('System', true), array('controller' => 'pages', 'action' => 'display', 'system'));
    $this->Html->addCrumb(__('Drafts', true));

    #echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">

    <div class="btn-toolbar pull-right clearfix">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Add draft', true), array('action' => 'admin_add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
    </div>

    <h2><?php echo __('Poll Drafts');?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id');?></th>
                        <th><?php echo $this->Paginator->sort('title', __('Name', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('poll_count', __('Poll count', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Last modified', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($drafts as $draft) { ?>
                        <tr>
                            <td>
                                <?php echo $draft['Draft']['id']; ?>
                            </td>
                            <td>
                                <?php echo $draft['Draft']['name_eng']; ?>
                            </td>
                            <td>
                                <?php if($draft['Draft']['status'] == 1) { ?>
                                    <span class="label label-success"><?php echo $statuses[$draft['Draft']['status']]; ?></span>
                                <?php } elseif($draft['Draft']['status'] == 0) { ?>
                                    <span class="label label-warning"><?php echo $statuses[$draft['Draft']['status']]; ?></span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php echo $draft['Draft']['poll_count']; ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $draft['Draft']['modified']); ?>
                            </td>
                            <td class="">
                                <div class="btn-group pull-right">
                                    <?php echo $this->Html->link(__('View', true), array('action' => 'admin_view', $draft['Draft']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                                    <?php echo $this->Html->link(__('Delete', true), array('action' => 'admin_delete', $draft['Draft']['id']), array('class' => 'btn btn-sm btn-danger standard-delete')); ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($drafts)) { ?>
                        <tr>
                            <td colspan="6"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
            <?php echo $this->element('counting_paginator'); ?>
        </div>
    </div>
</div>


<?php echo $this->element('Widgets/standard_activate/main'); ?>
<?php echo $this->element('Widgets/standard_deactivate/main'); ?>
<?php echo $this->element('Widgets/standard_delete/main'); ?>