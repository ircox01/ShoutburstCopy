<div class="login-wrap">
	<a class="logo"></a>
	<div class="login-box">
		
		<?php
			echo $this->session->flashdata('message');
		?>
		
		<div class="inner">
			
			  <div class="form-group">
			  <label>
				  An email has been sent to your account.
				</label>
				
			  </div>
		</div>
	</div><!-- .login-box -->
</div><!-- .login-wrap -->  

<style>
.page-login #header {
	display: none;
}
</style>
<script>
	$("body").addClass("page-login").removeClass("ua-sidebar");
</script>