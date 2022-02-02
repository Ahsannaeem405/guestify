<div id="chart-<?php echo $group_id; ?>" style="height: 400px"></div>
<?php #$question_ids = json_encode(Set::ClassicExtract($questions, '{n}.Question.id')); ?>

<?php
    if(!isset($option)) {
        $option = '';
    }
?>

<script type="text/javascript">

    $(document).ready(function() {

        var period = 'month';

        plotGroupChart(
            <?php echo $group_id; ?>,
            options_chart_<?php echo $period; ?>,
            "<?php echo $period; ?>",
            "<?php echo $option; ?>"
        );

    });



    function plotGroupChartDay(group_id, date) {

        console.log(group_id);
        console.log(date);
        return false;

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

</script>
