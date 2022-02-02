<h2 style="font-size: 20px; "><?php echo __('Hello', true); ?> <?php echo $report['User']['firstname']; ?>!</h2>
<p><?php echo __('This is your weekly report for your ratings on guestify!', true); ?></p>
<h3 style="font-size: 16px; "><?php echo __('Week of', true); ?> <?php echo $this->Time->format($formats[$locale]['date'], $week_start); ?> - <?php echo $this->Time->format($formats[$locale]['date'], $week_end); ?></h3>

<?php foreach($report['Host'] as $host) { ?>
    <?php if(empty($host['Poll'])) { continue; } ?>
    <h3 style="color: #31b0d5; font-size: 16px; margin: 0 0 5px 0;"><?php echo $host['name']; ?></h3>
    <hr  style="border: 0 none; border-bottom: 1px #ccc dashed; " />
    <?php foreach($host['Poll'] as $poll) { ?>
        <h4 style="color: #31b0d5; font-size: 14px; margin: 0 0 10px 0;"><?php echo __('Poll', true); ?>: <?php echo $poll['title']; ?></h4>
        <table cellpadding="0" cellspacing="0" style="font-size: 16px; width: 100%;">
            <thead>
                <tr>
                    <th style="border-top: 2px #ccc solid; padding: 5px;"></th>
                    <th style="border-top: 2px #ccc solid; padding: 5px; font-size: 12px; text-transform: uppercase;"><?php echo __('Last week', true); ?></th>
                    <th style="border-top: 2px #ccc solid; padding: 5px; font-size: 12px; text-transform: uppercase;"><?php echo __('Week before', true); ?></th>
                    <th style="border-top: 2px #ccc solid; padding: 5px; font-size: 12px; text-transform: uppercase;"><?php echo __('Trend', true); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border-top: 1px #ddd solid; padding: 5px;"><?php echo __('Guest Satisfaction Index', true); ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"><?php $gsi_current = round($poll['Report']['current']['average_overall']*(10/$poll['Report']['max_scale']), 1); echo $gsi_current; ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"><?php $gsi_prev = round($poll['Report']['prev']['average_overall']*(10/$poll['Report']['max_scale']), 1); echo $gsi_prev; ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;">
                        <?php
                            if($gsi_prev != 0) {
                                $difference = $gsi_current - $gsi_prev;
                                $factor = $difference / $gsi_prev;
                                //$trend = round(($gsi_current / $gsi_prev * 100), 0);
                                $trend = round(($factor * 100), 0);
                                if($gsi_prev > $gsi_current) {
                                    //$trend = $trend -100;
                                    echo '<span style="color: #AA0000;">'.$trend.'%</span>';
                                } elseif($gsi_prev < $gsi_current) {
                                    echo  '<span style="color: #00AB00;">+'.$trend.'%</span>';
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '-';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 1px #ddd solid; padding: 5px;"><?php echo __('Score', true); ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"><?php echo $poll['Report']['current']['average_overall']; ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"><?php echo $poll['Report']['prev']['average_overall']; ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;">
                        <?php
                            if($poll['Report']['prev']['average_overall'] != 0) {
                                $difference_score = $poll['Report']['current']['average_overall'] - $poll['Report']['prev']['average_overall'];
                                $factor_score = $difference_score / $poll['Report']['prev']['average_overall'];
                                //$trend_score = round(($poll['Report']['current']['average_overall'] / $poll['Report']['prev']['average_overall'] * 100), 0);
                                $trend_score = round(($factor_score * 100), 0);
                                if($poll['Report']['prev']['average_overall'] > $poll['Report']['current']['average_overall']) {
                                    //$trend_score = $trend_score -100;
                                    echo '<span style="color: #AA0000;">'.$trend_score.'%</span>';
                                } elseif($poll['Report']['prev']['average_overall'] < $poll['Report']['current']['average_overall']) {
                                    echo  '<span style="color: #00AB00;">+'.$trend_score.'%</span>';
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '-';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 1px #ddd solid; padding: 5px;"><?php echo __('Ratings', true); ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"><?php echo $poll['Report']['current']['guest_count_overall']; ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"><?php echo $poll['Report']['prev']['guest_count_overall']; ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"></td>
                </tr>
                <tr>
                    <td style="border-top: 1px #ddd solid; padding: 5px;"><?php echo __('Views', true); ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"><?php echo $poll['Report']['views']['current']; ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"><?php echo $poll['Report']['views']['prev']; ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: center;"></td>
                </tr>
            </tbody>

        </table>

        <hr style="border: 0 none; border-bottom: 1px #ccc dashed; " />
        <p>&nbsp;</p>

    <?php } ?>

<?php } ?>


<p>
    <?php echo __('All the best, your guestify team!', true); ?>
</p>
