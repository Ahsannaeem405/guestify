
    $(document).ready(function() {

        $(document).on('click', '.trigger-change-period', function() {

            plotGroupChart(group_id, options, period);

            return false;
        });

    });


    function plotGroupChart(group_id, options_chart, period, option, date) {

        var placeholder = 'chart-'+group_id;

        $('#'+placeholder).fadeTo('fast', 0, function() {

            // get the datasets for the given group (and question ids)
            $.ajax({
                url: '/polls/getAnswers',
                data: {
                    "group_id": group_id,
                    "period": period,
                    "option": option,
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
                        options_chart.legend.container = '#legend-container-'+group_id;
                        
                        $.plot('#chart-'+group_id, data, options_chart);
                        $('#chart-'+group_id).UseTooltip();
                    }

                    $('#'+placeholder).fadeTo('fast', 1, function() {
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
    var options_chart_month = {
        series: {
            shadowSize: 1
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
            //noColumns: 2,
            labelFormatter: function (label, series) {
                return '<span class="legend-selector" style="color: #000">' + label + '</span> ';
                //return '<a href="#" onClick="togglePlot('+series.idx+'); return false;">'+label+'</a>';
            },
            //backgroundColor: "#666",
            backgroundOpacity: 0.7,
            //labelBoxBorderColor: "#333",
            //position: "ne"
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
            //noColumns: 2,
            labelFormatter: function (label, series) {
                return '<span class="legend-selector" style="color: #000">' + label + '</span> ';
                //return '<a href="#" onClick="togglePlot('+series.idx+'); return false;">'+label+'</a>';
            },
            //backgroundColor: "#666",
            backgroundOpacity: 0.7,
            //labelBoxBorderColor: "#333",
            //position: "ne"
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


    // SETUP OPTIONS
    var options_chart_year = {
        series: {
            shadowSize: 1
        },
        xaxis: {
            mode: "time",
            timeformat: "%m-%y",
            tickSize: [1, "month"],
            color: "#333",
            axisLabel: "Month",
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
            noColumns: 2,
            labelFormatter: function (label, series) {
                return '<span style="color: #fff">' + label + '</span> ';
            },
            backgroundColor: "#666",
            backgroundOpacity: 0.7,
            labelBoxBorderColor: "#333",
            position: "ne"
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


    // SETUP OPTIONS
    var options_chart_week = {
        series: {
            shadowSize: 1
        },
        xaxes: [{
            mode: "time",
            tickFormatter: function (val, axis) {
                return dayOfWeek[new Date(val).getDay()];
            },
            minTickSize: [1, "day"],
            color: "#333",
            position: "top",
            axisLabel: "Day of week",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10,
            tickLength: 0
        },
        {
            mode: "time",
            timeformat: "%d.%m.%y",
            tickSize: [1, "day"],
            minTickSize: [1, "day"],
            color: "#333",
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10,
            tickLength: 0
        }],
        yaxis: {
            color: "#333",
            tickDecimals: 1,
            min: 0,
            max: 5,
            axisLabel: "Rating",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5,
            tickColor: "#eee"
        },
        legend: {
            show: true,
            container: '',
            placement: 'outsideGrid',
            noColumns: 0,
            //noColumns: 2,
            labelFormatter: function (label, series) {
                return '<span class="legend-selector" style="color: #000">' + label + '</span> ';
                //return '<a href="#" onClick="togglePlot('+series.idx+'); return false;">'+label+'</a>';
            },
            //backgroundColor: "#666",
            backgroundOpacity: 0.7,
            //labelBoxBorderColor: "#333",
            //position: "ne"
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
