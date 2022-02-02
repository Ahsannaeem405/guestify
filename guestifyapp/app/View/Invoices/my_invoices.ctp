<?php
    $this->set('title_for_layout', __('My Invoices', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('My Invoices', true));

    #echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">

    <h2><?php echo __('My Invoices'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="clearfix text-right">
                <p class="lead">
                    <?php if($amount_pending > 0) { ?>
                        <small><?php echo __('Pending', true); ?>:</small> <span class="text-warning"><?php echo $this->Number->format($amount_pending, $formats['currency']); ?></span>
                    <?php } else { ?>
                        <small><?php echo __('Pending', true); ?>:</small> <span class="text-success">€0.00</span>
                    <?php } ?>
                </p>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id'); ?></th>
                        <th><?php echo $this->Paginator->sort('invoice_number', __('Invoice Nr', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('Poll.title', __('Poll', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('payment_type', __('Type', true)); ?></th>
                        <th><?php echo __('Amount', true); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status', true)); ?></th></th>
                        <th><?php echo $this->Paginator->sort('Host.name', __('Host', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('valid_until', __('Valid until', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($invoices as $invoice) { ?>
                        <tr>
                            <td>
                                <?php echo $this->Html->link($invoice['Invoice']['id'], array('action' => 'view', $invoice['Invoice']['id'])); ?>
                            </td>
                            <td>
                                <?php echo $this->Html->link(Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number'], array('action' => 'view', $invoice['Invoice']['id'])); ?>
                            </td>
                            <td>
                                <?php echo $this->Html->link($invoice['Poll']['title'], array('controller' => 'polls', 'action' => 'showLast30', $invoice['Invoice']['poll_id'])); ?>
                            </td>
                            <td>
                                <?php if($invoice['Invoice']['payment_type'] == 1) { ?>
                                    <?php echo 'Paypal'; ?>
                                <?php } elseif($invoice['Invoice']['payment_type'] == 2) { ?>
                                    <?php echo 'On Account'; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php echo $this->Number->format($invoice['Invoice']['final_total'], $formats['currency']); ?>
                            </td>
                            <td>
                                <?php
                                    switch($invoice['Invoice']['status']) {
                                        case 0:
                                            $class = 'default';
                                            break;
                                        case 1:
                                            $class = 'warning';
                                            break;
                                        case 2:
                                            $class = 'success';
                                            break;
                                        case 3:
                                        case 4:
                                            $class = 'danger';
                                            break;
                                        case 5:
                                            $class = 'info';
                                            break;
                                    }
                                ?>
                                <span class="label label-<?php echo $class; ?>"><?php echo $statuses[$invoice['Invoice']['status']]; ?></span>
                            </td>
                            <td>
                                <?php echo $this->Html->link($hosts[$invoice['Invoice']['host_id']], array('controller' => 'hosts', 'action' => 'view', $invoice['Invoice']['host_id'])); ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $invoice['Invoice']['valid_until']); ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $invoice['Invoice']['created']); ?>
                            </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <?php echo $this->Html->link(__('View', true), array('action' => 'view', $invoice['Invoice']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-save"></span> '.__('Download', true), array('action' => 'download', $invoice['Invoice']['id']), array('class' => 'btn btn-sm btn-default', 'escape' => false)); ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($invoices)) { ?>
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
