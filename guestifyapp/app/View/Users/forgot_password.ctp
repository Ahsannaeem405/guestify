<?php    
    $title_for_layout = __('Forgot your password? Here you can recover it.', true);
    $this->set('title_for_layout', $title_for_layout);

    // Set specific meta tags
    $meta_keywords = __('email, password, recover, guestify, profile, preferences', true);
    $meta_description = __('With your email address, you can recover your password very easily.', true);
    echo $this->Html->meta(array('name' => 'keywords', 'content' => $meta_keywords), null, array('inline' => false));
    echo $this->Html->meta(array('name' => 'description', 'content' => $meta_description), null, array('inline' => false));

    // Facebook OpenGraph
    $seo_image = Configure::read('NON_SSL_HOST').'/graphics/logos/300/guestify_300_regular.jpg';
    echo $this->Html->meta(array('property' => 'og:title', 'content' => $title_for_layout), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:description', 'content' => $meta_description), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:image', 'content' => $seo_image), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:url', 'content' => Configure::read('NON_SSL_HOST') . $this->here), null, array('inline' => false));
?>

<div class="clearfix">
    <div class="col-lg-4"></div>

    <div class="col-lg-4 col-xs-12">
        <p class="text-center"><a href="/login"><img src="/graphics/logos/300/guestify_logo_word_brand_300.png" alt="Guestify" /></a></p>
        <div id="login">
            <div class="clearfix ">
                <div class="col-xs-12 well">
                    <h1 class="hide"><?php echo __('Forgot your password?'); ?></h1>
                    <?php echo $this->Form->create('User', array('url' => $this->here)); ?>
                        <p><?php echo __('You forgot your password? You can retreive your login by requesting a new password.', true); ?></p>
                        <?php
                            echo $this->Form->input('User.email', array(
                                'label' => __('Your email', true),
                                'type' => 'text',
                                'class' => 'form-control input-lg',
                                'div' => array('class' => 'form-group')
                            ));
                        ?>
                        <?php echo $this->Form->button(__('Send reactivation link', true), array('type' => 'submit', 'class' => 'btn btn-lg btn-success btn-block')); ?>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
