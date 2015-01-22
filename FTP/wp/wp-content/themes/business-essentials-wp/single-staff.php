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
$stafftitle = get_post_meta($post->ID, 'staff_stafftitle', $single = true); 
$stafffullwidthimage = get_post_meta($post->ID, 'staff_stafffullwidthimage', $single = true); 
$stafftextlink = get_post_meta($post->ID, 'staff_textlink', $single = true); 
$staffalttext = get_post_meta($post->ID, 'staff_text', $single = true); 
$staffimage = get_post_meta($post->ID, 'staff_image', $single = true); 
$stafftextlink2 = get_post_meta($post->ID, 'staff_textlink2', $single = true); 
$staffalttext2 = get_post_meta($post->ID, 'staff_text2', $single = true); 
$staffimage2 = get_post_meta($post->ID, 'staff_image2', $single = true); 
$stafftextlink3 = get_post_meta($post->ID, 'staff_textlink3', $single = true); 
$staffalttext3 = get_post_meta($post->ID, 'staff_text3', $single = true); 
$staffimage3 = get_post_meta($post->ID, 'staff_image3', $single = true); 
$stafftextlink4 = get_post_meta($post->ID, 'staff_textlink4', $single = true); 
$staffalttext4 = get_post_meta($post->ID, 'staff_text4', $single = true); 
$staffimage4 = get_post_meta($post->ID, 'staff_image4', $single = true); 
$stafftextlink5 = get_post_meta($post->ID, 'staff_textlink5', $single = true); 
$staffalttext5 = get_post_meta($post->ID, 'staff_text5', $single = true); 
$staffimage5 = get_post_meta($post->ID, 'staff_image5', $single = true); 
$stafftextlink6 = get_post_meta($post->ID, 'staff_textlink6', $single = true); 
$staffalttext6 = get_post_meta($post->ID, 'staff_text6', $single = true); 
$staffimage6 = get_post_meta($post->ID, 'staff_image6', $single = true); 
$stafftextlink7 = get_post_meta($post->ID, 'staff_textlink7', $single = true); 
$staffalttext7 = get_post_meta($post->ID, 'staff_text7', $single = true); 
$staffimage7 = get_post_meta($post->ID, 'staff_image7', $single = true); 
?>

<?php echo wp_get_attachment_image($stafffullwidthimage, ''); ?>

</div><!-- End of employee image single -->

<h2><?php the_title (); ?></h2>

<!-- Start of employee info -->
<div class="employee_info">

<!-- Start of social icons -->
<div class="social_icons">

<?php if ($staffimage != ('')){ 
?>
<a href="<?php echo $stafftextlink; ?>" title="<?php echo ($staffalttext); ?>"><?php echo wp_get_attachment_image($staffimage, ''); ?></a>

<?php } else { } ?>

<?php if ($staffimage2 != ('')){ ?>

<a href="<?php echo $stafftextlink2; ?>" title="<?php echo ($staffalttext2); ?>"><?php echo wp_get_attachment_image($staffimage2, ''); ?></a>

<?php } else { } ?>

<?php if ($staffimage3 != ('')){ ?>

<a href="<?php echo $stafftextlink3; ?>" title="<?php echo ($staffalttext3); ?>"><?php echo wp_get_attachment_image($staffimage3, ''); ?></a>

<?php } else { } ?>

<?php if ($staffimage4 != ('')){ ?>

<a href="<?php echo $stafftextlink4; ?>" title="<?php echo ($staffalttext4); ?>"><?php echo wp_get_attachment_image($staffimage4, ''); ?></a>

<?php } else { } ?>

<?php if ($staffimage5 != ('')){ ?>

<a href="<?php echo $stafftextlink5; ?>" title="<?php echo ($staffalttext5); ?>"><?php echo wp_get_attachment_image($staffimage5, ''); ?></a>

<?php } else { } ?>

<?php if ($staffimage6 != ('')){ ?>

<a href="<?php echo $stafftextlink6; ?>" title="<?php echo ($staffalttext6); ?>"><?php echo wp_get_attachment_image($staffimage6, ''); ?></a>

<?php } else { } ?>

<?php if ($staffimage7 != ('')){ ?>

<a href="<?php echo $stafftextlink7; ?>" title="<?php echo ($staffalttext7); ?>"><?php echo wp_get_attachment_image($staffimage7, ''); ?></a>

<?php } else { } ?>

</div><!-- End of social icons -->

<!-- Start of employee title -->
<div class="employee_title">
<?php if ($stafftitle != ('')){ ?>
<?php echo stripslashes($stafftitle); ?>
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