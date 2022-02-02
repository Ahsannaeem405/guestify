<?php
    App::import('Controller', 'Users');
    App::import('Helper', 'Html');
    App::import('Helper', 'Time');
    App::import('Helper', 'Number');
    App::import('Helper', 'Session');

    $this->Number = new NumberHelper(new View(null));
    $this->Time = new TimeHelper(new View(null));
    $this->Session = new SessionHelper(new View(null));

?>

<style type="text/css">
    body { text-indent: 0; margin: 0; padding: 0; }
    h3 { font-size: 12pt;}
    h4 { font-size: 10pt;}
    table.first { width: 253mm; font-size: 11pt;}
    table.second { width: 400mm; 10pt;}
    tr.head td { border-bottom: 1pt #666666 solid; height: 5mm;}
    td.units {width: 25mm; text-align: center;}
    td.artciles { }
    td.price { width: 20mm;}
    tr.positions td { border-bottom: .5pt #cccccc solid;}
    tr.total td { border-top: 1pt #666666 solid; font-size: 14pt;}
    .align-right { text-align: right;}
    .align-left { text-align: left;}
    td.column_right { width: 55mm; font-size: 10pt;}
    .text { text-indent: 0; }
    .regular { font-size: 9pt;}
    .medium { font-size: 8pt;}
    .small { font-size: 7pt;}
</style>

<br />
<br />

<table class="first" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td>
            <p class="text"><?php if(!empty($invoice['Invoice']['company'])) { ?><?php echo h($invoice['Invoice']['company']); ?> <br /><?php } ?><?php echo h($genders[$invoice['Invoice']['gender']]) . ' ' . h($invoice['Invoice']['firstname']) . ' ' . h($invoice['Invoice']['lastname']); ?><br />
                <?php echo h($invoice['Invoice']['address']); ?> <br />
                <?php if(!empty($invoice['Invoice']['address_additional'])) { ?>
                    <?php echo h($invoice['Invoice']['address_additional']); ?> <br />
                <?php } ?>
                <?php echo h($invoice['Invoice']['zipcode']) . ' ' . h($invoice['Invoice']['city']); ?><br />
                <?php echo $invoice['Invoice']['country_name']; ?> <br />
            </p>
        </td>
        <td class="column_right">
            <p class="text medium align-right"><?php echo __('Service delivered by', true); ?> <br />
                <?php echo 'Guestify'; ?> <br />
                <?php /*echo __('VAT ID', true) .': XXXXXXX'; */?><br />
            </p>
            <p class="text medium align-right"><strong><?php echo __('Reference', true); ?></strong><br />
                <?php echo __('Customer Number', true).': ' . $invoice['Host']['id']; ?> <br />
                <?php echo __('Invoice date', true); ?>: <?php echo $this->Time->format($formats['date'], $invoice['Invoice']['created']); ?> <br />
                <?php if(!empty($invoice['Invoice']['ustid'])) { ?>
                    <?php echo __('Your VAT ID', true).': ' . h($invoice['Invoice']['ustid']); ?>
                <?php } ?>
            </p>
        </td>
    </tr>
</table>
<h2><?php echo __('Invoice', true); ?></h2>
<p class="regular align-left"><?php echo __('Invoice number', true).': '.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?> </p>


<table class="second" cellpadding="5" cellspacing="0" border="0" >
        <tr class="head">
            <td class="units" width="2cm"><span class="regular right-align"><?php echo __('Units', true); ?></span></td>
            <td class="articles" width="9cm"><span class="regular"><?php echo __('Article', true); ?></span></td>
            <td class="price"  width="2cm"><span class="regular align-right"><?php echo __('Price',true); ?></span></td>
        </tr>

        <tr class="positions">
            <td class="units" valign="top" width="2cm"><span class="regular">1 x</span></td>
            <td valign="top"><span class="regular"><strong><?php echo $invoice['Invoice']['description']; ?></strong><br />
                    <?php echo __('Host', true); ?>: <?php echo h($invoice['Host']['name']); ?>, <?php echo __('Poll', true); ?>: <?php echo h($invoice['Poll']['title']); ?><br />
                    <?php echo __('Period of service', true).': '. $this->Time->format($formats['datetime'], $invoice['Invoice']['valid_from']).' - '.$this->Time->format($formats['datetime'], $invoice['Invoice']['valid_until']); ?><br />
                </span>
            </td>

            <td><span class="regular align-right"><?php echo $this->Number->format($invoice['Invoice']['price_netto'], $formats['currency']); ?></span></td>
        </tr>

        <?php if(!empty($invoice['Invoice']['promotioncode'])) { ?>
            <tr class="positions">
                <td class="units" valign="top"><span class="regular">1 x</span></td>
                <td valign="top"><span class="regular"><strong><?php echo __('Promotioncode', true); ?></strong> <br />
                        <?php echo h($invoice['Invoice']['promotioncode']); ?> (<?php echo $invoice['Invoice']['promotioncode_deduction_percent']; ?>%)
                    </span>
                </td>
                <td><span class="regular align-right"><?php echo '&ndash;'.' '.$this->Number->format($invoice['Invoice']['promotioncode_deduction_netto'], $formats['currency']); ?></span></td>
            </tr>
        <?php } ?>

        <tr>
            <td>&nbsp;</td>
            <td><span class="regular align-right"><?php echo __('Net total', true); ?></span></td>
            <td><span class="regular align-right"><?php echo $this->Number->format($invoice['Invoice']['final_netto'], $formats['currency']); ?></span></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><?php if($invoice['Invoice']['country_id'] == 1) { ?><span class="regular align-right"><?php echo round($invoice['Invoice']['price_vat_percent'], 2); ?>% <?php echo __('VAT', true); ?></span><?php } else { ?><span class="regular align-right"><?php echo __('VAT', true); ?></span><?php } ?>
            </td>
            <td><span class="regular align-right"><?php echo $this->Number->format($invoice['Invoice']['final_vat'], $formats['currency']); ?></span></td>
        </tr>
        <tr class="total">
            <td>&nbsp;</td>
            <td><span class="regular align-right"><?php echo __('Total', true); ?></span></td>
            <td><span class="regular align-right"><strong><?php echo $this->Number->format($invoice['Invoice']['final_total'], $formats['currency']); ?></strong></span></td>
        </tr>
</table>

<table class="third" cellpadding="" cellspacing="0" border="0" ><tr><td width="13cm">
<?php /* UNCOMMENT THIS LINE IF YOU NEED TO ADD INTERNATIONAL VAT REGULATIONS 
<?php if($invoice['Invoice']['country_id'] != 1) { ?>
<p class="text regular align-left"><?php echo __('Reverse charges. The tax free inner-community-based service delivery - according to § 4 No. 1b and 6a UStG. Transfer of tax debt under § 13b UStG based on German law.', true); ?>
</p>
<?php } ?>
*/ ?>


<br/>
<?php if(($invoice['Invoice']['payment_type'] == 1) && isset($invoice['PaymentPP']) && !empty($invoice['PaymentPP']['id'])) { ?>
<h4><?php echo __('Payment information', true); ?></h4>
<p class="text medium"><?php echo __('Payment method', true).': PayPal'; ?> <br />
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
<p class="text regular align-left"><?php echo  __('This statement was prepared electronically and is valid without signature. Thank you very much for using guestify.net.', true); ?>
</p>
<?php } else { ?>
<p class="text medium"><?php echo __('Payable within 7 days without deduction. Please add the invoice number', true); ?> <strong><?php echo Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?></strong> <?php echo __('to your bank transfer.', true); ?> <?php echo __('Please transfer the amount to the following bank account', true); ?>:</p>

<table class="fourth text medium" cellpadding="" cellspacing="0" border="0" >
<tr>
    <td width="3cm" class="right-align"><?php echo __('Bank', true); ?>:</td>
    <td>YOURBANK</td>
</tr>
<tr>
    <td width="3cm" class="right-align"><?php echo __('Recipient', true); ?>:</td>
    <td>XXXXX</td>
</tr>
<tr>
    <td width="3cm" class="right-align">ACCOUNT:</td>
    <td>XXXXXX</td>
</tr>
<tr>
    <td width="3cm" class="right-align">BIC:</td>
    <td>XXXXXXX</td>
</tr>
<tr>
    <td width="3cm" class="right-align"><?php echo __('Purpose', true); ?>:</td>
    <td><?php echo Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?></td>
</tr>
</table>
<?php } ?>
</td>
</tr>
</table>