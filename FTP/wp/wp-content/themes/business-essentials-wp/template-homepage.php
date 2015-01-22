<?php  
/* 
Template Name: Homepage-DynamicWithSlider
*/  
?>

<?php get_header(); ?>

<!-- Start of slider wrapper -->
<section class="slider_wrapper">

<!-- Start of slider -->
<section class="slider">

<ul class="slides">

<?php
$my_query = null;
$my_query = new WP_Query('post_type=slider&showposts=10');
$my_query->query('post_type=slider&showposts=10');
?>

<?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?> 
<li>
<?php the_content(); ?>
</li>

<?php endwhile; ?>

</ul>

<?php wp_reset_query(); ?>
    
</section><!-- End of slider -->

<!-- Start of clear fix --><div class="clear"></div>

</section><!-- End of slider wrapper -->

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of header wrapper -->

<!-- Start of message wrapper -->
<div id="message_wrapper">

<!-- Start of content wrapper -->
<div class="content_wrapper">

<?php 
if ( function_exists( 'get_option_tree' ) ) {
$homepagemessageleft = get_option_tree( 'vn_homepagemessageleft' );
} ?>

<?php if ($homepagemessageleft != ('')){ ?>

<!-- Start of contentleft -->
<div class="contentleft">
<p><?php echo stripslashes($homepagemessageleft); ?></p>

</div><!-- End of contentleft -->

<?php } else { } ?>

<?php 
if ( function_exists( 'get_option_tree' ) ) {
$homepagemessageright = get_option_tree( 'vn_homepagemessageright' );
} ?>

<?php if ($homepagemessageright != ('')){ ?>

<!-- Start of contentright -->
<div class="contentright">
<?php echo $homepagemessageright; ?>

</div><!-- End of contentright -->

<?php } else { } ?>

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of message wrapper -->

<!-- Start of content wrapper -->
<div id="contentwrapper">

<!-- Start of content wrapper -->
<div class="content_wrapper">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php the_content('        '); ?> 

<?php endwhile; endif; ?>

<?php wp_reset_query(); ?>

<div class="clear"></div>

<hr />

<!-- Start of one half first -->
<div class="one_half_first">
<?php 
if ( function_exists( 'get_option_tree' ) ) {
$homepageleftcolumntitle = get_option_tree( 'vn_homepageleftcolumntitle' );
} ?>

<?php if ($homepageleftcolumntitle != ('')){ ?>

<h3><?php echo stripslashes($homepageleftcolumntitle); ?></h3>

<?php } else { } ?>

<?php 
if ( function_exists( 'get_option_tree' ) ) {
$homepageleftcolumnlinktext = get_option_tree( 'vn_homepageleftcolumnlinktext' );
$homepageleftcolumnlink = get_option_tree( 'vn_homepageleftcolumnlink' );
} ?>

<?php if ($homepageleftcolumnlinktext != ('')){ ?>

<!-- Start of view all -->
<div class="viewall">
<a href="<?php echo $homepageleftcolumnlink; ?>"><?php echo stripslashes($homepageleftcolumnlinktext); ?></a>

</div><!-- End of view all -->

<?php } else { } ?>

<!-- Start of homepage slider section -->
<div class="homepage_slider_section">

<!-- Start of slider -->
<section class="slider">

<ul class="slides">

<?php
$casestudy_query = null;
$casestudy_query = new WP_Query('post_type=casestudy&showposts=5');
$casestudy_query->query('post_type=casestudy&showposts=5');
?>

<?php while ( $casestudy_query->have_posts() ) : $casestudy_query->the_post();  ?>

<li>
<a href="<?php the_permalink (); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('slide'); ?></a>
</li>

<?php endwhile; ?>

</ul>

<?php wp_reset_query(); ?>
    
</section><!-- End of slider -->

</div><!-- End of homepage slider section -->

</div><!-- End of one half first -->

<!-- Start of one half -->
<div class="one_half">
<?php 
if ( function_exists( 'get_option_tree' ) ) {
$homepagerightcolumntitle = get_option_tree( 'vn_homepagerightcolumntitle' );
} ?>

<?php if ($homepagerightcolumntitle != ('')){ ?>

<h3><?php echo stripslashes($homepagerightcolumntitle); ?></h3>

<?php } else { } ?>

<?php 
if ( function_exists( 'get_option_tree' ) ) {
$homepageleftcolumnlinktext = get_option_tree( 'vn_homepagerightcolumnlinktext' );
$homepagerightcolumnlink = get_option_tree( 'vn_homepagerightcolumnlink' );
} ?>

<?php if ($homepageleftcolumnlinktext != ('')){ ?>

<!-- Start of view all -->
<div class="viewall">
<a href="<?php echo $homepagerightcolumnlink; ?>"><?php echo stripslashes($homepageleftcolumnlinktext); ?></a>

</div><!-- End of view all -->

<?php } else { } ?>

<!-- Start of homepage slider section -->
<div class="homepage_slider_section">

<!-- Start of slider -->
<section class="slider">

<ul class="slides">

<?php
$blog_query = null;
$blog_query = new WP_Query('post_type=post&showposts=5');
$blog_query->query('post_type=post&showposts=5');
?>

<?php while ( $blog_query->have_posts() ) : $blog_query->the_post();  ?>

<li>

<div class="flex-caption">

<div class="contentright">

<?php the_time('F j, Y') ?>

</div>

<h4><?php the_title (); ?></h4>

<?php the_excerpt (); ?>

<a href="<?php the_permalink (); ?>"><?php _e( 'Continue Reading', 'essentials' ); ?></a>

</div>

</li>

<?php endwhile; ?>

</ul>

<?php wp_reset_query(); ?>
    
</section><!-- End of slider -->

</div><!-- End of homepage slider section -->

</div><!-- End of one half -->

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of content wrapper -->

<?php get_footer(); ?>