<?php
    $this->set('title_for_layout', $genders[$user['User']['gender']].' '.$user['User']['firstname'].' '.$user['User']['lastname']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Users', true), array('action' => 'adminIndex'));
    $this->Html->addCrumb($genders[$user['User']['gender']].' '.$user['User']['firstname'].' '.$user['User']['lastname']);
?>

<div class="btn-toolbar pull-right">
    <?php
        echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $user['User']['id']), array('class' => 'btn btn-info'));
        #if($user['User']['status'] == 2) {
            echo $this->Html->link(__('Send welcome mail', true), array('action' => 'sendActivationLink', $user['User']['id']), array('class' => 'btn btn-info'));
        #}
        if($user['User']['status'] == 0) {
            echo $this->Html->link('<span class="glyphicon glyphicon-ok-sign"></span> '.__('Activate', true), array('action' => 'setActivate', $user['User']['id']), array('class' => 'btn btn-success standard-activate', 'escape' => false));
        } elseif($user['User']['status'] == 1) {
            echo $this->Html->link('<span class="glyphicon glyphicon-ban-circle"></span> '.__('Deactivate', true), array('action' => 'setInactivate', $user['User']['id']), array('class' => 'btn btn-warning standard-deactivate', 'escape' => false));
        }
    ?>
</div>


<h2><?php echo $genders[$user['User']['gender']].' '.$user['User']['firstname'].' '.$user['User']['lastname']; ?></h2>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-7">

                <h4><?php echo __('General information', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Email', true); ?></dt>
                    <dd>
                        <?php echo $user['User']['email']; ?>
                    </dd>
                    <dt><?php echo __('Status', true); ?></dt>
                    <dd>
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
                    </dd>
                    <dt><?php echo __('Last login', true); ?></dt>
                    <dd>
                        <?php if(!empty($user['User']['last_login'])) { ?>
                            <?php echo $this->Time->format($formats['datetime'], $user['User']['last_login']); ?>
                        <?php } else { ?>
                            <i><?php echo __('not logged in yet', true); ?></i>
                        <?php } ?>
                    </dd>
                    <dt><?php echo __('Created', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $user['User']['created']); ?>
                    </dd>
                </dl>

                <h4><?php echo __('Account information', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Company name', true); ?></dt>
                    <dd>
                        <?php echo $user['Account']['company_name']; ?>
                    </dd>
                    <dt><?php echo __('Street', true); ?></dt>
                    <dd>
                        <?php echo $user['Account']['address']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Zipcode', true); ?></dt>
                    <dd>
                        <?php echo $user['Account']['zipcode']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('City', true); ?></dt>
                    <dd>
                        <?php echo $user['Account']['city']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Country', true); ?></dt>
                    <dd>
                        <?php echo $user['Account']['country_name']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Phone', true); ?></dt>
                    <dd>
                        <?php echo $user['Account']['phone']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Mobile', true); ?></dt>
                    <dd>
                        <?php echo $user['Account']['mobile']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Fax', true); ?></dt>
                    <dd>
                        <?php echo $user['Account']['fax']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Last modified', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $user['Account']['modified']); ?>
                    </dd>
                    <dt><?php echo __('Created', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $user['Account']['created']); ?>
                    </dd>
                </dl>
            </div>

            <div class="col-xs-5">

                <h4><?php echo __('Invitation statistic', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Welcome Email sent', true); ?></dt>
                    <dd>
                        <?php if($user['User']['welcome_mail_count'] > 0) { ?>
                            <span class="label label-success"><?php echo __('yes', true); ?></span>
                        <?php } else { ?>
                            <span class="label label-warning"><?php echo __('no', true); ?></span>
                        <?php } ?>
                    </dd>
                    <?php if($user['User']['welcome_mail_count'] > 0) { ?>
                        <dt><?php echo __('Count', true); ?></dt>
                        <dd>
                            <?php echo $user['User']['welcome_mail_count']; ?>
                        </dd>
                    <?php } ?>
                </dl>
            </div>

        </div>
    </div>
</div>


<?php echo $this->element('Widgets/standard_activate/main'); ?>
<?php echo $this->element('Widgets/standard_deactivate/main'); ?>
