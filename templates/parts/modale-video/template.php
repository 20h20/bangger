<?php
	$post_id = get_the_ID();
	$video = get_field('movie_video', $post_id);
	$realisateur = get_field('movie_director', $post_id);
	if (!$video) return;
?>
<div id="modal-<?php echo esc_attr($post_id); ?>" class="cbo-modale">
	<div class="modale-inner">
		<button type="button" class="modale-close" aria-label="<?php echo esc_attr(pll__('Fermer la modale')); ?>">
			<span class="close-label">
				<?php pll_e('Fermer') ?>
			</span>
			<i class="icon icon--close"></i>
		</button>

		<div class="modale-content">
			<?php if ($realisateur): ?>
				<span class="content-director cbo-title-4">
					<?php echo esc_html(get_the_title($realisateur->ID)); ?>
				</span>
			<?php endif; ?>
			<h3 class="content-title cbo-title-4" itemprop="name">
				<?php echo esc_html(get_the_title($post_id)); ?>
			</h3>
		</div>

		<div class="inner-video custom-video cbo-picture-cover">
			<!-- <img
				class="video-cover"
				decoding="async"
				loading="lazy"
				src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'xlarge')); ?>"
				srcset="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'xlarge')); ?> 320w, <?php echo esc_url(get_the_post_thumbnail_url($post_id, 'xlarge')); ?> 768w, <?php echo esc_url(get_the_post_thumbnail_url($post_id, 'xlarge')); ?> 1024w"
				alt="<?php echo esc_attr($video['title']); ?>"
				sizes="100vw"
				width="2000"
				height="2000"
			/> -->

			<div itemscope itemtype="https://schema.org/VideoObject">
				<meta itemprop="name" content="<?php echo esc_attr($video['title']); ?>">
				<meta itemprop="description" content="<?php echo esc_attr($video['description']); ?>">
				<meta itemprop="uploadDate" content="<?php echo esc_attr(date('Y-m-d', strtotime($video['date']))); ?>">
				<meta itemprop="thumbnailUrl" content="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'xlarge')); ?>">
				<meta itemprop="embedUrl" content="<?php echo esc_url($video['url']); ?>">
				<meta itemprop="width" content="1920">
				<meta itemprop="height" content="1080">
				<meta itemprop="publisher" content="Bangger">
				<video preload="metadata" playsinline aria-label="<?php echo esc_attr(pll__('Lecteur vidéo')); ?>"  poster="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'xlarge')); ?>">
					<source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
				</video>
			</div>

			<div class="custom-controls">
				<button class="playPause" aria-label="<?php pll_e('Lire la vidéo') ?>">
					<i class="icon icon--player"></i>
				</button>
				<input type="range" class="seekBar" value="0" aria-label="<?php pll_e('Barre de progression') ?>">
				<button class="muteToggle" aria-label="<?php pll_e('Mettre le son') ?>">
					<i class="icon icon--sound-on"></i>
				</button>
				<button class="fullscreenToggle" aria-label="<?php pll_e('Mettre en plein écran') ?>">
					<i class="icon icon--fullscreen"></i>
				</button>
			</div>
		</div>
	</div>
</div>