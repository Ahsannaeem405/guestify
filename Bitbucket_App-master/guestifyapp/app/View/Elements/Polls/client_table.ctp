<?php echo $this->Html->script('View/Polls/client_table'); ?>

<span id="reload-page-text" style="display: none;"><?php echo __('To see your changes, please reload the page!', true); ?></span>

<?php
    $labels = array(
        0 => 'primary',
        1 => 'info',
        2 => 'warning',
        3 => 'danger'
    );
    $count = 0;
?>
<h4><?php echo __('Scorecard', true); ?></h4>
<table id="clients" class="table  table-bordered table-condensed">
    <thead>
        <tr class="group-row">
            <th></th>
            <?php foreach($poll['Groups'] as $key => $group) { ?>
                <th colspan="<?php echo count($group['Questions']); ?>">
                    <small class="label label-<?php echo $labels[$key]; ?>" style="display: block;"><?php echo $group['Group']['name']; ?></small>
                </th>
            <?php } ?>
            <th colspan="6"></th>
        </tr>
        <tr>
            <th><?php echo __('Source', true); ?></th>
            <?php foreach($poll['Groups'] as $group) { ?>
                <?php foreach($group['Questions'] as $question) { ?>
                    <th class="text-center">
                        <span class="table-tooltip" data-toggle="tooltip" data-placement="top" title="<?php echo $question['Question']['question']; ?>">G<?php echo $group['Group']['order']; ?> <?php echo __('Q', true); ?><?php echo $question['Question']['order']; ?></span>
                    </th>
                <?php } ?>
            <?php } ?>
            <th><?php echo __('GSI', true); ?></th>
            <th><?php echo __('Guest ID', true); ?></th>
            <th><?php echo __('Visit time', true); ?></th>
            <th><?php echo __('Guest type', true); ?></th>
            <th><?php echo __('Created', true); ?></th>
            <th width="90">&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        <?php $averages = array(); ?>

        <?php foreach($answers as $answer) { ?>
            <?php
                $icon = '';
                if(($answer['Guest']['pin'] != $poll['Poll']['code']) && (empty($answer['Guest']['api_account_id']))) {
                    $icon = 'pencil';
                }
                if($answer['Guest']['pin'] == $poll['Poll']['code']) {
                    $icon = 'phone';
                }
                if(!empty($answer['Guest']['api_account_id'])) {
                    $icon = 'cloud';
                }

                $tr_class = '';
                if($answer['Guest']['status'] == 0) {
                    $tr_class = 'warning';
                }
            ?>
            <tr class="<?php echo $tr_class; ?>">
                <td class="text-center">
                    <span class="glyphicon glyphicon-<?php echo $icon; ?>"></span>
                </td>
                <?php foreach($poll['Groups'] as $key => $group) { ?>
                    <?php foreach($group['Questions'] as $question) { ?>
                        <td class="text-center cell-<?php echo $labels[$key]; ?>">
                            <?php
                                if(isset($answer['Answers'][$question['Question']['id']])) {
                                    if($question['Question']['scale'] == $answer['Answers'][$question['Question']['id']]) {
                                        echo '<strong class="text-success">'.$answer['Answers'][$question['Question']['id']].'</strong>';
                                    } elseif($answer['Answers'][$question['Question']['id']] == 1) {
                                        echo '<strong class="text-danger">'.$answer['Answers'][$question['Question']['id']].'</strong>';
                                    } else {
                                        echo $answer['Answers'][$question['Question']['id']];
                                    }

                                    if($answer['Guest']['status'] == 1) {
                                        if(!isset($averages[$question['Question']['id']])) {
                                            $averages[$question['Question']['id']] = array();
                                        }
                                        array_push($averages[$question['Question']['id']], $answer['Answers'][$question['Question']['id']]);
                                    }
                                }
                            ?>
                        </td>
                    <?php } ?>
                <?php } ?>
                <td>
                    <?php
                        $score 	        = 0;
                        $rating_max 	= 0;
                        $rating_real 	= 0;
                        $count_answers 	= 0;

                        foreach($poll['Groups'] as $group) {
                            foreach($group['Questions'] as $question) {
                                $count_answers++;
                                $rating_max += $question['Question']['scale'];
                                $rating_real += $answer['Answers'][$question['Question']['id']];
                            }
                        }

                        $score_max = $rating_max/$count_answers;
                        $score_real = $rating_real/$count_answers;
                        $gsi = $rating_real/$rating_max*10;
                    ?>
                    <strong><?php echo number_format($gsi, 1, '.', ''); ?></strong>
                </td>
                <td>
                    <?php echo $answer['Guest']['id']; ?>&nbsp;
                    <?php if(!empty($answer['Guest']['comment_customer'])) { ?>
                        <span class="glyphicon glyphicon-comment" data-toggle="tooltip" data-placement="top" title="<?php echo $answer['Guest']['comment_customer']; ?>"></span>
                    <?php } ?>
                    &nbsp;
                </td>
                <td>
                    <?php echo $visit_times[$answer['Guest']['visit_time']]; ?>
                </td>
                <td>
                    <?php echo $guest_types[$answer['Guest']['guest_type']]; ?>
                </td>
                <td>
                    <?php echo $this->Time->format($formats['datetime'], $answer['Guest']['created']); ?>
                </td>
                <td width="70">
                    <div class="btn-group btn-group-xs">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Option <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                                echo '<li>'.$this->Html->link('<span class="glyphicon glyphicon-info-sign"></span> '.__('Show detail info', true), '#', array('id' => 'rating-info-'.$answer['Guest']['id'], 'class' => 'rating-info ', 'title' => __('Show detail info', true), 'escape' => false)).'</li>';
                                if($answer['Guest']['status'] == 1) {
                                    echo '<li>'.$this->Html->link('<span class="glyphicon glyphicon-ban-circle"></span> '.__('Remark as invalid', true), '#', array('id' => 'mark-invalid-'.$answer['Guest']['id'], 'class' => 'mark-invalid ', 'title' => __('Remark as invalid', true), 'escape' => false)).'</li>';
                                } elseif($answer['Guest']['status'] == 0) {
                                    echo '<li>'.$this->Html->link('<span class="glyphicon glyphicon-ok-circle"></span> '.__('Remark as valid', true), '#', array('id' => 'mark-valid-'.$answer['Guest']['id'], 'class' => 'mark-valid ', 'title' => __('Remark as valid', true), 'escape' => false)).'</li>';
                                }
                                echo '<li>'.$this->Html->link('<span class="glyphicon glyphicon-remove-circle"></span> '.__('Delete rating', true), '#', array('id' => 'mark-delete-'.$answer['Guest']['id'], 'class' => 'mark-delete ', 'title' => __('Delete rating', true), 'escape' => false)).'</li>';
                            ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>

    <tfoot>
        <tr>
            <td class="text-center lead">
                &empty;
            </td>
            <?php foreach($poll['Groups'] as $group) { ?>
                <?php foreach($group['Questions'] as $question) { ?>
                    <td class="text-center lead">
                        <?php
                            if(isset($averages[$question['Question']['id']])) {
                                $count = count($averages[$question['Question']['id']]);
                                $overall = 0;
                                foreach($averages[$question['Question']['id']] as $av) {
                                    $overall += $av;
                                }
                                if($count > 0) {
                                    echo round($overall/$count, 1);
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '-';
                            }
                        ?>
                    </td>
                <?php } ?>
            <?php } ?>
            <td class="text-center lead"><strong><?php echo round($scorecard['current']['average_overall']*(10/$max_scale), 1); ?></strong></td>
            <td colspan="5"></td>
        </tr>
    </tfoot>

</table>

<script>
    $(document).ready(function() {
        $('.glyphicon-comment').tooltip({html: true});
        $('.table-tooltip').tooltip({html: true});
    });
</script>

<!-- mark guest/answerset invalid -->
<div id="modal-mark-invalid" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Remark as invalid', true); ?></h3>
            </div>

            <div class="modal-body">
                <p>
                    <?php echo __('Are you sure you want to remark this rating as invalid?', true); ?>
                </p>

                <div class="alert alert-info">
                    <i>
                        <?php echo __('Note: Ratings marked as invalid will not be respected in the calculations and drawing of the rating-data!', true); ?>
                    </i>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-mark-invalid" style="display: none;"/>
                <button class="btn btn-default" id="mark-invalid-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-warning" id="mark-invalid-confirm" type="button"><?php echo __('Confirm', true); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- mark guest/answerset valid -->
<div id="modal-mark-valid" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Remark as valid', true); ?></h3>
            </div>

            <div class="modal-body">
                <p>
                    <?php echo __('Are you sure you want to remark this rating as valid?', true); ?>
                </p>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-mark-delete" style="display: none;"/>
                <button class="btn btn-default" id="mark-valid-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="mark-valid-confirm" type="button"><?php echo __('Confirm', true); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- mark delete -->
<div id="modal-mark-delete" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Remark as delete', true); ?></h3>
            </div>

            <div class="modal-body">
                <p>
                    <?php echo __('Are you sure you want to delete this rating?', true); ?>
                </p>
                <div class="alert alert-danger">
                    <i>
                        <?php echo __('Note: The rating will be deleted permanently! Only use this option if you are sure the rating was a scam or otherwise irregular.', true); ?>
                    </i>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-mark-delete" style="display: none;"/>
                <button class="btn btn-default" id="mark-delete-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-danger" id="mark-delete-confirm" type="button"><?php echo __('Confirm', true); ?></button>
            </div>
        </div>
    </div>
</div>


<!-- rating info -->
<?php Configure::write('debug', 1); ?>
<div id="modal-rating-info" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Rating/Guest information', true); ?></h3>
            </div>

            <div class="modal-body">
                <div id="wrapper-rating-info">
                    <div class="row">
                        <?php echo $this->element('Polls/wrapper_rating_info'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-rating-info" style="display: none;"/>
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php echo __('Close', true); ?></button>
            </div>
        </div>
    </div>
</div>
