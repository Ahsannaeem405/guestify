<?php # ?>
<div class="content-area ">
    <h2 class="text-center">Haxenhaus <?php echo __('Guest Feedback', true); ?></h2>
    <div class="row-fluid">
        <div class="span1"></div>
        <div class="span10">
            <script>
                $(document).on('click', 'a.open-language-selection', function() {
                    $(".lang-selector" ).slideToggle( "fast", function() {
                        return false;
                    });
                });
            </script>
            <div class="language-box">
                <div class="lang-selected">

                    <a class="open-language-selection">
                        <i class="icon icon-chevron-down margin5px pull-right"></i>
                        <?php
                            $locale = $this->Session->read('Config.language');
                            if(empty($locale)) {
                                $locale = Configure::read('Language.default');
                            }
                            if($locale == 'deu') {
                                echo $this->Html->tag('span', __('Deutsch', true), array('class' => 'flag deu'));
                            } elseif($locale == 'eng') {
                                echo $this->Html->tag('span', __('English', true), array('class' => 'flag eng'));
                            }
                        ?>
                    </a>

                </div>
                <div class="lang-selector">
                    <?php echo $this->Html->link(__('Deutsch', true), array('controller' => 'polls', 'action' => 'changeLanguage', 'deu'), array('class' => 'flag deu')); ?>
                    <?php echo $this->Html->link(__('English', true), array('controller' => 'polls', 'action' => 'changeLanguage', 'eng'), array('class' => 'flag eng')); ?>
                </div>
            </div>

            <div class="text-center">
                <?php
                    echo $this->Form->create('Poll', array('url' => $this->here));
                    echo $this->Form->input('Poll.hash', array(
                        'type' => 'hidden',
                        'value' => $hash
                    ));
                    echo $this->Form->input('Poll.code', array(
                        'label' => false,
                        'class' => 'span12',
                        'placeholder' => __('Please enter PIN', true),
                        #'class' => 'span6'
                    ));
                    echo $this->Form->submit(__('Start Feedback', true), array('class' => 'btn btn-success btn-block btn-large'));
                    echo $this->Form->end();
                ?>
            </div>

        </div>

        <div class="span1"></div>

    </div>
</div>
