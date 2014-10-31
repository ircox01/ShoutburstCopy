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
	jQuery(document).ready(function(){
	// validate signup form on keyup and submit
	jQuery("#updateAgent").validate({
		rules: {
			user_name: {
				required: true,
				minlength: 3
			},
			user_login: "required",
			
			accessArr:  "required",
			user_email: {
				required: true,
				email: true
			},
			user_pin:{
				number:true,
				maxlength: 11,
				minlength: 4
			}
		},
		messages: {			
			user_name: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 3 characters"
			},
			user_login: "Please enter your User Login",
		//	password: {
		//		required: "Please provide a password",
		//		minlength: "Your password must be at least 5 characters long"
		//	},
			accessArr: "Please select user access level",
			user_email: "Please enter a valid email address",
			user_pin:{
				number: "Please enter only numbers",
				minlength: "User pin atleast have 4 digits"
			}
		}
	});	

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

$(document).ready(function(){

	<?php if($user[0]->user_pin != 0){?>
		$('#user_pin').show();
	<?php }else{?>
		$('#user_pin').hide();
	<?php }?>
	
	
});
</script>
<?php echo form_open_multipart('users/edit/'.$user[0]->user_id, array('name'=>'users', 'id'=>'updateAgent')) ?>
<?php echo $this->session->flashdata('message');?>
<div class="modal-header">
	<button type="button" class="sb-close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">Edit User</h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<input type="text" value="<?php echo isset($user[0]->full_name) ? $user[0]->full_name : ''?>" name="user_name" id="user_name" class="sb-control" placeholder="User Name">
	</div>
	<div class="form-group">
		<input type="text" value="<?php echo isset($user[0]->user_name) ? $user[0]->user_name : ''?>" name="user_login" id="user_login" class="sb-control" placeholder="User Login">
	</div>
	<!--  <div class="form-group">
		<input type="password" value="" name="password" id="password" class="sb-control" placeholder="User Password">
	</div>-->
	<div class="form-group">
		<select name="accessArr"  id="access" class="sb-control">
			<option value="">Please Select Access Level</option>
			<?php  $acc_id = explode(",", $user[0]->acc_id);
		
			foreach ($access_levels as $al)
			{ 
				$selected = '';
				if ($acc_id[0] == $al->acc_id)
					$selected = 'selected="selected"';
				if ($acc_id[1] == $al->acc_id)
					$selected = 'selected="selected"';
				if(($access_level == COMP_MANAGER &&  $al->acc_title=='Manager') || ($access_level == COMP_MANAGER &&  $al->acc_title=='Admin')){
					//echo '<option value="'.$al->acc_id.'">'."H".'</option>';
				}else{
					echo '<option '.$selected.' value="'.$al->acc_id.'">'.$al->acc_title.'</option>';
				}
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<input type="text" value="<?php echo isset($user[0]->user_pin) ? $user[0]->user_pin : ''?>" name="user_pin" id="user_pin" class="sb-control" placeholder="User Pin" maxlength="11" >
	</div>
	<div class="form-group">
		<input type="text" value="<?php echo isset($user[0]->email) ? $user[0]->email : ''?>" name="user_email" id="user_email" class="sb-control" placeholder="User E-mail address">
	</div>
	<div class="form-group">
		<input type="hidden" value="<?php echo isset($user[0]->photo) ? USER_PHOTO.'/'.$user[0]->photo :  ''; ?>" name="old_photo" height="35%">
		<img id="tempimg" style='border:1px solid black;' src="<?php echo (isset($user[0]->photo) && $user[0]->photo != '') ? base_url().USER_PHOTO.'/'.$user[0]->photo :  base_url().USER_PHOTO.'/no_image_uploaded.png'?>" width="35%" height="35%">
		<input type="file" value="" name="user_photo" id="user_photo" class="mt-xxs sb-file" onChange="loadImg(this);" placeholder="User photography">
		<div class="mt-xxs mb-m">Allowed extensions (<code>jpeg</code>, <code>jpg</code>, <code>gif</code>, and <code>png</code>)</div>
	</div>
	
	<div class="form-group">
		<div class="panel panel-sb">
		  <div class="panel-heading">
			<h3 class="panel-title">Select Tags</h3>
		  </div>
		  <div class="panel-body">
			  <select multiple="multiple" size="5" name="tags[]" id="tags" class="sb-control" >
				<?php
				foreach ($tags as $t)
				{
					$selected = '';
					if ( !empty($user_tags) && in_array($t->tag_id, $user_tags) ){
						$selected = 'selected="selected"';
					}
					echo '<option '.$selected.' value="'.$t->tag_id.'">'.$t->tag_name.'</option>';
				}
					?>
			  </select>
		  </div>
		</div>



        <div class="panel panel-sb">
          <div class="panel-heading">
                <h3 class="panel-title">Select Group Tags</h3>
          </div>
          <div class="panel-body">
                  <select multiple="multiple" size="5" name="group_tags[]" id="group_tags" class="sb-control" >
                        <?php
                        foreach ($group_tags as $t)
                        {
                                $selected = '';
                                if ( !empty($user_group_tags) && in_array($t->tg_id, $user_group_tags) ){
                                        $selected = 'selected="selected"';
                                }
                                echo '<option '.$selected.' value="'.$t->tg_id.'">'.$t->tg_name.'</option>';
                        }
                                ?>
                  </select>
          </div>
        </div>



        <div class="panel panel-sb">
		  <div class="panel-heading">
			<h3 class="panel-title">Select Actual Team Tags</h3>
		  </div>
		  <div class="panel-body">
			<select   name="actual_tags[]" id="actual_tags" class="sb-control" >
			<?php
				foreach ($actual_tags as $t)
				{
					if($user_actual_tags == $t->actual_tag_name)
						echo '<option selected="selected" value="'.$t->actual_tag_id.'">'.$t->actual_tag_name.'</option>';
					else
						echo '<option value="'.$t->actual_tag_id.'">'.$t->actual_tag_name.'</option>';
					
				}
				?>
		  </select>
		  </div>
		</div>

	</div>
	
</div><!-- .modal-body -->
<div class="modal-footer">
	<button type="button" class="sb-btn sb-btn-white" data-dismiss="modal">Close</button>
	<button type="submit" name="submit" id="submit" class="sb-btn sb-btn-green">Update</button>
</div>
</form>
