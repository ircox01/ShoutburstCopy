<div id="content">
  <div class="container">
    <div class="row content-header">
      <h1>back-end administration</h1>
    </div>
    <!-- .row -->
    <div class="row content-body"> <?php echo form_open('users/setPassword',array('onsubmit'=>"return validateForm(this)")); ?>
      <p><?php echo $this->session->flashdata('message');?></p>
      <div class="col-sm-4">
        <h3>Set Password</h3>
	         <div class="form-group">
	  <input type="password" value="" name="password" id="password"  class="" placeholder="Password" />
	</div>
	 <div class="form-group">
	  <input type="password" value="" name="confpassword" id="confpassword"  class="" placeholder="Confirm Password" />
	   <input type="hidden" name="code" id="code"  class="" placeholder="Confirm Password" value="<?php echo $this->uri->segment(3);?>" />
	</div>
		<div class="form-group text-right">		
          <button type="submit" class="sb-btn sb-btn-green">Save</button>
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
	
function validateForm(){
	if($("#password").val() == ""){
		alert('Please provide a password');
		return false;
	}else if(($("#password").val()).length <6){
		alert('Password length must be greator than 5 characters');
		return false;	
	}
	if($("#confpassword").val() == ""){
		alert('Please provide confirm password');
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