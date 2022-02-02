<?php
    $this->set('title_for_layout', __('Invoices', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('Invoices', true));

    #echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">
    <h2><?php echo __('Invoices'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="clearfix text-right">
                <p class="lead">
                    <small><?php echo __('Revenues', true); ?>:</small> <span class="text-success"><?php echo $this->Number->format($amount_revenues, $formats['currency']); ?></span>&nbsp;
                    <?php if($amount_pending > 0) { ?>
                        <small><?php echo __('Pending', true); ?>:</small> <span class="text-warning"><?php echo $this->Number->format($amount_pending, $formats['currency']); ?></span>
                    <?php } else { ?>
                        <span class="text-success">€0.00</span>
                    <?php } ?>
                </p>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'ID');?></th>
                        <th><?php echo $this->Paginator->sort('invoice_number', __('No', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('company', __('Company', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('Host.name', __('Host', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('Poll.title', __('Poll', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('payment_type', __('Type', true)); ?></th>
                        <th><?php echo __('Amount', true); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($invoices as $invoice) { ?>
                        <tr>
                            <td>
                                <?php echo $invoice['Invoice']['id']; ?>
                            </td>
                            <td>
                                <?php echo Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?>
                            </td>
                            <td>
                                <?php echo $invoice['Invoice']['company']; ?>
                            </td>
                            <td>
                                <?php echo $invoice['Host']['name']; ?>
                            </td>
                            <td>
                                <?php echo $invoice['Poll']['title']; ?>
                            </td>
                            <td>
                                <?php if($invoice['Invoice']['payment_type'] == 1) { ?>
                                    <?php echo 'Paypal'; ?>
                                <?php } elseif($invoice['Invoice']['payment_type'] == 2) { ?>
                                    <?php echo 'On Account'; ?>
                                <?php } ?>
                            </td>
                            <td><?php echo $this->Number->format($invoice['Invoice']['final_total'], $formats['currency']); ?></td>
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
                                <?php echo $this->Time->format($formats['datetime'], $invoice['Invoice']['created']); ?>
                            </td>
                            <td class="">
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $invoice['Invoice']['id']), array('class' => 'btn btn-sm btn-default'));
                                        echo $this->Html->link(__('Download', true), array('controller' => 'invoices', 'action' => 'adminDownload', $invoice['Invoice']['id']), array('class' => 'btn btn-sm btn-default'));
                                        #echo $this->Html->link(__('Delete', true), array('action' => 'delete', $invoice['Invoice']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($invoices)) { ?>
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
