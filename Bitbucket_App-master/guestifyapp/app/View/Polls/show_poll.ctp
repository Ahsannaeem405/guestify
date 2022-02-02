<?php $done = $this->Session->read('Poll.done'); ?>
<?php if($done != 1) { ?>
    <h2 class="text-center"><?php echo __('Guest Feedback', true); ?></h2>
<?php } ?>


<script>
    $(document).ready(function() {

        $('html, body').animate({
            scrollTop: $("div.content-area").offset().top
        }, 100);

        $(document).on('click', '.trigger-vote', function() {

            var trigger = $(this);

            var temp = trigger.attr('id').split('-');

            var question_id = temp[1];
            var answer_id   = temp[2];

            $('#answer_'+question_id).val(answer_id);

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

<style type="text/css">
    a.trigger-vote {
        cursor: pointer!important;
    }
</style>


<div class="content-area">

    <?php if($done != 1) { ?>

        <?php #pr($errors); ?>
        <?php echo $this->Form->create('Poll', array('url' => $this->here)); ?>

            <?php echo $this->Form->input('Guest.poll_id', array('type' => 'hidden', 'value' => $poll['Poll']['id'])); ?>
            <?php echo $this->Form->input('Guest.pin', array('type' => 'hidden', 'value' => $poll['Poll']['code'])); ?>

            <!-- Part 1: db-based questions -->
            <?php foreach($poll['Groups'] as $group) { ?>
                <div id="question-set-<?php echo $group['Group']['id']; ?>" class="row-fluid">
                    <fieldset class="well">
                        <legend><?php echo $group['Group']['order']; ?>. <?php echo $group['Group']['name']; ?></legend>
                        <?php foreach($group['Questions'] as $question) { ?>
                        <!-- Question #1 -->

                        <div id="question-id-<?php echo $question['Question']['id']; ?>" class="question row-fluid">
                            <div class="span12">
                                <label><?php echo $question['Question']['question']; ?></label>
                                <?php
                                    echo $this->Form->input('Poll.answer.'.$question['Question']['id'], array(
                                        'type' => 'hidden',
                                        'id' => 'answer_'.$question['Question']['id']
                                    ));
                                ?>

                                <div class="scale-container row-fluid">
                                    <?php for($i = 0; $i < $question['Question']['scale']; $i++) { ?>
                                        <div class="span3 quarter-layout">
                                            <?php
                                                $class = '';
                                                if(
                                                    isset($this->data['Poll']['answer'][$question['Question']['id']]) &&
                                                    ($this->data['Poll']['answer'][$question['Question']['id']] == $i+1)) {
                                                    $class = 'active';
                                                }

                                            ?>
                                            <a id="vote-<?php echo $question['Question']['id']; ?>-<?php echo $i+1; ?>" class="scale_<?php echo $i+1; ?> scale_unit trigger-vote <?php echo $class; ?>"><?php echo $i+1; ?></a>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>

                        <?php
                            $style = 'display: none;';
                            if(isset($errors) && in_array($question['Question']['id'], $errors)) {
                                $style = '';
                            }
                        ?>

                        <div class="text-error" style="<?php echo $style; ?>">
                            <?php echo __('Please answer this question!', true); ?>
                        </div>
                        <hr />

                        <?php } ?>
                    </fieldset>
                </div>
            <?php } ?>
            <!-- end of Part 2 -->

            <hr />

            <!-- Part 2: guest-depending questions -->
            <div id="question-set-04" class="row-fluid">
                <fieldset class="well">
                    <legend><?php echo __('Restaurant visit', true); ?></legend>
                    <!-- Question #12 >>> goes into guest record -->
                    <div id="question-id-12" class="question row-fluid">
                        <?php
                            echo $this->Form->input('Guest.guest_type', array(
                                'type' => 'select',
                                'label' => false,
                                'div' => false,
                                'empty' => __('Is this your first visit...?', true),
                                'options' => $guest_types,
                                'class' => 'span12'
                            ));
                        ?>
                    </div>
                    <!-- Question #13 >>> goes into guest record -->
                    <div id="question-id-13" class="question row-fluid">
                        <?php
                            echo $this->Form->input('Guest.visit_time', array(
                                'type' => 'select',
                                'label' => false,
                                'div' => false,
                                'empty' => __('Visit time...', true),
                                'options' => $visit_times,
                                'class' => 'span12'
                            ));
                        ?>
                    </div>
                </fieldset>
            </div>
            <!-- end of Part 2 -->

            <div>
                <fieldset>
                    <input type="submit" name="submit" class="btn btn-block btn-success btn-large" value="<?php echo __('Rate', true); ?>" />

                    <!-- replace this with a spinner! -->
                    <!--<span id="submit-spinner">Submit-Spinner</span>-->

                    <input id="trigger-reset" type="reset" name="reset" class="btn btn-small btn-block" value="<?php echo __('Reset', true); ?>" />
                </fieldset>
            </div>
        <?php echo $this->Form->end(); ?>
    <?php } ?>

    <?php if($done == 1) { ?>
        <!-- show this when poll is completed -->
        <div id="complete-wrapper">

            <div class="confirm-message text-center">
                <span class="OK"></span>
                <strong><?php echo __('Thank your very much!', true); ?></strong>
                <p><?php echo __('We appreciate your feedback and we will do our best to be better.', true); ?></p>
            </div>
            <h3 class="text-center"><?php echo __('Public Check in &amp; rating!', true); ?></h3>
            <nav>
                <ul class="buttonlist">
                    <li><a class="button facebook" href="https://www.facebook.com/haxenhaus">Facebook</a></li>
                    <li><a class="button foursquare" href="https://de.foursquare.com/v/haxenhaus-zum-rheingarten/4b05886bf964a5208ec422e3">Foursquare</a></li>
                    <li><a class="button yelp" href="http://www.yelp.de/biz/haxenhaus-zum-rheingarten-k%C3%B6ln">Yelp</a></li>
                    <li><a class="button tripadvisor" href="http://www.tripadvisor.de/Restaurant_Review-g187371-d715369-Reviews-Haxenhaus_zum_Rheingarten-Cologne_North_Rhine_Westphalia.html">TripAdvisor</a></li>
                    <li><a class="button qype" href="http://www.qype.com/place/3425--Haxenhaus-zum-Rheingarten--Koeln">Qype</a></li>
                    <li><a class="button restkritik" href="http://www.restaurant-kritik.de/3628">Restaurant Kritik</a></li>
                </ul>

            </nav>

            <h3 class="text-center"><?php echo __('Follow us!', true); ?></h3>
            <nav>

                <ul class="buttonlist">
                    <li><a class="button facebook" href="https://www.facebook.com/haxenhaus"><?php echo __('Like us on Facebook', true); ?></a></li>
                    <li><a class="button twitter" href="https://twitter.com/haxenhaus">Twitter</a></li>
                </ul>

            </nav>
        </div>
    <?php } ?>
    <!-- end of complete wrapper -->

</div>



