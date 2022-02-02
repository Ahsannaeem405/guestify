<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div id="wrapper">
        <div id="content">
            <table width="100%">
                <tr>
                    <td><h4 style=" font-weight:bold; padding-top:0;"><?php echo $poll['Host']['name']; ?></h4></td>
                    <td align="right">
                        <?php if(!empty($poll['Host']['logo'])) { ?>
                            <p><?php echo $this->Html->Image(Configure::read('CDN.Host').'hosts/300/'.$poll['Host']['logo'], array('align' => 'right', 'class' => 'host_img','width' => '1.5cm', 'alt' => $poll['Host']['name'])); ?></p>
                        <?php }  ?>
                    </td>
                </tr>
            </table>
            <div class="centered">
                <h2 style="margin: 0;"><?php echo __('Rate us!', true); ?></h2>
                <p style="font-size: 6pt; margin: 0 0 10px 0;">
                    <span><?php echo __('How satisfied are you?', true); ?></span> <span><?php echo __('We appreciate your feedback.', true); ?></span>
                </p>

                <?php if(!empty($poll['Poll']['text'])) { ?>
                    <p style="font-size: 6pt; margin: 0 0 10px 0;">
                        <strong><?php echo $poll['Poll']['text']; ?></strong>
                    </p>
                <?php } ?>


                <div class="qr-code">
                    <table width="100%" style="font-size: 6pt;">
                        <tr>
                            <td valign="top" align="left">
                                <?php echo $this->Html->Image('/img/qrcodes/'.$qrcode_300, array('width' => '2cm', 'align' => 'left')); ?>
                            </td>
                            <td valign="top">
                                <strong><?php echo __('Use QR-Code', true); ?></strong><br />
                                <?php echo __('or just type in this address into your browser:', true); ?><br />
                                <?php if(!empty($poll['Poll']['alt_url'])) { ?>
                                    <strong class="text-center"><?php echo $poll['Poll']['alt_url']; ?></strong><br /><br />
                                <?php } else { ?>
                                    <strong class=" text-center"><?php echo Configure::read('URL_feedbackapp').'/'.$poll['Poll']['hash']; ?></strong><br /><br />
                                <?php } ?>
                                <?php /* <strong><?php echo __('PIN', true); ?>: <?php echo $poll['Poll']['code']; ?></strong> */ ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <strong style="font-size: 7pt;"><?php echo __('How does it work?', true); ?></strong>
                <table style="width: 100%; text-align:center; font-size: 7pt;">
                    <tr>
                        <td style="width: 33%;">
                            <div class="step">
                                <img src="/graphics/qr-code.png" align="center" height="0.7cm" /><br />
                                <?php echo __('Step 1', true); ?><br />
                                <?php echo __('Scan QR code', true); ?>
                            </div>
                        </td>
                        <td style="width: 33%;">
                            <div class="step">
                                <img src="/graphics/smartphone.png" align="center"  height="0.7cm" /><br />
                                <?php echo __('Step 2', true); ?><br />
                                <?php echo __('Rate us', true); ?>
                            </div>
                        </td>
                        <td style="width: 33%;">
                            <div class="step">
                                <img src="/graphics/check_yes_circle.png" align="center" height="0.7cm" /><br />
                                <?php echo __('Step 3', true); ?><br />
                                <?php echo __('Send rating', true); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <h4 style="text-align: center; margin: 0; padding: 0; font-size: 8pt;"><?php echo __('Thank you!', true); ?></h4>

            <div id="footer" style="text-align:center; font-size: 5pt;">
                <span><?php echo __('All ratings are stored anonymously for', true); ?> <?php echo $poll['Host']['name']; ?></span>
            </div>
        </div>
    </div>

</body>
</html>
