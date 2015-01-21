<?php
/**
 * Register Settings
 *
 * @package     Creativ Social
 * @subpackage  Register Settings
 * @copyright   Copyright (c) 2012, Jonathan Atkinson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
*/


function creativsocial_options_each( $key ) {

	$social_options = get_option( 'creativsocial_all_options' );

	 /* Define the array of defaults */ 
	$defaults = array(
		'facebook'     	=> 0,
		'twitter'     	=> 0,
		'pinterest'    	=> 0,
		'youtube'		=> 0,
		'vimeo'			=> 0,
		'flickr'		=> 0,
		'github'		=> 0,
		'gplus'			=> 0,
		'dribbble'		=> 0,
		'tumblr'		=> 0,
		'wordpress'		=> 0,
		'instagram'		=> 0,
		'rss'		=> 0,
		'linkedin'		=> 0
		//'other'			=> 0
	);

	$social_options = wp_parse_args( $social_options, $defaults );

	if( isset( $social_options[$key] ) )
		 return $social_options[$key];

	return false;
}


function creativsocial_admin_menu() {
	add_submenu_page(
		'options-general.php',
		__( 'Creativ Social Settings', 'creativsocial' ),
		__( 'Creativ Social', 'creativsocial' ),
		'manage_options',
		'creativsocial_all_options',
		'creativsocial_render_settings_page'
	);
}
add_action( 'admin_menu', 'creativsocial_admin_menu' );


/**
 * Render Settings Page
 *
 * @access      private
 * @since       1.0.0
 * @return      void
 */

function creativsocial_render_settings_page( $active_tab = '' ) {
	ob_start(); ?>

	<div class="wrap">
	
		<div id="icon-themes" class="icon32"></div>
		<h2><?php _e( 'Creativ Social Settings', 'creativsocial' ); ?></h2>
		<?php settings_errors(); ?>
		
		<?php if ( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else {
			$active_tab = 'display_options';
		}

		?>
		
		<form method="post" action="options.php">
			<?php
			if ( $active_tab == 'display_options' ) {
				settings_fields( 'creativsocial_all_options' );
				do_settings_sections( 'creativsocial_all_options' );
			}

			submit_button();
	
	echo ob_get_clean();	
}


function creativsocial_initialize_theme_options() {

	// If the theme options don't exist, create them.
	if ( false == get_option( 'creativsocial_all_options' ) )
		add_option( 'creativsocial_all_options' );

	// First, we register a section.
	add_settings_section(
		'general_settings_section',
		__( 'Settings', 'creativsocial' ),
		'creativsocial_general_options_callback',
		'creativsocial_all_options'
	);

	add_settings_field(	
		'facebook',						
		__( 'Facebook',	'creativsocial' ),						
		'creativsocial_facebook_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'twitter',						
		__( 'Twitter', 'creativsocial' ),
		'creativsocial_twitter_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);
	
	add_settings_field(	
		'pinterest',						
		__( 'Pinterest', 'creativsocial' ),					
		'creativsocial_pinterest_callback',
		'creativsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'youtube',						
		__( 'Youtube', 'creativsocial' ),
		'creativsocial_youtube_callback',
		'creativsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'vimeo',						
		__( 'Vimeo', 'creativsocial' ),
		'creativsocial_vimeo_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'flickr',						
		__( 'Flickr', 'creativsocial' ),
		'creativsocial_flickr_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'github',						
		__( 'Github','creativsocial' ),
		'creativsocial_github_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'gplus',						
		__( 'Google+', 'creativsocial' ),
		'creativsocial_gplus_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'dribbble',						
		__( 'Dribbble',	'creativsocial' ),
		'creativsocial_dribbble_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);
	
	add_settings_field(	
		'linkedin',						
		__( 'LinkedIn',	'creativsocial' ),
		'creativsocial_linkedin_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);
	
	
	add_settings_field(	
		'tumblr',						
		__( 'Tumblr',	'creativsocial' ),
		'creativsocial_tumblr_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);
	
	
	add_settings_field(	
		'wordpress',						
		__( 'WordPress',	'creativsocial' ),
		'creativsocial_wordpress_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);
	
	
	add_settings_field(	
		'instagram',						
		__( 'Instagram',	'creativsocial' ),
		'creativsocial_instagram_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);
	
	
	add_settings_field(	
		'rss',						
		__( 'RSS',	'creativsocial' ),
		'creativsocial_rss_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);


	/*
	add_settings_field(	
		'other',						
		__( 'Other Social Network (add later)',	'creativsocial' ),
		'creativsocial_other_callback',	
		'creativsocial_all_options',	
		'general_settings_section'			
	);
	*/

	// Finally, we register the fields with WordPress
	register_setting(
		'creativsocial_all_options',
		'creativsocial_all_options',
		'creativsocial_sanitize_social_options'
	);


} // end creativsocial_initialize_theme_options
add_action( 'admin_init', 'creativsocial_initialize_theme_options' );



/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */ 


/**
 * This function provides a simple description for the General Options page. 
 *
 * It's called from the 'creativsocial_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */

function creativsocial_general_options_callback() {
	echo '<p>';
	_e( 'Please add links (the full http://) to your social network profiles below. Only completed entries will display a social icon. <br/><br/>Once complete you can insert in to any widget area using a Text widget and the shortcode [creativsocial].', 'creativsocial' );
	echo '</p>';
} // end creativsocial_general_options_callback


/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */ 


/**
 * This function renders the interface elements for toggling the visibility of the header element.
 * 
 * It accepts an array or arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */

// Facebook Callback
function creativsocial_facebook_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['facebook'] ) ) {
		$url = esc_url( $options['facebook'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="facebook" name="creativsocial_all_options[facebook]" value="' . $url . '" />';
	
} // end creativsocial_facebook_callback


// Twitter Callback
function creativsocial_twitter_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['twitter'] ) ) {
		$url = esc_url( $options['twitter'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="twitter" name="creativsocial_all_options[twitter]" value="' . $url . '" />';
	
} // end creativsocial_twitter_callback


// Pinterest Callback
function creativsocial_pinterest_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['pinterest'] ) ) {
		$url = esc_url( $options['pinterest'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="pinterest" name="creativsocial_all_options[pinterest]" value="' . $url . '" />';
	
} // end creativsocial_pinterest_callback


// Youtube Callback
function creativsocial_youtube_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['youtube'] ) ) {
		$url = esc_url( $options['youtube'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="youtube" name="creativsocial_all_options[youtube]" value="' . $url . '" />';
	
} // end creativsocial_youtube_callback


// Vimeo Callback
function creativsocial_vimeo_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['vimeo'] ) ) {
		$url = esc_url( $options['vimeo'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="vimeo" name="creativsocial_all_options[vimeo]" value="' . $url . '" />';
	
} // end creativsocial_vimeo_callback


// Flickr Callback
function creativsocial_flickr_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['flickr'] ) ) {
		$url = esc_url( $options['flickr'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="flickr" name="creativsocial_all_options[flickr]" value="' . $url . '" />';
	
} // end creativsocial_flickr_callback


// Github Callback
function creativsocial_github_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['github'] ) ) {
		$url = esc_url( $options['github'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="github" name="creativsocial_all_options[github]" value="' . $url . '" />';
	
} // end creativsocial_github_callback


// Google+ Callback
function creativsocial_gplus_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['gplus'] ) ) {
		$url = esc_url( $options['gplus'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="gplus" name="creativsocial_all_options[gplus]" value="' . $url . '" />';
	
} // end creativsocial_gplus_callback


// Dribbble Callback
function creativsocial_dribbble_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['dribbble'] ) ) {
		$url = esc_url( $options['dribbble'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="dribbble" name="creativsocial_all_options[dribbble]" value="' . $url . '" />';
	
} // end creativsocial_dribbble_callback


// LinkedIn Callback
function creativsocial_linkedin_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['linkedin'] ) ) {
		$url = esc_url( $options['linkedin'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="linkedin" name="creativsocial_all_options[linkedin]" value="' . $url . '" />';
	
} // end creativsocial_linkedin_callback


// Tumblr Callback
function creativsocial_tumblr_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['tumblr'] ) ) {
		$url = esc_url( $options['tumblr'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="tumblr" name="creativsocial_all_options[tumblr]" value="' . $url . '" />';
	
} // end creativsocial_tumblr_callback


// WordPress Callback
function creativsocial_wordpress_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['wordpress'] ) ) {
		$url = esc_url( $options['wordpress'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="wordpress" name="creativsocial_all_options[wordpress]" value="' . $url . '" />';
	
} // end creativsocial_wordpress_callback


// Instagram Callback
function creativsocial_instagram_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['instagram'] ) ) {
		$url = esc_url( $options['instagram'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="instagram" name="creativsocial_all_options[instagram]" value="' . $url . '" />';
	
} // end creativsocial_instagram_callback


// RSS Callback
function creativsocial_rss_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['rss'] ) ) {
		$url = esc_url( $options['rss'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="rss" name="creativsocial_all_options[rss]" value="' . $url . '" />';
	
} // end creativsocial_rss_callback


/*
// Other Callback
function creativsocial_other_callback() {
	
	$options = get_option( 'creativsocial_all_options' );
	$url = '';

	if( isset( $options['other'] ) ) {
		$url = esc_url( $options['other'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="other" name="creativsocial_all_options[other]" value="' . $url . '" />';
	
} // end creativsocial_other_callback
*/


/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */ 
 
 /**
 * Sanitization callback for the social options. Since each of the social options are text inputs,
 * this function loops through the incoming option and strips all tags and slashes from the value
 * before serializing it.
 *	
 * @since 		1.0.0
 * @param		$input (The unsanitized collection of options)
 * @return		The collection of sanitized values.
 */

function creativsocial_sanitize_social_options( $input ) {
	
	// Define the array for the updated options
	$output = array();

	// Loop through each of the options sanitizing the data
	foreach( $input as $key => $val ) {
	
		if( isset ( $input[$key] ) ) {
			$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
		} // end if	
	
	} // end foreach
	
	// Return the new collection
	return apply_filters( 'creativsocial_sanitize_social_options', $output, $input );

} // end sandbox_theme_sanitize_social_options