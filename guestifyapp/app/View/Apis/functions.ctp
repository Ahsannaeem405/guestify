<?php
    $this->set('title_for_layout', __('API functions'));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('System', true), array('controller' => 'pages', 'action' => 'display', 'system'));
    $this->Html->addCrumb(__('API functions', true));

    #echo $this->Html->script('View/Accounts/admin_view', false);
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Back', true), array('controller' => 'pages', 'action' => 'display', 'system'), array('class' => 'btn btn-info')); ?>
</div>

<div class="clearfix">&nbsp;</div>

<h2><?php echo __('API functions'); ?></h2>

<div class="clearfix">&nbsp;</div>

<div class="panel panel-default">
    <div class="panel-body">
        
        List all API functions here!

    </div>
</div>
