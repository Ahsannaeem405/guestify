<div class="panel panel-info creator-group">
    <div class="panel-heading creator-trigger-group-drag">
        <span class="creator-trigger-group-edit-title" id="creator-trigger-group-edit-title-<?php echo $group['id']; ?>">
	    	<?php
	    		if(!empty($group['name_'.$locale])) {
	    			echo $group['name_'.$locale];
	    		} else {
	    			echo __('Click here to edit...', true);
	    		}
			?>
    	</span>
    	<input class="creator-input-group-edit-title" id="creator-input-group-edit-title-<?php echo $group['id']; ?>" type="text" value="<?php echo $group['name_'.$locale]; ?>" style="display: none;" />

        <div class="btn-toolbar pull-right clearfix">
            <?php 
                echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>', '#', array(
                    'class' => 'btn btn-xs btn-success creator-trigger-group-add-question', 
                    'id' => 'creator-trigger-group-add-question-'.$group['id'],
                    'escape' => false
                )); 
                echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', '#', array(
                    'class' => 'btn btn-xs btn-danger creator-trigger-group-delete', 
                    'id' => 'creator-trigger-group-delete-'.$group['id'],
                    'escape' => false
                ));
                echo $this->Html->link('<span class="glyphicon glyphicon-chevron-up"></span>', '#', array(
                    'class' => 'btn btn-xs btn-info creator-trigger-group-hide', 
                    'id' => 'creator-trigger-group-hide-'.$group['id'],
                    'escape' => false
                ));
            ?>
        </div>
    </div>
    <div class="panel-body">
        <?php # begin questions ?>
        <ul class="list-group question-wrapper">
            <?php if(isset($group['DraftsGroupsQuestion']) && !empty($group['DraftsGroupsQuestion'])) { ?>
                <?php foreach($group['DraftsGroupsQuestion'] as $question) { ?>
                    <?php echo $this->element('Drafts/Creator/question', array('question' => $question)); ?>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>    
