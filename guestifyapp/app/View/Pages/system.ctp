<?php
    $this->set('title_for_layout', __('System', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
?>

<div class="clearfix">
    <h2><?php echo __('System services', true); ?></h2>
    
    <div class="row">
        <div class="panel">
            <div class="panel-body">

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-comment"></span><br />
                        <?php echo $this->Html->link(__('Poll-drafts', true), array('controller' => 'drafts', 'action' => 'admin_index'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-list"></span><br />
                        <?php echo $this->Html->link(__('Translations', true), array('controller' => 'tokens', 'action' => 'index'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-envelope"></span><br />
                        <?php echo $this->Html->link(__('Email-Tracker', true), array('controller' => 'trackers', 'action' => 'index_system'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>


                <?php /* AUTOMATIC DEPLYOMENT MANAGEMENT - ACTIVATE THIS IF YOU CAN CONNECT VIA REPO AND PRODUCTION ENV VIA SHELL COMMAND
                <?php if(in_array(Configure::read('Environment'), array('LOCAL', 'STAGE', 'LIVE'))) { ?>
                    <div class="col-xs-3">
                        <div class="lead text-center well">
                            <span class="glyphicon glyphicon-refresh"></span><br />
                            <?php
                                echo $this->Html->link(__('Deploy', true), '#', array('title' => __('Currently deactivated because of server-switch'), 'class' => '', 'escape' => false)); ?>
                        </div>
                    </div>
                <?php } ?>
                */ ?>

            </div>
        </div>
    </div>

    <?php /* DISABLED API MANAGEMENT BETA / DOES NOT AFFECT API FUNCTIONALITY
    <H2>API AREA BETA</h2>
    <div class="row">
        <div class="panel">
            <div class="panel-body">

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-resize-horizontal"></span><br />
                        <?php echo $this->Html->link(__('API Functions', true), array('controller' => 'apis', 'action' => 'functions'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-play"></span><br />
                        <?php echo $this->Html->link(__('API Debugger', true), array('controller' => 'ApiDebugger', 'action' => 'debugger'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-random"></span><br />
                        <?php echo $this->Html->link(__('API Tokens', true), array('controller' => 'ApiTokens', 'action' => 'adminIndex'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-random"></span><br />
                        <?php echo $this->Html->link(__('API Calls', true), array('controller' => 'ApiCallLogs', 'action' => 'adminIndex'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    */ ?>

</div>
