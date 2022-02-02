<?php
    $this->set('title_for_layout', __('Privacy policy', true));

    // Set specific meta tags
    $meta_keywords = __('privacy, policy, legals, guestify, rules', true);
    $meta_description = __('On this page you read the privacy policy of guestify.', true);
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
    <h1><?php echo __('Privacy policy', true); ?></h1>

    <div class="row">
        <div class="col-xs-12">
            <div class="clearfix">
                <div class="clearfix">
                    <div class="row">
                        <div class="col-xs-8 text-white">
                            <?php echo $this->element('privacy-policy-en'); ?>
                            <?php /*
                            <p><?php echo __('Protection of your privacy and safety is our top priority when we design and develop our service, and we will keep it that way during our communication and interaction.', true); ?> </p>
                            <p><?php echo __('guestify provides this Privacy Policy to inform you of our policies and procedures regarding the collection, use and disclosure of personal information we receive from users of www.guestify.net. This Privacy Policy applies only to information that you provide to us through this Site. Our Privacy Policy may be updated from time to time, and we will notify you of any material changes by posting the new Privacy Policy on the Site.', true); ?> </p>
                            <p><?php echo __('We promise that we will not act outside of our privacy policy and abuse your personal information and data.', true); ?> </p>
                            */?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
