<?php

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Extract audio/video shortcode     /////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////



function extracted_shortcode()
{
    global $post;
if($post) {
		$pattern = get_shortcode_regex();
		preg_match('/'.$pattern.'/s', $post->post_content, $matches);
		if( $matches ) :
			if (is_array($matches) && $matches[2] == 'audio') {
			   $shortcode = $matches[0];
			   echo do_shortcode($shortcode);
			}
		endif; //$matches
	} // endif $post
}// end func. audio_shortcode

add_action( 'init', 'extracted_shortcode' );



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Featured Image Functionality     ////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

add_theme_support( 'post-thumbnails' );
add_image_size( 'slide', 980, 999999, true );



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     WP Tag Cloud     //////////////////////////////////////////////// 
////////////////////////////////////////////////////////////////////////////////////////////


add_filter( 'wp_tag_cloud', 'remove_tag_cloud', 10, 2 );

function remove_tag_cloud ( $return, $args )
{
        return false;
}



function mytheme_tags() {
			
$tags = get_tags();
foreach ($tags as $tag) {
$tag_link = get_tag_link($tag->term_id);
$html = '<div class="button_tag">';
$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
$html .= "{$tag->name}</a>";
$html .= '</div>';
echo $html;
}
}
	
add_filter('widget_tag_cloud_args', 'mytheme_tags');	





////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Prev & Next Buttons    //////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_filter('next_posts_link_attributes', 'posts_link_attributes_1');
add_filter('previous_posts_link_attributes', 'posts_link_attributes_2');

function posts_link_attributes_1() {
    return 'class="button arrow_left"';
}
function posts_link_attributes_2() {
    return 'class="button arrow_right"';
}



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Post Format     /////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_theme_support( 'post-formats', array( 'audio', 'link', 'gallery', 'video', 'quote' ) );



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     2 WP Nav Menus     //////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


register_nav_menus( array(  
  'primary' => __( 'Primary Navigation', 'essentials' ),
  'topsub' => __( 'Top Sub Menu Navigation', 'essentials' ), 
  'sidebarone' => __('Sidebar Menu', 'essentials')  

) );  	



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Setting up Option Tree includes     /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

/* START OPTION TREE */ 
add_filter( 'ot_show_pages', '__return_false' );  
add_filter( 'ot_theme_mode', '__return_true' );
//add_filter( 'ot_show_pages', '__return_true' );  
//add_filter( 'ot_theme_mode', '__return_false' );
include_once( 'option-tree/ot-loader.php' );
include_once( 'functions/theme-options.php' );



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Google Fonts     ////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
function mytheme_fonts() {
$protocol = is_ssl() ? 'https' : 'http';
wp_enqueue_style( 'essentials-opensans', "$protocol://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css" );}
add_action( 'wp_enqueue_scripts', 'mytheme_fonts' );



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Theme Options for widget     ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


$include_path = get_template_directory() . '/includes/';
require_once ($include_path . 'theme-options.php'); 


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Comments     ////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   
   <div class="comment-author-avatar">
   <?php echo get_avatar($comment, 64); ?>
         
   </div>
   
   <div class="comment-main">
   
     <div class="comment-meta">
     <?php printf(__('<span class="comment-author">Written by: %s</span>', 'essentials'), get_comment_author()) ?>
     <div class="button"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
     </div>   
     
     <div class="comment-content">      
     <?php if ($comment->comment_approved == '0') : ?>
     <p><em><?php _e('Your comment is awaiting moderation.', 'essentials') ?></em></p>
     <?php comment_text() ?>
 
     </div> 
     
     </div>
     
     
     <?php else : { ?>
 
     <?php comment_text() ?>  
     
     <?php } ?>  
     
	 <?php endif; ?>
	 
     
     
     <?php
       }
				
	
////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Content width set     ///////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


if ( ! isset( $content_width ) ) 
    $content_width = 980;
		

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Text Domain     /////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


load_theme_textdomain ('essentials');



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Multi Language Ready     ////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


load_theme_textdomain( 'essentials', get_template_directory().'/languages' );

$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);
	

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Contact Form 7     //////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


/**
 * Functions:	Optimize and style Contact Form 7 - WPCF7
 *
 */
// Remove the default Contact Form 7 Stylesheet
function remove_wpcf7_stylesheet() {
	remove_action( 'wp_head', 'wpcf7_wp_head' );
}

// Add the Contact Form 7 scripts on selected pages
function add_wpcf7_scripts() {
	if ( is_page('contact') )
		wpcf7_enqueue_scripts();
}

// Change the URL to the ajax-loader image
function change_wpcf7_ajax_loader($content) {
	if ( is_page('contact') ) {
		$string = $content;
		$pattern = '/(<img class="ajax-loader" style="visibility: hidden;" alt="ajax loader" src=")(.*)(" \/>)/i';
		$replacement = "$1".get_template_directory_uri()."/images/ajax-loader.gif$3";
		$content =  preg_replace($pattern, $replacement, $string);
	}
	return $content;
}

// If the Contact Form 7 Exists, do the tweaks
if ( function_exists('wpcf7_contact_form') ) {
	if ( ! is_admin() && WPCF7_LOAD_JS )
		remove_action( 'init', 'wpcf7_enqueue_scripts' );

	add_action( 'wp', 'add_wpcf7_scripts' );
	add_action( 'init' , 'remove_wpcf7_stylesheet' );
	add_filter( 'the_content', 'change_wpcf7_ajax_loader', 100 );
}





////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Include post and page in search     /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function filter_search($query) {
    if ($query->is_search) {
	$query->set('post_type', array('post', 'page', 'staff', 'affiliates', 'partners', 'casestudy', 'call_centres', 'disabled_workers'));
    };
    return $query;
};
add_filter('pre_get_posts', 'filter_search');



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////              RSS Feed Links             /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_theme_support( 'automatic-feed-links' );


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Remove the jump on read more     ////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function remove_more_jump_link($link) { 
$offset = strpos($link, '#more-');
if ($offset) {
$end = strpos($link, '"',$offset);
}
if ($end) {
$link = substr_replace($link, '', $offset, $end-$offset);
}
return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Include tiny mce for shortcode buttons     //////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


include('tinyMCE.php');


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Load JS Scripts     /////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function tws_js_loader() {
wp_enqueue_script('retina', get_template_directory_uri().'/js/retina.js', array('jquery'),'1.0', true );
wp_enqueue_script('slider', get_template_directory_uri().'/js/jquery.flexslider-min.js', array('jquery'),'1.0', true );
wp_enqueue_script('easing', get_template_directory_uri().'/js/jquery.easing.1.3.js', array('jquery'),'1.0', true );
wp_enqueue_script('hover', get_template_directory_uri().'/js/hoverIntent.js', array('jquery'),'1.0', true );
wp_enqueue_script('sfmenu', get_template_directory_uri().'/js/jquery.sfmenu.js', array('jquery'),'1.0', true );
wp_enqueue_script('commentvaljs', get_template_directory_uri().'/js/jquery.validate.pack.js', array('jquery'),'1.0', true );
wp_enqueue_script('commentval', get_template_directory_uri().'/js/comment-form-validation.js', array('jquery'),'1.0', true );
wp_enqueue_script('jfontsize', get_template_directory_uri().'/js/jquery.jfontsize-1.0.js', array('jquery'),'1.0', true );
}

add_action('wp_enqueue_scripts', 'tws_js_loader');

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     DisabledWorkers post type     /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_action('init', 'create_disabled_workers');

function create_disabled_workers() {
    	$disabled_workers_args = array(
        	'label' => __('Disabled Worker Items', 'essentials'),
        	'singular_label' => __('Disabled Worker Item', 'essentials'),
        	'public' => true,
        	'show_ui' => true,
			'query_var' => true,
        	'rewrite' => true,
			'capability_type' => 'post',
        	'hierarchical' => false,
			'menu_position' => null,
        	'supports' => array('title', 'editor', 'thumbnail', 'comments')
        );
    	register_post_type('disabled_workers',$disabled_workers_args);
	}
	

$meta_box = array(
    'id' => 'my-meta-box',
    'title' => __('DisabledWorker Data'),
    'page' => 'disabled_workers',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
		array(
            'name' => __('Text to appear next to print icon.  Leave blank to disable the icon.'),
            'desc' => __('Print This Page.'),
            'id' => 'printicontext',
            'type' => 'text',
            'std' => ""
        ),	
       array(
            'name' => __('Text to appear next to download icon.  If you do not upload a file (see below) this text will not appear'),
            'desc' => __('Download PDF File.'),
            'id' => 'downloadicontext',
            'type' => 'text',
            'std' => ""
        ), 
    )
);

add_action('admin_menu', 'mytheme_add_box');



// check autosave
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
 return $post_id;
}

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Callcentres post type     /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_action('init', 'create_call_centres');

function create_call_centres() {
    	$call_centres_args = array(
        	'label' => __('Callcentre Items', 'essentials'),
        	'singular_label' => __('Callcentre Item', 'essentials'),
        	'public' => true,
        	'show_ui' => true,
			'query_var' => true,
        	'rewrite' => true,
			'capability_type' => 'post',
        	'hierarchical' => false,
			'menu_position' => null,
        	'supports' => array('title', 'editor', 'thumbnail', 'comments')
        );
    	register_post_type('call_centres',$call_centres_args);
	}
	
	

function add_custom_meta_boxes() {  
  
    // Define the custom attachment for posts  
     
	add_meta_box(  
        'wp_custom_attachment',  
        __('PDF Upload.  If you choose not to upload the text you placed above will not appear.', 'essentials'),
        'wp_custom_attachment',  
        'call_centres',  
        'normal'  
    );  
	
} // end add_custom_meta_boxes  
add_action('add_meta_boxes', 'add_custom_meta_boxes');  

function wp_custom_attachment() {

wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');

$html = '
<p>';
$html .= 'Upload your PDF/Application here.';
$html .= '</p>';
$html .= '<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="57" />';

// Grab the array of file information currently associated with the post
$doc = get_post_meta(get_the_ID(), 'wp_custom_attachment', true);

// Create the input box and set the file's URL as the text element's value
$html .= '<input type="text" id="wp_custom_attachment_url" name="wp_custom_attachment_url" value=" ' . $doc['url'] . '" size="100" style="background-color:transparent; border: none; margin-top:10px;" />';

// Display the 'Delete' option if a URL to a file exists
$doc = get_post_meta(get_the_ID(), 'wp_custom_attachment', true);
if (strlen(trim($doc['url'])) > 0) {
$html .= '<a href="javascript:;" id="wp_custom_attachment_delete">' . __('Delete File') . '</a>';
} // end if

echo $html;

} // end wp_custom_attachment

function save_custom_meta_data($id) {

/* --- security verification --- */
if(!wp_verify_nonce($_POST['wp_custom_attachment_nonce'], plugin_basename(__FILE__))) {
return $id;
} // end if

if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
return $id;
} // end if

if(!current_user_can('edit_page', $id)) {
return $id;
} // end if
/* - end security verification - */

// Make sure the file array isn't empty
if(!empty($_FILES['wp_custom_attachment']['name'])) {

// Setup the array of supported file types. In this case, it's just PDF.
$supported_types = array('application/pdf');

// Get the file type of the upload
$arr_file_type = wp_check_filetype(basename($_FILES['wp_custom_attachment']['name']));
$uploaded_type = $arr_file_type['type'];

// Check if the type is supported. If not, throw an error.
if(in_array($uploaded_type, $supported_types)) {

// Use the WordPress API to upload the file
$upload = wp_upload_bits($_FILES['wp_custom_attachment']['name'], null, file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));

if(isset($upload['error']) && $upload['error'] != 0) {
wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
} else {
add_post_meta($id, 'wp_custom_attachment', $upload);
update_post_meta($id, 'wp_custom_attachment', $upload);
} // end if/else

} else {
wp_die("The file type that you've uploaded is not a PDF.");
} // end if/else

} else {

// Grab a reference to the file associated with this post
$doc = get_post_meta($id, 'wp_custom_attachment', true);

// Grab the value for the URL to the file stored in the text element
$delete_flag = get_post_meta($id, 'wp_custom_attachment_url', true);

// Determine if a file is associated with this post and if the delete flag has been set (by clearing out the input box)
if(strlen(trim($doc['url'])) > 0 && strlen(trim($delete_flag)) == 0) {

// Attempt to remove the file. If deleting it fails, print a WordPress error.
if(unlink($doc['file'])) {

// Delete succeeded so reset the WordPress meta data
update_post_meta($id, 'wp_custom_attachment', null);
update_post_meta($id, 'wp_custom_attachment_url', '');

} else {
wp_die('There was an error trying to delete your file.');
} // end if/el;se

} // end if

} // end if/else

} // end save_custom_meta_data
add_action('save_post', 'save_custom_meta_data');	

function update_edit_form() {  
        echo ' enctype="multipart/form-data"';  
    } // end update_edit_form  
add_action('post_edit_form_tag', 'update_edit_form');  
	
function add_custom_attachment_script() {

wp_register_script('custom-attachment-script', get_stylesheet_directory_uri() . '/js/custom_attachment.js');
wp_enqueue_script('custom-attachment-script');

} // end add_custom_attachment_script
add_action('admin_enqueue_scripts', 'add_custom_attachment_script');

$meta_box = array(
    'id' => 'my-meta-box',
    'title' => __('Callcentre Data'),
    'page' => 'call_centres',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
		array(
            'name' => __('Text to appear next to print icon.  Leave blank to disable the icon.'),
            'desc' => __('Print This Page.'),
            'id' => 'printicontext',
            'type' => 'text',
            'std' => ""
        ),	
       array(
            'name' => __('Text to appear next to download icon.  If you do not upload a file (see below) this text will not appear'),
            'desc' => __('Download PDF File.'),
            'id' => 'downloadicontext',
            'type' => 'text',
            'std' => ""
        ), 
    )
);

add_action('admin_menu', 'mytheme_add_box');


// Add meta box
function mytheme_add_box() {
    global $meta_box;
    
    add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function mytheme_show_box() {
    global $meta_box, $post;
    
    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
        }
        echo     '<td>',
            '</tr>';
    }
    
    echo '</table>';
}

// get current post meta data

add_action('save_post', 'mytheme_save_data');

// Save data from meta box
function mytheme_save_data($post_id) {
    global $meta_box;
    
    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

// check autosave
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
 return $post_id;
}



	
////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Custom taxonomies     ///////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_action( 'init', 'call_centre_category', 0 );
function call_centre_category()	{
	register_taxonomy( 
		'call_centre_category', 
		'call_centres', 
			array( 
				'hierarchical' => true, 
				'label' => __('Call Centre Category', 'essentials'),
				'query_var' => true, 
				'rewrite' => array( 'slug' => 'call_centre_category' ),
			) 
	);
 
}

add_action( 'init', 'disabled_worker_category', 0 );
function disabled_worker_category()	{
	register_taxonomy( 
		'disabled_worker_category', 
		'disabled_workers', 
			array( 
				'hierarchical' => true, 
				'label' => __('Disabled Worker Category', 'essentials'),
				'query_var' => true, 
				'rewrite' => array( 'slug' => 'disabled_worker_category' ),
			) 
	);
 
}


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Staff post type     /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_action('init', 'create_staff');

function create_staff() {
	
	$labels = array(
		'name' => __('Staff', 'post type general name'),
		'singular_name' => __('Staff', 'post type singular name'),
		'add_new' => __('Add New', 'staff member'),
		'add_new_item' => __('Add New Staff Member'),
		'edit_item' => __('Edit Staff Member'),
		'new_item' => __('New Staff Member'),
		'view_item' => __('View Staff Member'),
		'search_items' => __('Search Staff'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => 'Staff'
	);
	
    	$staff_args = array(
        	'labels' => $labels,
        	'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','comments')
        );
    	register_post_type('staff',$staff_args);
	}
	
// Add the Meta Box
function add_custom_meta_box() {
    add_meta_box(
		'custom_meta_box', // $id
		__('Staff Info', 'essentials'), // $title 
		'show_custom_meta_box', // $callback
		'staff', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// Field Array
$prefix = 'staff_';
$custom_meta_fields = array(
	array(
		'label'	=> __('Staff Title'),
		'desc'	=> __('Enter the professional title of this staff member.'),
		'id'	=> $prefix.'stafftitle',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Staff Head Shot Image'),
		'desc'	=> __('Upload your employees head shot image here.  Recommended size is 310px X 400px.'),
		'id'	=> $prefix.'staffheadshot',
		'type'	=> 'image'
	),
	array(
		'label'	=> __('Social Icon 1 Link'),
		'desc'	=> __('Enter the link you want for the social media icon 1.'),
		'id'	=> $prefix.'textlink',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Social Icon 1 Image Alt Text'),
		'desc'	=> __('Enter the title text to display for the social media icon 1.'),
		'id'	=> $prefix.'text',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Upload the Social Media Image 1'),
		'desc'	=> __('Upload your social media image 1'),
		'id'	=> $prefix.'image',
		'type'	=> 'image'
	),
	array(
		'label'	=> __('Social Icon 2 Link'),
		'desc'	=> __('Enter the link you want for the social media icon 2.'),
		'id'	=> $prefix.'textlink2',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Social Icon 2 Image Alt Text'),
		'desc'	=> __('Enter the title text to display for the social media icon 2.'),
		'id'	=> $prefix.'text2',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Upload the Social Media Image 2'),
		'desc'	=> __('Upload your social media image 2'),
		'id'	=> $prefix.'image2',
		'type'	=> 'image'
	),
	array(
		'label'	=> __('Social Icon 3 Link'),
		'desc'	=> __('Enter the link you want for the social media icon 3.'),
		'id'	=> $prefix.'textlink3',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Social Icon 3 Image Alt Text'),
		'desc'	=> __('Enter the title text to display for the social media icon 3.'),
		'id'	=> $prefix.'text3',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Upload the Social Media Image 3'),
		'desc'	=> __('Upload your social media image 3'),
		'id'	=> $prefix.'image3',
		'type'	=> 'image'
	),
	array(
		'label'	=> __('Social Icon 4 Link'),
		'desc'	=> __('Enter the link you want for the social media icon 4.'),
		'id'	=> $prefix.'textlink4',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Social Icon 4 Image Alt Text'),
		'desc'	=> __('Enter the title text to display for the social media icon 4.'),
		'id'	=> $prefix.'text4',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Upload the Social Media Image 4'),
		'desc'	=> __('Upload your social media image 4'),
		'id'	=> $prefix.'image4',
		'type'	=> 'image'
	),
	array(
		'label'	=> __('Social Icon 5 Link'),
		'desc'	=> __('Enter the link you want for the social media icon 5.'),
		'id'	=> $prefix.'textlink5',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Social Icon 5 Image Alt Text'),
		'desc'	=> __('Enter the title text to display for the social media icon 5.'),
		'id'	=> $prefix.'text5',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Upload the Social Media Image 5'),
		'desc'	=> __('Upload your social media image 5'),
		'id'	=> $prefix.'image5',
		'type'	=> 'image'
	),
	array(
		'label'	=> __('Social Icon 6 Link'),
		'desc'	=> __('Enter the link you want for the social media icon 6.'),
		'id'	=> $prefix.'textlink6',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Social Icon 6 Image Alt Text'),
		'desc'	=> __('Enter the title text to display for the social media icon 6.'),
		'id'	=> $prefix.'text6',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Upload the Social Media Image 6'),
		'desc'	=> __('Upload your social media image 6'),
		'id'	=> $prefix.'image6',
		'type'	=> 'image'
	),
	array(
		'label'	=> __('Social Icon 7 Link'),
		'desc'	=> __('Enter the link you want for the social media icon 7.'),
		'id'	=> $prefix.'textlink7',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Social Icon 7 Image Alt Text'),
		'desc'	=> __('Enter the title text to display for the social media icon 7.'),
		'id'	=> $prefix.'text7',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Upload the Social Media Image 7'),
		'desc'	=> __('Upload your social media image 7'),
		'id'	=> $prefix.'image7',
		'type'	=> 'image'
	),
	array(
		'label'	=> __('Staff Single Page Full Width Image'),
		'desc'	=> __('Upload the full width image that will display on the staff single page.  Recommended size is 980px X your choice of height.'),
		'id'	=> $prefix.'stafffullwidthimage',
		'type'	=> 'image'
	)
);

//Hook on admin_enqueue_scripts
add_action('admin_enqueue_scripts' , 'my_scripts' );
 
//Do enqueue
function my_scripts(){
   //jQuery datepicker is already bundled with WordPress
   //See link above
  wp_enqueue_script('custom-js', get_template_directory_uri().'/js/custom-js.js');
   //But jQuery theme is unbundled. Load you own.
   wp_enqueue_style('jquery-ui-custom', get_template_directory_uri().'/css/jquery-ui-custom.css', false ,'1.1', 'all' );
}

function my_custom_js() {
    wp_enqueue_script('jquery.kinetic.js', get_template_directory_uri().'/js/jquery.kinetic.js');
	wp_enqueue_script('jquery-ui-1.8.23.custom.min.js', get_template_directory_uri().'/js/jquery-ui-1.8.23.custom.min.js');
	wp_enqueue_script('jquery.mousewheel.min.js', get_template_directory_uri().'/js/jquery.mousewheel.min.js');
	wp_enqueue_script('jquery.smoothdivscroll-1.3-min.js', get_template_directory_uri().'/js/jquery.smoothdivscroll-1.3-min.js');
}
// Add hook for front-end <head></head>
add_action('wp_head', 'my_custom_js');

	
// The Callback
function show_custom_meta_box() {
	global $custom_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($custom_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// image
					case 'image':  
    $image = get_template_directory_uri().'/img/image.png';    
    echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';  
    if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; }                 
    echo    '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" /> 
                <img src="'.$image.'" class="custom_preview_image" alt="" /><br /> 
                    <input class="custom_upload_image_button button" type="button" value="Choose Image" /> 
                    <small> <a href="#" class="custom_clear_image_button">Remove Image</a></small> 
                    <br clear="all" /><span class="description">'.$field['desc'].'<hr />';  
break;  
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// Save the Data
function save_custom_meta($post_id) {
    global $custom_meta_fields;
	
	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('call_centres' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	if ('disabled_workers' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	
	// loop through fields and save the data
	foreach ($custom_meta_fields as $field) {
		if($field['type'] == 'tax_select') continue;
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // enf foreach
	
	// save taxonomies
	$post = get_post($post_id);
	$category = $_POST['category'];
	wp_set_object_terms( $post_id, $category, 'category' );
}
add_action('save_post', 'save_custom_meta');


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Partners post type     /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_action('init', 'create_partners');

function create_partners() {

	$labels = array(
			'name' => __('Partners', 'post type general name'),
			'singular_name' => __('Partner', 'post type singular name'),
			'add_new' => __('Add New', 'partner'),
			'add_new_item' => __('Add New Partner'),
			'edit_item' => __('Edit Partner'),
			'new_item' => __('New Partner'),
			'view_item' => __('View Partner'),
			'search_items' => __('Search Partners'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => 'Partners'
	);

	$partners_args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','comments', 'author')
	);
	register_post_type('partners',$partners_args);
}

// Add the Meta Box
function partners_add_custom_meta_box() {
	add_meta_box(
			'custom_meta_box', // $id
			__('Partners Info', 'essentials'), // $title
			'partners_show_custom_meta_box', // $callback
			'partners', // $page
			'normal', // $context
			'high'); // $priority
}
add_action('add_meta_boxes', 'partners_add_custom_meta_box');

// Field Array
$prefix = 'partners_';

$partners_custom_meta_fields = array(
		array(
				'label'	=> __('Partner Title'),
				'desc'	=> __('Enter the professional title of this partner.'),
				'id'	=> $prefix.'partnertitle',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Partner Head Shot Image'),
				'desc'	=> __('Upload partner head shot image here.  Recommended size is 310px X 400px.'),
				'id'	=> $prefix.'partnerheadshot',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 1 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 1.'),
				'id'	=> $prefix.'textlink',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 1 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 1.'),
				'id'	=> $prefix.'text',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 1'),
				'desc'	=> __('Upload your social media image 1'),
				'id'	=> $prefix.'image',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 2 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 2.'),
				'id'	=> $prefix.'textlink2',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 2 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 2.'),
				'id'	=> $prefix.'text2',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 2'),
				'desc'	=> __('Upload your social media image 2'),
				'id'	=> $prefix.'image2',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 3 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 3.'),
				'id'	=> $prefix.'textlink3',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 3 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 3.'),
				'id'	=> $prefix.'text3',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 3'),
				'desc'	=> __('Upload your social media image 3'),
				'id'	=> $prefix.'image3',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 4 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 4.'),
				'id'	=> $prefix.'textlink4',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 4 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 4.'),
				'id'	=> $prefix.'text4',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 4'),
				'desc'	=> __('Upload your social media image 4'),
				'id'	=> $prefix.'image4',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 5 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 5.'),
				'id'	=> $prefix.'textlink5',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 5 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 5.'),
				'id'	=> $prefix.'text5',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 5'),
				'desc'	=> __('Upload your social media image 5'),
				'id'	=> $prefix.'image5',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 6 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 6.'),
				'id'	=> $prefix.'textlink6',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 6 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 6.'),
				'id'	=> $prefix.'text6',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 6'),
				'desc'	=> __('Upload your social media image 6'),
				'id'	=> $prefix.'image6',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 7 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 7.'),
				'id'	=> $prefix.'textlink7',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 7 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 7.'),
				'id'	=> $prefix.'text7',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 7'),
				'desc'	=> __('Upload your social media image 7'),
				'id'	=> $prefix.'image7',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Partners Single Page Full Width Image'),
				'desc'	=> __('Upload the full width image that will display on the partners single page.  Recommended size is 980px X your choice of height.'),
				'id'	=> $prefix.'partnersfullwidthimage',
				'type'	=> 'image'
		)
);

//Hook on admin_enqueue_scripts
add_action('admin_enqueue_scripts' , 'partners_my_scripts' );

//Do enqueue
function partners_my_scripts(){
	//jQuery datepicker is already bundled with WordPress
	//See link above
	wp_enqueue_script('custom-js', get_template_directory_uri().'/js/custom-js.js');
	//But jQuery theme is unbundled. Load you own.
	wp_enqueue_style('jquery-ui-custom', get_template_directory_uri().'/css/jquery-ui-custom.css', false ,'1.1', 'all' );
}


// The Callback
function partners_show_custom_meta_box() {
	global $partners_custom_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($partners_custom_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
		<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
		<td>';
		switch($field['type']) {
			// text
			case 'text':
				echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
				<br /><span class="description">'.$field['desc'].'</span>';
				break;
				// image
			case 'image':
				$image = get_template_directory_uri().'/img/image.png';
				echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
				if ($meta) {
					$image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0];
				}
				echo    '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
				<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
				<input class="custom_upload_image_button button" type="button" value="Choose Image" />
				<small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
				<br clear="all" /><span class="description">'.$field['desc'].'<hr />';
				break;
		} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// Save the Data
function partners_save_custom_meta($post_id) {
	global $partners_custom_meta_fields;

	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('call_centres' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	if ('disabled_workers' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	// loop through fields and save the data
	foreach ($partners_custom_meta_fields as $field) {
		if($field['type'] == 'tax_select') continue;
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // enf foreach

	// save taxonomies
	$post = get_post($post_id);
	$category = $_POST['category'];
	wp_set_object_terms( $post_id, $category, 'category' );
}
add_action('save_post', 'partners_save_custom_meta');

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Affiliates post type     /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_action('init', 'create_affiliates');

function create_affiliates() {

	$labels = array(
			'name' => __('Affiliates', 'post type general name'),
			'singular_name' => __('Affiliate', 'post type singular name'),
			'add_new' => __('Add New', 'Affiliate'),
			'add_new_item' => __('Add New Affiliate'),
			'edit_item' => __('Edit Affiliate'),
			'new_item' => __('New Affiliate'),
			'view_item' => __('View Affiliate'),
			'search_items' => __('Search Affiliates'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => 'Affiliate'
	);

	$affiliates_args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','comments', 'author')
	);
	register_post_type('affiliates',$affiliates_args);
}

// Add the Meta Box
function affiliates_add_custom_meta_box() {
	add_meta_box(
			'custom_meta_box', // $id
			__('Affiliates Info', 'essentials'), // $title
			'affiliates_show_custom_meta_box', // $callback
			'affiliates', // $page
			'normal', // $context
			'high'); // $priority
}
add_action('add_meta_boxes', 'affiliates_add_custom_meta_box');

// Field Array
$prefix = 'affiliates_';

$affiliates_custom_meta_fields = array(
		array(
				'label'	=> __('Affiliate Title'),
				'desc'	=> __('Enter the professional title of this affiliate.'),
				'id'	=> $prefix.'affiliatetitle',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Affiliate Head Shot Image'),
				'desc'	=> __('Upload affiliate head shot image here.  Recommended size is 310px X 400px.'),
				'id'	=> $prefix.'affiliateheadshot',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 1 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 1.'),
				'id'	=> $prefix.'textlink',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 1 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 1.'),
				'id'	=> $prefix.'text',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 1'),
				'desc'	=> __('Upload your social media image 1'),
				'id'	=> $prefix.'image',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 2 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 2.'),
				'id'	=> $prefix.'textlink2',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 2 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 2.'),
				'id'	=> $prefix.'text2',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 2'),
				'desc'	=> __('Upload your social media image 2'),
				'id'	=> $prefix.'image2',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 3 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 3.'),
				'id'	=> $prefix.'textlink3',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 3 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 3.'),
				'id'	=> $prefix.'text3',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 3'),
				'desc'	=> __('Upload your social media image 3'),
				'id'	=> $prefix.'image3',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 4 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 4.'),
				'id'	=> $prefix.'textlink4',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 4 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 4.'),
				'id'	=> $prefix.'text4',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 4'),
				'desc'	=> __('Upload your social media image 4'),
				'id'	=> $prefix.'image4',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 5 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 5.'),
				'id'	=> $prefix.'textlink5',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 5 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 5.'),
				'id'	=> $prefix.'text5',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 5'),
				'desc'	=> __('Upload your social media image 5'),
				'id'	=> $prefix.'image5',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 6 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 6.'),
				'id'	=> $prefix.'textlink6',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 6 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 6.'),
				'id'	=> $prefix.'text6',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 6'),
				'desc'	=> __('Upload your social media image 6'),
				'id'	=> $prefix.'image6',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Social Icon 7 Link'),
				'desc'	=> __('Enter the link you want for the social media icon 7.'),
				'id'	=> $prefix.'textlink7',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Social Icon 7 Image Alt Text'),
				'desc'	=> __('Enter the title text to display for the social media icon 7.'),
				'id'	=> $prefix.'text7',
				'type'	=> 'text'
		),
		array(
				'label'	=> __('Upload the Social Media Image 7'),
				'desc'	=> __('Upload your social media image 7'),
				'id'	=> $prefix.'image7',
				'type'	=> 'image'
		),
		array(
				'label'	=> __('Affiliates Single Page Full Width Image'),
				'desc'	=> __('Upload the full width image that will display on the affiliates single page.  Recommended size is 980px X your choice of height.'),
				'id'	=> $prefix.'affiliatesfullwidthimage',
				'type'	=> 'image'
		)
);

//Hook on admin_enqueue_scripts
add_action('admin_enqueue_scripts' , 'affiliates_my_scripts' );

//Do enqueue
function affiliates_my_scripts(){
	//jQuery datepicker is already bundled with WordPress
	//See link above
	wp_enqueue_script('custom-js', get_template_directory_uri().'/js/custom-js.js');
	//But jQuery theme is unbundled. Load you own.
	wp_enqueue_style('jquery-ui-custom', get_template_directory_uri().'/css/jquery-ui-custom.css', false ,'1.1', 'all' );
}


// The Callback
function affiliates_show_custom_meta_box() {
	global $affiliates_custom_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($affiliates_custom_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
		<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
		<td>';
		switch($field['type']) {
			// text
			case 'text':
				echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
				<br /><span class="description">'.$field['desc'].'</span>';
				break;
				// image
			case 'image':
				$image = get_template_directory_uri().'/img/image.png';
				echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
				if ($meta) {
					$image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0];
				}
				echo    '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
				<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
				<input class="custom_upload_image_button button" type="button" value="Choose Image" />
				<small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
				<br clear="all" /><span class="description">'.$field['desc'].'<hr />';
				break;
		} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// Save the Data
function affiliates_save_custom_meta($post_id) {
	global $affiliates_custom_meta_fields;

	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('call_centres' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	if ('disabled_workers' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	// loop through fields and save the data
	foreach ($affiliates_custom_meta_fields as $field) {
		if($field['type'] == 'tax_select') continue;
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // enf foreach

	// save taxonomies
	$post = get_post($post_id);
	$category = $_POST['category'];
	wp_set_object_terms( $post_id, $category, 'category' );
}
add_action('save_post', 'affiliates_save_custom_meta');



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     PAGINATION     //////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

		
function pagination($pages = '', $range = 1)
{ 
     $showitems = ($range * 2)+1; 
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Slider post type     ////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_action('init', 'slider_register');
 
function slider_register() {
 
	$labels = array(
		'name' => __('Slider Images', 'post type general name'),
		'singular_name' => __('Slider Item', 'post type singular name'),
		'add_new' => __('Add New', 'slider item'),
		'add_new_item' => __('Add New Slider Item'),
		'edit_item' => __('Edit Slider Item'),
		'new_item' => __('New Slider Item'),
		'view_item' => __('View Slider Item'),
		'search_items' => __('Search Slider'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail')
	  ); 
 
	register_post_type( 'slider' , $args );
}


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Case Study post type     ////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_action('init', 'casestudy_register');
 
function casestudy_register() {
 
	$labels = array(
		'name' => __('Case Study', 'post type general name'),
		'singular_name' => __('Case Study', 'post type singular name'),
		'add_new' => __('Add New', 'case study item'),
		'add_new_item' => __('Add New Case Study Item'),
		'edit_item' => __('Edit Case Study Item'),
		'new_item' => __('New Case Study Item'),
		'view_item' => __('View Case Study Item'),
		'search_items' => __('Search Case Study'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => 'Case Study'
	);
 
	$casestudyargs = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','comments')
	  ); 
 
	register_post_type( 'casestudy' , $casestudyargs );
}


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Change excerpt length     ///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}


////////////////////////////////////////////////////////////////////////////////////////////
/////////////////    Extract first occurance of text from a string     /////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

// Extract first occurance of text from a string
function my_extract_from_string($start, $end, $tring) {
	$tring = stristr($tring, $start);
	$trimmed = stristr($tring, $end);
	return substr($tring, strlen($start), -strlen($trimmed));
}


function get_content_link( $content = false, $echo = false )
{
    // allows using this function also for excerpts
    if ( $content === false )
        $content = get_the_content(); // You could also use $GLOBALS['post']->post_content;

    $content = preg_match_all( '/href\s*=\s*[\"\']([^\"\']+)/', $content, $links );
    $content = $links[1][0];
    $content = make_clickable( $content );

    // if you set the 2nd arg to true, you'll echo the output, else just return for later usage
    if ( $echo === true )
        echo $content;

    return $content;
}

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Shortcodes    ///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


//	blockquote
add_shortcode('quote', 'tws_quote');

function tws_quote($atts, $content = null) {
	return '<div class="quote">' .do_shortcode($content).'</div>';
}

//	intro
add_shortcode('intro', 'tws_intro');

function tws_intro($atts, $content = null) {
	return '<div class="intro">' .do_shortcode($content).'</div>';
}

//	hr
add_shortcode('hr', 'tws_hr');

function tws_hr($atts, $content = null) {
	return '<div class="hrr">' .do_shortcode($content).'</div>';
}

//	pullquoteleft
add_shortcode('pullquoteleft', 'tws_pullquoteleft');

function tws_pullquoteleft($atts, $content = null) {
	return '<div class="pullquoteleft">' .do_shortcode($content).'</div>';
}

//	pullquoteright
add_shortcode('pullquoteright', 'tws_pullquoteright');

function tws_pullquoteright($atts, $content = null) {
	return '<div class="pullquoteright">' .do_shortcode($content).'</div>';
}

//	alert_yellow
add_shortcode('alert_yellow', 'tws_alert_yellow');

function tws_alert_yellow($atts, $content = null) {
	return '<div class="alert_yellow">' .do_shortcode($content).'</div>';
}

//	alert_blue
add_shortcode('alert_blue', 'tws_alert_blue');

function tws_alert_blue($atts, $content = null) {
	return '<div class="alert_blue">' .do_shortcode($content).'</div>';
}

//	alert_green
add_shortcode('alert_green', 'tws_alert_green');

function tws_alert_green($atts, $content = null) {
	return '<div class="alert_green">' .do_shortcode($content).'</div>';
}

//	alert_red
add_shortcode('alert_red', 'tws_alert_red');

function tws_alert_red($atts, $content = null) {
	return '<div class="alert_red">' .do_shortcode($content).'</div>';
}

//	one_half
add_shortcode('one_half', 'tws_one_half');

function tws_one_half($atts, $content = null) {
	return '<div class="one_half">' .do_shortcode($content).'</div>';
}

//	one_third
add_shortcode('one_third', 'tws_one_third');

function tws_one_third($atts, $content = null) {
	return '<div class="one_third">' .do_shortcode($content).'</div>';
}

//	two_third
add_shortcode('two_third', 'tws_two_third');

function tws_two_third($atts, $content = null) {
	return '<div class="two_third">' .do_shortcode($content).'</div>';
}

//	one_fourth
add_shortcode('one_fourth', 'tws_one_fourth');

function tws_one_fourth($atts, $content = null) {
	return '<div class="one_fourth">' .do_shortcode($content).'</div>';
}

//	three_fourth
add_shortcode('three_fourth', 'tws_three_fourth');

function tws_three_fourth($atts, $content = null) {
	return '<div class="three_fourth">' .do_shortcode($content).'</div>';
}

//	one_fifth
add_shortcode('one_fifth', 'tws_one_fifth');

function tws_one_fifth($atts, $content = null) {
	return '<div class="one_fifth">' .do_shortcode($content).'</div>';
}

//	two_fifth
add_shortcode('two_fifth', 'tws_two_fifth');

function tws_two_fifth($atts, $content = null) {
	return '<div class="two_fifth">' .do_shortcode($content).'</div>';
}

//	three_fifth
add_shortcode('three_fifth', 'tws_three_fifth');

function tws_three_fifth($atts, $content = null) {
	return '<div class="three_fifth">' .do_shortcode($content).'</div>';
}

//	four_fifth
add_shortcode('four_fifth', 'tws_four_fifth');

function tws_four_fifth($atts, $content = null) {
	return '<div class="four_fifth">' .do_shortcode($content).'</div>';
}

//	one_sixth
add_shortcode('one_sixth', 'tws_one_sixth');

function tws_one_sixth($atts, $content = null) {
	return '<div class="one_sixth">' .do_shortcode($content).'</div>';
}

//	five_sixth
add_shortcode('five_sixth', 'tws_five_sixth');

function tws_five_sixth($atts, $content = null) {
	return '<div class="five_sixth">' .do_shortcode($content).'</div>';
}

//	one_half_first
add_shortcode('one_half_first', 'tws_one_half_first');

function tws_one_half_first($atts, $content = null) {
	return '<div class="one_half_first">' .do_shortcode($content).'</div>';
}

//	one_third_first
add_shortcode('one_third_first', 'tws_one_third_first');

function tws_one_third_first($atts, $content = null) {
	return '<div class="one_third_first">' .do_shortcode($content).'</div>';
}

//	one_fourth_first
add_shortcode('one_fourth_first', 'tws_one_fourth_first');

function tws_one_fourth_first($atts, $content = null) {
	return '<div class="one_fourth_first">' .do_shortcode($content).'</div>';
}

//	one_fifth_first
add_shortcode('one_fifth_first', 'tws_one_fifth_first');

function tws_one_fifth_first($atts, $content = null) {
	return '<div class="one_fifth_first">' .do_shortcode($content).'</div>';
}

//	one_sixth_first
add_shortcode('one_sixth_first', 'tws_one_sixth_first');

function tws_one_sixth_first($atts, $content = null) {
	return '<div class="one_sixth_first">' .do_shortcode($content).'</div>';
}

//	two_third_first
add_shortcode('two_third_first', 'tws_two_third_first');

function tws_two_third_first($atts, $content = null) {
	return '<div class="two_third_first">' .do_shortcode($content).'</div>';
}

//	three_fourth_first
add_shortcode('three_fourth_first', 'tws_three_fourth_first');

function tws_three_fourth_first($atts, $content = null) {
	return '<div class="three_fourth_first">' .do_shortcode($content).'</div>';
}

//	two_fifth_first
add_shortcode('two_fifth_first', 'tws_two_fifth_first');

function tws_two_fifth_first($atts, $content = null) {
	return '<div class="two_fifth_first">' .do_shortcode($content).'</div>';
}

//	three_fifth_first
add_shortcode('three_fifth_first', 'tws_three_fifth_first');

function tws_three_fifth_first($atts, $content = null) {
	return '<div class="three_fifth_first">' .do_shortcode($content).'</div>';
}

//	four_fifth_first
add_shortcode('four_fifth_first', 'tws_four_fifth_first');

function tws_four_fifth_first($atts, $content = null) {
	return '<div class="four_fifth_first">' .do_shortcode($content).'</div>';
}

//	button_red
add_shortcode('button_red', 'tws_button_red');

function tws_button_red($atts, $content = null) {
	return '<div class="button_red">' .do_shortcode($content).'</div>';
}

//	button_green
add_shortcode('button_green', 'tws_button_green');

function tws_button_green($atts, $content = null) {
	return '<div class="button_green">' .do_shortcode($content).'</div>';
}

//	button_blue
add_shortcode('button_blue', 'tws_button_blue');

function tws_button_blue($atts, $content = null) {
	return '<div class="button_blue">' .do_shortcode($content).'</div>';
}

//	button_red_image
add_shortcode('button_red_image', 'tws_button_red_image');

function tws_button_red_image($atts, $content = null) {
	return '<div class="button_red_image">' .do_shortcode($content).'</div>';
}

//	button_green_image
add_shortcode('button_green_image', 'tws_button_green_image');

function tws_button_green_image($atts, $content = null) {
	return '<div class="button_green_image">' .do_shortcode($content).'</div>';
}

//	button_blue_image
add_shortcode('button_blue_image', 'tws_button_blue_image');

function tws_button_blue_image($atts, $content = null) {
	return '<div class="button_blue_image">' .do_shortcode($content).'</div>';
}



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Remove shortcode from excerpt     ///////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_trim_excerpt');

function custom_trim_excerpt($text = '')
{
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');
 
		//$text = strip_shortcodes( $text );
 
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]&gt;', ']]&gt;', $text);
		$excerpt_length = apply_filters('excerpt_length', 25);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

add_filter('get_the_excerpt','do_shortcode');



////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Allow Shortcodes in Widgets     /////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_filter('widget_text', 'do_shortcode');


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Remove height/width on images for responsive     ////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////              Exclude thumbnail from gallery              ////////////
////////////////////////////////////////////////////////////////////////////////////////////


function exclude_thumbnail_from_gallery($null, $attr)
{
    if (!$thumbnail_ID = get_post_thumbnail_id())
        return $null; // no point carrying on if no thumbnail ID

    // temporarily remove the filter, otherwise endless loop!
    remove_filter('post_gallery', 'exclude_thumbnail_from_gallery');

    // pop in our excluded thumbnail
    if (!isset($attr['exclude']) || empty($attr['exclude']))
        $attr['exclude'] = array($thumbnail_ID);
    elseif (is_array($attr['exclude']))
        $attr['exclude'][] = $thumbnail_ID;

    // now manually invoke the shortcode handler
    $gallery = gallery_shortcode($attr);

    // add the filter back
    add_filter('post_gallery', 'exclude_thumbnail_from_gallery', 10, 2);

    // return output to the calling instance of gallery_shortcode()
    return $gallery;
}
add_filter('post_gallery', 'exclude_thumbnail_from_gallery', 10, 2);




////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////    Link Extraction for Post Format Link     /////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


// Extract first occurance of text from a string
if( !function_exists ('extract_from_string') ) :
function extract_from_string($start, $end, $tring) {
	$tring = stristr($tring, $start);
	$trimmed = stristr($tring, $end);
	return substr($tring, strlen($start), -strlen($trimmed));
}
endif;



function filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

function cleanup_shortcode_fix($content) {   
          $array = array (
            '<p>[' => '[', 
            ']</p>' => ']', 
            ']<br />' => ']',
            ']<br>' => ']',
			'<br />' => '',
			'<br>' => ''
          );
          $content = strtr($content, $array);
            return $content;
        }
        add_filter('the_content', 'cleanup_shortcode_fix', 10);


function modify_contact_methods($profile_fields) {

	// Add new fields
	#$profile_fields['gplus'] = 'Google+ URL';
	$profile_fields['skype'] = 'Skype';

	// Remove old fields
	unset($profile_fields['aim']);
	unset($profile_fields['url']);
	unset($profile_fields['yim']);
	unset($profile_fields['twitter']);

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');	
		
?>