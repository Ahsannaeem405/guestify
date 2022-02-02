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
			        			'id' => 'api_debugger-api_key'
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
			        			'id' => 'api_debugger-api_secret'
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
			        			'id' => 'api_debugger-token'
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
			        			'id' => 'api_debugger-token_type'
			        		));
		        		?>
	        		</div>

	        		<div id="wrapper-input-payload" style="display: none;">
		        		<?php
			        		echo $this->Form->input('ApiDebugger.payload', array(
			        			'label' => __('Payload data'),
			        			'type' => 'textarea',
			        			'class' => 'form-control',
			        			'div' => array(
			        				'class' => 'form-group'
		        				),
			        			'id' => 'api_debugger-payload',
			        		));
			    		?>
		    		</div>

	        		<div id="wrapper-input-result_type" style="display: none;">
		        		<?php
			        		echo $this->Form->input('ApiDebugger.result_type', array(
			        			'label' => __('Result type'),
			        			'type' => 'select',
			        			'options' => array(
			        				1 => __('JSON'),
			        				2 => __('PHP array')
		        				),
			        			'class' => 'form-control',
			        			'div' => array(
			        				'class' => 'form-group'
		        				),
			        			'id' => 'api_debugger-result_type'
			        		));
		        		?>
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
		        			'id' => 'api_debugger-request_url',
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

        <div class="clearfix" id="wrapper-result">

			<div class="clearfix" id="wrapper-result-get_token">

			</div>

			<div class="clearfix" id="wrapper-result-get_poll">

			</div>

			<div class="clearfix" id="wrapper-result-save_poll">

			</div>
        </div>

    </div>
</div>

<style>
	.mono, textarea.mono {
  		/*border:1px solid #999999;*/
  		font-family:Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New, monospace;
	}
</style>

<script>
	$(document).ready(function() {

		var api_key 	= '';
		var api_secret 	= '';
		var token 		= '';
		var token_type  = '';

		var data = '';


		$(document).on('change', '#api_debugger-function', function() {


			$('#wrapper-input-api_key').hide();
			$('#wrapper-input-api_secret').hide();
			$('#wrapper-input-token').hide();
			$('#wrapper-input-token_type').hide();
			$('#wrapper-input-payload').hide();

			$('#wrapper-input-api_key').val('');
			$('#wrapper-input-api_secret').val('');
			$('#wrapper-input-token').val('');
			$('#wrapper-input-token_type').val('');
			$('#wrapper-input-payload').val('');


			var selection = $(this).val();
			if(selection == '') {
				return false;
			}

			if(selection == 'getToken') {
				$('#wrapper-input-api_key').show();
				$('#wrapper-input-api_secret').show();
				$('#wrapper-input-token').hide();
				$('#wrapper-input-token_type').show();
				$('#wrapper-input-payload').hide();
			}

			if(selection == 'getPoll') {
				$('#wrapper-input-api_key').show();
				$('#wrapper-input-api_secret').hide();
				$('#wrapper-input-token').show();
				$('#wrapper-input-token_type').hide();
				$('#wrapper-input-payload').hide();
			}

			if(selection == 'savePoll') {
				$('#wrapper-input-api_key').show();
				$('#wrapper-input-api_secret').hide();
				$('#wrapper-input-token').show();
				$('#wrapper-input-token_type').hide();
				$('#wrapper-input-payload').show();
			}

		});


		$(document).on('click', '#trigger-form-submit', function() {

        	$('#api_debugger-request_url').val('');
        	$('#api_debugger-request_result').val('');

			var selected_function = $('#api_debugger-function').val();

			if(selected_function == '') {
				return false;
			}

			api_key 	= $('#api_debugger-api_key').val();
			api_secret 	= $('#api_debugger-api_secret').val();
			token 		= $('#api_debugger-token').val();
			token_type  = $('#api_debugger-token_type').val();

			// prepare "payload" from debugger
			data = '';

	        $.ajax({
	            url: '/ApiDebugger/prepareDebuggerCall',
	            data: {
	                "selected_function":   selected_function,
	                "api_key"      : api_key,
	                "api_secret"    : api_secret,
	                "token"  : token,
	                "token_type"  : token_type
	            },
	            dataType: 'json',

	            success: function(result) {

	                if(selected_function == 'getToken') {
	                	$('#api_debugger-request_url').val(result.request_url);
	                	var result_str = JSON.stringify(JSON.parse(result.request_result), null, 4); // spacing level = 4
	                	$('#api_debugger-request_result').val(result_str);
	                }

	                if(selected_function == 'getPoll') {
	                	$('#api_debugger-request_url').val(result.request_url);
	                	var result_str = JSON.stringify(JSON.parse(result.request_result), null, 4); // spacing level = 4
	                	$('#api_debugger-request_result').val(result_str);
	                }

	                if(selected_function == 'savePoll') {
	                	loadResultSavePoll();
	                }

	                return false;
	            }
	        });

	        return false;
		});


		$(document).on('click', '#trigger-result-convert-array', function() {

        	var result_string = $('#api_debugger-request_result').val();
        	console.log(result_string);
        	return false;

		});


		$(document).on('click', '#trigger-form-reset', function() {
			
		});

	});

	function loadResultGetToken() {
		console.log('load result');
	}

	function loadResultGetPoll() {
		console.log('load result');
	}

	function loadResultsavePoll() {
		console.log('load result');
	}
</script>