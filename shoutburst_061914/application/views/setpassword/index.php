<div class="login-wrap">
	<a class="logo"></a>
	<div class="login-box">
		<?php 
			echo $this->session->flashdata('message');
			if(isset($_SESSION['password_updated']))
			{
				if($_SESSION['password_updated']==1){
		?>
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
		<div class="inner">
			<?php echo form_open('setpassword/index',array('id'=>'setPass','onsubmit'=>"return validateForm(this)")); ?>
			<div class="form-group">
				<input type="password" autofocus="autofocus" value="" name="password" id="password" class="sb-control"	placeholder="Password">
				<span class="icon icon-password"></span>
				<label for="password" class="" id="error2" style='color:red;' >Your password must contain atleast one number</label> 
			</div>
			<div class="form-group">
				<input type="password" value=""	name="confpassword" id="confpassword" class="sb-control"	placeholder="Confirm Password">
				<input type="hidden" name="code"	id="code" class="" placeholder=""	value="<?php echo $this->uri->segment(3);?>">
				<span	class="icon icon-password"></span>
				<label for="confpassword" class="" id="error3" style='color:red;' >Your password and confirm password are not same</label>
			</div>
			<button type="submit" name="user_login" id="user_login"	class="btn sb-btn-create-password">Create Password</button>
			</form>
		</div>
			<?php }?>
	</div>

</div>


<style>
.page-login #header {
	display: none;
}
</style>
<script>
	$("body").addClass("page-login").removeClass("ua-sidebar");
</script>
<script>

jQuery("#setPass").validate({
	rules: {				
		password: {
			required: true,
			minlength: 8
		},
		confpassword: {
			required: true,
			minlength: 8
		}		
	},
	messages: {			
		password: {
			required: "Please provide password",
			minlength: "Your password must be at least 8 characters long"
		},
		confpassword: {
			required: "Please re-enter your password",
			minlength: "Your password must be at least 8 characters long"
		}
	}
});

function validateForm()
{
	 $('#error2').hide();
	 $('#error3').hide();
	 valid = true;
	if($("#password").val()!="")
	{	
		regExp=/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/;
		pwd=$("#password").val();	
		if(!regExp.test(pwd))
		{
			$('#error2').show();
			 valid = false;		
		}
		else {
			if($("#password").val()!=$("#confpassword").val())
			{
				$('#error3').show();
				valid=false;
			}
		}
		
		return valid;
	}
}
$(document).ready(function(){
	$('#error2').hide();
	$('#error3').hide();
});

</script>
