<?php
    $this->set('title_for_layout', __('Polls', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('My Polls', true), array('action' => 'index'));
    $this->Html->addCrumb($poll['Poll']['title'], array('action' => 'showLast30', $poll['Poll']['id']));
    $this->Html->addCrumb(__('Add feedback', true));

    echo $this->Html->css('../js/vendors/datepicker/datepicker');
    echo $this->Html->script('vendors/datepicker/bootstrap-datepicker', false);
    $locale = $this->Session->read('Config.language');
    if(substr($locale, 0, 2) == 'de') {
        echo $this->Html->script('vendors/datepicker/locales/bootstrap-datepicker.de', false);
    }
?>

<span id="max-scale" style="display: none;"><?php echo $max_scale; ?></span>

<?php if($locale == 'deu') { ?>
    <span id="datepicker-format" style="display: none;">dd.mm.yyyy</span>
    <span id="datepicker-language" style="display: none;">de</span>
<?php } else { ?>
    <span id="datepicker-format" style="display: none;">yyyy-mm-dd</span>
    <span id="datepicker-language" style="display: none;">en</span>
<?php } ?>

<script type="text/javascript">

    $(document).ready(function() {

        $('#date').datepicker({
            language: $('#datepicker-language').text(),
            format: $('#datepicker-format').text(),
            weekStart: 1,
            endDate: '-0d',
        });
        $('#date').datepicker().on('changeDate', function(ev){
            $('#date').datepicker('hide');
        });

        var max_scale = parseInt($('#max-scale').text());

        $('.input-answer-scale').on('input', function() {

            var value = parseInt($(this).val());

            if((value != '') && (!isNaN(value))) {
                if((value > 0) && (value <= max_scale)) {
                    return;
                } else {
                    event.preventDefault();
                    $(this).val('');
                    return false;
                }
            } else {
                event.preventDefault();
                $(this).val('');
                return false;
            }

        });

    });


</script>

<div class="clearfix">

    <h2><?php echo $poll['Poll']['title']; ?></h2>

    <div class="clearfix">
        <?php echo $this->Form->create('Poll', array('url' => $this->here)); ?>
            <?php
                echo $this->Form->input('Poll.poll_id', array(
                    'type' => 'hidden',
                    'value' => $poll['Poll']['id']
                ));
            ?>

            <div class="well">
                <h3><?php echo __('Add a manual feedback', true); ?></h3>
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <?php
                                echo $this->Form->input('Poll.date', array(
                                    'label' => false,
                                    #'placeholder' => 
                                    'placeholder' => $formats['date_placeholder'],
                                    'type' => 'text',
                                    'id' => 'date',
                                    'class' => 'form-control input-lg ',
                                    'div' => array('class' => 'input-group'),
                                    'between' => $this->Html->tag('div', '<span class="glyphicon glyphicon-calendar"></span>', array('class' => 'input-group-addon')),
                                    'escape' => false
                                ));
                            ?>
                        </div>
                        <div class="clearfix">
                            <span class="glyphicon glyphicon-info-sign"> <small><?php echo __('Insert the date for all following ratings', true); ?></small></span>
                        </div>

                        <?php if(isset($errors['date'])) { ?>
                            <div class="clearfix">
                                <p class="text-danger">
                                    <?php echo $errors['date']; ?>
                                </p>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="col-md-6">
                        <strong><?php echo __('Information', true); ?></strong>
                        <p><?php echo __('It is possible that you enter ratings manually. If you are using hand written feedback surveys with the identical score rating, just enter the scores into the correct fields.', true); ?></p>
                        <p><?php echo __('Scale', true); ?>: 1 - <?php echo $max_scale; ?></p>

                    </div>
                </div>
            </div>

            <div class="clearfix">
                <?php # make the set number dynamic! ?>
                <?php for($set_number = 1; $set_number < 11; $set_number++) { ?>
                    <?php
                        $class = '';
                        if(isset($errors[$set_number]) && !empty($errors[$set_number])) {
                            $class = ' alert alert-danger';
                        }
                    ?>
                    <fieldset class="well <?php echo $class; ?>">
                        <h3><?php echo __('Guest rating', true); ?> #<?php echo $set_number; ?></h3>
                        <div class="clearfix">

                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="clearfix">
                                        <?php
                                            $labels = array(
                                                1 => 'primary',
                                                2 => 'info',
                                                3 => 'warning',
                                                4 => 'danger'
                                            );
                                            $count = 0;
                                        ?>
                                        <div class="clearfix">
                                            <?php foreach($poll['Groups'] as $key_groups => $group) { ?>
                                                <?php $count++; ?>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <small class="label label-<?php echo $labels[$count]; ?>" style="display: block;"><?php echo $group['Group']['name']; ?></small>
                                                        <div class="row">
                                                        <?php foreach($poll['Groups'][$key_groups]['Questions'] as $key_questions => $question) { ?>
                                                            <?php
                                                                echo $this->Form->input('Poll.answers.'.$set_number.'.answer.'.$question['Question']['id'], array(
                                                                    'label' => 'Q'.$question['Question']['order'],
                                                                    'type' => 'text',
                                                                    #'size' => 1,
                                                                    'maxlength' => 1,
                                                                    'div' => array('class' => 'form-group col-xs-2', 'title' => __('Question', true).' '.$question['Question']['order']),
                                                                    'class' => 'form-control input-answer-scale',
                                                                ));
                                                            ?>
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php /*
                                        <div class="row">
                                        <?php foreach($poll['Groups'] as $key_groups => $group) { ?>
                                            <?php foreach($group['Questions'] as $key_questions => $question) { ?>
                                                <?php
                                                    echo $this->Form->input('Poll.answers.'.$set_number.'.answer.'.$question['Question']['id'], array(
                                                        'label' => 'Q'.$question['Question']['order'],
                                                        'type' => 'text',
                                                        #'size' => 1,
                                                        'maxlength' => 1,
                                                        'div' => array('class' => 'form-group col-xs-2', 'title' => __('Question', true).' '.$question['Question']['order']),
                                                        'class' => 'form-control input-answer-scale',

                                                    ));
                                                ?>
                                            <?php } ?>
                                        <?php } ?>
                                        </div>
                                        */ ?>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <?php
                                        echo $this->Form->input('Guest.'.$set_number.'.guest_type', array(
                                            'type' => 'select',
                                            'label' => __('Visit type', true),
                                            'div' => array('class' => 'form-group'),
                                            'empty' => __('Select visit cycle...', true),
                                            'options' => $guest_types,
                                            'class' => 'form-control',
                                        ));
                                    ?>
                                    <?php
                                        echo $this->Form->input('Guest.'.$set_number.'.visit_time', array(
                                            'type' => 'select',
                                            'label' => __('Visit time', true),
                                            'div' => array('class' => 'form-group'),
                                            'empty' => __('Select visit time...', true),
                                            'options' => $visit_times,
                                            'class' => 'form-control'
                                        ));
                                    ?>
                                    <?php
                                        echo $this->Form->input('Guest.'.$set_number.'.comment', array(
                                            'label' => __('Guest comment', true),
                                            'type' => 'textarea',
                                            'rows' => 3,
                                            'div' => array('class' => 'form-group'),
                                            'class' => 'form-control'
                                        ));
                                    ?>
                                </div>
                            </div>

                            <?php if(isset($errors[$set_number]) && !empty($errors[$set_number])) { ?>
                                <div class="clearfix">&nbsp;</div>
                                <div class="alert alert-danger" style="margin-bottom: 0;">
                                    <p class="text-danger">
                                        <?php echo $errors[$set_number]; ?>
                                    </p>
                                </div>
                            <?php } ?>
                        </div>


                    </fieldset>

                <?php } ?>
            </div>
            <?php echo $this->Form->submit(__('Save feedback', true), array('class' => 'btn btn-success btn-block')); ?>

        <?php echo $this->Form->end(); ?>
    </div>
</div>

