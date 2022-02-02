<?php
    $this->set('title_for_layout', __('Hosts', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('Hosts', true));

    #echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">
    <h2><?php echo __('Hosts');?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id');?></th>
                        <th></th>
                        <th><?php echo $this->Paginator->sort('name', __('Host', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('locale', __('Standard language', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('count_polls', __('Polls', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($hosts as $host) { ?>
                        <tr>
                            <td>
                                <?php echo $host['Host']['id']; ?>
                            </td>
                            <td>
                                <?php
                                    if(!empty($host['Host']['logo'])) {
                                        echo $this->Html->image(Configure::read('CDN.Host'). 'hosts' . DS . 300 . DS . $host['Host']['logo'], array('class' => 'img-thumbnail', 'width' => '80px'));
                                    } else {
                                        #echo 'Placeholder here!';
                                        echo $this->Html->image(Configure::read('CDN.Host'). 'hosts' . DS . 300 . DS . 'no_pic.jpg', array('class' => 'img-thumbnail', 'width' => '80px'));
                                    }
                                ?>
                            </td>
                            <td>
                                <?php echo $host['Host']['name']; ?>
                            </td>
                            <td>
                                <?php echo $host['Host']['locale']; ?>
                            </td>
                            <td>
                                <?php echo $host['Host']['count_polls']; ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $host['Host']['created']); ?>
                            </td>
                            <td class="">
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $host['Host']['id']), array('class' => 'btn btn-sm btn-default'));
                                        #echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $host['Host']['id']), array('class' => 'btn btn-sm btn-default'));
                                        #echo $this->Html->link(__('Delete', true), array('action' => 'delete', $host['Host']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($hosts)) { ?>
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
<?php #echo $this->element('Widgets/standard_delete/main'); ?>
