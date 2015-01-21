<?php  
/* 
Template Name: affiliates
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
<?
$counter_cc = 0;
?>
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<?php 
if ( has_post_thumbnail() ) {  ?>

<a href="<?php the_permalink (); ?>"><?php the_post_thumbnail('slide'); ?></a>

<?php } ?>


<?php the_content('        '); ?> 

<?php endwhile; ?> 

<?php else: ?> 
<p><?php _e( 'There are no posts to display. Try using the search.', 'essentials' ); ?></p> 

<?php endif; ?>

<div class="clear"></div>

<?php if (have_posts()) : ?>
<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts('post_type=affiliates&posts_per_page=12&orderby=rand&paged='. $paged ); ?>
<?php while (have_posts()) : the_post(); ?>

<!-- Start of partners wrapper -->
<div class="partners_wrapper">

<!-- Start of one third -->
<?if ($counter_cc % 4 == 0){
	print '<div class="one_fourth" style="margin-left: 0px;">';
	$counter_cc++;
}
else{
	$counter_cc++;
	print '<div class="one_fourth">';
}
?>


<?php
$affiliatestitle = get_post_meta($post->ID, 'affiliates_affiliatetitle', $single = true); 
$affiliatesheadshot = get_post_meta($post->ID, 'affiliates_affiliateheadshot', $single = true); 
$affiliatestextlink = get_post_meta($post->ID, 'affiliates_textlink', $single = true); 
$affiliatesalttext = get_post_meta($post->ID, 'affiliates_text', $single = true); 
$affiliatesimage = get_post_meta($post->ID, 'affiliates_image', $single = true); 
$affiliatestextlink2 = get_post_meta($post->ID, 'affiliates_textlink2', $single = true); 
$affiliatesalttext2 = get_post_meta($post->ID, 'affiliates_text2', $single = true); 
$affiliatesimage2 = get_post_meta($post->ID, 'affiliates_image2', $single = true); 
$affiliatestextlink3 = get_post_meta($post->ID, 'affiliates_textlink3', $single = true); 
$affiliatesalttext3 = get_post_meta($post->ID, 'affiliates_text3', $single = true); 
$affiliatesimage3 = get_post_meta($post->ID, 'affiliates_image3', $single = true); 
$affiliatestextlink4 = get_post_meta($post->ID, 'affiliates_textlink4', $single = true); 
$affiliatesalttext4 = get_post_meta($post->ID, 'affiliates_text4', $single = true); 
$affiliatesimage4 = get_post_meta($post->ID, 'affiliates_image4', $single = true); 
$affiliatestextlink5 = get_post_meta($post->ID, 'affiliates_textlink5', $single = true); 
$affiliatesalttext5 = get_post_meta($post->ID, 'affiliates_text5', $single = true); 
$affiliatesimage5 = get_post_meta($post->ID, 'affiliates_image5', $single = true); 
$affiliatestextlink6 = get_post_meta($post->ID, 'affiliates_textlink6', $single = true); 
$affiliatesalttext6 = get_post_meta($post->ID, 'affiliates_text6', $single = true); 
$affiliatesimage6 = get_post_meta($post->ID, 'affiliates_image6', $single = true); 
$affiliatestextlink7 = get_post_meta($post->ID, 'affiliates_textlink7', $single = true); 
$affiliatesalttext7 = get_post_meta($post->ID, 'affiliates_text7', $single = true); 
$affiliatesimage7 = get_post_meta($post->ID, 'affiliates_image7', $single = true); 
?>

<!-- Start of employee image -->
<div class="employee_image">
<a href="<?php the_permalink (); ?>"><?php echo wp_get_attachment_image($affiliatesheadshot, array(310,139)); ?></a>

</div><!-- End of employee image -->

<!-- Start of employee name -->
<div class="employee_name">
<!--a href="<?php the_permalink (); ?>"><?php the_title (); ?></a-->

</div><!-- End of employee name -->

<!-- Start of employee title -->
<!--div class="employee_title">
<?php if ($affiliatestitle != ('')){ ?>
<?php echo stripslashes($affiliatestitle); ?>
<?php } else { } ?>

</div--><!-- End of employee title -->

<!-- Start of employee social -->
<div class="employee_social">

<?php if ($affiliatesimage != ('')){ 
?>
<a href="<?php echo $affiliatestextlink; ?>" title="<?php echo ($affiliatesalttext); ?>"><?php echo wp_get_attachment_image($affiliatesimage, array('','')); ?></a>

<?php } else { } ?>

<?php if ($affiliatesimage2 != ('')){ ?>

<a href="<?php echo $affiliatestextlink2; ?>" title="<?php echo ($affiliatesalttext2); ?>"><?php echo wp_get_attachment_image($affiliatesimage2, ''); ?></a>

<?php } else { } ?>

<?php if ($affiliatesimage3 != ('')){ ?>

<a href="<?php echo $affiliatestextlink3; ?>" title="<?php echo ($affiliatesalttext3); ?>"><?php echo wp_get_attachment_image($affiliatesimage3, ''); ?></a>

<?php } else { } ?>

<?php if ($affiliatesimage4 != ('')){ ?>

<a href="<?php echo $affiliatestextlink4; ?>" title="<?php echo ($affiliatesalttext4); ?>"><?php echo wp_get_attachment_image($affiliatesimage4, ''); ?></a>

<?php } else { } ?>

<?php if ($affiliatesimage5 != ('')){ ?>

<a href="<?php echo $affiliatestextlink5; ?>" title="<?php echo ($affiliatesalttext5); ?>"><?php echo wp_get_attachment_image($affiliatesimage5, ''); ?></a>

<?php } else { } ?>

<?php if ($affiliatesimage6 != ('')){ ?>

<a href="<?php echo $affiliatestextlink6; ?>" title="<?php echo ($affiliatesalttext6); ?>"><?php echo wp_get_attachment_image($affiliatesimage6, ''); ?></a>

<?php } else { } ?>

<?php if ($affiliatesimage7 != ('')){ ?>

<a href="<?php echo $affiliatestextlink7; ?>" title="<?php echo ($affiliatesalttext7); ?>"><?php echo wp_get_attachment_image($affiliatesimage7, ''); ?></a>

<?php } else { } ?>

</div><!-- End of employee social -->

</div><!-- End of one third -->

</div><!-- end of partners wrapper -->

<?php endwhile; ?> 

<?php else: ?> 
<p><?php _e( 'There are no posts to display. Try using the search.', 'essentials' ); ?></p> 

<?php endif; ?>

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