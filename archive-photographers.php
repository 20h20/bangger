<?php
	if (function_exists('cbo_register_block_usage')) {
		cbo_register_block_usage('herosimple');
	}
	get_header();
	$title	= get_field('page_photographestitle', 'option');
	$chapo	= get_field('page_photographeschapo', 'option');
?>
	<div class="cbo-page page--archive archive--directors">

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

		<section class="cbo-directors">
			<div class="directors-inner cbo-container">
				<div class="directors-list">
					<?php
					if (have_posts()) :
						while (have_posts()) : the_post();
							get_template_part('templates/parts/director/template');
						endwhile;
					endif;
					?>
				</div>
			</div>
		</section>
	</div>
<?php
	get_footer();
?>