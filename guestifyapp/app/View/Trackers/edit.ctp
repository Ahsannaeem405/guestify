<?php
    $this->set('title_for_layout', __('Tracker details', true).' - '.$tracker['Tracker']['id']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Trackers', true), array('controller' => 'trackers', 'action' => 'index_system', $tracker['Tracker']['type']), array('escape' => false));
    $this->Html->addCrumb(__('Tracker', true) . ' - ' . $tracker['Tracker']['email_id']);
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $tracker['Tracker']['id']), array('class' => 'btn btn-info')); ?>
    <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $tracker['Tracker']['id']), array('class' => 'btn btn-danger standard-delete')); ?>
</div>

<h2><?php echo __('Tracker', true); ?> - #<?php echo $tracker['Tracker']['id']; ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <?php echo $this->Form->create('Tracker', array('url' => $this->here)); ?>
                <div class="panel-body">
                    <h4><?php echo __('General information', true); ?></h4>
                    <?php
                        echo $this->Form->input('Tracker.type', array(
                            'label' => __('Type', true),
                            'type' => 'select',
                            'options' => $options_tracker_types,
                            'class' => 'form-control'
                        ));
                        echo $this->Form->input('Tracker.recipient_email', array(
                            'label' => __('Email', true),
                            'type' => 'text',
                            'class' => 'form-control'
                        ));
                        echo $this->Form->input('Tracker.email_id', array(
                            'label' => __('Email ID', true),
                            'type' => 'text',
                            'class' => 'form-control'
                        ));
                        echo $this->Form->input('Tracker.campaign_id', array(
                            'label' => __('Campaign ID', true),
                            'type' => 'text',
                            'class' => 'form-control'
                        ));
                        echo $this->Form->input('Tracker.sender_email', array(
                            'label' => __('Sent from', true),
                            'type' => 'text',
                            'class' => 'form-control'
                        ));
                    ?>
                </div>

                <hr />

                <?php echo $this->Form->submit(__('Save', true), array('class' => 'btn btn-success')); ?>

            <?php echo $this->Form->end(); ?>
        </div>

        <hr />

        <?php if($recipient && !empty($recipient)) { ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4><?php echo __('Recipient information', true); ?></h4>
                    <?php if(isset($recipient['User'])) { ?>
                        <?php echo $this->element('Trackers/recipient_user'); ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <hr />

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
                                <tr>
                                    <td>
                                        <?php echo $link['TrackersLink']['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $link['TrackersLink']['url']; ?>
                                    </td>
                                    <td>
                                        <span class="label label-<?php echo $tracking_link_statuses_labels[$link['TrackersLink']['status']]; ?>">
                                            <?php echo $tracking_link_statuses[$link['TrackersLink']['status']]; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="glyphicon glyphicon-cog"></span>  <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <?php echo $this->Html->link(__('Show details', true), '#', array('id' => 'trackers-link-show-details-'.$link['TrackersLink']['id'], 'class' => 'trackers-link-show-details')); ?>
                                                </li>
                                                <?php /*
                                                <li>
                                                    <?php echo $this->Html->link(__('Edit', true), '#', array('id' => 'trackers-link-edit-details-'.$link['TrackersLink']['id'], 'class' => 'trackers-link-edit-details')); ?>
                                                </li>
                                                <li>
                                                    <?php echo $this->Html->link(__('Reset', true), '#', array('id' => 'trackers-link-reset-'.$link['TrackersLink']['id'], 'class' => 'trackers-link-reset')); ?>
                                                </li>
                                                */ ?>
                                                <li class="divider"></li>
                                                <li>
                                                    <?php echo $this->Html->link(__('Delete', true), array('action' => 'deleteLink', $link['TrackersLink']['id']), array('class' => 'standard-delete')); ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>

                </div>
            </div>
        <?php } ?>
    </div>

    <div class="col-xs-5">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4><?php echo __('Opening Information', true); ?></h4>

                <div class="clearfix text-center">
                    <h1><span class="label label-<?php echo $statuses_labels[$tracker['Tracker']['status']]; ?>"><?php echo $statuses[$tracker['Tracker']['status']]; ?></span></h1>

                    <?php if(!empty($tracker['Tracker']['first_opened'])) { ?>
                        <h4><span class="label label-info"><?php echo $tracker['Tracker']['open_count']; ?>x <?php echo __('opened', true); ?></span></h4>
                    <?php } ?>
                </div>

                <div class="clearfix">
                    <dl>
                        <dt><?php echo __('Email sent at', true); ?></dt>
                        <dd>
                            <?php echo $this->Time->format($formats['datetime'], $tracker['Tracker']['created']); ?> UTC
                            &nbsp;
                        </dd>

                        <?php if(!empty($tracker['Tracker']['first_opened'])) { ?>
                            <dt><?php echo __('Opened at', true); ?></dt>
                            <dd>
                                <?php echo $this->Time->format($formats['datetime'], $tracker['Tracker']['first_opened']); ?> UTC
                            </dd>

                            <dt><?php echo __('Time to open', true); ?></dt>
                            <dd>
                                <?php echo $this->Tracker->getNiceDuration($tracker['Tracker']['created'], $tracker['Tracker']['first_opened']); ?>
                            </dd>
                        <?php } ?>

                        <?php if(!empty($tracker['Tracker']['user_agent'])) { ?>
                            <dt><?php echo __('User agent', true); ?></dt>
                            <dd>
                                <?php echo $tracker['Tracker']['user_agent']; ?>
                            </dd>
                            <dt><?php echo __('IP', true); ?></dt>
                            <dd>
                                <?php echo $tracker['Tracker']['ip']; ?>
                            </dd>
                        <?php } ?>

                    </dl>
                </div>
            </div>
        </div>



        <?php if(isset($email_log) && !empty($email_log)) { ?>

            <hr />

            <div class="panel panel-default">
                <div class="panel-body">
                    <h4><?php echo __('Mailserver Information', true); ?></h4>

                    <div class="clearfix text-center">
                        <h1>
                            <?php $email_log['LogsEmail']['notification_type'] = 'Delivery'; ?>
                            <?php if($email_log['LogsEmail']['notification_type'] == 'Delivery') { ?>
                                <span class="label label-success"><?php echo __('Delivered', true); ?></span>
                            <?php } elseif($email_log['LogsEmail']['notification_type'] == 'Delivery') { ?>
                                <span class="label label-danger"><?php echo __('Bounce', true); ?></span>
                            <?php } elseif($email_log['LogsEmail']['notification_type'] == 'Complaint') { ?>
                                <span class="label label-warning"><?php echo __('Bounce', true); ?></span>
                            <?php } ?>
                        </h1>
                    </div>

                    <?php if($email_log['LogsEmail']['notification_type'] == 'Delivery') { ?>
                        <?php $data_origin = json_decode($email_log['LogsEmail']['data_origin'], true); ?>
                        <?php $mail = $data_origin['Message']['mail']; ?>
                        <?php $delivery = $data_origin['Message']['delivery']; ?>
                        
                        <div class="clearfix">
                            <h4><?php echo __('Sending MTA', true); ?></h4>
                            <dl>
                                <dt><?php echo __('Source', true); ?></dt>
                                <dd>
                                    <?php echo $mail['source']; ?>
                                </dd>
                                <dt><?php echo __('Message ID', true); ?></dt>
                                <dd>
                                    <?php echo $mail['messageId']; ?>
                                </dd>
                                <dt><?php echo __('Destination', true); ?></dt>
                                <dd>
                                    <?php echo $mail['destination'][0]; ?>
                                </dd>
                            </dl>

                            <hr />

                            <h4><?php echo __('Receiving MTA', true); ?></h4>
                            <dl>
                                <dt><?php echo __('Timestamp', true); ?></dt>
                                <dd>
                                    <?php echo $delivery['timestamp']; ?>
                                </dd>
                                <dt><?php echo __('Recipient(s)', true); ?></dt>
                                <dd>
                                    <?php echo $delivery['recipients'][0]; ?>
                                </dd>
                                <dt><?php echo __('Processing time', true); ?> (ms)</dt>
                                <dd>
                                    <?php echo $delivery['processingTimeMillis']; ?>
                                </dd>
                                <dt><?php echo __('SMTP-Response', true); ?></dt>
                                <dd>
                                    <?php echo $delivery['smtpResponse']; ?>
                                </dd>
                                <dt><?php echo __('Reporting MTA', true); ?></dt>
                                <dd>
                                    <?php echo $delivery['reportingMTA']; ?>
                                </dd>
                            </dl>
                        </div>
                    <?php } ?>

                    <?php echo $this->Html->link(__('Show original data', true), '#', array('class' => 'toggle-data-origin btn btn-default')); ?>

                    <div class="clearfix">&nbsp;</div>

                    <div id="wrapper-data-origin" class="clearfix" style="display: none;">
                        <pre>
                            <?php print_r(json_decode($email_log['LogsEmail']['data_origin'], true)); ?>
                        </pre>
                    </div>
                </div>
            </dl>
        <?php } ?>

    </div>
</div>


<?php echo $this->element('Widgets/standard_delete/main'); ?>

<script>
    
    $(document).ready(function() {

        $(document).on('click', '.toggle-data-origin', function() {
            $('#wrapper-data-origin').slideToggle('fast', function() {
                return false;
            });
            return false;
        });
        
        var linktracker_id = '';

        $(document).on('click', '.trackers-link-show-details', function() {
            linktracker_id = $(this).attr('id').split('-').pop();
            $('#modal-spinner-linktracker').show();
            $('#modal-linktracker-details').modal('show');
            loadLinktrackerDetails(linktracker_id);
            return false;
        });

    });

    function loadLinktrackerDetails(linktracker_id) {

        $('#wrapper-linktracker-details').fadeTo('fast', 0, function() {
            $('#wrapper-linktracker-details').load('/trackers/loadLinktrackerDetails/'+linktracker_id, function() {
                $('#modal-spinner-linktracker').hide();
                $('#wrapper-linktracker-details').fadeTo('fast', 1, function() {
                    return false;
                });
                return false;
            });
            return false;
        });

        return;

    }

</script>


<!-- mark guest/answerset invalid -->
<div id="modal-linktracker-details" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('LinkTracker details', true); ?></h3>
            </div>

            <div class="modal-body">

                <div id="wrapper-linktracker-details">
                    <?php echo $this->element('Trackers/trackers_link_details'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-linktracker" style="display: none;"/>
                <button class="btn btn-default" id="mark-linktracker-close" data-dismiss="modal" aria-hidden="true"><?php echo __('Close', true); ?></button>
            </div>
        </div>
    </div>
</div>