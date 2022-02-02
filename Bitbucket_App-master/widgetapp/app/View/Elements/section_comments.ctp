<section class="comment_feed">
	<div class="content comment-carousel">
		<script>
			$('#CommentFeed').carousel({
			  interval: 3000
			})
		</script>
		<div id="CommentFeed" class="carousel slide vertical" data-ride="carousel" data-interval="3000">
            <!-- Carousel items -->
            <div class="carousel-inner vertical">
        		<?php $i = 1; ?>
            	<?php foreach($widget['Widget']['comments'] as $key => $comment){ ?>
					<?php $item_class = ($i === 1) ? 'item active' : 'item'; ?>
					<div class=" item ">
						<div class="comment_bulb label label-default">
							<div class="row">
								<div class="col-xs-1">
									<span class="gsi_small"><?php echo $comment['Guest']['gsi']; ?></span>
								</div>
								<div class="col-xs-10">
									<?php if(isset($comment['Guest']['comment_customer']) && !empty($comment['Guest']['comment_customer'])) { ?>
										<span class="comment_text">
											<?php echo $comment['Guest']['comment_customer']; ?><br />
										</span>
									<?php } ?>
									<?php /*
									<small>
										<?php if(isset($comment['Guest']['ip']) && !empty($comment['Guest']['ip']) && ($comment['Guest']['ip'] != '127.0.0.1')) { ?>
											<?php
												// $json = file_get_contents('http://freegeoip.net/json/'.$comment['Guest']['ip']);
												$json = @file_get_contents('http://freegeoip.net/json/'.$comment['Guest']['ip']);
												if(!empty($json)) {
													$originlocation = json_decode($json, true);
													if(isset($originlocation['country_name']) && !empty($originlocation['country_name'])) {
														echo $originlocation['city'].', '.$originlocation['country_name'];
													}
												}
											?>
										<?php } ?>
									</small>
									*/ ?>
								</div>
								<div class="col-xs-1"></div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<script>
			$('div.carousel-inner').find('div.item:first').addClass('active');
		</script>
	</div>
</section>