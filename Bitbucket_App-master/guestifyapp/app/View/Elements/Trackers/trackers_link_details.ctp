<?php if(isset($linktracker_details)) { ?>

	<div class="clearfix">

        <dl>
            <dt><?php echo __('ID', true); ?></dt>
            <dd>
                <?php echo $linktracker_details['TrackersLink']['id']; ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Tracker ID', true); ?></dt>
            <dd>
                <?php echo $linktracker_details['TrackersLink']['tracker_id']; ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Email ID', true); ?></dt>
            <dd>
                <?php echo $linktracker_details['TrackersLink']['email_id']; ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Link ID', true); ?></dt>
            <dd>
                <?php echo $linktracker_details['TrackersLink']['link_id']; ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Tracker-String', true); ?></dt>
            <dd>
                <?php echo $linktracker_details['TrackersLink']['tracker_string']; ?>
                &nbsp;
            </dd>
            <dt><?php echo __('URL', true); ?></dt>
            <dd>
                <?php echo $linktracker_details['TrackersLink']['url']; ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Status', true); ?></dt>
            <dd>
                <span class="label label-<?php echo $tracking_link_statuses_labels[$linktracker_details['TrackersLink']['status']]; ?>"><?php echo $tracking_link_statuses[$linktracker_details['TrackersLink']['status']]; ?></span>
                &nbsp;
            </dd>

            <hr/>

            <dt><?php echo __('First visit', true); ?></dt>
            <dd>
                <?php if(!empty($linktracker_details['TrackersLink']['first_visit'])) { ?>
                	<?php echo $this->Time->format($formats['datetime'], $linktracker_details['TrackersLink']['first_visit']); ?> UTC
            	<?php } else { ?>
            		<?php echo __('not opened yet', true); ?>
            	<?php } ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Last visit', true); ?></dt>
            <dd>
                <?php if(!empty($linktracker_details['TrackersLink']['last_visit'])) { ?>
                	<?php echo $this->Time->format($formats['datetime'], $linktracker_details['TrackersLink']['last_visit']); ?> UTC
            	<?php } else { ?>
            		<?php echo __('not opened yet', true); ?>
            	<?php } ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Visit count', true); ?></dt>
            <dd>
                <?php echo $linktracker_details['TrackersLink']['visit_count']; ?>
                &nbsp;
            </dd>

            <hr/>

            <dt><?php echo __('IP', true); ?></dt>
            <dd>
                <?php if(!empty($linktracker_details['TrackersLink']['ip'])) { ?>
                    <?php echo $linktracker_details['TrackersLink']['ip']; ?>
                <?php } else { ?>
                    <i><?php echo __('not opened yet', true); ?></i>
                <?php } ?>
                &nbsp;
            </dd>
            <dt><?php echo __('User agent', true); ?></dt>
            <dd>
                <?php if(!empty($linktracker_details['TrackersLink']['user_agent'])) { ?>
                    <?php echo $linktracker_details['TrackersLink']['user_agent']; ?>
                <?php } else { ?>
                    <i><?php echo __('not opened yet', true); ?></i>
                <?php } ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Browser language', true); ?></dt>
            <dd>
                <?php if(!empty($linktracker_details['TrackersLink']['lang'])) { ?>
                    <?php echo $linktracker_details['TrackersLink']['lang']; ?>
                <?php } else { ?>
                    <i><?php echo __('not opened yet', true); ?></i>
                <?php } ?>
                &nbsp;
            </dd>

            <hr>
            
            <dt><?php echo __('Created', true); ?></dt>
            <dd>
                <?php echo $this->Time->format($formats['datetime'], $linktracker_details['TrackersLink']['created']); ?> UTC
                &nbsp;
            </dd>
            <dt><?php echo __('Modified', true); ?></dt>
            <dd>
                <?php echo $this->Time->format($formats['datetime'], $linktracker_details['TrackersLink']['modified']); ?> UTC
                &nbsp;
            </dd>
        </dl>

	</div>

<?php } ?>
