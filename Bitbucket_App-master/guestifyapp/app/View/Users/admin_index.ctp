<?php
    $this->set('title_for_layout', __('Users', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('Users', true));

    #echo $this->Html->script('View/Hosts/index', false);
?>

<div class="clearfix">
    <h2><?php echo __('Users'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id');?></th>
                        <th><?php echo $this->Paginator->sort('gender', __('Gender', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('firstname', __('Firstname', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('lastname', __('Lastname', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('email', __('Email', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('user_pin', __('Pin', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user) { ?>
                        <tr>
                            <td>
                                <?php echo $user['User']['id']; ?>
                            </td>
                            <td>
                                <?php echo $genders[$user['User']['gender']]; ?>
                            </td>
                            <td>
                                <?php echo $user['User']['firstname']; ?>
                            </td>
                            <td>
                                <?php echo $user['User']['lastname']; ?></p>
                            </td>
                            <td>
                                <?php echo $user['User']['email']; ?>
                            </td>
                            <td>
                                <?php echo $user['User']['user_pin']; ?>
                            </td>
                            <td>
                                <?php
                                    switch($user['User']['status']) {
                                        case 0:
                                            $class = 'warning';
                                            break;
                                        case 1:
                                            $class = 'success';
                                            break;
                                        case 2:
                                            $class = 'info';
                                            break;
                                    }
                                ?>
                                <span class="label label-<?php echo $class; ?>"><?php echo $statuses[$user['User']['status']]; ?></span>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $user['User']['created']); ?>
                            </td>
                            <td class="">
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'adminView', $user['User']['id']), array('class' => 'btn btn-sm btn-default'));
                                        #echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $user['User']['id']), array('class' => 'btn btn-sm btn-default'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($users)) { ?>
                        <tr>
                            <td colspan="9"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
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
