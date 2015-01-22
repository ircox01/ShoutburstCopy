<?php  
/* 
Template Name: CaseStudy
*/  
?>

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
<?php
if (have_posts()) :
$counter = 1;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts('post_type=casestudy&posts_per_page=4&paged='. $paged );
   while (have_posts()) :
      the_post();
if( $counter == 1 ) { ?>

<!-- Start of casestudy image -->
<div class="casestudy_image">
<a href="<?php the_permalink (); ?>"><?php the_post_thumbnail('slide'); ?></a>

</div><!-- End of casestudy image -->

<!-- Clear Fix --><div class="clear"></div>

<?php } else { ?>

<!-- Start of case study wrapper -->
<div class="case_study_wrapper">

<!-- Start of one third -->
<div class="one_third">

<!-- Start of casestudy image -->
<div class="casestudy_image">
<a href="<?php the_permalink (); ?>"><?php the_post_thumbnail('slide'); ?></a>

</div><!-- End of casestudy image -->

</div><!-- End of one third -->

</div><!-- end of case study wrapper -->

<?php }
$counter++;
   endwhile;
endif;
?>

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