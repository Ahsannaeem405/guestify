<?php # ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6" >
        <div class="col-xs-12">
            <h3 class="text-center"><?php echo __('Guests visit time', true); ?></h3>
            <div class="text-center">
                <?php $total_visit_time = $scorecard['guests_evening'] + $scorecard['guests_midday'] + $scorecard['guests_morning']; ?>
                <?php if($total_visit_time != 0) { ?>
                    <?php
                        $percent_visit_evening = $scorecard['guests_evening'] / $total_visit_time * 100;
                        $percent_visit_midday = $scorecard['guests_midday'] / $total_visit_time * 100;
                        $percent_visit_morning = $scorecard['guests_morning'] / $total_visit_time * 100;
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
                        #chart_visit_time { width: 100%; height: 250px; }
                    </style>
                    <div id="chart_visit_time"></div>
                <?php } ?>
            </div>
        </div>
        <div class="col-xs-4">
            <div class=" text-center">
                <h3><?php echo $scorecard['guests_evening']; ?></h3>
                <small><?php echo __('Evening', true); ?></small>
            </div>
        </div>
        <div class="col-xs-4">
            <div class=" text-center">
                <h3><?php echo $scorecard['guests_midday']; ?></h3>
                <small><?php echo __('Midday', true); ?></small>
            </div>
        </div>
        <div class="col-xs-4">
            <div class=" text-center">
                <h3><?php echo $scorecard['guests_morning']; ?></h3>
                <small><?php echo __('Morning', true); ?></small>
            </div>
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-6">
        <h3 class="text-center"><?php echo __('Guest type', true); ?></h3>
        <div class="text-center">
            <?php $total_visit_type = $scorecard['guests_regular'] + $scorecard['guests_occ'] + $scorecard['guests_rarely'] + $scorecard['guests_first']; ?>
            <?php if($total_visit_type != 0) { ?>
                <?php
                    $percent_visit_regular = $scorecard['guests_regular'] / $total_visit_type * 100;
                    $percent_visit_occasionally = $scorecard['guests_occ'] / $total_visit_type * 100;
                    $percent_visit_rarely = $scorecard['guests_rarely'] / $total_visit_type * 100;
                    $percent_visit_first = $scorecard['guests_first'] / $total_visit_type * 100;
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
                    #chart_visit_type { width: 100%; height: 250px; }
                </style>
                <div id="chart_visit_type"></div>
            <?php } ?>
            <div class="row">
                <div class="col-xs-3">
                    <div class=" text-center">
                        <h3><?php echo $scorecard['guests_regular']; ?></h3>
                        <small><?php echo __('Regularly', true);?></small>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class=" text-center">
                        <h3><?php echo $scorecard['guests_occ']; ?></h3>
                        <small><?php echo __('Occasionally', true); ?></small>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class=" text-center">
                        <h3><?php echo $scorecard['guests_rarely']; ?></h3>
                        <small><?php echo __('Rarely', true); ?></small>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class=" text-center">
                        <h3><?php echo $scorecard['guests_first']; ?></h3>
                        <small><?php echo __('First visit', true);?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
