<?php
    $this->set('title_for_layout', __('Targets', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('Targets', true));

    #echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">
    
    <div class="btn-toolbar pull-right clearfix">
        <?php
            echo $this->Form->input('Target.category_id', array(
                'label' => false,
                'type' => 'select',
                'options' => $categories,
                'class' => 'form-control',
                'id' => 'selector-category',
                'selected' => $category_id
            ));
        ?>
    </div>
    <h2><?php echo __('Targets'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            
            <?php echo $this->element('Targets/navtabs'); ?>

            <?php echo $this->Form->create('Target', array('url' => $this->here, 'class' => 'form-inline')); ?>
                <?php
                    echo $this->Form->input('Target.category_id', array(
                        'type' => 'hidden',
                        'value' => $category_id
                    ));
                    echo $this->Form->input('Target.id', array(
                        'label' => false,
                        'placeholder' => __('ID', true),
                        'class' => 'form-control',
                        'size' => 5,
                        'type' => 'text',
                        'value' => $this->Session->read('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.id'),
                        'div' => array(
                            'class' => 'form-group'
                        )
                    ));
                ?>
                &nbsp;&nbsp;
                <?php
                    echo $this->Form->input('Target.name', array(
                        'label' => false,
                        'placeholder' => __('Name', true),
                        'class' => 'form-control',
                        'type' => 'text',
                        'size' => 50,
                        'value' => $this->Session->read('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.name'),
                        'div' => array(
                            'class' => 'form-group'
                        )
                    ));
                ?>
                &nbsp;&nbsp;
                <?php
                    echo $this->Form->input('Target.zipcode', array(
                        'label' => false,
                        'placeholder' => __('Zipcode', true),
                        'class' => 'form-control',
                        'size' => 10,
                        'type' => 'text',
                        'value' => $this->Session->read('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.zipcode'),
                        'div' => array(
                            'class' => 'form-group'
                        )
                    ));
                ?>
                &nbsp;&nbsp;
                <?php
                    echo $this->Form->input('Target.city', array(
                        'label' => false,
                        'placeholder' => __('City', true),
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $this->Session->read('Targets.conditions_plain.'.$category_id.'.'.$type.'.Target.city'),
                        'div' => array(
                            'class' => 'form-group'
                        )
                    ));
                ?>

                <?php echo $this->Form->submit(__('Search', true), array('class' => 'btn btn-info', 'div' => array('class' => 'form-group'))); ?>
                <?php echo $this->Form->submit(__('Reset', true), array('name' => 'reset', 'class' => 'btn btn-default', 'div' => array('class' => 'form-group pull-right'))); ?>
                

            <?php echo $this->Form->end(); ?>
        </div>
    </div>

    <div>
        <?php
            #$plain = $this->Session->read('Targets.conditions_plain.'.$category_id);
            #$con = $this->Session->read('Targets.conditions.'.$category_id);
            
            #pr($plain);
            #pr($con);
            #pr($check);
        ?>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            
            <?php echo $this->element('counting_paginator'); ?>

            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'ID');?></th>
                        <th width="30%"><?php echo $this->Paginator->sort('name', __('Name', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('zipcode', __('Zipcode', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('city', __('City', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('web', __('Web', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php foreach($targets as $target) { ?>
                        <tr>
                            <td>
                                <?php echo $target['Target']['id']; ?>
                            </td>
                            <td>
                                <?php echo $target['Target']['name']; ?>
                            </td>
                            <td>
                                <?php echo $target['Target']['zipcode']; ?>
                            </td>
                            <td>
                                <?php echo $target['Target']['city']; ?>
                            </td>
                            <td>
                                <?php
                                    if(!empty($target['Target']['web'])) {
                                        echo $this->Html->link('<span class="label label-info">'.__('Web', true).' <span class="glyphicon glyphicon-share"></span></span>', $target['Target']['web'], array('target' => 'blank', 'escape' => false));
                                    }
                                ?>
                                &nbsp;
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $target['Target']['created']); ?>
                            </td>
                            <td class="">
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $target['Target']['id']), array('class' => 'btn btn-sm btn-default'));
                                        echo $this->Html->link(__('Delete', true), array('action' => 'adminDelete', $target['Target']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    
                    <?php if(empty($targets)) { ?>
                        <tr>
                            <td colspan="7"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
                        </tr>
                    <?php  } ?>
                    
                </tbody>
                
            </table>


            <?php echo $this->element('counting_paginator'); ?>
        </div>
    </div>
    
</div>


<?php #echo $this->element('Widgets/standard_activate/main'); ?>
<?php #echo $this->element('Widgets/standard_deactivate/main'); ?>
<?php echo $this->element('Widgets/standard_delete/main'); ?>

<script>
    $('#selector-category').change(function() {
      // set the window's location property to the value of the option the user has selected
        window.location = '/targets/adminIndex/'+$(this).val();
    });
</script>