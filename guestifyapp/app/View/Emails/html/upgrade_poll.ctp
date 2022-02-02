<?php $media_host = Configure::read('CDN.Host'); ?>
<table cellpadding="0" cellspacing="0" width="460">
    <tr>
        <td valign="top">
            <h3 style="font-size: 15px; margin: 0px 0px 10px 0;"><?php echo __('Poll upgrade confirmation', true); ?></h3></h3>
            <?php echo $this->Html->tag('h2', __('Invoice', true), array('style'=>'font-size: 18px; margin: 0px 0px 5px 0;'));?>
        </td>
        <td width="100px" align="right">
            <?php #echo $this->Html->Image($media_host . 'commons/present_64.jpg', array('width' => '64px', 'height' => '64px', 'style' => 'display: block;')); ?>
        </td>
    </tr>
</table>
<h4><?php echo __('Hello'); ?>!</h4>
<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <strong><?php echo __('Thank you for upgrading your poll to PREMIUM!', true); ?></strong>
    
    <br/>
    <br/>

    <?php if($invoice['Invoice']['payment_type'] == 1) { ?>
        <?php echo __('We just received your payment for the invoice number').' <strong>'.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number'].'</strong>.'; ?> <br />
    <?php } else { ?>
        <?php echo __('Please transfer the amount via bank transfer of the invoice', true). ' <strong>'.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number'].'</strong>.'; ?> <br />
    <?php } ?>
    <br />
    <?php echo __('Your upgrade will be available until', true); ?>: <strong><?php echo $this->Time->format($formats['datetime'], $invoice['Invoice']['valid_until']); ?></strong>. <br />
    <br />
    <?php echo __('Attached to this email is your invoice as PDF. You can always view all existing invoices in your acccount settings and download them again.', true); ?>
</p>
<p style="font-size: 12px; margin: 0px 0px 5px 0;">    
    <?php echo __('You can extend your upgrade anytime. Go to your account settings and simply select extend', true); ?>. <br />
</p>
<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <?php echo __('Here you can access and download your invoices'); ?>: <?php echo $this->Html->link(__('Invoices', true), Configure::read('NON_SSL_HOST').'/invoices/my_invoices');?>
</p>
<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <?php echo __('If you have any questions regarding your premium buy, please feel free to contact us.', true); ?>
</p>
<p style="font-size: 12px; margin: 0px 0px 5px 0;">
    <?php echo __('Thank you', true); ?>
</p>
<p>
    <?php echo __('With best regards'); ?><br />
    <?php echo __('Your guestify Team'); ?>
</p>
