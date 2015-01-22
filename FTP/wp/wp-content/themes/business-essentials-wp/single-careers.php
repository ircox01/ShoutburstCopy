<?php get_header(); ?>

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of header wrapper -->

<!-- Start of breadcrumb wrapper -->
<div class="breadcrumb_wrapper">

<div class="breadcrumbs">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>
</div>

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of breadcrumb wrapper -->

<!-- Start of content wrapper -->
<div id="contentwrapper">

<!-- Start of content wrapper -->
<div class="content_wrapper">

<!-- Start of left content -->
<div class="left_content">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<?php
$printicontext = get_post_meta($post->ID, 'printicontext', $single = true); 
$downloadicontext = get_post_meta($post->ID, 'downloadicontext', $single = true); 
$pdf = get_post_meta(get_the_ID(), 'wp_custom_attachment', true); 
?>

<!-- Start of blog wrapper -->
<div class="blog_wrapper">

<?php 
if ( has_post_thumbnail() ) {  ?>

<?php the_post_thumbnail('slide'); ?>

<?php } ?>

<h2><?php the_title (); ?></h2>

<!-- Start of post details -->
<div class="post_details">

<!-- Start of post date -->
<div class="post_date">
<?php the_time('m.d.Y') ?>

</div><!-- End of post date -->

<?php if ($printicontext != ('')){ ?>

<!-- Start of career print -->
<div class="career_print">

<a href="javascript:window.print()"><?php echo stripslashes($printicontext); ?></a>

</div><!-- End of career print -->

<div class="career_split"></div>

<?php } else { } ?>

<?php if ($pdf != ('')){ ?>

<!-- Start of PDF download -->
<div class="pdf_download">

<a href="<?php echo $pdf['url']; ?>"><?php echo stripslashes($downloadicontext); ?></a>

</div><!-- End of PDF download -->

<?php } else { } ?>

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of post details -->

<!-- Clear Fix --><div class="clearbig"></div>

<?php the_content('        '); ?> 

<?php endwhile; ?> 

<?php else: ?> 
<p><?php _e( 'There are no posts to display. Try using the search.', 'essentials' ); ?></p> 

<?php endif; ?>

<?php if ('open' == $post->comment_status) { ?>

<!-- Clear Fix --><div class="clearbig"></div>

<!-- Start of comment wrapper -->
<div class="comment_wrapper">

<!-- Start of comment wrapper main -->
<div class="comment_wrapper_main">

<?php comments_template(); ?>
<?php comment_form(); ?>

</div><!-- End of comment wrapper main -->

<div class="clear"></div>

</div><!-- End of comment wrapper -->

<?php } ?> 

</div><!-- End of blog wrapper -->

</div><!-- End of left content -->

<!-- Start of right content -->
<div class="right_content">
<?php get_sidebar ('careers'); ?> 

</div><!-- End of right content -->

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of content wrapper -->

<?php get_footer(); ?>