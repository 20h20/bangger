<?php
	$realisateur = get_field('movie_director', get_the_ID());
	$video = get_field('movie_video', get_the_ID());
?>
<article <?php post_class('list-el'); ?> itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting" data-modal-id="modal-<?php echo get_the_ID(); ?>">
	<span class="el-inner">
		<span class="inner-picture cbo-picture-cover" 
			data-video-url="<?php echo esc_url($video['url']); ?>"
			data-video-title="<?php echo esc_attr($video['title']); ?>"
			data-video-description="<?php echo esc_attr($video['description']); ?>"
			data-video-date="<?php echo date('Y-m-d', strtotime($video['date'])); ?>"
			data-video-thumbnail="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'xlarge')); ?>"
		>
			<img class="video-cover" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'xlarge')); ?>" alt="" />
			<meta itemprop="name" content="<?php echo esc_attr($video['title']); ?>">
			<meta itemprop="description" content="<?php echo esc_attr($video['description']); ?>">
			<meta itemprop="uploadDate" content="<?php echo date('Y-m-d', strtotime($video['date'])); ?>">
			<meta itemprop="thumbnailUrl" content="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'xlarge')); ?>">
			<meta itemprop="interactionCount" content="12345">
			<meta itemprop="publisher" content="Bangger">
		</span>

		<span class="inner-content">
			<span class="content-infos">
				<h3 class="content-title" itemprop="name">
					<?php the_title(); ?>
				</h3>
				<?php if ($realisateur && !is_singular('directors')): ?>
					<span class="content-director cbo-title-4">
						<?php echo get_the_title($realisateur->ID); ?>
					</span>
				<?php endif; ?>
			</span>
		</span>
	</span>
</article>
<div class="movie-cursor">
	<div class="cursor-inner">
		Play
	</div>
</div>
<?php get_template_part('templates/parts/modale-video/template'); ?>