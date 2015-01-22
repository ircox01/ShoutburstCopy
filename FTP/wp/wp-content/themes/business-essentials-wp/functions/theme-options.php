<?php
/**
 * Initialize the options before anything else.
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'setup',
        'title'       => 'Setup'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'vn_toplogo',
        'label'       => 'Top Logo',
        'desc'        => 'Upload your logo.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_favicon',
        'label'       => 'Favicon',
        'desc'        => 'Upload your favicon.  16px X 16px .png.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_specstyle',
        'label'       => 'Upload Special Stylesheet',
        'desc'        => 'Upload the color selected stylesheet.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_customcss',
        'label'       => 'Custom CSS',
        'desc'        => 'Use this area to over ride any CSS from the stylesheet with custom CSS.',
        'std'         => '',
        'type'        => 'css',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_tracking',
        'label'       => 'Tracing Code',
        'desc'        => 'Enter your tracking code script here that will be injected into every page for better analytics.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_copyright',
        'label'       => 'Copyright',
        'desc'        => 'Enter your copyright information here.  HTML such as links etc is acceptable.',
        'std'         => '2013 Jonathan Atkinson - Handcrafted in the U.S.A.',
        'type'        => 'textarea-simple',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_homepagemessageleft',
        'label'       => 'Homepage Message Left Column',
        'desc'        => 'Enter your message area here that will appear under the slider.  HTML is acceptable here.  Leave this blank to disable.',
        'std'         => 'Sign-up today for a FREE instant account with no monthly commitment!',
        'type'        => 'textarea-simple',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_homepagemessageright',
        'label'       => 'Homepage Message Right Column',
        'desc'        => 'Enter your message area here that will appear under the slider.  HTML is acceptable here.  Leave this blank to disable.',
        'std'         => '<div class="button_green_image"> <a href="#">No Credit Card Required</a> </div>',
        'type'        => 'textarea-simple',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_telephonenumber',
        'label'       => 'Telephone Number',
        'desc'        => 'Enter your phone number here that will appear in the menu bar on every page.  Leave this blank to disable.',
        'std'         => '0800 123 456 7890',
        'type'        => 'text',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_homepageleftcolumntitle',
        'label'       => 'Homepage Left Column Title',
        'desc'        => 'Enter the title for the left column title if you have chosen the Homepage-Dynamic page template for your homepage.',
        'std'         => 'Our clients',
        'type'        => 'text',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_homepageleftcolumnlinktext',
        'label'       => 'Homepage Left Column Link Text',
        'desc'        => 'Enter some text here that will link through to wherever you would like.  Leaving this field blank will disable this feature.',
        'std'         => 'View all',
        'type'        => 'text',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_homepageleftcolumnlink',
        'label'       => 'Homepage Left Column Link',
        'desc'        => 'Enter a url here for the above text to point to.  If you left the above field blank, the link feature will be disabled.',
        'std'         => '#',
        'type'        => 'text',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_homepagerightcolumntitle',
        'label'       => 'Homepage Right Column Title',
        'desc'        => 'Enter the title for the left column title if you have chosen the Homepage-Dynamic page template for your homepage.',
        'std'         => 'Latest blog',
        'type'        => 'text',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_homepagerightcolumnlinktext',
        'label'       => 'Homepage Right Column Link Text',
        'desc'        => 'Enter some text here that will link through to wherever you would like.  Leaving this field blank will disable this feature.',
        'std'         => 'View all',
        'type'        => 'text',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vn_homepagerightcolumnlink',
        'label'       => 'Homepage Right Column Link',
        'desc'        => 'Enter a url here for the above text to point to.  If you left the above field blank, the link feature will be disabled.',
        'std'         => '#',
        'type'        => 'text',
        'section'     => 'setup',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}