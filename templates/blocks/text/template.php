<?php
	$text = get_field('text_content');
	$textsize = get_field('text_size');
?>
<section class="cbo-text">
	<div class="text-inner cbo-container">
		<div class="cbo-cms text--<?php echo esc_attr($textsize); ?>">
			<?php echo $text; ?>
		</div>
	</div>
</section>