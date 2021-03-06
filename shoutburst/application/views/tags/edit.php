<script type="text/javascript">
$(document).ready(function(){
	$("#data_set").change(function()
	{
    	var value = $(this).val();
    	$("#details_div").html('');
    	$("#details_div").html('Loading...');    	
    	
    	// load all tours w.r.t selected Country
		$.ajax({
            type : 'GET',
            url : "<?php echo base_url().'tags/load_data_set_detail/edit/'?>"+value+"<?php echo '/'.$tag[0]->tag_id?>",           
            /*data: {
            	data_set : value
            },*/
            success:function (data) {
            	$("#details_div").html('');
            	$("#details_div").show();
                if(data == 0){
                	$("#details_div").html('Nothing found');
                }else{
                    $("#details_div").append(data);
                }
            }          
        });
	});	
})

function check_it(){ 
	var tag_name = $("#tag_name").val();
	jQuery('#errMsg').css('display','none');

	var start_score = $("#start_score").val();
	var score = $("#score").val();
	var score_operator = $("#details").val();

	if (tag_name == ''){
		jQuery('#errMsg').text('Please enter tag name.');
		jQuery('#errMsg').css('display','block');
		return false;
	} else if ( (score_operator == 'B') && ( parseInt(start_score) > parseInt(score) )){
		alert('Start score must be less than end score');
		return false;
	}else{
		return true;
	}	
}
</script>

<div id="content">
  <div class="container">
    <div class="row content-header">
      <?php echo anchor("tags","Back", array('class'=>('sb-btn sb-btn-white'))); ?>
      <h1>Edit Tag</h1>
    </div>
    <!-- .row -->
    <div class="row content-body">
      <div class="col-sm-5"> <?php echo heading('Edit Tags Setup', 3);?> <?php echo form_open_multipart('tags/edit/'.$tag[0]->tag_id, array('name'=>'tags', 'id'=>'tags', 'onsubmit'=>"return check_it(this)")) ?>
        <p><?php echo $this->session->flashdata('message');?></p>
        <div class="form-group">
			<input type="text" class="sb-control" value="<?php echo isset($tag[0]->tag_name) ? $tag[0]->tag_name : ''?>" name="tag_name" id="tag_name" placeholder="Tag name" />
			<div id='errMsg' style='display:none;color:red;'></div>
        </div>
        <div class="form-group">
          <select name="data_set" id="data_set" class="sb-control">
			<option value="0">Select Data Set</option>
			<option value="teams" <?php echo ($tag[0]->data_set=='teams')?'selected="selected"':'';?>>Teams</option>
			<option value="agents" <?php echo ($tag[0]->data_set=='agents')?'selected="selected"':'';?>>Agents</option>
			<option value="score_levels" <?php echo ($tag[0]->data_set=='score_levels')?'selected="selected"':'';?>>Score Levels</option>
			<option value="cli" <?php echo ($tag[0]->data_set=='cli')?'selected="selected"':'';?>>CLI</option>
			<option value="transcriptions" <?php echo ($tag[0]->data_set=='transcriptions')?'selected="selected"':'';?>>Transcriptions</option>
			<option value="sentiment" <?php echo ($tag[0]->data_set=='sentiment')?'selected="selected"':'';?>>Sentiment</option>
		</select>
        </div>
        <div class="form-group">
          <div id="details_div" style="display:block;"><?php echo isset($details) ? $details : ''?></div>
        </div>
        <div class="form-group">
          <div> 
					 <div>
						 <?php
				        	$json = json_decode($tag[0]->camp_ids);        	
				        	if ( is_array($json) ){
				        		$comp_ids = $json;
				        	} else {
				        		$comp_ids = explode(',', $json );
				        	}        	
				        	?>
						  <select name='campaign_name[]' id='campaign_name' data-placeholder="Please Select Campaigns" multiple class="sb-control chosen-select-no-results" tabindex="11">
								  <?php
									if(!empty($campaigns)){
										foreach($campaigns as $campaignsRow){
											
										$selected = '';
										if ( in_array($campaignsRow->camp_id, $comp_ids) ){
											$selected = 'selected="selected"';
										}
								 ?>
										<option value="<?php echo $campaignsRow->camp_id;?>" <?php echo $selected;?> ><?php echo $campaignsRow->camp_name;?></option>
								 <?php
										}
									}
								  ?>			
							</select>
							<br/>
							<span id='addNewCampaignRegionLink'>
							  <a href ='javascript:;' onclick='addNewCampaignShowRegion(); return false;' ><br>Add New Campaign</a>
							 <span>		
						</div>
						
						<div style='display:none;' id='new-campiagn-region'>
							<br><input type='text' id='addNewCampaign'  placeholder="Add New Campaign" class='sb-control span3 input-large'></input>							
							<span id='RemoveCampaignRegion'>
								<a href ='javascript:;' onclick='addNewCampaign(); return false;' >Add</a>
								&nbsp;|&nbsp;
								<a href ='javascript:;' onclick='removeNewCampaign(); return false;' >Close</a>
							 </span>		 
						</div>
						<div id='errorRegion' style='display:none; color:red;'></div>
				</div>
        </div>
        <div class="form-group text-right">
        	<!-- Add New Campaign Hidden Url -->
			<input type='hidden' id='addCamapaignHiddenUrlForJS' value='<?php echo site_url("campaigns/add/ajaxRequest");?>'>
          <button type="submit" class="btn btn-primary-green">Save</button>
        </div>
        </form>
      </div>
    </div>
    <!-- .row -->
  </div>
  <!-- .container -->
</div>
<!-- #content -->
