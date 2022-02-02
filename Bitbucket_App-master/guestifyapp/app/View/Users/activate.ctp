<?php $this->set('title_for_layout', __('Setup password', true)); ?>

<div class="clearfix">
    <div class="col-xs-4"></div>

    <div class="col-xs-4">
        <h1 class="text-center"><a href="/login"><img src="/images/logo.png" width="50%" /></a></h1>

        <div id="login">
            <div class="clearfix ">
                <div class="col-xs-12 well">
                    <h2 class="hide"><?php echo __('Set Password'); ?></h2>

                    <p>
                        <strong><?php echo __('Your email address', true); ?></strong><br />
                        <?php echo $user['User']['email']; ?>
                    </p>

                    <hr />

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
