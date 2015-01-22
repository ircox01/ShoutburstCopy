<?php  
/* 
Template Name: Homepage-Alternate 
*/  
?>

<?php get_header(); ?>

<!-- Start of slider wrapper -->
<section class="slider_wrapper">

<?php 
if ( has_post_thumbnail() ) {  ?>

<?php the_post_thumbnail('slide'); ?>

<?php } ?>

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

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of content wrapper -->

<?php get_footer(); ?>