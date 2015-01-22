<?php
 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');
 
if ( post_password_required() ) { ?>
<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'essentials' ); ?></p>
<?php
return;
}
?>
 
<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
 
<div class="commentlist"><?php wp_list_comments('type=comment&callback=mytheme_comment'); ?></div>

<?php else : ?>
 
<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
 
<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments"><?php _e( 'Comments are closed.', 'essentials' ); ?></p>
 
<?php endif; ?>
 
<?php endif; // if you delete this the sky will fall on your head ?>