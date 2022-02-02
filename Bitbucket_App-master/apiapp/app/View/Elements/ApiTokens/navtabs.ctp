<?php
    $classes = array();
    $classes['live']     = '';
    $classes['debugger'] = '';
    $classes[$this->params['ApiTokens.index.tab']] = 'active';
?>

<ul class="nav nav-tabs">
    <li class="<?php echo $classes['live']; ?>"><?php echo $this->Html->link(__('Live', true).' <span class="badge badge-info">'.$navtabCounts['live'].'</span>', array('action' => 'adminIndex', 'live'), array('escape' => false)); ?></li>
    <li class="<?php echo $classes['debugger']; ?>"><?php echo $this->Html->link(__('Debugger', true).' <span class="badge badge-info">'.$navtabCounts['debugger'].'</span>', array('action' => 'adminIndex', 'debugger'), array('escape' => false)); ?></li>
</ul>

<div class="clearfix">&nbsp;</div>


