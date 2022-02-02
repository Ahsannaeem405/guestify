<?php
    $labels = array(
        0 => 'primary',
        1 => 'info',
        2 => 'warning'
    );
    $count = 0;
?>

<table id="clients" class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <?php foreach($poll['Groups'] as $key => $group) { ?>
                <th colspan="<?php echo count($group['Questions']); ?>">
                    <small class="label label-<?php echo $labels[$key]; ?>" style="display: block;"><?php echo $group['Group']['name']; ?></small>
                </th>
            <?php } ?>
        </tr>
        <tr>
            <th><?php echo __('Month', true); ?></th>
            <?php foreach($poll['Groups'] as $group) { ?>
                <?php foreach($group['Questions'] as $question) { ?>
                    <?php #pr($question); ?>
                    <th class="text-center">
                        <span class="table-tooltip" data-toggle="tooltip" data-placement="top" title="<?php echo $question['Question']['question']; ?>">G<?php echo $group['Group']['order']; ?> <?php echo __('Q', true); ?><?php echo $question['Question']['order']; ?></span>
                    </th>
                <?php } ?>
            <?php } ?>
        </tr>
    </thead>

    <tbody>
        <?php $averages_overall = array(); ?>

        <?php $count_months_with_ratings = 0; ?>

        <?php foreach($answers as $month_number => $answer) { ?>
            <?php if(!empty($answer)) { $count_months_with_ratings++; } ?>
            <tr>
                <td class="text-center">
                    <?php echo $month_number; ?>
                </td>
                <?php foreach($poll['Groups'] as $key => $group) { ?>
                    <?php foreach($group['Questions'] as $question) { ?>
                        <td class="text-center cell-<?php echo $labels[$key]; ?>">
                            <?php
                                if(isset($answer['Answers'][$question['Question']['id']]['rating_overall'])) {
                                    $average = round($answer['Answers'][$question['Question']['id']]['rating_overall']/$answer['Answers'][$question['Question']['id']]['rating_count'], 1);
                                    echo $average;

                                    if(!isset($averages_overall[$question['Question']['id']])) {
                                        $averages_overall[$question['Question']['id']] = 0;
                                    }
                                    $averages_overall[$question['Question']['id']] += $average;
                                } else {
                                    echo '-';
                                }
                            ?>
                        </td>
                    <?php } ?>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>

    <tfoot>
        <tr>
            <td class="text-center lead">&empty;</td>
            <?php foreach($poll['Groups'] as $group) { ?>
                <?php foreach($group['Questions'] as $question) { ?>
                    <td class="text-center lead">
                        <?php 
                            if(isset($averages_overall[$question['Question']['id']])) {
                                echo round($averages_overall[$question['Question']['id']]/$count_months_with_ratings,1); 
                            } else {
                                echo '-';
                            }
                        ?>
                    </td>
                <?php } ?>
            <?php } ?>
        </tr>
    </tfoot>

</table>

<script>
    $(document).ready(function() {
        $('.table-tooltip').tooltip({html: true});
    });
</script>