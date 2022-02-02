/**
* on change in the selector of the poll, 
* sent the poll id to determine if poll is limited or unlimited,
* if limited disable the selector for style and set it to standard,
* else enable the selector and set to nothing
*/
$(document).ready(function(){
	$("#poll_id").change(function(){
		if(!$("#poll_id").val()){
	 		$("#style option").eq(0).prop("selected", true);
	 		$("#style").prop("disabled", false);
	 	} else{
	 		var poll_id = $("#poll_id").val();
	 		$.ajax({
	 			url: '/widgets/add',
	 			data: {
	                "poll_id"    :   poll_id
	            },
	            dataType: 'json',
	            success: function(result){
	            	if(result == 'limited'){
	            		$("#style option").eq(1).prop("selected", true);
	            		$("#style").prop("disabled", "disabled");
	            	} else{
	            		$("#style option").eq(0).prop("selected", true);
	            		$("#style").prop("disabled", false);
	            	}
	                return false;
	            }
	 		});		 		
	 	}
	});	
});