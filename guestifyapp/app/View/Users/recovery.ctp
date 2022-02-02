<?php $this->set('title_for_layout', __('Setup password', true)); ?>

<div class="clearfix">
    <div class="col-lg-4"></div>

    <div class="col-lg-4 col-xs-12">
        <p class="text-center"><a href="/login"><img src="/graphics/logos/300/guestify_logo_word_brand_300.png" alt="Guestify" /></a></p>
        <div id="login">
            <div class="clearfix ">
                <div class="col-xs-12 well">
                    <h1 class="hide"><?php echo __('Set Password'); ?></h1>
                    <?php echo $this->Form->create('User', array('url' => $this->here)); ?>
                        <?php
                            echo $this->Form->input('User.p_1', array(
                                'label' => __('Password', true),
                                'type' => 'password',
                                'class' => 'form-control input-lg',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('User.p_2', array(
                                'label' => __('Confirm Password', true),
                                'type' => 'password',
                                'class' => 'form-control input-lg',
                                'div' => array('class' => 'form-group')
                            ));
                        ?>
                        <?php echo $this->Form->button(__('Set password', true), array('type' => 'submit', 'class' => 'btn btn-lg btn-success btn-block')); ?>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-4"></div>

</div>
