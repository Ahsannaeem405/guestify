<?php
    $this->set('title_for_layout', __('Add draft', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('System', true), array('controller' => 'pages', 'action' => 'display', 'system'));
    $this->Html->addCrumb(__('Drafts', true), array('controller' => 'drafts', 'action' => 'admin_index'));
    $this->Html->addCrumb(__('Add draft', true));
?>

<?php # jQuery UI needed for sortable/draggable ?>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<?php # load the creators main-js for all needed functions ?>
<?php echo $this->Html->script('View/Drafts/creator', false); ?>


<div class="clearfix">

    <div class="btn-toolbar pull-right clearfix">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Cancel', true), array('action' => 'admin_index'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
    </div>

    <h2><?php echo __('Add draft'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row" id="wrapper-creator">
                <div class="col-lg-12">
                    <div class="alert alert-warning">
                        <?php
                            echo $this->Form->input('Draft.name', array(
                                'label' => __('Title', true),
                                #'label' => false,
                                'type' => 'text',
                                'class' => 'form-control',
                                'id' => 'creator-draft-name',
                                'placeholder' => __('Enter the title of your poll-draft here', true),
                                'after' => '<br />',
                                'escape' => false
                            ));
                        ?>
                    </div>
                </div>
            </div>


            <div class="row" id="wrapper-creator">
                <div class="col-lg-4">
                    <div class="alert alert-warning">
                        <?php
                            echo $this->Form->input('Draft.locale', array(
                                'label' => __('Locale', true),
                                #'label' => false,
                                'type' => 'select',
                                'class' => 'form-control',
                                'id' => 'creator-draft-locale',
                                'options' => array(
                                    'eng' => __('English', true),
                                    'deu' => __('German', true)
                                ),
                                'empty' => __('Select locale...', true),
                                'after' => '<br />',
                                'escape' => false
                            ));
                        ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="alert alert-warning">
                        <?php
                            echo $this->Form->input('Draft.status', array(
                                #'label' => false,
                                'label' => __('Status', true),
                                'type' => 'select',
                                'options' => array(
                                    0 => __('inactive', true),
                                    1 => __('active', true)
                                ),
                                'empty' => __('Select status...', true),
                                'class' => 'form-control',
                                'id' => 'creator-draft-status',
                                'after' => '<br />',
                                'escape' => false
                            ));
                        ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="alert alert-warning">
                        <?php
                            $options_scale = array();
                            for($i = 4; $i <= 6; $i++) {
                                $options_scale[$i] = $i;
                            }
                            echo $this->Form->input('Draft.scale', array(
                                'label' => __('Scale', true),
                                #'label' => false,
                                'type' => 'select',
                                'empty' => __('Select scale...', true),
                                'options' => $options_scale,
                                'class' => 'form-control',
                                'id' => 'creator-draft-scale',
                                'after' => '<br />',
                                'escape' => false
                            ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Toggle groups', true), '#', array('class' => 'btn btn-primary creator-trigger-group-toggle-all hide-all pull-right', 'escape' => false)); ?>
                </div>
            </div>
                  
            <div class="clearfix">&nbsp;</div>

            <div id="errors-groups_empty" class="alert alert-danger" style="display: none;">
                <ul>
                    <li><?php echo __('You need to add at least one group for a poll-draft!', true); ?></li>
                    <li><?php echo __('You need to add at least one question to each group!', true); ?></li>
                </ul>
            </div>
            <div id="errors-questions_empty" class="alert alert-danger" style="display: none;">
                <ul>
                    <li><?php echo __('You need to add at least one question to each group!', true); ?></li>
                </ul>
            </div>

            <div id="draft-wrapper" class="clearfix">
                <?php if(isset($draft['DraftsGroup']) && !empty($draft['DraftsGroup'])) { ?>
                    <?php foreach($draft['DraftsGroup'] as $group) { ?>
                        <?php echo $this->element('Drafts/Creator/group', array('group' => $group)); ?>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Add group', true), '#', array('class' => 'btn btn-primary creator-trigger-group-add', 'escape' => false)); ?>
                </div>
            </div>

            <hr />

            <?php echo $this->Html->link(__('Save', true), '#', array('id' => 'creator-trigger-save', 'class' => 'btn btn-block btn-success')); ?>

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