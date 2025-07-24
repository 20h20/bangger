<?php
	function bones_ahoy() {
		require_once( 'library/inc/custom-cleanup.php' );
		require_once( 'library/inc/custom-admin.php' );
		require_once( 'library/inc/custom-dashboard.php' );
		require_once( 'library/inc/styles-import.php' );
		require_once( 'library/inc/acf.php' );
		require_once( 'library/inc/custom-post/cpt-directors.php' );
		require_once( 'library/inc/custom-post/cpt-movies.php' );
	}
	add_action( 'after_setup_theme', 'bones_ahoy' );

	/* ************************* */
	// Pic size
	/* ************************* */
	add_action('after_setup_theme', function() {
		add_image_size('xsmall', 320, 320, false);
		add_image_size('small', 768, 768, false);
		add_image_size('medium', 1200, 1200, false);
		add_image_size('xlarge', 1920, 1920, false);
	});


	/* ************************* */
	// Add `loading="lazy"` attribute to images output by the_post_thumbnail().
	/* ************************* */
	add_filter( 'post_thumbnail_html', 'wpdd_modify_post_thumbnail_html', 10, 5 );
	
	function wpdd_modify_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		return str_replace( '<img', '<img loading="lazy"', $html );
	}

	/* ************************* */
	// Removing autoP from CF7
	/* ************************* */
	add_filter('wpcf7_autop_or_not', '__return_false');


	/* ************************* */
	/* AJOUT OPTIONS AU DASHBOARD */
	/* ************************* */
	add_action('acf/init', function() {
		if ( function_exists('acf_add_options_page') ) {
			acf_add_options_page();
		}
	});


	/* ************************* */
	// Register menu
	/* ************************* */
	function register_my_menu() {
		register_nav_menu('primary-menu',__( 'Menu Principal' ));
		register_nav_menu('menu-annexe',__( 'Menu Annexe' ));
	}
	add_action( 'init', 'register_my_menu' );


	/* ************************* */
	/* CRÉATION PAGINATION */
	/* ************************* */
	function page_navi($before = '', $after = '') {
		global $wpdb, $wp_query;
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
		if ( $numposts <= $posts_per_page ) { return; }
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = 7;
		$pages_to_show_minus_1 = $pages_to_show-1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		echo $before.'<nav class="pagination-container" aria-label="Pagination"><ul class="cbo-pagination">'."";

		$prevposts = get_previous_posts_link('<i class="icon icon--arrow-next"></i>');
		if($prevposts) {
			$prevposts = str_replace('<a ', '<a rel="prev" ', $prevposts);
			echo '<li class="cbo-paginate-prev">' . $prevposts  . '</li>';
		}
		else { echo '<li class="disabled"><span aria-disabled="true"><i class="icon icon--arrow-next"></i></span></li>'; }

		for($i = $start_page; $i  <= $end_page; $i++) {
			if($i == $paged) {
				echo '<li class="active"><a href="#" aria-current="page">'.$i.'</a></li>';
			} else {
				echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
			}
		}

		$nextposts = get_next_posts_link('<i class="icon icon--arrow-next"></i>');
		if($nextposts) {
			$nextposts = str_replace('<a ', '<a rel="next" ', $nextposts);
			echo '<li class="cbo-paginate-next">' . $nextposts  . '</li>';
		}
		else { echo '<li class="disabled"><span aria-disabled="true"><i class="icon icon--arrow-next"></i></span></li>'; }
		
		echo '</ul></nav>'.$after."";
	}


	/* ************************* */
	/* Add styles to wysiwyg editor */
	/* ************************* */
	function add_style_select_button($buttons) {
		array_unshift($buttons, 'styleselect');
		return $buttons;
	}
	add_filter('mce_buttons_2', 'add_style_select_button');
	function my_mce_before_init_insert_formats( $init_array ) {
		$style_formats = array(
			array(
				'title' => 'Bouton blanc',
				'block' => 'a',
				'classes' => 'cbo-button',
				'wrapper' => true,
				'attributes' => array(
					'href' => '#'
				)
			),
			array(
				'title' => 'Bouton bordure blanche',
				'block' => 'a',
				'classes' => 'cbo-button button--border',
				'wrapper' => true,
				'attributes' => array(
					'href' => '#'
				)
			),
		);
		$init_array['style_formats'] = json_encode( $style_formats );
		return $init_array;
	}
	add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

	/* ************************* */
	/* CUSTOM LOGIN */
	/* ************************* */
	function childtheme_custom_login() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/library/css/style.min.css" />';
	}
	add_action('login_head', 'childtheme_custom_login');


	/* ************************* */
	// Add a custom tool bar
	/* ************************* */
	function custom_acf_wysiwyg_toolbar($toolbars) {
		$toolbars['Custom'] = [];
		$toolbars['Custom'][1] = ['bold', 'formatselect', 'underline'];
		return $toolbars;
	}
	add_filter('acf/fields/wysiwyg/toolbars', 'custom_acf_wysiwyg_toolbar');


	/* ************************* */
	/* CURRENT PAGE FOR ARCHIVE */
	/* ************************* */
	function current_paged( $var = '' ) {
		if( empty( $var ) ) {
			global $wp_query;
			if( !isset( $wp_query->max_num_pages ) )
				return;
			$pages = $wp_query->max_num_pages;
		}
		else {
			global $$var;
				if( !is_a( $$var, 'WP_Query' ) )
					return;
			if( !isset( $$var->max_num_pages ) || !isset( $$var ) )
				return;
			$pages = absint( $$var->max_num_pages );
		}
		if( $pages < 1 )
			return;
		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		echo 'Page ' . $page ;
	}
	

	/* ************************* */
	/* MEGA MENU - DIRECTORS */
	/* ************************* */
	add_filter('walker_nav_menu_start_el', 'inject_mega_menu_directors', 10, 4);
	function inject_mega_menu_directors($item_output, $item, $depth, $args) {
		if (in_array('has-mega-menu-directors', $item->classes)) {
			ob_start(); ?>
			<div class="mega-menu" id="mega-menu-directors">
				<div class="categories-list tags-list">
					<?php
					$terms = get_terms([
						'taxonomy' => 'directors_cat',
						'hide_empty' => false,
					]);
					foreach ($terms as $term) {
						echo '<div class="list-el" data-term-id="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</div>';
					}
					?>
				</div>
				<div class="items-list">
					<?php
					$directors = new WP_Query([
						'post_type' => 'directors',
						'posts_per_page' => -1,
					]);
					if ($directors->have_posts()) {
						while ($directors->have_posts()) {
							$directors->the_post();
							$terms = get_the_terms(get_the_ID(), 'directors_cat');
							$term_ids = [];

							if ($terms && !is_wp_error($terms)) {
								foreach ($terms as $term) {
									$term_ids[] = $term->term_id;
								}
							}
							echo '<div class="list-item" data-term-ids="' . esc_attr(implode(',', $term_ids)) . '">';
							echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
							echo '</div>';
						}
						wp_reset_postdata();
					}
					?>
				</div>
			</div>

		<?php
			$mega_menu_html = ob_get_clean();
			$item_output .= $mega_menu_html;
		}

		return $item_output;
	}


	/* ************************* */
	/* Ajax sur les filtres */
	/* ************************* */
	add_action('wp_ajax_filter_directors', 'ajax_filter_items');
	add_action('wp_ajax_nopriv_filter_directors', 'ajax_filter_items');
	add_action('wp_ajax_filter_movies', 'ajax_filter_items');
	add_action('wp_ajax_nopriv_filter_movies', 'ajax_filter_items');

	function ajax_filter_items() {
		$post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'directors';
		if (!in_array($post_type, ['directors', 'movies'])) {
			wp_send_json_error('Post type invalide.');
			wp_die();
		}
		$category_slug = isset($_POST['category_slug']) ? sanitize_text_field($_POST['category_slug']) : '';
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => -1,
		);
		$taxonomy = $post_type === 'directors' ? 'directors_cat' : 'movies_cat';
		if ($category_slug && $category_slug !== 'tous') {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $category_slug,
				),
			);
		}
		$query = new WP_Query($args);
		error_log("[$post_type] Articles trouvés : " . $query->found_posts);

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				if ($post_type === 'directors') {
					get_template_part('templates/parts/director/template');
				} else {
					get_template_part('templates/parts/movie/template');
				}
			}
		} else {
			echo '<p>Aucun résultat pour la catégorie : ' . esc_html($category_slug) . '</p>';
		}
		wp_reset_postdata();
		wp_die();
	}


	/* ************************* */
	/* Ajax sur le chargement des vidéos - Page archive et Taxo */
	/* ************************* */
	add_action('wp_ajax_cbo_load_more_movies', 'cbo_load_more_movies');
	add_action('wp_ajax_nopriv_cbo_load_more_movies', 'cbo_load_more_movies');

	function cbo_load_more_movies() {
		check_ajax_referer('cbo_load_more_nonce', 'nonce');

		$paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$category_slug = isset($_POST['category_slug']) ? sanitize_text_field($_POST['category_slug']) : '';
		$taxonomy = 'movies_cat'; // uniquement pour le post type movies

		$args = [
			'post_type'      => 'movies',
			'post_status'    => 'publish',
			'posts_per_page' => 6,
			'paged'          => $paged,
		];

		if ($category_slug && $category_slug !== 'tous') {
			$args['tax_query'] = [
				[
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $category_slug,
				],
			];
		}

		$query = new WP_Query($args);

		if ($query->have_posts()) {
			ob_start();
			while ($query->have_posts()) {
				$query->the_post();
				get_template_part('templates/parts/movie/template');
			}
			wp_reset_postdata();

			wp_send_json_success([
				'content'   => ob_get_clean(),
				'max_page'  => $query->max_num_pages,
			]);
		} else {
			wp_send_json_error('Aucun autre article.');
		}
	}

	
	function theme_enqueue_scripts() {
		wp_enqueue_script('scripts', get_template_directory_uri() . '/library/js/scripts.js', array(), null, true);

		wp_localize_script('scripts', 'cbo_ajax_object', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('cbo_load_more_nonce'),
		));
	}
	add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


	/* ************************* */
	/* TRANSLATE KEYS */
	/* ************************* */
	add_action('init', function() {
		pll_register_string( 'global', "Lire l\'article");
		pll_register_string( 'global', "Navigation annexe");
		pll_register_string( 'global', "Fermer la modale");
		pll_register_string( 'global', "Fermer");
		pll_register_string( 'global', "Tous");
		pll_register_string( 'global', "Filtrer par catégorie");
		pll_register_string( 'global', "Envoyer une vidéo");
		pll_register_string( 'global', "Envoyer");
		pll_register_string( 'global', "Joindre un fichier");

		pll_register_string( '404', "Erreur 404");
		pll_register_string( '404', "La page que vous rechechez n\'existe pas.<br />Vous pouvez toujours revenir sur vos pas.");
		pll_register_string( '404', "Revenir à l\'accueil");

		pll_register_string( 'vidéo', "Lire la vidéo");
		pll_register_string( 'vidéo', "Mettre le son");
		pll_register_string( 'vidéo', "Mettre en plein écran");
		pll_register_string( 'vidéo', "Portfolio");
	});





	/* ************************* */
	/* Titles des pages archive */
	/* ************************* */
	add_filter('rank_math/frontend/title', function($title) {
		if (!function_exists('pll_current_language')) {
			return $title;
		}
		$lang = pll_current_language();
		$uri  = $_SERVER['REQUEST_URI'];

		// Archive Movies
		if (is_post_type_archive('movies')) {
			if ($lang === 'fr' && strpos($uri, '/nos-films') !== false) {
				return 'Nos films, vos Bangger !';
			}
			if ($lang === 'en' && strpos($uri, '/our-films') !== false) {
				return 'Our films, your Bangger!';
			}
		}

		// Archive Directors
		if (is_post_type_archive('directors')) {
			if ($lang === 'fr' && strpos($uri, '/nos-realisateurs') !== false) {
				return 'Nos réalisateurs'; 
			}
			if ($lang === 'en' && strpos($uri, '/our-directors') !== false) {
				return 'Our directors';
			}
		}
	
		return $title;
	});
	
?>