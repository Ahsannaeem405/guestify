<?php
    $this->set('title_for_layout', __('Tokens', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('System', true), '/system', array('escape' => false));
    $this->Html->addCrumb(__('Tokens', true).' - '.$instance.' - '.$locale);

    echo $this->Html->script('View/Tokens/index', false);
?>

<style>
    div.pagination.token-chars ul>li.active>a{
        background-color: #08c;
        color: white;
    }
</style>


<div class="clearfix">
    <h2><?php echo __('Tokens');?></h2>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo $this->element('Tokens/navtabs'); ?>
            <div class="clearfix">
                <div class="row">
                    <div class="col-xs-12 tab-content">
                        <div class="clearfix">
                            <?php
                                $classes_locales = array();

                                krsort($codes);
                                foreach($codes as $locale_temp => $iso) {
                                    $classes_locales[$locale_temp] = 'inactive';
                                }
                                $classes_locales[$this->params['Tokens.index.tab_locale']] = 'active';
                            ?>

                            <ul class="nav nav-pills">
                                <?php foreach($codes as $temp_locale => $name) { ?>
                                    <li class="<?php echo $classes_locales[$temp_locale]; ?>">
                                        <?php
                                            echo $this->Html->link(
                                                $this->Html->image('/img/flags/'.substr($temp_locale, 0, 2).'.png').' '.$name.
                                                    ' <span class="badge ">'.$navtab_counts[$instance][$temp_locale].'</span>',
                                                    array('action' => 'index', $instance, $temp_locale), array('escape' => false)
                                            );
                                        ?>
                                    </li>
                                <?php } ?>
                            </ul>
                            <hr />
                        </div>

                        <?php /*
                        <div class="pull-left">
                            <?php $chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); ?>
                            <div class="list-inline token-chars pull-left">
                                <ul>
                                    <?php foreach($chars as $start_char) { ?>
                                        <?php $class = ''; if($start_char == $char) { $class = 'active'; } ?>
                                        <li class="<?php echo $class; ?>"><?php echo $this->Html->link($start_char.' ', array('action' => 'index', $locale, $start_char)); ?></li>
                                    <?php } ?>
                                    <?php if(!$char) { $class = 'active'; } else { $class = ''; } ?>
                                    <li class="<?php echo $class; ?>"><?php echo $this->Html->link(__('All', true), array('action' => 'index', $locale)); ?></li>
                                </ul>
                            </div>
                        </div>
                        */ ?>

                        <div class="btn-toolbar pull-right clearfix">
                            <?php
                                if($instance == 'guestifyapp') {
                                    echo $this->Html->link(__('Rebuild cache', true), array('action' => 'rebuildCache', $instance, $locale), array('title' => '('.$instance.', '.$locale.')','class' => 'btn btn-default'));
                                } elseif($instance == 'feedbackapp') {
                                    echo $this->Html->link(__('Rebuild cache', true), Configure::read('NON_SSL_HOST_FE').'/rebuildTokenCache/'.$locale, array('title' => '('.$instance.', '.$locale.')','class' => 'btn btn-default'));
                                }
                            ?>

                            <?php echo $this->Html->link(__('Update tokens', true), array('action' => 'update', $instance, $locale), array('title' => '('.$instance.', '.$locale.')', 'class' => 'btn btn-default')); ?>
                        </div>

                        <div class="clearfix">
                            <?php
                                echo $this->Form->create('Token', array('class' => 'form-inline'), array('url' => $this->here));

                                echo $this->Form->input('Token.search', array(
                                    'label' => false,
                                    'placeholder' => __('Search for token/content ...', true),
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'div' => array(
                                        'class' => 'form-group'
                                    )
                                ));
                                echo $this->Form->submit(__('Search', true), array('class' => 'btn btn-default', 'div' => array('class' => 'form-group')));
                                echo $this->Html->link(__('Reset', true), array('action' => 'resetSearch'), array('class' => 'btn btn-default', 'div' => array('class' => 'form-group')));
                                echo $this->Form->end();
                            ?>


                        </div>

                        <div class="clearfix">
                            <div id="token-index-wrapper">
                                <?php echo $this->element('Tokens/list'); ?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php echo $this->element('Widgets/standard_delete/main'); ?>
