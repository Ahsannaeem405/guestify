<?php
    $this->set('title_for_layout', __('Accounts', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('Accounts', true));

    #echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">
    <div class="btn-toolbar pull-right clearfix">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Add account', true), array('action' => 'adminAdd'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
    </div>
    <h2><?php echo __('Accounts');?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id');?></th>
                        <th><?php echo $this->Paginator->sort('name', __('Company', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('zipcode', __('Zipcode', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('country_id', __('Country', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('count_hosts', __('Hosts', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('count_polls', __('Polls', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('count_users', __('Users', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($accounts as $account) { ?>
                        <tr>
                            <td>
                                <?php echo $account['Account']['id']; ?>
                            </td>
                            <td>
                                <?php echo $account['Account']['company_name']; ?>
                            </td>
                            <td>
                                <?php echo $account['Account']['zipcode']; ?>
                            </td>
                            <td>
                                <?php echo $account['Account']['country_id']; ?></p>
                            </td>
                            <td>
                                <?php echo $account['Account']['count_hosts']; ?>
                            </td>
                            <td>
                                <?php echo $account['Account']['count_polls']; ?>
                            </td>
                            <td>
                                <?php echo $account['Account']['count_users']; ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $account['Account']['created']); ?>
                            </td>
                            <td class="">
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $account['Account']['id']), array('class' => 'btn btn-sm btn-default'));
                                        #echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $account['Account']['id']), array('class' => 'btn btn-sm btn-default'));
                                        #echo $this->Html->link(__('Delete', true), array('action' => 'delete', $account['Account']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($accounts)) { ?>
                        <tr>
                            <td colspan="9"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
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
