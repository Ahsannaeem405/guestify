<?php
    $this->set('title_for_layout', $account['Account']['company_name']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Accounts', true), array('action' => 'adminIndex'));
    $this->Html->addCrumb($account['Account']['company_name']);

    echo $this->Html->script('View/Accounts/admin_view', false);
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link(__('Add host', true), '#', array('id' => 'account-'.$account['Account']['id'], 'class' => 'add_host btn btn-info')); ?>
    <?php echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $account['Account']['id']), array('class' => 'btn btn-info')); ?>
</div>

<div class="clearfix">&nbsp;</div>

<h2><?php echo $account['Account']['company_name']; ?></h2>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-7">
                <h4><?php echo __('Address', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Street', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['address']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Zipcode', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['zipcode']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('City', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['city']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Country', true); ?></dt>
                    <dd>
                        <?php echo $countries[$account['Account']['country_id']]; ?>
                        &nbsp;
                    </dd>
                </dl>

                <h4><?php echo __('General information', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Last modified', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $account['Account']['modified']); ?>
                    </dd>
                    <dt><?php echo __('Created', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $account['Account']['created']); ?>
                    </dd>
                </dl>
            </div>
            <div class="col-xs-5">
                <h4><?php echo __('Contact', true); ?></h4>
                <dl class="dl-horizontal">
                    <dt><?php echo __('Phone', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['phone']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Mobile', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['mobile']; ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Fax', true); ?></dt>
                    <dd>
                        <?php echo $account['Account']['fax']; ?>
                        &nbsp;
                    </dd>
                </dl>
            </div>
        </div>

        <hr />

        <?php // list all users ?>
        <h3><?php echo __('Users', true); ?></h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo 'Id'; ?></th>
                            <th><?php echo __('Gender', true); ?></th>
                            <th><?php echo __('Firstname', true); ?></th>
                            <th><?php echo __('Lastname', true); ?></th>
                            <th><?php echo __('Email', true); ?></th>
                            <th><?php echo __('Status', true); ?></th>
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
                                    <span class="label label-<?php echo $class; ?>"><?php echo $statuses_users[$user['User']['status']]; ?></span>
                                </td>
                                <td class="">
                                    <div class="btn-group pull-right">
                                        <?php
                                            echo $this->Html->link(__('View', true), array('controller' => 'users', 'action' => 'adminView', $user['User']['id']), array('class' => 'btn btn-sm btn-default'));
                                            #echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $user['User']['id']), array('class' => 'btn btn-sm btn-default'));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if(empty($users)) { ?>
                            <tr>
                                <td colspan="7"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <hr />

        <?php // list all hosts ?>
        <h3><?php echo __('Hosts', true); ?></h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo 'Id'; ?></th>
                            <th></th>
                            <th><?php echo __('Name', true); ?></th>
                            <th><?php echo __('Polls', true); ?></th>
                            <th><?php echo __('Created', true); ?></th>
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
                                    <?php echo $host['Host']['count_polls']; ?>
                                </td>
                                <td>
                                    <?php echo $this->Time->format($formats['datetime'], $host['Host']['created']); ?>
                                </td>
                                <td class="">
                                    <div class="btn-group pull-right">
                                        <?php
                                            echo $this->Html->link(__('View', true), array('controller' => 'hosts', 'action' => 'adminView', $host['Host']['id']), array('class' => 'btn btn-sm btn-default'));
                                            #echo $this->Html->link(__('Edit', true), array('action' => 'adminEdit', $host['Host']['id']), array('class' => 'btn btn-sm btn-default'));
                                            #echo $this->Html->link(__('Delete', true), array('action' => 'delete', $host['Host']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php if(empty($hosts)) { ?>
                            <tr>
                                <td colspan="6"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <hr />

        <?php // list all invoices ?>
        <h3><?php echo __('Invoices', true); ?></h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo 'Id'; ?></th>
                            <th><?php echo __('Number', true); ?></th>
                            <th><?php echo __('Description', true); ?></th>
                            <th><?php echo __('Valid until', true); ?></th>
                            <th><?php echo __('Amount', true); ?></th>
                            <th><?php echo __('Statuses', true); ?></th>
                            <th class="text-right"><?php echo __('Actions', true);?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($invoices as $invoice) { ?>
                            <tr>
                                <td>
                                    <?php echo $invoice['Invoice']['id']; ?>
                                </td>
                                <td>
                                    <?php echo Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number']; ?>
                                </td>
                                <td>
                                    <?php echo $invoice['Invoice']['description']; ?>
                                </td>
                                <td>
                                    <?php echo $this->Time->format($formats['datetime'], $invoice['Invoice']['valid_until']); ?>
                                </td>
                                <td>
                                    <?php echo $this->Number->format($invoice['Invoice']['final_total'], $formats['currency']); ?>
                                </td>
                                <td>
                                    <?php
                                        switch($invoice['Invoice']['status']) {
                                            case 0:
                                                $class = 'default';
                                                break;
                                            case 1:
                                                $class = 'warning';
                                                break;
                                            case 2:
                                                $class = 'success';
                                                break;
                                            case 3:
                                            case 4:
                                                $class = 'danger';
                                                break;
                                            case 5:
                                                $class = 'info';
                                                break;
                                        }
                                    ?>
                                    <span class="label label-<?php echo $class; ?>"><?php echo $statuses_invoices[$invoice['Invoice']['status']]; ?></span>
                                </td>
                                <td class="">
                                    <div class="btn-group pull-right">
                                        <?php echo $this->Html->link(__('View', true), array('controller' => 'invoices', 'action' => 'adminView', $invoice['Invoice']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                                        <?php echo $this->Html->link(__('Download', true), array('controller' => 'invoices', 'action' => 'adminDownload', $invoice['Invoice']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if(empty($invoices)) { ?>
                            <tr>
                                <td colspan="7"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<!-- add host modal -->
<div id="modal-host-add" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Add new host', true); ?></h3>
            </div>

            <div class="modal-body">
                <div class="clearfix">dddd
                    <?php
                        echo $this->Form->input('Host.name', array(
                            'label' => __('Host name', true),
                            'placeholder' => __('Name of the host', true),
                            'type' => 'text',
                            'id' => 'hosts-name',
                            'class' => 'form-control',
                            'div' => array('class' => 'form-group'),
                            'after' => '<div class="error-message">'.__('Please enter a name for the host!', true).'</div>',
                            'escape' => false
                        ));
                        echo $this->Form->input('Host.locale', array(
                            'label' => __('Standard language for polls of this host', true),
                            'type' => 'select',
                            'options' => $options_locale,
                            'id' => 'hosts-locale',
                            'class' => 'form-control',
                            'div' => array('class' => 'form-group'),
                            'after' => '<div class="error-message">'.__('Please select a standard locale for polls of this host!', true).'</div>',
                            'escape' => false
                        ));
                        echo $this->Form->input('Host.timezone', array(
                            'label' => __('Timezone of the host', true),
                            'type' => 'select',
                            'options' => $options_timezones,
                            'selected' => 'America/New_York',
                            'id' => 'hosts-timezone',
                            'class' => 'form-control',
                            'div' => array('class' => 'form-group'),
                            'after' => '<div class="error-message">'.__('Please select a timezone for the host-location!', true).'</div>',
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
