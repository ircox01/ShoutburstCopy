<div id="content">
  <div class="container">
	<div class="row content-header">
		<?php echo heading('Settings', 1);?> 
		<?php echo $this->session->flashdata('message');?>      
    </div>
    <!-- .row -->
    <div class="row content-body"><?php echo form_open('users/settings', array('id'=>'restPass', 'onsubmit'=>"return validateForm(this)")); ?>        
      <div class="col-sm-4">
        <?php echo heading('Change password', 3);?>
        <div class="form-group">
          <input type="password" value="" autofocus="autofocus" name="epassword" id="epassword"  class="sb-control" placeholder="Existing Password" />
        </div>
	    <div class="form-group">
          <input type="password" value="" autofocus="autofocus" name="password" id="password"  class="sb-control" placeholder="New Password" />
			<label for="password" class="" id="error2" style='color:red;' >Your password must contain atleast one number</label>        
        </div>
         <div class="form-group">
          <input type="password" value="" name="confpassword" id="confpassword"  class="sb-control" placeholder="Confirm New Password" />
          <label for="confpassword" class="" id="error3" style='color:red;' >Your password and confirm password are not same</label>
        </div>
		<div class="form-group text-right">		
          <button type="submit" class="btn btn-primary-green">Save</button>
        </div>
      </div>
      <!-- .col -->
      </form>
    </div>
    <!-- .row -->
  </div>
  <!-- .container -->
</div>
<script>

jQuery("#restPass").validate({
	rules: {		
		epassword: {
			required: true,
			minlength: 5
		},
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
		epassword: {
			required: "Please provide your existing password",
			minlength: "Your password must be at least 5 characters long"
		},	
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
		else{
			if($("#password").val()!=$("#confpassword").val())
			{
				$('#error3').show();
				valid = false;
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
