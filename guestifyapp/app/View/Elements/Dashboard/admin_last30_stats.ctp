<?php # ?>
<div id="container-chart-last30-stats" style="height: 250px;"></div>


<script type="text/javascript">

    $(document).ready(function() {

        plotLast30StatsChart();

    });

    function plotLast30StatsChart() {

        $('#container-chart-last30-stats').fadeTo('fast', 0, function() {

            $.ajax({
                url: '/polls/getLast30StatsAdmin',
                dataType: 'json',
                success: function(result) {

                    var data_new = [];
                    $.each(result, function (key, question_id) {
                        if(key && result[key]) {
                            data_new.push(result[key]);
                        }
                    });

                    console.log(data_new);

                    $.plot('#container-chart-last30-stats', data_new, options_last30_stats);
                    $('#container-chart-last30-stats').UseTooltip();

                    $('#container-chart-last30-stats').fadeTo('fast', 1, function() {
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

    // SETUP OPTIONS
    var options_last30_stats = {
        series: {
            lines: {
                show: true,
                lineWidth: 3,
                fill: true,
                fillColor: {
                    colors: [{ opacity: 0.1 }, { opacity: 0.8 } ]
                },
                // lineColor: "#A20000"
            },
            points:{
                show: true,
                fill: true,
                fillColor: "#fff",
                radius: 4
            },
            shadowSize: 0,
        },
        xaxis: {
            mode: "time",
            timeformat: "%d.%m",
            tickSize: [1, "day"],
            minTickSize: [1, "day"],
            color: "#333",
            //axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Arial, Verdana',
            axisLabelPadding: 10,
            tickLength: 0
        },
        yaxis: {
            color: "#333",
            //tickDecimals: 1,
            min: 0,
            //max: 4.5,
            // axisLabel: "Rating",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5,
            tickColor: "#eee"
        },
        legend: false,
        colors: ["#BBB", "#428BCA"],
        grid: {
            hoverable: true,
            borderWidth: 1,
            color: "#eee",
            mouseActiveRadius: 25,
            backgroundColor: { colors: ["#fdfdfd", "#ffffff"] },
            axisMargin: 20
        }
    };


    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }

    var previousPoint = null, previousLabel = null;
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

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
                        dateT + " : <strong>" + y + "</strong>" + '<br>';

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
            padding: '5px',
            'font-size': '12px',
            'border-radius': '2px',
            'background-color': '#fff',
            'font-family': 'Arial, Verdana, Helvetica, Tahoma, sans-serif',
            opacity: 1
        }).appendTo("body").fadeIn(200);
    }

</script>
