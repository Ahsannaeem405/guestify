<?php
    $this->set('title_for_layout', __('My profile', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My profile', true));
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Edit', true), array('action' => 'profileEdit'), array('class' => 'btn btn-info')); ?>
</div>

<h2><?php echo __('My Profile', true); ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4><?php echo __('General information', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Gender', true); ?></dt>
                    <dd><?php echo $genders[$user['User']['gender']]; ?></dd>
                    <dt><?php echo __('Firstname', true); ?></dt>
                    <dd><?php echo $user['User']['firstname']; ?></dd>
                    <dt><?php echo __('Lastname', true); ?></dt>
                    <dd><?php echo $user['User']['lastname']; ?></dd>
                    <dt><?php echo __('Email', true); ?></dt>
                    <dd>
                        <?php echo $user['User']['email']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Status', true); ?></dt>
                    <dd>
                        <?php
                            if($user['User']['status'] == 0) {
                                echo '<span class="label label-warning">'.$statuses[$user['User']['status']].'</span>';
                            } elseif($user['User']['status'] == 1) {
                                echo '<span class="label label-success">'.$statuses[$user['User']['status']].'</span>';
                            } elseif ($user['User']['status'] == 2) {
                                echo '<span class="label label-info">'.$statuses[$user['User']['status']].'</span>';
                            }
                        ?>
                    </dd>
                    <dt><?php echo __('Last login', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $user['User']['last_login']); ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Created', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $user['User']['created']); ?>
                        &nbsp;
                    </dd>
                </dl>
            </div>

        </div>
    </div>
</div>


