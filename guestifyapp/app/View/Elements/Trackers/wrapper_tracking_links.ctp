<?php if(!empty($tracking_links)) { ?>
	<div class="panel panel-default">
	    <div class="panel-body">
	        <h4><?php echo __('Tracking links', true); ?> (<?php echo count($tracking_links); ?>)</h4>
	        <table class="table table-striped">
	            <thead>
	                <tr>
	                    <th><?php echo __('ID', true); ?></th>
	                    <th><?php echo __('URL', true); ?></th>
	                    <th><?php echo __('Status', true); ?></th>
	                    <th><?php echo __('Actions', true); ?></th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach($tracking_links as $link) { ?>
	                    <tr id="wrapper-tracking_links-row-<?php echo $link['TrackersLink']['id']; ?>">
	                        <?php echo $this->element('Trackers/wrapper_tracking_links_row', array('link' => $link)); ?>
	                    </tr>
	                <?php } ?>
	            </tbody>

	        </table>

	    </div>
	</div>
<?php } ?> 
