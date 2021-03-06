<script type="text/javascript">
function check_it(){ 
	var tg_name = $("#tg_name").val();
	if (tg_name == ''){
		alert('Please enter group name.');
		return false;
	}else{
		return true;
	}
	return true;
}
</script>

<div id="content">
  <div class="container">
    <div class="row content-header">
      <?php echo anchor("tags","Back", array('class'=>('sb-btn sb-btn-white'))); ?>
      <h1>Add Group Tags</h1>
    </div>
    <!-- .row -->
    <div class="row content-body">
      <div class="col-sm-5"> <?php echo heading('Group Tags Setup', 3);?>
	  <?php echo form_open_multipart('tags/add_group', array('name'=>'add_group', 'id'=>'add_group', 'onsubmit'=>"return check_it(this)")) ?>
        <p><?php echo $this->session->flashdata('message');?></p>
        <div class="form-group">
		  <input type="text" value="" class="sb-control" name="tg_name" id="tg_name" placeholder="Group Tag name" />
          <div id='errMsg' style='display:none;color:red;'></div>
        </div>
        <div class="form-group">
          <select name="tags[]" id="add_group" data-placeholder="Please Select Tags" multiple class="sb-control chosen-select-no-results" tabindex="11">
        			<?php
        			foreach ($tags as $t)
					{
						echo '<option value="'.$t->tag_id.'">'.$t->tag_name.'</option>';
					}
        			?>
        		</select>
        </div>
        
        <div class="form-group text-right">
          <button type="submit" class="sb-btn sb-btn-green">Save</button>
        </div>
        </form>
      </div>
    </div>
    <!-- .row -->
  </div>
  <!-- .container -->
</div>
<!-- #content -->