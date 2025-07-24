	</div><!-- End main -->

	<?php
		$baseline	= get_field('footer_baseline', 'option');
		$mail	= get_field('global_mail', 'option');
		$btlibelle	= get_field('footer_btlibelle', 'option');
		$bturl	= get_field('footer_bturl', 'option');
	?>

	<footer itemscope itemtype="http://schema.org/WPFooter" role="contentinfo">
		<div class="footer-inner cbo-container container--nomargin">
			<div class="footer-top">
				<?php if($baseline): ?>
					<div class="top-baseline cbo-title-2 slide-up">
						<?php echo $baseline ?>
					</div>
				<?php endif; ?>

				<div class="social-list">
					<?php
						if( have_rows('global_socials', 'option') ):
						while ( have_rows('global_socials', 'option') ) : the_row();
						$type	= get_sub_field('type_de_reseau');
						$url	= get_sub_field('url');
					?>
						<a class="list-el slide-up" href="<?php echo $url ?>" target="_blank">
							<i class="icon icon--<?php echo $type ?>"></i>
						</a>
					<?php
						endwhile;
						endif;
					?>
				</div>
			</div>

			<div class="footer-content">
				<nav class="content-nav slide-up" role="navigation" aria-label="<?php pll_e('Navigation annexe') ?>" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<?php wp_nav_menu( array(
						'theme_location' => 'menu-annexe',
					));?>
				</nav>
				<div class="content-infos">
					<div class="infos-address slide-up">
						<a class="infos-mail cbo-chapo slide-up" href="mailto:<?php echo $mail ?>">
							<?php echo $mail ?>
						</a>
					</div>
					<a class="cbo-button slide-up" href="<?php echo $bturl ?>">
						<span class="button-label">
							<?php echo $btlibelle ?>
						</span>
						<i class="icon icon--arrow-next"></i>
					</a>
				</div>
			</div>	
		</div>
		<div class="footer-accroche">
			<img
				decoding="async"
				src="<?php bloginfo('template_directory'); ?>/library/img/logo-footer.svg"
				alt="<?php echo get_bloginfo('description'); ?>" sizes="100vw"
				width="100%"
				loading="lazy"
			>
		</div>
	</footer>

	<link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet" type="text/css" />
	
	<?php wp_footer(); ?>
</body>
</html>