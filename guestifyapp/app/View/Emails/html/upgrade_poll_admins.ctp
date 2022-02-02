<h2><?php echo __('Poll upgrade confirmation notification', true); ?></h3></h3>

<h3><?php echo __('Hello Admins'); ?>!</h3>

<p style="font-size: 18px; margin: 0px 0px 5px 0;">
    <strong><?php echo __('A poll was upgraded to PREMIUM!', true); ?></strong>
</p>


<p style="font-size: 16px; margin: 0px 0px 5px 0;">    
    <strong><?php echo __('Revenue', true); ?>:</strong> <?php echo $this->Number->format($invoice['Invoice']['final_total'], $formats['currency']); ?>
</p>

<p style="font-size: 16px; margin: 0px 0px 5px 0;">    
    <strong><?php echo __('Description', true); ?>:</strong> <?php echo $invoice['Invoice']['description']; ?>
</p>

<p style="font-size: 16px; margin: 0px 0px 5px 0;">    
    <strong><?php echo __('Type of invoice', true); ?>:</strong> <?php echo $payment_types[$invoice['Invoice']['payment_type']]; ?>
</p>

<p style="font-size: 16px; margin: 0px 0px 5px 0;">    
    <strong><?php echo __('Poll', true); ?>:</strong> <?php echo $this->Html->link($invoice['Poll']['title'], array('controller' => 'polls', 'action' => 'adminView', $invoice['Poll']['id'])); ?>
</p>

<p style="font-size: 16px; margin: 0px 0px 5px 0;">    
    <strong><?php echo __('Host', true); ?>:</strong> <?php echo $this->Html->link($invoice['Host']['name'], array('controller' => 'hosts', 'action' => 'adminView', $invoice['Host']['id'])); ?>
</p>

<p style="font-size: 16px; margin: 0px 0px 5px 0;">    
    <strong><?php echo __('Account', true); ?>:</strong> <?php echo $this->Html->link($invoice['Account']['company_name'], array('controller' => 'accounts', 'action' => 'adminView', $invoice['Account']['id'])); ?>
</p>

<br />

<p style="font-size: 16px; margin: 0px 0px 5px 0;">    
    <?php echo __('The invoice is attached to this email as PDF.', true); ?>
</p>

<h3><?php echo __('Nice work!'); ?></h3>

<?php #pr($invoice); ?>