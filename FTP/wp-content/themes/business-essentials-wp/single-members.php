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
$memberstitle = get_post_meta($post->ID, 'members_membertitle', $single = true); 
$membersfullwidthimage = get_post_meta($post->ID, 'members_membersfullwidthimage', $single = true); 
$memberstextlink = get_post_meta($post->ID, 'members_textlink', $single = true); 
$membersalttext = get_post_meta($post->ID, 'members_text', $single = true); 
$membersimage = get_post_meta($post->ID, 'members_image', $single = true); 
$memberstextlink2 = get_post_meta($post->ID, 'members_textlink2', $single = true); 
$membersalttext2 = get_post_meta($post->ID, 'members_text2', $single = true); 
$membersimage2 = get_post_meta($post->ID, 'members_image2', $single = true); 
$memberstextlink3 = get_post_meta($post->ID, 'members_textlink3', $single = true); 
$membersalttext3 = get_post_meta($post->ID, 'members_text3', $single = true); 
$membersimage3 = get_post_meta($post->ID, 'members_image3', $single = true); 
$memberstextlink4 = get_post_meta($post->ID, 'members_textlink4', $single = true); 
$membersalttext4 = get_post_meta($post->ID, 'members_text4', $single = true); 
$membersimage4 = get_post_meta($post->ID, 'members_image4', $single = true); 
$memberstextlink5 = get_post_meta($post->ID, 'members_textlink5', $single = true); 
$membersalttext5 = get_post_meta($post->ID, 'members_text5', $single = true); 
$membersimage5 = get_post_meta($post->ID, 'members_image5', $single = true); 
$memberstextlink6 = get_post_meta($post->ID, 'members_textlink6', $single = true); 
$membersalttext6 = get_post_meta($post->ID, 'members_text6', $single = true); 
$membersimage6 = get_post_meta($post->ID, 'members_image6', $single = true); 
$memberstextlink7 = get_post_meta($post->ID, 'members_textlink7', $single = true); 
$membersalttext7 = get_post_meta($post->ID, 'members_text7', $single = true); 
$membersimage7 = get_post_meta($post->ID, 'members_image7', $single = true); 
?>

<?php echo wp_get_attachment_image($membersfullwidthimage, ''); ?>

</div><!-- End of employee image single -->

<h2><?php the_title (); ?></h2>

<!-- Start of employee info -->
<div class="employee_info">

<!-- Start of social icons -->
<div class="social_icons">

<?php if ($membersimage != ('')){ 
?>
<a href="<?php echo $memberstextlink; ?>" title="<?php echo ($membersalttext); ?>"><?php echo wp_get_attachment_image($membersimage, ''); ?></a>

<?php } else { } ?>

<?php if ($membersimage2 != ('')){ ?>

<a href="<?php echo $memberstextlink2; ?>" title="<?php echo ($membersalttext2); ?>"><?php echo wp_get_attachment_image($membersimage2, ''); ?></a>

<?php } else { } ?>

<?php if ($membersimage3 != ('')){ ?>

<a href="<?php echo $memberstextlink3; ?>" title="<?php echo ($membersalttext3); ?>"><?php echo wp_get_attachment_image($membersimage3, ''); ?></a>

<?php } else { } ?>

<?php if ($membersimage4 != ('')){ ?>

<a href="<?php echo $memberstextlink4; ?>" title="<?php echo ($membersalttext4); ?>"><?php echo wp_get_attachment_image($membersimage4, ''); ?></a>

<?php } else { } ?>

<?php if ($membersimage5 != ('')){ ?>

<a href="<?php echo $memberstextlink5; ?>" title="<?php echo ($membersalttext5); ?>"><?php echo wp_get_attachment_image($membersimage5, ''); ?></a>

<?php } else { } ?>

<?php if ($membersimage6 != ('')){ ?>

<a href="<?php echo $memberstextlink6; ?>" title="<?php echo ($membersalttext6); ?>"><?php echo wp_get_attachment_image($membersimage6, ''); ?></a>

<?php } else { } ?>

<?php if ($membersimage7 != ('')){ ?>

<a href="<?php echo $memberstextlink7; ?>" title="<?php echo ($membersalttext7); ?>"><?php echo wp_get_attachment_image($membersimage7, ''); ?></a>

<?php } else { } ?>

</div><!-- End of social icons -->

<!-- Start of employee title -->
<div class="employee_title">
<?php if ($memberstitle != ('')){ ?>
<?php echo stripslashes($memberstitle); ?>
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