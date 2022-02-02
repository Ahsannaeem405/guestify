<section class="statistics">
	<div class="content statsbar">
		<div class="box box1">
			<figure><?php echo $widget['Widget']['ratingcount']; ?></figure>
			<small class"label_comment"><?php echo __('Ratings', true); ?></small>
		</div>
		<div class="box box2">
			<?php $comment_count = 0; ?>
			<?php foreach($widget['Widget']['comments'] as $key => $comment){ ?>
				<?php if(isset($comment['Guest']['comment_customer']) && !empty($comment['Guest']['comment_customer'])) { ?>
					<?php $comment_count++; ?>
				<?php } ?>
			<?php } ?>
			<figure><?php echo $comment_count; ?></figure>
			<small class"label_comment"><?php echo __('Comments', true); ?></small>
		</div>
	</div>
</section>