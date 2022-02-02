<?php
    $this->set('title_for_layout', __('First Steps', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
?>


<div class="clearfix">
    <h2><?php echo __('First steps', true); ?></h2>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-8">
                            <h3><?php echo __('Step 1 - Create and setup your first poll', true); ?></h3>
                            <div class="jumbotron">Illustration & Video coming soon</div>
                            <h3><?php echo __('Step 2 - Customize and activate your poll', true); ?></h3>
                            <div class="jumbotron">Illustration & Video coming soon</div>
                            <h3><?php echo __('Step 3 - Download the table cards and put them on the tables', true); ?></h3>
                            <div class="jumbotron">Illustration & Video coming soon</div>
                        </div>
                        <div class="col-xs-4">
                            <div class="text-center">
                                <h3><?php echo __('Guest Satisfaction Index', true);?><br /> (GSI)</h3>
                                <h4><strong>10</strong></h4>
                            </div>
                            <div class="row gsi-barometer">
                                <div class="col-xs-5">
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-left"><small><?php echo __('Amazing', true); ?></small></div>
                                        <hr />
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-left"><small><?php echo __('Good', true); ?></small></div>
                                        <hr />
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-left"><small><?php echo __('Not bad', true); ?></small></div>
                                        <hr />
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-left"><small><?php echo __('Bad', true); ?></small></div>
                                        <hr />
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-left"><small><?php echo __('Do you care?', true); ?></small></div>
                                        <hr />
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="progress progress-striped" style="height: 500px; width: 40px;">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 25%"></div>
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 50%"></div>
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 25%"></div>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-right"><small><?php echo __('Excellent', true); ?></small></div>
                                        <hr />
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-right"><small><?php echo __('Satisfied', true); ?></small></div>
                                        <hr />
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-right"><small><?php echo __('Average', true); ?></small></div>
                                        <hr />
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-right"><small><?php echo __('Dissatisfied', true); ?></small></div>
                                        <hr />
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">
                                        <div class="alert alert-warning pull-right"><small><?php echo __('Awful', true); ?></small></div>
                                        <hr />
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h4><strong>0</strong></h4>
                                <h3><?php echo __('No rating', true);?></h3>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
