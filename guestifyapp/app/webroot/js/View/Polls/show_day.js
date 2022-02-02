

    function plotGroupChartDay(group_id, date) {

        var placeholder = 'chart-day-'+group_id;

        $('#chart-day-'+group_id).fadeTo('fast', 0, function() {

            // get the datasets for the given group (and question ids)
            $.ajax({
                url: '/polls/getAnswersDay',
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
                        options_chart_day.legend.container = '#legend-container-'+group_id;
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
            shadowSize: 5
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
            max: 5,
            axisLabel: "Rating",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10,
            tickColor: "#DDD"
        },
        legend: {
            show: true,
            container: '',
            placement: 'outsideGrid',
            noColumns: 0,
            labelFormatter: function (label, series) {
                return '<span class="legend-selector" style="color: #000">' + label + '</span> ';
            },
            backgroundOpacity: 0.7
        },
        grid: {
            hoverable: true,
            borderWidth: 3,
            color: "#fff",
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
