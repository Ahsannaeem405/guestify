<?php
    $this->set('title_for_layout', __('Edit Widget', true));
    $this->Html->addCrumb(__('Home', true), '/');
    $this->Html->addCrumb(__('My Widgets', true), array('controller' => 'widgets', 'action' => 'index'), array('escape' => false));
    $this->Html->addCrumb(__($this->request->data['Widget']['name'], true), array('controller' => 'widgets', 'action' => 'settings', $this->request->data['Widget']['id']), array('escape' => false));
?>

<div class="clearfix">
	<h2><?php echo 'Edit Widget';?></h2>
</div>
<div class="row">
	<div class="col-xs-2"></div>
	<div class="col-xs-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo $this->Form->create('Widget'); ?>

				<?php
					echo $this->Form->input('Widget.poll_title', array(
						'readonly' => true,
						'label' => __('Poll', true),
						'div' => array('class' => 'form-group'),
						'class' => 'form-control'
					));
					echo $this->Form->input('Widget.poll_id', array('readonly' => true, 'type' => 'hidden'));
					echo $this->Form->input('Widget.name', array(
						'label' => __('Name', true),
						'div' => array('class' => 'form-group'),
						'class' => 'form-control'
					));
					echo $this->Form->input('Widget.period', array(
						'label' => __('Period', true),
						'div' => array('class' => 'form-group'),
						'class' => 'form-control',
						'type' => 'select',
						'empty' => __('Select a timeperiod'),
						'options' => $period
					));
					echo $this->Form->input('Widget.format', array(
						'label' => __('Format', true),
						'div' => array('class' => 'form-group'),
						'class' => 'form-control',
						'type' => 'select',
						'empty' => __('Select a format'),
						'options' => $format
					));
					echo $this->Form->input('Widget.width', array(
						'label' => __('Width', true),
						'div' => array('class' => 'form-group'),
						'class' => 'form-control'
					));
					echo $this->Form->input('Widget.height', array(
						'label' => __('Height', true),
						'div' => array('class' => 'form-group'),
						'class' => 'form-control'
					));
					if($this->request->data['Widget']['poll_type'] == 'limited'){
						$disabled = 'disabled';
						$selected = 'standard';
					} else{
						$disabled = false;
						$selected = $this->request->data['Widget']['style'];
					}
					echo $this->Form->input('Widget.style', array(
						'label' => __('Style', true),
						'div' => array('class' => 'form-group'),
						'class' => 'form-control',
						'type' => 'select',
						'disabled' => $disabled,
						'selected' => $selected,
						'empty' => __('Select a style'),
						'options' => $style
					));
					foreach($widget_element_types as $key => $value){
						echo '<div class="form-group">';
						echo $this->Form->checkbox($key, array('class' => ''));
						echo $this->Form->label($key, $value);
						echo '</div>';						
					}
					echo $this->Form->input('Widget.select_comment_count', array(
						'label' => __('Amount of comments', true),
						'div' => array('class' => 'form-group'),
						'class' => 'form-control',
						'type' => 'select',
						'empty' => __('how many comments'),
						'options' => $comment_choice
					));

					echo $this->Form->input('Widget.id', array('readonly' => true, 'type' => 'hidden'));
					
					echo $this->Form->submit(__('Save changes'), array('class' => 'btn btn-success btn-block'));
					echo '&nbsp';
					echo $this->Html->link(__('Cancel', true), array('controller' => 'widgets', 'action' => 'settings', $this->request->data['Widget']['id']), array('class' => 'btn btn-default btn-block'));
					echo $this->Form->end();
				?>
			</div>
		</div>
	</div>
	<div class="col-xs-2"></div>
</div>