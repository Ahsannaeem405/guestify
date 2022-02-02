<?php
    $this->set('title_for_layout', __('Target', true).' - '.$target['Target']['name']);

    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Targets', true), array('action' => 'adminIndex'), array('escape' => false));
    $this->Html->addCrumb(__('Target', true).' - '.$target['Target']['name']);
?>

<div class="btn-toolbar pull-right clearfix">
    <?php
        if($target['Target']['prepared'] == 1) {
            echo $this->Html->link(__('Transform into new account', true), array('action' => 'adminTransform', $target['Target']['id']), array('class' => 'account-transform btn btn-info'));
            echo $this->Html->link(__('Transfer to existing account', true), array('action' => 'adminTransfer', $target['Target']['id']), array('class' => 'account-transfer btn btn-info'));
        }
        echo $this->Html->link(__('Delete', true), array('action' => 'adminDelete', $target['Target']['id']), array('class' => 'btn btn-danger standard-delete'));
    ?>
</div>


<h2><?php echo __('Target', true).' - '.$target['Target']['name']; ?></h2>

<div class="panel panel-default">
    <div class="panel-body">

        <div class="row">
            <div class="col-xs-10">
                <?php echo $this->Form->create('Target', array('url' => $this->here)); ?>

                    <?php echo $this->Form->input('Target.id'); ?>

                    <?php
                        echo $this->Form->input('Target.name', array(
                            'label' => __('Name', true),
                            'class' => 'form-control',
                            'type' => 'text'
                        ));
                        echo $this->Form->input('Target.address', array(
                            'label' => __('Address', true),
                            'class' => 'form-control',
                            'type' => 'text'
                        ));
                        echo $this->Form->input('Target.zipcode', array(
                            'label' => __('Zipcode', true),
                            'class' => 'form-control',
                            'type' => 'text'
                        ));
                        echo $this->Form->input('Target.city', array(
                            'label' => __('City', true),
                            'class' => 'form-control',
                            'type' => 'text'
                        ));
                        echo $this->Form->input('Target.state_id', array(
                            'label' => __('State', true),
                            'class' => 'form-control',
                            'type' => 'select',
                            'options' => $states
                        ));
                        echo $this->Form->input('Target.country_id', array(
                            'label' => __('Country', true),
                            'class' => 'form-control',
                            'type' => 'select',
                            'options' => $countries
                        ));
                        echo $this->Form->input('Target.timezone', array(
                            'label' => __('Timezone', true),
                            'type' => 'select',
                            'options' => $timezones,
                            #'selected' => 'Europe/Brussels',
                            'class' => 'form-control',
                            'escape' => false
                        ));
                        echo $this->Form->input('Target.phone', array(
                            'label' => __('Phone', true),
                            'class' => 'form-control',
                            'type' => 'text'
                        ));
                        echo $this->Form->input('Target.fax', array(
                            'label' => __('Fax', true),
                            'class' => 'form-control',
                            'type' => 'text'
                        ));
                        echo $this->Form->input('Target.email', array(
                            'label' => __('Email', true),
                            'class' => 'form-control',
                            'type' => 'text'
                        ));
                        echo $this->Form->input('Target.web', array(
                            'label' => __('Web', true),
                            'class' => 'form-control',
                            'type' => 'text'
                        ));
                    ?>

                    <hr />
                    <div class="input">
                    <?php
                        echo $this->Form->input('Target.prepared', array(
                            'label' => __('Moved to prepared-list', true),
                            'class' => '',
                            'style' => 'margin-left: 0;',
                            'type' => 'checkbox'
                        ));
                    ?>
                    </div>
                    <hr />

                    <div class="clearfix">&nbsp;</div>


                    <?php echo $this->Form->submit(__('Save changes', true), array('class' => 'btn btn-success')); ?>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>

    </div>
</div>


<?php echo $this->element('Widgets/standard_delete/main'); ?>