<!-- START OF SEARCHBOX -->

<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">

<input type="text" value="<?php _e( 'search', 'essentials' ); ?>" id="searchBox" name="s"  onblur="if(this.value == '') { this.value = '<?php _e( 'search', 'essentials' ); ?>'; }" onfocus="if(this.value == '<?php _e( 'search', 'essentials' ); ?>') { this.value = ''; }" />

<span class="searchme"></span>
</form>

<!-- END OF SEARCHBOX -->
            	