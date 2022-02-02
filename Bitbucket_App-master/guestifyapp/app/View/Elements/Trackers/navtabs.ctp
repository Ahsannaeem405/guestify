<?php
    $classes = array();
    $classes['system']     		= '';
    $classes['weekly_report'] 	= '';
    $classes['newsletter'] 		= '';
    
    $classes[$this->params['Targets.index.tab']] = 'active';
?>

<ul class="nav nav-tabs">
    <li class="<?php echo $classes['system']; ?>"><?php echo $this->Html->link(__('System', true).' <span class="badge badge-info">'.$navtab_counts['system'].'</span>', array('action' => 'index_system'), array('escape' => false)); ?></li>
    <?php /*
    <li class="<?php echo $classes['weekly_report']; ?>"><?php echo $this->Html->link(__('Weekly Report', true).' <span class="badge badge-info">'.$navtab_counts['weekly_report'].'</span>', array('action' => 'index_weekly_report'), array('escape' => false)); ?></li>
    <li class="<?php echo $classes['newsletter']; ?>"><?php echo $this->Html->link(__('Newsletters', true).' <span class="badge badge-info">'.$navtab_counts['newsletter'].'</span>', array('action' => 'index_newsletter'), array('escape' => false)); ?></li>
    */ ?>
</ul>

<div class="clearfix">&nbsp;</div>


