<?php echo $this->Html->css('theme_'.$poll['Poll']['theme_id']); ?>
<style type="text/css">
    body, legend {
        color: #<?php echo $poll['Poll']['color']; ?>;
    }
</style>

<header>
    <div class="content-area container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <?php if(!empty($poll['Host']['logo'])) { ?>
                    <div class="row branded withlogo">        
                        <div class="col-xs-3">
                            <?php
                                $logo = $poll['Host']['logo'];
                                echo $this->Html->image(Configure::read('CDN.Host').'hosts/300/'.$logo, array('alt' => $poll['Host']['name'], 'class' => 'img-rounded img-responsive')); 
                            ?>
                        </div>
                        <div class="col-xs-9">
                            <h1><?php echo __('Guest Feedback', true); ?></h1>
                            <h2><?php echo $poll['Host']['name']; ?></h2>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row branded">        
                        <div class="col-xs-3">

                            <?php
                                echo $this->Html->image('/graphics/logos/150/guestify_logo_word_brand_regular_150.png', array('alt' => $poll['Host']['name'], 'class' => 'img-responsive')); 
                            ?>
                        </div>
                        <div class="col-xs-9">
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
                    $(document).ready(function() {

                        $('html, body').animate({
                            scrollTop: $("div.content-area").offset().top
                        }, 100);

                        $(document).on('click', '.trigger-vote', function() {

                            var trigger = $(this);

                            var temp = trigger.attr('id').split('-');

                            var question_id = temp[1];
                            var answer_id   = temp[2];

                            $('#answer_'+question_id).val(answer_id);

                            var container = $(this).closest('div.scale-container');

                            container.find('.trigger-vote').removeClass('active');

                            if(trigger.hasClass('active')) {
                                trigger.removeClass('active');
                            } else {
                                trigger.addClass('active');
                            }

                            return false;
                        });

                        $(document).on('click', '#trigger-reset', function() {
                            $('.trigger-vote').removeClass('active');
                            $('html,body').animate({scrollTop: 0});
                            return false;
                        });

                    });
                </script>

                <style type="text/css">
                    a.trigger-vote {
                        cursor: pointer!important;
                    }
                </style>

                <?php
                    $col_class = 'col-xs-3 quarter-layout ';
                    if($max_scale == 4) {
                        $col_class = 'col-xs-3 quarter-layout ';
                    } else if($max_scale == 5 ) {
                        $col_class = 'col-xs-2 fifth-layout ';
                    } else if($max_scale == 6 ) {
                        $col_class = 'col-xs-2 sixth-layout ';
                    }
                ?>


                <div class="clearfix">

                    <?php if($done != 1) { ?>

                        <?php #pr($errors); ?>
                        <?php echo $this->Form->create('Poll', array('url' => $this->here)); ?>

                            <?php echo $this->Form->input('Guest.poll_id', array('type' => 'hidden', 'value' => $poll['Poll']['id'])); ?>
                            <?php echo $this->Form->input('Guest.pin', array('type' => 'hidden', 'value' => $poll['Poll']['code'])); ?>

                            <!-- Part 1: db-based questions -->
                            <?php $group_count = count($poll['Groups']); ?>
                            <?php foreach($poll['Groups'] as $group) { ?>
                                <div id="question-set-<?php echo $group['Group']['id']; ?>" class="panel panel-default">
                                    <div class="panel-body">
                                        <fieldset>
                                            <?php if($group_count > 1) { ?>
                                                <legend><?php echo $group['Group']['order']; ?>. <?php echo $group['Group']['name']; ?></legend>
                                            <?php } ?>
                                            <div class="row text-muted scalelegend">
                                                <div class="col-xs-6 text-left">
                                                    <small>
                                                        <span>
                                                            <span class="glyphicon glyphicon-menu-left"></span> <?php echo __('Negative'); ?>
                                                        </span>
                                                    </small>
                                                </div>
                                                <div class="col-xs-6 text-right">
                                                    <small>                                                
                                                        <span>
                                                            <?php echo __('Positive'); ?> <span class="glyphicon glyphicon-menu-right"></span> 
                                                        </span>
                                                    </small>

                                                </div>
                                            </div>
                                            <?php foreach($group['Questions'] as $question) { ?>
                                            <!-- Question #1 -->

                                            <div id="question-id-<?php echo $question['Question']['id']; ?>" class="question row">
                                                <div class="col-xs-12">
                                                    <label><?php echo $question['Question']['question']; ?></label>
                                                    <?php
                                                        echo $this->Form->input('Poll.answer.'.$question['Question']['id'], array(
                                                            'type' => 'hidden',
                                                            'id' => 'answer_'.$question['Question']['id']
                                                        ));
                                                    ?>

                                                    <div class="scale-container row">
                                                        <?php for($i = 0; $i < $question['Question']['scale']; $i++) { ?>
                                                            <div class="<?php echo $col_class; ?>">
                                                                <?php
                                                                    $class = '';
                                                                    if(
                                                                        isset($this->data['Poll']['answer'][$question['Question']['id']]) &&
                                                                        ($this->data['Poll']['answer'][$question['Question']['id']] == $i+1)) {
                                                                        $class = 'active';
                                                                    }
                                                                ?>
                                                                <a id="vote-<?php echo $question['Question']['id']; ?>-<?php echo $i+1; ?>" class="scale_<?php echo $i+1; ?> scale_unit trigger-vote <?php echo $class; ?>"><?php echo $i+1; ?></a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                        $style = 'display: none;';
                                                        if(isset($errors) && in_array($question['Question']['id'], $errors)) {
                                                            $style = '';
                                                        }
                                                    ?>

                                                    <div class="error-message" style="<?php echo $style; ?>">
                                                        <?php echo __('Please answer this question!', true); ?>
                                                    </div>
                                                    
                                                </div>
                                            </div>


                                            <?php } ?>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- end of Part 2 -->

                            

                            <!-- Part 2: guest-depending questions -->
                            <div id="question-set-04" class="panel panel-default">
                                <div class="panel-body">
                                    <fieldset >
                                        <legend><?php echo __('Visit', true); ?></legend>
                                        <!-- Question #12 >>> goes into guest record -->
                                        <div id="question-id-12" class="question ">
                                            <?php
                                                echo $this->Form->input('Guest.guest_type', array(
                                                    'type' => 'select',
                                                    'label' => false,
                                                    'div' => array('class' => 'form-group'),
                                                    'empty' => __('Is this your first visit...?', true),
                                                    'options' => $guest_types,
                                                    'class' => 'form-control input-lg'
                                                ));
                                            ?>
                                        </div>
                                        <!-- Question #13 >>> goes into guest record -->
                                        <div id="question-id-13" class="question ">
                                            <?php
                                                echo $this->Form->input('Guest.visit_time', array(
                                                    'type' => 'select',
                                                    'label' => false,
                                                    'div' => array('class' => 'form-group'),
                                                    'empty' => __('Visit time...', true),
                                                    'options' => $visit_times,
                                                    'class' => 'form-control input-lg'
                                                ));
                                            ?>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <!-- end of Part 2 -->

                            <div id="customer-comment" class="panel panel-default">
                                <div class="panel-body">
                                    <fieldset>
                                        <legend><?php echo __('Comment', true); ?> (<?php echo __('optional', true); ?>)</legend>
                                        <?php
                                            echo $this->Form->input('Guest.comment_customer', array(
                                                'type' => 'textarea',
                                                'label' => false,
                                                'class' => 'form-control',
                                                'div' => array('class' => 'form-group'),
                                            ));
                                        ?>
                                    </fieldset>
                                </div>
                            </div>

                            <div id="customer-comment" class="panel panel-default">
                                <div class="panel-body">
                                    <fieldset>
                                        <legend><?php echo __('Contact', true); ?> (<?php echo __('optional', true); ?>)</legend>
                                        <?php
                                            echo $this->Form->input('Guest.name', array(
                                                'type' => 'text',
                                                'placeholder' => __('Your name', true),
                                                'label' => false,
                                                'class' => 'form-control input-lg',
                                                'div' => array('class' => 'form-group'),
                                            ));
                                            echo $this->Form->input('Guest.email', array(
                                                'type' => 'text',
                                                'placeholder' => __('Your email', true),
                                                'label' => false,
                                                'class' => 'form-control input-lg',
                                                'div' => array('class' => 'form-group'),
                                            ));
                                        ?>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="clearfix"> 
                                <fieldset>
                                    <button type="submit" name"submit" class="btn btn-block btn-success btn-lg"><span class="glyphicon glyphicon-ok-sign"></span> <?php echo __('Send feedback', true); ?></button>

                                    <!-- replace this with a spinner! -->
                                    <!--<span id="submit-spinner">Submit-Spinner</span>-->

                                    <input id="trigger-reset" type="reset" name="reset" class="btn btn-sm btn-block" value="<?php echo __('Reset', true); ?>" />
                                </fieldset>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    <?php } ?>

                    <?php if($done == 1) { ?>
                        <!-- show this when poll is completed -->
                        <div id="complete-wrapper">

                            <div class="confirm-message text-center">
                                <span class="OK"></span>
                                <strong><?php echo __('Thank your very much!', true); ?></strong>
                                <p><?php echo __('We appreciate your feedback and we will do our best to be better.', true); ?></p>
                            </div>


                                <?php if(!empty($values_socials[1]) || !empty($values_socials[5]) || !empty($values_socials[6] || !empty($values_socials[7]) || !empty($values_socials[8]) || !empty($values_socials[9]))) { ?>
                                    <h3 class="text-center"><?php echo __('Public Check in &amp; rating!', true); ?></h3>
                                <?php } ?>

                                <nav class="text-center">
                                    <ul class="buttonlist">
                                        <?php if(!empty($values_socials[1])) { ?>
                                            <li><a class="button facebook" href="<?php echo $values_socials[1]; ?>" target="_blank">Facebook</a></li>
                                        <?php } ?>

                                        <?php if(!empty($values_socials[5])) { ?>
                                            <li><a class="button foursquare" href="<?php echo $values_socials[5]; ?>" target="_blank">Foursquare</a></li>
                                        <?php } ?>

                                        <?php if(!empty($values_socials[6])) { ?>
                                            <li><a class="button yelp" href="<?php echo $values_socials[6]; ?>" target="_blank">Yelp</a></li>
                                        <?php } ?>

                                        <?php if(!empty($values_socials[7])) { ?>
                                            <li><a class="button tripadvisor" href="<?php echo $values_socials[7]; ?>" target="_blank">TripAdvisor</a></li>
                                        <?php } ?>

                                        <?php if(!empty($values_socials[8])) { ?>
                                            <li><a class="button qype" href="<?php echo $values_socials[8]; ?>" target="_blank">Qype</a></li>
                                        <?php } ?>

                                        <?php if(!empty($values_socials[9])) { ?>
                                            <li><a class="button restkritik" href="<?php echo $values_socials[9]; ?>" target="_blank">Restaurant Kritik</a></li>
                                        <?php } ?>
                                    </ul>
                                </nav>

                                <?php if(!empty($values_socials[1]) || !empty($values_socials[2])) { ?>
                                    <h3 class="text-center"><?php echo __('Follow us!', true); ?></h3>
                                    <nav class="text-center">
                                        <ul class="buttonlist">
                                            <?php if(!empty($values_socials[1])) { ?>
                                                <li><a class="button facebook" href="<?php echo $values_socials[1]; ?>" target="_blank"><?php echo __('Like us on Facebook', true); ?></a></li>
                                            <?php } ?>
                                            <?php if(!empty($values_socials[2])) { ?>
                                                <li><a class="button twitter" href="<?php echo $values_socials[2]; ?>" target="_blank">Twitter</a></li>
                                            <?php } ?>
                                        </ul>
                                    </nav>
                                <?php } ?>

                        </div>
                    <?php } ?>
                    <!-- end of complete wrapper -->

                </div>
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
                    <small><?php echo __('Ratings will be stored anonymously by default for', true); ?><br /> <strong><?php echo $poll['Host']['name']; ?></strong></small><br />
                    <small><?php echo __('Guest feedback powered by', true); ?> <a href="<?php echo Configure::read('NON_SSL_HOST_PUBLIC'); ?>" target="_blank">guestify.net</a></small><br />
                </p>
            </div>
        </div>
    </div>
</footer>
