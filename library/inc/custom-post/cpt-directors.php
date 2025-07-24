<?php
    function cbo_directors() { 

		// Définition des slugs par défaut
		$single_slug = 'director';
		$archive_slug = 'our-directors';
	
		// Appliquer les slugs spécifiques à la langue via Polylang
		if (function_exists('pll_current_language')) {
			$current_lang = pll_current_language();
			if ($current_lang == 'fr') {
				$single_slug = 'realisateur';
				$archive_slug = 'nos-realisateurs';
			}
		}

        register_post_type( 'directors',
            array(
                'labels' => array(
                    'name' => __( 'Nos réalisateurs', 'bonestheme' ),
					'singular_name' => __( 'Réalisateur', 'bonestheme' ),
					'all_items' => __( 'Tous les réalisateurs', 'bonestheme' ), 
					'add_new' => __( 'Ajouter', 'bonestheme' ), 
					'add_new_item' => __( 'Ajouter un réalisateur', 'bonestheme' ),
					'edit' => __( 'Modifier', 'bonestheme' ),
					'edit_item' => __( 'Modifier un réalisateur', 'bonestheme' ),
					'new_item' => __( 'Nouveau réalisateur', 'bonestheme' ),
					'view_item' => __( 'Voir le réalisateur', 'bonestheme' ),
					'search_items' => __( 'Rechercher', 'bonestheme' ),
					'not_found' =>  __( 'Aucun réalisateur trouvé.', 'bonestheme' ),
					'not_found_in_trash' => __( 'Aucun réalisateur dans la corbeille', 'bonestheme' ),
					'parent_item_colon' => ''
                ),
				'description' => __( 'Ceci est un réalisateur d\'exemple', 'bonestheme' ),
				'public' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				'show_ui' => true,
				'query_var' => true,
				'menu_position' => 3, 
				'menu_icon' => 'dashicons-video-alt',
				'rewrite' => array('slug' => $single_slug, 'with_front' => false),
						'has_archive' => $archive_slug,
				'capability_type' => 'post',
				'hierarchical' => false,
				'show_in_rest' => true,
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'), 
            )
        );

        register_taxonomy( 'directors_cat', 
            array('directors'),
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

	add_action('init', 'cbo_directors', 1);

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
		$fr_archive_url = home_url('/nos-realisateurs/');
		$en_archive_url = home_url('/en/our-directors/');

		if ($current_lang === 'fr') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/en\/our-directors\//',
				'href="' . $en_archive_url,
				$output
			);
		} elseif ($current_lang === 'en') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/our-directors\//',
				'href="' . $fr_archive_url,
				$output
			);
		}
		return $output;
	});

	///// Select slugs FR to EN
	add_filter('pll_the_languages', function ($output) {
		$current_lang = pll_current_language();
		$fr_archive_url = home_url('/nos-realisateurs/');
		$en_archive_url = home_url('/en/our-directors/');

		if ($current_lang === 'fr') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/en\/nos-realisateurs\//',
				'href="' . $en_archive_url,
				$output
			);
		} elseif ($current_lang === 'en') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/nos-realisateurs\//',
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
		if (is_singular('directors') && $current_language == 'fr') {
			$head_content = str_replace('/en/realisateur/', '/en/director/', $head_content);
			$head_content = str_replace('/fr/director/', '/fr/realisateur/', $head_content);
		}
		if (is_singular('directors') && $current_language == 'en') {
			$head_content = str_replace('/director/', '/realisateur/', $head_content);
			$head_content = str_replace('/en/realisateur/', '/en/director/', $head_content);
		}

		// Modifications archives
		if (is_post_type_archive('directors') || is_tax('directors_cat')) {
			if ($current_language == 'fr') {
				$head_content = str_replace('/en/nos-realisateurs/', '/en/our-directors/', $head_content);
				$head_content = str_replace('/fr/our-directors/', '/fr/nos-realisateurs/', $head_content);
			}
			if ($current_language == 'en') {
				$head_content = str_replace('/our-directors/', '/nos-realisateurs/', $head_content);
				$head_content = str_replace('/en/nos-realisateurs/', '/en/our-directors/', $head_content);
			}
		}
		echo $head_content;
	}, 100);


	///////////////////////////// Polylang Single Flag url /////////////////////////////
	add_filter('pll_the_languages', function ($output) {
		$current_lang = pll_current_language();
		if ($current_lang === 'fr') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/en\/realisateur\//',
				'href="http://bangger.com/en/director/',
				$output				
			);
		} elseif ($current_lang === 'en') {
			$output = preg_replace(
				'/href="http:\/\/bangger.com\/director\//',
				'href="http://bangger.com/realisateur/',
				$output
			);
		}
		return $output;
	});
?>