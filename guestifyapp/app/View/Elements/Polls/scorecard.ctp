<hr />
<?php if(isset($scorecard)) { ?>
    <div class="row">
        <div class="col-xs-6">
            <div class="clearfix">
                <div class="pull-right">
                    <div class="gsi-background-small">
                        <img src="/graphics/backgrounds/img-noise-361x370_darkblue.png" class="img-circle" width="50" />
                        <div class="position_absolute">
                            <span class="text-center text-white gsi-base"><?php echo round($scorecard['prev']['average_overall']*(10/$max_scale), 1); ?></span>
                        </div>
                    </div>
                </div>
                <div class="score pull-right">
                    <div class="position_absolute">
                        <?php
                            if($scorecard['prev']['average_overall'] > $scorecard['current']['average_overall']) {
                                $change = '<span class="text-danger"><span class="glyphicon glyphicon-arrow-down"></span></span>';
                            } elseif($scorecard['prev']['average_overall'] < $scorecard['current']['average_overall']) {
                                $change = '<span class="text-success"><span class="glyphicon glyphicon-arrow-up"></span></span>';
                            } else {
                                $change = '&nbsp;';
                            }
                        ?>
                        <?php echo $change; ?>
                        <div class="gsi-background">
                            <img src="/graphics/backgrounds/img-noise-361x370_darkblue.png" class="img-circle" width="100" />

                            <div class="position_absolute">
                                <?php echo $this->Label->GsiLabel(round($scorecard['current']['average_overall']*(10/$max_scale), 1)); ?>
                            </div>

                            <p class="jumbo text-white text-center">
                                <span><?php echo round($scorecard['current']['average_overall']*(10/$max_scale), 1); ?></span>
                            </p>

                        </div>
                    </div>
                </div>
                <h3><?php echo __('Guest Satisfaction Index', true); ?></h3>
                <small><?php echo __('The GSI provides a comparable score based on a maximum of 10.', true);?></small>
            </div>
            <hr />
            <h3><?php echo __('Scores', true); ?></h3>
            <div class="row">
                <div class="col-xs-2">
                    <div class="score text-info text-center">
                        <span><?php echo __('Views', true); ?> </span>
                        <p>
                            <span  class="number"><?php echo $scorecard['views']['current']; ?></span><br />
                            <strong><?php echo $scorecard['views']['prev']; ?></strong>
                        </p>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="score text-info text-center">
                        <span><?php echo __('Overall', true); ?> </span>
                        <?php
                            $change = '';
                            if($scorecard['prev']['average_overall'] > $scorecard['current']['average_overall']) {
                                $change = '<small class="text text-danger"><span class="glyphicon glyphicon-arrow-down"></span></small>';
                            } elseif($scorecard['prev']['average_overall'] < $scorecard['current']['average_overall']) {
                                $change = '<small class="text text-success"><span class="glyphicon glyphicon-arrow-up"></span></small>';
                            }
                        ?>
                        <p>
                            <span  class="number"><?php echo $scorecard['current']['average_overall']; ?> <span><?php echo $change; ?> </span></span><br />
                            <strong><?php echo $scorecard['prev']['average_overall']; ?></strong>
                        </p>
                    </div>
                </div>
                <div class="col-xs-7">
                    <?php foreach($scorecard['current']['average_by_group'] as $group_id => $rating) { ?>
                        <p class="text-right">
                            <span><?php echo $groups[$group_id]; ?></span>:
                            <span >
                                <?php
                                    $change = '';
                                    if($scorecard['prev']['average_by_group'][$group_id] > $scorecard['current']['average_by_group'][$group_id]) {
                                        $change = '<small class="text text-danger"><span class="glyphicon glyphicon-arrow-down"></span></small>';
                                    } elseif($scorecard['prev']['average_by_group'][$group_id] < $scorecard['current']['average_by_group'][$group_id]) {
                                        $change = '<small class="text text-success"><span class="glyphicon glyphicon-arrow-up"></span></small>';
                                    }
                                ?>

                                <span class="lead"><?php echo $scorecard['current']['average_by_group'][$group_id]; ?> <span><?php echo $change; ?> </span></span>
                                <span>(<?php echo $scorecard['prev']['average_by_group'][$group_id]; ?>)</span>
                            </span>
                        </p>
                    <?php } ?>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h3><?php echo __('Overall average'); ?> - <?php echo $overall_average_title; ?></h3>
                    <?php echo $this->element('Polls/overall_average', array('type' => $type, 'date_value' => $date_value)); ?>
                </div>
            </div>
        </div>

        <div class="col-xs-6">
            <?php $total_visit_time = $scorecard['current']['guests_evening'] + $scorecard['current']['guests_midday'] + $scorecard['current']['guests_morning']; ?>
            <?php $total_visit_time_prev = $scorecard['prev']['guests_evening'] + $scorecard['prev']['guests_midday'] + $scorecard['prev']['guests_morning']; ?>
            <div class="clearfix">
                <div class="score pull-right">
                    <div class="position_absolute">
                        <?php
                            if($total_visit_time_prev > $total_visit_time) {
                                $change_guest = '<span class="text-danger"><span class="glyphicon glyphicon-arrow-down"></span></span>';
                            } elseif($total_visit_time_prev < $total_visit_time) {
                                $change_guest = '<span class="text-success"><span class="glyphicon glyphicon-arrow-up"></span></span>';
                            } else {
                                $change_guest = '&nbsp;';
                            }
                        ?>
                        <?php echo $change_guest; ?>
                        <div class="gsi-background">
                            <img src="/graphics/backgrounds/grey_bg.jpg" class="img-circle" width="100" />
                            <div class="position_absolute"><span class="text-center text-white gsi-base"><?php echo $total_visit_time_prev; ?></span></div>
                            <p class="jumbo text-white text-center">
                                <span><?php echo $total_visit_time; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <h3><?php echo __('Amount of guest ratings in this period', true); ?></h3>
                <small>&nbsp;</small>
                <hr />
            </div>
            <div class="row">

                <div class="col-xs-6">
                    <div class="col-xs-12">
                        <h3 class="text-center"><?php echo __('Guests visit time', true); ?></h3>

                        <div class="text-center">

                            <?php if($total_visit_time != 0) { ?>
                                <?php
                                    $percent_visit_evening = $scorecard['current']['guests_evening'] / $total_visit_time * 100;
                                    $percent_visit_midday = $scorecard['current']['guests_midday'] / $total_visit_time * 100;
                                    $percent_visit_morning = $scorecard['current']['guests_morning'] / $total_visit_time * 100;
                                ?>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        var data = [
                                            { label: "<?php echo __('Evening', true); ?>",  data: <?php echo $percent_visit_evening; ?>, color: "#4572A7"},
                                            { label: "<?php echo __('Midday', true); ?>",  data: <?php echo $percent_visit_midday; ?>, color: "#80699B"},
                                            { label: "<?php echo __('Morning', true); ?>",  data: <?php echo $percent_visit_morning; ?>, color: "#AA4643"},
                                        ];

                                        $.plot($("#chart_visit_time"), data, {
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
                                    #chart_visit_time { width: 250px; height: 250px; }
                                </style>
                                <div id="chart_visit_time"></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class=" text-center">
                            <small><?php echo __('Evening', true); ?></small>
                            <h3><?php echo $scorecard['current']['guests_evening']; ?> <br /><small>(<?php echo $scorecard['prev']['guests_evening']; ?>)</small></h3>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class=" text-center">
                            <small><?php echo __('Midday', true); ?></small>
                            <h3><?php echo $scorecard['current']['guests_midday']; ?> <br /><small>(<?php echo $scorecard['prev']['guests_midday']; ?>)</small></h3>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class=" text-center">
                            <small><?php echo __('Morning', true); ?></small>
                            <h3><?php echo $scorecard['current']['guests_morning']; ?> <br /><small>(<?php echo $scorecard['prev']['guests_morning']; ?>)</small></h3>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <h3 class="text-center"><?php echo __('Guest type', true); ?></h3>
                    <div class="text-center">
                        <?php $total_visit_type = $scorecard['current']['guests_regular'] + $scorecard['current']['guests_occ'] + $scorecard['current']['guests_rarely'] + $scorecard['current']['guests_first']; ?>
                        <?php if($total_visit_type != 0) { ?>
                            <?php
                                $percent_visit_regular = $scorecard['current']['guests_regular'] / $total_visit_type * 100;
                                $percent_visit_occasionally = $scorecard['current']['guests_occ'] / $total_visit_type * 100;
                                $percent_visit_rarely = $scorecard['current']['guests_rarely'] / $total_visit_type * 100;
                                $percent_visit_first = $scorecard['current']['guests_first'] / $total_visit_type * 100;
                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    var data = [
                                        { label: "<?php echo __('Regularly', true); ?>",  data: <?php echo $percent_visit_regular; ?>, color: "#4572A7"},
                                        { label: "<?php echo __('Occasionally', true); ?>",  data: <?php echo $percent_visit_occasionally; ?>, color: "#80699B"},
                                        { label: "<?php echo __('Rarely', true); ?>",  data: <?php echo $percent_visit_rarely; ?>, color: "#AA4643"},
                                        { label: "<?php echo __('First visit', true); ?>",  data: <?php echo $percent_visit_first; ?>, color: "#89A54E"},
                                    ];

                                    $.plot($("#chart_visit_type"), data, {
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
                                #chart_visit_type { width: 250px; height: 250px; }
                            </style>
                            <div id="chart_visit_type"></div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class=" text-center">
                                    <small><?php echo __('Regularly', true);?></small>
                                    <h3><?php echo $scorecard['current']['guests_regular']; ?> <br /><small>(<?php echo $scorecard['prev']['guests_regular']; ?>)</small></h3>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class=" text-center">
                                    <small><?php echo __('Occasionally', true); ?></small>
                                    <h3><?php echo $scorecard['current']['guests_occ']; ?> <br /><small>(<?php echo $scorecard['prev']['guests_occ']; ?>)</small></h3>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class=" text-center">
                                    <small><?php echo __('Rarely', true); ?></small>
                                    <h3><?php echo $scorecard['current']['guests_rarely']; ?> <br /><small>(<?php echo $scorecard['prev']['guests_rarely']; ?>)</small></h3>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class=" text-center">
                                    <small><?php echo __('First visit', true);?></small>
                                    <h3><?php echo $scorecard['current']['guests_first']; ?> <br /><small>(<?php echo $scorecard['prev']['guests_first']; ?>)</small></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
