<?php
    $classes = array();
    $classes['list']     = '';
    $classes['prepared'] = '';
    $classes[$this->params['Targets.index.tab']] = 'active';
?>

<ul class="nav nav-tabs">
    <li class="<?php echo $classes['list']; ?>"><?php echo $this->Html->link(__('List', true).' <span class="badge badge-info">'.$navtab_counts['list'].'</span>', array('action' => 'adminIndex', $category_id, 'list'), array('escape' => false)); ?></li>
    <li class="<?php echo $classes['prepared']; ?>"><?php echo $this->Html->link(__('Prepared', true).' <span class="badge badge-info">'.$navtab_counts['prepared'].'</span>', array('action' => 'adminIndex', $category_id, 'prepared'), array('escape' => false)); ?></li>
</ul>

<div class="clearfix">&nbsp;</div>


