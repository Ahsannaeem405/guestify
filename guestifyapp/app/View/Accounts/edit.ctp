<?php
    $this->set('title_for_layout', __('My account', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My account', true), array('action' => 'my_account'));
    $this->Html->addCrumb(__('Edit my account', true));
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Back', true), array('action' => 'my_account'), array('class' => 'btn btn-info')); ?>
</div>

<h2><?php echo $account['Account']['company_name']; ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo $this->Form->create('Account', array('class' => '', 'url' => $this->here)); ?>
                    <?php echo $this->Form->input('Account.id'); ?>

                    <fieldset>
                        <legend><?php echo __('Company', true); ?></legend>
                        <?php
                            echo $this->Form->input('Account.company_name', array(
                                'label' => __('Company name', true).'*',
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('Account.ust_id', array(
                                'label' => __('Tax ID', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                        ?>
                    </fieldset>

                    <fieldset>
                        <legend><?php echo __('Address', true); ?></legend>
                        <?php
                            echo $this->Form->input('Account.address', array(
                                'label' => __('Address', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('Account.zipcode', array(
                                'label' => __('Zipcode', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('Account.city', array(
                                'label' => __('City', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('Account.country_id', array(
                                'label' => __('Country', true),
                                'type' => 'select',
                                'options' => $options_countries,
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                        ?>
                    </fieldset>

                    <fieldset>
                        <legend><?php echo __('Contact', true); ?></legend>
                        <?php
                            echo $this->Form->input('Account.phone', array(
                                'label' => __('Phone', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('Account.fax', array(
                                'label' => __('Fax', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('Account.mobile', array(
                                'label' => __('Mobile', true),
                                'type' => 'text',
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
