<?php if($this->Session->check('Auth.User.id')) { ?>
    <hr />
    <div class="row">
        <div class="col-xs-3">
            <?php echo $this->Html->link(__('Dashboard', true), '/dashboard', array('class' => 'btn btn-link')); ?><br />
            <?php echo $this->Html->link(__('Terms and conditions', true), '/terms', array('class' => 'btn btn-link')); ?><br />
            <?php echo $this->Html->link(__('Privacy policy', true), '/privacy', array('class' => 'btn btn-link')); ?><br />
            <?php echo $this->Html->link(__('Imprint', true), '/imprint', array('class' => 'btn btn-link')); ?>
        </div>

        <div class="col-xs-3">
            <?php if($this->Permission->isClient()) { ?>
                <?php echo $this->Html->link(__('First steps', true), '/first-steps', array('class' => 'btn btn-link')); ?><br />
                <?php echo $this->Html->link(__('My Polls', true), array('controller' => 'polls', 'action' => 'index'), array('class' => 'btn btn-link', 'escape' => false)); ?><br />
            <?php } ?>
        </div>

        <div class="col-xs-6">
            <div class="pull-right">
                <a href="https://www.facebook.com/guestifyapp" target="_blank" title="<?php echo __('Follow us on Facebook', true); ?>"><img src="/graphics/own-social/48-facebook.png" /></a>&nbsp;
                <a href="https://twitter.com/guestifyapp" target="_blank" title="<?php echo __('Follow us on twitter', true); ?>"><img src="/graphics/own-social/48-twitter.png" /></a>
            </div>
        </div>
    </div>
    <div class="text-center"><small>&copy; <?php echo date('Y'); ?> guestify.net - <?php echo __('All rights reserved', true); ?></small></div>
<?php } ?>
