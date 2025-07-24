<?php
	if (function_exists('cbo_register_block_usage')) {
		cbo_register_block_usage('herovideo');
	}
	get_header();
	$post_id = get_the_ID(); 
	$firstname = get_field('director_firstname', $post_id);
	$lastname = get_field('director_lastname', $post_id);
	$video = get_field('director_video', $post_id);
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('cbo-page page--single'); ?>>
		<section class="cbo-herovideo herovideo--single">
			<div class="herovideo-inner">
				<div class="herovideo-content cbo-container container--nomargin">
					<div class="content-text">
						<?php if($firstname): ?>
							<div class="herovideo-uptitle slide-up">
								<?php echo $firstname ?>
							</div>
						<?php endif; ?>

						<?php if($lastname): ?>
							<div class="herovideo-title-wrapper">
								<div class="herovideo-title slide-up" itemprop="headline">
									<?php echo $lastname ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="herovideo-box cbo-picture-cover">
					<video
						autoplay="autoplay"
						preload="none"
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
			</div>

			<div class="herovideo-full cbo-picture-cover">
				<video
					autoplay="autoplay"
					preload="none"
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
		</section>

		<?php
			while (have_posts()) : the_post();
				the_content();
			endwhile;
		?>
	</article>
<?php
	get_footer();
?>