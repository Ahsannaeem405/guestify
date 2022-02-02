<?php
    $this->set('title_for_layout', __('Tracker details', true).' - '.$tracker['Tracker']['id']);
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('Trackers', true), array('controller' => 'trackers', 'action' => 'index_system', $tracker['Tracker']['type']), array('escape' => false));
    $this->Html->addCrumb(__('Tracker', true) . ' - #' . $tracker['Tracker']['id']);

    echo $this->Html->script('View/Trackers/view.js');
    echo $this->Html->script('vendors/jquery.color/jquery.color.js');
?>

<span id="tracker-id" style="display: none;"><?php echo $tracker['Tracker']['id']; ?></span>

<style type="text/css">
    a.recipient-search-result-btn{ visibility: hidden;}
    tr.recipient-search-result-entry:hover a.recipient-search-result-btn{ visibility: visible;}

    span.highlight-result-user {
        background-color: red;
        color: white;
    }
    span.highlight-result-account {
        background-color: yellow;
        color: black;
    }
</style>

<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $tracker['Tracker']['id']), array('class' => 'btn btn-info')); ?>
    <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $tracker['Tracker']['id']), array('class' => 'btn btn-danger standard-delete')); ?>
</div>

<h2><?php echo __('Tracker', true); ?> - #<?php echo $tracker['Tracker']['id']; ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default" id="container-tracker-general-information">
            
            <div class="panel-body">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="glyphicon glyphicon-cog"></span>  <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <?php echo $this->Html->link(__('Edit', true), '#', array('id' => 'tracker-general_information-edit-'.$tracker['Tracker']['id'], 'class' => 'tracker-general_information-edit')); ?>
                        </li>
                    </ul>
                </div>

                <h4 class="clearfix"><?php echo __('General information', true); ?></h4>
                
                <div id="wrapper-tracker-general-information">
                    <?php echo $this->element('Trackers/wrapper_general_information'); ?>
                </div>
            </div>
        </div>

        <hr />

        <?php if($recipient && !empty($recipient)) { ?>
            <div class="panel panel-default" id="container-tracker-recipient">
                <div class="panel-body">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="glyphicon glyphicon-cog"></span>  <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <?php echo $this->Html->link(__('Edit', true), '#', array('id' => 'tracker-recipient-edit-'.$tracker['Tracker']['id'], 'class' => 'tracker-recipient-edit')); ?>
                            </li>
                        </ul>
                    </div>
                    <h4 class="clearfix"><?php echo __('Recipient information', true); ?></h4>
                    <?php if(isset($recipient['User'])) { ?>
                        <div id="wrapper-tracker-recipient">
                            <?php echo $this->element('Trackers/wrapper_tracker_recipient'); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <hr />

        <div id="wrapper-tracking_links">
            <?php echo $this->element('Trackers/wrapper_tracking_links'); ?>
        </div>
    </div>

    <div class="col-xs-5">
        <div class="panel panel-default" id="container-tracker-opening-information">
            <div class="panel-body">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="glyphicon glyphicon-cog"></span>  <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <?php echo $this->Html->link(__('Edit', true), '#', array('id' => 'tracker-opening-edit-'.$tracker['Tracker']['id'], 'class' => 'tracker-opening-edit')); ?>
                        </li>
                    </ul>
                </div>

                <h4 class="clearfix"><?php echo __('Opening Information', true); ?></h4>
                <div id="wrapper-tracker-opening-information">
                    <?php echo $this->element('Trackers/wrapper_opening_information'); ?>
                </div>

            </div>
        </div>

        
        <?php if(isset($email_log) && !empty($email_log)) { ?>
            <hr />
            <div class="panel panel-default" id="container-tracker-mailserver-information">
                <div class="panel-body">
                    <?php /*
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="glyphicon glyphicon-cog"></span>  <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <?php echo $this->Html->link(__('Edit', true), '#', array('id' => 'tracker-mailserver-edit-'.$tracker['Tracker']['id'], 'class' => 'tracker-mailserver-edit')); ?>
                            </li>
                        </ul>
                    </div>
                    */ ?>

                    <h4 class="clearfix"><?php echo __('Mailserver Information', true); ?></h4>
                    <div id="wrapper-tracker-mailserver-information">
                        <?php echo $this->element('Trackers/wrapper_mailserver_information'); ?>
                    </div>
                </div>
            </dl>
        <?php } ?>

    </div>
</div>


<?php echo $this->element('Widgets/standard_delete/main'); ?>
<?php echo $this->element('Trackers/modals_view'); ?>
