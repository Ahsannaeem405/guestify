<?php
    $this->set('title_for_layout', __('API Token', true). ' - #' . $apiToken['ApiToken']['id']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('API Tokens', true), array('action' => 'adminIndex', $type));
    $this->Html->addCrumb(__('API Token', true). ' - #' . $apiToken['ApiToken']['id']);
?>


<div class="btn-toolbar pull-right">
    <?php #echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $api_account['ApiAccount']['id']), array('class' => 'btn btn-info')); ?>
</div>

<div class="clearfix">&nbsp;</div>

<h2><?php echo __('API Token', true). ' - #' . $apiToken['ApiToken']['id']; ?></h2>

<div class="clearfix">&nbsp;</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-7">

                <h4><?php echo __('General information', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('ID', true); ?></dt>
                    <dd>
                        <?php echo $apiToken['ApiToken']['id']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Type', true); ?></dt>
                    <dd>
                        <?php echo $tokenTypeLabels[$apiToken['ApiToken']['type']]; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('API Key', true); ?></dt>
                    <dd>
                        <?php echo $apiToken['ApiToken']['api_key']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Account ID', true); ?></dt>
                    <dd>
                        <?php echo $apiToken['ApiToken']['account_id']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Type', true); ?></dt>
                    <dd>
                        <?php 
                            if($type == 'live') {
                                echo __('Live', true);
                            } else {
                                echo __('Debugger', true);
                            }
                        ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Token', true); ?></dt>
                    <dd>
                        <?php echo $apiToken['ApiToken']['token']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Model/Key', true); ?></dt>
                    <dd>
                        <?php echo $apiToken['ApiToken']['model']; ?>/<?php echo $apiToken['ApiToken']['f_key']; ?>
                        &nbsp;
                    </dd>
                    <?php if(isset($apiToken['Host']['name']) && !empty($apiToken['Host']['name'])) { ?>
                        <dt><?php echo __('Host', true); ?></dt>
                        <dd>
                            <?php echo $apiToken['Host']['name']; ?>
                        </dd>
                    <?php } ?>
                    <dt><?php echo __('Status', true); ?></dt>
                    <dd>
                        <span class="label label-<?php echo $tokenStatusClasses[$apiToken['ApiToken']['status']]; ?>"><?php echo $tokenStatuses[$apiToken['ApiToken']['status']]; ?></span>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Created', true); ?></dt>
                    <dd>
                        <?php echo $apiToken['ApiToken']['created']; ?>
                        &nbsp;
                    </dd>
                </dl>

            </div>
            <div class="col-xs-5">

            </div>
        </div>

        <hr />

    </div>
</div>

