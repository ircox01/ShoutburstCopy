 <?php echo form_open_multipart('makTest/formSubmit', array('name'=>'campaigns', 'id'=>'campaigns', 'onsubmit'=>"return check_it(this)")) ?> 
 <div>
	  <select name='campaigns[]' id='campaigns' data-placeholder="Please Select Campaigns" style="width:350px;" multiple class="chosen-select-no-results" tabindex="11">
			  <?php
				if(!empty($campaigns)){
					foreach($campaigns as $campaignsRow){
			 ?>
					<option value="<?php echo $campaignsRow->camp_id;?>"><?php echo $campaignsRow->camp_name;?></option>
			 <?php
					}
				}
			  ?>			
		</select>
		<br/>
		<span id='addNewCampaignRegionLink'>
		  <a href ='javascript:;' onclick='addNewCampaignShowRegion(); return false;' >Add New Campaign</a>
		 <span>		
	</div>
	
	<div style='display:none;' id='new-campiagn-region'>		
	<br/>
		<input type='text' id='addNewCampaign'></input>
		<span id='RemoveCampaignRegion'>
			<a href ='javascript:;' onclick='addNewCampaign(); return false;' >Add</a>
			&nbsp;|&nbsp;
			<a href ='javascript:;' onclick='removeNewCampaign(); return false;' >Cancel</a>
		 </span>		 
	</div>
	<div id='errorRegion' style='display:none; color:red;'></div>
	
	<br/><hr/><br/>
	<div>
		<input type="submit" value="Save" name="submit" id="submit" />
	</div>
	</form>
	
	
	<script type="text/javascript">  
   
		function check_it(){ 
			var campaigns = jQuery('select#campaigns').val();
			
			if (campaigns == null){
				alert('Please Select aleast one campaign.');
				return false;
			}else{
				return true;
			}
			return true;
		}

	 
       jQuery('.chosen-select-no-results').chosen({no_results_text:'Oops, nothing found!'} );
	   
	   //show add campaign region
		function addNewCampaignShowRegion(){
		  jQuery('#new-campiagn-region').css('display','block');
		  jQuery('#addNewCampaignRegionLink').css('display','none');
		}
		
		 //hide add campaign region
		function removeNewCampaign(){
		  jQuery('#new-campiagn-region').css('display','none');
		  jQuery('#addNewCampaignRegionLink').css('display','block');
		  
		  //error region hide if show
		  jQuery('#errorRegion').html('');
		  jQuery('#errorRegion').css('display','none');
		  
		  //reset value
		  jQuery('#addNewCampaign').val('');
		}
		
		//add new campaign
		function addNewCampaign(){
		
			var addNewCampaign = jQuery.trim(jQuery('#addNewCampaign').val());
			
			//remove special characters from string
			var addNewCampaign = addNewCampaign.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, ' ')
			//set value on text box to show user
			jQuery('#addNewCampaign').val(addNewCampaign);
			
			var error = '';
			
			//validate value
			if(addNewCampaign==''){
				error += 'Please Enter Campaign Name';
			}
			
			
			
			if(error!=''){			
				jQuery('#errorRegion').html(error);
				jQuery('#errorRegion').css('display','block');			
				
			}else{
				jQuery('#errorRegion').html('');
				jQuery('#errorRegion').css('display','none');
				
				var urlPath	=	'<?php echo site_url("campaigns/add/ajaxRequest");?>';			
				
				//add campaign by ajax
				jQuery.ajax({
							type: "POST",
							url: urlPath,
							data:"camp_name="+addNewCampaign,
							cache:false,
							success: function(msg){	
								var msg = jQuery.trim(msg);
								//if message are true then we update list
								if(msg){
									jQuery('.chosen-select-no-results').append("<option value='"+addNewCampaign+"'>"+addNewCampaign+"</option>");		
									jQuery('.chosen-select-no-results').trigger("chosen:updated");
									
									jQuery('#errorRegion').html('Campaign added successfully.');
									jQuery('#errorRegion').css('color','green');	
								}else{
									jQuery('#errorRegion').html('Campaign is already added in list.');
									jQuery('#errorRegion').css('color','red');	
									
								}
								jQuery('#errorRegion').css('display','block');	
							}
						});
			}
			
			
		}
		
	   //add option
	    // var key = 'mak';
	    // var value = 'mak';
	    // $('.chosen-select-no-results').append("<option value='"+key+"'>"+value+"</option>");		
		// $('.chosen-select-no-results').trigger("chosen:updated");

    
  </script>