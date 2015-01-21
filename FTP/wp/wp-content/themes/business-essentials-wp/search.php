<?php get_header(); ?>

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of header wrapper -->

<!-- Start of breadcrumb wrapper -->
<div class="breadcrumb_wrapper">

<!-- Start of breadcrumb -->
<div class="breadcrumbs">
<?php _e( 'Results For: ', 'essentials' ); ?> <?php echo($s); ?>

</div><!-- End of breadcrumb -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of breadcrumb wrapper -->

<!-- Start of content wrapper -->
<div id="contentwrapper">

<!-- Start of content wrapper -->
<div class="content_wrapper">

<!-- Start of left content -->
<div class="left_content">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<!-- Start of blog wrapper -->
<div class="blog_wrapper">

<h5><a href="<?php the_permalink (); ?>"><?php the_title (); ?></a></h5>

<?php the_excerpt (); ?>

<!-- Start of post details -->
<div class="post_details">

<!-- Start of post date -->
<div class="post_date">
<?php the_time('m.d.Y') ?>

</div><!-- End of post date -->

<!-- Start of post read more -->
<div class="post_read_more">
<a href="<?php the_permalink (); ?>"><?php _e( 'Continue Reading', 'essentials' ); ?><img src="<?php echo get_template_directory_uri(); ?>/img/red-hoverarrow.png" width="15" height="15" alt="red arrow" /></a>

</div><!-- End of post read more -->

</div><!-- End of post details -->

</div><!-- End of blog wrapper -->

<?php endwhile; ?> 

<?php else: ?> 
<p><?php _e( 'There are no posts to display. Try using the search.', 'essentials' ); ?></p> 

<?php endif; ?>

</div><!-- End of left content -->

<!-- Start of right content -->
<div class="right_content">
<?php get_sidebar ('page'); ?> 

</div><!-- End of right content -->

<!-- Start of pagination -->
<div class="pagination">
<?php if (function_exists("pagination")) {
    pagination($wp_query->max_num_pages);
} ?>

</div><!-- End of pagination -->

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of content wrapper -->
           
<?php get_footer(); ?>