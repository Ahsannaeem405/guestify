<?php
    $this->set('title_for_layout', __('Poll', true).' - '.$poll['Poll']['title']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My polls', true), array('controller' => 'polls', 'action' => 'index'), array('escape' => false));
    $this->Html->addCrumb($poll['Poll']['title']);

    $locale = $this->Session->read('Config.language');

    echo $this->Html->script('vendors/spectrum/spectrum', false);
    echo $this->Html->script('vendors/spectrum/i18n/jquery.spectrum-'.substr($locale, 0, 2), false);
    echo $this->Html->css('../js/vendors/spectrum/spectrum');
?>


<h2><?php echo __('Edit poll', true); ?></h2>


<div class="row">
    <div class="col-xs-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo $this->Form->create('Poll', array('url' => $this->here)); ?>

                    <?php echo $this->Form->input('Poll.id'); ?>
                    <fieldset>
                        <legend><?php echo __('General information', true); ?></legend>
                        <?php
                            echo $this->Form->input('Poll.title', array(
                                'label' => __('Title', true),
                                'type' => 'text',
                                'id' => 'polls-title',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                            echo $this->Form->input('Poll.code', array(
                                'label' => __('PIN code', true),
                                'type' => 'text',
                                'id' => 'polls-code',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                        ?>
                        <?php
                            $disabled = true;
                            if($poll['Poll']['ratings_received'] == 0) {
                                $disabled = false;
                            }

                            echo $this->Form->input('Poll.scale', array(
                                'label' => __('Scale', true),
                                'type' => 'select',
                                'options' => $options_scales,
                                'selected' => $max_scale,
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false,
                                'disabled' => $disabled
                            ));
                        ?>
                        <?php if($poll['Poll']['ratings_received'] > 1) {  ?>
                            <div class="text-danger"><p><small><span class="glyphicon glyphicon-warning-sign"></span> <?php echo __('The scale cannot be changed anymore because this poll has feedback answers.', true); ?></small></p></div>
                        <?php } ?>
                        <?php
                            echo $this->Form->input('Poll.alt_url', array(
                                'label' => __('Alternative URL to poll', true),
                                'type' => 'text',
                                'id' => 'polls-alt_url',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                            echo $this->Form->input('Poll.notify_on_answer', array(
                                'label' => __('Email-Notification on new answers', true),
                                'type' => 'checkbox',
                                'id' => 'polls-notify_on_answer',
                                'class' => '',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                            echo $this->Form->input('Poll.text', array(
                                'label' => __('Individual text for your poll-cards', true),
                                'type' => 'textarea',
                                'id' => 'polls-text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                        ?>
                    </fieldset>


                    <fieldset>
                        <legend><?php echo __('Appearance options', true); ?></legend>
                        <?php
                            echo $this->Form->input('Poll.theme_id', array(
                                'label' => __('Theme', true),
                                'type' => 'select',
                                'options' => $options_themes,
                                'id' => 'polls-theme_id',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                        ?>
                        <div class="row">
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set1/scale_4.png" width="40px" /><br /><?php echo __('Standard'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set2/scale_4.png" width="40px" /><br /><?php echo __('Black'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set3/scale_4.png" width="40px" /><br /><?php echo __('Stars Yellow'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set4/scale_4.png" width="40px" /><br /><?php echo __('Stars Blue'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set5/scale_4.png" width="40px" /><br /><?php echo __('Stars Grey'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set6/scale_4.svg" width="40px" /><br /><?php echo __('Stars Black'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set7/scale_4.svg" width="40px" /><br /><?php echo __('Blue Ribbon'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set8/scale_4.svg" width="40px" /><br /><?php echo __('Grey Ribbon'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set9/scale_4.png" width="40px" /><br /><?php echo __('Green Lime'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set10/scale_4.png" width="40px" /><br /><?php echo __('Ice Creams'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set11/scale_4.png" width="40px" /><br /><?php echo __('Cakes'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set12/scale_4.png" width="40px" /><br /><?php echo __('Muffins'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/smiley-set13/scale_4.png" width="40px" /><br /><?php echo __('Cookies'); ?></p></div>
                            <div class="col-xs-3"><p class="text-center"><img src="/graphics/simley-set14/scale_4.png" width="40px" /><br /><?php echo __('Blue Smiley'); ?></p></div>
                        </div>
                        <p>&nbsp;</p>

                        <?php
                            echo $this->Form->label(__('Main color', true));
                            echo $this->Form->input('Poll.color', array(
                                'label' => false,
                                #'type' => 'text',
                                'class' => 'form-control',
                                'id' => 'color-picker',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                        ?>
                    </fieldset>

                    <div class="clearfix">&nbsp;</div>
                    <?php echo $this->Form->submit(__('Save changes', true), array('class' => 'btn btn-success pull-left')); ?>&nbsp;
                    <?php $referer = $this->request->referer(); ?>
                    <?php echo $this->Html->link(__('Cancel', true), $referer, array('class' => 'btn btn-default')); ?>

                <?php echo $this->Form->end(); ?>
            </div>

        </div>
    </div>


    <div class="col-xs-5">
        <?php echo $this->element('help'); ?>
    </div>

</div>



<?php #echo $this->element('Widgets/standard_activate/main'); ?>
<?php #echo $this->element('Widgets/standard_deactivate/main'); ?>
<?php #echo $this->element('Widgets/standard_delete/main'); ?>

<script>
    $(document).ready(function() {

        var col = "<?php echo $poll['Poll']['color']; ?>";

        $('#polls-title').focusin(function() {
            $('#container-help-polls-title').addClass('alert alert-info');
        });
        $('#polls-title').focusout(function() {
            $('#container-help-polls-title').removeClass('alert alert-info');
        });

        $('#polls-code').focusin(function() {
            $('#container-help-polls-code').addClass('alert alert-info');
        });
        $('#polls-code').focusout(function() {
            $('#container-help-polls-code').removeClass('alert alert-info');
        });

        $('#polls-alt_url').focusin(function() {
            $('#container-help-polls-alt_url').addClass('alert alert-info');
        });
        $('#polls-alt_url').focusout(function() {
            $('#container-help-polls-alt_url').removeClass('alert alert-info');
        });

        $('#polls-text').focusin(function() {
            $('#container-help-polls-text').addClass('alert alert-info');
        });
        $('#polls-text').focusout(function() {
            $('#container-help-polls-text').removeClass('alert alert-info');
        });

        $('#polls-theme_id').focusin(function() {
            $('#container-help-polls-theme_id').addClass('alert alert-info');
        });
        $('#polls-theme_id').focusout(function() {
            $('#container-help-polls-theme_id').removeClass('alert alert-info');
        });

        $('#color-picker').focusin(function() {
            $('#container-help-color-picker').addClass('alert alert-info');
        });
        $('#color-picker').focusout(function() {
            $('#container-help-color-picker').removeClass('alert alert-info');
        });

        $(document).on('click', 'body', function() {
            console.log('click!'); 
            if($('.sp-replacer').hasClass('sp-active')) {
                $('#container-help-color-picker').addClass('alert alert-info');
            } else {
                $('#container-help-color-picker').removeClass('alert alert-info');
            }
        });

        $("#color-picker").spectrum({
            preferredFormat: "hex",
            //showPaletteOnly: true,
            showPalette: true,
            hideAfterPaletteSelect: true,
            color: 'black',
            show: function() {
                $('#container-help-color-picker').addClass('alert alert-info');
            },
            hide: function() {
                $('#container-help-color-picker').removeClass('alert alert-info');
            },
            palette: [
                ['black', 'grey', 'yellow', 'lightblue'],
                ['red', 'green', 'blue', 'violet'],
                ['rgb(255, 128, 0);', 'hsv 100 70 50', 'lightyellow']
            ],
        });

        $("#color-picker").spectrum("set", '#'+col);
    });

</script>
