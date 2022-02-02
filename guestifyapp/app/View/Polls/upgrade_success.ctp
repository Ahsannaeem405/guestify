<?php
    $this->set('title_for_layout', __('Upgrade successful!', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My Polls', true), array('action' => 'index'), array('escape' => false));
    $this->Html->addCrumb($data['Poll']['title'], array('action' => 'showLast30', $data['Poll']['id']), array('escape' => false));
    $this->Html->addCrumb(__('Upgrade successful!', true));

    echo $this->Html->script('View/Polls/upgrade', false);
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Back to poll', true), array('action' => 'settings', $data['Poll']['id']), array('class' => 'btn btn-info')); ?>
</div>

<h2><?php echo __('Upgrade successful', true); ?> - <?php echo $data['Poll']['title']; ?> </h2>

<div class="row">
    <div class="col-xs-12 col-md-3 col-lg-3"></div>
    <div class="col-xs-12 col-md-6 col-lg-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h4><span class="glyphicon glyphicon-ok-sign"></span> <?php echo __('Well done!', true); ?></h4>
            </div>
            <div class="panel-body">
                <p class="lead text-center">
                    <?php echo __('Thank you for upgrading to guestify PRO!', true); ?>
                </p>
                <p class="text-center"><strong><?php echo $data['Invoice']['description']; ?></strong></p>
                <p class="text-center"><?php echo __('Valid from', true);?> <strong><?php echo $this->Time->format($formats['datetime'], $data['Invoice']['valid_from']); ?></strong> <?php echo __('to', true); ?> <strong><?php echo $this->Time->format($formats['datetime'], $data['Invoice']['valid_until']); ?></strong></p>
                <p><?php echo __('You have unlocked a some very nice features like', true); ?>:</p>
                <ul class="list-unstyled">
                    <li><span class="glyphicon glyphicon-ok"></span> <?php echo __('Unlimited ratings', true);?></li>
                    <li><span class="glyphicon glyphicon-ok"></span> <?php echo __('Access to all period views', true);?></li>
                    <li><span class="glyphicon glyphicon-ok"></span> <?php echo __('Export of your collected ratings as Excel sheet', true);?></li>
                    <li><span class="glyphicon glyphicon-ok"></span> <?php echo __('Autmatic weekly reports with valuable statistics', true);?></li>
                    <li><span class="glyphicon glyphicon-ok"></span> <?php echo __('API Support', true); ?> </li>
                    <li><span class="glyphicon glyphicon-ok"></span> <?php echo __('Personal Support', true); ?> </li>
                </ul>
                <hr />
                <h4><?php echo __('Invoice', true); ?></h4>
                <p><?php echo __('Invoice number', true);?>: <?php echo Configure::read('Invoice.number_prefix').$data['Invoice']['invoice_number']; ?></p>
                <p><?php echo __('Total', true);?>: <?php echo $this->Number->format($data['Invoice']['final_total'], $formats['currency']); ?></p>
                <p>
                    <?php echo __('Payment method', true);?>:
                    <?php if($data['Invoice']['payment_type'] == 1) { ?>
                        <?php echo 'Paypal'; ?>
                    <?php } elseif($data['Invoice']['payment_type'] == 2) { ?>
                        <?php echo 'On Account'; ?>
                    <?php } ?>
                </p>
                <p>
                    <?php echo __('Status', true);?>:

                    <?php
                        switch($data['Invoice']['status']) {

                            case 1:
                                $class = 'warning';
                                $label = __('Pending', true);
                                break;
                            case 2:
                                $class = 'success';
                                $label = __('Paid', true);
                                break;

                        }
                    ?>
                    <span class="label label-<?php echo $class; ?>"><?php echo $label; ?></span>
                </p>
                <small class="text-warning"><span class="glyphicon glyphicon-info-sign"></span> <?php echo __('If your invoice is pending, please settle the invoice within the next seven days', true); ?></small>
                <hr />
                <h4><?php echo __('What next?', true); ?></h4>
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-stats"></span> '.__('Statistics', true), array('action' => 'showLast30', $data['Poll']['id']), array('class' => 'btn btn-info btn-lg btn-block', 'escape' => false)); ?><br />
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-cog"></span> '.__('Settings', true), array('action' => 'settings', $data['Poll']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?>
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-euro"></span> '.__('Invoices', true), array('controller' => 'invoices', 'action' => 'view', $data['Invoice']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-3"></div>
</div>

<?php /*
<div class="row">
    <div class="col-xs-7">
        <div class="well">
            <?php pr($data); ?>
        </div>
    </div>

</div>
*/ ?>
