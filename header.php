<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/library/img/fav/favicon-16x16.png">


	<?php
		$default_lang = 'en'; 
		$default_url = home_url('/en/our-directors/');

		if (function_exists('pll_get_post') && is_singular()) {
			$post_id = get_queried_object_id();
			$post_type = get_post_type($post_id);

			if ($post_type === 'casestudies') {
				$default_url = home_url('/en/case-studies/');
			}
			$translated_post_id = pll_get_post($post_id, $default_lang);
			if (!empty($translated_post_id)) {
				$default_url = get_permalink($translated_post_id);
			}
		} elseif (is_tax() && function_exists('pll_get_term')) {
			$term = get_queried_object();
			$translated_term_id = pll_get_term($term->term_id, $default_lang);

			if (!empty($translated_term_id)) {
				$default_url = get_term_link($translated_term_id);
			}
		} elseif (is_post_type_archive('casestudies')) {
			$default_url = home_url('/en/case-studies/');
		}
	?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

	<header role="banner" itemscope itemtype="http://schema.org/WPHeader">
		<div class="header-inner">
			<a class="header-logo cbo-picture-contain" title="<?php echo get_bloginfo('description'); ?>" href="<?php echo home_url(); ?>" itemprop="url">
				<img
					decoding="async"
					src="<?php bloginfo('template_directory'); ?>/library/img/bangger-baseline.svg"
					alt="<?php echo get_bloginfo('description'); ?>" sizes="100vw"
					width="150" height="55"
					itemprop="logo"
					fetchpriority="high"
				>
			</a>

			<div class="header-right">
				<nav class="header-nav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement" aria-label="Navigation principale">
					<?php wp_nav_menu( array(
						'container' => false,
						'container_class' => '',
						'menu_class' => 'cbo-menu',
						'theme_location' => 'primary-menu',
					));?>
				</nav>

				<ul class="languages-switcher" itemscope itemtype="http://schema.org/Language">
					<?php
						$languages = pll_the_languages( array('show_flags' => 0, 'show_names' => 1, 'echo' => 0) );
						echo $languages;
					?>
				</ul>

				<button type="button" class="burger-menu" aria-label="Ouvrir la navigation principale">
					<span class="top"></span>
					<span class="middle"></span>
					<span class="bottom"></span>
				</button>
			</div>
		</div>
	</header>

	<main class="cbo-main" role="main" itemscope itemtype="http://schema.org/WebPageElement">
		<div class="cbo-overlay"></div>