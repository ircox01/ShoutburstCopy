<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.datetimepicker.css"/ >
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js"></script>
<div id="content">
  <div class="container">
    <div class="row content-header">
      <?php echo anchor("companies","Back", array('class'=>('sb-btn sb-btn-white'))); ?>
      <h1>Add New Company</h1>
      <p><?php echo $this->session->flashdata('message');?></p>
    </div>
    <!-- .row -->
    <div class="row content-body cf"> <?php echo form_open_multipart('companies/account_setup',array('id'=>"accountSetupform", 'onsubmit'=>"return validateForm(this)")); ?>
      <div class="col-sm-4">
        <h3>Account set up</h3>
        <div class="form-group">
          <input type="text" autofocus class="sb-control" placeholder="Company name" id="name" name="name">
        </div>
        <div class="form-group">
          <input type="text" autocomplete="off" class="sb-control" placeholder="Administrator name" name="adminname" id="adminname">
        </div>
          <div class="form-group">
          <input type="password" autocomplete="off" class="sb-control" placeholder="Password" name="password" id="password">
        <label for="password" class="" id="error2" style='color:red;' >Password must contain atleast one number</label>  </div>
        <div class="form-group">
          <select name="campaign_name[]" id="campaign_name" data-placeholder="Please Select Campaigns" multiple class="sb-control chosen-select-no-results" tabindex="11">
            <?php
				if(!empty($campaigns))
				{
					foreach($campaigns as $campaignsRow)
					{
			 ?>
           				 <option value="<?php echo $campaignsRow->camp_id;?>"><?php echo $campaignsRow->camp_name;?></option>
            <?php
					}
				}
			  ?>
          </select>
          <br>
          <span id="addNewCampaignRegionLink"><a href ="javascript:;" onclick="addNewCampaignShowRegion(); return false;"><br>Add New Campaign</a><span>
        </div>
        <div class="form-group">
          <div style="display:none;" id="new-campiagn-region">
        	<div class="form-group"><input type="text" id="addNewCampaign" placeholder="Add New Campaign" class="sb-control span3 input-large"></div>
        	<div class="form-group"><input type="text" id="addNewRoutingPlan" placeholder="Add Routing Plan" class="sb-control span3 input-large"></div>
            <span id="RemoveCampaignRegion"> <a href="javascript:;" onclick="addNewCampaign(); return false;" >Add</a> &nbsp;|&nbsp; <a href="javascript:;" onclick='removeNewCampaign(); return false;' >Close</a> </span> </div>
          <div id="errorRegion" style="display:none; color:red;"></div>
        </div>
        <div class="form-group">
          <input type="text" class="sb-control" placeholder="Administrator e-mail" name="adminemail" id="adminemail">
        </div>
       <!--   <div class="form-group">
          <input type="text" class="sb-control"  value="" placeholder="Platform" name="platform" id="platform">
        </div>-->
        <label>Company logo</label>
        <div class="form-group">
        <img id="tempimg" style='border:1px solid black;' src="<?php echo base_url().USER_PHOTO.'/noImageUploaded.png';?>" width="35%" height="35%">
          <input type="file" placeholder="upload Photo" name="image" id="image" onChange="loadImg(this);">
        </div>
        <div class="form-group">
          <input type="checkbox" name="transcribe" id="transcribe">
          <label for="transcribe"><span></span>Transcribe</label>
        </div>
      </div>
      <!-- .col -->
      <div class="col-sm-5 col-sm-offset-3">
        <h3>targets set up</h3>
        <div class="form-horizontal sb-form">
          <div class="form-group">
            <label for="no_survey"class="col-sm-6 control-label">No. of  surveys per day</label>
            <div class="col-sm-6">
              <input type="text" value="" name="no_survey" id="no_survey" maxlength="10" class="sb-control" />
            </div>
          </div>
          <div class="form-group">
            <label for="avg_total"class="col-sm-6 control-label">Average total score</label>
            <div class="col-sm-6">
              <input type="text" value="" name="avg_total"  id="avg_total" maxlength="10" class="sb-control"/>
            </div>
          </div>
          <div class="form-group">
            <label for="no_incomplete"class="col-sm-6 control-label">No. of incompletes per day</label>
            <div class="col-sm-6">
              <input type="text" value="" class="sb-control" name="no_incomplete" id="no_incomplete" maxlength="10" />
            </div>
          </div>         
          <div class="form-group">
            <label for="nps_score"class="col-sm-6 control-label">NPS Score</label>
            <div class="col-sm-6">
              <input type="text" value="" placeholder="" class="sb-control" id="nps_score" name="nps_score" maxlength="10" />
            </div>
          </div>
          <div class="form-group">
            <label for="no_max"class="col-sm-6 control-label">No. of maximum per day</label>
            <div class="col-sm-6">
              <input type="text" class="sb-control" value=""  name="no_max" id="no_max" maxlength="10" />
            </div>
          </div>
          <div class="form-group">
            <label for="start_time"class="col-sm-6 control-label">Day start time</label>
            <div class="col-sm-6">
              <input type="text" value="" class="sb-control" name="start_time" id="start_time" maxlength="10" />
            </div>
          </div>
          <div class="form-group">
            <label for="end_time"class="col-sm-6 control-label">Day end time</label>
            <div class="col-sm-6">
              <input type="text" class="sb-control" value="" name="end_time" id="end_time" maxlength="10" />
            </div>
          </div>
        </div>
        <!-- .form-horizontal -->
        <div class="form-group text-right">
          <input type="hidden" name="jsonCamp" id="jsonCamp" value="">
          <!-- Add New Campaign Hidden Url -->
		  <input type='hidden' id='addCamapaignHiddenUrlForJS' value='<?php echo site_url("campaigns/add/ajaxRequest");?>'>
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
<!-- #content -->
<script type="text/javascript">
var campaigns=new Array();
$(document).ready(function(){
	$('#error2').hide();
	
campaigns=new Array();
	
});

function validateForm()
{
	$('#error2').hide();
	
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
	}
	return valid;
}	




/*
 * Validate form fields
 */

//validate signup form on keyup and submit
	jQuery("#accountSetupform").validate({
		rules: {
			name: {
				required: true,
				minlength: 3
			},
			adminname: {
				required: true,
				minlength: 3
			},
			password: {
				required: true,
				minlength: 8
			},
			adminemail: {
				required: true,	
				email:true			
			},			
			no_survey: {
				required: true,
				number:true				
			},
			avg_total:
			{
				required: true,
				number:true	
			},
			no_incomplete:
			{
				required: true,
				number:true	
			},
			nps_score:
			{
				required: true,
				number:true	
			},
			no_max:
			{
				required: true,
				number:true	
			},
			start_time:
			{
				required: true
			},
			end_time:{
				required: true
			}	
		},
		messages: {			
			name: {
				required: "Please enter a company name",
				minlength: "Company name must consist of at least 3 characters"
			},
			adminname: {
				required: "Please enter a administrator name",
				minlength: "Administrator name must consist of at least 3 characters"
			},
			password: {
				required: "Please provide password",
				minlength: "Password must be at least 8 characters long"
			},
			adminemail: "Please enter a administrator email",
			no_survey: {
				required:"Please enter number of surverys"
				//no_survey:"Please entery only numbers"
			},
			avg_total:{
				required:"Please enter average total score"
			},
			no_incomplete:{
				required:"Please enter number of incomplete per day"
			},
			nps_score:{
				required:"Please enter nps score"
			},
			no_max:{
				required:"Please enter number of maximum per day"
			},
			start_time:{
				required:"Please enter day start time"
			},
			end_time:{
				required:"Please enter day end time"
			}
		}
	});

var i=0;
function addCampaign()
{
	if($("#campaign_name").val()!="")
	{
		campaigns[i]=$("#campaign_name").val();
		$("#Campaign_ids").append("<li id='"+$("#campaign_name").val()+"'>"+$("#campaign_name").val()+"</li>");
		$("#campaign_name").val("");
		i++;
	}
	//console.log(campaigns);
}


jQuery('#start_time').datetimepicker({
	  datepicker:false,
	  format:'H:i'
	});
jQuery('#end_time').datetimepicker({
	  datepicker:false,
	  format:'H:i'
});
	
function loadImg(img) {
	
	if(fileExtensionValidate('image'))
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

function fileExtensionValidate(valId){
	var ext = $('#'+valId).val().split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg','GIF','PNG','JPG','JPEG']) == -1) {
		jQuery('#'+valId).val('');
	    alert("Invalid File Type.");
		return false;
	}else
		return true;
}
</script>
