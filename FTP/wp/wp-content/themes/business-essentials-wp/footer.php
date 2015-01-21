<!-- Start of bottom wrapper -->
<div id="bottom_wrapper">

<!-- Start of content wrapper -->
<div class="content_wrapper">

<!-- Start of one fourth first -->
<div class="one_fourth_first">
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_one')) : ?>
<?php endif; ?>

</div><!-- End of one fourth first -->

<!-- Start of one fourth -->
<div class="one_fourth">
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_two')) : ?>
<?php endif; ?>

</div><!-- End of one fourth -->

<!-- Start of one fourth -->
<div class="one_fourth">
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_three')) : ?>
<?php endif; ?>

</div><!-- End of one fourth -->

<!-- Start of one fourth -->
<div class="one_fourth">
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_four')) : ?>
<?php endif; ?>

</div><!-- End of one fourth -->

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of bottom wrapper -->

<!-- Start of copyright wrapper -->
<div id="copyright_wrapper">

<!-- Start of content wrapper -->
<div class="content_wrapper">

<!-- Start of copyright message -->
<div class="copyright_message">
<?php 
if ( function_exists( 'get_option_tree' ) ) {
$copyright = get_option_tree( 'vn_copyright' );
} ?>     

<?php if ($copyright != ('')){ ?> 
 
&copy;<?php echo stripslashes($copyright); ?>

<?php } else { } ?>
</div><!-- End of copyright message -->

<!-- Start of social icons -->
<div class="social_icons">
<?php echo creativsocial_icons_template(); ?>
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('social')) : ?>
<?php endif; ?>

</div><!-- End of social icons -->

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of copyright wrapper -->

<?php 
if ( function_exists( 'get_option_tree' ) ) {
$analytics = get_option_tree( 'vn_tracking' );
} ?>     

<?php echo stripslashes($analytics); ?>

<script type="text/javascript">
// DOM ready
jQuery(document).ready(function(){
	
jQuery('.slider').flexslider({slideshow: true});

// Create the dropdown base
jQuery("<select />").appendTo(".topmenu");

// Create default option "Go to..."
jQuery("<option />", {
 "selected": "selected",
 "value"   : "",
 "text"    : "Menu Selection"
}).appendTo(".topmenu select");

// Populate dropdown with menu items
jQuery(".topmenu a").each(function() {
var el = jQuery(this);
jQuery("<option />", {
   "value"   : el.attr("href"),
   "text"    : el.text()
}).appendTo(".topmenu select");
});

// To make dropdown actually work
// To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
jQuery(".topmenu select").change(function() {
window.location = jQuery(this).find("option:selected").val();
});

});

</script> 

<?php wp_footer(); ?>
<script>
jQuery('p, li, div.right_content div ul li a').jfontsize();
</script>
</body>
</html>