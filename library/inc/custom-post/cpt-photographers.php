<?php
	function cbo_photographers() { 
		register_post_type( 'photographers',
		array( 'labels' => array(
			'name' => __( 'Nos photographes', 'bonestheme' ),
			'singular_name' => __( 'Photographe', 'bonestheme' ),
			'all_items' => __( 'Tous les photographes', 'bonestheme' ), 
			'add_new' => __( 'Ajouter', 'bonestheme' ), 
			'add_new_item' => __( 'Ajouter un photographe', 'bonestheme' ),
			'edit' => __( 'Modifier', 'bonestheme' ),
			'edit_item' => __( 'Modifier un photographe', 'bonestheme' ),
			'new_item' => __( 'Nouveau photographe', 'bonestheme' ),
			'view_item' => __( 'Voir le photographe', 'bonestheme' ),
			'search_items' => __( 'Rechercher', 'bonestheme' ),
			'not_found' =>  __( 'Aucun photographe trouvé.', 'bonestheme' ),
			'not_found_in_trash' => __( 'Aucun photographe dans la corbeille', 'bonestheme' ),
			'parent_item_colon' => ''
		),
		'description' => __( 'Ceci est un photographe d\'exemple', 'bonestheme' ),
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'query_var' => true,
		'menu_position' => 4, 
		'menu_icon' => 'dashicons-camera-alt',
		'rewrite'	=> array( 'slug' => 'photographe', 'with_front'   => false ), // slug du single
		'has_archive' => 'nos-photographes', // slug de la page d'archive
		'capability_type' => 'post',
		'hierarchical' => false,
		'show_in_rest' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'), 
	)); }
	add_action( 'init', 'cbo_photographers');

?>