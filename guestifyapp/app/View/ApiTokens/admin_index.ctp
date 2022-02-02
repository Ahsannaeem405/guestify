<?php
    $this->set('title_for_layout', __('API Tokens', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('System', true), array('controller' => 'pages', 'action' => 'display', 'system'));
    $this->Html->addCrumb(__('API Tokens', true));

?>

<div class="clearfix">
    
    <h2><?php echo __('API Tokens'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            
            <?php echo $this->element('counting_paginator'); ?>

            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'ID');?></th>
                        <th><?php echo $this->Paginator->sort('api_key', __('API Key', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('token', __('Token', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('f_key', __('Poll', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('type', __('Type', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($apiTokens as $apiToken) { ?>
                        <tr>
                            <td>
                                <?php echo $apiToken['ApiToken']['id']; ?>
                            </td>
                            <td>
                                <?php echo $apiToken['ApiToken']['api_key']; ?>
                            </td>
                            <td>
                                <?php echo $apiToken['ApiToken']['token']; ?>
                            </td>
                            <td>
                                # <?php echo $apiToken['ApiToken']['f_key']; ?>
                            </td>
                            <td>
                                <?php echo $apiToken['ApiToken']['type']; ?>
                            </td>
                            <td>
                                <?php echo $apiToken['ApiToken']['status']; ?>
                            </td>
                            <td>
                                <?php echo $apiToken['ApiToken']['created']; ?>
                            </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $apiToken['ApiToken']['id']), array('class' => 'btn btn-sm btn-default'));
                                        echo $this->Html->link(__('Delete', true), array('action' => 'adminDelete', $apiToken['ApiToken']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if(empty($apiTokens)) { ?>
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
