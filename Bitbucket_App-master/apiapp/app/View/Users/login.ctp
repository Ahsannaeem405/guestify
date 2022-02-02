<?php $this->set('title_for_layout', __('Login', true)); ?>


<div class="clearfix">
    <div class="col-xs-4"></div>

    <div class="col-xs-4">
        <h1 class="text-center"><a href="/login"><img src="/images/logo.png" width="50%" /></a></h1>
        <?php echo $this->element('Users/login');?>
    </div>

</div>
