<?php
    $this->set('title_for_layout', __('My account', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Accounts', true), array('action' => 'adminIndex'));
    $this->Html->addCrumb(__('Add Account', true));
?>

<h2><?php echo __('Add Account');?></h2>

<div class="panel panel-default">
    <div class="panel-body">

        <?php echo $this->Form->create('Account', array('class' => '', 'url' => $this->here)); ?>

            <fieldset>
                <legend><?php echo __('Account details', true); ?></legend>
                <?php
                    echo $this->Form->input('Account.company_name', array(
                        'label' => __('Company name', true).'*',
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Account.address', array(
                        'label' => __('Address', true),
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Account.zipcode', array(
                        'label' => __('Zipcode', true),
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Account.city', array(
                        'label' => __('City', true),
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Account.country_id', array(
                        'label' => __('Country', true).'*',
                        'type' => 'select',
                        'options' => $options_countries,
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Account.phone', array(
                        'label' => __('Phone', true),
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Account.mobile', array(
                        'label' => __('Mobile', true),
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Account.fax', array(
                        'label' => __('Fax', true),
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Account.ustid', array(
                        'label' => __('Ust ID', true),
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                ?>
            </fieldset>

            <hr />

            <fieldset>
                <legend><?php echo __('User details', true); ?></legend>
                <?php
                    echo $this->Form->input('User.gender', array(
                        'label' => __('Gender', true).'*',
                        'type' => 'select',
                        'options' => $options_genders,
                        'empty' => __('Select gender...', true),
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('User.firstname', array(
                        'label' => __('Firstname', true).'*',
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('User.lastname', array(
                        'label' => __('Lastname', true).'*',
                        'type' => 'text',
                        'class' => 'form-control'
                    ));

                    echo $this->Form->input('User.e_1', array(
                        'label' => __('Email', true).'*',
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('User.e_2', array(
                        'label' => __('Confirm Email', true).'*',
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('User.user_pin', array(
                        'label' => __('User-PIN', true).'*',
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                ?>
            </fieldset>

            <hr />

            <?php echo $this->Form->submit(__('Save changes', true), array('class' => 'btn btn-success')); ?>

        <?php echo $this->Form->end(); ?>
    </div>
</div>
