<div class="login-wrap">
	<a class="logo"></a>
	<div class="login-box">		
		<?php
		
			echo $this->session->flashdata('message');
	
		?>		
        <div id="message" class="updated below-h2">
        <?php if(isset($_SESSION['email_send'])){?>
        <p>An email has been sent to your account.</p>
        <br><a href="<?php echo base_url();?>">Back</a>
        <?php }else{
        	if(isset($_SESSION['error'])){
        
        	?><p>Your username or email address is invalid.</p>
        <?php }else {?>
        	<p>Please enter your username or email address.</p>
        	<p>You will receive a link to create a new password via email.</p>
        <?php }?></div>
        
		<div class="inner">
			<?php echo form_open_multipart('setpassword/forgetpassword', array('name' => 'user_password', 'id' => 'user_password')) ?>
			  <div class="form-group">
				<input type="text" autofocus="autofocus" autocomplete="off" class="sb-control" name="email" id="email" placeholder="Username or E-mail">
				<span class="icon icon-username"></span>
			  </div>
              <button type="submit" name="user_login" id="user_login" class="btn sb-btn-forgot-password">Get New Password</button>
              <a class="btn sb-btn-forgot-password" href="<?php echo base_url();?>">Cancel</a>
			</form>
		</div>  <?php }?>
	</div><!-- .login-box -->
</div><!-- .login-wrap -->  

<style>
.page-login #header {
	display: none;
}
</style>
<script>

//validate signup form on keyup and submit
jQuery("#user_password").validate({
	rules: {
		email: {
			required: true,
		}
	},
	messages: {			
		email: {
			required: "Please enter a username/email"			
		}
	}
});
	$("body").addClass("page-login").removeClass("ua-sidebar");
</script>