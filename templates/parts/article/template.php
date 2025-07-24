<?php
	$excerpt = get_the_excerpt();
	$limited_excerpt = wp_trim_words($excerpt, 25, '...');
?>
<article <?php post_class('list-el'); ?> itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
	<a class="el-inner" href="<?php the_permalink(); ?>" itemprop="url">
		<span class="el-content">
			<span class="content-top">
				<time class="top-date slide-up" itemprop="datePublished" datetime="<?php echo get_the_date(); ?>">
					<?php echo get_the_date('M Y'); ?>
				</time>

				<h3 class="top-title cbo-title-3 slide-up" itemprop="headline">
					<?php the_title(); ?>
				</h3>
			</span>

			<span class="content-bottom slide-up" itemprop="description">
				<span class="bottom-text">
					<?php echo $limited_excerpt; ?>
				</span>
				<span class="cbo-button">
					<?php pll_e('Lire l\'article') ?>
				</span>
			</span>
		</span>
		<span class="el-picture cbo-picture-cover">
			<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('medium', array('sizes' => '(max-width:320px) 145px, (max-width:425px) 220px, 500px', 'itemprop' => 'image'));
				} else {
					echo '<img src="' . get_template_directory_uri() . '/library/img/bangger-logo.png" class="picture-default" alt="Bangger" itemprop="image">';
				}
			?>
		</span>
	</a>
</article>