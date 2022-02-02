<?php
    $this->set('title_for_layout', __('Trackers', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('Trackers', true));
?>

<div class="clearfix">

    <div class="btn-toolbar pull-right clearfix">
        <?php
            echo $this->Form->input('Trackers.type', array(
                'label' => false,
                'type' => 'select',
                'options' => $types,
                'class' => 'form-control',
                'id' => 'selector-type',
                'selected' => $this->params['Tracker.selected']
            ));
        ?>
    </div>

    <h2><?php echo __('Trackers'); ?></h2>
    
    <div class="panel panel-default">
        
        <div class="panel-body">
            
            <?php echo $this->element('Trackers/scorecard'); ?>

            <div class="clearfix">&nbsp;</div>

            <?php echo $this->element('Trackers/navtabs'); ?>

            <?php echo $this->element('counting_paginator'); ?>

            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('id', 'ID');?></th>
                        <th><?php echo $this->Paginator->sort('recipient_email', __('Email', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('Status', __('Status', true)); ?></th>
                        <th><?php echo $this->Paginator->sort('open_count', __('Open count', true)); ?></th>
                        <th><?php echo __('Links visited', true); ?></th>
                        <th><?php echo $this->Paginator->sort('created', __('Created', true)); ?></th>
                        <th class="text-right"><?php echo __('Actions', true);?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($trackers as $tracker) { ?>
                        <tr>
                            <td>
                                <?php echo $tracker['Tracker']['id']; ?>
                            </td>
                            <td>
                                <?php echo $tracker['Tracker']['recipient_email']; ?>
                            </td>
                            <td>
                                <span class="label label-<?php echo $statuses_labels[$tracker['Tracker']['status']]; ?>"><?php echo $statuses[$tracker['Tracker']['status']]; ?></span>
                                &nbsp;
                            </td>
                            <td>
                                <?php echo $tracker['Tracker']['open_count']; ?>
                            </td>
                            <td>
                                <?php
                                    if(empty($tracker['TrackersLink'])) {
                                        echo '-';
                                    } else {
                                        $link_count = count($tracker['TrackersLink']);
                                        $link_count_visited = 0;
                                        foreach($tracker['TrackersLink'] as $link) {
                                            if($link['status'] == 1) {
                                                $link_count_visited++;
                                            }
                                        }
                                        echo $link_count_visited . '/' . $link_count;
                                    }
                                ?>
                            </td>
                            <td>
                                <?php echo $this->Time->format($formats['datetime'], $tracker['Tracker']['created']); ?>
                            </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <?php
                                        echo $this->Html->link(__('View', true), array('action' => 'view', $tracker['Tracker']['id']), array('class' => 'btn btn-sm btn-default'));
                                        echo $this->Html->link(__('Delete', true), array('action' => 'adminDelete', $tracker['Tracker']['id']), array('class' => 'btn btn-sm btn-danger standard-delete'));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    
                    <?php if(empty($trackers)) { ?>
                        <tr>
                            <td colspan="6"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
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