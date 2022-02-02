<?php
    $this->set('title_for_layout', __('Transfer target as host to existing account', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Targets', true), array('action' => 'adminIndex'));
    $this->Html->addCrumb(__('Transfer', true));
?>

<h2><?php echo __('Transfer target');?></h2>

<div class="panel panel-default">
    <div class="panel-body">

        <?php echo $this->Form->create('Target', array('class' => '', 'url' => $this->here)); ?>

            <fieldset>
                <legend><?php echo __('Host details', true); ?></legend>
                <?php
                    echo $this->Form->input('Host.name', array(
                        'label' => __('Name', true).'*',
                        'class' => 'form-control',
                        'type' => 'text'
                    ));
                    echo $this->Form->input('Host.address', array(
                        'label' => __('Address', true),
                        'class' => 'form-control',
                        'type' => 'text'
                    ));
                    echo $this->Form->input('Host.zipcode', array(
                        'label' => __('Zipcode', true),
                        'class' => 'form-control',
                        'type' => 'text'
                    ));
                    echo $this->Form->input('Host.city', array(
                        'label' => __('City', true),
                        'class' => 'form-control',
                        'type' => 'text'
                    ));
                    echo $this->Form->input('Host.state_id', array(
                        'label' => __('State', true),
                        'class' => 'form-control',
                        'type' => 'select',
                        'empty' => '',
                        'options' => $options_states
                    ));
                    echo $this->Form->input('Host.country_id', array(
                        'label' => __('Country', true),
                        'class' => 'form-control',
                        'type' => 'select',
                        'options' => $options_countries
                    ));
                    echo $this->Form->input('Host.timezone', array(
                        'label' => __('Timezone', true),
                        'type' => 'select',
                        'options' => $options_timezones,
                        #'selected' => 'Europe/Brussels',
                        'class' => 'form-control',
                        'escape' => false
                    ));
                    echo $this->Form->input('Host.locale', array(
                        'label' => __('Locale', true),
                        'type' => 'select',
                        'options' => $options_locale,
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Host.phone', array(
                        'label' => __('Phone', true),
                        'class' => 'form-control',
                        'type' => 'text'
                    ));
                    echo $this->Form->input('Host.fax', array(
                        'label' => __('Fax', true),
                        'class' => 'form-control',
                        'type' => 'text'
                    ));
                    echo $this->Form->input('Host.email', array(
                        'label' => __('Email', true),
                        'class' => 'form-control',
                        'type' => 'text'
                    ));
                    echo $this->Form->input('Host.web', array(
                        'label' => __('Web', true),
                        'class' => 'form-control',
                        'type' => 'text'
                    ));
                ?>
            </fieldset>

            <hr />

            <fieldset>
                <legend><?php echo __('Account connection', true); ?></legend>
                <?php
                    echo $this->Form->input('Host.account_id', array(
                        'label' => __('Enter Account ID', true),
                        'type' => 'text',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('Host.target_id', array(
                        'type' => 'hidden'
                    ));
                ?>
            </fieldset>

            <hr />

            <?php echo $this->Form->submit(__('Transfer!', true), array('class' => 'btn btn-success')); ?>

        <?php echo $this->Form->end(); ?>
    </div>
</div>
