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

<style>
#logoParade
{
	width: 400px;
	height: 60px;
	position: relative;
}

#logoParade div.scrollableArea a
{
	display: block;
	float: left;
	padding-left: 10px;
}
/* You can alter this CSS in order to give Smooth Div Scroll your own look'n'feel */

/* Invisible left hotspot */
div.scrollingHotSpotLeft
{
	/* The hotspots have a minimum width of 100 pixels and if there is room the will grow
    and occupy 15% of the scrollable area (30% combined). Adjust it to your own taste. */
	min-width: 75px;
	width: 10%;
	height: 100%;
	/* There is a big background image and it's used to solve some problems I experienced
    in Internet Explorer 6. */
	background-image: url(/images/big_transparent.gif);
	background-repeat: repeat;
	background-position: center center;
	position: absolute;
	z-index: 200;
	left: 0;
	/*  The first url is for Firefox and other browsers, the second is for Internet Explorer */
	cursor: url(/images/cursors/cursor_arrow_left.png), url(../images/cursors/cursor_arrow_left.cur),w-resize;
}

/* Visible left hotspot */
div.scrollingHotSpotLeftVisible
{
	background-image: url(/images/arrow_left.gif);				
	background-color: #fff;
	background-repeat: no-repeat;
	opacity: 0.35; /* Standard CSS3 opacity setting */
	-moz-opacity: 0.35; /* Opacity for really old versions of Mozilla Firefox (0.9 or older) */
	filter: alpha(opacity = 35); /* Opacity for Internet Explorer. */
	zoom: 1; /* Trigger "hasLayout" in Internet Explorer 6 or older versions */
}

/* Invisible right hotspot */
div.scrollingHotSpotRight
{
	min-width: 75px;
	width: 10%;
	height: 100%;
	background-image: url(/images/big_transparent.gif);
	background-repeat: repeat;
	background-position: center center;
	position: absolute;
	z-index: 200;
	right: 0;
	cursor: url(/images/cursors/cursor_arrow_right.png), url(/images/cursors/cursor_arrow_right.cur),e-resize;
}

/* Visible right hotspot */
div.scrollingHotSpotRightVisible
{
	background-image: url(/images/arrow_right.gif);
	background-color: #fff;
	background-repeat: no-repeat;
	opacity: 0.35;
	filter: alpha(opacity = 35);
	-moz-opacity: 0.35;
	zoom: 1;
}

/* The scroll wrapper is always the same width and height as the containing element (div).
   Overflow is hidden because you don't want to show all of the scrollable area.
*/
div.scrollWrapper
{
	position: relative;
	overflow: hidden;
	width: 100%;
	height: 100%;
}

div.scrollableArea
{
	position: relative;
	width: auto;
	height: 100%;
}
</style>
<script>

		jQuery(document).ready(function () {
			jQuery("#logoParade").smoothDivScroll({
				autoScrollingMode: "always",
				autoScrollingDirection: "endlessLoopRight",
				autoScrollingStep: 1,
				autoScrollingInterval: 25 
			});

			// Logo parade
			jQuery("#logoParade").bind("mouseover", function () {
				jQuery(this).smoothDivScroll("stopAutoScrolling");
			}).bind("mouseout", function () {
				jQuery(this).smoothDivScroll("startAutoScrolling");
			});

		});
		
</script>
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
<div style="float:right; width:510px;height:60px;margin-top:-12px">
<div style="float:left;height:60px;padding-top:15px;color:white">
Our Sponsors:
</div>
	<div style="float:right">
		<div id='logoParade'>
			<a href="http://www.pipkins.com"><img src="/images/sponsors/pipkins-x.png"></a>
            <a href="http://www.e-qualitylearning.com"><img src="/images/sponsors/eql.png"></a>
			<a href="http://performancetelecom.co.uk"><img src="/images/sponsors/pt.png"></a>
			<a href="http://www.hrdept.co.uk/offices/south-east/west-herts-and-south-beds"><img src="/images/sponsors/hr.png"></a>
			<a href="http://www.kcom.com"><img src="/images/sponsors/kcom.png"></a>
			<a href="http://www.virginmedia.com"><img src="/images/sponsors/vm.png"></a>
			<!--<a href="http://ubm.com"><img src="/images/sponsors/ubm.png"></a>
			<a href="http://www.remploy.co.uk"><img src="/images/sponsors/remploy.png"></a>
			<a href="http://invate.co.uk"><img src="/images/sponsors/invate.png"></a>
			<a href="http://www.disabilityrightsuk.org"><img src="/images/sponsors/dr.png"></a>
			<a href="http://www.ccma.org.uk"><img src="/images/sponsors/ccma.png"></a>
			<a href="http://cbi.org.uk"><img src="/images/sponsors/cbi.png"></a>
			<a href="http://businessdisabilityforum.org.uk"><img src="/images/sponsors/bdf.png"></a>
-->
		</div>
	</div>
</div>
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