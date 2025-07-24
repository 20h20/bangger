<?php
	if (function_exists('cbo_register_block_usage')) {
		cbo_register_block_usage('herosimple');
	}
	get_header();
	$title	= get_field('page_directorstitle', 'option');
	$chapo	= get_field('page_directorschapo', 'option');
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

				<?php
					$current_cat_id = get_queried_object_id();
					$args = array(
						'taxonomy' => 'directors_cat',
						'orderby' => 'name',
						'order'   => 'ASC'
					);
					$cats = get_categories($args);
					$all_articles_link = get_post_type_archive_link('directors');
				?>
				<div class="cbo-filters" data-post-type="directors">
					<div class="filters-inner slide-up">
						<div class="filters-menu">
							<?php pll_e('Filtrer par catégorie') ?>
						</div>
						<div class="tags-list" data-post-type="directors">
							<a class="list-el <?php if (!$current_cat_id) echo 'el--active'; ?>" href="<?php echo esc_url($all_articles_link); ?>" data-archive="1">
								<span class="el-inner"><?php pll_e('Tous') ?></span>
							</a>

							<?php foreach ($cats as $cat) : ?>
								<a class="list-el <?php if ($current_cat_id == $cat->term_id) echo 'el--active'; ?>" href="<?php echo esc_url(get_term_link($cat->term_id)); ?>">
									<span class="el-inner"><?php echo esc_html($cat->name); ?></span>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
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