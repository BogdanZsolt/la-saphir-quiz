<?php

// Quiz - Custom Box
function lsq_custom_box(){
 $screens = [ 'post', 'ls_quiz' ];
	foreach ( $screens as $screen ) {
		add_meta_box(
			'quiz-answers-info',
			'Quiz Answers Info',
			'ls_quiz_answers_info_html',
			$screen,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'lsq_custom_box' );

function lsq_answers_fields(){
	$qanswers = get_post_meta( get_the_ID(), '_question_answers', true );
	return json_decode( $qanswers );
}

function lsq_questionIndex_fields(){
 return get_post_meta( get_the_ID(), '_question_index', true );
}

function lsq_custom_rest(){
	register_rest_field( 'ls_quiz', 'category', array(
		'get_callback' => function(){return get_the_terms( get_the_ID(), 'quiz_categories');}
	));

	register_rest_field( 'ls_quiz', 'questionIndex', array(
		'get_callback' => function(){return get_post_meta( get_the_ID(), '_question_index', true );},
	) );

	register_rest_field( 'ls_quiz', 'answers', array(
		'get_callback' => function(){return json_decode( get_post_meta( get_the_ID(), '_question_answers', true ) );}
	) );
}
add_action( 'rest_api_init', 'lsq_custom_rest');

function ls_quiz_answers_info_html( $post ){
	$qindex = get_post_meta( $post->ID, '_question_index', true );
	$qanswers = get_post_meta( $post->ID, '_question_answers', true );
	$qanswers = ( $qanswers == '' ) ? array( '', '', '', '', '', '' ) : json_decode( $qanswers );
	$html = '<input type="hidden" name="question_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
	$html .= '<table class="form-table">';
	$html .= '<tr><th></th><td id="field-button">';
	$html .= '<button id="remove-field" type="button" class="btn btn-primary">Remove Field</button>';
	$html .= '<button id="add-field" type="button" class="btn btn-primary">Add Field</button>';
	$html .= '</td></tr>';
	$html .= '<tr><th><label for="question_index">Question index:</label></th>';
	$html .= '<td><input id="question_index" type="number" name="question_index" min="1" value="' . $qindex . '"></td>';
	$html .= '</tr>';
	$index = 1;
	foreach ( $qanswers as $qanswer) {
		$html .= '<tr><th style=""><label for="quiz_answer">Answer ' . $index . '</label></th>';
		$html .= '<td><textarea class="widefat" name="quiz_answer[]" id="quiz_answer' . $index . '">' . esc_textarea( trim( $qanswer ) ) . '</textarea></td></tr>';
		$index++;
	}
	$html .= '</tr>';
	$html .= '</table>';
	echo $html;
}

function ls_save_quizes( $post_id ) {
	if ( ! wp_verify_nonce( $_POST['question_box_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	if ( array_key_exists( 'question_index', $_POST ) ) {
		update_post_meta( $post_id, '_question_index', $_POST['question_index']);
	}
	if ( 'ls_quiz' == $_POST['post_type'] && current_user_can( 'edit_post', $post_id ) ) {
		$qanswers = isset( $_POST['quiz_answer'] ) ? ( $_POST['quiz_answer'] ) : array();
		$filtered_answers = array();
		foreach ( $qanswers as $qanswer) {
			array_push( $filtered_answers, sanitize_text_field( trim( $qanswer ) ) );
		}
		$qanswers = json_encode( $filtered_answers );
		update_post_meta( $post_id, "_question_answers", $qanswers );
	}
	else {
		return $post_id;
	}
}
add_action( 'save_post', 'ls_save_quizes' );
