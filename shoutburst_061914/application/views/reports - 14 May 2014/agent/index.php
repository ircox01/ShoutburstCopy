<div id="content">
<div class="container">
<div class="row content-header"><?php echo heading('Report Management', 1);?> <?php echo $this->session->flashdata('message');?>
</div>
<?php if($this->session->flashdata('reportSuccessMessage')!=''){?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
		<?php echo $this->session->flashdata('reportSuccessMessage');?>
	</div>
<?php } ?>
<div class="row content-body">
<div class="col-md-12">
<table class="table table-striped table-bordered dataTable" id="dashboardDatatable">
	<thead>
		<tr>
			<th>Report Name</th>
			<th>Created By</th>
			<th>Created On</th>
			<th class="text-center">Show in Dashboard</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($reports as $key){ ?>
		<tr>
			<td><?php echo $key->report_name;?></td>
			<td><?php echo $key->full_name;?></td>
			<td><?php echo date("d/m/y", strtotime($key->created_on));?></td>
			<td class="text-center">
			<?php
			# check if report published on dashboard?
			$result = $this->reports->my_dashboard_report($key->report_id);
            if(!empty($result)){
				echo anchor("reports/status/".$key->report_id."/disable",'<span class="glyphicon green glyphicon-ok"></span>', array('class' => 'confirm','style'=>'','id'=>"disable__".$key->report_id));
			}else{
				echo anchor("reports/status/".$key->report_id."/enable",'<span class="glyphicon red glyphicon-remove"></span>', array('class' => 'confirm','style'=>'','id'=>"enable__".$key->report_id));
			}
			?>
			</td>
		</tr>
		<?php }?>
	</tbody>
</table>
</div>
</div>
<!-- .row --></div>
<!-- .container --></div>
<!-- #content -->

<script>
// confirm box for enable and disable agent
jQuery(".confirm").confirm({
	text: "Are you sure you want to perform this action?",
	title: "Confirmation required",
	confirm: function( urlAndid) {
		//split to get url and id
		var urlAndidArr	=	urlAndid.split('__==__');
		if(urlAndidArr[0]&&urlAndidArr[1]){
			url	=	urlAndidArr[0];
			id	=	urlAndidArr[1];
					
			//remove attr and set message wait for ajax request completion
			jQuery('#'+id).attr('href','');
			jQuery('#'+id).text('Please Wait...');	
			//split id to determine which action is perform
			var idArr	=	id.split('__');
			var actionPerformed	=	idArr[0];
			var currentId		=	idArr[1];

			$.ajax({
	            type : 'GET',
				url : '<?php echo site_url("reports/status/");?>'+"/"+currentId+"/"+actionPerformed,
	            success:function (data) {
		            window.location = "<?php echo base_url().'reports'?>";	            	
	            }
	        });

		}
	},
	cancel: function(button) {
		// do something
	},
	confirmButton: "Yes",
	cancelButton: "No",
	post: true
});		

//report copy confirm box
// confirm box for enable and disable agent
jQuery(".reportCopy").confirm({
	text: "Are you sure you want to copy this report?",
	title: "Confirmation required",
	confirm: function( urlAndid) {
		//split to get url and id
		var urlAndidArr	=	urlAndid.split('__==__');
		if(urlAndidArr[0]&&urlAndidArr[1]){
			url	=	urlAndidArr[0];
			id	=	urlAndidArr[1];
					
			//remove attr and set message wait for ajax request completion
			jQuery('#'+id).attr('href','');
			jQuery('#'+id).text('Please Wait...');	
			//split id to determine which action is perform
			var idArr	=	id.split('__');
			var actionPerformed	=	idArr[0];
			var currentId		=	idArr[1];

			$.ajax({
	            type : 'GET',
				url : url,
	            success:function (data) {
		           window.location = "<?php echo base_url().'reports'?>";	            	
	           }
	        });

		}
	},
	cancel: function(button) {
		// do something
	},
	confirmButton: "Yes",
	cancelButton: "No",
	post: true
});		
</script>