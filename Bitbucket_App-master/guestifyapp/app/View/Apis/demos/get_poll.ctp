<?php
    $this->set('title_for_layout', __('API demo').' - '.'getPoll');
    $this->layout = '/Api/api_demo_get_poll';
?>

<?php
	$poll      = $result['data']['Poll'];
	$host      = $result['data']['Host'];
	$groups    = $result['data']['Groups'];
?>


<style type="text/css">
    body, legend {
        color: #<?php echo $poll['color']; ?>;
    }

    /* smileys -> scale */
    .scale_1 { background-image: url(/graphics/smiley-set1/scale_1.png) ;}
    .scale_2 { background-image: url(/graphics/smiley-set1/scale_2.png) ;}
    .scale_3 { background-image: url(/graphics/smiley-set1/scale_3.png) ;}
    .scale_4 { background-image: url(/graphics/smiley-set1/scale_4.png) ;}
    .scale_5 { background-image: url(/graphics/smiley-set1/scale_5.png) ;}
    .scale_6 { background-image: url(/graphics/smiley-set1/scale_6.png) ;}

    /* change cursor when hovering vote-triggers */
    a.trigger-vote {
        cursor: pointer!important;
    }

    .trigger-vote.active { background-color: #47CC4A; border-radius: 10px; }

    .scale-container  { margin-top: 10px; }
    .scale_unit { background-size: 48px; background-position: 50% 50%; background-repeat: no-repeat; display: block; height: 48px; margin: 0 auto; width: 48px; padding: 5px; text-indent: -9999px; overflow: hidden;}

    fieldset legend { margin: 0; line-height: 100%; border: 0 none; text-transform: uppercase; font-size: 16px; font-weight: 700; }

    fieldset label { font-size: 16px; }
</style>


<div class="container">
    <div class="clearfix">&nbsp;</div>

    <h2><?php echo __('API Demo'); ?> - getPoll()</h2>

    <div class="clearfix">&nbsp;</div>

    <div class="well">
        <?php echo __('Access request URL'); ?> <br />
        <pre><?php echo $url_access_request; ?></pre>
        
        <?php echo __('Sample call URL'); ?> <br />
    	<pre><?php echo $url_api_call; ?></pre>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <h3><?php echo $poll['name']; ?></h3>

            <?php
                if(!empty($host['logo'])) {
                    echo $this->Html->image($host['logo'], array('alt' => $host['name'], 'width' => '300px'));
                }
            ?>

            <?php echo $this->Form->create('Api', array('url' => $this->here)); ?>

                <?php
                    echo $this->Form->input('Poll.id', array(
                        'type' => 'hidden',
                        'value' => $poll['id'],
                        'id' => 'poll_id'
                    ));
                ?>

                <?php foreach($groups as $group) { ?>
                    <div class="clearfix">
                        <fieldset class="well">
                        	<legend><?php echo $group['Group']['order']; ?>. <?php echo $group['Group']['name']; ?></legend>
                            <?php foreach($group['Questions'] as $question) { ?>
        	                    <div class="clearfix">
    	                            <label><?php echo $question['Question']['question']; ?></label>
                                    <?php
                                        echo $this->Form->input('Answers.'.$question['Question']['id'], array(
                                            'type' => 'hidden',
                                            'id' => 'question_'.$question['Question']['id']
                                        ));
                                    ?>
                                    <div class="scale-container">
                                        <?php for($i = 0; $i < $question['Question']['scale']; $i++) { ?>
                                            <div class="span3 col-lg-3">
                                                <a id="vote-<?php echo $question['Question']['id']; ?>-<?php echo $i+1; ?>" class="scale_<?php echo $i+1; ?> scale_unit trigger-vote"><?php echo $i+1; ?></a>
                                            </div>
                                        <?php } ?>
                                    </div>
        	                    </div>
                            <?php } ?>
                        </fieldset>
                    </div>
                <?php } ?>

                <hr />

                <div class="row-fluid">
                    <fieldset class="well">
                        <legend><?php echo __('Restaurant visit', true); ?></legend>
                        <?php
                            $guest_types = array(
                                1 => __('This is my first visit', true),
                                2 => __('I am rarely here', true),
                                3 => __('I am occasionally here', true),
                                4 => __('I am a regular guest', true)
                            );

                            echo $this->Form->input('Guest.guest_type', array(
                                'type' => 'select',
                                'label' => false,
                                'div' => array(
                                    'class' => 'form-group'
                                ),
                                'empty' => __('Is this your first visit...?', true),
                                'options' => $guest_types,
                                'class' => 'form-control',
                            ));
                        ?>

                        <hr />

                        <?php
                            $visit_times = array(
                                1 => __('Evening', true),
                                2 => __('Midday', true),
                                3 => __('Morning', true)
                            );
                            echo $this->Form->input('Guest.visit_time', array(
                                'type' => 'select',
                                'label' => false,
                                'div' => array(
                                    'class' => 'form-group'
                                ),
                                'empty' => __('Visit time...', true),
                                'options' => $visit_times,
                                'class' => 'form-control'
                            ));
                        ?>
                    </fieldset>
                </div>

                <div id="customer-comment" class="row-fluid">
                    <fieldset class="well">
                        <legend><?php echo __('Comment', true); ?> (<?php echo __('optional', true); ?>)</legend>
                        <?php
                            echo $this->Form->input('Guest.comment_customer', array(
                                'type' => 'textarea',
                                'div' => array(
                                    'class' => 'form-group'
                                ),
                                'class' => 'form-control'
                            ));
                        ?>
                    </fieldset>
                </div>

                <div id="customer-comment" class="row-fluid">
                    <fieldset class="well">
                        <legend><?php echo __('Contact', true); ?> (<?php echo __('optional', true); ?>)</legend>
                        <?php
                            echo $this->Form->input('Guest.name', array(
                                'type' => 'text',
                                'placeholder' => __('Your name', true),
                                'label' => false,
                                'div' => array(
                                    'class' => 'form-group'
                                ),
                                'class' => 'form-control'
                            ));
                            echo $this->Form->input('Guest.email', array(
                                'type' => 'text',
                                'placeholder' => __('Your email', true),
                                'label' => false,
                                'div' => array(
                                    'class' => 'form-group'
                                ),
                                'class' => 'form-control'
                            ));
                        ?>
                    </fieldset>
                </div>

                <div>
                    <fieldset>
                        <input type="submit" name="submit" class="btn btn-block btn-success btn-large" value="<?php echo __('Send rating', true); ?>" />
                        <input id="trigger-reset" type="reset" name="reset" class="btn btn-small btn-block" value="<?php echo __('Reset', true); ?>" />
                    </fieldset>
                </div>
            <?php echo $this->Form->end(); ?>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $(document).on('click', '.trigger-vote', function() {

            var trigger = $(this);

            var temp = trigger.attr('id').split('-');

            var question_id = temp[1];
            var voted_scale = temp[2];

            $('#question_'+question_id).val(voted_scale);

            var container = $(this).closest('div.scale-container');

            container.find('.trigger-vote').removeClass('active');

            if(trigger.hasClass('active')) {
                trigger.removeClass('active');
            } else {
                trigger.addClass('active');
            }

            return false;
        });


        $(document).on('click', '#trigger-reset', function() {
            $('.trigger-vote').removeClass('active');
            $('html,body').animate({scrollTop: 0});
            return false;
        });

    });
</script>