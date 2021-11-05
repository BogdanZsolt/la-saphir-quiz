<?php

/**
 * La Saphire - Create Question Custom Post Type
*/
function lsq_post_type(){

	// Lasaphire Quiz CPT
	$quiz_labels = array(
		'name'                  => __( 'Questions', 'lasaphire' ),
		'singular_name'         => __( 'Question', 'lasaphire' ),
		'menu_name'             => __( 'Quiz', 'lasaphire' ),
		'name_admin_bar'        => __( 'Question', 'lasaphire' ),
		'add_new'               => __( 'Add New ', 'lasaphire' ),
		'add_new_item'          => __( 'Add New Question', 'lasaphire' ),
		'all_items'			    						=> __( 'All Questions', 'lasaphire' ),
		'search_items'		    				=> __( 'Search Questions', 'lasaphire' ),
		'not_found'             => __( 'No Question Found', 'lasaphire' ),
		'not_found_in_trash'    => __( 'No Question in Trash', 'lasaphire' ),
		'featured_image'        => __( 'Question Cover Image', 'lasaphire' ),
		'set_featured_image'    => __( 'Set cover image', 'lasaphire' ),
		'remove_featured_image'	=> __( 'Remove cover image', 'lasaphire' ),
		'use_featured_image'				=> __( 'Use as cover image', 'lasaphire' ),
		'archives'														=> __( 'Question archives', 'lasaphire' ),
		'insert_into_item'						=> __( 'Insert into question', 'lasaphire' ),
		'uploaded_to_this_item'	=> __( 'Uploaded to this question', 'lasaphire' ),
		'filter_items_list'					=> __( 'Filter question list', 'lasaphire' ),
		'items_list_navigation'	=> __( 'Questions list navigation', 'lasaphire' ),
		'items_list'												=> __( 'Questions list', 'lasaphire' ),
		'new_item'              => __( 'New Question', 'lasaphire' ),
		'all_items'             => __( 'All Questions', 'lasaphire' ),
		'edit_item'             => __( 'Edit Question', 'lasaphire' ),
		'view_item'             => __( 'View Question', 'lasaphire' ),
		'search_items'          => __( 'Search Questions', 'lasaphire' ),
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
				'name' => __( 'Quiz Category', 'lasaphire' ),
				'add_new_item' => __( 'Add New Quiz Category', 'lasaphire' ),
				'new_item_name' => __( 'New Quiz Category', 'lasaphire' )
			),
			'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true
		)
	);
}
add_action( 'init', 'lsq_create_taxonomies', 0 );

