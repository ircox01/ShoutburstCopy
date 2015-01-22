<script type="text/javascript">
function check_it(){ 
	var camp_name = $("#camp_name").val();
	if (camp_name == ''){
		alert('Please enter campaigns name.');
		return false;
	}else{
		return true;
	}
	return true;
}
</script>

<?php echo heading('Add Campaigns', 3);?>

<?php echo form_open_multipart('campaigns/add', array('name'=>'campaigns', 'id'=>'campaigns', 'onsubmit'=>"return check_it(this)")) ?>
<p><?php echo $this->session->flashdata('message');?></p>
    <table>
        <tr>
            <td valign="top"><label>Campaigns Name*: </label></td>
            <td valign="top">
                <input type="text" value="" name="camp_name" id="camp_name" />
            </td>
        </tr>
        
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2" align="right"><input type="submit" value="Save" name="submit" id="submit" /></td></tr>
    </table>
</form>