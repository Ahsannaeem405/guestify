<?php
    $this->set('title_for_layout', __('Dashboard', true));
    $this->Html->addCrumb(__('Home', true), '/');

    echo $this->Html->script('vendors/flot/jquery.flot');
    echo $this->Html->script('vendors/flot/jquery.flot.axislabels');
    echo $this->Html->script('vendors/flot/jquery.flot.time');
    echo $this->Html->script('vendors/flot/JUMFlot.min');
    echo $this->Html->script('vendors/flot/jquery.flot.pie.min.js');



    echo $this->Html->script('date');

    echo $this->Html->script('View/dashboard', false);
?>


<div class="clearfix">
    <h2>
        <?php echo __('Hello', true); ?> <?php echo User::get('firstname'); ?>!
        <div class="pull-right">
            <small class="text-white pull-left"><?php echo __('Dashboard', true); ?>&nbsp;</small>

            <?php if(!empty($polls_selectable) && (count($polls_selectable_plain) > 1)) { ?>
                <?php
                    echo $this->Form->input('Poll.id', array(
                        'label' => false,
                        'type' => 'select',
                        'options' => $polls_selectable,
                        'class' => 'form-control input-sm selector-poll_id',
                        // 'id' => 'selector-poll_id',
                        'div' => array('class' => 'form-group pull-right'),
                        'value' => $this->Session->read('Dashboard.selected_poll_id')
                    ));
                ?>
            <?php } ?>
        </div>
    </h2>

<?php if(isset($scorecard) && isset($poll) && !empty($poll)) { ?>
    <span id="selector-poll_id" class="hide"><?php echo $poll['Poll']['id']; ?></span>
    <!-- First row with line chart of 7 days -->
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="clearfix">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="clearfix">
                            <h3 class="pull-left"><?php echo __('Overall average last 7 days'); ?></h3>
                            <?php echo $this->Html->link(__('Go to last 30 day overview', true).' <span class="glyphicon glyphicon-arrow-right"></span>', array('controller' => 'polls', 'action' => 'showLast30', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-info pull-right', 'escape' => false)); ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <div class="clearfix">
                                    <?php echo $this->element('Dashboard/last_7_average'); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <div class="clearfix">
                                    <?php echo $this->element('Dashboard/last_7_days'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Second row with meta data for line chart of 7 days -->
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- BEGIN -->

                    <div class="clearfix">
                        <div class="score pull-right">
                            <div class="position_absolute">
                                <div class="gsi-background">
                                    <img src="/graphics/backgrounds/img-noise-361x370_darkblue.png" class="img-circle" width="100" />
                                    <div class="position_absolute">
                                        <?php echo $this->Label->GsiLabel(round($scorecard['last_7_average_overall']*(10/$max_scale), 1)); ?>
                                    </div>
                                    <p class="jumbo text-white text-center">
                                        <span><?php echo round($scorecard['last_7_average_overall']*(10/$max_scale), 1); ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <h3><?php echo __('7-Day Guest Satisfaction Index', true); ?></h3>
                    </div>
                    <hr />
                    <h3><?php echo __('Amount of guests and average scores of last 7 days', true); ?></h3>

                    <div class="clearfix">&nbsp;</div>

                    <div class="row">
                        <div class="col-md-1 col-xs-12">
                            <div class="score text-center">
                                <div class="clearfix">
                                    <small><?php echo __('Guests', true); ?></small>
                                    <p class="number">
                                        <?php echo $scorecard['last_7_guest_count']; ?>
                                    </p>
                                </div>
                                <hr />
                                <div class="clearfix">
                                    <small><?php echo __('Views', true); ?></small>
                                    <p class="number">
                                        <?php echo $scorecard['views']['last_7']; ?>
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-1 col-xs-12">
                            <div class="score text-center">
                                <small><?php echo __('Overall', true); ?></small>
                                <p class="number">
                                    <strong><?php echo $scorecard['last_7_average_overall']; ?></strong> /<?php echo $max_scale; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <?php if(isset($scorecard['last_7']['average_by_group'])) { ?>
                                <div class="clearfix">
                                    <?php foreach($scorecard['last_7']['average_by_group'] as $group_id => $rating) { ?>
                                        <div class="clearfix">
                                            <small><?php echo $grouplist[$group_id]; ?>&nbsp;</small>
                                            <?php
                                                $percentage = $rating/$max_scale*100;
                                                $class = 'danger';
                                                if($percentage > 33) {
                                                    $class = 'warning';
                                                }
                                                if($percentage > 66) {
                                                    $class = 'success';
                                                }
                                            ?>
                                            <div class="row">
                                                <div class="col-xs-8">
                                                    <div class="progress">
                                                      <div class="progress-bar progress-bar-<?php echo $class; ?>" role="progressbar" aria-valuenow="<?php echo  $rating/$max_scale*100; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo  $rating/$max_scale*100; ?>%;">
                                                        <span class="sr-only"><?php echo  $rating/$max_scale*100; ?>% Complete</span>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4"><span class="number"><strong><?php echo $rating; ?></strong> /<?php echo $max_scale; ?> </span></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-7 col-xs-12">
                            <?php echo $this->element('Dashboard/chart_last7days_donuts'); ?>
                        </div>
                    </div>

                    <!-- END -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="row">

                <?php if(isset($poll['Groups'])) { ?>

                        <?php $count = 0; ?>
                        <?php foreach($poll['Groups'] as $key => $group) { ?>
                            <div class="col-md-4 col-xs-12">
                                <?php $count++; ?>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h3><?php echo $group['Group']['name']; ?></h3>

                                        <div class="clearfix">
                                            <?php
                                                echo $this->element('Dashboard/chart_group', array(
                                                    #'questions' => $group['Questions'],
                                                    'group_id' => $group['Group']['id'],
                                                    'period' => 'week',
                                                    'option' => 'last_7'
                                                ));
                                            ?>
                                        </div>

                                        <p class="clearfix">&nbsp;</p>

                                        <div id="legend-container-<?php echo $group['Group']['id']; ?>"></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                <?php } ?>
            </div>

        </div>

    </div>

    <hr />
    <!-- All time satisfaction block for dashboard -->
    <div class="clearfix">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="clearfix">
                    <div class="score pull-right">
                        <div class="position_absolute">
                            <div class="gsi-background">
                                <img src="/graphics/backgrounds/img-noise-361x370_darkblue.png" class="img-circle" width="100" />

                                <div class="position_absolute">
                                    <?php echo $this->Label->GsiLabel(round($scorecard['average_overall']*(10/$max_scale), 1)); ?>
                                </div>

                                <p class="jumbo text-white text-center">
                                    <span><?php echo round($scorecard['average_overall']*(10/$max_scale), 1); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <h3><?php echo __('All time Guest Satisfaction Index', true); ?></h3>
                </div>
                <hr />

                <h3><?php echo __('Overall guests and scores', true); ?></h3>

                <div class="row">
                    <div class="col-xs-3">
                        <div class="score text-center">
                            <div class="clearfix">
                                <small><?php echo __('Guests', true); ?></small>
                                <p class="number">
                                    <?php echo $scorecard['guest_count_overall']; ?>
                                </p>
                            </div>
                            <hr />
                            <div class="clearfix">
                                <small><?php echo __('Views', true); ?></small>
                                <p class="number">
                                    <?php echo $scorecard['views']['overall']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="score text-center">
                            <small><?php echo __('Overall', true); ?></small>
                            <p class="number">
                                <strong><?php echo $scorecard['average_overall']; ?></strong> /<?php echo $max_scale; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <?php if(isset($scorecard['overall']['average_by_group'])) { ?>
                            <div class="clearfix">
                                <?php foreach($scorecard['overall']['average_by_group'] as $group_id => $rating) { ?>
                                    <div class="clearfix">
                                        <small><?php echo $grouplist[$group_id]; ?>&nbsp;</small>
                                        <?php
                                            $percentage = $rating/$max_scale*100;
                                            $class = 'danger';
                                            if($percentage > 33) {
                                                $class = 'warning';
                                            }
                                            if($percentage > 66) {
                                                $class = 'success';
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <div class="progress">
                                                  <div class="progress-bar progress-bar-<?php echo $class; ?>" role="progressbar" aria-valuenow="<?php echo  $rating/$max_scale*100; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo  $rating/$max_scale*100; ?>%;">
                                                    <span class="sr-only"><?php echo  $rating/$max_scale*100; ?>% Complete</span>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-4"><span class="number"><strong><?php echo $rating; ?></strong> /<?php echo $max_scale; ?> </span></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <hr />

                <?php # add overall guest types/visit times pie charts ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="col-xs-12">
                            <h3 class="text-center"><?php echo __('Guests visit time', true); ?></h3>
                            <?php $total_visit_time = $scorecard['overall_guests_evening'] + $scorecard['overall_guests_midday'] + $scorecard['overall_guests_morning']; ?>
                            <?php if($total_visit_time != 0) { ?>
                                <div class="text-center">
                                    <?php
                                        $percent_visit_evening = $scorecard['overall_guests_evening'] / $total_visit_time * 100;
                                        $percent_visit_midday = $scorecard['overall_guests_midday'] / $total_visit_time * 100;
                                        $percent_visit_morning = $scorecard['overall_guests_morning'] / $total_visit_time * 100;
                                    ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var data = [
                                                { label: "<?php echo __('Evening', true); ?>",  data: <?php echo $percent_visit_evening; ?>, color: "#4572A7"},
                                                { label: "<?php echo __('Midday', true); ?>",  data: <?php echo $percent_visit_midday; ?>, color: "#80699B"},
                                                { label: "<?php echo __('Morning', true); ?>",  data: <?php echo $percent_visit_morning; ?>, color: "#AA4643"},
                                            ];

                                            $.plot($("#chart_visit_time_overall"), data, {
                                                series: {
                                                    pie: {
                                                        innerRadius: 0.4,
                                                        show: true
                                                    }
                                                },
                                                legend: {
                                                    show: false
                                                }
                                            });
                                        });
                                    </script>
                                    <style>
                                        #chart_visit_time_overall { width: 100%; height: 250px; }
                                    </style>
                                    <div id="chart_visit_time_overall"></div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-xs-4">
                            <div class=" text-center">
                                <h3><?php echo $scorecard['overall_guests_evening']; ?></h3>
                                <small><?php echo __('Evening', true); ?></small>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class=" text-center">
                                <h3><?php echo $scorecard['overall_guests_midday']; ?></h3>
                                <small><?php echo __('Midday', true); ?></small>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class=" text-center">
                                <h3><?php echo $scorecard['overall_guests_morning']; ?></h3>
                                <small><?php echo __('Morning', true); ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <h3 class="text-center"><?php echo __('Guest type', true); ?></h3>

                        <div class="text-center">
                            <?php $total_visit_type = $scorecard['overall_guests_regular'] + $scorecard['overall_guests_occ'] + $scorecard['overall_guests_rarely'] + $scorecard['overall_guests_first']; ?>
                            <?php if($total_visit_type != 0) { ?>
                                <?php
                                    $percent_visit_regular = $scorecard['overall_guests_regular'] / $total_visit_type * 100;
                                    $percent_visit_occasionally = $scorecard['overall_guests_occ'] / $total_visit_type * 100;
                                    $percent_visit_rarely = $scorecard['overall_guests_rarely'] / $total_visit_type * 100;
                                    $percent_visit_first = $scorecard['overall_guests_first'] / $total_visit_type * 100;
                                ?>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        var data = [
                                            { label: "<?php echo __('Regularly', true); ?>",  data: <?php echo $percent_visit_regular; ?>, color: "#4572A7"},
                                            { label: "<?php echo __('Occasionally', true); ?>",  data: <?php echo $percent_visit_occasionally; ?>, color: "#80699B"},
                                            { label: "<?php echo __('Rarely', true); ?>",  data: <?php echo $percent_visit_rarely; ?>, color: "#AA4643"},
                                            { label: "<?php echo __('First visit', true); ?>",  data: <?php echo $percent_visit_first; ?>, color: "#89A54E"},
                                        ];

                                        $.plot($("#chart_visit_type_overall"), data, {
                                            series: {
                                                pie: {
                                                    innerRadius: 0.4,
                                                    show: true
                                                }
                                            },
                                            legend: {
                                                show: false
                                            }
                                        });
                                    });
                                </script>
                                <style>
                                    #chart_visit_type_overall { width: 100%; height: 250px; }
                                </style>
                                <div id="chart_visit_type_overall"></div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class=" text-center">
                                        <h3><?php echo $scorecard['overall_guests_regular']; ?></h3>
                                        <small><?php echo __('Regularly', true);?></small>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class=" text-center">
                                        <h3><?php echo $scorecard['overall_guests_occ']; ?></h3>
                                        <small><?php echo __('Occasionally', true); ?></small>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class=" text-center">
                                        <h3><?php echo $scorecard['overall_guests_rarely']; ?></h3>
                                        <small><?php echo __('Rarely', true); ?></small>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class=" text-center">
                                        <h3><?php echo $scorecard['overall_guests_first']; ?></h3>
                                        <small><?php echo __('First visit', true);?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php } else { ?>

    <?php
        echo $this->Html->script('View/dashboard_wizard', false);
        echo $this->Html->script('vendors/cycle/jquery.cycle.all', false);
        echo $this->Html->script('vendors/cycle/jquery.easing.1.3', false);

        $current_step = $this->Session->read('Wizard.current_step');
    ?>

    <span id="wizard-current_step" style="display: none;"><?php echo $current_step; ?></span>


    <div class="row">

        <div class="col-md-6 col-md-offset-3">
            <h3 class="text-white text-center"><?php echo __('Welcome to guestify!', true);?></h3>
            <div id="wrapper-panels" style="margin: auto;">
                <!-- NOTE: slide-0 is step1 - personal! -->

                <div class="slide-1">

                    <div id="panel-step-1" class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                <?php echo __('Setup your host', true); ?>
                                <span id="ok-sign-panel-1" class="pull-right glyphicon glyphicon-ok-sign text-success" style="display: none;"></span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="stepwizard">
                                <div class="stepwizard-row">
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle" disabled="disabled">1</button>
                                        <p><?php echo __('Personal', true); ?></p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle">2</button>
                                        <p><?php echo __('Host', true); ?></p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
                                        <p><?php echo __('Company', true); ?></p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-default btn-circle" disabled="disabled">4</button>
                                        <p><?php echo __('Poll', true); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php echo $this->Form->create('Host', array('url' => $this->here)); ?>
                                <?php
                                    echo $this->Form->input('Host.name', array(
                                        'label' => __('Name', true).'*',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group'),
                                        'type' => 'text',
                                        'id' => 'hosts-name',
                                        'escape' => false,
                                        'after' => '<div class="error-message"></div>'
                                    ));
                                    echo $this->Form->input('Host.address', array(
                                        'label' => __('Address', true),
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group'),
                                        'type' => 'text',
                                        'id' => 'hosts-address'
                                    ));
                                ?>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <?php
                                            echo $this->Form->input('Host.zipcode', array(
                                                'label' => __('Zipcode', true),
                                                'type' => 'text',
                                                'class' => 'form-control',
                                                'div' => array('class' => 'form-group'),
                                                'id' => 'hosts-zipcode'
                                            ));
                                        ?>
                                    </div>
                                    <div class="col-xs-8">
                                        <?php
                                            echo $this->Form->input('Host.city', array(
                                                'label' => __('City', true),
                                                'class' => 'form-control',
                                                'div' => array('class' => 'form-group'),
                                                'type' => 'text',
                                                'id' => 'hosts-city'
                                            ));
                                        ?>
                                    </div>
                                </div>

                                <?php
                                    $preselect_country = 225; // United States
                                    echo $this->Form->input('Host.country_id', array(
                                        'label' => __('Country', true),
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group'),
                                        'type' => 'select',
                                        'options' => $options_countries,
                                        'default' => $preselect_country,
                                        'id' => 'hosts-country_id'
                                    ));

                                    $preselect_timezone = 'America/New_York';
                                    if(isset($account_setup_data['Host']['timezone']) || !empty($account_setup_data['Host']['timezone'])) {
                                        $preselect_timezone = $account_setup_data['Host']['timezone'];
                                    }
                                    echo $this->Form->input('Host.timezone', array(
                                        'label' => __('Timezone', true),
                                        'type' => 'select',
                                        'options' => $options_timezones,
                                        'selected' => $preselect_timezone,
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group'),
                                        'escape' => false,
                                        'id' => 'hosts-timezone'
                                    ));
                                ?>
                                <hr />
                                <?php echo $this->Form->button(__('Proceed tp step 3', true).' <span class="glyphicon glyphicon-chevron-right"></span>', array('type' => 'submit', 'id' => 'save-step-1', 'class' => 'btn btn-success btn-lg pull-right', 'div' => false)); ?>

                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>

                </div>

                <div class="slide-2">

                    <div id="panel-step-2" class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                <?php echo __('Setup your account', true); ?>
                                <span id="ok-sign-panel-2" class="pull-right glyphicon glyphicon-ok-sign text-success" style="display: none;"></span>
                            </h3>
                        </div>

                        <div class="panel-body">
                            <div class="stepwizard">
                                <div class="stepwizard-row">
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle" disabled="disabled">1</button>
                                        <p><?php echo __('Personal', true); ?></p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle" disabled="disabled">2</button>
                                        <p><?php echo __('Host', true); ?></p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle">3</button>
                                        <p><?php echo __('Company', true); ?></p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-default btn-circle" disabled="disabled">4</button>
                                        <p><?php echo __('Poll', true); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php echo $this->Form->create('Account', array('url' => $this->here)); ?>
                                <?php

                                    echo $this->Form->input('Account.company_name', array(
                                        'label' => __('Company name', true).'*',
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group'),
                                        'id' => 'accounts-company_name',
                                        'escape' => false,
                                        'after' => '<div class="error-message"></div>'
                                    ));

                                    echo $this->Form->input('Account.use_host_address', array(
                                        'label' => __('Use my restaurant address', true),
                                        'type' => 'checkbox',
                                        'checked' => true,
                                        'class' => 'form-control1',
                                        'div' => array('class' => 'form-group'),
                                        'id' => 'accounts-use_host_address'
                                    ));

                                    echo $this->Form->input('Account.address', array(
                                        'label' => __('Address', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group'),
                                        'id' => 'accounts-address',
                                        'disabled' => true
                                    ));
                                ?>

                                <div class="row">
                                    <div class="col-xs-4">
                                        <?php
                                            echo $this->Form->input('Account.zipcode', array(
                                                'label' => __('Zipcode', true),
                                                'type' => 'text',
                                                'class' => 'form-control',
                                                'div' => array('class' => 'form-group'),
                                                'id' => 'accounts-zipcode',
                                                'disabled' => true
                                            ));
                                        ?>
                                    </div>
                                    <div class="col-xs-8">
                                        <?php
                                            echo $this->Form->input('Account.city', array(
                                                'label' => __('City', true),
                                                'type' => 'text',
                                                'class' => 'form-control',
                                                'div' => array('class' => 'form-group'),
                                                'id' => 'accounts-city',
                                                'disabled' => true
                                            ));
                                        ?>
                                    </div>
                                </div>
                                <?php
                                    echo $this->Form->input('Account.country_id', array(
                                        'label' => __('Country', true).'*',
                                        'type' => 'select',
                                        'options' => $options_countries,
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group'),
                                        'id' => 'accounts-country_id',
                                        'disabled' => true
                                    ));
                                ?>
                                <hr />

                                <?php echo $this->Form->button(__('Back', true), array('id' => 'goto-step-1', 'class' => 'btn btn-default btn-lg')); ?>
                                <?php echo $this->Form->button(__('Proceed to step 4', true).' <span class="glyphicon glyphicon-chevron-right"></span>', array('type' => 'submit', 'id' => 'save-step-2', 'class' => 'btn btn-success btn-lg pull-right', 'div' => false)); ?>

                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>

                </div>

                <div class="slide-3">
                    <div id="panel-step-3" class="panel panel-default">
                        <div class="panel-heading">
                            <h3><?php echo __('Setup your poll', true); ?>
                                <span id="ok-sign-panel-3" class="pull-right glyphicon glyphicon-ok-sign text-success" style="display: none;"></span>
                            </h3>
                        </div>

                        <div class="panel-body">
                            <div class="stepwizard">
                                <div class="stepwizard-row">
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle" disabled="disabled">1</button>
                                        <p><?php echo __('Personal', true); ?></p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle" disabled="disabled">2</button>
                                        <p><?php echo __('Company', true); ?></p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle" disabled="disabled">3</button>
                                        <p><?php echo __('Host', true); ?></p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle">4</button>
                                        <p><?php echo __('Poll', true); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php echo $this->Form->create('Host', array('url' => $this->here)); ?>
                                <div class="row">
                                    <div class="col-xs-8">
                                        <?php
                                            echo $this->Form->input('Poll.title', array(
                                                'label' => __('Title of your poll', true).'*',
                                                'type' => 'text',
                                                'class' => 'form-control input-lg',
                                                'div' => array('class' => 'form-group'),
                                                'id' => 'polls-title',
                                                'placeholder' => __('e.g. Feedback', true),
                                                'escape' => false,
                                                'after' => '<div class="error-message"></div>'
                                            ));
                                        ?>
                                    </div>
                                    <div class="col-xs-4">
                                        <?php
                                            echo $this->Form->input('Poll.code', array(
                                                'label' => __('PIN code', true),
                                                'type' => 'text',
                                                'class' => 'form-control input-lg',
                                                'div' => array('class' => 'form-group'),
                                                'id' => 'polls-code',
                                                'placeholder' => __('e.g. 43694', true),
                                                'escape' => false,
                                                'after' => '<div class="error-message"></div>'
                                            ));
                                        ?>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xs-6">
                                        <?php

                                            echo $this->Form->input('Poll.template_id', array(
                                                'label' => __('Poll template', true),
                                                'type' => 'select',
                                                'empty' => __('Select poll', true),
                                                'options' => $options_templates,
                                                'id' => 'polls-template_id',
                                                'class' => 'form-control ',
                                                'div' => array('class' => 'form-group'),
                                                'escape' => false,
                                                'after' => '<div class="error-message"></div>'
                                            ));
                                        ?>
                                        <small><?php echo __('We offer a variety of question sets you can preselect', true); ?></small>
                                    </div>
                                    <div class="col-xs-2">
                                        <label>&nbsp;</label>
                                        <div id="wrapper-template-info" style="display: none;">
                                            <?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', '#', array('id' => 'trigger-template-show', 'class' => 'btn btn-default', 'title' => __('Preview', true), 'escape' => false)); ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <?php
                                            echo $this->Form->input('Poll.scale', array(
                                                'label' => __('Scale', true),
                                                'type' => 'select',
                                                'options' => $options_scales,
                                                'id' => 'polls-scale',
                                                'class' => 'form-control',
                                                'div' => array('class' => 'form-group'),
                                                'escape' => false
                                            ));
                                        ?>
                                        <small><?php echo __('Amount of maximum points', true); ?></small>
                                    </div>

                                </div>

                                <?php /* if(isset($free_slots) && ($free_slots > 0)) { ?>
                                    <div class="alert alert-info">
                                        Free slots: <?php echo $free_slots; ?> <br />
                                        Add info about free upgrade of poll here!
                                    </div>
                                <?php } */?>

                                <hr />
                                <?php echo $this->Form->button(__('Back', true), array('id' => 'goto-step-2', 'class' => 'btn btn-default btn-lg')); ?>
                                <?php echo $this->Form->submit(__('Finish!', true), array('id' => 'save-step-3', 'class' => 'btn btn-success btn-lg pull-right', 'div' => false)); ?>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php } ?>

</div>

<span id="format_chart_month_day" style="display: none;"><?php echo $formats['chart_month_day']; ?></span>

<!-- add poll modal -->
<div id="modal-template-details" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Poll template catalog', true); ?></h3>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php # MOVE THIS INTO A LIVE-AJAX-FUNCTION! ?>
                        <?php foreach($templates as $template_id => $template) { ?>
                            <div id="wrapper-template-<?php echo $template_id; ?>" class="wrapper-templates" style="display: none;">
                                <h4><?php echo __('Poll template', true); ?> "<?php echo $template['name'][$this->Session->read('Config.language')]; ?>"</h4>
                                <?php $group_count = count($template['Groups']); ?>

                                <?php foreach($template['Groups'] as $group_number => $group) { ?>
                                    <?php if($group_count > 1) { ?>
                                        <p><strong><?php echo $group_number; ?> - <?php echo $group['name'][$this->Session->read('Config.language')]; ?></strong></p>
                                    <?php } ?>

                                    <div>
                                        <?php foreach($group['Questions'] as $question_number => $question) { ?>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <p><?php echo $question['question'][$this->Session->read('Config.language')]; ?></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="progress">
                                                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                        <span class="sr-only">80% Complete (success)</span>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-template-details" style="display: none;"/>
                <button class="btn btn-default" id="template-details-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Close', true); ?></button>
            </div>
        </div>
    </div>
</div>
