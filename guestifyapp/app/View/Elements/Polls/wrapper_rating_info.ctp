<div class="clearfix">

    <?php if(isset($rating_info)) { ?>
        <div class="row">

            <?php /*<pre><?php print_r($statuses_ratings); ?></pre> */ ?>
            <div class="col-lg-7 col-xs-12">

                <dl class="dl-horizontal">
                    <dt><?php echo __('Rating origin', true); ?></dt>
                    <dd>
                        <?php
                            $icon = '';
                            if(($rating_info['Guest']['pin'] != $poll['Poll']['code']) && (empty($rating_info['Guest']['api_account_id']))) {
                                $icon = 'pencil';
                                $label = __('Manual feedback', true);
                            }
                            if($rating_info['Guest']['pin'] == $poll['Poll']['code']) {
                                $icon = 'phone';
                                $label = __('Mobile feedback', true);
                            }
                            if(!empty($rating_info['Guest']['api_account_id'])) {
                                $icon = 'cloud';
                                $label = __('API feedback', true);
                            }

                            echo '<span class="glyphicon glyphicon-'.$icon.'"></span> '.$label;
                        ?>
                    </dd>


                    <dt><?php echo __('Guest ID', true); ?></dt>
                    <dd>
                        <?php echo $rating_info['Guest']['id']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Pin used', true); ?></dt>
                    <dd>
                        <?php echo $rating_info['Guest']['pin']; ?>
                        &nbsp;
                    </dd>

                    <dt><?php echo __('Guest type', true); ?></dt>
                    <dd>
                        <?php echo $guest_types[$rating_info['Guest']['guest_type']]; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Visit time', true); ?></dt>
                    <dd>
                        <?php echo $visit_times[$rating_info['Guest']['visit_time']]; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Status', true); ?></dt>
                    <dd>
                        <?php
                            if($rating_info['Guest']['status'] == 0) {
                                echo '<span class="label label-warning">'.$statuses_ratings[$rating_info['Guest']['status']].'</span>';
                            } elseif($rating_info['Guest']['status'] == 1) {
                                echo '<span class="label label-success">'.$statuses_ratings[$rating_info['Guest']['status']].'</span>';
                            }
                        ?>
                        &nbsp;
                    </dd>

                    <hr />

                    <dt><?php echo __('Comment', true); ?></dt>
                    <dd>
                        <blockquote><?php echo $rating_info['Guest']['comment_customer']; ?></blockquote>

                    </dd>
                    <dt><?php echo __('Name', true); ?></dt>
                    <dd>
                        <?php echo $rating_info['Guest']['name']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Email', true); ?></dt>
                    <dd>
                        <?php echo $rating_info['Guest']['email']; ?>
                        &nbsp;
                    </dd>


                    <hr />
                    <dt><?php echo __('Browser locale', true); ?></dt>
                    <dd>
                        <?php echo $rating_info['Guest']['language']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('IP', true); ?></dt>
                    <dd>
                        <?php echo $rating_info['Guest']['ip']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('User Agent', true); ?></dt>
                    <dd>
                        <?php echo $rating_info['Guest']['user_agent']; ?>
                        &nbsp;
                    </dd>


                    <hr />

                    <dt><?php echo __('Created', true); ?></dt>
                    <dd>
                        <?php echo CakeTime::format('Y-m-d H:i:s', strtotime($rating_info['Guest']['created'])); ?>
                    </dd>
                </dl>
            </div>
            <div class="col-lg-5 col-xs-12">
                <?php
                    $score 	        = 0;
                    $rating_max 	= 0;
                    $rating_real 	= 0;
                    $count_answers 	= 0;

                    foreach($poll['Groups'] as $group) {
                        foreach($group['Questions'] as $key_question => $question) {
                            $count_answers++;
                            $rating_max += $question['Question']['scale'];
                            $rating_real += $rating_info['Answer'][$question['Question']['id']]['rating'];
                        }
                    }

                    $score_max = $rating_max/$count_answers;
                    $score_real = $rating_real/$count_answers;
                    $gsi = $rating_real/$rating_max*10;
                ?>
                <div class="score">
                    <div class="gsi-background">
                        <img src="/graphics/backgrounds/img-noise-361x370_darkblue.png" class="img-circle" width="100" />

                        <div class="position_absolute">
                            <?php echo $this->Label->GsiLabel(round($gsi, 1)); ?>
                        </div>

                        <p class="jumbo text-white text-center">
                            <span><?php echo number_format($gsi, 1, '.', ''); ?></span>
                        </p>

                    </div>
                </div>
                <?php Configure::write('debug', 1); ?>
                <table class="table table-condensed">
                    <tbody>
                        <?php foreach($poll['Groups'] as $group) { ?>
                            <?php foreach($group['Questions'] as $key_question => $question) { ?>
                                <tr>
                                    <td>
                                        <?php echo $question['Question']['question']; ?>
                                    </td>
                                    <td>
                                        <?php echo $rating_info['Answer'][$question['Question']['id']]['rating']; ?>
                                    </td>
                                </tr>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</div>
