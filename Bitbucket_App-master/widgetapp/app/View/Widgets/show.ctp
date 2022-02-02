<?php 
	echo $this->Html->css('w_basic'); 
    echo $this->Html->css('w_'.$widget['Widget']['style']); 
?>

<style>
	.widget_width { width: <?php echo $widget['Widget']['width']; ?>px; }
	.widget_height { height: <?php echo $widget['Widget']['height']; ?>px; }	

	.content { margin: 0px auto; width: <?php echo $widget['Widget']['width']-20; ?>px; padding: 0; }
</style>



<div class="widget_wrapper widget_width widget_height">
	<header>
		<section>
			<div class="clearfix">
				<div class="left_side">
					<div class="logo_container">
						<div class="logo">
							<?php echo $this->Html->image(Configure::read('CDN.Host') . 'hosts' . DS . '300' . DS . $widget['Host']['logo'], array('class' => 'img-responsive')); ?>
						</div>
					</div>
				</div>
				<div class="right_side">
					<div class="gsi_container">
						<?php if(isset($widget['Widget']['gsi'])) { ?>
							<div class="element_gsi"><?php echo $widget['Widget']['gsi']; ?></div>
						<?php } ?>
						<?php if(isset($widget['Widget']['ratinglabel'])) { ?>
							<div class="element_ratinglabel"><?php echo $widget['Widget']['ratinglabel']; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
		</section>
		<section class="host_area">
			<div class="content">
				<h1 class="hostname"><?php echo $widget['Host']['name']; ?></h1>
			</div>
		</section>
	</header>

	<content>

		<?php if(!empty($widget['Widget']['gsi'])) { ?>
			
			<div class="content">
				<?php if(isset($widget['Widget']['ratingcount'])) { ?>
					<?php echo $this->element('section_stats'); ?>
				<?php } ?>

				<?php if(is_array($widget['Widget']['comments']) && isset($widget['Widget']['comments'])) { ?>
					<?php echo $this->element('section_comments'); ?>
				<?php } ?>


				<?php if(isset($widget['Widget']['trend'])) { ?>
					<?php echo $this->element('section_trend'); ?>
				<?php } ?>

				
			<?php } else { ?>
				<div class="panel-body">
					<p class="lead text-center text-muted">
						<span class="clearfix"><span class="glyphicon glyphicon-warning-sign "></span></span>
						<?php echo __('Sorry, no data available', true); ?>
					</p>
				</div>
			<?php } ?>
		</div>

	</content>

	<footer>
		<div class="clearfix">
			<div class="content">
				<a href="https://guestfiy.net" class="pull-right" title="<?php echo __('Powered by', true); ?> &copy; Guestify, <?php echo date('Y'); ?>"><img src="/graphics/favicon-32x32.png" class="guestify_logo" /></a>
				<?php if(!empty($widget['Widget']['gsi'])) { ?>
					<?php 
						if($widget['Widget']['period'] == 'week_1') {
							$period_name = __('last 7 days', true); 
						} elseif($widget['Widget']['period'] == 'month_1') {
							$period_name = __('last 30 days', true); 
						} elseif($widget['Widget']['period'] == 'month_3') {
							$period_name = __('last 3 months', true); 
						} elseif($widget['Widget']['period'] == 'month_6') {
							$period_name = __('last 6 months', true); 
						} elseif($widget['Widget']['period'] == 'year_1') {
							$period_name = __('last year', true); 
						} else {
							$period_name = __('since beginning', true); 
						}
					?>
					<small class="text-muted"><?php echo __('Ratings based', true); ?> <?php echo $period_name; ?></small>

				<?php } ?>
			</div>
		</div>
	</footer>

</div>

<?php #pr($widget); ?>

