<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.datetimepicker.css"/ >
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js"></script>
<div id="content">
  <div class="container">
    <div class="row content-header">
      <h1>Agent Indicator Links</h1>
      <p><?php echo $this->session->flashdata('message');?></p>
    </div>
    <!-- .row -->
    <div class="row content-body cf"> <?php echo form_open_multipart('companies/account_setup',array('id'=>"accountSetupform", 'onsubmit'=>"return validateForm(this)")); ?>
	<div class="col-md-12">
	  <table class="table table-striped table-bordered dataTable" id="example">
		<thead>
			<tr>
	            <th>Link Name</th>
	            <th>Campaign</th>
	            <th>Media</th>
	            <th>Options</th>
	            <th>Action</th>
	        </tr>
		</thead>
		<tbody>
			<?php foreach ($links as $key){ ?>
			<tr>
			  <td><?php echo $key->name;?></td>
		  	  <td><?php echo $key->camp_name;?></td>
		  	  <td><?php echo $key->media_name;?></td>
		      <td><?php echo $key->options_text;?></td>
	            <td align="center">
	            	<?php echo anchor("media/link_edit/".$key->link_id,'<span class="glyphicon black glyphicon-pencil"></span>', array('title'=>'Edit link', 'class' => 'warn')).' | '?>
	            	<?php 
						echo anchor("media/link_delete/".$key->link_id,'<span class="glyphicon red glyphicon-remove"></span>', array('class' => 'confirm','style'=>'','id'=>$key->link_id, 'title'=>'Delete link')).' | ';
					?>
	            	<?php 
						echo anchor("media/sendnow/".$key->link_id,'<span class="glyphicon red glyphicon-envelope"></span>', array('class' => 'confirm','style'=>'','id'=>$key->link_id, 'title'=>'Send now!'));
					?>
	            </td>
			</tr>
	    	<?php }?>
		</tbody>
	  </table>
	  <div>
 	  <div style="float:left">
        <?php echo anchor("media/link_edit","Add a new link", array('class'=>('sb-btn sb-btn-green warn'))); ?>
      </div>
 	  <div style="float:right">
        <?php echo anchor("media/sendall","Send all surveys", array('class'=>'sb-btn sb-btn-green confirm', 'id'=>'')); ?>
      </div>
	  </div>	
	</div>
  </div>
  <!-- .container -->
</div>
<!-- #content -->

<script type="text/javascript">
$(document).ready(function(){
	//
});

jQuery(".confirm").confirm({
	text: "Are you sure you want to perform this action?",
	title: "Confirmation required",
	confirmButton: "Yes",
	cancelButton: "No",
	post: false
});		

$.fn.warn = function (options) {
	if (typeof options === 'undefined') {
        options = {};
    }
    this.click(function (e) {
        var newOptions = $.extend({
            button: $(this)
        }, options);
        $.confirm(newOptions, e);
		$(":button.confirm").hide();
    });
    return this;
};

<?php if($sm_warn) { ?>
jQuery(".warn").warn({
	text: "Please wait while your SurveyMonkey settings are being loaded...",
	cancelButton: "OK"
});
<?php } ?>

</script>
