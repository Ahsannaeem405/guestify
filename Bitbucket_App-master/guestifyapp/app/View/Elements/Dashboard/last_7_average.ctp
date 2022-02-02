<?php # ?>
<div id="container-legend-last-7-average"></div>
<div id="container-chart-last-7-average" style="height: 250px"></div>

<span id="text-axislabel-xaxis" style="display: none;"><?php echo __('Average'); ?></span>

<script type="text/javascript">

    $(document).ready(function() {
        var poll_id = parseInt($('#selector-poll_id').text());
        plotLast7Average(poll_id, "<?php echo $max_scale; ?>");
    });


    function plotLast7Average(poll_id, max_scale) {

        $('#container-chart-last-7-average').fadeTo('fast', 0, function() {

            $.ajax({
                url: '/polls/getLast7Average',
                dataType: 'json',
                data: {
                    "poll_id": poll_id
                },
                success: function(result) {

                    var data_new = [];
                    $.each(result, function (key, question_id) {
                        if(key && result[key]) {
                            data_new.push(result[key]);
                        }
                    });

                    options_last_7_average.xaxis.timeformat = $('#format_chart_month_day').text().toString();
                    options_last_7_average.yaxis.max = max_scale;

                    $.plot('#container-chart-last-7-average', data_new, options_last_7_average);
                    $('#container-chart-last-7-average').UseTooltip();
                    $('#container-chart-last-7-average').fadeTo('fast', 1, function() {
                        return false;
                    });

                    return false;
                }
            });

            return false;
        });

        return false;
    }


    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }

    // BEGIN MAIN DEFINITION OF PLOT
    //var dayOfWeek = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];


    // SETUP OPTIONS
    var options_last_7_average = {
        series: {
            lines: {
                show: true,
                lineWidth: 3,
                fill: true,
                fillColor: {
                    colors: [{ opacity: 0.1 }, { opacity: 0.8 } ]
                },
            },
            points: {
                show: true,
                fill: true,
                fillColor: "#ffffff",
                radius: 4
            },
            shadowSize: 0
        },
        xaxis: {
            mode: "time",
            timeformat: "%d.%m",
            tickSize: [1, "day"],
            minTickSize: [1, "day"],
            color: "#333",
            axisLabel: "Average",
            axisLabel: $('#text-axislabel-xaxis').text(),
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Arial, Verdana',
            axisLabelPadding: 10,
            tickLength: 0
        },
        yaxis: {
            color: "#333",
            tickDecimals: 0,
            min: 0,
            // max: 8,
            tickSize: 1,
            //axisLabel: "Average",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5,
            tickColor: "#eee"
        },
        legend: false,
        colors: ["#5cb85c"],
        // views, ratings, rating average
        grid: {
            hoverable: true,
            borderWidth: 1,
            color: "#eee",
            mouseActiveRadius: 25,
            backgroundColor: { colors: ["#fdfdfd", "#ffffff"] },
            axisMargin: 20
        }
    };


</script>
