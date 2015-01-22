<script type="text/javascript">
function check_it(){ 
	return true;
}
</script>

<script type="text/javascript">
jQuery(document).ready(function() {
	$('.multi').multiSelect({
		  selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search...'>",
		  selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search...'>",
		  afterInit: function(ms){
			var that = this,
				$selectableSearch = that.$selectableUl.prev(),
				$selectionSearch = that.$selectionUl.prev(),
				selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
				selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

			that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
			.on('keydown', function(e){
			  if (e.which === 40){
				that.$selectableUl.focus();
				return false;
			  }
			});

			that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
			.on('keydown', function(e){
			  if (e.which == 40){
				that.$selectionUl.focus();
				return false;
			  }
			});
		  },
		  afterSelect: function(){
			this.qs1.cache();
			this.qs2.cache();
		  },
		  afterDeselect: function(){
			this.qs1.cache();
			this.qs2.cache();
		  }
		});
});
</script>

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
                </select>
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