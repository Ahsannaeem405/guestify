<?php
    $this->set('title_for_layout', __('API Call logs', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('System', true), array('controller' => 'pages', 'action' => 'display', 'system'));
    $this->Html->addCrumb(__('API Call logs', true));

?>

<div class="clearfix">
    
    <h2><?php echo __('API Call Logs'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            
            <?php echo $this->element('counting_paginator'); ?>

            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'ID');?></th>
                        <th><?php echo $this->Paginator->sort('api_key', __('API Key', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('action', __('Action', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('f_key', __('Poll', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($apiCallLogs as $apiCallLog) { ?>
                        <tr>
                            <td>
                                <?php echo $apiCallLog['ApiCallLog']['id']; ?>
                            </td>
                            <td>
                                <?php echo $apiCallLog['ApiCallLog']['api_key']; ?>
                            </td>
                            <td>
                                <?php echo $apiCallLog['ApiCallLog']['action']; ?>
                            </td>
                            <td>
                                # <?php echo $apiCallLog['ApiCallLog']['f_key']; ?>
                            </td>
                            <td>
                                <?php echo $apiCallLog['ApiCallLog']['created']; ?>
                            </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $apiCallLog['ApiCallLog']['id']), array('class' => 'btn btn-sm btn-default'));
                                        echo $this->Html->link(__('Delete', true), array('action' => 'adminDelete', $apiCallLog['ApiCallLog']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if(empty($apiCallLogs)) { ?>
                        <tr>
                            <td colspan="6">
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
