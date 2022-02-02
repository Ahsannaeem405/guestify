<li class="list-group-item">
	<div class="creator-trigger-question-drag">
	    <span class="creator-trigger-question-edit" id="creator-trigger-question-edit-<?php echo $question['id']; ?>">
	    	<?php
	    		if(!empty($question['question_'.$locale])) {
	    			echo $question['question_'.$locale];
	    		} else {
	    			echo __('Click here to edit...', true);
	    		}
			?>
    	</span>
	    <input class="creator-input-question-edit" id="creator-input-question-edit-<?php echo $question['id']; ?>" type="text" placeholder="Enter name of group..." style="display: none;"/>
	    <div class="btn-group pull-right" role="group">
	        <button type="button" class="btn btn-danger btn-xs creator-trigger-question-delete" id="creator-trigger-question-delete-<?php echo $question['id']; ?>">
	        	<span class="glyphicon glyphicon-remove"></span>
        	</button>
	    </div>
    </div>
</li> 
