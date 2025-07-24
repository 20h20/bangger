<?php
	require get_template_directory() . '/templates/blocks/contact/block.php';
	require get_template_directory() . '/templates/blocks/directors/block.php';
	require get_template_directory() . '/templates/blocks/herovideo/block.php';
	require get_template_directory() . '/templates/blocks/herosimple/block.php';
	require get_template_directory() . '/templates/blocks/movies/block.php';
	require get_template_directory() . '/templates/blocks/picturefull/block.php';
	require get_template_directory() . '/templates/blocks/relationship/block.php';
	require get_template_directory() . '/templates/blocks/team/block.php';
	require get_template_directory() . '/templates/blocks/text/block.php';
	require get_template_directory() . '/templates/blocks/textitle/block.php';
	require get_template_directory() . '/templates/blocks/textpicture/block.php';

	function allow_only_custom_blocks( $allowed_blocks, $editor_context ) {
		return array(
			'acf/contact',
			'acf/directors',
			'acf/herovideo',
			'acf/herosimple',
			'acf/movies',
			'acf/picturefull',
			'acf/relationship',
			'acf/team',
			'acf/text',
			'acf/textitle',
			'acf/textpicture',
		);
	}
	add_filter( 'allowed_block_types_all', 'allow_only_custom_blocks', 10, 2 );


	/* ************************* */
	/* ADD NEW CATEGORIES INTO ACF BLOCK REGISTER */
	/* ************************* */
	function add_custom_block_categories($categories) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'hero',
					'title' => __('En-tête'),
					'icon'  => null,
				),
				array(
					'slug'  => 'relationel',
					'title' => __('Relation'),
					'icon'  => null,
				),
			)
		);
	}
	add_filter('block_categories_all', 'add_custom_block_categories');

?>