<?php
    $this->set('title_for_layout', __('API Accounts', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('API Accounts', true));
?>

<div class="clearfix">
    <div class="btn-toolbar pull-right clearfix">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Add account', true), array('action' => 'adminAdd'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
    </div>
    <h2><?php echo __('API Accounts'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id');?></th>
                        <th><?php echo $this->Paginator->sort('company_name', __('Company', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($api_accounts as $api_account) { ?>
                        <tr>
                            <td>
                                <?php echo $api_account['ApiAccount']['id']; ?>
                            </td>
                            <td>
                                <?php echo $api_account['ApiAccount']['company_name']; ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $api_account['ApiAccount']['created']); ?>
                            </td>
                            <td class="">
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $api_account['ApiAccount']['id']), array('class' => 'btn btn-sm btn-default'));
                                        echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $api_account['ApiAccount']['id']), array('class' => 'btn btn-sm btn-default'));
                                        echo $this->Html->link(__('Delete', true), array('action' => 'adminDelete', $api_account['ApiAccount']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($api_accounts)) { ?>
                        <tr>
                            <td colspan="4"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
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
<?php echo $this->element('Widgets/standard_delete/main'); ?>
