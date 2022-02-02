<?php 
	$this->assign('title', __('Add widget')); 
    $this->set('title_for_layout', __('Create your widget', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('My Widgets', true), array('controller' => 'widgets', 'action' => 'index'), array('escape' => false));
    $this->Html->addCrumb(__('Add Widgets', false));

    echo $this->Html->script('View/Widgets/add', false);
?>

<div class="clearfix">
    <h2><?php echo __('Add widget');?></h2>
<p></p>
<div class="row">
	<div class="col-xs-2"></div>
	<div class="col-xs-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php 
					echo $this->Form->create('Widget');
					echo $this->Form->input('Widget.poll_id', array(
                        'div' => array('class' => 'form-group'),
						'class' => 'form-control',
						'id' => 'poll_id',
                        'empty' => __('Select a poll...'),
                        'type' => 'select',
                        'options' => $polls
                    ));
					echo $this->Form->input('Widget.name', array(
						'div' => array('class' => 'form-group'),
						'class' => 'form-control'
					));
					echo $this->Form->input('Widget.period', array(
						'div' => array('class' => 'form-group'),
						'class' => 'form-control',
						'type' => 'select',
						'empty' => __('Select a timeperiod'),
						'options' => $period
					));
					echo $this->Form->input('Widget.format', array(
						'div' => array('class' => 'form-group'),
						'class' => 'form-control',
						'type' => 'select',
						'empty' => __('Select a format'),
						'options' => $format
					));
					echo $this->Form->input('Widget.width', array(
						'div' => array('class' => 'form-group'),
						'class' => 'form-control'
					));
					echo $this->Form->input('Widget.height', array(
						'div' => array('class' => 'form-group'),
						'class' => 'form-control'
					));
					echo $this->Form->input('Widget.style', array(
						'div' => array('class' => 'form-group'),
						'id' => 'style',
						'class' => 'form-control',
						'type' => 'select',
						'empty' => __('Select a style'),
						'options' => $style
					));
					foreach($widget_element_types as $key => $value){
						echo $this->Form->label($key, $value);
						echo $this->Form->checkbox($key);
						echo "<br>";
					}
					echo $this->Form->input('Widget.select_comment_count', array(
						'div' => array('class' => 'form-group'),
						'type' => 'select',
						'empty' => __('how many comments'),
						'options' => $comment_choice
					));
					echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-success btn-block'));
					echo '&nbsp';
					echo $this->Html->link(__('Cancel', true), array('controller' => 'widgets', 'action' => 'index'), array('class' => 'btn btn-default btn-block'));
					echo $this->Form->end();
				?>
			</div>
		</div>
	</div>
	<div class="col-xs-2"></div>
</div>