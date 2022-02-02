<?php
    $title_for_layout = __('Sign up now for free at guestify!', true);
    $this->set('title_for_layout', $title_for_layout);

    // Set specific meta tags
    $meta_keywords = __('user email, password, account, free, guestify, profile, preferences', true);
    $meta_description = __('A single email address and password gets you into your guestify account. Set up your profile and preferences in 4 easy steps.', true);
    echo $this->Html->meta(array('name' => 'keywords', 'content' => $meta_keywords), null, array('inline' => false));
    echo $this->Html->meta(array('name' => 'description', 'content' => $meta_description), null, array('inline' => false));

    // Facebook OpenGraph
    $seo_image = Configure::read('NON_SSL_HOST').'/graphics/logos/300/guestify_300_regular.jpg';
    echo $this->Html->meta(array('property' => 'og:title', 'content' => $title_for_layout), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:description', 'content' => $meta_description), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:image', 'content' => $seo_image), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:url', 'content' => Configure::read('NON_SSL_HOST') . $this->here), null, array('inline' => false));

    // JS Files
    echo $this->Html->script('jquery.simplecaptcha-0.2', false);

    // Read locale
    $locale = $this->Session->read('Config.language');
?>

<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="clearfix">
    &nbsp;
</div>

<div class="clearfix">

    <div class="row">

        <div class="col-xs-12  col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <p class="text-center"><a href="/login"><img src="/graphics/logos/300/guestify_logo_word_brand_300.png" alt="Guestify" /></a></p>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-right">
                        <?php #echo $this->element('languages-flat'); ?>
                    </div>
                    <h1><?php echo __('Free Account setup', true); ?></h1>
                </div>

                <div class="panel-body">
                    <div class="stepwizard">
                        <div class="stepwizard-row">
                            <div class="stepwizard-step">
                                <button type="button" class="btn btn-primary btn-circle">1</button>
                                <p><?php echo __('Personal', true); ?></p>
                            </div>
                            <div class="stepwizard-step">
                                <button type="button" class="btn btn-primary btn-circle" disabled="disabled">2</button>
                                <p><?php echo __('Company', true); ?></p>
                            </div>
                            <div class="stepwizard-step">
                                <button type="button" class="btn btn-primary btn-circle" disabled="disabled">3</button>
                                <p><?php echo __('Host', true); ?></p>
                            </div>
                            <div class="stepwizard-step">
                                <button type="button" class="btn btn-primary btn-circle" disabled="disabled">4</button>
                                <p><?php echo __('Poll', true); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php echo $this->Form->create('User', array('class' => '', 'url' => $this->here)); ?>

                        <fieldset>
                            <legend><?php echo __('Your login details', true); ?></legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <?php
                                        echo $this->Form->input('User.gender', array(
                                            'label' => __('Gender', true).'*',
                                            'type' => 'select',
                                            'options' => $options_genders,
                                            'empty' => __('Select gender...', true),
                                            'class' => 'form-control',
                                            'div' => array('class' => 'form-group')

                                        ));
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                        echo $this->Form->input('User.firstname', array(
                                            'label' => __('Firstname', true).'*',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => array('class' => 'form-group')
                                        ));
                                    ?>
                                </div>
                                <div class="col-md-5">
                                    <?php
                                        echo $this->Form->input('User.lastname', array(
                                            'label' => __('Lastname', true).'*',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => array('class' => 'form-group')
                                        ));
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                        echo $this->Form->input('User.e_1', array(
                                            'label' => __('Email', true).'*',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => array('class' => 'form-group')
                                        ));
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                        echo $this->Form->input('User.e_2', array(
                                            'label' => __('Confirm Email', true).'*',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => array('class' => 'form-group')
                                        ));
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                        echo $this->Form->input('User.p_1', array(
                                            'label' => __('Password', true).'*',
                                            'type' => 'password',
                                            'class' => 'form-control',
                                            'placeholder' => __('Minimum 8 characters!', true),
                                            'escape' => false,
                                            'div' => array('class' => 'form-group')
                                        ));
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                        echo $this->Form->input('User.p_2', array(
                                            'label' => __('Confirm password', true).'*',
                                            'type' => 'password',
                                            'class' => 'form-control',
                                            'div' => array('class' => 'form-group')
                                        ));
                                        # generate the user-pin through the system and stop buggin' the user here...
                                    ?>
                                </div>
                            </div>

                        </fieldset>

                        <div class="clearfix">&nbsp;</div>

                        <fieldset>
                            <legend><?php echo __('Are you are a robot?', true); ?></legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="g-recaptcha" data-sitekey="6LdZihQTAAAAAOXzShB1w3sVm9XLww9XK_A0Bony"></div>

                                    <?php if(isset($captcha_error)) { ?>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="alert alert-danger">
                                            <?php echo __('You need to be a human to register an account!'); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </fieldset>
                        <div class="clearfix">&nbsp;</div>


                        <?php echo $this->Form->submit(__('Sign up for FREE!', true), array('class' => 'btn btn-success btn-lg btn-block')); ?>
                        <div class="clearfix">&nbsp;</div>
                        <p>
                            <?php echo __('With clicking on "Sign up for Free", you accept the terms & conditions.', true); ?> <a href="/<?php echo substr($locale, 0, 2); ?>/terms" class="btn btn-link btn-sm" title="<?php echo __('Terms & Conditions'); ?>"><span class="glyphicon glyphicon-link"></span> <?php echo __('TOC'); ?></a>
                        </p>
                        <p>
                            <?php echo __('Please read carefully our privacy policy. With clicking on "Sign up for free", you accept the privacy policy.', true); ?> <a href="/privacy" class="btn btn-link btn-sm" title="<?php echo __('Privacy Policy'); ?>"><span class="glyphicon glyphicon-link"></span> <?php echo __('Privacy Policy'); ?></a>
                        </p>


                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
            <?php echo $this->Html->link(__('Login', true), '/login', array('class' => 'btn btn-default btn-block', 'escape' => false)); ?><br />
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var intro_text = $('#intro-text').text();

        /* load captcha section */
        $('#captcha').simpleCaptcha({
            scriptPath: '/users/captcha',
            introText: '<p>'+intro_text+' <strong class="captchaText"></strong></p>',
            inputName: "data[User][captcha]",
            numImages: 5,
        });

    });
</script>
