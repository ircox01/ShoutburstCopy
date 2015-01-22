<?php

function creativsocial_icons_template() {
	
	ob_start(); ?>

	<div class="creativsocial">

		<?php

		// Let's define each social network
		// URL in a variable.
	    $facebook = creativsocial_options_each( 'facebook' );
	    $twitter = creativsocial_options_each( 'twitter' );
	    $pinterest = creativsocial_options_each( 'pinterest' );
	    $youtube = creativsocial_options_each( 'youtube' );
	    $vimeo = creativsocial_options_each( 'vimeo' );
	    $flickr = creativsocial_options_each( 'flickr' );
	    $github = creativsocial_options_each( 'github' );
	    $gplus = creativsocial_options_each( 'gplus' );
	    $dribbble = creativsocial_options_each( 'dribbble' );
		$linkedin = creativsocial_options_each( 'linkedin' );
		$tumblr = creativsocial_options_each( 'tumblr' );
		$wordpress = creativsocial_options_each( 'wordpress' );
		$instagram = creativsocial_options_each( 'instagram' );
		$rss = creativsocial_options_each( 'rss' );

		?>

		<?php
		// Only show ul if at least one social network option has been filled.
		if ( ( $facebook or $twitter or $tumblr or $pinterest or $youtube or $vimeo or $flickr or $github or $gplus or $dribbble or $linkedin or $wordpress or $instagram or $rss ) != '' ) { ?>

		<?php // Assuming there is, let's go ahead and display the ones that have been filled ?>
			<?php // _TODO_ Make this into a switch/case structure or a foreach statement if possible ?>
		    <ul <?php /* Again, this is for the new Type option in an upcoming version.
		    					// If a user has chosen one of the other social media icon
		    					// designs, let's add a class that will change the icons
		    					// accordingly. 2 = Circle Black/White. 3 = Square Color. 4 = Square Black/White.
		    					if ( $type == 2 ) {
		    						echo 'circle bw';
		    					} elseif ( $type == 3 ) {
		    						echo 'square color';
		    					} elseif ( $type == 4 ) {
		    						echo 'square bw'; } */ ?>">
		    	<?php if ( $facebook !='' ) { ?>
		    	<li class="facebook">
		    	    <a href="<?php echo $facebook; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $twitter !='' ) { ?>
		    	<li class="twitter">
		    	    <a href="<?php echo $twitter; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $tumblr !='' ) { ?>
		    	<li class="tumblr">
		    	    <a href="<?php echo $tumblr; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $pinterest !='' ) { ?>
		    	<li class="pinterest">
		    	    <a href="<?php echo $pinterest; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $youtube !='' ) { ?>
		    	<li class="youtube">
		    	    <a href="<?php echo $youtube; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $vimeo !='' ) { ?>
		    	 <li class="vimeo">
		    	    <a href="<?php echo $vimeo; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $flickr !='' ) { ?>
		    	 <li class="flickr">
		    	    <a href="<?php echo $flickr; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $github !='' ) { ?>
		    	 <li class="github">
		    	    <a href="<?php echo $github; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $gplus !='' ) { ?>
		    	 <li class="gplus">
		    	    <a href="<?php echo $gplus; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $dribbble !='' ) { ?>
		    	 <li class="dribbble">
		    	    <a href="<?php echo $dribbble; ?>"></a>
		    	</li>
		    	<?php } ?>
                <?php if ( $linkedin !='' ) { ?>
		    	 <li class="linkedin">
		    	    <a href="<?php echo $linkedin; ?>"></a>
		    	</li>
		    	<?php } ?>
                <?php if ( $rss !='' ) { ?>
		    	 <li class="rss">
		    	    <a href="<?php echo $rss; ?>"></a>
		    	</li>
		    	<?php } ?>
                <?php if ( $wordpress !='' ) { ?>
		    	 <li class="wordpress">
		    	    <a href="<?php echo $wordpress; ?>"></a>
		    	</li>
		    	<?php } ?>
                <?php if ( $instagram !='' ) { ?>
		    	 <li class="instagram">
		    	    <a href="<?php echo $instagram; ?>"></a>
		    	</li>
		    	<?php } ?>
	    </ul>

		<?php } ?>	
    
	</div><!-- .creativsocial -->

	<?php
		echo ob_get_clean();

}