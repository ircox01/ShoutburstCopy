<?php  
/* 
Template Name: Sitemap 
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

<!-- Start of one third first -->
<div class="one_third_first">

<h4><?php _e( 'Categories', 'essentials' ); ?></h4>

<ul>

<?php $args = array(
    'show_option_all'    => '',
    'orderby'            => 'name',
    'order'              => 'ASC',
    'style'              => 'list',
    'show_count'         => 1,
    'hide_empty'         => 1,
    'use_desc_for_title' => 0,
    'child_of'           => 0,
    'feed'               => '',
    'feed_type'          => '',
    'feed_image'         => '',
    'exclude'            => '',
    'exclude_tree'       => '',
    'include'            => '',
    'hierarchical'       => true,
    'title_li'           => '',
    'show_option_none'   => __('No categories', 'essentials'),
    'number'             => NULL,
    'echo'               => 1,
    'depth'              => 0,
    'current_category'   => 0,
    'pad_counts'         => 0,
    'taxonomy'           => 'category',
    'walker'             => 'Walker_Category' ); ?> 
	
	<?php wp_list_categories( $args ); ?>
    
</ul>

<div class="clearbig"></div>


<h4><?php _e( 'Feeds', 'essentials' ); ?></h4>

<ul>

<li><a title="<?php _e( 'Full content', 'essentials' ); ?>" href="feed:<?php bloginfo('rss2_url'); ?>"><?php _e( 'Main RSS', 'essentials' ); ?></a></li>
<li><a title="<?php _e( 'Comment Feed', 'essentials' ); ?>" href="feed:<?php bloginfo('comments_rss2_url'); ?>"><?php _e( 'Comment Feed', 'essentials' ); ?></a></li>

</ul>

<div class="clearbig"></div>

<h4><?php _e( 'Archives', 'essentials' ); ?></h4>

<ul>

<?php wp_get_archives('type=monthly&show_post_count=true'); ?>
    
</ul>

</div><!-- End of one third first -->

<!-- Start of one third -->
<div class="one_third">

<h4><?php _e( 'Pages', 'essentials' ); ?></h4>

<ul>
<?php wp_list_pages("title_li=" ); ?>

</ul>

<div class="clearbig"></div>

</div><!-- End of one third -->

<!-- Start of one third -->
<div class="one_third">

<h4><?php _e( 'All Blog Posts', 'essentials' ); ?></h4>


<ul>

<?php $archive_query = new WP_Query('showposts=1000&cat=-8');
while ($archive_query->have_posts()) : $archive_query->the_post(); ?>

<li>
<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'essentials' ); ?><?php the_title(); ?>"><?php the_title(); ?></a>
(<?php comments_number('0', '1', '%'); ?>)
</li>

<?php endwhile; ?>
    
</ul>

<div class="clearbig"></div>

</div><!-- End of one third -->

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of content wrapper -->

<?php get_footer(); ?>