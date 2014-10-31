<script>
	// validate
	jQuery("#addalerts").validate({
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
	    $("#smsdiv").toggle(this.checked);
	});
	
	var count=1;
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
	    
		if(score_type !='' && operator!='' && score!='' && isNaN(score)==false )
		{	 
			str="";
			condition="";
			if(count<=3)
			{
			    if(count>1)
			    {
			    	cond1 = document.getElementById('condition1');
			    	condition =cond1.options[cond1.selectedIndex].value;
			    }			
			    str = condition+" "+score_type+" "+operator+" "+score;
			    conditionArray[count-1] = str;
			    $('#morefilters').append("<div class='row form-group' id='filter-"+count+"'><div class='col-xs-6'>"+str+"</div><div class='col-xs-6'><a href='#' onClick=\"removeFilter(\'"+count+"\')\"><span class='glyphicon red glyphicon-minus-sign'></span></a></div></div>");
								
				$("#score_type option[value='']").attr('selected', 'selected');
				$("#operator option[value='']").attr('selected', 'selected');
				$("#score1").val('');
				count++;	
			}
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
		
		if(conditionArray.length==0)
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

	$("#score_type").on("change",function(){
		$("#e1").css("display","none");
	});
	$("#operator").on("change",function(){
		$("#e2").css("display","none");
	});
	$("#score1").keypress(function() {
		$("#e3").css("display","none");
		$("#e4").css("display","none");
	});
	
</script>
  <?php echo form_open_multipart('alerts/add', array('name'=>'alerts', 'id'=>'addalerts' , 'onsubmit'=>"return check_it()")) ?>
<?php echo $this->session->flashdata('message');?>
<div class="modal-header">
            <button type="button" class="sb-close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">New Alert</h4>
</div>
        <div class="modal-body cf">
          <div class="f orm-horizontal s b-form">
            <div class="form-group">
                    <input type="text" autocomplete="off" autofocus="autofocus" name="alert_name" id="alert_name" class="sb-control" placeholder="Alert name">
            </div>
            <div class="form-group" id="filters">
                     <select name="score_type" id="score_type" class="sb-control">
                        <option value="">Score Type</option>
                        <option value="total score">Total score</option>                
                        <option value="question score">Question score</option>
                        <option value="total surveys">Total surveys</option>
                      </select>
                      <span id="e1" style="display:none;color:red;" ><i>Please select score type</i></span> 
             </div>
               <div class="form-group">
               <select name="operator" id="operator" class="sb-control">
                        <option value="">Operator</option>
                        <option value="=">equals</option>                
                        <option value="<">less than</option>
                        <option value=">">greater than</option>
                      </select>
                       <span class="error" for="operator" id="e2" style="display:none;color:red;"><i>Please select operator</i></span>
               </div>                
                   <div class="form-group">
                   <input type="text" name="score" id="score1"  placeholder="Score" class="sb-control">
                   	<span class="error" for="score" id="e3" style="display:none;color:red;"><i>Please enter score</i></span>
                   	<span class="error" for="score" id="e4" style="display:none;color:red;"><i>Please enter only numbers</i></span></div>
                <div>
                <div class="row form-group">
	               <div class="col-xs-6">
	               <select name="condition1" id="condition1" class="">
                        <option value="And">And</option>
                        <option value="Or">Or</option>
                      </select></div>
	               <div class="col-xs-6 text-right"><a href="#" id="addfilter">Add Filter</a></div>   
                </div>       
		          <div id="morefilters" class="form-group">		           
		           </div>
		           </div>
		             <div class="form-group">
                  <select name="period" id="period" class="sb-control">
                    <option value="">Period</option>
                    <option value="lasthour">Last hour</option>                
                    <option value="todate">To date</option>
                    <option value="everycall">Every call</option>
                  </select>
                 </div>
            <div class="form-group">
                  <input type="checkbox" id="send_email" name="send_email">
                  <label for="send_email"><span></span>Send email</label>
                  <br>
                  <input type="checkbox" id="send_sms" name="send_sms">
                  <label for="send_sms"><span></span>Send SMS</label>
            </div>
            <div class="form-group" style="display:none;" id="emaildiv" >
                    <textarea  name="email_address" autocomplete="off" rows="3" cols="10" class="sb-textarea" id="email_address" placeholder="Add email addresses [comma separated] ..."></textarea>
            </div>
            <div class="form-group" style="display:none;" id="smsdiv">
                    <textarea name="sms" autocomplete="off" rows="3" cols="10" class="sb-textarea" id="sms" placeholder="Input telephones numbers ..."></textarea>
            </div>
          </div>
        </div><!-- .modal-body.cf -->
        <div class="modal-footer">
        <input type="hidden" value="" id="filters1" name="filters1"/>
            <button type="button" class="sb-btn sb-btn-white" data-dismiss="modal">Close</button>
            <button type="submit" name="submit" id="submit" class="sb-btn sb-btn-green">Save</button>
        </div>
  </form>