<?php
    $this->set('title_for_layout', __('My account', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My profile', true), array('action' => 'my_profile'));
    $this->Html->addCrumb(__('Edit profile', true));
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Back', true), array('action' => 'my_profile'), array('class' => 'btn btn-info')); ?>
</div>

<h2><?php echo __('Edit pofile', true); ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo $this->Form->create('User', array('class' => '', 'url' => $this->here)); ?>
                    <?php echo $this->Form->input('User.id'); ?>
                    <fieldset>
                        <legend><?php echo __('Personal information', true); ?></legend>
                        <?php
                            echo $this->Form->input('User.gender', array(
                                'label' => __('Gender', true).'*',
                                'type' => 'select',
                                'options' => $genders,
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('User.firstname', array(
                                'label' => __('Firstname', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('User.lastname', array(
                                'label' => __('Lastname', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                        ?>
                    </fieldset>

                    <fieldset>
                        <legend><?php echo __('Email', true); ?></legend>
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="text-info">
                                    <?php echo __('Current email', true); ?>:<br /> <strong><?php echo $user['User']['email']; ?></strong>
                                </p>
                            </div>
                            <div class="col-xs-6">
                                <?php
                                    echo $this->Form->input('User.email_new', array(
                                        'label' => __('New email', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                    echo $this->Form->input('User.email_new_confirm', array(
                                        'label' => __('Confirm new email', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                ?>
                            </div>
                        </div>


                    </fieldset>

                    <fieldset>
                        <legend><?php echo __('Password', true); ?></legend>
                        <p>
                            <small class="text-warning"><?php echo __('To change your password, enter your current password, the new one and confirm it!', true); ?></small>
                        </p>

                        <?php
                            echo $this->Form->input('User.pass_current', array(
                                'label' => __('Current password', true),
                                'type' => 'password',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('User.pass_new', array(
                                'label' => __('New password', true),
                                'type' => 'password',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('User.pass_new_confirm', array(
                                'label' => __('Confirm new password', true),
                                'type' => 'password',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                        ?>
                    </fieldset>

                    <?php echo $this->Form->submit(__('Save changes', true), array('class' => 'btn btn-success')); ?>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>

    </div>
</div>
