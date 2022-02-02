<div class="clearfix">
    <div class="pull-right">
        <div id="legend-holder-<?php echo $group_id; ?>" class="clearfix">
            <?php
                $colors = Configure::read('Colors');
                $question_count = count($group['Questions']);
                $cols = 12/$question_count;
            ?>
            <div class="clearfix">
                <?php foreach($group['Questions'] as $key => $question) { ?>
                    <div class="label" style="background-color: <?php echo $colors[$key]; ?>; display: inline-block;">
                        <?php
                            echo $this->Form->input('Poll.'.$question['Question']['id'].'.legend', array(
                                'type' => 'checkbox',
                                'label' => array(
                                    'text' => $question['Question']['question'],
                                    'style' => 'color: #333; cursor: pointer; padding-top: 5px; font-size: 12px;'
                                ),
                                'class' => 'hide legend-select checkbox-legend-select-'.$group_id,
                                'id' => 'legend_checkbox-'.$group_id.'-'.$question['Question']['id'],
                                'hiddenField' => false,
                                'checked' => true,
                                'div' => false,
                                'style' => 'margin: 5px;'
                            ));
                        ?>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>

    <h3 class="pull-left"><?php echo $group['Group']['name']; ?> <span class="lead badge">&empty; <?php echo round($scorecard['current']['average_by_group'][$group['Group']['id']], 2); ?></span></h3>
</div>


<div id="chart-month-<?php echo $group_id; ?>" style="height: 400px"></div>

<script type="text/javascript">
    $(document).ready(function() {
        plotGroupChartMonth(<?php echo $group_id; ?>, "<?php echo $year_month; ?>", "<?php echo $max_scale + 0.5; ?>");
    });
</script>
