<?php
if ( function_exists('register_sidebars') ) {
register_sidebar(array(
	'name' => __( 'Page-Right', 'essentials' ),
	'id' => 'page',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Page-Left', 'essentials' ),
	'id' => 'page-left',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Blog-Right', 'essentials' ),
	'id' => 'blog',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Blog-Left', 'essentials' ),
	'id' => 'blog-left',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Callcentres Page', 'essentials' ),
	'id' => 'call_centres',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Disabled Page', 'essentials' ),
	'id' => 'disabled_workers',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Footer One', 'essentials' ),
	'id' => 'footer_one',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Footer Two', 'essentials' ),
	'id' => 'footer_two',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Footer Three', 'essentials' ),
	'id' => 'footer_three',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Footer Four', 'essentials' ),
	'id' => 'footer_four',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
register_sidebar(array(
	'name' => __( 'Footer Social Icons', 'essentials' ),
	'id' => 'social',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));
}
?>