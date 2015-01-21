<?php
/*
Single Post Template: [Blog Single Right Sidebar]
Description: This part is optional, but helpful for describing the Post Template
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

<!-- Start of left content -->
<div class="left_content">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<h2 class="blue"><?php the_title (); ?></h2>

<?php 
    if (has_post_format('gallery')) { ?>
    
<?php
$attachments = get_children(
array(
'post_type' => 'attachment',
'post_mime_type' => 'image',
'post_parent' => $post->ID
));
if(count($attachments) > 1) { ?>

<!-- Start of slider -->
<section class="slider">

<ul class="slides">
<?php 

$args = array(
'post_type' => 'attachment',
'numberposts' => -1,
'post_status' => null,
'post_parent' => $post->ID
);

$attachments = get_posts( $args );
if ( $attachments ) {
foreach ( $attachments as $attachment ) {
echo '<li>';
echo wp_get_attachment_image( $attachment->ID, 'slide' );
echo '</li>';
}
}

?>

</ul><!-- End of slides -->	

<div class="clear"></div>

</section><!-- End of slider -->

<div class="clearbig"></div>

<?php the_content('        '); ?>

<?php } else { ?>

<a href="<?php the_permalink (); ?>"><?php the_post_thumbnail('slide'); ?></a>

<!-- Clear Fix --><div class="clearbig"></div>

<?php the_content('        '); ?> 

<?php } ?>   

<?php ; } elseif (has_post_format('video')) { ?>

<?php the_content('        '); ?>

<?php ; } elseif (has_post_format('quote')) { ?>

<blockquote><?php the_content('        '); ?></blockquote>

<?php ; } else { ?>
    
<?php 
if ( has_post_thumbnail() ) {  ?>

<?php the_post_thumbnail('slide'); ?>

<!-- Clear Fix --><div class="clearbig"></div>

<?php } ?>

<?php the_content('        '); ?>

<?php } ?>

<!-- Start of post details -->
<div class="post_details">

<!-- Start of post date -->
<div class="post_date">
<?php the_time('m.d.Y') ?>

</div><!-- End of post date -->

<?php if ('open' == $post->comment_status) { ?>

<!-- Start of post comment -->
<div class="post_comment">
&nbsp;
<?php
if (get_comments_number()==1) { ?>

<?php comments_number( '0', '1', '%', '', ''); ?>

<?php _e( 'COMMENT', 'essentials' ); ?>

<?php } else { ?>

<?php comments_number( '0', '1', '%', '', ''); ?>

<?php _e( 'COMMENTS', 'essentials' ); ?>

<?php } ?>

</div><!-- End of post comment -->

<?php } ?>

<!-- Start of post read morecats -->
<div class="post_read_morecats">
<?php the_category('&nbsp;'); ?>

</div><!-- End of post read morecats -->

</div><!-- End of post details -->

<?php endwhile; ?> 

<?php else: ?> 
<p><?php _e( 'There are no posts to display. Try using the search.', 'essentials' ); ?></p> 

<?php endif; ?>

<?php if ('open' == $post->comment_status) { ?>

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

</div><!-- End of left content -->

<!-- Start of right content -->
<div class="right_content">
<?php get_sidebar ('blog'); ?> 

</div><!-- End of right content -->

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of content wrapper -->

<?php get_footer(); ?>