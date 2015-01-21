<script>
	//file validate
	 function fileExtensionValidate(valId){
		var ext = $('#'+valId).val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg','GIF','PNG','JPG','JPEG']) == -1) {
			jQuery('#'+valId).val('');
		    alert("Invalid File Type.");
			return false;
		}else
			return true;
	}

	// validate signup form on keyup and submit
	jQuery("#signupForm").validate({
		rules: {
			user_name: {
				required: true,
				minlength: 3
			},
			user_login: "required",
			//password: {
			//	required: true,
			//	minlength: 5
			//},
			access:  "required",
			user_email: {
				required: true,
				email: true
			},
			//user_pin:"required"
		},
		messages: {			
			user_name: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 3 characters"
			},
			user_login: "Please enter your User Login",
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			access: "Please select user access level",
			user_email: "Please enter a valid email address",
			//user_pin: "Please enter your User Pin",
		}
	});
	
	function loadImg(img) {
		
		if(fileExtensionValidate('user_photo'))
		{
        	//if (input.files && input.files[0])
           // {
            	var reader = new FileReader();
            	reader.onload = function (e) {            	
                $('#tempimg')
                    .attr('src', e.target.result);
            	};
            	reader.readAsDataURL(img.files[0]);
        	//}
		}
    }
	/*$(function(){
		   $("#companies").multiselect(); 
		});*/
</script>
<?php echo form_open_multipart('users/add', array('name'=>'users', 'id'=>'signupForm')) ?><?php echo $this->session->flashdata('message');?>
<div class="modal-header">
	<button type="button" class="sb-close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">Add User</h4>
</div>
<div class="modal-body">
	<div class="form-group">
	  <input type="text" value="" name="user_name" id="user_name" class="sb-control" placeholder="User Name" />
	</div>
	<div class="form-group">
	  <input type="text" value="" name="user_login" id="user_login"  class="sb-control" placeholder="User Login" />
	</div>
	<!-- <div class="form-group">
	  <input type="password" value="" name="password" id="password"  class="sb-control" placeholder="Password" />
	</div>-->
	<div class="form-group">
	  <select name="accessArr[]" id="access" class="sb-control">
		<option value="">Please Select Access Level</option>
		<?php
			foreach ($access_levels as $al)
			{
				echo '<option value="'.$al->acc_id.'">'.$al->acc_title.'</option>';
			}
			?>
	  </select>
	</div>
	<div class="form-group">
	  <input type="text" value="" name="user_pin" id="user_pin"   class="sb-control" placeholder="User Pin" />
	</div>
	<div class="form-group">
	  <input type="text" value="" name="user_email" id="user_email"  class="sb-control" placeholder="User E-mail address" />
	</div>
	<div class="form-group">	
		<img id="tempimg" style='border:1px solid black;' src="<?php echo base_url().USER_PHOTO.'/noImageUploaded.png';?>" width="35%" height="35%">
	  <input type="file" value="" name="user_photo" id="user_photo" class='' onChange="loadImg(this);"  placeholder="User photography" />
	  <p style="color:##939393; font-size:12px;">Only <i>(PNG,JPG,GIF)</i> files are allowed for images</p>
	</div>
</div><!-- .modal-body -->
<div class="modal-footer">
	<button type="button" class="sb-btn sb-btn-white" data-dismiss="modal">Close</button>
	<button type="submit" name="submit" id="submit" class="sb-btn sb-btn-green">Save</button>
</div>
</form>
