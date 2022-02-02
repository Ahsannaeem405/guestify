<?php
    $this->set('title_for_layout', __('Home', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));

    echo $this->Html->script('vendors/flot/jquery.flot');
    echo $this->Html->script('vendors/flot/jquery.flot.time');
    echo $this->Html->script('vendors/flot/jquery.flot.axislabels');
    echo $this->Html->script('vendors/flot/jquery.flot.pie.min.js');
?>


<div class="clearfix">
    <h2><?php echo __('Hello Admin!', true); ?></h2>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel">
                <div class="panel-body">

                    <h3 class="text-info"><?php echo __('Overall statistics', true); ?></h3>

                    <h4><?php echo __('Last 30 days'); ?></h4>
                    <?php echo $this->element('Dashboard/admin_last30_stats'); ?>
                    <hr />

                    <h3><?php echo __('Polls & Ratings', true); ?> </h3>
                    <div class="row">
                        <div class="col-xs-6">
                            <strong><?php echo __('Polls', true); ?></strong>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="score">
                                        <small class="clearfix"><?php echo __('Amount of Polls', true); ?></small>
                                        <span class="number"><?php echo $scorecard['polls']; ?></span>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="score">
                                        <small class="clearfix"><?php echo __('Active Pro Upgrades', true); ?></small>
                                        <span class="number"><?php echo $scorecard['polls_premium_active']; ?></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="score">
                                        <small class="clearfix"><?php echo __('Overall Pro Upgrades', true); ?></small>
                                        <span class="number"><?php echo $scorecard['polls_premium']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <strong><?php echo __('Ratings', true); ?></strong>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="score">
                                        <small class="clearfix"><?php echo __('Guest Ratings', true); ?></small>
                                        <span class="number"><?php echo $scorecard['guests']; ?></span>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="score">
                                        <small class="clearfix"><?php echo __('Hosts', true); ?></small>
                                        <span class="number"><?php echo $scorecard['hosts']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        </div>
                        <div class="col-xs-6">
                            <strong><?php echo __('Sales', true); ?></strong>
                            <div class="clearfix">
                                <div class="score">
                                    <small class="clearfix"><?php echo __('Revenue', true); ?></small>
                                    <span class="number"><?php echo $this->Number->format($scorecard['revenue'], $formats['currency']); ?></span>
                                </div>
                            </div>
                            <div class="clearfix">
                                <?php /* PREPARED CHART FOR REVENUE 
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        var data = [
                                            [0, 100],
                                            [1, 120],
                                            [2, 140],
                                            [3, 90],
                                            [4, 110],
                                            [5, 160],
                                            [6, 115],
                                        ];

                                        var dataset = [
                                            { label: "Revenue",  data: data, color: "#a8d200"},
                                        ];

                                        var ticks = [
                                            [0, "01.09"], [1, "02.09"], [2, "03.09"], [3, "04.09"], [4, "05.09"], [5, "06.09"], [6, "07.09"],
                                        ];


                                        var options = {
                                            series: {
                                                bar: {
                                                    show: true,
                                                    label: false
                                                }
                                            },
                                            bars: {
                                                align: "center",
                                                barWidth: 0.5
                                            },
                                            xaxis: {
                                                axisLabel: "Period",
                                                axisLabelUseCanvas: true,
                                                axisLabelFontSizePixels: 12,
                                                axisLabelFontFamily: 'Verdana, Arial',
                                                axisLabelPadding: 10,
                                                ticks: ticks
                                            },
                                            yaxis: {
                                                axisLabel: "Sales in $",
                                                axisLabelUseCanvas: true,
                                                axisLabelFontSizePixels: 12,
                                                axisLabelFontFamily: 'Verdana, Arial',
                                                axisLabelPadding: 3,
                                                tickFormatter: function (v, axis) {
                                                    return v + "$";
                                                }
                                            },
                                            legend: {
                                                show: false
                                            }
                                        };
                                        $.plot($("#sales_7days"), dataset, options);
                                    });

                                </script>
                                <style>
                                    #sales_7days { width: 540px; height: 225px; }
                                </style>
                                <div id="sales_7days"></div>
                                */ ?> 
                            </div>
                        </div>
                    </div>

                    <h4><?php echo __('Poll conversion rates'); ?></h4>
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="panel panel-info score">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="glyphicon glyphicon-stats"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div><?php echo __('Yesterday', true); ?></div>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="position_absolute">
                                        <div class="number-set text-center">
                                            <div class="number"><?php echo $conversion_rates['today']; ?>%</div>
                                            <p><?php echo __('Yesterday', true); ?>: <?php echo $conversion_rates['yesterday']; ?>%</p>
                                        </div>
                                    </div>
                                    <?php
                                        $rest = '';
                                        $rest = 100 - $conversion_rates['today'];
                                    ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var data = [
                                                { label: "<?php echo __('Conversion rate today', true); ?>",  data: <?php echo $conversion_rates['today']; ?>, color: "#428BCA"},
                                                { label: "",  data: <?php echo $rest; ?>, color: "#efefef"}
                                            ];

                                            $.plot($("#conversion_today_donut"), data, {
                                                series: {
                                                    pie: {
                                                        innerRadius: 0.8,
                                                        radius: 0.9,
                                                        show: true,
                                                        label: false
                                                    }
                                                },
                                                legend: {
                                                    show: false
                                                }
                                            });
                                        });
                                    </script>
                                    <style>
                                        #conversion_today_donut { width: 225px; height: 225px; }
                                    </style>
                                    <div id="conversion_today_donut"></div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-3">
                            <div class="panel panel-info score">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="glyphicon glyphicon-stats"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div><?php echo __('Last 7 days', true); ?></div>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="position_absolute">
                                        <div class="number-set text-center">
                                            <div class="number"><?php echo $conversion_rates['last_7']; ?>%</div>
                                            <p><?php echo __('7 days before', true); ?>: <?php echo $conversion_rates['last_7_before']; ?>%</p>
                                        </div>
                                    </div>
                                    <?php
                                        $rest_7days = '';
                                        $rest_7days = 100 - $conversion_rates['last_7'];
                                    ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var data = [
                                                { label: "<?php echo __('Conversion last 7 today', true); ?>",  data: <?php echo $conversion_rates['last_7']; ?>, color: "#428BCA"},
                                                { label: "",  data: <?php echo $rest_7days; ?>, color: "#efefef"}
                                            ];

                                            $.plot($("#conversion_7days_donut"), data, {
                                                series: {
                                                    pie: {
                                                        innerRadius: 0.8,
                                                        radius: 0.9,
                                                        show: true,
                                                        label: false
                                                    }
                                                },
                                                legend: {
                                                    show: false
                                                }
                                            });
                                        });
                                    </script>
                                    <style>
                                        #conversion_7days_donut { width: 225px; height: 225px; }
                                    </style>
                                    <div id="conversion_7days_donut"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="panel panel-info score">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="glyphicon glyphicon-stats"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div><?php echo __('Last 30 days', true); ?></div>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="position_absolute">
                                        <div class="number-set text-center">
                                            <div class="number"><?php echo $conversion_rates['last_30']; ?>%</div>
                                            <p><?php echo __('30 days before', true); ?>: <?php echo $conversion_rates['last_30_before']; ?>%</p>
                                        </div>
                                    </div>
                                    <?php
                                        $rest_30days = '';
                                        $rest_30days = 100 - $conversion_rates['last_30'];
                                    ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var data = [
                                                { label: "<?php echo __('Conversion last 30 days', true); ?>",  data: <?php echo $conversion_rates['last_30']; ?>, color: "#428BCA"},
                                                { label: "",  data: <?php echo $rest_30days; ?>, color: "#efefef"}
                                            ];

                                            $.plot($("#conversion_30days_donut"), data, {
                                                series: {
                                                    pie: {
                                                        innerRadius: 0.8,
                                                        radius: 0.9,
                                                        show: true,
                                                        label: false
                                                    }
                                                },
                                                legend: {
                                                    show: false
                                                }
                                            });
                                        });
                                    </script>
                                    <style>
                                        #conversion_30days_donut { width: 225px; height: 225px; }
                                    </style>
                                    <div id="conversion_30days_donut"></div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-3">
                            <div class="panel panel-info score">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="glyphicon glyphicon-stats"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div><?php echo __('This year', true); ?></div>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="position_absolute">
                                        <div class="number-set text-center">
                                            <div class="number"><?php echo $conversion_rates['this_year']; ?>%</div>
                                            <p><?php echo __('Year before', true); ?>: <?php echo $conversion_rates['last_year']; ?>%</p>
                                        </div>
                                    </div>
                                    <?php
                                        $rest_year = '';
                                        $rest_year = 100 - $conversion_rates['this_year'];
                                    ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var data = [
                                                { label: "<?php echo __('Conversion this year', true); ?>",  data: <?php echo $conversion_rates['this_year']; ?>, color: "#428BCA"},
                                                { label: "",  data: <?php echo $rest_year; ?>, color: "#efefef"}
                                            ];

                                            $.plot($("#conversion_year_donut"), data, {
                                                series: {
                                                    pie: {
                                                        innerRadius: 0.8,
                                                        radius: 0.9,
                                                        show: true,
                                                        label: false
                                                    }
                                                },
                                                legend: {
                                                    show: false
                                                }
                                            });
                                        });
                                    </script>
                                    <style>
                                        #conversion_year_donut { width: 225px; height: 225px; }
                                    </style>
                                    <div id="conversion_year_donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
