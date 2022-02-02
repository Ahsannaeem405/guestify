<?php
    $this->set('title_for_layout', __('Users', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Users', true), array('action' => 'admin_index'));
    $this->Html->addCrumb(__('Edit user', true));
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Back', true), array('action' => 'adminView', $user['User']['id']), array('class' => 'btn btn-info')); ?>
</div>

<h2><?php echo __('Edit user', true); ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo $this->Form->create('User', array('class' => '', 'url' => $this->here)); ?>
                    <?php echo $this->Form->input('User.id'); ?>

                    <fieldset>
                        <legend><?php echo __('System information', true); ?></legend>
                        <?php
                            echo $this->Form->input('User.status', array(
                                'label' => __('Status', true),
                                'type' => 'select',
                                'options' => $statuses,
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                        ?>
                    </fieldset>
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
                        <p>
                            <?php echo __('Current email', true); ?>: <strong><?php echo $user['User']['email']; ?></strong>
                        </p>
                        <?php
                            echo $this->Form->input('User.email_new', array(
                                'label' => __('New Email', true),
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
                    </fieldset>

                    <fieldset>
                        <legend><?php echo __('Password', true); ?></legend>
                        <?php
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
