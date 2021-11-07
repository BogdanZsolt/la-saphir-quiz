<?php


function set_ls_quiz_columns($columns) {
	$columns = array(
		'title'                 => __( 'Question', 'lsquiz' ),
		'question_index'        => __( 'Question Index', 'lsquiz' ),
		'quiz_categories'  					=> __( 'Categories', 'lsquiz' ),
		'date'                  => __( 'Date', 'lsquiz' ),
	);
	return $columns;
}
add_filter('manage_ls_quiz_posts_columns', 'set_ls_quiz_columns');

function custom_ls_quiz_column( $column, $post_id ) {
	switch ( $column ) {
		case 'quiz_categories' :
			echo strip_tags( get_the_term_list( $post_id, 'quiz_categories', '', ', ' ) );
			break;
		case 'question_index' :
			echo get_post_meta( $post_id, '_question_index', true );
			break;
	}
}
add_action( 'manage_ls_quiz_posts_custom_column' , 'custom_ls_quiz_column', 10, 2 );

/**
 * Making Columns Sortable
*/
function quiz_make_columns_sortable( $columns ){
	$columns[ 'question_index' ] = 'question_index';
	$columns[ 'quiz_categories' ] = 'quiz_categories';
	return $columns;
}
add_filter( 'manage_edit-ls_quiz_sortable_columns', 'quiz_make_columns_sortable' );

/**
 * Columns sorting logic
*/
function quiz_columns_sorting_logic( $query ){
	if( !is_admin() || !$query->is_main_query() ) {
		return;
	}

	if( 'question_index' === $query->get( 'orderby' ) ) {
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'meta_key', '_question_index');
	}
}
add_action( 'pre_get_posts', 'quiz_columns_sorting_logic' );

/**
 * Set row actions
 */
function quiz_action_row( $actions, $post ){
	//remove what you don't need
	if( $post->post_type == 'ls_quiz'){
		unset( $actions['view'] );
		$actions['id'] = 'ID: ' . $post->ID;
	}
	return $actions;
}
add_filter( 'post_row_actions', 'quiz_action_row', 9, 2 );
