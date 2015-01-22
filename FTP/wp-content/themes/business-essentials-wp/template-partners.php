<?php  
/* 
Template Name: Partners
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
query_posts('post_type=partners&posts_per_page=12&orderby=rand&paged='. $paged ); ?>
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
$partnerstitle = get_post_meta($post->ID, 'partners_partnertitle', $single = true); 
$partnersheadshot = get_post_meta($post->ID, 'partners_partnerheadshot', $single = true); 
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

<!-- Start of employee image -->
<div class="employee_image">
<a href="<?php the_permalink (); ?>"><?php echo wp_get_attachment_image($partnersheadshot, array(310,139)); ?></a>

</div><!-- End of employee image -->

<!-- Start of employee name -->
<div class="employee_name">
<!--a href="<?php the_permalink (); ?>"><?php the_title (); ?></a-->

</div><!-- End of employee name -->

<!-- Start of employee title -->
<!--div class="employee_title">
<?php if ($partnerstitle != ('')){ ?>
<?php echo stripslashes($partnerstitle); ?>
<?php } else { } ?>

</div--><!-- End of employee title -->

<!-- Start of employee social -->
<div class="employee_social">

<?php if ($partnersimage != ('')){ 
?>
<a href="<?php echo $partnerstextlink; ?>" title="<?php echo ($partnersalttext); ?>"><?php echo wp_get_attachment_image($partnersimage, array('','')); ?></a>

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