<?php
    $this->set('title_for_layout', __('Polls - List of upgrades', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('Polls', true), array('action' => 'adminIndex'));
    $this->Html->addCrumb(__('Upgrades', true));

    #echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">
    <h2><?php echo __('Upgrades');?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <small><i>* <?php echo __('All dates/times in UTC', true); ?></i></small>
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id');?></th>
                        <th><?php echo $this->Paginator->sort('Poll.title', __('Poll', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('valid_from', __('Begin', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('valid_until', __('End', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('Account.company_name', __('Account', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('Host.name', __('Host', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th><?php echo __('Status', true); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($upgrades as $upgrade) { ?>
                        <tr>
                            <td>
                                <?php echo $upgrade['Upgrade']['id']; ?>
                            </td>
                            <td>
                                <?php echo $this->Html->link($upgrade['Poll']['title'], array('action' => 'adminSettings', $upgrade['Poll']['id'])); ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $upgrade['Upgrade']['valid_from']); ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $upgrade['Upgrade']['valid_until']); ?>
                            </td>
                            <td>
                                <?php echo $this->Html->link($upgrade['Account']['company_name'].' ('.$upgrade['Account']['id'].')', array('controller' => 'accounts', 'action' => 'adminView', $upgrade['Account']['id'])); ?>
                            </td>
                            <td>
                                <?php echo $this->Html->link($upgrade['Host']['name'].' ('.$upgrade['Host']['id'].')', array('controller' => 'hosts', 'action' => 'adminView', $upgrade['Host']['id'])); ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $upgrade['Upgrade']['created']); ?>
                            </td>
                            <td>
                                <?php if(strtotime(date('Y-m-d H:i:s')) < strtotime($upgrade['Upgrade']['valid_until'])) { ?>
                                    <span class="label label-success"><?php echo __('active', true); ?></span>
                                <?php } else { ?>
                                    <span class="label label-info"><?php echo __('expired', true); ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($upgrades)) { ?>
                        <tr>
                            <td colspan="8"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
            <?php echo $this->element('counting_paginator'); ?>
        </div>
    </div>
</div>
