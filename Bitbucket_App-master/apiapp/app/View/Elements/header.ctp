<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <?php if($this->Session->check('Auth.User.id')) { ?>
                <?php if($this->Permission->isClient()) { ?>
                    <a class="navbar-brand" href="/dashboard"><img src="/graphics/happy.png" width="24px" /> <span class="text-primary">guestify</span></a>
                <?php } elseif($this->Permission->isAdmin()) { ?>
                    <a class="navbar-brand" href="/admin_dashboard"><img src="/graphics/happy.png" width="24px" /> <span class="text-primary">guestify</span></a>
                <?php } ?>
            <?php } else { ?>
                <a class="navbar-brand" href="/">guestify</a>
            <?php } ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse">
            <?php /*
            <ul class="nav navbar-nav">
                <?php if($this->Session->check('Auth.User.id')) { ?>

                    <?php if($this->Permission->isAdmin()) { ?>
                        <li class=""><?php echo $this->Html->link(__('Accounts', true), array('controller' => 'accounts', 'action' => 'adminIndex'), array('class' => '')); ?></li>
                        <li class=""><?php echo $this->Html->link(__('Users', true), array('controller' => 'users', 'action' => 'adminIndex'), array('class' => '')); ?></li>
                        <li class=""><?php echo $this->Html->link(__('Hosts', true), array('controller' => 'hosts', 'action' => 'adminIndex'), array('class' => '')); ?></li>
                        <li class=""><?php echo $this->Html->link(__('Polls', true), array('controller' => 'polls', 'action' => 'adminIndex'), array('class' => '')); ?></li>
                        <li class=""><?php echo $this->Html->link(__('Invoices', true), array('controller' => 'invoices', 'action' => 'adminIndex'), array('class' => '')); ?></li>
                        <li class=""><?php echo $this->Html->link(__('Targets', true), array('controller' => 'targets', 'action' => 'adminIndex'), array('class' => '')); ?></li>
                        <li class=""><?php echo $this->Html->link(__('System', true), '/system', array('class' => '')); ?></li>
                    <?php } ?>

                <?php } ?>
            </ul>
            */ ?>



            <?php if(!$this->Session->check('Auth.User.id')) { ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><?php echo $this->Html->link(__('Login', true), array('controller' => 'users', 'action' => 'login'), array('class' => '')); ?></li>
                </ul>
            <?php } else { ?>
                <div class="btn-group margin10px pull-right">
                    <!--<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-align-justify"></span> Menu</button>-->
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-align-justify"></span> <?php echo User::get('firstname'); ?>
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul id="user-menu" class="dropdown-menu" role="menu">
                        <?php if($this->Permission->isAdmin()) { ?>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> '.__('Profile', true), array('controller' => 'users', 'action' => 'my_profile'), array('class' => '', 'escape' => false)); ?><li>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-off"></span> '.__('Logout', true), array('controller' => 'users', 'action' => 'logout'), array('class' => '', 'escape' => false)); ?><li>
                        <?php } ?>
                        <?php if($this->Permission->isClient()) { ?>
                            <?php
                                $first_run_class = '';
                                if(empty($firstPollId)) {
                                    $first_run_class = 'disabled'; 
                                }
                            ?>
                            <li class="<?php echo $first_run_class; ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-record"></span> '.__('My Polls', true), array('controller' => 'polls', 'action' => 'index'), array('class' => $first_run_class, 'escape' => false)); ?></li>
                            <li class="<?php echo $first_run_class; ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-home"></span> '.__('My Hosts', true), array('controller' => 'hosts', 'action' => 'index'), array('class' => $first_run_class, 'escape' => false)); ?></li>
                            <li class="<?php echo $first_run_class; ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-briefcase"></span> '.__('Account', true), array('controller' => 'accounts', 'action' => 'my_account'), array('class' => $first_run_class, 'escape' => false)); ?><li>
                            <li class="<?php echo $first_run_class; ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> '.__('Profile', true), array('controller' => 'users', 'action' => 'my_profile'), array('class' => $first_run_class, 'escape' => false)); ?><li>
                            <li class="<?php echo $first_run_class; ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-euro"></span> '.__('Invoices', true), array('controller' => 'invoices', 'action' => 'my_invoices'), array('class' => $first_run_class, 'escape' => false)); ?></li>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-off"></span> '.__('Logout', true), array('controller' => 'users', 'action' => 'logout'), array('class' => '', 'escape' => false)); ?><li>
                        <?php } ?>
                    </ul>
                </div>

            <?php } ?>

            <div class="btn-group margin10px pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-globe"></span>
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu" style="min-width: 0;">
                    <?php $codes = Configure::read('Locales'); ?>
                    <?php foreach($codes as $locale => $name) { ?>
                        <li><?php echo $this->Html->link($this->Html->image('/img/flags/'.substr($locale, 0, 2).'.png'), array('controller' => 'users', 'action' => 'setInterfaceLanguage', $locale), array('escape' => false)); ?></li>
                    <?php } ?>
                </ul>
            </div>

            <?php if($this->Session->check('Auth.User.id')) { ?>
                <?php if($this->Permission->isClient() && !empty($statistics_list)) { ?>
                    <div class="btn-group margin10px pull-right">
                        <!--<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-align-justify"></span> Menu</button>-->
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-stats"></span> <?php echo __('My statistics', true); ?>
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu" style="width: 200px; ">
                            <?php foreach($statistics_list as $host_name => $stat) { ?>
                                <li><h4><?php echo $host_name; ?></h4></li>
                                <?php foreach($stat as $poll_id => $poll_title) { ?>
                                    <li><?php echo $this->Html->link('<strong>'.$poll_title.'</strong> <span class="glyphicon glyphicon-chevron-right pull-right"></span>', array('controller' => 'polls', 'action' => 'showLast30', $poll_id), array('class' => '', 'escape' => false)); ?></li>
                                <?php } ?>
                                <li class="divider"></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <?php if($this->Permission->isClient()) { ?>
                    <a href="/dashboard" class="btn btn-default margin10px pull-right"><span class="glyphicon glyphicon-home"></span></a>
                <?php } elseif($this->Permission->isAdmin()) { ?>
                    <a href="/admin_dashboard" class="btn btn-default margin10px pull-right"><span class="glyphicon glyphicon-home"></span></a>
                <?php } ?>
            <?php } ?>

        </div>
    </div>
</nav>

<script>

    $(document).on('click', '#user-menu a', function() {
        if($(this).hasClass('disabled')) {
            return false;
        }
    });

</script>