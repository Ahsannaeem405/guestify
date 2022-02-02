<?php
    $this->set('title_for_layout', __('Invoice', true).' #'.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']);

    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My Invoices', true), array('action' => 'my_invoices'), array('escape' => false));
    $this->Html->addCrumb(__('Invoice', true).' #'.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']);
?>

<div class="btn-toolbar pull-right clearfix">
    <?php echo $this->Html->link('<span class="glyphicon glyphicon-save"></span> '. __('Download', true), array('action' => 'download', $invoice['Invoice']['id']), array('class' => 'btn btn-info', 'escape' => false)); ?>
</div>

<h2><?php echo __('Invoice', true).' #'.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>
                            <p><?php echo h($genders[$invoice['Invoice']['gender']] . ' ' . $invoice['Invoice']['firstname'] . ' ' . $invoice['Invoice']['lastname']); ?><br />
                                <?php echo h($invoice['Invoice']['address']); ?> <br />
                                <?php echo h($invoice['Invoice']['zipcode']) . ' ' . h($invoice['Invoice']['city']); ?><br />
                                <?php echo h($invoice['Invoice']['country_name']); ?>
                            </p>
                        </td>
                        <td >
                            <div class="pull-right">
                                <p><?php echo __('Service delivered by', true); ?> <br />
                                    <?php echo 'Guestify'; ?> <br />
                                    <?php /*echo __('VAT ID', true) .': XXXXX';*/ ?><br />
                                </p>
                                <p><strong><?php echo __('Reference', true); ?></strong><br />
                                    <?php echo __('Customer Number', true).': ' . $invoice['Host']['id']; ?> <br />
                                    <?php echo __('Invoice number', true).': ' . Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?> <br />
                                    <?php echo __('Your VAT ID', true).': ' . h($invoice['Invoice']['ustid']); ?>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>

                <h2><?php echo __('Invoice', true); ?></h2>
                <p><?php echo $this->Time->format($formats['date'], $invoice['Invoice']['created']); ?> </p>

                <p><?php echo __('Invoice number', true).': '.h(Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']); ?> </p>
                <p><?php echo __('Customer number', true).': '.$invoice['Invoice']['account_id']; ?> </p>

                <table class="table table-striped" cellpadding="5" cellspacing="0" border="0">
                    <tr class="head">
                        <td><span><?php echo __('Units', true); ?></span></td>
                        <td><span><?php echo __('Article', true); ?></span></td>
                        <td><span><?php echo __('Price',true); ?></span></td>
                    </tr>

                    <tr class="positions">
                        <td class="units" valign="top"><span>1 x</span></td>
                        <td valign="top">
                            <span>
                                <strong><?php echo $invoice['Invoice']['description']; ?></strong> <br />
                                <?php echo __('Host', true); ?>: <?php echo h($invoice['Host']['name']); ?>, <?php echo __('Poll', true); ?>: <?php echo h($invoice['Poll']['title']); ?><br />
                                <?php echo __('Period of service', true).': '. $this->Time->format($formats['datetime'], $invoice['Invoice']['valid_from']).' - '.$this->Time->format($formats['datetime'], $invoice['Invoice']['valid_until']); ?><br />
                            </span>
                        </td>
                        <td>
                            <span><?php echo $this->Number->format($invoice['Invoice']['price_netto'], $formats['currency']); ?></span>
                        </td>
                    </tr>

                    <?php if(isset($invoice['Invoice']['promotioncode']) && !empty($invoice['Invoice']['promotioncode'])) { ?>
                        <tr class="positions">
                            <td class="units" valign="top"><span>1 x</span></td>
                            <td valign="top">
                                <span>
                                    <strong><?php echo __('Promotioncode', true); ?></strong> <br />
                                    <?php echo h($invoice['Invoice']['promotioncode']); ?> (<?php echo round($invoice['Invoice']['promotioncode_deduction_percent'], 0); ?>%)
                                </span>
                            </td>
                            <td>
                                <span><?php echo '&ndash;'.' '.$this->Number->format($invoice['Invoice']['promotioncode_deduction_netto'], $currency); ?></span>
                            </td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <span>
                                <?php echo __('Net total', true); ?><br />
                            </span>
                        </td>
                        <td>
                            <span>
                                <?php echo $this->Number->format($invoice['Invoice']['final_netto'], $formats['currency']); ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <span>
                                <?php
                                    if($invoice['Invoice']['country_id'] == 1) {
                                        echo round($invoice['Invoice']['price_vat_percent'], 2).'% '. __('VAT', true);
                                    } else {
                                        echo __('VAT', true);
                                    }
                                ?>
                            </span>
                        </td>
                        <td>
                            <span>
                                <?php echo $this->Number->format($invoice['Invoice']['final_vat'], $formats['currency']); ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td><span><?php echo __('Total', true); ?></span></td>
                        <td><strong><?php echo $this->Number->format($invoice['Invoice']['final_total'], $formats['currency']); ?> </strong></td>
                    </tr>

                </table>

                <br/>

                <?php /* UNCOMMENT THIS LINE IF YOU NEED TO ADD INTERNATIONAL VAT REGULATIONS. 
                <?php if($invoice['Invoice']['country_id'] != 1) { ?>
                    <p class="text regular align-left"><?php echo __('Reverse charges. The tax free inner-community-based service delivery - according to § 4 No. 1b and 6a UStG. Transfer of tax debt under § 13b UStG based on German law.', true); ?></p>
                <?php } ?>
                */ ?>

                <br/>

                <?php if(($invoice['Invoice']['payment_type'] == 1) && isset($invoice['PaymentPP']) && !empty($invoice['PaymentPP']['id'])) { ?>
                    <h4><?php echo __('Payment information', true); ?></h4>
                    <p><?php echo __('Payment method', true).': PayPal'; ?> <br />
                        <?php echo __('Payer ID', true).': ' . $invoice['PaymentPP']['PAYERID']; ?> <br />
                        <?php echo __('Transaction ID', true).': ' . $invoice['PaymentPP']['PAYMENTINFO_0_TRANSACTIONID']; ?> <br />
                        <?php echo __('Token', true).': ' . $invoice['PaymentPP']['TOKEN']; ?> <br />
                        <?php echo __('Email', true).': ' . $invoice['PaymentPP']['EMAIL']; ?> <br />
                        <?php echo __('Firstname', true).': ' . $invoice['PaymentPP']['FIRSTNAME']; ?> <br />
                        <?php echo __('Lastname', true).': ' . $invoice['PaymentPP']['LASTNAME']; ?> <br />
                        <?php echo __('Transaction type', true).': ' . ucfirst($invoice['PaymentPP']['PAYMENTINFO_0_TRANSACTIONTYPE']); ?> <br />
                        <?php echo __('Payment type', true).': ' . ucfirst($invoice['PaymentPP']['PAYMENTINFO_0_PAYMENTTYPE']); ?> <br />
                        <?php echo __('Timestamp', true).': ' . $invoice['PaymentPP']['TIMESTAMP']; ?>
                    </p>
                <?php } else { ?>
                    <p><?php echo __('Payable within 7 days without deduction. Please add the invoice number', true); ?> <strong><?php echo Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?></strong> <?php echo __('to your bank-transfer.', true); ?></p>
                    <p><?php echo __('Please transfer the amount to the following bank account', true); ?>:</p>
                    <p>YOURBANK<br />
                    <?php echo __('Recipient', true); ?>: XXXXXXX<br />
                    ACCOUNT: XXXXXXXX<br />
                    BIC: XXXXXXXX<br />
                    <?php echo __('Purpose', true); ?>: <?php echo Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-xs-5">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo __('Invoice payment status'); ?></strong></div>
            <div class="panel-body">
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
                <p class="invoice-status alert alert-<?php echo $class; ?>"><?php echo $statuses[$invoice['Invoice']['status']]; ?></p>
            </div>
        </div>
    </div>
</div>
