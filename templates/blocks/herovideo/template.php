<?php
	$video	= get_field('herovideo_video');
	$videomobile	= get_field('herovideo_videomobile');
?>
<section class="cbo-herovideo herovideo--blocks">
	<div class="herovideo-inner">
		<div class="herovideo-content cbo-container container--nomargin">
			<div class="content-text typing-slider">
				<?php
					if (have_rows('herovideo_content')) :
						$titles = [];
						$has_uptitle = false;
						$first_uptitle = '';
						$index = 0;

						while (have_rows('herovideo_content')) : the_row();
							$uptitle = get_sub_field('uptitle');
							$title = get_sub_field('title');
							if ($index === 0 && $uptitle) {
								$has_uptitle = true;
								$first_uptitle = $uptitle;
							}
							if ($title) {
								$titles[] = $title;
							}
							$index++;
						endwhile;
					endif;
				?>
					<?php if ($has_uptitle): ?>
						<div class="herovideo-uptitle slide-up">
							<?php echo esc_html($first_uptitle); ?>
						</div>
					<?php endif; ?>

					<div class="herovideo-title-wrapper">
						<div class="herovideo-title slide-up" id="typing-text" itemprop="headline">
							<?php echo esc_html($titles[0] ?? ''); ?>
						</div>
					</div>

				<script>
					const titles = <?php echo json_encode($titles); ?>;
				</script>
			</div>
		</div>

		<div class="herovideo-box herovideo--desktop cbo-picture-cover">
			<video
				autoplay="autoplay"
				preload="auto"
				muted
				itemprop="video"
				loop
				itemscope itemtype="http://schema.org/VideoObject"
				onmouseenter="event.target.setAttribute('preload','metadata')"
			>
				<source
					type="video/mp4"
					src="<?php echo $video['url'] ?>"
					itemprop="contentUrl"
				>
			</video>
		</div>
		<div class="herovideo-box herovideo--mobile cbo-picture-cover">
			<video
				autoplay
				muted
				playsinline
				loop
				preload="auto"
				itemprop="video"
				itemscope itemtype="http://schema.org/VideoObject"
				onmouseenter="event.target.setAttribute('preload','metadata')"
			>
				<source
					type="video/mp4"
					src="<?php echo esc_url($videomobile['url']); ?>"
					itemprop="contentUrl"
				>
			</video>
		</div>
	</div>

	<div class="herovideo-full cbo-picture-cover">
		<video
			autoplay
			muted
			playsinline
			loop
			preload="auto"
			itemprop="video"
			itemscope itemtype="http://schema.org/VideoObject"
			onmouseenter="event.target.setAttribute('preload','metadata')"
		>
			<source
				type="video/mp4"
				src="<?php echo esc_url($video['url']); ?>"
				itemprop="contentUrl"
			>
		</video>
	</div>
</section>