<?php
    $this->set('title_for_layout', __('Host', true).' - '.$host['Host']['name']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My Hosts', true), array('controller' => 'hosts', 'action' => 'index'), array('escape' => false));
    $this->Html->addCrumb($host['Host']['name'], array('controller' => 'hosts', 'action' => 'view', $host['Host']['id']), array('escape' => false));
    $this->Html->addCrumb(__('Edit host', true));
?>

<h2><?php echo __('Edit host', true); ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo $this->Form->create('Host', array('url' => $this->here, 'type' => 'file')); ?>

                    <?php echo $this->Form->input('Host.id'); ?>

                    <fieldset>
                        <legend><?php echo __('General information', true); ?></legend>
                        <?php
                            echo $this->Form->input('Host.name', array(
                                'label' => __('Name', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                            echo $this->Form->input('Host.locale', array(
                                'label' => __('Standard locale for polls', true),
                                'type' => 'select',
                                'options' => $options_locale,
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group')
                            ));
                        ?>
                    </fieldset>

                    <div class="row">

                        <div class="col-xs-6">
                            <fieldset>
                                <legend><?php echo __('Location information', true); ?></legend>
                                <?php
                                    echo $this->Form->input('Host.address', array(
                                        'label' => __('Address', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                    echo $this->Form->input('Host.zipcode', array(
                                        'label' => __('Zipcode', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                    echo $this->Form->input('Host.city', array(
                                        'label' => __('City', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                    echo $this->Form->input('Host.country_id', array(
                                        'label' => __('Country', true),
                                        'type' => 'select',
                                        'options' => $options_countries,
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                ?>
                            </fieldset>
                        </div>
                        <div class="col-xs-6">
                            <fieldset>
                                <legend><?php echo __('Contact information', true); ?></legend>
                                <?php
                                    echo $this->Form->input('Host.phone', array(
                                        'label' => __('Phone', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                    echo $this->Form->input('Host.fax', array(
                                        'label' => __('Fax', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                    echo $this->Form->input('Host.email', array(
                                        'label' => __('Email', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                    echo $this->Form->input('Host.web', array(
                                        'label' => __('Web', true),
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                ?>
                            </fieldset>
                        </div>

                    </div>





                    <fieldset>
                        <legend><?php echo __('Logo', true); ?></legend>

                        <div class="clearfix">
                            <?php if(!empty($host['Host']['logo'])) { ?>
                                <?php echo $this->Html->image(Configure::read('CDN.Host').'hosts/300/'.$host['Host']['logo'], array('class' => 'img-thumbnail')); ?>
                            <?php } else { ?>
                                <?php echo $this->Html->image(Configure::read('CDN.Host').'hosts/300/no_pic.jpg', array('class' => 'img-thumbnail')); ?>
                            <?php } ?>
                        </div>

                        <?php if(!empty($host['Host']['logo'])) { ?>
                            <p>
                                <?php
                                    echo $this->Form->input('Host.logo_remove', array(
                                        'label' => __('Remove logo', true),
                                        'type' => 'checkbox',
                                        #'class' => 'form-control',
                                        'div' => array('class' => 'form-group')
                                    ));
                                ?>
                            </p>
                        <?php } ?>

                        <?php
                            echo $this->Form->input('Host.logo_edit', array(
                                'label' => __('Upload logo', true),
                                'type' => 'file',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                            ));
                        ?>
                    </fieldset>

                    <fieldset>
                        <legend><?php echo __('Social links options', true); ?></legend>
                        <?php
                            foreach($socials as $social_id => $social_type) {
                                echo $this->Form->input('PollsSocial.'.$social_id, array(
                                    'label' => $social_type,
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                    'escape' => false,
                                    'value' => $values_socials[$social_id]
                                ));
                            }
                        ?>
                    </fieldset>

                    <div class="clearfix">&nbsp;</div>
                    <?php echo $this->Form->submit(__('Save changes', true), array('class' => 'btn btn-success')); ?>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-5">
       <?php #echo $this->element('help'); ?>
    </div>
</div>




<?php #echo $this->element('Widgets/standard_activate/main'); ?>
<?php #echo $this->element('Widgets/standard_deactivate/main'); ?>
<?php #echo $this->element('Widgets/standard_delete/main'); ?>
