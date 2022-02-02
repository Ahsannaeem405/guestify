<?php
    $this->set('title_for_layout', $api_account['ApiAccount']['company_name']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Accounts', true), array('action' => 'adminIndex'));
    $this->Html->addCrumb($api_account['ApiAccount']['company_name']);

    echo $this->Html->script('View/Accounts/admin_view', false);
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Add host', true), '#', array('id' => 'account-'.$api_account['ApiAccount']['id'], 'class' => 'add_host btn btn-info')); ?>
    <?php echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $api_account['ApiAccount']['id']), array('class' => 'btn btn-info')); ?>
</div>

<div class="clearfix">&nbsp;</div>

<h2><?php echo $api_account['ApiAccount']['company_name']; ?> - <?php echo $api_account['ApiAccount']['api_key']; ?></h2>

<div class="clearfix">&nbsp;</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-7">
                <h4><?php echo __('Address', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Street', true); ?></dt>
                    <dd>
                        <?php echo $api_account['ApiAccount']['address']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Zipcode', true); ?></dt>
                    <dd>
                        <?php echo $api_account['ApiAccount']['zipcode']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('City', true); ?></dt>
                    <dd>
                        <?php echo $api_account['ApiAccount']['city']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Country', true); ?></dt>
                    <dd>
                        <?php echo $countries[$api_account['ApiAccount']['country_id']]; ?>
                        &nbsp;
                    </dd>
                </dl>

                <h4><?php echo __('General information', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Last modified', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $api_account['ApiAccount']['modified']); ?>
                    </dd>
                    <dt><?php echo __('Created', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $api_account['ApiAccount']['created']); ?>
                    </dd>
                </dl>

                <h4><?php echo __('Contact', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Phone', true); ?></dt>
                    <dd>
                        <?php echo $api_account['ApiAccount']['phone']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Mobile', true); ?></dt>
                    <dd>
                        <?php echo $api_account['ApiAccount']['mobile']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Fax', true); ?></dt>
                    <dd>
                        <?php echo $api_account['ApiAccount']['fax']; ?>
                        &nbsp;
                    </dd>
                </dl>

            </div>
            <div class="col-xs-5">

                <div class="well">
                    <h3><?php echo __('Access Credentials', true); ?></h3>
                    <div class="clearfix text-center">
                        <p class="lead">
                            <strong><?php echo __('API Key', true); ?></strong> <br />
                            <span class="label label-warning"><?php echo $api_account['ApiAccount']['api_key']; ?></span>
                        </p>
                    </div>

                    <div class="clearfix text-center">
                        <p class="lead">
                            <strong><?php echo __('API Secret', true); ?></strong> <br />
                            <span class="label label-warning"><?php echo $api_account['ApiAccount']['api_secret']; ?></span>
                        </p>
                    </div>
                </div>

                <hr />

                <div class="well">
                    <h3><?php echo __('API Statistics', true); ?></h3>
                </div>

            </div>
        </div>

        <hr />

    </div>
</div>

