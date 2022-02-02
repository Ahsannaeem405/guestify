<td>
    <?php echo $link['TrackersLink']['id']; ?>
</td>
<td>
    <?php echo $link['TrackersLink']['url']; ?>
</td>
<td>
    <span class="label label-<?php echo $trackers_link_statuses_labels[$link['TrackersLink']['status']]; ?>">
        <?php echo $trackers_link_statuses[$link['TrackersLink']['status']]; ?>
    </span>
</td>
<td>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="glyphicon glyphicon-cog"></span>  <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <?php echo $this->Html->link(__('Show details', true), '#', array('id' => 'trackers_link-show-details-'.$link['TrackersLink']['id'], 'class' => 'trackers_link-show-details')); ?>
            </li>
            <li>
                <?php echo $this->Html->link(__('Edit', true), '#', array('id' => 'trackers_link-edit-'.$link['TrackersLink']['id'], 'class' => 'trackers_link-edit')); ?>
            </li>
            <?php /*
            <li>
                <?php echo $this->Html->link(__('Reset', true), '#', array('id' => 'trackers-link-reset-'.$link['TrackersLink']['id'], 'class' => 'trackers-link-reset')); ?>
            </li>
            */ ?>
            <li class="divider"></li>
            <li>
                <?php echo $this->Html->link(__('Delete', true), array('action' => 'deleteLink', $link['TrackersLink']['id']), array('class' => 'standard-delete')); ?>
            </li>
        </ul>
    </div>
</td> 
