<?php
    $this->set('title_for_layout', __('API Debugger'));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('API Debugger', true));

    echo $this->Html->script('View/ApiDebugger/debugger.js');
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Back', true), array('controller' => 'pages', 'action' => 'display', 'system'), array('class' => 'btn btn-info')); ?>
</div>

<div class="clearfix">&nbsp;</div>

<h2><?php echo __('API Debugger'); ?> v0.1alpha</h2>

<div class="clearfix">&nbsp;</div>

<div class="panel panel-default">
    <div class="panel-body">

    	<div class="row clearfix">
	        <?php echo $this->Form->create('ApiDebugger', array('url' => $this->here)); ?>
	        	<div class="clearfix col-lg-4">
	        		<h3><?php echo __('Parameters'); ?></h3>
		        	<?php
		        		echo $this->Form->input('ApiDebugger.function', array(
		        			'label' => __('API Function'),
		        			'type' => 'select',
		        			'div' => array(
		        				'class' => 'form-group'
	        				),
		        			'class' => 'form-control',
		        			'id' => 'api_debugger-function',
		        			'empty' => __('Select function...'),
		        			'options' => array(
		        				'getToken' => __('getToken'),
		        				'getPoll' => __('getPoll'),
		        				'savePoll' => __('savePoll'),
		    				)
		        		));
	        		?>

	        		<hr />

	        		<div id="wrapper-input-api_key" style="display: none;">
		        		<?php
			        		echo $this->Form->input('ApiDebugger.api_key', array(
			        			'label' => __('API key'),
			        			'type' => 'text',
			        			'value' => 'cec50ff799',
			        			'class' => 'form-control',
			        			'div' => array(
			        				'class' => 'form-group'
		        				),
			        			'id' => 'api_debugger-api_key',
			        			'escape' => false,
			        			'after' => '<sdall><i>'.__('The API key of your poll').'</i></span>'
			        		));
		        		?>
	        		</div>

	        		<div id="wrapper-input-api_secret" style="display: none;">
		        		<?php
			        		echo $this->Form->input('ApiDebugger.api_secret', array(
			        			'label' => __('API secret'),
			        			'type' => 'text',
			        			'value' => 'efb9e27deabc9726141d',
			        			'class' => 'form-control',
			        			'div' => array(
			        				'class' => 'form-group'
		        				),
			        			'id' => 'api_debugger-api_secret',
			        			'escape' => false,
			        			'after' => '<sdall><i>'.__('The API secret of your poll').'</i></span>'
			        		));
		        		?>
	        		</div>

	        		<div id="wrapper-input-token" style="display: none;">
		        		<?php
			        		echo $this->Form->input('ApiDebugger.token', array(
			        			'label' => __('API token'),
			        			'type' => 'text',
			        			'class' => 'form-control',
			        			'div' => array(
			        				'class' => 'form-group'
		        				),
			        			'id' => 'api_debugger-token',
			        			'escape' => false,
			        			'after' => '<sdall><i>'.__('The token you fetched with an API call (read or write)').'</i></span>'
			        		));
		        		?>
	        		</div>

	        		<div id="wrapper-input-locale" style="display: none;">
		        		<?php
			        		echo $this->Form->input('ApiDebugger.locale', array(
			        			'label' => __('Locale'),
			        			'type' => 'select',
			        			'options' => array(
			        				'eng' => __('English'),
			        				'deu' => __('German')
		        				),
			        			'class' => 'form-control',
			        			'div' => array(
			        				'class' => 'form-group'
		        				),
			        			'id' => 'api_debugger-locale',
			        			'escape' => false,
			        			'after' => '<sdall><i>'.__('Select the language for the poll').'</i></span>'
			        		));
		        		?>
	        		</div>

	        		<div id="wrapper-input-token_type" style="display: none;">
		        		<?php
			        		echo $this->Form->input('ApiDebugger.token_type', array(
			        			'label' => __('API token type'),
			        			'type' => 'select',
			        			'options' => array(
			        				1 => __('read'),
			        				2 => __('write')
		        				),
			        			'class' => 'form-control',
			        			'div' => array(
			        				'class' => 'form-group'
		        				),
			        			'id' => 'api_debugger-token_type',
			        			'escape' => false,
			        			'after' => '<sdall><i>'.__('Either read or write permission').'</i></span>'
			        		));
		        		?>
	        		</div>

	        		<div id="wrapper-input-payload" style="display: none;">
		        		<?php echo $this->Form->label('ApiDebugger.payload', __('Payload')); ?>

		        		<?php for($i = 1; $i < 6; $i++) { ?>
			        		<div class="row payload-line" style="margin-bottom: 10px;">
			        			<div class="col-lg-5">
					        		<?php
						        		echo $this->Form->input('ApiDebugger.payload.'.$i.'.key', array(
						        			'label' => false,
						        			'placeholder' => __('Key'),
						        			'type' => 'text',
						        			'class' => 'form-control payload_key',
						        			'id' => 'api_debugger-payload_key-'.$i,
						        		));
						    		?>
					    		</div>
			        			<div class="col-lg-5">
					        		<?php
						        		echo $this->Form->input('ApiDebugger.payload.'.$i.'.value', array(
						        			'label' => false,
						        			'placeholder' => __('Value'),
						        			'type' => 'text',
						        			'class' => 'form-control payload_value',
						        			'id' => 'api_debugger-payload_value-'.$i,
						        		));
						    		?>
					    		</div>
					    		<div class="col-lg-2">
					    			<?php 
					    				$style = '';
					    				if($i == 1) { 
					    					$style = 'display: none;';
				    					}
			    					?>
				    				<?php echo $this->Html->link('<span class="glyphicon glyphicon-minus-sign"></span>', '#', array('class' => 'trigger-remove-payload-line btn btn-sm btn-danger btn-block', 'escape' => false, 'style' => $style)); ?>
					    		</div>
				    		</div>
			    		<?php } ?>
		    		</div>

		    		<div id="wrapper-input-payload-add" class="clearfix" style="display:none;">
		    			<?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span>', '#', array('id' => 'trigger-add-payload-line', 'class' => 'btn btn-success btn-block', 'escape' => false)); ?>
	    			</div>

		    		<hr />

		    		<?php echo $this->Form->submit(__('Send'), array('id' => 'trigger-form-submit', 'class' => 'btn btn-success')); ?>
		    		<br />
		    		<?php echo $this->Html->link(__('Reset'), array('id' => 'trigger-form-reset', 'class' => 'btn btn-default')); ?>
	    		</div>

	    		<div class="clearfix col-lg-8">
	    			<h3><?php echo __('Result'); ?></h3>
	    			<?php
		        		echo $this->Form->input('ApiDebugger.request_url', array(
		        			'label' => __('Call URL'),
		        			'type' => 'textarea',
		        			'rows' => 3,
		        			'style' => 'background-color: #DEDEDE',
		        			'class' => 'form-control mono',
		        			'div' => array(
		        				'class' => 'form-group'
	        				),
		        			'readonly' => true,
		        			'id' => 'api_debugger-request_url'
		        		));
	        		?>

	        		<?php
		        		echo $this->Form->input('ApiDebugger.request_result', array(
		        			'label' => __('Request Result'),
		        			'type' => 'textarea',
		        			'style' => 'background-color: #DEDEDE',
		        			'class' => 'form-control mono',
		        			'div' => array(
		        				'class' => 'form-group'
	        				),
	        				'rows' => 30,
		        			'readonly' => true,
		        			'id' => 'api_debugger-request_result',
		        			'escape' => false
		        		));
	        		?>
	    		</div>
	        <?php echo $this->Form->end(); ?>
        </div>

    </div>
</div>

<style>
	.mono, textarea.mono {
  		/*border:1px solid #999999;*/
  		font-family:Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New, monospace;
	}
</style>
