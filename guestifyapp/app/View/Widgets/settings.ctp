<?php
    $this->set('title_for_layout', __('Widgetview', true));
    $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    $this->Html->addCrumb(__('My Widgets', true), array('controller' => 'widgets', 'action' => 'index'), array('escape' => false));
    $this->Html->addCrumb($widget['Widget']['name'], false);
?>

<div class="clearfix">

    <div class="btn-toolbar pull-right">
        <?php 
	        if($widget['Widget']['status'] == 0){
	            echo $this->Html->link('<span class="glyphicon glyphicon-ok-sign"></span> '.__('Activate', true), array('controller' => 'widgets', 'action' => 'activate', $widget['Widget']['id']), array('class' => 'btn btn-success standard-activate', 'escape' => false));
	        } elseif($widget['Widget']['status'] == 1){
	            echo $this->Html->link('<span class="glyphicon glyphicon-ban-circle"></span> '.__('Deactivate', true), array('controller' => 'widgets', 'action' => 'deactivate', $widget['Widget']['id']), array('class' => 'btn btn-warning standard-deactivate', 'escape' => false));
	        }
	        if($widget['Widget']['status'] == 0){
            	echo $this->Html->link('<span class="glyphicon glyphicon-remove-sign"></span>', array('controller' => 'widgets', 'action' => 'remove', $widget['Widget']['id']), array('id' => 'delete-poll-'.$widget['Widget']['id'], 'class' => 'btn btn-danger standard-delete', 'title' => __('Delete', true), 'escape' => false));
        	}
        	echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ', array('controller' => 'widgets', 'action' => 'edit', $widget['Widget']['id']), array('class' => 'btn btn-default', 'title' => __('Edit', true), 'escape' => false));
        ?>
    </div>

    <h2><?php echo 'Widget: '.$widget['Widget']['name'];?></h2>
	<div class="row">
		<div class="col-xs-12">
		    <div class="panel panel-default">
		        <div class="panel-body">
		        	<div class="row">
						<div class="col-xs-6">
							<h3><?php echo __('Basic settings', true); ?></h3>
							<dl class="dl-horizontal">
								<dt><?php echo __('Widget URL', true); ?></dt>
			                    <dd><?php echo Configure::read('URL_widgetapp') . '/widgets/show/'.$widget['Widget']['hash']; ?></dd>				                
			                    <dt><?php echo __('Poll', true); ?></dt>
			                    <dd><?php echo $widget['Poll']['title']; ?></dd>
			                    <dt><?php echo __('Name', true); ?></dt>
			                    <dd><?php echo $widget['Widget']['name']; ?></dd>
			                    <dt><?php echo __('Period', true); ?></dt>
			                    <dd><?php echo $widget['Widget']['period']; ?></dd>
			                    <dt><?php echo __('Format', true); ?></dt>
			                    <dd><?php echo $widget['Widget']['format']; ?></dd>
			                    <dt><?php echo __('Width', true); ?></dt>
			                    <dd><?php echo $widget['Widget']['width']; ?></dd>
			                    <dt><?php echo __('Height', true); ?></dt>
			                    <dd><?php echo $widget['Widget']['height']; ?></dd>
			                    <dt><?php echo __('Style', true); ?></dt>
			                    <dd><?php echo $widget['Widget']['style']; ?></dd>
			                </dl>
			                <hr />
                        	<div class="well">
                            	<h4><?php echo __('Grab this code', true); ?></h4>
                            	<code>
                            		<?php echo h('<iframe src="' . Configure::read('URL_widgetapp') . '/widgets/show/'.$widget['Widget']['hash'].'" height="'.$widget['Widget']['height'].'" width="'.$widget['Widget']['width'].'" allowtransparency="true" frameborder="0" border="0" cellspacing="0" scrolling="no" />'); ?>
                            	</code>

                            </div>
			                <h3><?php echo __('Activated elements', true); ?></h3>
			                <dl class="dl-horizontal">
			                    <?php foreach($widget['WidgetElement'] as $widget_element): ?>
				                    <dt><?php echo __('Element', true); ?></dt>
				                    <dd><?php echo $widget_element['type']; ?></dd>
				                <?php endforeach; ?>
							</dl>
						</div>
						<div class="col-xs-6">
							<div class="panel panel-info">
                                <div class="panel-body">
                                	<h3><?php echo __('Preview', true); ?></h3>
                                	<style>
	                                	iframe:focus { 
										    outline: none;
										}

										iframe[seamless] { 
										    display: block;
										}
									</style>
                                	<iframe src="<?php echo Configure::read('URL_widgetapp') . '/widgets/show/'.$widget['Widget']['hash']; ?>" height="<?php echo $widget['Widget']['height']; ?>" width="<?php echo $widget['Widget']['width']; ?>" allowtransparency="true" frameborder="0" border="0" cellspacing="0" scrolling="no" />
                                </div>
                                
                            </div>                            
						</div>
					</div>
		        </div>
		    </div>
		</div>
	</div>
</div>