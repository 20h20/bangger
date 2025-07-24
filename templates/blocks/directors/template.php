<?php
	$title	= get_field('directors_title');
	$last = get_field('directors_all');
?>
<section class="cbo-directors">
	<div class="directors-inner cbo-container">
		<div class="directors-top">
			<?php if($title): ?>
				<div class="directors-title cbo-title-2 slide-up" itemprop="headline">
					<?php echo $title ?>
				</div>
			<?php endif; ?>
			<?php get_template_part('templates/parts/button/template', null, array()); ?>
		</div>

		<div class="directors-list">
			<?php
				if ($last) {
					$args = [
						'post_type'	=> 'directors',
						'posts_per_page'	=> 999,
						'post_status'	=> 'publish',
					];
					$posts_query = new WP_Query($args);
					if ($posts_query->have_posts()) :
						while ($posts_query->have_posts()) : $posts_query->the_post();
							get_template_part('templates/parts/director/template');
						endwhile;
						wp_reset_postdata();
					endif;

				} else {
					global $post;
					$posts = get_field('directors_list');
					if($posts):
						foreach( $posts as $post):
							setup_postdata($post);
							get_template_part('templates/parts/director/template');
						endforeach;
						wp_reset_postdata();
					endif;
					setup_postdata($post);
				}
			?>
		</div>
	</div>
</section>