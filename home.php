<?php
	if (function_exists('cbo_register_block_usage')) {
		cbo_register_block_usage('herosimple');
	}
	get_header();
	global $wp_query;
	$paged	= get_query_var('paged') ? get_query_var('paged') : 1;
	$posts_per_page = get_query_var('posts_per_page') ? get_query_var('posts_per_page') : get_option('posts_per_page');
	$total_posts	= $wp_query->found_posts;
	$articles_affiches = min($paged * $posts_per_page, $total_posts);
?>

<div class="cbo-page">
	<div class="cbo-page page--archive">
		<section class="cbo-herosimple">
			<div class="herosimple-inner cbo-container container--nomargin container--padding">
				<?php get_template_part('templates/parts/breadcrumb/template'); ?>

				<div class="herosimple-title cbo-title-1 slide-up" itemprop="headline">
					<h1>
						<?php
							if ( is_home() ) {
								$page_for_posts_id = get_option( 'page_for_posts' );
								echo get_the_title( $page_for_posts_id );
							}
						?>
						<?php if (is_paged()): ?>
							<span class="title-page slide-up"><?php current_paged(); ?></span>
						<?php endif; ?>
					</h1>
				</div>
			</div>
		</section>

		<section class="cbo-articles">
			<div class="articles-inner cbo-container container--small">
				<div class="articles-list">
					<?php
						global $post;
						if (have_posts()) :
						while (have_posts()) : the_post();
							get_template_part('templates/parts/article/template');
						endwhile;
						echo page_navi();
						endif;
					?>
				</div>
			</div>
		</section>
	</div>
</div>

<?php
	get_footer();
?>