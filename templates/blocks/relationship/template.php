<?php
	$slidetxt = get_field('relationship_slidetxt');
	$mode = get_field('relationship_mode');
	$posts = get_field('relationship_list');
	$category = get_field('relationship_category');
?>
<section class="cbo-relationship">
	<?php if($slidetxt): ?>
		<div class="relationship-textslide slide-up">
			<div class="textslide-wrap">
				<?php for ($i = 0; $i < 10; $i++) : ?>
					<span><?php echo $slidetxt; ?></span>
				<?php endfor; ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="relationship-inner cbo-container container--small">
		<?php get_template_part('templates/parts/button/template', null, array()); ?>

		<div class="articles-list relationship-list slide-up">
			<?php
				global $post;
				$original_post = $post;
				if( $mode === 'manual' && !empty($posts) && is_array($posts) ):
					foreach( $posts as $post ):
						if ( $post instanceof WP_Post ) {
							setup_postdata($post);
							get_template_part('templates/parts/article/template');
						}
					endforeach;
				elseif( $mode === 'latest' ):
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 6,
					);
					$query = new WP_Query($args);
					if( $query->have_posts() ):
						while( $query->have_posts() ): $query->the_post();
							get_template_part('templates/parts/article/template');
						endwhile;
					endif;
					wp_reset_postdata();
				endif;

				if ( $original_post instanceof WP_Post ) {
					$post = $original_post;
					setup_postdata($post);
				} else {
					wp_reset_postdata();
				}
			?>
		</div>
	</div>
</section>