<section class="trend">
	<div class="content trend-container">
		<script>
			$(function () {
			  $('.trendbar').tooltip()
			})
		</script>
		<?php 
			$maxgsi_value = 10;							
			if(isset($widget['Widget']['trend']['day'])) {
				$maxvalue = max($widget['Widget']['trend']['day']); 
			} elseif(isset($widget['Widget']['trend']['month'])) {
				$maxvalue = max($widget['Widget']['trend']['month']); 
			} elseif(isset($widget['Widget']['trend']['year'])) {
				$maxvalue = max($widget['Widget']['trend']['year']); 
			}  
		?>

		<table class="trend-table <?php echo $widget['Widget']['period']; ?>" cellspacing="0">
			<tr>
				<?php foreach($widget['Widget']['trend'] as $dateinfo => $trend ){ ?>
					<?php foreach($trend as $date => $gsi) { ?>
						<td class="bar-container" valign="bottom">
							<?php 
								if($maxvalue > 0) {
									$barvalue = ($gsi / $maxgsi_value) * 100;
								} else { 
									$barvalue = 0; 
								}
							?>
							<span class="trendbar" data-toggle="tooltip" data-placement="top" title="<?php echo round($gsi, 1).'/10 | '.$date; ?>" style=" height: <?php echo $barvalue; ?>%;"></span>
						</td>
					<?php } ?>
				<?php } ?>
			</tr>
		</table>
	</div>
	
</section>