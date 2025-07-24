<?php
    function cbo_movies() { 

		// Définition des slugs par défaut
		$single_slug = 'film';
		$archive_slug = 'our-films';
	
		// Appliquer les slugs spécifiques à la langue via Polylang
		if (function_exists('pll_current_language')) {
			$current_lang = pll_current_language();
			if ($current_lang == 'fr') {
				$single_slug = 'film';
				$archive_slug = 'nos-films';
			}
		}

        register_post_type( 'movies',
            array(
                'labels' => array(
                    'name' => __( 'Nos films', 'bonestheme' ),
					'singular_name' => __( 'Film', 'bonestheme' ),
					'all_items' => __( 'Tous les films', 'bonestheme' ), 
					'add_new' => __( 'Ajouter', 'bonestheme' ), 
					'add_new_item' => __( 'Ajouter un film', 'bonestheme' ),
					'edit' => __( 'Modifier', 'bonestheme' ),
					'edit_item' => __( 'Modifier un film', 'bonestheme' ),
					'new_item' => __( 'Nouveau film', 'bonestheme' ),
					'view_item' => __( 'Voir le film', 'bonestheme' ),
					'search_items' => __( 'Rechercher', 'bonestheme' ),
					'not_found' =>  __( 'Aucun film trouvé.', 'bonestheme' ),
					'not_found_in_trash' => __( 'Aucun film dans la corbeille', 'bonestheme' ),
					'parent_item_colon' => ''
                ),
				'description' => __( 'Ceci est un film d\'exemple', 'bonestheme' ),
				'public' => false,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_position' => 3, 
				'menu_icon' => 'dashicons-welcome-view-site',
				'rewrite' => array('slug' => $single_slug, 'with_front' => false),
				'has_archive' => $archive_slug,
				'capability_type' => 'post',
				'hierarchical' => false,
				'show_in_rest' => true,
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'), 
            )
        );

        register_taxonomy( 'movies_cat', 
            array('movies'),
            array(
                'hierarchical' => true, 
                'labels' => array(
                    'name' => __( 'Catégories', 'bonestheme' ),
                    'singular_name' => __( 'Catégorie', 'bonestheme' ),
                    'search_items' => __( 'Rechercher', 'bonestheme' ),
                    'all_items' => __( 'Toutes les catégories', 'bonestheme' ),
                    'parent_item' => __( 'Catégories parentes', 'bonestheme' ),
                    'parent_item_colon' => __( 'Catégorie parente', 'bonestheme' ),
                    'edit_item' => __( 'Modifier la catégorie', 'bonestheme' ),
                    'update_item' => __( 'Mettre à jour', 'bonestheme' ),
                    'add_new_item' => __( 'Ajouter', 'bonestheme' ),
                    'new_item_name' => __( 'Nouveau nom', 'bonestheme' )
                ),
                'show_admin_column' => true,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => array( 'slug' => $archive_slug ),
            )
        );
        flush_rewrite_rules();
    }

	add_action('init', 'cbo_movies', 1);

    if ( ! function_exists( 'cbo_flush_rewrite_rules_case' ) ) {
		function cbo_flush_rewrite_rules_case() {
			flush_rewrite_rules();
		}
	}
	add_action( 'after_switch_theme', 'cbo_flush_rewrite_rules_case' );


	///////////////////////////// SLUGS /////////////////////////////
	//// Select slugs EN to FR
	add_filter('pll_the_languages', function ($output) {
		$current_lang = pll_current_language();
		$fr_archive_url = home_url('/nos-films/');
		$en_archive_url = home_url('/en/our-films/');

		if ($current_lang === 'fr') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/en\/our-films\//',
				'href="' . $en_archive_url,
				$output
			);
		} elseif ($current_lang === 'en') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/our-films\//',
				'href="' . $fr_archive_url,
				$output
			);
		}
		return $output;
	});

	///// Select slugs FR to EN
	add_filter('pll_the_languages', function ($output) {
		$current_lang = pll_current_language();
		$fr_archive_url = home_url('/nos-films/');
		$en_archive_url = home_url('/en/our-films/');

		if ($current_lang === 'fr') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/en\/nos-films\//',
				'href="' . $en_archive_url,
				$output
			);
		} elseif ($current_lang === 'en') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/nos-films\//',
				'href="' . $fr_archive_url,
				$output
			);
		}
		return $output;
	});


	///////////////////////////// href lang /////////////////////////////
	add_action('get_header', function () {
		ob_start();
	}, 1);

	add_action('wp_head', function () {
		$head_content = ob_get_clean();
		$current_language = function_exists('pll_current_language') ? pll_current_language() : 'fr';
		// Modifications single
		if (is_singular('movies') && $current_language == 'fr') {
			$head_content = str_replace('/en/film/', '/en/film/', $head_content);
			$head_content = str_replace('/fr/film/', '/fr/film/', $head_content);
		}
		if (is_singular('movies') && $current_language == 'en') {
			$head_content = str_replace('/film/', '/film/', $head_content);
			$head_content = str_replace('/en/film/', '/en/film/', $head_content);
		}

		// Modifications archives
		if (is_post_type_archive('movies') || is_tax('movies_cat')) {
			if ($current_language == 'fr') {
				$head_content = str_replace('/en/nos-films/', '/en/our-films/', $head_content);
				$head_content = str_replace('/fr/our-films/', '/fr/nos-films/', $head_content);
			}
			if ($current_language == 'en') {
				$head_content = str_replace('/our-films/', '/nos-films/', $head_content);
				$head_content = str_replace('/en/nos-films/', '/en/our-films/', $head_content);
			}
		}
		echo $head_content;
	}, 100);


	///////////////////////////// Polylang Single Flag url /////////////////////////////
	add_filter('pll_the_languages', function ($output) {
		$current_lang = pll_current_language();
		if ($current_lang === 'fr') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/en\/film\//',
				'href="http://bangger.com/en/film/',
				$output				
			);
		} elseif ($current_lang === 'en') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/film\//',
				'href="http://bangger.com/film/',
				$output
			);
		}
		return $output;
	});
?>