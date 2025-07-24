<?php
	$label	= get_field('button_label');
	$url	= get_field('button_url');
	$target	= get_field('button_target');
?>
<?php if($label): ?>
	<div class="button-container slide-up">
		<a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="cbo-button">
			<span class="button-label">
				<?php echo $label; ?>
			</span>
			<i class="icon icon--arrow-next"></i>
		</a>
	</div>
<?php endif; ?>