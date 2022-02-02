<?php    
    $title_for_layout = __('You are successfully logged out.', true);
    $this->set('title_for_layout', $title_for_layout);

    // Set specific meta tags
    $meta_keywords = __('email, password, logout, guestify, profile, preferences', true);
    $meta_description = __('On this page you are successfully logged out from guestify.', true);
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
        <h1 class="text-center"><a href="/login"><img src="/graphics/logos/300/guestify_logo_word_brand_300.png" /></a></h1>
        <div class="alert alert-success"><h3>Good bye!</h3></div>
        <?php echo $this->element('Users/login');?>
    </div>


    <div class="col-xs-4"></div>

    </div>

</div>
