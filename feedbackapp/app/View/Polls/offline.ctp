<header>
    <div class="content-area container">
        <div class="row branded">        
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <?php
                    echo $this->Html->image('/graphics/logos/150/guestify_logo_word_brand_regular_150.png', array('alt' => 'Guestify', 'class' => 'img-responsive')); 
                ?>
            </div>
        </div>
    </div>
</header>

<content>
    <div class="content-area container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <div class="text-center">
                    <div class="" style="background: #fcfcfc; padding: 30px; margin: 0 auto; ">
                        <img src="/graphics/walkingcat_white.gif" alt=""  />
                    </div>
                </div>
                <p>&nbsp;</p>
                <h1 class="text-center"><?php echo __('Meowww', true); ?></h1>
                <h2 class="text-center"><?php echo __('We are sorry, but the requested poll is currently not available!', true); ?></h2>
            </div>
            <div class="span1"></div>
        </div>
    </div>
</content>

<footer>
    <div class="content-area container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <p class="text-center">
                    <small><?php echo __('Guest feedback powered by', true); ?> <a href="<?php echo Configure::read('NON_SSL_HOST_PUBLIC'); ?>" target="_blank">guestify.net</a></small><br />
                </p>
            </div>
        </div>
    </div>
</footer>
