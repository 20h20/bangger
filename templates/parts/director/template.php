<?php
	$post_id = get_the_ID(); 
	$firstname = get_field('director_firstname', $post_id);
	$lastname = get_field('director_lastname', $post_id);
	$video = get_field('director_video', $post_id);

	$categories = get_the_terms( $post_id, 'directors_cat' );
	$categories_list = '';
	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $category ) {
			$categories_list .= '<span class="list-el">' . esc_html( $category->name ) . '</span>';
		}
	}
?>
<a href="<?php the_permalink(); ?>" itemprop="url" <?php post_class('list-el'); ?>>
	<span class="el-inner" <?php if($video): ?>data-video="<?php echo esc_url($video['url']); ?>"<?php endif; ?>>
		<span class="el-content">
			<span class="content-firstname cbo-title-5">
				<?php echo $firstname ?>
			</span>
			<span class="content-lastname cbo-title-2">
				<?php echo $lastname ?>
			</span>
		</span>
		<span class="tags-list">
			<?php echo $categories_list; ?>
		</span>
	</span>
</a>

<?php if($video): ?>
	<div class="el-video cbo-picture-cover">
		<video muted loop playsinline>
			<source
				loading="lazy"
				type="video/mp4"
				src="<?php echo esc_url($video['url']); ?>"
				itemprop="contentUrl"
				preload="none"
			>
		</video>
	</div>
<?php endif; ?>