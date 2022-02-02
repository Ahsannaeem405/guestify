<?php
    $this->set('title_for_layout', __('Imprint', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
?>


<div class="clearfix">
    <h2><?php echo __('Imprint', true); ?> - <?php echo __('Angaben gemäß §5 TMG:', true); ?></h2>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel">
                <div class="panel-body">

                   <h4><?php echo __('Legal', true); ?></h4>


                    <p><?php echo __('Michael Bisse', true); ?></p>

                    <p><?php echo __('E-Mail: info [at] guestify.net', true); ?></p>

                    <p><?php echo __('Telefon', true); ?>: <?php echo __('012345678', true); ?></p>

                    <p><?php echo __('Telefax', true); ?>: <?php echo __('012345678', true); ?></p>

                    <h4><?php echo __('ADDRESS', true); ?></h4>

                    <p>
                        <?php echo __('4030 Wake Forest Road STE 439'); ?><br />
                        <?php echo __('Raleigh'); ?>, <?php echo __('NC, 27609'); ?>
                    </p> 


                </div>
            </div>
        </div>
    </div>

</div>
