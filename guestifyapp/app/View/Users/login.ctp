<?php 	
	$title_for_layout = __('Login here into your account at guestify', true);
    $this->set('title_for_layout', $title_for_layout);

    // Set specific meta tags
    $meta_keywords = __('login, user email, password, account, guestify', true);
    $meta_description = __('Here you login into your account at guestify and get access to all application features.', true);
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
        <?php echo $this->element('Users/login');?>

        <?php echo $this->Html->link(__('Register', true), '/register', array('class' => 'btn btn-default btn-block', 'escape' => false)); ?>
    </div>

</div>
