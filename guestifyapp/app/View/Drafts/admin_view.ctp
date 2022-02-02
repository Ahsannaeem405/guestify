<?php
    $this->set('title_for_layout', $draft['Draft']['name_eng']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('System', true), array('controller' => 'pages', 'action' => 'display', 'system'));
    $this->Html->addCrumb(__('Drafts', true), array('controller' => 'drafts', 'action' => 'admin_index'));
    $this->Html->addCrumb($draft['Draft']['name_eng']);

    #echo $this->Html->script('View/Accounts/admin_view', false);
?>

<?php 
    $locale = $this->Session->read('Drafts.locale');
?>

<?php 
    $theme_id = $this->Session->read('Drafts.theme_id');
    echo $this->Html->css('theme_'.$theme_id);
?>

<?php
    $draft_color = $this->Session->read('Drafts.color'); 
    $draft_color = str_replace('#', '', $draft_color);
?>
<style type="text/css">
    .draft-preview, .draft-preview legend {
        color: #<?php echo $draft_color; ?>;
    }
</style>

<div class="btn-toolbar pull-right">
    
    <?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span> '.__('Delete', true), array('action' => 'admin_delete', $draft['Draft']['id']), array('class' => 'btn btn-danger standard-delete', 'escape' => false)); ?>

    <!-- Single button -->
    <div class="btn-group">
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo __('Edit', true); ?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-right">
            <li>
                <?php echo $this->Html->link('<img src="/img/flags/en.png" alt=""> ' . __('English', true), array('action' => 'admin_edit', $draft['Draft']['id'], 'eng'), array('escape' => false)); ?>
            </li>
            <li>
                <?php echo $this->Html->link('<img src="/img/flags/de.png" alt=""> ' . __('German', true), array('action' => 'admin_edit', $draft['Draft']['id'], 'deu'), array('escape' => false)); ?>
            </li>
        </ul>
    </div>

</div>


<h2><?php echo __('Draft', true); ?> - <?php echo $draft['Draft']['name_'.$locale]; ?></h2>

<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="clearfix">
                    <h3 class="pull-left"><?php echo __('Draft preview', true); ?></h3>
                    <a id="trigger-reset" class="btn btn-sm pull-right"><?php echo __('Reset selection(s)', true); ?></a>
                </div>

                <?php
                    $col_class = 'span3 quarter-layout ';
                    if($max_scale == 4) {
                        $col_class = 'span3 quarter-layout ';
                    } else if($max_scale == 5 ) {
                        $col_class = 'span2 fifth-layout ';
                    } else if($max_scale == 6 ) {
                        $col_class = 'span2 sixth-layout ';
                    }
                ?>

                <?php $group_count = count($draft['DraftsGroup']); ?>

                <div class="draft-preview clearfix">
                    <?php foreach($draft['DraftsGroup'] as $group) { ?>
                        <div id="question-set-<?php echo $group['id']; ?>" class="row-fluid clearfix">
                            <fieldset class="well">
                                <?php if($group_count > 1) { ?>
                                    <legend><?php echo $group['position']; ?>. <?php echo $group['name_'.$locale]; ?></legend>
                                <?php } ?>

                                <?php foreach($group['DraftsGroupsQuestion'] as $question) { ?>
                                    <div id="question-id-<?php echo $question['id']; ?>" class="question row-fluid clearfix">
                                        <div class="span12">
                                            <label><?php echo $question['question_'.$locale]; ?></label>
                                            <div class="scale-container row-fluid">
                                                <?php for($i = 0; $i < $question['scale']; $i++) { ?>
                                                    <div class="<?php echo $col_class; ?>">
                                                        <a id="vote-<?php echo $question['id']; ?>-<?php echo $i+1; ?>" class="scale_<?php echo $i+1; ?> scale_unit trigger-vote"><?php echo $i+1; ?></a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <br />
                                <?php } ?>
                            </fieldset>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-5">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php 
                    $labels_status = array(
                        0 => 'warning',
                        1 => 'success',
                        2 => 'default'
                    );
                ?>
                <div class="text-center">
                    <h2><span class="label label-<?php echo $labels_status[$draft['Draft']['status']]; ?>"><?php echo $statuses[$draft['Draft']['status']]; ?></span></h2>
                </div>
                
                <div class="clearfix">&nbsp;</div>

                <dl class="dl-horizontal">
                    <dt><?php echo __('Created', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $draft['Draft']['created']); ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Modified', true); ?></dt>
                    <dd>
                        <?php echo $this->Time->format($formats['datetime'], $draft['Draft']['modified']); ?>
                        &nbsp;
                    </dd>
                </dl>

                <hr />

                <h3><?php echo __('Settings', true); ?></h3>
                
                <?php echo $this->Form->create('Draft', array('url' => $this->here)); ?>
                    <?php
                        echo $this->Form->input('Draft.locale', array(
                            'label' => __('Locale', true),
                            'class' => 'form-control',
                            'type' => 'select',
                            'options' => array(
                                'deu' => __('German', true),
                                'eng' => __('English', true)
                            ),
                            'value' => $this->Session->read('Drafts.locale')
                        ));
                        echo $this->Form->input('Draft.theme_id', array(
                            'label' => __('Theme', true),
                            'class' => 'form-control',
                            'type' => 'select',
                            'empty' => __('Select theme', true),
                            'options' => $options_themes,
                            'value' => $this->Session->read('Drafts.theme_id')
                        ));
                        echo $this->Form->input('Draft.color', array(
                            'label' => __('Color', true),
                            'class' => 'form-control',
                            'type' => 'text',
                            'value' => $this->Session->read('Drafts.color')
                        ));
                    ?>
                    <hr />

                    <?php echo $this->Form->submit(__('Apply', true), array('class' => 'btn btn-success')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // $('html, body').animate({
        //     scrollTop: $("div.content-area").offset().top
        // }, 100);

        $(document).on('click', '.trigger-vote', function() {

            var trigger = $(this);

            var temp = trigger.attr('id').split('-');

            var question_id = temp[1];
            var answer_id   = temp[2];

            $('#answer_'+question_id).val(answer_id);

            var container = $(this).closest('div.scale-container');

            container.find('.trigger-vote').removeClass('active');

            // if(trigger.hasClass('active')) {
            //     trigger.removeClass('active');
            // } else {
                trigger.addClass('active');
            // }

            return false;
        });

        $(document).on('click', '#trigger-reset', function() {
            $('.trigger-vote').removeClass('active');
            $('div.draft-preview').animate({scrollTop: 0});
            return false;
        });

    });
</script>

<style type="text/css">
    a.trigger-vote { cursor: pointer!important; }
    .scale-container  { margin-top: 10px; }
    .scale_unit { background-size: 48px; background-position: 50% 50%; background-repeat: no-repeat; display: block; height: 48px; margin: 0 auto; width: 48px; padding: 5px; text-indent: -9999px; overflow: hidden;}

    .quarter-layout, .span3.quarter-layout { width: 22.904255319148934%!important; float: left!important; }
    .fifth-layout, .span2.fifth-layout { width: 19%!important; float: left!important; margin-left: 0!important; }
    .sixth-layout, .span2.sixth-layout { width: 16.66666666666667%!important; float: left!important; margin-left: 0!important; }

    .trigger-vote.active { background-color: #47CC4A; border-radius: 10px; }
</style>

<?php echo $this->element('Widgets/standard_delete/main'); ?>