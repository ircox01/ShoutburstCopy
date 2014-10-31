<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.8.23/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
        $(function () {
            $("ul.dragdrop").sortable({  
                connectWith: "ul"
            });
        });
</script>
<style type="text/css">
        #sort1, #sort2     
        {
            list-style-type: none;
            padding: 10px;
            margin: 5px;
            width: 200px;
            background: #FFDAB9;
            vertical-align:top;
        }
        #sort1 li, #sort2 li            
       {
            border: 2px;
            padding: 5px;
            margin: 5px;
            background: #9ACD32;
            cursor: pointer;
            border-color: Black;
            width: 180px;
            text-align: center;
            vertical-align: middle;
        }
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#op_req").change(function(){
		var value = $(this).val();

		switch (value){
			case 'email':
				$('#ftp_tr').hide();
				$('#email_tr').show();
				$('#op_req_flag').val('email');
			break;

			case 'ftp':
				$('#email_tr').hide();
				$('#ftp_tr').show();
				$('#op_req_flag').val('ftp');
			break;

			default:
				$('#email_tr').hide();
				$('#ftp_tr').hide();
				$('#op_req_flag').val('data');
			break;
		}
	});
})

/*
 * @author:	Muhammad Sajid
 * @name:	next_step
 */
function next_step(step)
{
	// hide all steps
	for(var i=1; i<=3; i++)
	{
		$("#step_"+i).hide();
	}

	// show only upcoming step
	$("#step_"+step).show();

	// if step 3 also perform some function
	if (step == 3){
		save_fields();
	}
}

/*
 * @author:	Muhammad Sajid
 * @name:	save_fields
 * @desc:	save selected fields for reports
 */
function save_fields(){
	$('.makTest').each(function(i, items_list){       
        var i = 0;
        var data = new Array();

        $(items_list).find('li').each(function(j, li){
			data[i++] = $(li).text();
        })
        alert(data);
    });
}
</script>

<?php echo form_open_multipart('reports/', array('name'=>'add_report', 'id'=>'add_report', 'onsubmit'=>"return check_it(this)")) ?>
<p><?php echo $this->session->flashdata('message');?></p>
<div id="report_content">
	
	<!-- Step 1 -->
	<div id="step_1">
		<?php echo heading('Report Creation', 2);?>
		<table>
			<tr>
	        	<td>Report Name:</td>
	            <td valign="top">
	                <input type="text" value="" name="report_name" id="report_name" placeholder="Report name" />
	            </td>
	        </tr>
	        <tr>
	        	<td>Report Type:</td>
	            <td valign="top">
	                <select id="report_type" name="report_type">
	                <?php foreach ($report_types as $rt){?>
	                	<option value="<?php echo strtolower( $rt->type_name )?>"><?php echo $rt->type_name?></option>
	                <?php }?>                	
	                </select>
	            </td>
	        </tr>
	        <tr>
	        	<td>Report Period:</td>
	            <td valign="top">
	                <select id="report_period" name="report_period">
	                <?php foreach ($report_periods as $rp){?>
	                	<option value="<?php echo strtolower( $rp->rep_prd_name )?>"><?php echo $rp->rep_prd_name?></option>
	                <?php }?>                	
	                </select>
	            </td>
	        </tr>
	        <tr>
	        	<td>Intervals:</td>
	            <td valign="top">
	                <select id="report_interval" name="report_interval">
	                <?php foreach ($report_intervals as $ri){?>
	                	<option value="<?php echo strtolower( $ri->rep_interval_name )?>"><?php echo $ri->rep_interval_name?></option>
	                <?php }?>                	
	                </select>
	            </td>
	        </tr>
	        <tr>
	        	<td valign="top">Output Requirements:</td>
	            <td valign="top">
	            	<select name="op_req" id="op_req">
	            		<option value="data">Data</option>
	            		<option value="email">Email</option>
	            		<option value="ftp">FTP</option>
	            	</select>
	            </td>
	        </tr>
		        
	        <tr id="email_tr" style="display:none;">
				<td colspan="2" align="right" valign="top">
					<textarea rows="3" cols="10" placeholder="Add email addresses [comma separated] ..."></textarea>
					<hr />
				</td>
	        </tr>
		        
	        <tr id="ftp_tr" style="display:none;">
				<td colspan="2" align="right" valign="top">
						Host:
						<input type="text" name="ftp_host_name" id="ftp_host_name" placeholder="Host" />
						<br />
						Port:
						<input type="text" name="ftp_port" id="ftp_port" placeholder="Port" />
						<br />
						Username:
						<input type="text" name="ftp_user_name" id="ftp_user_name" placeholder="Username" />
						<br />
						Password:
						<input type="text" name="ftp_password" id="ftp_password" placeholder="Password" />
						<hr />
				</td>
	        </tr>
		        
	        <tr>
	        	<td valign="top">Assigned?</td>
	            <td valign="top">
	                <input type="checkbox" id="dashboard" name="dashboard" /> Dashboard
	                <br />
	                <input type="checkbox" id="wallboard" name="wallboard" /> Wallboard
	            </td>
	        </tr>
	        <tr>
	        	<td valign="top">Privacy:</td>
	            <td valign="top">
	                <input type="radio" id="privacy" name="privacy" value="private" checked="checked"/> Private
	                <br />
	                <input type="radio" id="privacy" name="privacy" value="global" /> Global
	            </td>
	        </tr>
	
	        <tr><td colspan="2">&nbsp;<input type="hidden" name="op_req_flag" id="op_req_flag" value="data" /></td></tr>
	        <tr><td colspan="2" align="right"><input type="button" value="Next" name="btn_step_2" id="btn_step_2" onclick="next_step(2);" /></td></tr>
		</table>
	</div>
	<!--// Step 1 -->
	
	<!-- Step 2 -->
	<div id="step_2" style="display:none;">
		<?php echo heading('Data Control', 2);?>
        <table>
            <tr>
                <td valign="top">
                    <ul id="sort1" class="dragdrop">
                        <li>Date</li>
                        <li>Dialed Number</li>
                        <li>CLI</li>
                        <li>Campaign</li>
                        <li>PIN</li>
                        <li>Questions Scores</li>
                        <li>Average Score</li>
                        <li>Notes</li>
                        <li>Team</li>
                        <li>Agents</li>
                        <li>Status</li>
                        <li>Playback</li>
                        <li>Action</li>
                        <li>Transcription</li>
                    </ul>
                </td>
                <td valign="top">
                    <ul id="sort2" class="dragdrop makTest">                        
                    </ul>
                </td>
            </tr>
		</table>
        
		<table>
			<tr>
				<td colspan="2" align="right">
					<input type="button" value="Back" name="btn_step_1" id="btn_step_1" onclick="next_step(1);" />&nbsp;&nbsp;&nbsp;
					<input type="button" value="Next" name="btn_step_3" id="btn_step_3" onclick="next_step(3);" />
				</td>
			</tr>			
		</table>
	</div>
	<!--// Step 1 -->
	
	
</div>
</form>