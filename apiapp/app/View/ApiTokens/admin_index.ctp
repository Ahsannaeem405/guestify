<?php
    $this->set('title_for_layout', __('API Tokens', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('API Tokens', true));

    $model = 'ApiToken';
    if(isset($this->params['ApiTokens.index.tab']) && ($this->params['ApiTokens.index.tab'] == 'debugger')) {
        $model =  'DebuggerApiToken';
    }
?>


<div class="clearfix">
    
    <h2><?php echo __('API Tokens'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <?php echo $this->element('ApiTokens/navtabs'); ?>

            <?php echo $this->element('counting_paginator'); ?>

            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'ID');?></th>
                        <th><?php echo $this->Paginator->sort('account_id', __('Account'));?></th>
                        <th><?php echo $this->Paginator->sort('api_key', __('API Key')); ?></th>
                        <th><?php echo $this->Paginator->sort('token', __('Token')); ?></th>
                        <th><?php echo $this->Paginator->sort('f_key', __('Poll')); ?></th>
                        <th><?php echo $this->Paginator->sort('type', __('Type')); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created')); ?></th>
                        <th class="pull-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($apiTokens as $apiToken) { ?>
                        <tr>
                            <td>
                                <?php echo $apiToken[$model]['id']; ?>
                            </td>
                            <td>
                                <?php echo $apiToken[$model]['account_id']; ?>
                            </td>
                            <td>
                                <?php echo $apiToken[$model]['api_key']; ?>
                            </td>
                            <td>
                                <?php echo $apiToken[$model]['token']; ?>
                            </td>
                            <td>
                                # <?php echo $apiToken[$model]['f_key']; ?>
                            </td>
                            <td>
                                <?php echo $apiToken[$model]['type']; ?>
                            </td>
                            <td>
                                <span class="label label-<?php echo $tokenStatusClasses[$apiToken[$model]['status']]; ?>"><?php echo $tokenStatuses[$apiToken[$model]['status']]; ?></span>
                            </td>
                            <td>
                                <?php echo $apiToken[$model]['created']; ?>
                            </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $apiToken[$model]['id'], $this->params['ApiTokens.index.tab']), array('class' => 'btn btn-sm btn-default'));
                                        echo $this->Html->link(__('Delete', true), array('action' => 'adminDelete', $apiToken[$model]['id'], $this->params['ApiTokens.index.tab']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if(empty($apiTokens)) { ?>
                        <tr>
                            <td colspan="9">
                                <div class="placeholderbox"><?php echo __('No entries', true); ?></div>
                            </td>
                        </tr>
                    <?php  } ?>

                </tbody>
            </table>

            <?php echo $this->element('counting_paginator'); ?>
        </div>
    </div>

</div>

<?php echo $this->element('Widgets/standard_delete/main'); ?>
