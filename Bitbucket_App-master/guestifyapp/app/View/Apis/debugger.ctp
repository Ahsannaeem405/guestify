<?php
    $this->set('title_for_layout', __('API Debugger'));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('System', true), array('controller' => 'pages', 'action' => 'display', 'system'));
    $this->Html->addCrumb(__('API Debugger', true));

    #echo $this->Html->script('View/Accounts/admin_view', false);
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Back', true), array('controller' => 'pages', 'action' => 'display', 'system'), array('class' => 'btn btn-info')); ?>
</div>

<div class="clearfix">&nbsp;</div>

<h2><?php echo __('API Debugger'); ?></h2>

<div class="clearfix">&nbsp;</div>

<div class="panel panel-default">
    <div class="panel-body">
        
        <?php echo $this->Form->create('ApiDebugger', array('url' => $this->here)); ?>

        	<?php
        		echo $this->Form->input('ApiDebugger.api_key', array(
        			'label' => __('Your API key'),
        			'type' => 'text'
        		));
        		echo $this->Form->input('ApiDebugger.api_secret', array(
        			'label' => __('Your API secret'),
        			'type' => 'text'
        		));
        		echo $this->Form->input('ApiDebugger.token', array(
        			'label' => __('Your API token'),
        			'type' => 'text'
        		));
        		echo $this->Form->input('ApiDebugger.function', array(
        			'label' => __('Function to test'),
        			'type' => 'select'
        			'options' => array(
        				'getToken' => __('getToken'),
        				'getPoll' => __('getPoll'),
        				'savePoll' => __('savePoll'),
    				)
        		));
    		?>

        <?php echo $this->Form->end(); ?>

    </div>
</div>
