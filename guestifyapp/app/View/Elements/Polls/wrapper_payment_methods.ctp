<?php
    $locale = Configure::read('Config.language');
    $paypal_image_locale = 'en_US';

    switch($locale) {
        case 'eng':
            $paypal_image_locale = 'en_US';
            break;
        case 'deu':
            $paypal_image_locale = 'de_DE';
            break;
    }
?>

<?php if($g_taxes_apply) { ?>
    <p class="text-center"><?php echo __('Local taxes apply', true); ?></p>
<?php } ?>

<div class="row">
    <div class="col-xs-6">
        <div class="text-center">
            <h4><?php echo __('PayPal', true); ?></h4>
            <hr />
            <small><?php echo __('Pay now'); ?></small>
            <p class="lead">
                <?php echo $this->Number->format($price, $formats['currency']); ?>
            </p>
            <input type="image" name="submit" class="payment-submit" id="payment_type-paypal" src="https://www.paypalobjects.com/webstatic/<?php echo $paypal_image_locale; ?>/i/buttons/checkout-logo-large.png" border="0" align="top" alt="<?php echo __('Pay with PayPal', true); ?>" />
        </div>
    </div>
    <div class="col-xs-6">
        <div class="text-center">
            <h4><?php echo __('Pay on account', true); ?></h4>
            <hr />
            <small><?php echo __('Pay later'); ?></small>
            <p class="lead">
                <?php echo $this->Number->format($price, $formats['currency']); ?>
            </p>
            <?php echo $this->Form->button('<span class="glyphicon glyphicon-ok"></span> '. __('Buy', true), array('class' => 'btn btn-success btn-lg payment-submit', 'type' => 'submit', 'id' => 'payment_type-on_account', 'escape' => false)); ?>
        </div>
    </div>
</div>
