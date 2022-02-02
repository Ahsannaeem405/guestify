<?php
    $this->set('title_for_layout', __('Upgrade successful!', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My Polls', true), array('action' => 'index'), array('escape' => false));
    $this->Html->addCrumb(__('Upgrade problem!', true));

    #echo $this->Html->script('View/Polls/upgrade', false);
?>


<h2><?php echo __('Upgrade problem', true); ?>!</h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <?php
                    # overwrite the type when styling this template
                    #$upgrade['Problem']['type'] = 'do_express_checkout_failed';

                    switch($upgrade['Problem']['type']) {
                        case 'paypal_redirect_failed':
                            $title = __('We could not redirect you to the PayPal website!', true);
                            break;
                        case 'shipping_details_failed':
                            $title = __('We could not retrieve your payment data from PayPal!', true);
                            break;
                        case 'do_express_checkout_failed':
                            $title = __('We were not able to charge your PayPal-Account!', true);
                            # add error code and specific description of the problem (e.g. card denied, exceeded etc.)
                            break;
                    }
                ?>
                <h3><?php echo $title; ?></h3>
            </div>

            <div class="panel-body">
                <div class="well well-lg">
                    <?php if($upgrade['Problem']['type'] == 'paypal_redirect_failed') { ?>
                        <p class="lead"><?php echo __('We could not redirect to PayPal. There seems to be a technical problem at the moment.', true); ?></p>
                        <p class="lead"><?php echo __('Please try again later or select another payment method.', true); ?></p>
                        <p class="">
                            <?php echo $this->Html->link(__('Change payment method', true), array('action' => 'upgrade', $poll['Poll']['id']), array('class' => 'btn btn-info')); ?>
                        </p>
                    <?php } ?>

                    <?php if($upgrade['Problem']['type'] == 'shipping_details_failed') { ?>
                        <p class="lead"><?php echo __('We could not retrieve your PayPal-information. It seems the data from PayPal could not be fetched. There was nothing charged so far.', true); ?></p>
                        <p class="lead"><?php echo __('Please try again or select another payment method.', true); ?></p>
                        <p class="">
                            <?php echo $this->Html->link(__('Try again', true), array('action' => 'upgrade', $poll['Poll']['id']), array('class' => 'btn btn-info')); ?>
                        </p>
                    <?php } ?>

                    <?php if($upgrade['Problem']['type'] == 'do_express_checkout_failed') { ?>

                        <p class="lead"><?php echo __('We could not charge your PayPal-Account. PayPal sent the following error-code for your payment-request', true); ?>:</p>

                        <?php
                            # uncomment this to see the error-container(s) for specific error-codes

                            # $upgrade['Transaction']['PAYMENTINFO_0_ERRORCODE'] = 10486;
                            # ... add other codes later
                        ?>

                        <?php if(isset($upgrade['Transaction']['PAYMENTINFO_0_ERRORCODE'])) { ?>
                            <p class="lead text-center">
                                <strong><?php echo $upgrade['Transaction']['PAYMENTINFO_0_ERRORCODE']; ?></strong>
                            </p>

                            <?php if($upgrade['Transaction']['PAYMENTINFO_0_ERRORCODE'] == 10486) { ?>

                                <?php echo __('The payment for your selected payment method within PayPal was denied. To solve this issue, you can try the following suggestions', true); ?>:
                                <ul>
                                    <li><?php echo __('Check your PayPal account for valid (and up-to-date) settings for the desired payment option', true); ?></li>
                                    <li><?php echo __('Select a different payment option within PayPal', true); ?></li>
                                    <li><?php echo __('Add another payment option to your PayPal account', true); ?></li>
                                    <li><?php echo __('Buy your upgrade on-account and pay later via bank-transfer', true); ?></li>
                                </ul>
                            <?php } ?>

                        <?php } ?>

                        <p class="">
                            <?php echo $this->Html->link(__('Try again', true), array('action' => 'upgrade', $poll['Poll']['id']), array('class' => 'btn btn-block btn-success')); ?>
                        </p>
                    <?php } ?>
                </div>
                <?php #pr($upgrade); ?>
                <?php #pr($poll); ?>
            </div>
        </div>
    </div>

    <div class="col-xs-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3><?php echo __('Customer support', true); ?></h3>
            </div>

            <div class="panel-body">

                <p class="lead text-center"><?php echo __('Do you need help with your upgrade?', true); ?></p>

                <p class="lead text-center">
                    <?php echo __('Call us any time', true); ?> <br />
                    + 49 221 12345
                </p>
            </div>
        </div>
    </div>

</div>
