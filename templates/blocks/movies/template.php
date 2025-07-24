<?php
	$title	= get_field('movies_title');
	$last = get_field('movies_all');
?>
<section class="cbo-movies">
	<div class="movies-inner">
		<?php if($title): ?>
			<div class="movies-top">
				<div class="movies-title cbo-title-2 slide-up" itemprop="headline">
					<?php echo $title ?>
				</div>
				<?php get_template_part('templates/parts/button/template', null, array()); ?>
			</div>
		<?php endif; ?>

		<div class="movies-list" id="cbo-movies">
			<?php
				if ($last) {
					$args = [
						'post_type'	=> 'movies',
						'posts_per_page'	=> 999,
						'post_status'	=> 'publish',
					];
					$posts_query = new WP_Query($args);
					if ($posts_query->have_posts()) :
						while ($posts_query->have_posts()) : $posts_query->the_post();
							get_template_part('templates/parts/movie/template');
						endwhile;
						wp_reset_postdata();
					endif;

				} else {
					global $post;
					$posts = get_field('movies_list');
					if($posts):
						foreach( $posts as $post):
							setup_postdata($post);
							get_template_part('templates/parts/movie/template');
						endforeach;
						wp_reset_postdata();
					endif;
					setup_postdata($post);
				}
			?>
		</div>
	</div>
</section>