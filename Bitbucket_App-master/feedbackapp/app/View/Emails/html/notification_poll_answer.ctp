<?php $media_host = Configure::read('CDN.Host'); ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td valign="top">
            <h3 style="font-size: 20px; margin: 0px 0px 10px 0; text-align: center;"><?php echo __('You have received a new rating!', true); ?></h3>
        </td>
    </tr>
</table>

<?php
    $score  = 0;
    $rating_max     = 0;
    $rating_real    = 0;
    $count_answers  = 0;

    foreach($poll['Groups'] as $group) {
        foreach($group['Questions'] as $question) {
            $count_answers++;
            $rating_max += $question['Question']['scale'];
            $rating_real += $answers[$question['Question']['id']]['Answer']['rating'];
        }
    }

    $score_max = $rating_max/$count_answers;
    $score_real = $rating_real/$count_answers;
    $gsi = $rating_real/$rating_max*10;
?>
<table cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 1em;">
    <tr>
        <td valign="top">
            <p style="font-size: 15px; margin-bottom: 1em;"><?php echo __('Location name'); ?>:  <strong><?php echo $poll['Host']['name']; ?></strong></p>
            <p style="font-size: 15px; margin-bottom: 1em;"><?php echo __('Poll title'); ?>: <?php echo $poll['Poll']['title']; ?> </p>
            <?php if(!empty($guest['Guest']['comment_customer'])) { ?>
                <cite style="background: #fff; padding: 10px; display: block; font-size: 16px; margin: 10px 40px 0 0; "><span style="font-size: 30px;">&bdquo;</span><?php echo nl2br(h(strip_tags($guest['Guest']['comment_customer']))); ?><span style="font-size: 30px;">&ldquo;</span></cite>
            <?php } ?>
        </td>
        <td width="120" valign="top">
            <div style="background-color: #082530; color: #eee; text-align: center; width: 120px; margin-bottom: 10px;">
                <span style="display: block;font-size: 13px;background-color: #fff;padding: 1px;color: #082530;">GSI</span>
                <h2 style="font-size: 3.6em; margin:0;"> <?php echo number_format($gsi, 1, '.', ''); ?> </h2>        
            </div>
            <p style="text-align: center;"><a href="https://guestify.net/first-steps" style="font-size: 12px;"><?php echo __('Explain the GSI'); ?></a></p>
        </td>
    </tr>
</table>



<?php foreach($poll['Groups'] as $group) { ?>
    <table cellpadding="0" cellspacing="0" style="font-size: 13px; width: 100%; margin-bottom: 1em;">
        <thead>
            <tr>
                <th style="border-bottom: 2px #ccc solid; padding: 5px; text-align: left;"><?php echo $group['Group']['name']; ?></th>
                <th style="border-bottom: 2px #ccc solid; padding: 5px; text-align: right;"><?php echo __('Rating', true); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($group['Questions'] as $question) { ?>
                <tr>
                    <td style="border-top: 1px #ddd solid; padding: 5px;"><?php echo $question['Question']['question']; ?></td>
                    <td style="border-top: 1px #ddd solid; padding: 5px; text-align: right;">
                        <?php echo $answers[$question['Question']['id']]['Answer']['rating']; ?> <small>/<?php echo $question['Question']['scale']; ?></small>
                    </td>
                </tr>
            <?php } ?>
        </tbody>        
    </table>
<?php } ?>
<table cellpadding="0" cellspacing="0" style="font-size: 13px; width: 100%; margin-bottom: 1em; border: 2px #ddd solid;">
    <tfoot>
        <tr>
            <td style="padding: 5px;"><?php echo __('Guest average rating', true); ?></td>
            <td style="padding: 5px; text-align: right;">
                <?php echo number_format($score_real, 2, '.', ''); ?>/<small><?php echo $question['Question']['scale']; ?></small>
            </td>
        </tr>
    </tfoot>
</table>

<div style="text-align: center; margin: 30px 20px ;"><?php echo $this->Html->link(__('View all ratings of this day', true), Configure::read('NON_SSL_HOST_PUBLIC') . DS . 'polls' . DS . 'showDay' . DS . $poll['Poll']['id'] . DS . date('d.m.Y', strtotime($guest['Guest']['created'])), array('style' => 'font-size: 1.4em; text-decoration: none; background-color: #059ec7; color: #fff; padding: 10px; text-transform: uppercase; font-weight: 700;')); ?></div>

<h3 style="font-size: 15px; margin: 0 0 10px 0;"><?php echo __('More useful information', true); ?></h3>
<table cellpadding="0" cellspacing="0" style="font-size: 13px; width: 100%;">
    <tr>
        <td width="150px" valign="top"><?php echo __('Guest type', true); ?></td>
        <td valign="top">
            <?php echo $guest_types[$guest['Guest']['guest_type']]; ?>
        </td>
    </tr>
    <tr>
        <td valign="top"><?php echo __('Visit time', true); ?></td>
        <td valign="top">
            <?php echo $visit_times[$guest['Guest']['visit_time']]; ?>
        </td>
    </tr>
    <tr>
        <td valign="top"><?php echo __('Guest comment', true); ?></td>
        <td valign="top">
            <?php echo nl2br(h(strip_tags($guest['Guest']['comment_customer']))); ?>
        </td>
    </tr>
    <tr>
        <td valign="top"><?php echo __('Guest name', true); ?></td>
        <td valign="top">
            <?php echo nl2br(h(strip_tags($guest['Guest']['name']))); ?>
        </td>
    </tr>
    <tr>
        <td valign="top"><?php echo __('Guest email', true); ?></td>
        <td valign="top">
            <?php echo nl2br(h(strip_tags($guest['Guest']['email']))); ?>
        </td>
    </tr>
    <tr>
        <td valign="top"><?php echo __('IP', true); ?></td>
        <td valign="top">
            <?php echo $guest['Guest']['ip']; ?>
        </td>
    </tr>
    <tr>
        <td valign="top"><?php echo __('User Agent', true); ?></td>
        <td valign="top">
            <?php echo $guest['Guest']['user_agent']; ?>
        </td>
    </tr>
</table>


