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
    echo $this->Html->script('vendors/flot/jquery.flot.pie.min.js');

    $locale = $this->Session->read('Config.language');

    echo $this->Html->css('../js/vendors/datepicker/datepicker');
    echo $this->Html->script('vendors/datepicker/bootstrap-datepicker', false);
    if($locale != 'eng') {
        echo $this->Html->script('vendors/datepicker/locales/bootstrap-datepicker.'.substr($locale, 0, 2), false);
    }

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
            echo $this->Html->link('<span class="glyphicon glyphicon-export"></span> '.__('Export XLS', true), array('action' => 'exportExcel', $poll['Poll']['id'], 'day', $date), array('class' => 'btn btn-primary', 'escape' => false));
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
            <?php echo $this->element('Polls/navigation_main', array('poll_id' => $poll['Poll']['id'], 'active_period' => 'day')); ?>
        </div>

    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">

        <?php
            $show_teaser = true;
            if($this->Permission->isPremiumPoll($poll['Poll']['id'])) {
                $show_teaser = false;
            } elseif(($poll['Poll']['id'] == $firstPollId) && (($poll['Poll']['limit'] - $poll['Poll']['ratings_received']) > 0)) {
                $show_teaser = false;
            }
            if($this->Permission->isAdmin()) {
                $show_teaser = false;
            }
        ?>
        <?php if($show_teaser == true) { ?>
            <?php echo $this->element('upgrade_teaser'); ?>
        <?php } else { ?>

            <div class="clearfix">
                <div class="row">
                    <div class="col-xs-4">
                        <?php
                            $yesterday = date('Y-m-d', strtotime($date.' - 1day'));
                            if($yesterday == date('Y-m-d', strtotime(' - 1day'))) {
                                $link_text = __('Yesterday', true);
                            } else {
                                $link_text = $this->Time->format($formats['date'], $yesterday);
                            }
                            echo $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> '.$link_text, array('action' => 'showDay', $poll['Poll']['id'], $yesterday), array('class' => 'btn btn-default btn-block', 'escape' => false));
                        ?>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group " style="margin: 0;">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                <?php
                                    echo $this->Form->input('Poll.date', array(
                                        'label' => false,
                                        'type' => 'text',
                                        'id' => 'picker',
                                        'class' => 'form-control',
                                        'style' => 'border: 1px #ccc solid;',
                                        'value' => $this->Time->format($formats['date'], $date)
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <?php
                            $tomorrow = date('Y-m-d', strtotime($date.' + 1day'));
                            $link_text = $tomorrow;
                            if($tomorrow <= date('Y-m-d')) {
                                echo $this->Html->link($this->Time->format($formats['date'], $link_text).' <span class="glyphicon glyphicon-chevron-right"></span>', array('action' => 'showDay', $poll['Poll']['id'], $tomorrow), array('class' => 'btn btn-default btn-block', 'escape' => false));
                            }
                        ?>
                    </div>
                </div>

            </div>

            <?php echo $this->element('Polls/scorecard', array('type' => 'day', 'overall_average_title' => __('Day', true), 'date_value' => $date)); ?>

        <?php } ?>
    </div>
</div>

<?php if($show_teaser == false) { ?>
    <div class="row">
        <div class="col-xs-12">
            <?php foreach($poll['Groups'] as $key => $group) { ?>
                <div class="clearfix">&nbsp;</div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                            echo $this->element('Polls/chart_group_day', array(
                                'group_id' => $group['Group']['id'],
                                'group' => $group,
                                'date' => $date
                            ));
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo $this->element('Polls/client_table'); ?>
        </div>
    </div>
<?php } ?>


<p class="text-center"><?php echo __('Created', true); ?>: <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['created']); ?> / <?php echo __('Last modified', true); ?>: <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['modified']); ?></p>

<span id="date-value" style="display: none;"><?php echo $date; ?></span>
<span id="poll_id" style="display: none;"><?php echo $poll['Poll']['id']; ?></span>

<?php if($locale == 'deu') { ?>
    <span id="datepicker-format" style="display: none;">dd.mm.yyyy</span>
    <span id="datepicker-language" style="display: none;">de</span>
<?php } else { ?>
    <span id="datepicker-format" style="display: none;">yyyy-mm-dd</span>
    <span id="datepicker-language" style="display: none;">en</span>
<?php } ?>


<script>
    var active_q_ids = [];

    $(document).ready(function() {

        $('.export-tooltip').tooltip({html: true});

        var poll_id = $('#poll_id').text();

        $('#picker').datepicker({
            language: $('#datepicker-language').text(),
            format: $('#datepicker-format').text(),
            weekStart: 1,
            endDate: '-0d',
            calendarWeeks: true
        });

        $('#picker').datepicker().on('changeDate', function(ev){
            var date = $('#picker').val();
            window.location.replace('/polls/showDay/'+poll_id+'/'+date);
            $('#picker').datepicker('hide');
        });


        $(document).on('click', '.legend-select', function() {

            // get the group id
            var temp = $(this).attr('id').split('-');
            var group_id = temp[1];
            var date_data = $('#date-value').text();
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
                url: '/polls/getAnswersDay',
                data: {
                    "group_id": group_id,
                    "date": date_data
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
                        $.plot('#chart-day-'+group_id, data, options_chart_day);
                        $('#chart-day-'+group_id).UseTooltip();
                        $('#chart-day-'+group_id).fadeTo('fast', 1, function() {
                            return false;
                        });
                    } else {
                        $('#chart-day-'+group_id).fadeTo('fast', 0, function() {
                            return false;
                        });
                    }

                    return false;
                }
            });

        });

    });



    function plotGroupChartDay(group_id, date_value, max_scale) {

        var placeholder = 'chart-day-'+group_id;

        $('#chart-day-'+group_id).fadeTo('fast', 0, function() {

            // get the datasets for the given group (and question ids)
            $.ajax({
                url: '/polls/getAnswersDay',
                data: {
                    "group_id": group_id,
                    "date": date_value
                },
                dataType: 'json',
                complete: function(){
                    return false;
                },
                success: function(datasets) {

                    var data = [];

                    var active_q_ids = [];

                    $.each(datasets, function (key, question_id) {
                        if(key && datasets[key]) {
                            data.push(datasets[key]);
                        }
                    });

                    if(data.length > 0) {
                        //options_chart_day.legend.container = '#legend-container-'+group_id;
                        options_chart_day.yaxis.max = max_scale;
                        $.plot('#chart-day-'+group_id, data, options_chart_day);
                        $('#chart-day-'+group_id).UseTooltip();
                    }

                    $('#chart-day-'+group_id).fadeTo('fast', 1, function() {
                        return false;
                    });
                    return false;
                }
            });

            return false;
        });
    }


    // BEGIN MAIN DEFINITION OF PLOT
    var dayOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat"];

    // SETUP OPTIONS
    var options_chart_day = {
        series: {
            shadowSize: 0
        },
        xaxis: {
            mode: "time",
            timeformat: "%H:%M",
            tickSize: [1, "hour"],
            color: "#333",
            axisLabel: "Time",
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
            show: false,
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

    var questions_active = [];

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
                        dateT + " : <strong>" + y + "</strong> ";

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
            top: y - 50,
            left: x - 100,
            border: '2px solid ' + color,
            padding: '3px',
            'font-size': '12px',
            'border-radius': '3px',
            'background-color': '#fff',
            'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            opacity: 0.9
        }).appendTo("body").fadeIn(200);
    }

</script>
