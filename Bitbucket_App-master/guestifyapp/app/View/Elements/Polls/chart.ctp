
<div id="chart-<?php echo $group_id; ?>" style="height: 500px"></div>
<?php $question_ids = json_encode(Set::ClassicExtract($questions, '{n}.Question.id')); ?>

<script type="text/javascript">
    $(document).ready(function() {
        plotAccordingToChoices(<?php echo $group_id; ?>, <?php echo $question_ids; ?>, options);
    });
</script>