<?php
    $this->set('title_for_layout', __('Poll', true).' - '.$poll['Poll']['title']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    if($this->Permission->isClient()) {
        $this->Html->addCrumb(__('My Polls', true), array('controller' => 'polls', 'action' => 'index'), array('escape' => false));
    } elseif($this->Permission->isAdmin()) {
        $this->Html->addCrumb(__('Polls', true), array('controller' => 'polls', 'action' => 'admin_index'), array('escape' => false));
    }
    $this->Html->addCrumb($poll['Poll']['title']);


    echo $this->Html->script('vendors/flot/jquery.flot');
    echo $this->Html->script('vendors/flot/jquery.flot.time');
    echo $this->Html->script('vendors/flot/jquery.flot.axislabels');
    echo $this->Html->script('vendors/flot/JUMFlot.min');
    echo $this->Html->script('vendors/flot/jquery.flot.pie.min.js');

    if(!isset($date)) {
        $date = CakeTime::format('Y-m-d', time());
    }
?>

<div class="btn-toolbar pull-right">
    <?php
        if($this->Permission->isClient()) {
            echo $this->Html->link('<span class="glyphicon glyphicon-cog"></span> '.__('Settings', true), array('action' => 'settings', $poll['Poll']['id']), array('class' => 'btn btn-primary', 'escape' => false));
        } elseif($this->Permission->isAdmin()) {
            echo $this->Html->link('<span class="glyphicon glyphicon-cog"></span> '.__('Settings', true), array('action' => 'adminSettings', $poll['Poll']['id']), array('class' => 'btn btn-primary', 'escape' => false));
        }
        if($this->Permission->isClient()) {
            echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> '.__('Add rating', true), array('action' => 'addFeedback', $poll['Poll']['id']), array('class' => 'btn btn-primary', 'escape' => false));
        }
        if($this->Permission->isPremiumPoll($poll['Poll']['id'])) {
            echo $this->Html->link('<span class="glyphicon glyphicon-export"></span> '.__('Export XLS', true), array('action' => 'exportExcel', $poll['Poll']['id'], 'last30'), array('class' => 'btn btn-primary', 'escape' => false));
        } else {
            echo $this->Html->link('<span class="glyphicon glyphicon-export"></span> '.__('Export XLS', true), '#', array('class' => 'btn btn-primary export-tooltip', 'title' => __('This feature is only available in the PRO version!', true), 'escape' => false, 'data-toggle' => 'tooltip', 'data-placement' => 'bottom'));
        }
        if($type == 'unlimited') {
            echo $this->Html->link('<span class="glyphicon glyphicon-certificate"></span> ', array('action' => 'upgrade', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-upgrade upgrade-tooltip', 'title' => __('Extend PRO', true), 'escape' => false));
        } else {
            echo $this->Html->link('<span class="glyphicon glyphicon-certificate"></span> ', array('action' => 'upgrade', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-upgrade upgrade-tooltip', 'title' => __('Upgrade', true), 'escape' => false));
        }
    ?>
</div>

<h2>
    <?php echo $poll['Poll']['title']; ?>
    <sup>
        <small>
            <?php
                if($type == 'unlimited') {
                    echo '<span class="label label-upgrade">'.__('PRO', true).' <span class="glyphicon glyphicon-certificate"></span></span>';
                }
            ?>
        </small>
    </sup>
    <sup>
        <small>
            <?php
                if($poll['Poll']['status'] == 0) {
                    echo '<span class="label label-warning">'.$statuses[$poll['Poll']['status']].'</span>';
                } elseif ($poll['Poll']['status'] == 1) {
                    echo '<span class="label label-success">'.$statuses[$poll['Poll']['status']].'</span>';
                }
            ?>
        </small>
    </sup>
</h2>

<div class="row">
    <div class="col-xs-5">

    </div>

    <div class="col-xs-7">
        <div class="pull-right">
            <?php echo $this->element('Polls/navigation_main', array('poll_id' => $poll['Poll']['id'], 'active_period' => 'last30')); ?>
        </div>
    </div>
</div>


<div id="#export-test">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php // special case for last30: no date => last 30 days from current date (today) ?>
            <?php echo $this->element('Polls/scorecard', array('type' => 'last30', 'overall_average_title' => __('Last 30 days', true), 'date_value' => false)); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">

            <?php foreach($poll['Groups'] as $key => $group) { ?>
                <div class="clearfix">&nbsp;</div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                            echo $this->element('Polls/chart_group_last30', array(
                                'group_id' => $group['Group']['id'],
                                'group' => $group,
                                'date' => date('Y-m-d')
                            ));
                        ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<div id="clients-table" class="panel panel-default">
    <div class="panel-body">
        <?php echo $this->element('Polls/client_table'); ?>
    </div>
</div>

<p><?php echo __('Created', true); ?>: <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['created']); ?> / <?php echo __('Last modified', true); ?>: <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['modified']); ?></p>


<span id="date-value" style="display: none;"><?php echo $date; ?></span>

<span id="format_chart_month_day" style="display: none;"><?php echo $formats['chart_month_day']; ?></span>

<script>

    $(document).ready(function() {

        $('.export-tooltip').tooltip({html: true});
        $('.upgrade-tooltip').tooltip({html: true});

        $(document).on('click', '.legend-select', function() {

            // get the group id
            var temp = $(this).attr('id').split('-');
            var group_id = temp[1];

            // regain the date value(s)
            var value_date = $('#date-value').text();
            var active_q_ids = [];

            $('[id^=legend_checkbox-'+group_id+'-]').each(function() {
                var q_id = $(this).attr('id').split('-').pop();
                if($(this).is(':checked')) {
                    active_q_ids.push(q_id);
                    $(this).closest('div.label').css({opacity: 1});
                } else {
                    $(this).closest('div.label').css({opacity: 0.5});
                }
            });

            $.ajax({
                url: '/polls/getAnswersLast30',
                data: {
                    "group_id": group_id,
                    "date": value_date
                },
                dataType: 'json',
                complete: function(){
                    return false;
                },
                success: function(datasets) {

                    var data = [];

                    $.each(datasets, function (key, question_id) {
                        if(key && datasets[key] && (jQuery.inArray(key, active_q_ids) !== -1)) {
                            data.push(datasets[key]);
                        }
                    });

                    if(data.length > 0) {
                        options_chart_last30.xaxis.timeformat = $('#format_chart_month_day').text().toString();

                        $.plot('#chart-last30-'+group_id, data, options_chart_last30);
                        $('#chart-last30-'+group_id).UseTooltip();
                        $('#chart-last30-'+group_id).fadeTo('fast', 1, function() {
                            return false;
                        });
                    } else {
                        $('#chart-last30-'+group_id).fadeTo('fast', 0, function() {
                            return false;
                        });
                        console.log('no data to plot! please check some legends!');
                    }

                    return false;
                }
            });

        });

    });


    function plotGroupChartLast30(group_id, date, max_scale) {

        $('#chart-last30-'+group_id).fadeTo('fast', 0, function() {

            // get the datasets for the given group (and question ids)
            $.ajax({
                url: '/polls/getAnswersLast30',
                data: {
                    "group_id": group_id,
                    "date": date
                },
                dataType: 'json',
                complete: function(){
                    return false;
                },
                success: function(datasets) {

                    var data = [];
                    $.each(datasets, function (key, question_id) {
                        if(key && datasets[key]) {
                            data.push(datasets[key]);
                        }
                    });

                    if(data.length > 0) {
                        options_chart_last30.legend.container = '#legend-container-'+group_id;
                        options_chart_last30.xaxis.timeformat = $('#format_chart_month_day').text().toString();
                        options_chart_last30.yaxis.max = max_scale;

                        $.plot('#chart-last30-'+group_id, data, options_chart_last30);
                        $('#chart-last30-'+group_id).UseTooltip();
                    }

                    $('#chart-last30-'+group_id).fadeTo('fast', 1, function() {
                        return false;
                    });
                    return false;
                }
            });

            return false;
        });
    }


    // SETUP OPTIONS
    var options_chart_last30 = {
        series: {
            shadowSize: 0
        },
        xaxis: {
            mode: "time",
            timeformat: "%d.%m",
            tickSize: [1, "day"],
            color: "#333",
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10,
            tickLength: 0
        },
        yaxis: {
            color: "#333",
            tickDecimals: 1,
            min: 0,
            max: 4.5,
            tickSize: 0.5,
            axisLabel: "Rating",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10,
            tickColor: "#DDD"
        },
        legend: {
            show: false
        },
        grid: {
            hoverable: true,
            borderWidth: 1,
            color: "#eee",
            mouseActiveRadius: 25,
            backgroundColor: { colors: ["#fdfdfd", "#ffffff"] },
            axisMargin: 20
        }
    };

    var previousPoint = null, previousLabel = null;

    $.fn.UseTooltip = function() {
        $(this).bind("plothover", function (event, pos, item) {
            if (item) {
                if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                    previousPoint = item.dataIndex;
                    previousLabel = item.series.label;
                    $("#tooltip").remove();

                    var x = item.datapoint[0];
                    var y = item.datapoint[1];
                    var date = new Date(x);

                    day = date.getDate();
                    month = date.getMonth();
                    month = month+1;
                    if((String(day)).length==1)
                    day = '0'+day;
                    if((String(month)).length==1)
                    month = '0'+month;

                    dateT=day+ '.' + month + '.' + date.getFullYear();

                    // set color
                    var color = item.series.color;

                    // define the contents of the tooltip
                    var entry = "<strong>" + item.series.label + "</strong><br>"  +
                        dateT + " : <strong>" + y + "</strong> (avg.)";

                    showTooltip(item.pageX, item.pageY, color, entry);
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
    };



    // build the tooltip containing given data, color and contents (html for entry)
    function showTooltip(x, y, color, contents) {
        $('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 40,
            left: x - 120,
            border: '2px solid ' + color,
            padding: '3px',
            'font-size': '9px',
            'border-radius': '5px',
            'background-color': '#fff',
            'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            opacity: 0.9
        }).appendTo("body").fadeIn(200);
    }


</script>
