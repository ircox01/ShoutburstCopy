<link rel="stylesheet" type="text/css" href="../../../css/jquery.datetimepicker.css"/ >
<div id="content">
  <div class="container">
    <div class="row content-header">
      <?php echo anchor("media/links","Back", array('class'=>('sb-btn sb-btn-white'))); ?>
      <h1>Agent Indicator Links</h1>
      <p><?php echo $this->session->flashdata('message');?></p>
    </div>
    <!-- .row -->
    <div class="row content-body cf"> <?php echo form_open('media/link_submit',array('id'=>"mediaLinkForm")); ?>
      <div class="col-sm-8">
        <h3>Edit Agent Indicator Link</h3>
        <div class="form-group">
        Please enter a link name that will appear in the Call Reason dropdown
		<input type="text" autofocus class="sb-control" placeholder="Link name" id="name" name="data[name]" value="<?php echo isset($item->name) ? htmlspecialchars($item->name) : ''?>">
        </div>
        <div class="form-group">
		  Please select a ShoutBurst campaign for this link	
          <select name="data[camp_id]" id="campaign_name" data-placeholder="Please select a campaign" class="sb-control chosen-select-no-results1">
			 <option value=""></option>
            <?php
				if(!empty($campaigns))
				{
					foreach($campaigns as $campaignsRow)
					{
						echo '<option value="'.$campaignsRow->camp_id.'"';
						if(isset($item->camp_id) && ($item->camp_id == $campaignsRow->camp_id)) echo ' selected';
						echo '>'.htmlspecialchars($campaignsRow->camp_name).'</option>';
					}
				}
			  ?>
          </select>
        </div>
        <div class="form-group">
		  Please select a media for this link
          <select name="data[media_id]" id="media_name" data-placeholder="Please select a media" class="sb-control chosen-select-no-results1" onchange="media_change()">
			 <option value=""></option>
            <?php
				if(!empty($media))
				{
					foreach($media as $row)
					{
						echo '<option value="'.$row->media_id.'"';
						if(isset($item->media_id) && ($item->media_id == $row->media_id)) echo ' selected';
						echo '>'.htmlspecialchars($row->name).'</option>';
					}
				}
			  ?>
          </select>
        </div>
		<div style="border: 1px dotted grey;padding:10px;display:none" id="sm_media_box">
    	<div class="form-group text-right">
		  <div style="font-size:x-small;margin-top:-7px;margin-bottom:10px">SurveyMonkey</div>
	      <?php 
	 		if ($sm_connected) {
 				echo '<a href="javascript:sm_disconnect()" id="0" class="sb-btn sb-btn-delete confirm">Disconnect from SurveyMonkey</a>';
			} else {	
 				echo '<a href="javascript:sm_connect()" id="0" class="sb-btn sb-btn-green">Connect to SurveyMonkey</a>';
			}	
			?>
	    </div>
        <div class="form-group">
          Please enter a survey that will be connected to this indicator link (required)
          <select name="sm[survey_id]" id="sm_survey" data-placeholder="Please select a survey" class="sb-control chosen-select-no-results1">
			 <option value=""></option>
            <?php
				if(!empty($sm_surveys))
				{
					foreach($sm_surveys as $row)
					{
						echo '<option value="'.$row->id.'"';
						if(isset($sm) && isset($sm->survey_id) && ($sm->survey_id == $row->id)) echo ' selected';
						echo '>'.htmlspecialchars($row->name).'</option>';
					}
				}
			  ?>
          </select>
        </div>
        <div class="form-group">
        Please enter a reply email address of the message to be sent to recipients (required)
		<input type="text" autofocus class="sb-control" placeholder="Reply Email" id="sm_reply_email" name="sm[reply_email]" value="<?php echo isset($sm) && isset($sm->reply_email) ? htmlspecialchars($sm->reply_email) : ''?>">
        </div>
        <div class="form-group">
        Please enter a subject of the message to be sent to recipients (required)
		<input type="text" autofocus class="sb-control" placeholder="Message Subject" id="sm_subject" name="sm[subject]" value="<?php echo isset($sm) && isset($sm->subject) ? htmlspecialchars($sm->subject) : ''?>">
        </div>
        <div class="form-group">
        Optionally enter a body of the message to be sent to recipients (optional)<br>
		Please refer to the <a href="http://help.surveymonkey.com/articles/en_US/kb/SurveyLink-and-RemoveLink" target="_blank">SurveyMonkey documentation</a> regarding requirements and available tags
		<textarea autofocus class="sb-textarea" placeholder="Message Body" id="sm_body_text" name="sm[body_text]" rows="5"><?php echo isset($sm) && isset($sm->body_text) ? htmlspecialchars($sm->body_text) : ''?></textarea>
        </div>
		</div>
		<br>
		<div class="form-group">
			<button type="submit" class="sb-btn sb-btn-green">Save</button>
		</div>
      </div>
	  <input type="hidden" name="data[link_id]" value="<?php echo $link_id; ?>">
      </form>
    </div>
    <!-- .row -->
  </div>
  <!-- .container -->
</div>
<!-- #content -->
<script type="text/javascript">
$(document).ready(function(){
	$('#error2').hide();
	media_change();	
	jQuery(".confirm").confirm({
		text: "Are you sure you want to perform this action?",
		title: "Confirmation required",
		confirmButton: "Yes",
		cancelButton: "No",
		post: false
	});		
});

function media_change() {
	var media = $("#media_name").val();
	$("#sm_media_box").fadeOut();
	if (media == 1) { // SM
		$("#sm_media_box").fadeIn();
	}
}

jQuery("#mediaLinkForm").validate({
	rules: {
		'data[name]': {
			required: true
		},
		'data[camp_id]': {
			required: true
		},
		'data[media_id]': {
			required: true
		},
		'sm[reply_email]': {
			required: {
				depends: function(e) {
					return $('#sm_survey').val() != '';
				}
			},
			email: true
		},
		'sm[subject]': {
			required: {
				depends: function(e) {
					return $('#sm_survey').val() != '';
				}
			}
		}	
	},
	messages: {			
		'data[name]': {
			required: "Please enter a link name"
		},
		'data[camp_id]': {
			required: "Please select a campaign"
		},
		'data[media_id]': {
			required: "Please select a media"
		},
		'sm[reply_email]': {
			required: "Please enter a email address of the message to be sent to recipients",
			email: "Please enter a valid email address of the message to be sent to recipients"
		},
		'sm[subject]': {
			required: "Please select a subject of the message to be sent to recipients"
		}
	}
});

function sm_connect() {
	jQuery('#mediaLinkForm').attr('action', '/media/sm_connect');
	jQuery('#mediaLinkForm').submit();
}

function sm_disconnect() {
	jQuery('#mediaLinkForm').attr('action', '/media/sm_disconnect');
	jQuery('#mediaLinkForm').submit();
}

</script>
