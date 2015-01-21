<?php $path = get_template_directory_uri();
if(!isset($_REQUEST['error']))  $error_code = '404';
else  $error_code = $_REQUEST['error'];
?>
<?php ob_start(); ?>

<?php get_header(); ?>

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of header wrapper -->

<!-- Start of content wrapper -->
<div id="contentwrapper">

<!-- Start of content wrapper -->
<div class="content_wrapper">

<?php _e( '<p class="page_error">404</p><br />
<p class="page_error_text">Sorry, but the page you were looking for does not exist.', 'essentials' ); ?></p><p>&nbsp;</p><p>&nbsp;</p><div class="clear"></div>


<div class="clearbig"></div>

</div><!-- End of content wrapper -->

<!-- Clear Fix --><div class="clear"></div>

</div><!-- End of content wrapper -->

<?php get_footer(); ?>