<?php
    $this->set('title_for_layout', __('Upgrade poll', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My Polls', true), array('action' => 'index'));
    $this->Html->addCrumb(strip_tags($poll['Poll']['name']), array('action' => 'showLast30', $poll['Poll']['id']), array('escape' => false));
    $this->Html->addCrumb(__('Upgrade', true));

    echo $this->Html->script('View/Polls/upgrade', false);
?>

<span id="upgrade-poll_id" style="display: none;"><?php echo $poll['Poll']['id']; ?></span>

<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Back', true), array('action' => 'settings', $poll['Poll']['id']), array('class' => 'btn btn-info')); ?>
</div>

<?php
    if(isset($latest_upgrade) && !empty($latest_upgrade)) {
        $type = __('Upgrade Extension', true);
    } else {
        $type = __('Upgrade', true);
    }
?>

<h2><?php echo $type; ?>: <?php echo $poll['Poll']['title']; ?> </h2>



<?php echo $this->Form->create('Poll', array('url' => $this->here)); ?>

    <div class="row">
        <div class="col-xs-7">
            <div class="panel panel-default">
                <div class="panel-heading">1. <?php echo __('Choose your plan', true); ?></div>
                <div id="period-selection" class="panel-body">

                    <small>&nbsp;</small>
                    <div class="panel panel-success">
                        <div class="panel-heading"><h4 class="text-center"><span class="glyphicon glyphicon-ok"></span> <?php echo __('Included', true); ?></h4></div>
                        <ul class="list-group">
                            <li class="list-group-item"><?php echo __('Unlimited ratings', true); ?> </li>
                            <li class="list-group-item"><?php echo __('Weekly Reports', true); ?> </li>
                            <li class="list-group-item"><?php echo __('XLS Export', true); ?> </li>
                            <li class="list-group-item"><?php echo __('API Support', true); ?> </li>
                            <li class="list-group-item"><?php echo __('Personal Support', true); ?> </li>
                        </ul>

                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="panel panel-success">
                                <div class="panel-heading"><h4 class="text-center"><?php echo __('Monthly', true); ?></h4></div>
                                <div class="panel-body">
                                    <div class="price lead text-center">
                                        <?php echo $this->Number->format($config['prices']['m'], $formats['currency']); ?> <span class="per"></span>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <?php
                                        $checked = '';
                                        if($selected_period == 'm') {
                                            $checked = 'checked="checked"';
                                        }
                                    ?>
                                    <label for="UpgradeM" class="btn btn-success btn-block">
                                        <input name="data[Poll][upgrade]" id="UpgradeM" value="m" type="radio" class="" <?php echo $checked; ?>>
                                        <?php echo __('Select', true); ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <?php /*

                        <div class="col-xs-4">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="position_absolute"><span class="bestbuy label label-danger hide">BEST BUY</span></div>
                                    <h4 class="text-center"><?php echo __('6 MONTH', true); ?></h4>
                                </div>
                                <div class="panel-body">
                                    <div class="price lead text-center">
                                        <?php echo $this->Number->format($config['prices']['h'], $formats['currency']); ?> <span class="per"></span>
                                    </div>
                                </div>

                                <div class="panel-footer">
                                    <?php
                                        $checked = '';
                                        if($selected_period == 'h') {
                                            $checked = 'checked="checked"';
                                        }
                                    ?>
                                    <label for="UpgradeH" class="btn btn-success btn-block">
                                        <input name="data[Poll][upgrade]" id="UpgradeH" value="h" type="radio" class="" <?php echo $checked; ?>>
                                        <?php echo __('Select', true); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        */ ?>

                        <div class="col-xs-6">
                            <div class="panel panel-success">
                                <div class="panel-heading"><h4 class="text-center"><?php echo __('Yearly', true); ?></h4></div>
                                <div class="panel-body">
                                    <div class="price lead text-center">
                                        <?php echo $this->Number->format($config['prices']['y'], $formats['currency']); ?> <span class="per"></span>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <?php
                                        $checked = '';
                                        if($selected_period == 'y') {
                                            $checked = 'checked="checked"';
                                        }
                                    ?>

                                    <label for="UpgradeY" class="btn btn-success btn-block">
                                        <input name="data[Poll][upgrade]" id="UpgradeY" value="y" type="radio" class="" <?php echo $checked; ?>>
                                        <?php echo __('Select', true); ?>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <p class="text-center"><?php echo __('All prices are excluding taxes.', true); ?></p>

                    <div id="wrapper-period">
                        <?php echo $this->element('Polls/wrapper_period'); ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xs-5">
            <div class="panel panel-info">
                <div class="panel-heading"><strong><?php echo __('Help', true); ?></strong></div>
                <div class="panel-body">
                    <h6><?php echo __('What benefit do I get from the PRO version?', true); ?></h6>
                    <p><?php echo __('You will not only get unlimited ratings, you will get all available time periods (day, week, month and year), you will be also able to export your statistics and premium support.', true); ?></p>
                    <hr />
                    <h6><?php echo __('What payment types do you accept?', true); ?></h6>
                    <p><?php echo __('We accept payments from PayPal and on account - MasterCard, Visa and Bank Transfer will be accepted soon.', true); ?></p>
                    <hr />
                    <h6><?php echo __('Do I loose my data after expiration of a PRO version?', true); ?></h6>
                    <p><?php echo __('No! The data you have collected is yours. You will always be able to access recorded data anytime.', true); ?></p>
                    <hr />
                    <h6><?php echo __('Do you create individual polls?', true); ?></h6>
                    <p><?php echo __('Yes! If one of the offered polls is not fitting into your scenario, we will be happy to help you without further costs.', true); ?></p>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading"><strong><?php echo __('Do you have any questions? Contact us!', true); ?></strong></div>
                <div class="panel-body">
                    <div class="media">
                        <img src="/graphics/logos/300/guestify_logo_word_brand_regular_square_300.jpg" alt="Jean Wichert" width="100" class="img-circle pull-left" />
                        <h4><?php echo __('We are happy to help.'); ?></h4>
                        <p><?php echo __('Please contact us here:'); ?></p>
                        <p class="lead"><strong><?php echo __('012345678', true); ?></strong></p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-7">
            <div class="panel panel-default">
                <div class="panel-heading">2. <?php echo __('Billing information', true); ?></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <?php
                                    echo $this->Form->input('Invoice.gender', array(
                                        'label' => __('Gender', true),
                                        'type' => 'select',
                                        'options' => $options_genders,
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group col-xs-2')
                                    ));
                                    echo $this->Form->input('Invoice.firstname', array(
                                        'label' => __('Firstname', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group col-xs-5')
                                    ));
                                    echo $this->Form->input('Invoice.lastname', array(
                                        'label' => __('Lastname', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group col-xs-5')
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <?php
                                echo $this->Form->input('Invoice.email', array(
                                    'label' => __('Email', true).' *',
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                    'escape' => false
                                ));
                                echo $this->Form->input('Invoice.company', array(
                                    'label' => __('Company', true),
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                ));
                                echo $this->Form->input('Invoice.ustid', array(
                                    'label' => __('Tax-ID', true).' **',
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                ));

                            ?>
                            <hr />
                            <small class="text-info">* <?php echo __('Your invoice will be sent as PDF to this address!', true); ?></small><br />
                            <small class="text-info">** <?php echo __('Insert your tax-ID and it will show up on the invoice.', true); ?></small>
                        </div>

                        <div class="col-xs-6">
                            <?php

                                echo $this->Form->input('Invoice.address', array(
                                    'label' => __('Address', true),
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                ));
                                echo $this->Form->input('Invoice.address_additional', array(
                                    'label' => __('Address additional', true),
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                ));
                                echo $this->Form->input('Invoice.zipcode', array(
                                    'label' => __('Zipcode', true),
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                ));
                                echo $this->Form->input('Invoice.city', array(
                                    'label' => __('City', true),
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group')
                                ));
                                echo $this->Form->input('Invoice.country_id', array(
                                    'label' => __('Country', true),
                                    'type' => 'select',
                                    'options' => $options_countries,
                                    'class' => 'form-control',
                                    'id' => 'invoices-country_id',      // don't mess with this!
                                    'div' => array('class' => 'form-group')
                                ));

                                echo $this->Form->input('Invoice.payment_type', array(
                                    'type' => 'hidden',
                                    'id' => 'invoice-payment_type'
                                ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-7">
            <div class="panel panel-default">
                <div class="panel-heading">3. <?php echo __('Pay', true); ?></div>
                <div class="panel-body">

                    <div id="wrapper-payment-methods" class="clearfix">
                        <?php echo $this->element('Polls/wrapper_payment_methods'); ?>
                    </div>

                    <?php if(Configure::read('Environment') != 'LIVE') { ?>
                        <div class="clearfix">&nbsp;</div>
                        <hr />
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-warning">
                                    <span class="glyphicon glyphicon-info-sign"></span>
                                    <p class="text-center">
                                        <span class="lead"><strong>PayPal Sandbox data</strong></span> <br />
                                        XXX@gXXXX.XXX    <br>
                                        12345678
                                    </p>
                                    <div class="text-center">
                                        <small>(will not be displayed in Live-Environment!)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <hr />
                    <div class="alert alert-info"><span class="glyphicon glyphicon-info-sign"></span> <?php echo __('After successfull confirmation of your upgrade your poll will activate the pro features.'); ?></div>
                    <small></small>
                </div>
            </div>
        </div>
    </div>


<?php echo $this->Form->end(); ?>
