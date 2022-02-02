<div id="chart-<?php echo $group_id; ?>" style="height: 250px"></div>
<?php #$question_ids = json_encode(Set::ClassicExtract($questions, '{n}.Question.id')); ?>

<?php
    if(!isset($option)) {
        $option = '';
    }
?>


<script type="text/javascript">

    $(document).ready(function() {

        plotGroupChart(
            <?php echo $group_id; ?>,
            options_chart_<?php echo $period; ?>,
            "<?php echo $period; ?>",
            "<?php echo $option; ?>",
            "<?php echo $max_scale; ?>"
        );
    });

</script>
