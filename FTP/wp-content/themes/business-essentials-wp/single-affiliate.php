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

<!-- Start of employee image single -->
<div class="employee_image_single">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<?php
$affiliatestitle = get_post_meta($post->ID, 'affiliates_affiliatetitle', $single = true); 
$affiliatesfullwidthimage = get_post_meta($post->ID, 'affiliates_affiliatesfullwidthimage', $single = true); 
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

<?php echo wp_get_attachment_image($affiliatesfullwidthimage, ''); ?>

</div><!-- End of employee image single -->

<h2><?php the_title (); ?></h2>

<!-- Start of employee info -->
<div class="employee_info">

<!-- Start of social icons -->
<div class="social_icons">

<?php if ($affiliatesimage != ('')){ 
?>
<a href="<?php echo $affiliatestextlink; ?>" title="<?php echo ($affiliatesalttext); ?>"><?php echo wp_get_attachment_image($affiliatesimage, ''); ?></a>

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

</div><!-- End of social icons -->

<!-- Start of employee title -->
<div class="employee_title">
<?php if ($affiliatestitle != ('')){ ?>
<?php echo stripslashes($affiliatestitle); ?>
<?php } else { } ?>

</div><!-- End of employee title -->

</div><!-- End of employee info -->

<?php 
if ( has_post_thumbnail() ) {  ?>

<a href="<?php the_permalink (); ?>"><?php the_post_thumbnail('slide'); ?></a>

<?php } ?>


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

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of content wrapper -->

<?php get_footer(); ?>