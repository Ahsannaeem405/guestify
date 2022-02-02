<?php
    $this->set('title_for_layout', __('Poll', true).' - '.$poll['Poll']['title']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('Polls', true), array('controller' => 'polls', 'action' => 'adminIndex'), array('escape' => false));
    $this->Html->addCrumb($poll['Poll']['title'], array('controller' => 'polls', 'action' => 'adminView', $poll['Poll']['id']), array('escape' => false));
    $this->Html->addCrumb(__('Edit by admin', true));

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
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                            echo $this->Form->input('Poll.code', array(
                                'label' => __('PIN code', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                            echo $this->Form->input('Poll.alt_url', array(
                                'label' => __('Alternative URL to poll', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                            echo $this->Form->input('Poll.text', array(
                                'label' => __('Individual text for your poll-cards', true),
                                'type' => 'textarea',
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
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
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

                    <fieldset>
                        <legend><?php echo __('Limit options', true); ?></legend>
                        <?php
                            echo $this->Form->input('Poll.limit', array(
                                'label' => __('Limit', true),
                                'type' => 'text',
                                'class' => 'form-control',
                                'div' => array('class' => 'form-group'),
                                'escape' => false
                            ));
                        ?>
                    </fieldset>

                    <div class="clearfix">&nbsp;</div>
                    <?php echo $this->Form->submit(__('Save changes', true), array('class' => 'btn btn-success')); ?>

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

        $("#color-picker").spectrum({
            preferredFormat: "hex",
            //showPaletteOnly: true,
            showPalette: true,
            hideAfterPaletteSelect: true,
            color: 'black',
            palette: [
                ['black', 'grey', 'yellow', 'lightblue'],
                ['red', 'green', 'blue', 'violet'],
                ['rgb(255, 128, 0);', 'hsv 100 70 50', 'lightyellow']
            ],
        });

        $("#color-picker").spectrum("set", '#'+col);
    });

</script>