<?php
    $this->set('title_for_layout', __('Accounts', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Accounts', true), array('action' => 'adminIndex'));
    $this->Html->addCrumb(__('Edit Account', true));
?>

<h2><?php echo __('Edit Account'); ?></h2>

<div class="panel panel-default">
    <div class="panel-body">

        <?php echo $this->Form->create('Account', array('class' => '', 'url' => $this->here)); ?>
            <?php echo $this->Form->input('Account.id'); ?>
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

            <?php echo $this->Form->submit(__('Save changes', true), array('class' => 'btn btn-success')); ?>

        <?php echo $this->Form->end(); ?>
    </div>
</div>
