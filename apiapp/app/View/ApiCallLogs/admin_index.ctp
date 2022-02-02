<?php
    $this->set('title_for_layout', __('API Call Logs', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('API Call Logs', true));

    $model = 'ApiCallLog';
    if(isset($this->params['ApiCallLogs.index.tab']) && ($this->params['ApiCallLogs.index.tab'] == 'debugger')) {
        $model =  'DebuggerApiCallLog';
    }
?>


<div class="clearfix">
    
    <h2><?php echo __('API Call Logs'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <?php echo $this->element('ApiCallLogs/navtabs'); ?>

            <?php echo $this->element('counting_paginator'); ?>

            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'ID');?></th>
                        <th><?php echo $this->Paginator->sort('api_key', __('API Key', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('request_uri', __('Request', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('action', __('Function', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('model', __('Model', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('f_key', __('ID', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="pull-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($apiCallLogs as $apiCallLog) { ?>
                        <tr>
                            <td>
                                <?php echo $apiCallLog[$model]['id']; ?>
                            </td>
                            <td>
                                # <?php echo $apiCallLog[$model]['api_key']; ?>
                            </td>
                            <td>
                                <?php echo $apiCallLog[$model]['request_uri']; ?>
                            </td>
                            <td>
                                <?php echo $apiCallLog[$model]['action']; ?>
                            </td>
                            <td>
                                <?php echo $apiCallLog[$model]['model']; ?>
                            </td>
                            <td>
                                <?php echo $apiCallLog[$model]['f_key']; ?>
                            </td>
                            <td>
                                <?php echo $apiCallLog[$model]['created']; ?>
                            </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $apiCallLog[$model]['id'], $this->params['ApiCallLogs.index.tab']), array('class' => 'btn btn-sm btn-default'));
                                        #echo $this->Html->link(__('Delete', true), array('action' => 'adminDelete', $apiCallLog[$model]['id'], $this->params['ApiCallLogs.index.tab']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if(empty($apiCallLogs)) { ?>
                        <tr>
                            <td colspan="8">
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
