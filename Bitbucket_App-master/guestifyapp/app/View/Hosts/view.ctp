<?php
    $this->set('title_for_layout', __('Poll', true).' - '.$host['Host']['name']);
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My Hosts', true), array('controller' => 'hosts', 'action' => 'index'), array('escape' => false));
    $this->Html->addCrumb($host['Host']['name']);
?>


<div class="btn-toolbar pull-right">
    <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> '.__('Edit', true), array('action' => 'edit', $host['Host']['id']), array('class' => 'btn btn-info', 'escape' => false)); ?>
</div>

<h2><?php echo $host['Host']['name']; ?></h2>

<div class="panel oanel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-7">
                <div class="clearfix">
                    <h3><?php echo __('Basic information', true);?></h3>
                    <dl class="dl-horizontal">
                        <dt><?php echo __('Id', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['id']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Standard language', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['locale']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Timezone', true); ?></dt>
                        <dd>
                            <?php echo $timezones[$host['Host']['timezone']]; ?>
                            &nbsp;
                        </dd>
                    </dl>



                    <h3><?php echo __('Location information', true);?></h3>
                    <dl class="dl-horizontal">
                        <dt><?php echo __('Address', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['address']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Zipcode', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['zipcode']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('City', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['city']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Country', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['country_name']; ?>
                            &nbsp;
                        </dd>
                    </dl>

                    <h3><?php echo __('Contact information', true);?></h3>
                    <dl class="dl-horizontal">
                        <dt><?php echo __('Phone', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['phone']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Fax', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['fax']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Email', true); ?></dt>
                        <dd>
                            <?php echo $host['Host']['email']; ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Web', true); ?></dt>
                        <dd>
                            <?php
                                if(!empty($host['Host']['web'])) {
                                    echo $this->Html->link($host['Host']['web'], $host['Host']['web'], array('target' => 'blank'));
                                }
                            ?>
                            &nbsp;
                        </dd>
                    </dl>



                    <?php
                        $empty = true;
                        foreach($values_socials as $type_id => $link) {
                            if(!empty($link)) {
                                $empty = false;
                            }
                        }
                    ?>

                    <?php if(!$empty)  { ?>
                        <h3><?php echo __('Social links', true);?></h3>
                        <dl class="dl-horizontal">
                            <?php foreach($values_socials as $type_id => $link) { ?>
                                <?php if(!empty($link)) { ?>
                                    <dt><?php echo $socials[$type_id]; ?></dt>
                                    <dd>
                                        <?php echo $values_socials[$type_id]; ?>
                                        &nbsp;
                                    </dd>
                                <?php } ?>
                            <?php } ?>
                        </dl>
                    <?php } ?>

                    <h3><?php echo __('System information', true);?></h3>
                    <dl class="dl-horizontal">
                        <dt><?php echo __('Last modified', true); ?></dt>
                        <dd>
                            <?php echo $this->Time->format($formats['datetime'], $host['Host']['modified']); ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Created', true); ?></dt>
                        <dd>
                            <?php echo $this->Time->format($formats['datetime'], $host['Host']['created']); ?>
                            &nbsp;
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="col-xs-5">
                <h3><?php echo __('Logo', true);?></h3>
                <?php
                    if(!empty($host['Host']['logo'])) {
                        echo $this->Html->image(Configure::read('CDN.Host'). 'hosts' . DS . 300 . DS . $host['Host']['logo'], array('class' => 'img-thumbnail'));
                    } else {
                        #echo 'Placeholder here!';
                        echo $this->Html->image(Configure::read('CDN.Host'). 'hosts' . DS . 300 . DS . 'no_pic.jpg', array('class' => 'img-thumbnail'));
                    }
                ?>

                <?php if(isset($host['Host']['lat']) && !empty($host['Host']['lat'])) { ?>
                    <hr />

                    <div class="clearfix">
                    <h3><?php echo __('Map', true); ?></h3>

                        <?php
                            echo $this->element('Hosts/map', array(
                                'lat' => $host['Host']['lat'],
                                'lng' => $host['Host']['lng'],
                                'host' => $host,
                                'width' => '100%',
                                'height' => '300px',
                                'zoom' => '10'
                            ));
                        ?>

                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>



<?php #echo $this->element('Widgets/standard_activate/main'); ?>
<?php #echo $this->element('Widgets/standard_deactivate/main'); ?>
<?php #echo $this->element('Widgets/standard_delete/main'); ?>
