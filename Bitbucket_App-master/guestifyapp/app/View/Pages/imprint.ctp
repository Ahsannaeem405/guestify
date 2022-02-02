<?php
    $this->set('title_for_layout', __('Imprint', true));

    // Set specific meta tags
    $meta_keywords = __('imprint, address, legals, guestify, policy', true);
    $meta_description = __('On this page you read the imprint information of guestify.', true);
    echo $this->Html->meta(array('name' => 'keywords', 'content' => $meta_keywords), null, array('inline' => false));
    echo $this->Html->meta(array('name' => 'description', 'content' => $meta_description), null, array('inline' => false));


    // Facebook OpenGraph
    $seo_image = Configure::read('NON_SSL_HOST').'/graphics/logos/300/guestify_300_regular.jpg';
    echo $this->Html->meta(array('property' => 'og:title', 'content' => $title_for_layout), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:description', 'content' => $meta_description), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:image', 'content' => $seo_image), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:url', 'content' => Configure::read('NON_SSL_HOST') . $this->here), null, array('inline' => false));

    // Crumbs
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
?>


<div class="clearfix">
    <h2><?php echo __('Imprint', true); ?> </h2>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel">
                <div class="panel-body">

                   <!-- <h4><?php //echo __('Legal', true); ?></h4>-->


                    <p><?php echo __('Michael Bisse', true); ?></p>

                    <p><?php echo __('E-Mail: info [at] guestify.net', true); ?></p>

                   <!-- <p><?php //echo __('Telefon', true); ?>: <?php //echo __('012345678', true); ?></p>

                    <p><?php //echo __('Telefax', true); ?>: <?php //echo __('012345678', true); ?></p>

                    <h4><?php //echo __('ADDRESS', true); ?></h4>

                    <p>
                        <?php //echo __('4030 Wake Forest Road STE 439'); ?><br />
                        <?php //echo __('Raleigh'); ?>, <?php //echo __('NC, 27609'); ?>
                    </p> -->

                </div>
            </div>
        </div>
    </div>

</div>
