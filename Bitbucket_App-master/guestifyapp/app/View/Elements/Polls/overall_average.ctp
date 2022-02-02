<!--<div id="container-legend-last-7-average"></div>-->
<div id="container-chart-overall-average" style="height: 250px"></div>

<span id="overall-average-type" style="display: none;"><?php echo $type; ?></span>
<span id="overall-average-poll_id" style="display: none;"><?php echo $poll['Poll']['id']; ?></span>
<span id="overall-average-date_value" style="display: none;"><?php echo $date_value; ?></span>

<script type="text/javascript">

    $(document).ready(function() {
        var type = $('#overall-average-type').text();
        var poll_id = $('#overall-average-poll_id').text();
        var date_value = $('#overall-average-date_value').text();

        plotOverallAverageChart(type, poll_id, date_value, "<?php echo $max_scale + 0.5; ?>");
    });


    function plotOverallAverageChart(type, poll_id, date_value, max_scale) {

        $('#container-chart-overall-average').fadeTo('fast', 0, function() {

            $.ajax({
                url: '/polls/getOverallAverage',
                dataType: 'json',
                data: {
                    "type": type,
                    "poll_id": poll_id,
                    "date_value": date_value
                },
                success: function(result) {

                    var data_new = [];
                    $.each(result, function (key, question_id) {
                        if(key && result[key]) {
                            data_new.push(result[key]);
                        }
                    });

                    if(type == 'last30') {
                        var options = options_overall_average_last30;
                        options.xaxis.timeformat = $('#format_chart_month_day').text().toString();
                    } else if(type == 'day') {
                        var options = options_overall_average_day;
                    } else if(type == 'week') {
                        var options = options_overall_average_week;
                        options.xaxis.timeformat = $('#format_chart_month_day').text().toString();
                    } else if(type == 'month') {
                        var options = options_overall_average_month;
                        options.xaxis.timeformat = $('#format_chart_month_day').text().toString();
                    } else if(type == 'year') {
                        var options = options_overall_average_year;
                        options.xaxis.timeformat = $('#format_chart_year_month').text().toString();
                    }
                    options.yaxis.max = max_scale;

                    $.plot('#container-chart-overall-average', data_new, options);

                    $('#container-chart-overall-average').UseTooltip();     // use different functions here to reflect current section!

                    $('#container-chart-overall-average').fadeTo('slow', 1, function() {
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
    //var dayOfWeek = ["Mon", "Tue", "Wed", "Thr", "Fri", "Sat", "Sun"];
    //var dayOfWeek = ["Mon1", "Tue", "Wed", "Thr", "Fri", "Sat", "Sun"];

    // SETUP OPTIONS
    var options_overall_average_last30 = {
        series: {
            shadowSize: 1
        },
        xaxis: {
            mode: "time",
            timeformat: "%d.%m.%y",
            tickSize: [5, "day"],
            minTickSize: [5, "day"],
            color: "#333",
            //axisLabel: "Date",
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
            //axisLabel: "Rating",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5,
            tickColor: "#eee"
        },
        legend: false,
        grid: {
            hoverable: true,
            borderWidth: 1,
            color: "#eee",
            mouseActiveRadius: 25,
            backgroundColor: { colors: ["#fdfdfd", "#ffffff"] },
            axisMargin: 20
        }
    };

    var options_overall_average_day = {
        series: {
            shadowSize: 1
        },
        xaxis: {
            mode: "time",
            timeformat: "%H:%M",
            tickSize: [2, "hour"],
            color: "#333",
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
            //axisLabel: "Rating",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5,
            tickColor: "#eee"
        },
        legend: false,
        grid: {
            hoverable: true,
            borderWidth: 1,
            color: "#eee",
            mouseActiveRadius: 25,
            backgroundColor: { colors: ["#fdfdfd", "#ffffff"] },
            axisMargin: 20
        }
    };

    var options_overall_average_week = {
        series: {
            shadowSize: 1
        },
        xaxis: {
            mode: "time",
            timeformat: "%d.%m",
            tickSize: [1, "day"],
            //minTickSize: [5, "day"],
            color: "#333",
            //axisLabel: "Date",
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
            //axisLabel: "Rating",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5,
            tickColor: "#eee"
        },
        legend: false,
        grid: {
            hoverable: true,
            borderWidth: 1,
            color: "#eee",
            mouseActiveRadius: 25,
            backgroundColor: { colors: ["#fdfdfd", "#ffffff"] },
            axisMargin: 20
        }
    };

    var options_overall_average_month = {
        series: {
            shadowSize: 1
        },
        xaxis: {
            mode: "time",
            timeformat: "%d.%m",
            tickSize: [5, "day"],
            minTickSize: [5, "day"],
            color: "#333",
            //axisLabel: "Date",
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
            //axisLabel: "Rating",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5,
            tickColor: "#eee"
        },
        legend: false,
        grid: {
            hoverable: true,
            borderWidth: 1,
            color: "#eee",
            mouseActiveRadius: 25,
            backgroundColor: { colors: ["#fdfdfd", "#ffffff"] },
            axisMargin: 20
        }
    };

    var options_overall_average_year = {
        series: {
            shadowSize: 1
        },
        xaxis: {
            mode: "time",
            timeformat: "%m-%y",
            tickSize: [1, "month"],
            //minTickSize: [5, "day"],
            color: "#333",
            //axisLabel: "Date",
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
            //axisLabel: "Rating",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5,
            tickColor: "#eee"
        },
        legend: false,
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
