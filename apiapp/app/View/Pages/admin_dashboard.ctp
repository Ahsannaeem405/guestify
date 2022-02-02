<?php
    $this->set('title_for_layout', __('API Services', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
?>

<div class="clearfix">
    <h2><?php echo __('API Services', true); ?></h2>
    
    <div class="row">
        <div class="panel">
            <div class="panel-body">

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-resize-horizontal"></span><br />
                        <?php echo $this->Html->link(__('Documentation', true), array('controller' => 'apis', 'action' => 'functions'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-play"></span><br />
                        <?php echo $this->Html->link(__('Debugger', true), array('controller' => 'ApiDebugger', 'action' => 'debugger'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-random"></span><br />
                        <?php echo $this->Html->link(__('Tokens', true), array('controller' => 'ApiTokens', 'action' => 'adminIndex'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="lead text-center well">
                        <span class="glyphicon glyphicon-random"></span><br />
                        <?php echo $this->Html->link(__('Calls', true), array('controller' => 'ApiCallLogs', 'action' => 'adminIndex'), array('class' => '', 'escape' => false)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
