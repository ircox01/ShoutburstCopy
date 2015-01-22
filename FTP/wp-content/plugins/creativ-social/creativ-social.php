<?php
/*
Plugin Name: Creativ Social
Plugin URI: http://cr3ativ.com/plugins/social/
Description: Retina Ready Social Icons.
Author: Jonathan Atkinson
Author URI: http://cr3ativ.com
Version: 1.0.0
Text Domain: creativsocial
License: GNU GPL v2
*/

/* _TODO_ Make Widget to display social icons. Doesn't have any options besides
 * the widget title; just a link to the settings page and some info.
 *
 * Addtionally, some cool settings to have in the future:
 *	-Choose Icon Style (4 Options at the moment due to SVG requirement)
 *	-Modify Height/Width of Icons
 *	-Hover/Default Styling is Optional (remove hover etc. styles and leave base)
 *	-Input/Checkbox to Center Icons
 *	-Custom CSS Box (just makes sense due to how easily a little CSS can modify the icons)

 * Look at switching over to a custom post type for social 'profiles':
 *	-Featured Image is the Icon Desired
 *	-Title is reference + alt/title for icon.
 *	-Single Custom Meta Box/Field for URL.
 *	-Include AJAX Sorter from Captain Slider for organising the order of the social icons.
 *	-Need to allow changing of URL from admin edit archive listing (google/Pippin)
 *	-Also need to include 10 'example' social icons or at least an easy import file.
 *	// This method has a lot of positives but there are still some big cons. Discuss.
 */

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/

// Plugin Folder Path
if ( !defined( 'CREATIVSOCIAL_PLUGIN_DIR' ) ) {
	define( 'CREATIVSOCIAL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder URL
if ( !defined( 'CREATIVSOCIAL_PLUGIN_URL' ) ) {
	define( 'CREATIVSOCIAL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Plugin Version
if ( !defined( 'CREATIVSOCIAL_VERSION' ) ) {
	define( 'CREATIVSOCIAL_VERSION', '1.0.0' );
}


/*
|--------------------------------------------------------------------------
| I18N - LOCALIZATION
|--------------------------------------------------------------------------
*/
load_plugin_textdomain( 'creativsocial', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/*
|--------------------------------------------------------------------------
| REGISTER & ENQUEUE SCRIPTS/STYLES
|--------------------------------------------------------------------------
*/

function creativsocial_load_scripts() {
	wp_register_style( 'creativsocial-styles',  CREATIVSOCIAL_PLUGIN_URL . 'includes/css/creativsocial-styles.css', array(  ), CREATIVSOCIAL_VERSION );

	wp_enqueue_style( 'creativsocial-styles' );	
}
add_action( 'wp_enqueue_scripts', 'creativsocial_load_scripts' );


/*
|--------------------------------------------------------------------------
| MISC FUNCTIONS
|--------------------------------------------------------------------------
*/

/**
 * Settings Link
 *
 * Add the jQuery for the slider to wp_head
 *
 * @access      private
 * @uses        add_filter()
 * @uses        array_unshift()
 * @since       1.0.0
 * @return      string $link
 */

function creativsocial_settings_link( $link, $file ) {
	static $this_plugin;
	
	if ( !$this_plugin )
		$this_plugin = plugin_basename( __FILE__ );

	if ( $file == $this_plugin ) {
		$settings_link = '<a href="' . admin_url( 'options-general.php?page=creativsocial_all_options' ) . '">' . __( 'Settings', 'creativsocial' ) . '</a>';
		array_unshift( $link, $settings_link );
	}
	
	return $link;
}
add_filter( 'plugin_action_links', 'creativsocial_settings_link', 10, 2 );


/*
|--------------------------------------------------------------------------
| INCLUDES
|--------------------------------------------------------------------------
*/

/* Admin Scripts */
include_once( CREATIVSOCIAL_PLUGIN_DIR . 'includes/admin/settings.php' );

/* Front End Scripts */
include_once( CREATIVSOCIAL_PLUGIN_DIR . 'includes/front-end/template.php' );
include_once( CREATIVSOCIAL_PLUGIN_DIR . 'includes/front-end/shortcode.php' );