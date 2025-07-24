<?php
	// Initialisation du tableau global des blocs utilisés
	if (!isset($GLOBALS['cbo_used_blocks'])) {
		$GLOBALS['cbo_used_blocks'] = array();
	}

	// Ajouter l'action pour charger les styles et blocs
	add_action('wp_enqueue_scripts', 'cbo_scripts_and_styles', 20);

	// Enregistrer un bloc utilisé
	function cbo_register_block_usage($block_name) {
		if (!in_array($block_name, $GLOBALS['cbo_used_blocks'])) {
			$GLOBALS['cbo_used_blocks'][] = $block_name;
		}
	}

	/* ****************** */
	/* Load Frontend styles */
	function cbo_scripts_and_styles() {
		global $cbo_used_blocks;

		if (!is_admin()) {
			$css_blocks_path = get_stylesheet_directory() . '/library/css/blocks/';
			$css_blocks_url  = get_stylesheet_directory_uri() . '/library/css/blocks/';
			
			// Charger les styles globaux pour le front-end
			$global_css_file = get_stylesheet_directory() . '/library/css/style.min.css';
			$global_css_version = file_exists($global_css_file) ? filemtime($global_css_file) : wp_get_theme()->get('Version');
			wp_enqueue_style('global-styles', get_stylesheet_directory_uri() . '/library/css/style.min.css', array(), $global_css_version);

			// Détection automatique des blocs ACF dans le contenu - Permet d'appeler les styles ou non
			if (is_singular() || is_tax()) {
				global $post;
				$content = $post->post_content;

				preg_match_all('/wp:acf\/([a-z0-9-]+)/', $content, $matches);
				if (!empty($matches[1])) {
					foreach ($matches[1] as $block_name) {
						cbo_register_block_usage($block_name);
					}
				}
			}

			// Charger les styles des blocs enregistrés
			if (!empty($cbo_used_blocks)) {
				foreach ($cbo_used_blocks as $block_name) {
					$block_css_file = $css_blocks_path . $block_name . '.min.css';
					if (file_exists($block_css_file)) {
						wp_enqueue_style('block-' . $block_name, $css_blocks_url . $block_name . '.min.css', array(), filemtime($block_css_file));
					}
				}
			}
		}
	}


	/* ****************** */
	/* Load admin styles */
	function admin_css() {
		$admin_handle = 'gutenberg-styles';
		$gutenberg_stylesheet = get_template_directory_uri() . '/library/css/gutenberg.min.css';
		wp_enqueue_style($admin_handle, $gutenberg_stylesheet);

		$admin_handle = 'backoffice';
		$admin_stylesheet = get_template_directory_uri() . '/library/css/style.min.css';
		wp_enqueue_style($admin_handle, $admin_stylesheet);
	}
	add_action('admin_print_styles', 'admin_css', 11);
?>
