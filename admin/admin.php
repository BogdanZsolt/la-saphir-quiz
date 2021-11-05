<?php
/**
 * Init Styles & scripts
 *
 * @return void
*/
function lsq_admin_styles_scripts(){
	wp_enqueue_style( 'lsq-admin-style', LSQ_URL . 'admin/css/admin.css', '', '' );
	wp_enqueue_script( 'lsq-admin-script', LSQ_URL . 'admin/js/admin.js', array(), '', true );
}
add_action( 'admin_enqueue_scripts', 'lsq_admin_styles_scripts' );