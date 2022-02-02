<table class="table table-striped">
    <thead>
        <tr>
            <th width="50"><?php echo $this->Paginator->sort('id', 'Id');?></th>
            <th width="250"><?php echo $this->Paginator->sort('token', __('Token', true)); ?></th>
            <th><?php echo $this->Paginator->sort('content', __('Content', true)); ?></th>
            <th class="actions" width="150"><?php echo $this->Paginator->sort('created', __('Created', true)); ?>/ <?php echo $this->Paginator->sort('modified', __('Modified', true)); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tokens as $token) { ?>
            <tr>
                <td>
                    <?php echo $token['Token']['id']; ?>
                </td>
                <td>
                    <?php echo $token['Token']['token']; ?>
                </td>
                <td>
                    <?php
                        echo $this->Form->input('Token.'.$token['Token']['id'].'.content', array(
                            'label' => false,
                            'type' => 'textarea',
                            'id' => 'tokens-'.$token['Token']['id'].'-content',
                            'class' => 'form-control',
                            'value' => $token['Token']['content']
                        ));
                    ?>
                    <?php
                        # build the tooltip title-string
                        $locs = explode(',', $token['Token']['locations']);
                        $tooltip_string = '';
                        foreach($locs as $loc) {
                            $tooltip_string .= $loc.'<br />';
                        }
                    ?>
                    <?php if(count($locs) > 1) { ?>
                        <?php echo __('Locations', true); ?>
                    <?php } else { ?>
                        <?php echo __('Location', true); ?>
                    <?php } ?>:<br />
                    <small><?php echo $tooltip_string; ?></small>

                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Update', true), '#', array('id' => 'token-update-'.$token['Token']['id'], 'class' => 'btn btn-sm btn-success token-update')); ?>
                    <?php #echo $this->Html->link(__('Delete', true), array('action' => 'delete', $token['Token']['id']), array('id' => 'token-delete-'.$token['Token']['id'], 'class' => 'btn btn-sm btn-danger delete_standard')); ?>
                    <img src="/img/spinner.gif" class="spinner" id="spinner-<?php echo $token['Token']['id']; ?>"style="opacity: 0;" />
                    <hr />
                    <small class="clearfix"><?php echo $this->Time->format($formats['datetime'], $token['Token']['created']); ?>/ <br /><?php echo $this->Time->format($formats['datetime'], $token['Token']['modified']); ?></small>
                </td>
            </tr>
        <?php } ?>
        <?php if(empty($tokens)) { ?>
            <tr>
                <td colspan="7"><div class="placeholderbox"><?php echo __('No entries', true); ?></div></td>
            </tr>
        <?php  } ?>
    </tbody>
</table>
<?php echo $this->element('counting_paginator'); ?>

<script>
    $(document).ready(function() {
        $('.glyphicon-comment').tooltip({html:true});
    });
</script>

<style>
.tooltip-inner { max-width: 400px; }
</style>
