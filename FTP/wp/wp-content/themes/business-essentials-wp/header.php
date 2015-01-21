<!DOCTYPE HTML>

<html <?php language_attributes(); ?>>

<!--[if IE 7 ]>    <html class= "ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class= "ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class= "ie9"> <![endif]-->

<!--[if lt IE 9]>
   <script>
      document.createElement('header');
      document.createElement('nav');
      document.createElement('section');
      document.createElement('article');
      document.createElement('aside');
      document.createElement('footer');
   </script>
<![endif]-->


<title><?php echo get_option('blogname'); ?><?php wp_title(); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<?php 
if ( function_exists( 'get_option_tree') ) {
  $specstyle = get_option_tree( 'vn_specstyle' );
  }
?>
<?php if ($specstyle != ('')){ ?>

<link href="<?php echo ($specstyle); ?>" rel="stylesheet" type="text/css" media="screen" />

<?php } else { ?>

<link href="<?php bloginfo('stylesheet_url') ?>" rel="stylesheet" type="text/css" media="screen" />

<?php } ?>

<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

 <!-- *************************************************************************
*****************                FAVICON               ********************
************************************************************************** -->

<?php 
if ( function_exists( 'get_option_tree') ) {
  $favicon = get_option_tree( 'vn_favicon' );
}
?>
<link rel="shortcut icon" href="<?php echo ($favicon); ?>" />

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- *************************************************************************
*****************              CUSTOM CSS              ********************
************************************************************************** -->


<style type="text/css">
<?php 
if ( function_exists( 'get_option_tree') ) {
  $css = get_option_tree( 'vn_customcss' );
}
?>
<?php echo ($css); ?>
	
</style>

<?php wp_head(); ?> 

</head>

<?php $theme_options = get_option('option_tree'); ?>

<body <?php body_class(); ?>>

<!-- Start of top wrapper -->
<div id="top_wrapper">

<!-- Start of content wrapper -->
<div class="content_wrapper">

<!-- Start of topsubmenu -->
<div class="topsubmenu">

<?php wp_nav_menu(
array(
'theme_location'  => 'topsub',
)
);
?>

</div><!-- End of topsubmenu -->
<!-- Start of searchbox -->
<div id="searchbox">
<div id='jsfontsize-div' style="float:left">
                    <a id="jfontsize-default" href="#" title="Deafult size"><img src="http://contactability.org.uk/wp/wp-content/themes/business-essentials-wp/img/btnDefault.jpg" alt="Default font size" /></a>
                    <a id="jfontsize-plus" href="#" title="Increase size"><img src="http://contactability.org.uk/wp/wp-content/themes/business-essentials-wp/img/btnPlus.jpg" alt="Increase font size" /></a>
</div>
<!-- Start of search box -->
<?php get_search_form(); ?>
<!-- End of searchbox -->

</div><!-- End of searchbox -->

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of top wrapper -->

<!-- Start of header wrapper -->
<div id="header_wrapper">

<!-- Start of content wrapper -->
<div class="content_wrapper">

<!-- Start of logo -->
<div id="logo">
<a href="<?php echo site_url(); ?>"><?php 
if ( function_exists( 'get_option_tree' ) ) {
$logopath = get_option_tree( 'vn_toplogo' );
} ?><img src="<?php echo $logopath; ?>" alt="logo" /></a>

</div><!-- End of logo -->

<!-- Start of top menu wrapper -->
<div class="topmenuwrapper">

<!-- Start of topmenu -->
<nav class="topmenu">
 
<?php wp_nav_menu(
array(
'menu_class' => 'sf-menu',
'theme_location'  => 'primary',
)
);
?>

</nav><!-- End of topmenu -->

<?php 
if ( function_exists( 'get_option_tree' ) ) {
$telephonenumber = get_option_tree( 'vn_telephonenumber' );
} ?>

<?php if ($telephonenumber != ('')){ ?> 

<!-- Start of header phone -->
<div class="header_phone">
<?php echo stripslashes($telephonenumber); ?>

</div><!-- End of header phone -->

<?php } else { } ?>

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of top menu wrapper -->