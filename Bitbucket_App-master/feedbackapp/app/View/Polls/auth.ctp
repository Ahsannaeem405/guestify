<header>
    <div class="content-area container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <?php if(!empty($poll['Host']['logo'])) { ?>
                    <div class="row branded withlogo">        
                        <div class="col-xs-4">
                            <?php
                                $logo = $poll['Host']['logo'];
                                echo $this->Html->image(Configure::read('CDN.Host').'hosts/300/'.$logo, array('alt' => $poll['Host']['name'], 'class' => 'img-rounded img-responsive')); 
                            ?>
                        </div>
                        <div class="col-xs-8">
                            <h1><?php echo __('Guest Feedback', true); ?></h1>
                            <h2><?php echo $poll['Host']['name']; ?></h2>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row branded">        
                        <div class="col-xs-4">
                            <?php
                                echo $this->Html->image('/graphics/logos/150/guestify_logo_word_brand_regular_150.png', array('alt' => $poll['Host']['name'], 'class' => 'img-responsive')); 
                            ?>
                        </div>
                        <div class="col-xs-8">
                            <h1><?php echo __('Guest Feedback', true); ?></h1>
                            <h2><?php echo $poll['Host']['name']; ?></h2>
                        </div>
                    </div>
                    
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<content>
    <div class="content-area container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <?php echo $this->Session->flash(); ?>
                <script>
                    $(document).on('click', 'a.open-language-selection', function() {
                        $(".lang-selector" ).slideToggle( "fast", function() {
                            return false;
                        });
                    });
                </script>
                <div class="jumbotron text-center">
                    <h2><?php echo __('Hello!'); ?></h2>
                    <p class="lead"><?php echo __('We would love to read your feedback.'); ?></p>
                </div>
                <div class="language-box panel panel-default">
                    <div class="panel-body">
                        <div class="lang-selected">

                            <a class="open-language-selection">
                                <i class="glyphicon glyphicon-chevron-down margin5px pull-right"></i>
                                <?php
                                    $locale = $this->Session->read('Config.language');
                                    if(empty($locale)) {
                                        $locale = Configure::read('Language.default');
                                    }
                                    if($locale == 'deu') {
                                        echo $this->Html->tag('span', __('German', true), array('class' => 'flag de'));
                                    } elseif($locale == 'eng') {
                                        echo $this->Html->tag('span', __('English', true), array('class' => 'flag en'));
                                    }
                                ?>
                            </a>

                        </div>
                        <div class="lang-selector ">
                            <hr />
                            <?php echo $this->Html->link(__('German'), array('controller' => 'polls', 'action' => 'changeLanguage', 'deu'), array('class' => 'flag de btn', 'title' => __('German'))); ?>
                            <?php echo $this->Html->link(__('English'), array('controller' => 'polls', 'action' => 'changeLanguage', 'eng'), array('class' => 'flag en btn', 'title' => __('English'))); ?>
                            <?php /*
                            <?php echo $this->Html->link(__('Spanish'), array('controller' => 'polls', 'action' => 'changeLanguage', 'esp'), array('class' => 'flag es btn disabled', 'title' => __('Spanish').' - '.__('Coming soon'))); ?>
                            <?php echo $this->Html->link(__('French'), array('controller' => 'polls', 'action' => 'changeLanguage', 'fre'), array('class' => 'flag fr btn disabled', 'title' => __('French').' - '.__('Coming soon'))); ?>
                            <?php echo $this->Html->link(__('Italian'), array('controller' => 'polls', 'action' => 'changeLanguage', 'ita'), array('class' => 'flag ie btn disabled', 'title' => __('Italian').' - '.__('Coming soon'))); ?>
                            <?php echo $this->Html->link(__('Japanese'), array('controller' => 'polls', 'action' => 'changeLanguage', 'jpa'), array('class' => 'flag jp btn disabled', 'title' => __('Japanese').' - '.__('Coming soon'))); ?>
                            <?php echo $this->Html->link(__('Chinese'), array('controller' => 'polls', 'action' => 'changeLanguage', 'cz'), array('class' => 'flag cz btn disabled', 'title' => __('Chinese').' - '.__('Coming soon'))); ?>
                            <?php echo $this->Html->link(__('Dutch'), array('controller' => 'polls', 'action' => 'changeLanguage', 'nl'), array('class' => 'flag nl btn disabled', 'title' => __('Dutch').' - '.__('Coming soon'))); ?>
                            <?php echo $this->Html->link(__('Portuguese'), array('controller' => 'polls', 'action' => 'changeLanguage', 'pt'), array('class' => 'flag pt btn disabled', 'title' => __('Portuguese').' - '.__('Coming soon'))); ?>
                            */ ?>
                        </div>
                    </div>
                </div>

                <?php if($poll['Poll']['status'] == 1) { ?>
                    <div class="text-center">
                        <?php
                            echo $this->Form->create('Poll', array('url' => $this->here));
                            echo $this->Form->input('Poll.hash', array(
                                'type' => 'hidden',
                                'value' => $hash
                            ));
                            echo $this->Form->input('Poll.code', array(
                                'label' => false,
                                'class' => 'form-control input-lg',
                                'div' => array('class' => 'form-group'),
                                'placeholder' => __('Please enter PIN', true),
                            ));
                        ?>

                        <?php if(isset($errors['code']) && !empty($errors['code'])) { ?>
                            <div class="alert alert-danger">
                                <?php echo $errors['code']; ?>
                            </div>
                        <?php } ?>
                        <p><small><?php echo __('Please take the chance to read our privacy policy. With clicking on "Start Feedback", you accept our privacy policy.'); ?> <a href="<?php echo Configure::read('NON_SSL_HOST_PUBLIC'); ?>/privacy" class="btn btn-link btn-sm" title="<?php echo __('Privacy Policy'); ?>" target="_blank"><span class="glyphicon glyphicon-link"></span> <?php echo __('Privacy Policy'); ?></a></small></p>

                        <?php
                            echo $this->Form->button('<span class="glyphicon glyphicon-star"></span> '.__('Start Feedback', true), array('class' => 'btn btn-success btn-block btn-lg'));
                            echo $this->Form->end();
                        ?>

                        </div>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning text-center">
                        <?php echo __('We are sorry but this poll is currently deactivated!', true); ?>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>


</content>
<footer>
    <div class="content-area container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <hr />
                <p class="text-center">
                    <small><?php echo __('Ratings will be stored anonymously by default for', true); ?> <strong><?php echo $poll['Host']['name']; ?></strong>.</small><br />
                    <small><?php echo __('Guest feedback powered by', true); ?> <a href="<?php echo Configure::read('NON_SSL_HOST_PUBLIC'); ?>" target="_blank">guestify.net</a></small><br />
                </p>
            </div>
        </div>
    </div>
</footer>
