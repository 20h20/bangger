<?php
	if (function_exists('cbo_register_block_usage')) {
		cbo_register_block_usage('herosimple');
	}
	get_header();
	$title	= get_field('page_moviestitle', 'option');
	$chapo	= get_field('page_movieschapo', 'option');
	$args = [
		'post_type' => 'movies',
		'posts_per_page' => 6,
		'post_status' => 'publish',
		'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
	  ];
	  $query = new WP_Query($args);
	  $max_page = $query->max_num_pages;
?>
	<div class="cbo-page page--archive archive--movies">

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
						'taxonomy' => 'movies_cat',
						'orderby' => 'name',
						'order'   => 'ASC'
					);
					$cats = get_categories($args);
					$all_articles_link = get_post_type_archive_link('movies');
				?>
				<div class="cbo-filters" data-post-type="movies">
					<div class="filters-inner slide-up">
						<div class="filters-menu">
							<?php pll_e('Filtrer par catégorie') ?>
						</div>
						<div class="tags-list">
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

		<div class="cbo-movies" id="cbo-movies" data-max-page="<?= $max_page ?>" data-category-slug="<?= is_tax('movies_cat') ? get_queried_object()->slug : 'tous' ?>">
			<div class="movies-inner">
				<div class="movies-list">
					<?php
						if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post();
								get_template_part('templates/parts/movie/template');
							endwhile;
							endif;
						wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	</div>
<?php
	get_footer();
?>