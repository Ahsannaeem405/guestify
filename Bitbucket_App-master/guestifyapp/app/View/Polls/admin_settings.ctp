<?php
    $this->set('title_for_layout', __('Poll', true).' - '.$poll['Poll']['title']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Polls', true), array('controller' => 'polls', 'action' => 'adminIndex'), array('escape' => false));
    $this->Html->addCrumb($poll['Poll']['title']);

    #echo $this->Html->script('View/Polls/view', false);
?>


<div class="btn-toolbar pull-right">
    <?php
        echo $this->Html->link('<span class="glyphicon glyphicon-stats"></span> '.__('Statistics', true), array('action' => 'showLast30', $poll['Poll']['id']), array('class' => 'btn btn-info', 'escape' => false));
        if($poll['Poll']['status'] == 0) {
            echo $this->Html->link('<span class="glyphicon glyphicon-ok-sign"></span> '.__('Activate', true), array('action' => 'activate', $poll['Poll']['id']), array('class' => 'btn btn-success standard-activate', 'escape' => false));
        } elseif ($poll['Poll']['status'] == 1) {
            echo $this->Html->link('<span class="glyphicon glyphicon-ban-circle"></span> '.__('Deactivate', true), array('action' => 'deactivate', $poll['Poll']['id']), array('class' => 'btn btn-warning standard-deactivate', 'escape' => false));
        }

        if($type == 'unlimited') {
            $title = __('Extend Upgrade', true);
        } else {
            $title = __('Upgrade', true);
        }

        echo $this->Html->link('<span class="glyphicon glyphicon-certificate"></span> '.$title, '#', array('id' => 'admin-upgrade-'.$poll['Poll']['id'], 'class' => 'admin-upgrade btn btn-upgrade', 'escape' => false));

        echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ', array('action' => 'adminEdit', $poll['Poll']['id']), array('class' => 'btn btn-default', 'title' => __('Edit', true), 'escape' => false));
        if($poll['Poll']['status'] == 0) {
            echo $this->Html->link('<span class="glyphicon glyphicon-remove-sign"></span>', array('action' => 'delete', $poll['Poll']['id']), array('id' => 'delete-poll-'.$poll['Poll']['id'], 'class' => 'btn btn-danger standard-delete', 'title' => __('Delete', true), 'escape' => false));
        }
    ?>
</div>

<h2>
    <?php echo $poll['Poll']['title']; ?> #<?php echo $poll['Poll']['id']; ?>
    <sup>
        <small>
            <?php
                if($type == 'unlimited') {
                    echo '<span class="label label-upgrade">'.__('PRO', true).' <span class="glyphicon glyphicon-certificate"></span></span>';
                }
            ?>
        </small>
    </sup>
</h2>

<div class="row">
    <div class="col-xs-5"></div>
    <div class="col-xs-7">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-white pull-right" role="tablist">
            <li class="active"><a href="#basics" role="tab" data-toggle="tab"><?php echo __('Basics', true);?></a></li>
            <li><a href="#style" role="tab" data-toggle="tab"><?php echo __('Style Options', true); ?></a></li>
            <li><a href="#tablecards" role="tab" data-toggle="tab"><?php echo __('Table Cards', true); ?></a></li>
            <li><a href="#invoices" role="tab" data-toggle="tab"><?php echo __('Invoices', true); ?></a></li>
        </ul>
    </div>

</div>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="basics">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-8">

                        <h3><?php echo __('Access', true); ?></h3>
                        <?php if(isset($latest_invoice) && !empty($latest_invoice) && ($latest_invoice['Invoice']['valid_until'] > date('Ym-d H:i:s'))) { ?>
                            <div class="alert alert-success">
                                <p class="text-center"><strong><?php echo __('This poll is upgraded to a PRO version', true); ?></strong> </p>
                                <p class="text-center">
                                    <?php echo __('Remaining', true); ?>:
                                    <?php echo $latest_invoice['Invoice']['daysdiff']*(-1); ?> <?php echo __('days', true); ?> (<?php echo __('ends on', true); ?>: <?php echo $this->Time->format($formats['datetime'], $latest_invoice['Invoice']['valid_until']); ?>)
                                </p>
                            </div>
                        <?php } ?>

                        <hr />

                        <div class="row">
                            <div class="col-xs-2">
                                <div class="score  text-center">
                                    <small><?php echo __('Limit'); ?></small>
                                    <p class="number">
                                        <?php if($type == 'unlimited') { ?>
                                            <span title="<?php echo __('Unlimited', true); ?>"> - - -</span>
                                        <?php } else { ?>
                                            <?php echo $poll['Poll']['limit']; ?>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <div class="score  text-center">
                                    <small><?php echo __('Views', true); ?></small>
                                    <p class="number">
                                        <?php echo $poll['Poll']['count_views']; ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <div class="score  text-center">
                                    <small><?php echo __('Received ratings', true); ?></small>
                                    <p class="number">
                                        <?php echo $poll['Poll']['ratings_received']; ?>
                                    </p>
                                </div>
                            </div>

                            <?php if($type == 'limited') { ?>
                                <div class="col-xs-2">
                                    <div class="score text-center">
                                        <small><?php echo __('Remaining ratings', true); ?></small>
                                        <p class="number">
                                            <?php echo $poll['Poll']['limit'] - $poll['Poll']['ratings_received']; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-xs-2">
                                <div class="score text-center">
                                    <small><?php echo __('CTR', true); ?></small>
                                    <p class="number">
                                        <?php
                                            $ctr = '';
                                            if(empty($poll['Poll']['count_views'])) {
                                                echo '--';

                                            } else {
                                                $ctr = $poll['Poll']['ratings_received'] / $poll['Poll']['count_views'] * 100;
                                                echo round($ctr, 1).' %';
                                            }
                                        ?>
                                    </p>
                                </div>
                            </div>

                        </div>

                        <hr />

                        <h3><?php echo __('General information'); ?></h3>
                        <dl class="dl-horizontal">

                            <dt><?php echo __('Status'); ?></dt>
                            <dd>
                                <?php
                                    if($poll['Poll']['status'] == 0) {
                                        echo '<span class="label label-warning">'.$statuses[$poll['Poll']['status']].'</span>';
                                    } elseif ($poll['Poll']['status'] == 1) {
                                        echo '<span class="label label-success">'.$statuses[$poll['Poll']['status']].'</span>';
                                    }
                                ?>
                            </dd>
                            <dt><?php echo __('Hash'); ?></dt>
                            <dd>
                                <?php echo $poll['Poll']['hash']; ?>
                            </dd>
                            <dt><?php echo __('Scale'); ?></dt>
                            <dd>
                                1 - <?php echo $max_scale; ?>
                            </dd>
                            <dt><?php echo __('Individual text'); ?></dt>
                            <dd>
                                <?php echo $poll['Poll']['text']; ?>
                            </dd>
                                <?php if(!empty($invoices)) { ?>
                                    <dt><?php echo __('Premium active', true); ?></dt>
                                    <dd><?php echo $this->Time->format($formats['datetime'], $invoices[0]['Invoice']['valid_until']); ?></dd>
                                <?php } ?>
                        </dl>

                        <hr />

                        <dl class="dl-horizontal">
                            <dt><?php echo __('Host'); ?></dt>
                            <dd>
                                <?php echo $poll['Host']['name']; ?>
                            </dd>

                            <dt><?php echo __('Created'); ?></dt>
                            <dd>
                                <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['created']); ?>
                            </dd>
                            <dt><?php echo __('Last modified'); ?></dt>
                            <dd>
                                <?php echo $this->Time->format($formats['datetime'], $poll['Poll']['modified']); ?>
                            </dd>
                        </dl>


                        <?php if(isset($upgrade_history) && !empty($upgrade_history)) { ?>
                            <hr />
                            <h3><?php echo __('Upgrade history', true); ?></h3>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><?php echo __('Created', true); ?></th>
                                                <th><?php echo __('Type', true); ?></th>
                                                <th><?php echo __('Invoice number', true); ?></th>
                                                <th><?php echo __('Valid from', true); ?></th>
                                                <th><?php echo __('Valid until', true); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($upgrade_history as $upgrade) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo CakeTime::format($formats['date'], strtotime($upgrade['created'])); ?>
                                                    </td>
                                                    <td>
                                                        <?php if($upgrade['type'] == 'Invoice') { ?>
                                                            <?php echo __('Invoice', true); ?>
                                                        <?php } else { ?>
                                                            <?php echo __('System-upgrade', true); ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if($upgrade['type'] == 'Invoice') { ?>
                                                            <?php echo $this->Html->link($upgrade['invoice_number'], array('controller' => 'invoices', 'action' => 'view', $upgrade['id'])); ?>
                                                        <?php } else { ?>
                                                            &mdash;
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php echo CakeTime::format($formats['datetime'], strtotime($upgrade['valid_from'])); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo CakeTime::format($formats['datetime'], strtotime($upgrade['valid_until'])); ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-xs-4">
                        <div class="pull-right">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <?php if(isset($filename_300)) { ?>
                                        <h4>QR-Code</h4>
                                        <?php echo $this->Html->Image('/img/qrcodes/'.$filename_300); ?>
                                    <?php } ?>
                                    <hr />
                                    <h4><?php echo __('Poll URL', true); ?></h4>
                                    <p class="lead text-center"><?php echo $this->Html->link(Configure::read('URL_feedbackapp').'/'.$poll['Poll']['hash'], Configure::read('URL_feedbackapp').'/'.$poll['Poll']['hash'], array('target' => 'blank')); ?></p>
                                    <hr />
                                    <?php if(!empty($poll['Poll']['alt_url'])) { ?>
                                        <h4><?php echo __('Alternative URL', true); ?></h4>
                                        <p class="lead text-center"><?php echo $this->Html->link($poll['Poll']['alt_url'], $poll['Poll']['alt_url'], array('target' => 'blank')); ?></p>
                                        <hr />
                                    <?php } ?>

                                    <div class="alert alert-info">
                                        <p class="lead text-center"><?php echo __('Pin'); ?>: <?php echo $poll['Poll']['code']; ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <?php /*
                <?php if(!empty($invoices)) { ?>
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
                                        <th><?php echo __('Status', true); ?></th>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
                */ ?>
            </div>
        </div>
    </div>


    <div class="tab-pane" id="style">
        <div class="panel panel-default">
            <div class="panel-body">
                <h3><?php echo __('Style options'); ?></h3>
                <dl class="dl-horizontal">

                    <dt><?php echo __('Theme'); ?></dt>
                    <dd>
                        <?php echo $themes[$poll['Poll']['theme_id']]; ?><br />
                        <?php
                            $graphic_extension = 'png';
                            if($poll['Poll']['theme_id'] == 6) {
                                $graphic_extension = 'svg';
                            }
                        ?>
                        <img src="/graphics/smiley-set<?php echo $poll['Poll']['theme_id']; ?>/scale_4.<?php echo $graphic_extension; ?>" width="50px">
                        <hr />
                    </dd>
                    <dt><?php echo __('Main color'); ?></dt>
                    <dd>
                        <p><span class="label label-default" style="background-color: #<?php echo $poll['Poll']['color']; ?>;">&nbsp;&nbsp;&nbsp;</span></p>
                        <p><?php echo __('This color will be used for text and border color', true); ?></p>
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="tablecards">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4><?php echo __('Download Tablecard', true); ?></h4>
                <p><?php echo __('Here you have downloadable PDF documents you use and print for your tables.', true); ?></p>

                <div class="row">
                    <div class="col-xs-3">
                        <div class="document">
                            <p>&nbsp;</p>
                            <h3 class="text-center">DIN<br />LANG (H)</h3>
                        </div>
                        <?php echo $this->Html->link('Download DIN LANG (H)', array('action' => 'downloadCard', $poll['Poll']['id'], 'LANG'), array('class' => 'btn btn-block btn-default')); ?>
                    </div>
                    <div class="col-xs-3">
                        <div class="document">
                            <p>&nbsp;</p>
                            <h3 class="text-center">DIN<br />A6</h3>
                        </div>
                        <?php echo $this->Html->link('Download DIN A6', array('action' => 'downloadCard', $poll['Poll']['id'], 'A6'), array('class' => 'btn btn-block btn-default')); ?>
                    </div>
                    <div class="col-xs-3">
                        <div class="document">
                            <p>&nbsp;</p>
                            <h3 class="text-center">DIN<br />A7</h3>
                        </div>
                        <?php echo $this->Html->link('Download DIN A7', array('action' => 'downloadCard', $poll['Poll']['id'], 'A7'), array('class' => 'btn btn-block btn-default')); ?>
                    </div>

                    <div class="col-xs-3"></div>
                </div>
                <p>&nbsp;</p>
                <p><?php echo __('If you do not find the document size, just tell us.'); ?></p>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="invoices">
        <div class="panel panel-default">
            <div class="panel-body">
                <h3><?php echo __('Invoices', true); ?></h3>
                <?php if(!empty($invoices)) { ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo 'Id'; ?></th>
                                        <th><?php echo __('Number', true); ?></th>
                                        <th><?php echo __('Description', true); ?></th>
                                        <th><?php echo __('Valid until', true); ?></th>
                                        <th><?php echo __('Value', true); ?></th>
                                        <th></th>
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
                                            <td class="">
                                                <div class="btn-group pull-right">
                                                    <?php echo $this->Html->link(__('View', true), array('controller' => 'invoices', 'action' => 'view', $invoice['Invoice']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                                                    <?php echo $this->Html->link(__('Download', true), array('controller' => 'invoices', 'action' => 'download', $invoice['Invoice']['id']), array('class' => 'btn btn-sm btn-default')); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="placeholderbox"><?php echo __('No entries', true); ?></div>
                <?php } ?>

            </div>
        </div>
    </div>

</div>


<?php echo $this->element('Widgets/standard_activate/main'); ?>
<?php echo $this->element('Widgets/standard_deactivate/main'); ?>

<div id="modal-standard-delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="StandardDelete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Delete entry?', true); ?></h3>
            </div>
            <div class="modal-body">
                <p class="modal-body-text">
                    <?php echo __('Are you sure you want to delete this poll?', true); ?>
                </p>
                <div class="alert alert-danger">
                    <i><?php echo __('Note: Your data will be permanently deleted and cannot be restored!', true); ?></i>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="standard-delete-spinner"/>
                <button class="btn btn-default" id="standard-delete-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-danger" id="standard-delete-confirm" type="button"><?php echo __('Delete', true); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="modal-admin-upgrade" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AdminUpgrade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Upgrade poll', true); ?></h3>
            </div>

            <div class="modal-body">

                <p class="modal-body-text">
                    <?php echo __('Please select the duration for the update', true); ?>:
                </p>

                <?php echo $this->Form->create('Poll', array('url' => $this->here)); ?>

                    <?php
                        echo $this->Form->input('Poll.upgrade_period', array(
                            'label' => __('Upgrade period', true),
                            'type' => 'select',
                            'empty' => __('Select upgrade period...', true),
                            'options' => $upgrade_periods,
                            'id' => 'polls-upgrade_period',
                            'class' => 'form-control'
                        ));
                    ?>

                <?php echo $this->Form->end(); ?>

            </div>

            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="admin-upgrade-spinner"/>
                <button class="btn btn-default" id="admin-upgrade-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-info disabled" id="admin-upgrade-confirm" type="button"><?php echo __('Apply!', true); ?></button>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function() {


        // standard delete
        $('#admin-upgrade-spinner').hide();

        var poll_id = 0;

        $(document).on('change', '#polls-upgrade_period', function() {
            if($(this).val() != '') {
                $('#admin-upgrade-confirm').removeClass('disabled');
            } else {
                $('#admin-upgrade-confirm').addClass('disabled');
            }
        });


        $(document).on('click', 'a.admin-upgrade', function() {
            poll_id = $(this).attr('id').split('-').pop();
            $('#admin-upgrade-spinner').hide();
            $('#polls-upgrade_period').val('');
            $('#polls-upgrade_period').addClass('disabled');
            $('#modal-admin-upgrade').find('div.error-message').remove();
            $('#modal-admin-upgrade').modal();
            return false;
        });


        $('#admin-upgrade-confirm').click(function() {
            if($(this).hasClass('disabled')) {
                return false;
            }

            $('#admin-upgrade-spinner').show();
            $('#admin-upgrade-confirm').addClass('disabled');

            $.ajax({
                url: '/polls/adminUpgrade',
                data: {
                    "poll_id":  poll_id,
                    "period":   encodeURIComponent($('#polls-upgrade_period').val())
                },
                dataType: 'json',
                success: function(result) {

                    if(typeof result =='object') {
                        $('#admin-upgrade-spinner').hide('fast');
                        jQuery.each(result, function(field, message) {
                            $('#polls-'+field).parent('div').append('<div class="error-message" style="display: none;">'+message+'</div>').fadeIn('fast');
                        });
                    } else {
                        location.reload();
                    }
                    return false;
                }
            });

            return false;
        });



        // standard delete
        $('#standard-delete-spinner').hide();

        var delete_url = '';

        $(document).on('click', 'a.standard-delete', function() {
            delete_url = $(this).attr('href');
            $('#modal-standard-delete').modal();
            return false;
        });

        $('#standard-delete-confirm').click(function() {
           $('#standard-delete-spinner').show();
           document.location = delete_url;
           return false;
        });

    });

</script>
