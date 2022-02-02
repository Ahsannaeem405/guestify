<?php
    $this->set('title_for_layout', __('Invoice', true).' #'.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']);

    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Invoices', true), array('action' => 'adminIndex'), array('escape' => false));
    $this->Html->addCrumb(__('Invoice', true).' #'.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']);

    echo $this->Html->script('View/Invoices/admin_view', false);
?>

<div class="btn-toolbar pull-right clearfix">
    <?php
        if($invoice['Invoice']['status'] == 1) {
            echo $this->Html->link(__('Mark as paid', true), '#', array('id' => 'invoice-mark-paid-'.$invoice['Invoice']['id'], 'class' => 'mark-paid btn btn-info'));
        }
        if($invoice['Invoice']['status'] == 2) {
            echo $this->Html->link(__('Mark as unpaid', true), '#', array('id' => 'invoice-mark-unpaid-'.$invoice['Invoice']['id'], 'class' => 'mark-unpaid btn btn-info'));
            echo $this->Html->link(__('Mark as refunded', true), '#', array('id' => 'invoice-mark-refunded-'.$invoice['Invoice']['id'], 'class' => 'mark-refunded btn btn-info'));
        }
        echo $this->Html->link(__('Download (PDF)', true), array('action' => 'adminDownload', $invoice['Invoice']['id']), array('class' => 'btn btn-info'));
    ?>
</div>


<h2><?php echo __('Invoice', true).' #'.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?></h2>

<div class="panel panel-default">
    <div class="panel-body">

        <?php if($invoice['Invoice']['status'] == 1) { ?>
            <div class="clearfix alert alert-danger">
                <strong><?php echo __('Invoice not paid yet!', true); ?></strong>
            </div>
        <?php } ?>

        <table class="table" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td>
                    <p><?php echo h($genders[$invoice['Invoice']['gender']] . ' ' . $invoice['Invoice']['firstname'] . ' ' . $invoice['Invoice']['lastname']); ?><br />
                        <?php echo h($invoice['Invoice']['address']); ?> <br />
                        <?php echo h($invoice['Invoice']['zipcode']) . ' ' . h($invoice['Invoice']['city']); ?><br />
                        <?php echo h($invoice['Invoice']['country_name']); ?>
                    </p>
                </td>
                <td class="pull-right">
                    <p><?php echo __('Service delivered by', true); ?> <br />
                        <?php echo 'Guestify'; ?> <br />
                        <?php /*echo __('VAT ID', true) .': XXXXX';*/ ?><br />
                    </p>
                    <p><strong><?php echo __('Reference', true); ?></strong><br />
                        <?php echo __('Customer Number', true).': ' . $invoice['Host']['id']; ?> <br />
                        <?php echo __('Invoice number', true).': ' . Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?> <br />
                        <?php echo __('Your VAT ID', true).': ' . h($invoice['Invoice']['ustid']); ?>
                    </p>
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

        <div class="clearfix">
            <p class="text regular align-left"><?php echo __('Reverse charges. The tax free inner-community-based service delivery - according to § 4 No. 1b and 6a UStG. Transfer of tax debt under § 13b UStG based on German law.', true); ?></p>
        </div>

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
            ACCOUNT: XXXXXXX<br />
            BIC: XXXXXXX<br />
            <?php echo __('Purpose', true); ?>: <?php echo Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?>
            </p>
        <?php } ?>
    </div>
</div>



<div id="modal-invoice-mark-paid" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Mark invoive as paid', true); ?></h3>
            </div>

            <div class="modal-body">
                <div class="alert alert-info">
                    <?php echo __('Are you sure you want to mark this invoice as paid?', true); ?>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-invoice-mark-paid" style="display: none;"/>
                <button class="btn btn-default" id="invoice-mark-paid-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="invoice-mark-paid-confirm" type="button"><?php echo __('Mark paid', true); ?></button>
            </div>
        </div>
    </div>
</div>


<div id="modal-invoice-mark-unpaid" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Mark invoive as unpaid', true); ?></h3>
            </div>

            <div class="modal-body">
                <div class="alert alert-info">
                    <?php echo __('Are you sure you want to mark this invoice as unpaid?', true); ?>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-invoice-mark-unpaid" style="display: none;"/>
                <button class="btn btn-default" id="invoice-mark-unpaid-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="invoice-mark-unpaid-confirm" type="button"><?php echo __('Mark unpaid', true); ?></button>
            </div>
        </div>
    </div>
</div>


<div id="modal-invoice-mark-refunded" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Mark invoive as refunded', true); ?></h3>
            </div>

            <div class="modal-body">
                <div class="alert alert-info">
                    <?php echo __('Are you sure you want to mark this invoice as refunded?', true); ?>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-invoice-mark-refunded" style="display: none;"/>
                <button class="btn btn-default" id="invoice-mark-refunded-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="invoice-mark-refunded-confirm" type="button"><?php echo __('Mark refunded', true); ?></button>
            </div>
        </div>
    </div>
</div>
