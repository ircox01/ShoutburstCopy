<script type="text/javascript">
function check_it(){
	var campaigns = $("#campaigns option:selected").text();
	var agents = $("#agents option:selected").text();
	var start_score = $("#start_score").val();
	var score = $("#score").val();
	var score_operator = $("#score_operator").val();
	
	if (campaigns=='' || agents==''){
		alert('Please select Campaign(s) & Agent(s)');
		return false;
	}
	if ( (score_operator == 'B') && (start_score > score)){
		alert('Start score must be less than end score');
		return false;
	}
	
	return true;
}

$(document).ready(function(){

	$('#start_score').val(0);
	$('#score').val(0);
	
	$("#score_operator").change(function()
	{
		var value = $(this).val();

		if (value == 'B'){
			$('#div_start_score').show();
		} else {
			$('#start_score').val(0);
			$('#div_start_score').hide();
		}
	});
})
</script>

<?php echo heading('Manage Filter', 3);?>

<?php echo form_open_multipart('manage_filter', array('name'=>'filter', 'id'=>'filter', 'onsubmit'=>"return check_it(this)")) ?>
    <p><?php echo $this->session->flashdata('message');?></p>
    <table>
        <tr>
            <td valign="top"><label>Campaigns* : </label></td>
            <td valign="top">
                <select name="campaigns[]" id="campaigns" multiple="multiple" class='multi'>
                    <?php
	                foreach ($campaigns as $c)
					{
						echo '<option value="'.$c->camp_id.'">'.$c->camp_name.'</option>';
					}
	                ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td valign="top"><label>Agents* : </label></td>
            <td valign="top">
                <select name="agents[]" id="agents" multiple="multiple" class='multi'>
                <?php
                foreach ($agents as $a)
				{
					echo '<option value="'.$a->user_id.'">'.$a->full_name.'</option>';
				}
                ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td valign="top"><label>Score : </label></td>
            <td valign="top">
                <select name="score_operator" id="score_operator">
                    <option value="G">Greater Than</option>
                    <option value="L">Less Than</option>
                    <option value="E">Equal To</option>
                    <option value="B">Between</option>
                </select>                
            </td>
            <td>
            	<div style="display:none;" id="div_start_score">
                	<input class="txtTesting" type="text" value="" placeholder="0" name="start_score" id="start_score" style="width:25px;" maxlength="2" />
                </div>
                <input class="txtTesting" type="text" value="" placeholder="0" name="score" id="score" style="width:25px;" maxlength="2" />
            </td>
        </tr>
        
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2" align="right"><input type="submit" value="Save Filter" name="submit" id="submit" /></td></tr>
    </table>
</form>

<script>
	$(".txtTesting").jStepper({minValue:0, maxValue:99, minLength:2});
	<?php if (!empty($msg)){?>alert('<?php echo $msg?>');<?php }?>
</script>