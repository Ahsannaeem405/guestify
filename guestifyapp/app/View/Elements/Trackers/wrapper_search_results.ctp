<?php $highlight_formatter_user = array('format' => '<span class="highlight-result-user">\1</span>'); ?>
<?php $highlight_formatter_account = array('format' => '<span class="highlight-result-account">\1</span>'); ?>


<?php if(isset($search_results)) { ?>

	<?php if(isset($search_results['users']) && !empty($search_results['users'])) { ?>
		
    	<?php 
    		# get the results count
    		$results_count = 0;
        	foreach($search_results['users'] as $user) {
				$results_count++;
			}
		?>

		<div class="scrollable">
			<p class="lead">
				<?php echo __('Overall results', true); ?>: <strong><?php echo $search_results['count']; ?></strong> 
				<?php if($results_count > 10) { ?>
					<span class="label label-info pull-right"><small><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> <?php echo __('More than 10 results! Please refine your search!', true); ?></small></span>
				<?php } ?>
			</p>
			<div class="clearfix"></div>
		    <table id="recipient-search-result-table" class="table table-striped">
		        <thead>
		            <tr>
		                <th>Id</th>
		                <th>Name</th>
		                <th>&nbsp;</th>
		            </tr>
		        </thead>
		        <tbody>
		        	<?php # add a notice row when more than 10 results have been found ?>

					<?php # show the 10 first results of the search (max 11 will be contained in the results) ?>
	                <?php $results_number = 0; ?>
	                <?php foreach($search_results['users'] as $user) { ?>
	                	<?php $results_number++; ?>
	                	<?php if($results_number > 10) { continue; } ?>
		                <tr class="recipient-search-result-entry">
		                    <td>
		                        <?php echo $this->Text->highlight($user['User']['id'], $search_term, $highlight_formatter_user); ?> 
		                    </td>
		                    <td>
		                    	<?php echo $user['User']['gender_label']; ?> 
		                    	<?php echo $this->Text->highlight($user['User']['firstname'], $search_term, $highlight_formatter_user); ?> 
		                    	<?php echo $this->Text->highlight($user['User']['lastname'], $search_term, $highlight_formatter_user); ?> | 
		                    	<?php echo $this->Text->highlight($user['User']['email'], $search_term, $highlight_formatter_user); ?>
		                    	<br />
		                        ID: <?php echo $user['User']['id']; ?> | 
		                        <?php echo $this->Text->highlight($user['Account']['company_name'], $search_term, $highlight_formatter_account); ?> | 
		                    </td>
		                    <td class="recipient-search-result-actions">
		                        <?php echo $this->Html->link(__('Use', true), '#', array('id' => 'recipient-search-result-'.$user['User']['id'], 'class' => 'recipient-search-result-btn btn btn-sm btn-info')); ?>
		                    </td>
		                </tr>
		            <?php } ?>
		        </tbody>
		    </table>
		</div>
	<?php } else { ?>
		<div class="placeholderbox">
			<?php echo __('No results!', true); ?>
		</div>
	<?php } ?>		
<?php } else { ?>
	<div class="placeholderbox">
		<?php echo __('Please enter your search!', true); ?>
	</div>
<?php } ?>
