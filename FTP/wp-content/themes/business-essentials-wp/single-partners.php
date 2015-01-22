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
$partnerstitle = get_post_meta($post->ID, 'partners_partnertitle', $single = true); 
$partnersfullwidthimage = get_post_meta($post->ID, 'partners_partnersfullwidthimage', $single = true); 
$partnerstextlink = get_post_meta($post->ID, 'partners_textlink', $single = true); 
$partnersalttext = get_post_meta($post->ID, 'partners_text', $single = true); 
$partnersimage = get_post_meta($post->ID, 'partners_image', $single = true); 
$partnerstextlink2 = get_post_meta($post->ID, 'partners_textlink2', $single = true); 
$partnersalttext2 = get_post_meta($post->ID, 'partners_text2', $single = true); 
$partnersimage2 = get_post_meta($post->ID, 'partners_image2', $single = true); 
$partnerstextlink3 = get_post_meta($post->ID, 'partners_textlink3', $single = true); 
$partnersalttext3 = get_post_meta($post->ID, 'partners_text3', $single = true); 
$partnersimage3 = get_post_meta($post->ID, 'partners_image3', $single = true); 
$partnerstextlink4 = get_post_meta($post->ID, 'partners_textlink4', $single = true); 
$partnersalttext4 = get_post_meta($post->ID, 'partners_text4', $single = true); 
$partnersimage4 = get_post_meta($post->ID, 'partners_image4', $single = true); 
$partnerstextlink5 = get_post_meta($post->ID, 'partners_textlink5', $single = true); 
$partnersalttext5 = get_post_meta($post->ID, 'partners_text5', $single = true); 
$partnersimage5 = get_post_meta($post->ID, 'partners_image5', $single = true); 
$partnerstextlink6 = get_post_meta($post->ID, 'partners_textlink6', $single = true); 
$partnersalttext6 = get_post_meta($post->ID, 'partners_text6', $single = true); 
$partnersimage6 = get_post_meta($post->ID, 'partners_image6', $single = true); 
$partnerstextlink7 = get_post_meta($post->ID, 'partners_textlink7', $single = true); 
$partnersalttext7 = get_post_meta($post->ID, 'partners_text7', $single = true); 
$partnersimage7 = get_post_meta($post->ID, 'partners_image7', $single = true); 
?>

<?php echo wp_get_attachment_image($partnersfullwidthimage, ''); ?>

</div><!-- End of employee image single -->

<h2><?php the_title (); ?></h2>

<!-- Start of employee info -->
<div class="employee_info">

<!-- Start of social icons -->
<div class="social_icons">

<?php if ($partnersimage != ('')){ 
?>
<a href="<?php echo $partnerstextlink; ?>" title="<?php echo ($partnersalttext); ?>"><?php echo wp_get_attachment_image($partnersimage, ''); ?></a>

<?php } else { } ?>

<?php if ($partnersimage2 != ('')){ ?>

<a href="<?php echo $partnerstextlink2; ?>" title="<?php echo ($partnersalttext2); ?>"><?php echo wp_get_attachment_image($partnersimage2, ''); ?></a>

<?php } else { } ?>

<?php if ($partnersimage3 != ('')){ ?>

<a href="<?php echo $partnerstextlink3; ?>" title="<?php echo ($partnersalttext3); ?>"><?php echo wp_get_attachment_image($partnersimage3, ''); ?></a>

<?php } else { } ?>

<?php if ($partnersimage4 != ('')){ ?>

<a href="<?php echo $partnerstextlink4; ?>" title="<?php echo ($partnersalttext4); ?>"><?php echo wp_get_attachment_image($partnersimage4, ''); ?></a>

<?php } else { } ?>

<?php if ($partnersimage5 != ('')){ ?>

<a href="<?php echo $partnerstextlink5; ?>" title="<?php echo ($partnersalttext5); ?>"><?php echo wp_get_attachment_image($partnersimage5, ''); ?></a>

<?php } else { } ?>

<?php if ($partnersimage6 != ('')){ ?>

<a href="<?php echo $partnerstextlink6; ?>" title="<?php echo ($partnersalttext6); ?>"><?php echo wp_get_attachment_image($partnersimage6, ''); ?></a>

<?php } else { } ?>

<?php if ($partnersimage7 != ('')){ ?>

<a href="<?php echo $partnerstextlink7; ?>" title="<?php echo ($partnersalttext7); ?>"><?php echo wp_get_attachment_image($partnersimage7, ''); ?></a>

<?php } else { } ?>

</div><!-- End of social icons -->

<!-- Start of employee title -->
<div class="employee_title">
<?php if ($partnerstitle != ('')){ ?>
<?php echo stripslashes($partnerstitle); ?>
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