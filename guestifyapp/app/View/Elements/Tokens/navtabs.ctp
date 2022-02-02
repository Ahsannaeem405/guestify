<?php
    $classes_instance = array();
    $classes_instance['guestifyapp'] = '';
    $classes_instance['feedbackapp'] = '';
    $classes_instance['apiapp'] 	 = '';
    $classes_instance['widgetapp'] 	 = '';
    $classes_instance[$this->params['Tokens.index.tab_instance']] = 'active';
?>

<ul class="nav nav-tabs">
    <li class="<?php echo $classes_instance['guestifyapp']; ?>"><?php echo $this->Html->link('<h4>Guestify-app'.' <span class="badge badge-info">'.$navtab_counts['guestifyapp']['overall'].'</span></h4>', array('action' => 'index', 'guestifyapp'), array('escape' => false)); ?></li>
    <li class="<?php echo $classes_instance['feedbackapp']; ?>"><?php echo $this->Html->link('<h4>Feedback-app'.' <span class="badge badge-info">'.$navtab_counts['feedbackapp']['overall'].'</span></h4>', array('action' => 'index', 'feedbackapp'), array('escape' => false)); ?></li>
    <li class="<?php echo $classes_instance['apiapp']; ?>"><?php echo $this->Html->link('<h4>API-app'.' <span class="badge badge-info">'.$navtab_counts['apiapp']['overall'].'</span></h4>', array('action' => 'index', 'apiapp'), array('escape' => false)); ?></li>
    <li class="<?php echo $classes_instance['widgetapp']; ?>"><?php echo $this->Html->link('<h4>Widget-app'.' <span class="badge badge-info">'.$navtab_counts['widgetapp']['overall'].'</span></h4>', array('action' => 'index', 'widgetapp'), array('escape' => false)); ?></li>
</ul>

<div class="clearfix">&nbsp;</div>


