<div class="login-wrap"><a class="logo"></a>
<div class="login-box"><?php 
echo $this->session->flashdata('message');

?> <?php if(isset($_SESSION['password_updated'])){
	if($_SESSION['password_updated']==1){?>
<div id="message" class="updated below-h2">
<p>
	Your password has been updated successfully.<br />
	<?php echo anchor(base_url(),"Return to login"); ?>
</p>
</div>
	<?php }else {?>
<div id="message" class="updated below-h2">
<p>Your password has already been updated.</p>
</div>
	<?php }	}else {?>
<div class="inner"><?php echo form_open('setpassword/index',array('onsubmit'=>"return validateForm(this)")); ?>
<div class="form-group"><input type="password" autofocus="autofocus"
	value="" name="password" id="password" class="sb-control"
	placeholder="Password"> <span class="icon icon-password"></span></div>
<div class="form-group"><input type="password" value=""
	name="confpassword" id="confpassword" class="sb-control"
	placeholder="Confirm Password"> <input type="hidden" name="code"
	id="code" class="" placeholder="Confirm Password"
	value="<?php echo $this->uri->segment(3);?>"> <span
	class="icon icon-password"></span></div>
<button type="submit" name="user_login" id="user_login"
	class="btn sb-btn-create-password">Create Password</button>
</form>
</div>
	<?php }?></div>
<!-- .login-box --></div>
<!-- .login-wrap -->

<style>
.page-login #header {
	display: none;
}
</style>
<script>
	$("body").addClass("page-login").removeClass("ua-sidebar");
</script>



<script>
	
function validateForm(){
	if($("#password").val() == ""){
		alert('Please provide a password');
		return false;
	}else if(($("#password").val()).length <6){
		alert('Your password must be at least 5 characters long');
		return false;	
	}
	if($("#confpassword").val() == ""){
		alert('Please re-enter your password');
		return false;
	}else if(($("#confpassword").val())!=($("#password").val())){
		alert('Password and confirm password are not matched');
		return false;	
	}return true;
	}

	/*$(function(){
		   $("#companies").multiselect(); 
		});*/
</script>
