<?php # modal edit recipient ?>
<div id="modal-tracker-recipient-edit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Edit recipient', true); ?></h3>
            </div>

            <div class="modal-body">
                <div class="clearfix">
                    <?php
                        echo $this->Form->input('Tracker.recipient_search', array(
                            'label' => __('Type your search', true),
                            'placeholder' => __('ID, Lastname, Email, ...'),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-tracker-recipient-edit-recipient_search'
                        ));
                    ?>
                </div>

                <hr />

                <div class="clearfix">
                    <strong><?php echo __('Current recipient', true); ?></strong> <br />
                    <?php echo $recipient['User']['gender_label']; ?> <?php echo $recipient['User']['firstname'].' '.$recipient['User']['lastname']; ?> <br />
                    ID: <?php echo $recipient['User']['id']; ?> | <?php echo $recipient['Account']['company_name']; ?> | <?php echo $recipient['User']['email']; ?>
                </div>

                <hr />
                
                <div id="modal-wrapper-recipient-search-results">
                    <?php echo $this->element('Trackers/wrapper_search_results'); ?>
                </div>
            </div>

            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-tracker-recipient-edit-spinner" style="display: none;"/>
                <button class="btn btn-default" id="modal-tracker-recipient-edit-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
            </div>

        </div>
    </div>
</div> 


<?php # modal edit opening information ?>
<div id="modal-tracker-opening_information-edit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Opening information', true); ?></h3>
            </div>

            <div class="modal-body">
                <?php
                    echo $this->Form->input('Tracker.status', array(
                        'label' => __('Status', true),
                        'type' => 'select',
                        'options' => $statuses,
                        'class' => 'form-control',
                        'id' => 'modal-tracker-opening_information-edit-status'
                    ));
                    echo $this->Form->input('Tracker.open_count', array(
                        'label' => __('Open count', true),
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'modal-tracker-opening_information-edit-open_count'
                    ));
                    echo $this->Form->input('Tracker.created', array(
                        'label' => __('Created', true),
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'modal-tracker-opening_information-edit-created'
                    ));
                    echo $this->Form->input('Tracker.first_opened', array(
                        'label' => __('First opened', true),
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'modal-tracker-opening_information-edit-first_opened'
                    ));
                    echo $this->Form->input('Tracker.user_agent', array(
                        'label' => __('User agent', true),
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'modal-tracker-opening_information-edit-user_agent'
                    ));
                    echo $this->Form->input('Tracker.ip', array(
                        'label' => __('IP', true),
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'modal-tracker-opening_information-edit-ip'
                    ));
                ?>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-tracker-opening_information-edit-spinner" style="display: none;"/>
                <button class="btn btn-default" id="modal-tracker-opening_information-edit-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="modal-tracker-opening_information-edit-confirm" type="button"><?php echo __('Save', true); ?></button>
            </div>
        </div>
    </div>
</div>


<?php # modal link tracker details ?>
<div id="modal-trackers_link-edit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Link tracker information', true); ?></h3>
            </div>

            <div class="modal-body">
                <fieldset>
                    <legend><?php echo __('Tracker details', true); ?></legend>
                    <?php
                        echo $this->Form->input('TrackersLink.tracker_id', array(
                            'label' => __('Tracker ID', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-tracker_id'
                        ));
                        echo $this->Form->input('TrackersLink.email_id', array(
                            'label' => __('Email ID', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-email_id'
                        ));
                        echo $this->Form->input('TrackersLink.link_id', array(
                            'label' => __('Link ID', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-link_id'
                        ));
                        echo $this->Form->input('TrackersLink.tracker_string', array(
                            'label' => __('Tracker String', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-tracker_string'
                        ));
                        echo $this->Form->input('TrackersLink.url', array(
                            'label' => __('URL', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-url'
                        ));
                        echo $this->Form->input('TrackersLink.status', array(
                            'label' => __('Status', true),
                            'type' => 'select',
                            'options' => $trackers_link_statuses,
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-status'
                        ));
                    ?>
                </fieldset>
                <hr />
                <fieldset>
                    <legend><?php echo __('Opening details', true); ?></legend>
                    <?php
                        echo $this->Form->input('TrackersLink.first_visit', array(
                            'label' => __('First visit', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-first_visit'
                        ));
                        echo $this->Form->input('TrackersLink.last_visit', array(
                            'label' => __('Last visit', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-last_visit'
                        ));
                        echo $this->Form->input('TrackersLink.visit_count', array(
                            'label' => __('Visit count', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-visit_count'
                        ));
                        echo $this->Form->input('TrackersLink.ip', array(
                            'label' => __('IP', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-ip'
                        ));
                        echo $this->Form->input('TrackersLink.user_agent', array(
                            'label' => __('User Agent', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-user_agent'
                        ));
                        echo $this->Form->input('TrackersLink.lang', array(
                            'label' => __('Browser language', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-lang'
                        ));
                    ?>
                </fieldset>
                <hr />
                <fieldset>
                    <legend><?php echo __('General information', true); ?></legend>
                    <?php
                        echo $this->Form->input('TrackersLink.created', array(
                            'label' => __('Created', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-created'
                        ));
                        echo $this->Form->input('TrackersLink.modified', array(
                            'label' => __('Modified', true),
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'modal-trackers_link-edit-modified'
                        ));
                    ?>
                </fieldset>
            </div>

            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-trackers_link-edit-spinner" style="display: none;"/>
                <button class="btn btn-default" id="modal-trackers_link-edit-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="modal-trackers_link-edit-confirm" type="button"><?php echo __('Save', true); ?></button>
            </div>
        </div>
    </div>
</div>



<?php # modal edit general information ?>
<div id="modal-tracker-general_information-edit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('General information', true); ?></h3>
            </div>

            <div class="modal-body">
                <?php
                    echo $this->Form->input('Tracker.type', array(
                        'label' => __('Type', true),
                        'type' => 'select',
                        'options' => $options_tracker_types,
                        'class' => 'form-control',
                        'id' => 'modal-tracker-general_information-edit-type'
                    ));
                    echo $this->Form->input('Tracker.recipient_email', array(
                        'label' => __('Email', true),
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'modal-tracker-general_information-edit-recipient_email'
                    ));
                    echo $this->Form->input('Tracker.email_id', array(
                        'label' => __('Email ID', true),
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'modal-tracker-general_information-edit-email_id'
                    ));
                    echo $this->Form->input('Tracker.campaign_id', array(
                        'label' => __('Campaign ID', true),
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'modal-tracker-general_information-edit-campaign_id'
                    ));
                    echo $this->Form->input('Tracker.sender_email', array(
                        'label' => __('Sent from', true),
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'modal-tracker-general_information-edit-sender_email'
                    ));
                ?>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-tracker-general_information-edit-spinner" style="display: none;"/>
                <button class="btn btn-default" id="modal-tracker-general_information-edit-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="modal-tracker-general_information-edit-confirm" type="button"><?php echo __('Save', true); ?></button>
            </div>
        </div>
    </div>
</div>


<!-- mark guest/answerset invalid -->
<div id="modal-trackers_link-details-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Tracking-link details', true); ?></h3>
            </div>

            <div class="modal-body">

                <div id="modal-wrapper-trackers_link-details">
                    <?php echo $this->element('Trackers/trackers_link_details'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-trackers_link-details-spinner" style="display: none;"/>
                <button class="btn btn-default" id="mark-trackers_link-details-close" data-dismiss="modal" aria-hidden="true"><?php echo __('Close', true); ?></button>
            </div>
        </div>
    </div>
</div> 
