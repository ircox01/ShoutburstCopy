<?php

// Slider Shortcode
function creativsocial_icons_shortcode( $atts, $content = null ) {
	
	ob_start();
	creativsocial_icons_template();
	$output = ob_get_clean();

	return $output;

}
add_shortcode( 'creativsocial', 'creativsocial_icons_shortcode' );