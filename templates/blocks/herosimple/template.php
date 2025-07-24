<?php
	$title	= get_field('herosimple_title');
	$chapo	= get_field('herosimple_chapo');
?>
<section class="cbo-herosimple">
	<div class="herosimple-inner cbo-container">
		<?php if($title): ?>
			<div class="herosimple-title cbo-title-2 slide-up" itemprop="headline">
				<?php echo $title; ?>
			</div>
		<?php endif; ?>

		<?php if($chapo): ?>
			<div class="herosimple-chapo cbo-title-5 slide-up" itemprop="headline">
				<?php echo $chapo; ?>
			</div>
		<?php endif; ?>
	</div>
</section>