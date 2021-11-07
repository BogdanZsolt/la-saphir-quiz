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

function lsq_custom_rest(){
	register_rest_field( 'ls_quiz', 'quiz_categories', array(
		'get_callback' => function(){return get_the_terms( get_the_ID(), 'quiz_categories');}
	));

	register_rest_field( 'ls_quiz', 'questionIndex', array(
		'get_callback' => function(){return get_post_meta( get_the_ID(), '_question_index', true );},
	) );

	register_rest_field( 'ls_quiz', 'number_of_choices', array(
		'get_callback' => function(){return get_post_meta( get_the_ID(), '_number_of_choices', true );},
	) );

	register_rest_field( 'ls_quiz', 'answers', array(
		'get_callback' => function(){return json_decode( get_post_meta( get_the_ID(), '_question_answers', true ) );}
	) );

	register_rest_field( 'ls_quiz', 'reactions', array(
		'get_callback' => function(){return json_decode( get_post_meta( get_the_ID(), '_question_reactions', true ) );}
	) );
}
add_action( 'rest_api_init', 'lsq_custom_rest');

function ls_quiz_answers_info_html( $post ){
	$qindex = get_post_meta( $post->ID, '_question_index', true );
	$qchoice = get_post_meta( $post->ID, '_number_of_choices', true );
	$qanswers = get_post_meta( $post->ID, '_question_answers', true );
	$qanswers = ( empty($qanswers) ) ? array( '' ) : json_decode( $qanswers );
	$qreactions = get_post_meta($post->ID, '_question_reactions', true);
	$qreactions = ( empty($qreactions) ) ? array( '' ) : json_decode( $qreactions );
	$html = '';
	$html .= '<input type="hidden" name="question_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
	$html .= '<table class="form-table">';
	$html .= '<tr><th></th><td id="field-button">';
	$html .= '<button id="remove-field" type="button" class="btn btn-primary">Remove Field</button>';
	$html .= '<button id="add-field" type="button" class="btn btn-primary">Add Field</button>';
	$html .= '</td></tr>';
	$html .= '<tr><th><label for="question_index">Question index:</label></th>';
	$html .= '<td><input id="question_index" type="number" name="question_index" min="1" value="' . $qindex . '"></td>';
	$html .= '</tr>';
	$html .= '<tr><th><label for="number_of_choices">Number of choices:</label></th>';
	$html .= '<td><input id="number_of_choices" type="number" name="number_of_choices" min="1" value="' . $qchoice . '"></td>';
	$html .= '</tr>';
	foreach( $qanswers as $key => $qanswer) {
		$html .= '<tr><th style=""><label for="quiz_answer">Answer ' . ( $key+1 ) . '</label></th>';
		$html .= '<td><textarea class="widefat" name="quiz_answer[]" id="quiz_answer' . ( $key+1 ) . '">' . esc_textarea( trim( $qanswer ) ) . '</textarea></td></tr>';
		$html .= '<tr><th style=""><label for="quiz_reaction">Reaction ' . ( $key+1 ) . '</label></th>';
		$html .= '<td><input class="widefat" type="text" name="quiz_reaction[]" id="quiz_reaction' . ( $key+1
		 ) . '"value="' . esc_attr( $qreactions[$key] ) .'" /></td></tr>';
	}
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
	if (array_key_exists( 'number_of_choices', $_POST ) ){
		update_post_meta( $post_id, '_number_of_choices', (empty(($_POST['number_of_choices'])) ? 1 : $_POST['number_of_choices'] ) );
	}
	if ( 'ls_quiz' == $_POST['post_type'] && current_user_can( 'edit_post', $post_id ) ) {
		$qanswers = isset( $_POST['quiz_answer'] ) ? ( $_POST['quiz_answer'] ) : array();
		$qreactions = isset( $_POST['quiz_reaction'] ) ? ( $_POST['quiz_reaction'] ) : array();
		$filtered_answers = array();
		$filtered_reactions = array();
		foreach ( $qanswers as $qanswer) {
			array_push( $filtered_answers, sanitize_text_field( trim( $qanswer ) ) );
		}
		foreach ( $qreactions as $qreaction) {
			array_push( $filtered_reactions, $qreaction );
		}
		$qanswers = json_encode( $filtered_answers );
		$qreactions = json_encode( $filtered_reactions );
		update_post_meta( $post_id, "_question_answers", $qanswers );
		update_post_meta( $post_id, "_question_reactions", $qreactions );
	}
	else {
		return $post_id;
	}
}
add_action( 'save_post', 'ls_save_quizes' );

/*
?st_face=dry-or-dehydrated

&sc=signs-of-aging
%2Cdrydehydrated
%2Cdulllack-of-radiance

&st_body=sun-damaged
%2Ceczema-or-dermatitis

&gender=male */

/*
?st_face=sensitive-or-reactive

&sc=signs-of-aging
%2Cpigmentation
%2Cdrydehydrated

&st_body=sun-damaged
%2Cvisibly-aging

&gender=female */

/*
?st_face=normal-skin

&sc=dulllack-of-radiance
%2Cliftingfirming
%2Coilybreakouts

&st_body=eczema-or-dermatitis
%2Cuneven-skin-tone

&gender=male
*/

/*
?st_face=mature-or-environmental-damaged

&sc=dulllack-of-radiance
%2Cliftingfirming
%2Coilybreakouts

&st_body=uneven-skin-tone
%2Cdryflaky

&gender=female */

/*
?st_face=oily-or-combination

&sc=signs-of-aging
%2Cpigmentation
%2Cdrydehydrated

&st_body=no-concern-body
&gender=female */

/*
?st_face=acne-or-problematic

&sc=dulllack-of-radiance
%2Cliftingfirming
%2Coilybreakouts

&st_body=sun-damaged
%2Cvisibly-aging

&gender=male */