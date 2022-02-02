<?php
    $this->set('title_for_layout', __('Edit draft', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('System', true), array('controller' => 'pages', 'action' => 'display', 'system'));
    $this->Html->addCrumb(__('Drafts', true), array('controller' => 'drafts', 'action' => 'admin_index'));
    $this->Html->addCrumb($draft['Draft']['name_'.$locale], array('controller' => 'drafts', 'action' => 'admin_view', $draft['Draft']['id']));
    $this->Html->addCrumb(__('Add draft', true));
?>

<?php # jQuery UI needed for sortable/draggable ?>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<?php # load the creators main-js for all needed functions ?>
<?php echo $this->Html->script('View/Drafts/creator_edit', false); ?>

<?php
    $draft      = $this->Session->read('DraftsEdit.Draft');
    $scale_selected  = $this->Session->read('DraftsEdit.scale_selected');

    $options_scale = array();
    for($i = 1; $i <= 6; $i++) {
        $options_scale[$i] = $i;
    }
?>

<script>
	$(document).ready(function(){
	    $("#myAffix").affix({
	        offset: { 
	            top: 50
	        }
	    });
	});
</script>

<span id="creator-draft-id" style="display: none;"><?php echo $draft['Draft']['id']; ?></span>

<div class="clearfix">

    <div class="btn-toolbar pull-right clearfix">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span> '.__('Cancel', true), array('action' => 'admin_view', $draft['Draft']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
    </div>

    <h2><?php echo __('Edit draft'); ?></h2>

    <div class="row">
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row" id="wrapper-creator">
                        <div class="col-lg-2">
                            <div class="alert alert-warning">
                                <?php
                                    echo $this->Form->input('Draft.locale', array(
                                        'label' => false,
                                        'type' => 'select',
                                        'options' => array(
                                            'eng' => __('English', true),
                                            'deu' => __('German', true)
                                        ),
                                        'disabled' => true,
                                        'selected' => $this->Session->read('DraftsEdit.locale_selected'),
                                        'class' => 'form-control',
                                        'id' => 'creator-draft-locale'
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="alert alert-warning">
                                <?php
                                    echo $this->Form->input('Draft.status', array(
                                        'label' => false,
                                        'type' => 'select',
                                        'options' => array(
                                            0 => __('inactive', true),
                                            1 => __('active', true)
                                        ),
                                        'selected' => $draft['Draft']['status'],
                                        'class' => 'form-control',
                                        'id' => 'creator-draft-status'
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="alert alert-warning">
                                <?php
                                    echo $this->Form->input('Draft.name_'.$locale, array(
                                        'label' => false,
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'placeholder' => __('Enter the title of your poll-draft here', true),
                                        'value' => $this->Session->read('DraftsEdit.title'),
                                        'id' => 'creator-draft-name'
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="alert alert-warning">
                                <?php
                                    echo $this->Form->input('Draft.scale', array(
                                        #'label' => __('Scale', true),
                                        'label' => false,
                                        'type' => 'select',
                                        'empty' => __('Select scale...', true),
                                        'options' => $options_scale,
                                        'selected' => $scale_selected,
                                        'class' => 'form-control',
                                        'id' => 'creator-draft-scale'
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Add group', true), '#', array('class' => 'btn btn-primary creator-trigger-group-add', 'escape' => false)); ?>
                            <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Toggle groups', true), '#', array('class' => 'btn btn-primary creator-trigger-group-toggle-all hide-all pull-right', 'escape' => false)); ?>
                        </div>
                    </div>
                          
                    <div class="clearfix">&nbsp;</div>

                    <div id="draft-wrapper" class="clearfix">
                        <?php if(isset($draft['DraftsGroup']) && !empty($draft['DraftsGroup'])) { ?>
                            <?php foreach($draft['DraftsGroup'] as $group) { ?>
                                <?php echo $this->element('Drafts/Creator/group', array('group' => $group)); ?>
                            <?php } ?>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="panel panel-default" id="myAffix">
                <div class="panel-body">
                    <?php echo $this->Html->link(__('Save changes', true), '#', array('class' => 'btn btn-success btn-block', 'id' => 'creator-trigger-save-edit')); ?>
                    <div class="clearfix">&nbsp;</div>
                    <?php echo $this->Html->link(__('Reset to DB values', true), '#', array('class' => 'btn btn-success btn-block', 'id' => 'creator-trigger-reset-edit')); ?>
                    <div class="clearfix">&nbsp;</div>
                    <?php echo $this->Html->link(__('Cancel', true), '#', array('class' => 'btn btn-default btn-block', 'id' => 'creator-trigger-cancel')); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php # blocks of html used as template-elements ?>
<div style="display: none;">

    <div id="wrapper-template-group">
        <div class="panel panel-info creator-group">

            <div class="panel-heading creator-trigger-group-drag">
                <span class="creator-trigger-group-edit-title"><?php echo __('Click here to edit...', true); ?></span>
                <input class="creator-input-group-edit-title" type="text" placeholder="Enter name of group..." style="display: none;"/>

                <div class="btn-toolbar pull-right clearfix">
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>', '#', array('class' => 'btn btn-xs btn-success creator-trigger-group-add-question', 'escape' => false)); ?>
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', '#', array('class' => 'btn btn-xs btn-danger creator-trigger-group-delete', 'escape' => false)); ?>
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-up"></span>', '#', array('class' => 'btn btn-xs btn-info creator-trigger-group-hide', 'escape' => false)); ?>
                </div>
            </div>

            <div class="panel-body">
                
                <ul class="list-group question-wrapper">
                </ul>

            </div>
        </div>    
    </div>

    <div id="wrapper-template-question">
        <li class="list-group-item">
            <div class="creator-trigger-question-drag">
                <span class="creator-trigger-question-edit"><?php echo __('Click here to edit...', true); ?></span>
                <input class="creator-input-question-edit" type="text" placeholder="Enter name of group..." style="display: none;"/>
                
                <div class="btn-group pull-right" role="group">
                    <button type="button" class="btn btn-danger btn-xs creator-trigger-question-delete"><span class="glyphicon glyphicon-remove"></span></button>
                </div>
            </div>
        </li> 
    </div>

</div>