<div id="login">
    <div class="clearfix ">
        <div class="col-xs-12 well">
            <h2 class="hide"><?php echo __('Login', true); ?></h2>
            
            <?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login'))); ?>
                <?php
                    echo $this->Form->input('User.email', array(
                        'label' => false,
                        'placeholder' => __('E-Mail', true),
                        'class' => 'form-control input-lg',
                        'div' => array('class' => 'form-group')
                    ));
                    echo $this->Form->input('User.password', array(
                        'label' => false,
                        'placeholder' => __('Password', true),
                        'class' => 'form-control input-lg',
                        'div' => array('class' => 'form-group'),
                        'type' => 'password'
                    ));
                ?>
                <?php echo $this->Form->button(__('Login', true), array('type' => 'submit', 'class' => 'btn btn-lg btn-success btn-block')); ?>
            
            <?php echo $this->Form->end(); ?>
            
            <hr />

            <?php echo $this->element('languages-flat'); ?>

        </div>
    </div>
</div>
