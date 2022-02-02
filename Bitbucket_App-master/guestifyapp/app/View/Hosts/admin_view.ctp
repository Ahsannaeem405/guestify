<?php
    $this->set('title_for_layout', __('Poll', true).' - '.$host['Host']['name']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Hosts', true), array('controller' => 'hosts', 'action' => 'adminIndex'), array('escape' => false));
    $this->Html->addCrumb($host['Host']['name']);

    echo $this->Html->script('View/Hosts/admin_view', false);
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Add Poll', true), '#', array('id' => 'add-poll-'.$host['Host']['id'], 'class' => 'add-poll btn btn-info', 'escape' => false)); ?>
    <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Edit', true), array('action' => 'adminEdit', $host['Host']['id']), array('class' => 'add-poll btn btn-info', 'escape' => false)); ?>
</div>

<h2><?php echo $host['Host']['name']; ?></h2>

<div class="panel oanel-default">
    <div class="panel-body">

        <div class="row">
            <div class="col-xs-7">
                <div class="clearfix">
                    <h3><?php echo __('Basic information', true);?></h3>
                    <dl class="dl-horizontal">
                        <dt><?php echo __('Id', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['id']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Standard language', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['locale']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Timezone', true); ?></dt>
                        <dd>
                            <?php echo $timezones[$host['Host']['timezone']]; ?>
                            &nbsp;
                        </dd>                        
                    </dl>

                    <h3><?php echo __('System information', true);?></h3>
                    <dl class="dl-horizontal">
                        <dt><?php echo __('Last modified', true); ?></dt>
                        <dd>
                            <?php echo $this->Time->format($formats['datetime'], $host['Host']['modified']); ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Created', true); ?></dt>
                        <dd>
                            <?php echo $this->Time->format($formats['datetime'], $host['Host']['created']); ?>
                            &nbsp;
                        </dd>
                    </dl>

                    <h3><?php echo __('Location information', true);?></h3>
                    <dl class="dl-horizontal">
                        <dt><?php echo __('Address', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['address']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Zipcode', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['zipcode']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('City', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['city']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Country', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['country_name']; ?>
                            &nbsp;
                        </dd>
                    </dl>

                    <h3><?php echo __('Contact information', true);?></h3>
                    <dl class="dl-horizontal">
                        <dt><?php echo __('Phone', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['phone']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Fax', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['fax']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Email', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['email']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Web', true); ?></dt>
                        <dd>
                            <?php
                                if(!empty($host['Host']['web'])) {
                                    echo $this->Html->link($host['Host']['web'], $host['Host']['web'], array('target' => 'blank'));
                                }
                            ?>
                            &nbsp;
                        </dd>
                    </dl>

                    <?php
                        $empty = true;
                        foreach($values_socials as $type_id => $link) {
                            if(!empty($link)) {
                                $empty = false;
                            }
                        }
                    ?>

                    <?php if(!$empty)  { ?>
                        <h3><?php echo __('Social links', true);?></h3>
                        <dl class="dl-horizontal">
                            <?php foreach($values_socials as $type_id => $link) { ?>
                                <?php if(!empty($link)) { ?>
                                    <dt><?php echo $socials[$type_id]; ?></dt>
                                    <dd>
                                        <?php echo $values_socials[$type_id]; ?>
                                        &nbsp;
                                    </dd>
                                <?php } ?>
                            <?php } ?>
                        </dl>
                    <?php } ?>

                    <h4><?php echo __('Account information', true); ?></h4>
                    <dl class="dl-horizontal">
                        <dt><?php echo __('Company name', true); ?></dt>
                        <dd>
                            <?php echo $this->Html->link($host['Account']['company_name'], array('controller' => 'accounts', 'action' => 'adminView', $host['Account']['id'])); ?>
                        </dd>
                        <dt><?php echo __('Street', true); ?></dt>
                        <dd>
                            <?php echo $host['Account']['address']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Zipcode', true); ?></dt>
                        <dd>
                            <?php echo $host['Account']['zipcode']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('City', true); ?></dt>
                        <dd>
                            <?php echo $host['Account']['city']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Country', true); ?></dt>
                        <dd>
                            <?php echo $host['Account']['country_name']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Phone', true); ?></dt>
                        <dd>
                            <?php echo $host['Account']['phone']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Mobile', true); ?></dt>
                        <dd>
                            <?php echo $host['Account']['mobile']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Fax', true); ?></dt>
                        <dd>
                            <?php echo $host['Account']['fax']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Last modified', true); ?></dt>
                        <dd>
                            <?php echo $this->Time->format($formats['datetime'], $host['Account']['modified']); ?>
                        </dd>
                        <dt><?php echo __('Created', true); ?></dt>
                        <dd>
                            <?php echo $this->Time->format($formats['datetime'], $host['Account']['created']); ?>
                        </dd>
                    </dl>

                </div>
            </div>

            <div class="col-xs-5">
                <h3><?php echo __('Logo', true);?></h3>
                <?php
                    if(!empty($host['Host']['logo'])) {
                        echo $this->Html->image(Configure::read('CDN.Host'). 'hosts' . DS . 300 . DS . $host['Host']['logo'], array('class' => 'img-thumbnail'));
                    } else {
                        #echo 'Placeholder here!';
                        echo $this->Html->image(Configure::read('CDN.Host'). 'hosts' . DS . 300 . DS . 'no_pic.jpg', array('class' => 'img-thumbnail'));
                    }
                ?>

                <?php if(isset($host['Host']['lat']) && !empty($host['Host']['lat'])) { ?>
                    <hr />

                    <div class="clearfix">
                    <h3><?php echo __('Map', true); ?></h3>

                        <?php
                            echo $this->element('Hosts/map', array(
                                'lat' => $host['Host']['lat'],
                                'lng' => $host['Host']['lng'],
                                'host' => $host,
                                'width' => '100%',
                                'height' => '300px',
                                'zoom' => '10'
                            )); 
                        ?>

                    </div>
                <?php } ?>
            </div>
        </div>

        <hr />

        <?php // list all polls ?>
        <h3><?php echo __('Polls', true); ?></h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo 'Id'; ?></th>
                            <th><?php echo __('Title', true); ?></th>
                            <th><?php echo __('Type', true); ?></th>
                            <th><?php echo __('Views', true); ?></th>
                            <th><?php echo __('Ratings received', true); ?></th>
                            <th><?php echo __('Status', true); ?></th>
                            <th><?php echo __('Created', true); ?></th>
                            <th class="text-right"><?php echo __('Actions', true);?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($polls as $poll) { ?>
                            <tr>
                                <td>
                                    <?php echo $poll['Poll']['id']; ?>
                                </td>
                                <td>
                                    <?php echo $poll['Poll']['title']; ?>
                                </td>
                                <td>
                                    add type here...
                                </td>
                                <td>
                                    <?php echo $poll['Poll']['count_views']; ?>
                                </td>
                                <td>
                                    <?php echo $poll['Poll']['ratings_received']; ?>
                                </td>
                                <td>
                                    <?php
                                        switch($poll['Poll']['status']) {
                                            case 0:
                                                $class = 'warning';
                                                break;
                                            case 1:
                                                $class = 'success';
                                                break;
                                        }
                                    ?>
                                    <span class="label label-<?php echo $class; ?>"><?php echo $statuses_polls[$poll['Poll']['status']]; ?></span>
                                </td>
                                <td>
                                    <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['created']); ?>
                                </td>
                                <td class="">
                                    <div class="btn-group pull-right">
                                        <?php
                                            echo $this->Html->link(__('View', true), array('controller' => 'polls', 'action' => 'showLast30', $poll['Poll']['id']), array('class' => 'btn btn-sm btn-default'));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if(empty($polls)) { ?>
                            <tr>
                                <td colspan="8"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <hr />


        </div>

    </div>
</div>


<!-- add poll modal -->
<div id="modal-poll-add" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Add poll', true); ?></h3>
            </div>
            <div class="modal-body">
                <?php
                    echo $this->Form->input('Poll.title', array(
                        'label' => __('Title', true),
                        'type' => 'text',
                        'id' => 'polls-title',
                        'class' => 'form-control',
                        'after' => '<div class="error-message">'.__('Please enter a title for the poll!', true).'</div>',
                        'escape' => false
                    ));
                    echo $this->Form->input('Poll.code', array(
                        'label' => __('PIN code', true),
                        'type' => 'text',
                        'id' => 'polls-code',
                        'class' => 'form-control',
                        'after' => '<div class="error-message">'.__('Please enter the pin-code for the poll!', true).'</div>',
                        'escape' => false
                    ));
                ?>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="modal-spinner-poll-add" style="display: none;"/>
                <button class="btn btn-default" id="poll-add-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="poll-add-confirm" type="button"><?php echo __('Add', true); ?></button>
            </div>
        </div>
    </div>
</div>




<?php #echo $this->element('Widgets/standard_activate/main'); ?>
<?php #echo $this->element('Widgets/standard_deactivate/main'); ?>
<?php #echo $this->element('Widgets/standard_delete/main'); ?>
