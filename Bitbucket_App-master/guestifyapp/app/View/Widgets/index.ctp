<?php
    $this->set('title_for_layout', __('MyWidgets', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My Widgets', false));
?>

<div class="clearfix">

    <div class="btn-toolbar pull-right clearfix">
        <?php 
            if($has_poll){
                echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Add widget', true), array('controller' => 'widgets', 'action' => 'add'), array('class' => 'add-poll btn btn-primary', 'escape' => false));
            }else{
                echo _('You have to create a Poll before you can add a Widget');
            }
        ?>
    </div>

    <h2><?php echo __('Widgets');?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'Id');?></th>
                        <th width="30%"><?php echo $this->Paginator->sort('name', __('Name', true)); ?>/ <?php echo $this->Paginator->sort('Host.name', __('Host', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('views', __('Views', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('poll', __('Poll', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($widgets as $widget){ ?>
                        <tr>
                            <td>
                                <p class="lead"><?php echo $widget['Widget']['id']; ?></p>
                            </td>
                            <td>
                                <strong class="lead"><?php echo $widget['Widget']['name']; ?></strong><br />
                                <small><span class="glyphicon glyphicon-home"></span> <?php echo $widget['Host']['name']; ?></small>
                            </td>
                            <td><?php 
                                    if($widget['Widget']['status'] == 0){
                                        echo '<span class="label label-warning">'.$statuses[$widget['Widget']['status']].'</span>';
                                    } elseif($widget['Widget']['status'] == 1){
                                        echo '<span class="label label-success">'.$statuses[$widget['Widget']['status']].'</span>';
                                    } 
                                ?>
                            </td>
                            <td>
                                <p class="lead"><?php echo $widget['Widget']['views']; ?></p>
                            </td>
                            <td>
                                <strong class="lead"><?php echo $widget['Poll']['title']; ?></strong><br />
                            </td>
                            <td>
                                <p class="lead"><?php echo $this->Time->format($formats['date'], $widget['Widget']['created']); ?></p>
                            </td>

                            <td>
                                <div class="btn-group-vertical">
                                    <?php
                                        echo $this->Html->link('<span class="glyphicon glyphicon-cog"></span> '.__('Settings', true), array('controller' => 'widgets', 'action' => 'settings', $widget['Widget']['id']), array('class' => 'btn btn-sm btn-default', 'escape' => false));
                                        
                                         if($widget['Widget']['status'] == 0){
                                            echo $this->Html->link('<span class="glyphicon glyphicon-ok-sign"></span> '.__('Activate', true), array('controller' => 'widgets', 'action' => 'activate', $widget['Widget']['id']), array('class' => 'btn btn-success btn-sm standard-activate', 'escape' => false));
                                        } elseif($widget['Widget']['status'] == 1){
                                            echo $this->Html->link('<span class="glyphicon glyphicon-ban-circle"></span> '.__('Deactivate', true), array('controller' => 'widgets', 'action' => 'deactivate', $widget['Widget']['id']), array('class' => 'btn btn-warning btn-sm standard-deactivate', 'escape' => false));
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(empty($widget)){ ?>
                        <tr>
                            <td colspan="10"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
            <?php echo $this->element('counting_paginator'); ?>
        </div>
    </div>
</div>