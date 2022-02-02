<?php
    $this->set('title_for_layout', __('Hosts', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('My Hosts', true));

    echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">
    <div class="btn-toolbar pull-right clearfix">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Add host', true), '#', array('class' => 'btn btn-primary add-host', 'escape' => false)); ?>
    </div>

    <h2><?php echo __('My Hosts');?></h2>
    <div class="clearfix">
        <div class="btn-group pull-right ">
            <?php echo $this->Paginator->sort('id', 'Id', array('class' => 'btn btn-default btn-sm'));?>
            <?php echo $this->Paginator->sort('name', __('Host', true), array('class' => 'btn btn-default btn-sm')); ?>
            <?php echo $this->Paginator->sort('locale', __('Standard language', true), array('class' => 'btn btn-default btn-sm')); ?>
            <?php echo $this->Paginator->sort('count_polls', __('Polls', true), array('class' => 'btn btn-default btn-sm')); ?>
            <?php echo $this->Paginator->sort('created', __('Created', true), array('class' => 'btn btn-default btn-sm')); ?>
        </div>
    </div>
    <p>&nbsp;</p>


    <div class="row">
        <?php foreach($hosts as $host) { ?>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="img-crop">
                        <?php
                            if(!empty($host['Host']['logo'])) {
                                echo $this->Html->image(Configure::read('CDN.Host'). 'hosts' . DS . 300 . DS . $host['Host']['logo'], array('class' => 'img-rounded', 'width' => '100%'));
                            } else {
                                #echo 'Placeholder here!';
                                echo $this->Html->image(Configure::read('CDN.Host'). 'hosts' . DS . 300 . DS . 'no_pic.jpg', array('class' => 'img-rounded', 'width' => '100%'));
                            }
                        ?>
                    </div>

                    <div class="caption">
                        <p class="lead"><?php echo $host['Host']['name']; ?></p>
                        <p><span class="text-left"><?php echo __('Polls', true); ?></span> <strong class="pull-right"><?php echo $host['Host']['count_polls']; ?></strong></p>
                        <hr />
                        <p><span class="text-left"><?php echo __('Standard language', true); ?></span> <strong class="pull-right"><?php if($host['Host']['locale'] == 'deu' ) {
                                    echo __('German', true);
                                } else {
                                    echo __('English', true);
                                } ?></strong></p>
                        <hr />
                        <p><span class="text-left"><?php echo __('ID', true); ?></span> <strong class="pull-right"><?php echo $host['Host']['id']; ?></strong></p>
                        <hr />
                        <div class="btn-group">
                            <?php
                                echo $this->Html->link(__('View', true), array('action' => 'view', $host['Host']['id']), array('class' => 'btn btn-sm btn-info'));
                                echo $this->Html->link(__('Edit', true), array('action' => 'edit', $host['Host']['id']), array('class' => 'btn btn-sm btn-default'));
                                /*
                                if($host['Host']['status'] == 0) {
                                    echo $this->Html->link(__('Activate', true), array('action' => 'activate', $host['Host']['id']), array('class' => 'btn btn-sm btn-success standard-activate'));
                                } else {
                                    echo $this->Html->link(__('Deactivate', true), array('action' => 'deactivate', $host['Host']['id']), array('class' => 'btn btn-sm btn-warning standard-deactivate'));
                                }
                                */

                                #echo $this->Html->link(__('Delete', true), array('action' => 'delete', $host['Host']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                            ?>
                        </div>

                    </div>

                </div>
            </div>
        <?php  } ?>
    </div>
    <?php if(empty($hosts)) { ?>
        <div class="placeholderbox"><?php echo __('No entries', true); ?></div>
    <?php  } ?>

    <?php echo $this->element('counting_paginator'); ?>

</div>

<?php #echo $this->element('Widgets/standard_activate/main'); ?>
<?php #echo $this->element('Widgets/standard_deactivate/main'); ?>
<?php #echo $this->element('Widgets/standard_delete/main'); ?>


<!-- add host modal -->
<div id="modal-host-add" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Add new host', true); ?></h3>
            </div>

            <div class="modal-body">
                <div class="clearfix">
                    <?php
                        echo $this->Form->input('Host.name', array(
                            'label' => __('Host name', true),
                            'placeholder' => __('Enter the name of your host', true),
                            'type' => 'text',
                            'id' => 'hosts-name',
                            'class' => 'form-control',
                            'div' => array('class' => 'form-group'),
                            'after' => '<div class="error-message">'.__('Please enter a name for the host!', true).'</div>',
                            'escape' => false
                        ));
                        echo $this->Form->input('Host.locale', array(
                            'label' => __('Standard for polls of this host', true),
                            'type' => 'select',
                            'options' => $options_locale,
                            'id' => 'hosts-locale',
                            'class' => 'form-control',
                            'div' => array('class' => 'form-group'),
                            'after' => '<div class="error-message">'.__('Please select a standard locale for your polls!', true).'</div>',
                            'escape' => false
                        ));
                        echo $this->Form->input('Host.timezone', array(
                            'label' => __('Select the timezone your host is located', true),
                            'type' => 'select',
                            'options' => $options_timezones,
                            'selected' => 'America/New_York',
                            'id' => 'hosts-timezone',
                            'class' => 'form-control',
                            'div' => array('class' => 'form-group'),
                            'after' => '<div class="error-message">'.__('Please select a timezone for your host-location!', true).'</div>',
                            'escape' => false
                        ));
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-host-add" style="display: none;"/>
                <button class="btn btn-default" id="host-add-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="host-add-confirm" type="button"><?php echo __('Add', true); ?></button>
            </div>
        </div>
    </div>
</div>
