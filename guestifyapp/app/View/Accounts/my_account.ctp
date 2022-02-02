<?php
    $this->set('title_for_layout', __('My account', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My account', true));
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', User::get('account_id')), array('class' => 'btn btn-info')); ?>
</div>

<h2><?php echo __('My account', true); ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <h3><?php echo $account['Account']['company_name']; ?></h3>
                <h4><?php echo __('Address', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Legal company name', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['company_name']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Street', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['address']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Zipcode', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['zipcode']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('City', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['city']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Country', true); ?></dt>
                    <dd>
                        <?php echo $countries[$account['Account']['country_id']]; ?>
                        &nbsp;
                    </dd>
                </dl>
                <h4><?php echo __('More information', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Tax ID', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['ust_id']; ?>
                        &nbsp;
                    </dd>
                </dl>
                <h4><?php echo __('Contact', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Phone', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['phone']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Mobile', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['mobile']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Fax', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['fax']; ?>
                        &nbsp;
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>


