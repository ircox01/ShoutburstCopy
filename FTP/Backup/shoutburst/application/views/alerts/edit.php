<script>
	// validate signup form on keyup and submit
	jQuery("#editalerts").validate({
		rules: {
			alert_name: {
				required: true,
				minlength: 3
			},
			period: {
				required: true
			}
		},
		messages: {			
			alert_name: {
				required: "Please enter a alert name",
				minlength: "Alert name must consist of at least 3 characters"
			},
			period: "Please select period"
		}
	});

	$('#send_email').click(function () {
	    $("#emaildiv").toggle(this.checked);
	});
	$('#send_sms').click(function () {
	    $("#sms").toggle(this.checked);
	});

	$("#score_type").on("change",function(){
		$("#e1").css("display","none");
	});
	$("#operator").on("change",function(){
		$("#e2").css("display","none");
	});
	$("#score1").keypress(function() {
		$("#e3").css("display","none");
	});
		$(document).ready(function(){
			if($('#send_email').is(':checked')){
				$("#emaildiv").css("display","block");
			}
			if($('#send_sms').is(":checked")){
				$("#smsdiv").css("display","block");
			}
		});
		
		var count=0;
		var score_type="";	
		var operator="";	
		var score_type="";		
		var conditionArray=[];
		
		$("#addfilter").click(function()
		{
			
			scoretype = document.getElementById('score_type');
			score_type =scoretype.options[scoretype.selectedIndex].value;
			operator1 = document.getElementById('operator');
			operator =operator1.options[operator1.selectedIndex].value;			
		    score=document.getElementById('score1').value;
		    count = conditionArray.length;
		 	if(isNaN(score)==false){
			if(score_type !='' && operator!='' && score!='' )
			{	 
				str="";
				condition="";				
				if(count<=3)
				{			   
				    if(count>0)
				    {
				    	cond1 = document.getElementById('condition1');
				    	condition =cond1.options[cond1.selectedIndex].value;
				    }			
				    str = condition+" "+score_type+" "+operator+" "+score;
				    conditionArray[count] = str;
				    $('#morefilters').append("<div class='row form-group' id='filter-"+count+"'><div class='col-xs-6'>"+str+"</div><div class='col-xs-6'><a href='#' onClick=\"removeFilter(\'"+count+"\')\"><span class='glyphicon red glyphicon-minus-sign'></span></a></div></div>");
					count++;
					$("#score_type option[value='']").attr('selected', 'selected');
					$("#operator option[value='']").attr('selected', 'selected');
					$("#score1").val('');				
				}
			}
		 	}else {
			 	alert("Score must be a numeric value");
		 	}
		});

		function removeFilter(divid)
		{			
			$("#filter-"+divid).remove();
			if(divid==0){divid=1;}
			delete conditionArray[divid-1];
			count--;
		}

		function check_it()
		{	
			conditionArray = conditionArray.filter(function(n){ return n != undefined });
			
		
			if(conditionArray.length == 0 )
			{
				scoretype = document.getElementById('score_type');
				score_type =scoretype.options[scoretype.selectedIndex].value;
				operator1 = document.getElementById('operator');
				operator =operator1.options[operator1.selectedIndex].value;	
				score=document.getElementById('score1').value;
				if(score_type==""){$("#e1").css("display","block");return false;}
				else if(operator==""){$("#e2").css("display","block");return false;}
				else if(score==""){$("#e3").css("display","block");return false;}
				else if(isNaN(score)){$("#e4").css("display","block");return false;}
				else
				{				
					str = score_type+" "+operator+" "+score;
				 	conditionArray[0] = str;						
					$("#filters1").val(conditionArray.toString());
					return true;
				}
			}
			$("#filters1").val(conditionArray.toString());
			return true;
		}		
</script>
 
<?php echo form_open_multipart('alerts/edit', array('name'=>'alerts', 'id'=>'editalerts', 'onsubmit'=>'return check_it()')) ?>

<?php echo $this->session->flashdata('message');?>
<div class="modal-header">
            <button type="button" class="sb-close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Update Alert</h4>
</div>
        <div class="modal-body cf">
          <div class="f orm-horizontal s b-form">
            <div class="form-group">
                    <input type="text" autocomplete="off" autofocus="autofocus" name="alert_name" id="alert_name" class="sb-control" 
                    value="<?php echo $alert[0]->alert_name;?>">
                    <input type="hidden" id="alert_id" name="alert_id" value="<?php echo $alert[0]->alert_id;?>">
            </div>
            <div class="form-group">
                     <select name="score_type" id="score_type" class="sb-control">                     	
                        <option value="">Score Type</option>
                        <option value="total score" >Total score</option>                
                        <option value="question score" >Question score</option>
                        <option value="total surveys" >Total surveys</option>
                      </select>  
                     <span id="e1" style="display:none;color:red;" ><i>Please select score type</i></span>                 
            </div>
			<div class="form-group">
                     <select name="operator" id="operator" class="sb-control">
                        <option value="">Operator</option>
                        <option value="=" >equals</option>                
                        <option value="<" >less than</option>
                        <option value=">" >greater than</option>
                      </select>     
                      <span class="error" for="operator" id="e2" style="display:none;color:red;"><i>Please select operator</i></span>                
            </div>
            <div class="form-group">
                     <input type="text" name="score" id="score1" class="sb-control" value="<?php //echo $alert[0]->score;?>">                    
           		<span class="error" for="score" id="e3" style="display:none;color:red;"><i>Please enter score</i></span>
           		<span class="error" for="score" id="e4" style="display:none;color:red;"><i>Please enter only numbers</i></span>
            </div>
              <div class="row form-group">
	               <div class="col-xs-6">
	               <select name="condition1" id="condition1" class="">
                        <option value="And">And</option>
                        <option value="Or">Or</option>
                      </select></div>
	               <div class="col-xs-6 text-right"><a href="#" id="addfilter">Add Filter</a></div>   
              </div>
               <div id="morefilters" class="form-group">
                    <?php 
                     $filters=explode(",",$alert[0]->filter_conditions);
                     $filters=array_filter($filters);
		             $count=1;		           
		             if(!empty($filters))
					 {
		             	foreach($filters as $filt)
					 	{					 						 		
							echo "<div class='row form-group' id='filter-".$count."'><div class='col-xs-6'>".$filt."</div><div class='col-xs-6'><a href='#' onClick=\"removeFilter('".$count."')\"><span class='glyphicon red glyphicon-minus-sign'></span></a></div></div>";
							$count++;
						}
					}
             ?>    
		       </div>   
            <div class="form-group">
                    <select name="period" id="period" class="sb-control">
                    <option value="">Period</option>
                    <option value="lasthour" <?php echo ($alert[0]->alert_period=="lasthour")?"Selected":"";?>>Last hour</option>                
                    <option value="todate" <?php echo ($alert[0]->alert_period=="todate")?"Selected":"";?>>To date</option>
                    <option value="everycall" <?php echo ($alert[0]->alert_period=="everycall")?"Selected":"";?>>Every call</option>
                  </select>
            </div>
            <div class="form-group" >
                  <input type="checkbox" id="send_email" name="send_email" <?php echo ($alert[0]->send_email=="1")?"checked":"";?>>
                  <label for="send_email"><span></span>Send email</label>
                  <br>
                  <input type="checkbox" id="send_sms" name="send_sms" <?php echo ($alert[0]->send_sms=="1")?"checked":"";?>>
                  <label for="send_sms"><span></span>Send SMS</label>
            </div>
            <div class="form-group"  style="display:none;" id="emaildiv" >
                    <textarea  name="email_address" autocomplete="off" rows="3" cols="10" class="sb-textarea" id="email_address" value="<?php echo $alert[0]->email_addresses;?>"></textarea>
            </div>
            <div class="form-group" style="display:none;" id="smsdiv">
                    <textarea name="sms" autocomplete="off" rows="3" cols="10" class="sb-textarea" id="sms" value="<?php echo $alert[0]->sms_numbers;?>"></textarea>
            </div>
          </div>
        </div><!-- .modal-body.cf -->
        <div class="modal-footer">
            <input type="hidden" value="" id="filters1" name="filters1"/>
            <button type="button" class="btn btn-primary-red" data-dismiss="modal">Close</button>
            <button type="submit" name="submit" id="submit" class="btn btn-primary-green">Update</button>
        </div>
</form>
<script type="text/javascript">
  $(document).ready(function()
  {		
  		<?php 
  			$filters = explode(",",$alert[0]->filter_conditions);
  			$filters = array_filter($filters);
  			if(!empty($filters))
			{
  		 		if(isset($filters[0]) )
		 		{
		?>
					conditionArray[0]='<?php  echo  $filters[0];?>';		
			<?php }
			  		if(isset($filters[1]) ) 
					{
			?>
						conditionArray[1]='<?php  echo $filters[1];?>';
			<?php }?>
		<?php  if(isset($filters[2]) ) 
				{
		?>
					conditionArray[2]='<?php echo $filters[2];?>';
		<?php }
		}?>
		conditionArray = conditionArray.filter(function(n){ return n != undefined });
 });
</script>
