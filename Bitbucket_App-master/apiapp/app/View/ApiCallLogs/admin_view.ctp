<?php
    $this->set('title_for_layout', __('API Call Log', true). ' - #' . $apiCallLog['ApiCallLog']['id']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('API Call Logs', true), array('action' => 'adminIndex', $type));
    $this->Html->addCrumb(__('API Call Log', true). ' - #' . $apiCallLog['ApiCallLog']['id']);


?>


<div class="btn-toolbar pull-right">
    <?php #echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $api_account['ApiAccount']['id']), array('class' => 'btn btn-info')); ?>
</div>

<div class="clearfix">&nbsp;</div>

<h2><?php echo __('API Call Log', true). ' - #' . $apiCallLog['ApiCallLog']['id']; ?></h2>

<div class="clearfix">&nbsp;</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-7">

                <h4><?php echo __('General information', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('ID', true); ?></dt>
                    <dd>
                        <?php echo $apiCallLog['ApiCallLog']['id']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('API Key', true); ?></dt>
                    <dd>
                        <?php echo $apiCallLog['ApiCallLog']['api_key']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Model', true); ?></dt>
                    <dd>
                        <?php echo $apiCallLog['ApiCallLog']['model']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('ID', true); ?></dt>
                    <dd>
                        <?php echo $apiCallLog['ApiCallLog']['f_key']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Request URI', true); ?></dt>
                    <dd>
                        <?php echo $apiCallLog['ApiCallLog']['request_uri']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Action', true); ?></dt>
                    <dd>
                        <?php echo $apiCallLog['ApiCallLog']['action']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Query', true); ?></dt>
                    <dd>
<pre>
<?php print_r(json_decode($apiCallLog['ApiCallLog']['query'], true)); ?>
</pre>
                        &nbsp;
                    </dd>

                    <dt><?php echo __('Created', true); ?></dt>
                    <dd>
                        <?php echo $apiCallLog['ApiCallLog']['created']; ?>
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

