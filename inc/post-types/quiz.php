<?php

/*
* Gutemberg editor disable
*/
// add_filter( 'use_block_editor_for_post', '__return_false' );

/*
* Gutemberg editor disable on ls_quiz custom post type
*/
add_filter( 'use_block_editor_for_post_type', function( $enabled, $post_type ) {
    return 'ls_quiz' === $post_type ? false : $enabled;
}, 10, 2 );

/**
 * La Saphire - Create Question Custom Post Type
*/
function lsq_post_type(){

	// Lasaphire Quiz CPT
	$quiz_labels = array(
		'name'                  => __( 'Questions', 'lsquiz' ),
		'singular_name'         => __( 'Question', 'lsquiz' ),
		'menu_name'             => __( 'Quiz', 'lsquiz' ),
		'name_admin_bar'        => __( 'Question', 'lsquiz' ),
		'add_new'               => __( 'Add New ', 'lsquiz' ),
		'add_new_item'          => __( 'Add New Question', 'lsquiz' ),
		'all_items'			    						=> __( 'All Questions', 'lsquiz' ),
		'search_items'		    				=> __( 'Search Questions', 'lsquiz' ),
		'not_found'             => __( 'No Question Found', 'lsquiz' ),
		'not_found_in_trash'    => __( 'No Question in Trash', 'lsquiz' ),
		'featured_image'        => __( 'Question Cover Image', 'lsquiz' ),
		'set_featured_image'    => __( 'Set cover image', 'lsquiz' ),
		'remove_featured_image'	=> __( 'Remove cover image', 'lsquiz' ),
		'use_featured_image'				=> __( 'Use as cover image', 'lsquiz' ),
		'archives'														=> __( 'Question archives', 'lsquiz' ),
		'insert_into_item'						=> __( 'Insert into question', 'lsquiz' ),
		'uploaded_to_this_item'	=> __( 'Uploaded to this question', 'lsquiz' ),
		'filter_items_list'					=> __( 'Filter question list', 'lsquiz' ),
		'items_list_navigation'	=> __( 'Questions list navigation', 'lsquiz' ),
		'items_list'												=> __( 'Questions list', 'lsquiz' ),
		'new_item'              => __( 'New Question', 'lsquiz' ),
		'all_items'             => __( 'All Questions', 'lsquiz' ),
		'edit_item'             => __( 'Edit Question', 'lsquiz' ),
		'view_item'             => __( 'View Question', 'lsquiz' ),
		'search_items'          => __( 'Search Questions', 'lsquiz' ),
	);

 $quiz_args = array(
		'show_in_rest'          => true,
		'rewrite'            			=> array( 'slug' => 'question' ),
		'labels'                => $quiz_labels,
		'hierarchical'          => false,
		'public'                => true,
		'description'           => 'Quiz back-end. Questions & Answers.',
		'show_ui'               => true,
		'show_in_menu'          => true,
		'query_var'             => true,
		'capability_type'       => 'post',
		'has_archive'           => false,
		'can_export'            => true,
		'menu_position'         => null,
		'supports'              => array( 'title', 'editor' ),
		'menu_icon' 												=> 'dashicons-clipboard',
		'taxonomies'												=> array( 'quiz_categories' ),
	);

 register_post_type( 'ls_quiz', $quiz_args );
}
add_action( 'init', 'lsq_post_type' );

// La Saphire Quiz - Create taxonomies
function lsq_create_taxonomies() {

	register_taxonomy(
		'quiz_categories',
		'ls_quiz',
		array(
		'labels' => array(
			'name' 									=> __( 'Category', 'lasaphire' ),
			'add_new_item' 	=> __( 'Add New Category', 'lasaphire' ),
			'new_item_name' => __( 'New Category', 'lasaphire' )
		),
			'show_ui' 						=> true,
			'show_tagcloud' => false,
			'hierarchical' 	=> true,
			'show_in_rest'		=> true,
			'rewrite'							=> array( 'slug' => 'quiz_categories'),
		)
	);
}
add_action( 'init', 'lsq_create_taxonomies' );
