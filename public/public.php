<?php
/**
 * Init Styles & scripts
 *
 * @return void
*/
function lsq_public_styles_scripts(){
	wp_enqueue_style( 'lsq-public-style', LSQ_URL . 'public/public.css', '', '');
	wp_enqueue_script( 'lsq-public-script', LSQ_URL . 'public/public.js', null, '', true );
}
add_action( 'wp_enqueue_scripts', 'lsq_public_styles_scripts' );