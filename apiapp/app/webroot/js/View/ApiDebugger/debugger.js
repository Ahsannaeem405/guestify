$(document).ready(function() {

	var api_key 	= '';
	var api_secret 	= '';
	var token 		= '';
	var locale  	= '';
	var token_type  = '';

	var data = '';


	$(document).on('click', '#trigger-add-payload-line', function() {

		var trigger = $(this);
		var payload_line_container = $('#wrapper-input-payload').find('div.payload-line:last').clone();

		payload_line_container.find('a.trigger-remove-payload-line').css('display', 'block');
		payload_line_container.find('input.payload_key').val('');
		payload_line_container.find('input.payload_value').val('');
		$('#wrapper-input-payload').append(payload_line_container);

		reorderPayloadLines();

		return false;
	});


	function reorderPayloadLines() {

		var n = 1;

		$('div.payload-line').each(function(key, container) {

			$(this).find('input.payload_key').attr('id', 'api_debugger-payload_key-'+n);
			$(this).find('input.payload_key').attr('name', 'data[ApiDebugger][payload]['+n+'][key]');

			$(this).find('input.payload_value').attr('id', 'api_debugger-payload_value-'+n);
			$(this).find('input.payload_value').attr('name', 'data[ApiDebugger][payload]['+n+'][value]');

			n++;
		});

		return;
	}


	$(document).on('click', '.trigger-remove-payload-line', function() {
		var payload_line_container = $(this).closest('div.payload-line').remove();
		reorderPayloadLines();
		return false;
	});


	$(document).on('change', '#api_debugger-function', function() {

		$('#wrapper-input-api_key').hide();
		$('#wrapper-input-api_secret').hide();
		$('#wrapper-input-token').hide();
		$('#wrapper-input-locale').hide();
		$('#wrapper-input-token_type').hide();
		$('#wrapper-input-payload').hide();
		$('#wrapper-input-payload-add').hide();


		$('#wrapper-input-api_key').val('');
		$('#wrapper-input-api_secret').val('');
		$('#wrapper-input-token').val('');
		$('#wrapper-input-locale').val('eng');
		$('#wrapper-input-token_type').val('');
		
		$('input.payload_key').val('');
		$('input.payload_value').val('');

		var selection = $(this).val();
		if(selection == '') {
			return false;
		}

		if(selection == 'getToken') {
			$('#wrapper-input-api_key').show();
			$('#wrapper-input-api_secret').show();
			$('#wrapper-input-token').hide();
			$('#wrapper-input-locale').hide();
			$('#wrapper-input-token_type').show();
			$('#wrapper-input-payload').hide();
			$('#wrapper-input-payload-add').hide();
		}

		if(selection == 'getPoll') {
			$('#wrapper-input-api_key').show();
			$('#wrapper-input-api_secret').hide();
			
			$('#wrapper-input-token').val('');
			$('#wrapper-input-token').show();
			
			$('#wrapper-input-locale').show();
			$('#wrapper-input-token_type').hide();
			$('#wrapper-input-payload').hide();
			$('#wrapper-input-payload-add').hide();
		}

		if(selection == 'savePoll') {
			$('#wrapper-input-api_key').show();
			$('#wrapper-input-api_secret').hide();
			
			$('#wrapper-input-token').val('');
			$('#wrapper-input-token').show();
			
			$('#wrapper-input-locale').hide();
			$('#wrapper-input-token_type').hide();
			$('#wrapper-input-payload').show();
			$('#wrapper-input-payload-add').show();
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
		locale 		= $('#api_debugger-locale').val();
		token_type  = $('#api_debugger-token_type').val();

		// prepare "payload" from debugger
		// data = encodeURIComponent($('#wrapper-input-payload').serialize());
		data = encodeURIComponent($("#wrapper-input-payload").find("input").serialize());

        $.ajax({
            url: '/ApiDebugger/prepareDebuggerCall',
            data: {
                "selected_function":   selected_function,
                "api_key": 		api_key,
                "api_secret": 	api_secret,
                "token": 		token,
                "locale": 		locale,
                "token_type": 	token_type,
                "payload": 		data
            },
            dataType: 'json',

            success: function(result) {

                if(selected_function == 'getToken') {
                	
                	var res_json = JSON.parse(result.request_result);
                	var code = res_json.code;

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
                	$('#api_debugger-request_url').val(result.request_url);
                	var result_str = JSON.stringify(JSON.parse(result.request_result), null, 4); // spacing level = 4
                	$('#api_debugger-request_result').val(result_str);
                }

                return false;
            }
        });

        return false;
	});


	$(document).on('click', '#trigger-result-convert-array', function() {
    	var result_string = $('#api_debugger-request_result').val();
    	return false;
	});


	$(document).on('click', '#trigger-form-reset', function() {
		
	});

});