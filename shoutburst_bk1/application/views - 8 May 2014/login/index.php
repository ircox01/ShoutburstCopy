<div class="login-wrap">
	<a class="logo"></a>
	<div class="login-box">
		
		<?php
			echo $this->session->flashdata('message');
		?>
		
		<div class="inner">
			<?php echo form_open_multipart('login/process', array('name' => 'user_login', 'id' => 'user_login')) ?>
			  <div class="form-group">
				<input type="text" autofocus="autofocus" autocomplete="off" class="sb-control" name="username" id="username" placeholder="User name">
				<span class="icon icon-username"></span>
			  </div>
			  <div class="form-group">
				<input type="password" class="sb-control" name="password" id="password" placeholder="Password">
				<span class="icon icon-password"></span>
			  </div>
			  <div class="checkbox">
				<label>
				  <input type="checkbox" autocomplete="off" class="remember-me-check"> <span class="remember-me">Remember me</span>
				</label>
                <?php echo anchor("setpassword/forgetpassword","Forgot your password?", array('class'=>'forgot-password')); ?>
			  </div>
			  <button type="submit" name="user_login" id="user_login" class="btn sb-btn-sign-in">Sign In</button>
			</form>
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