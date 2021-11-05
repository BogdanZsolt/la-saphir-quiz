<?php

/**
 * La Saphire Video Modal Wordpress Shortcode
*/

function lsq_load(){
		$return_html = '';
		$return_html .= '
			<section id="lsq_load" />
		';
	return $return_html;
}
add_shortcode( 'lsq_load', 'lsq_load' );

