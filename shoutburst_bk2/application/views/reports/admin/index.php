<div id="content">
<div class="container">
<div class="row content-header"><a href="<?php echo base_url().'reports/add_report'?>" class="sb-btn sb-btn-blue" role="button">Add New
Report</a> <a href="#" class="main-nav-toggle"></a><?php echo heading('&nbsp;&nbsp;&nbsp;&nbsp;'.'Report Management', 1);?> <?php echo $this->session->flashdata('message');?>
</div>
<?php if($this->session->flashdata('reportSuccessMessage')!=''){?>
	<div id="message" class="update">
		<?php echo $this->session->flashdata('reportSuccessMessage');?>
	</div>
<?php } ?>
<div class="row content-body">
<div class="col-md-12">
<table class="table table-striped table-bordered dataTable" id="dashboardDatatable">
	<thead>
		<tr>
			<th style="display: none;">ID</th>
			<th>Report Name</th>
			<th>Created By</th>
			<th>Created On</th>		
			<th>Permissions</th>
			<th>Type</th>
			<th>Email</th>
			<th>FTP</th>
			<th>Wallboard</th>
			<th>Dashboard</th>			
            <th class="text-center">Edit</th>
            <th class="text-center">Copy</th>
            <th class="text-center">Delete</th>
			<th class="text-center">Show in Dashboard</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	
	foreach ($reports as $key){ ?>
		
		<tr><td style="display: none;"><?php echo  $key->report_id;?></td>
			<td>
			<?php
			if($key->report_type=='data')
			{
				$urlLink = base_url().'reports/data_report_view/'.$key->report_id;
				echo $key->report_name." <a href='$urlLink' target='_blank'><img src='img/open_icon.png' style='float:right;'/></a>";				
			}elseif($key->report_type=='detail')
			 {
				$urlLink = base_url().'reports/detail_report_view/'.$key->report_id;
				echo $key->report_name." <a href='$urlLink' target='_blank'><img src='img/open_icon.png' style='float:right;'/></a>";				
			}else 
			{
			?>
				<?php echo $key->report_name;?> 
				<a href="#myModal" id='modal1' class="modal-iframe" role="button" data-toggle="modal" data-src="<?php echo base_url().'reports/view_report/'.$key->report_id.'/full_view'?>" data-height=600 data-width=100% >
				<img src='img/open_icon.png' style='float:right;'/>
				</a>
			<?php }?>
			</td>
			<td><?php echo $key->full_name;?></td>
			<td><?php echo ($key->createdon);?></td>
			<td><?php echo ucwords( $key->privacy );?></td>
			<td>
				<?php echo ucwords( $key->report_type );?>				
			</td>
			<?php
			if ($key->op_req == 'email'){
				$email = 'YES';
				$title = str_replace(",", "\n", $key->email_address );
			}else{
				$email = 'NO';
				$title = '';
			}
			?>
			<td title="<?php echo $title;?>"><?php echo $email;?></td>
			<td>
				<?php echo ($key->op_req == 'ftp') ? 'YES' : 'NO';?>
			</td>
			<td align="center"><?php echo ($key->wallboard == 1) ? '<span class="glyphicon green glyphicon-ok"></span>' : '<span class="invisible">0</span>';?></td>
			<td align="center"><?php echo ($key->dashboard == 1) ? '<span class="glyphicon green glyphicon-ok"></span>' : '<span class="invisible">1</span>';?></td>
			
			<td class="text-center">
				<?php 
					echo anchor("reports/updateReport/".$key->report_id,'<span class="glyphicon black glyphicon-pencil"></span>');
				?>
			</td>
            <td class="text-center">
            	
            	<?php echo anchor("reports/copyReport/".$key->report_id,'<span class="glyphicon black custom-icon icon-copy"></span>', array('class' => 'reportCopy','style'=>'','id'=>$key->report_id)); ?>
            </td>
            <td class="text-center">
				<?php 
					echo anchor("reports/delete/".$key->report_id,'<span class="glyphicon red glyphicon-remove"></span>', array('class' => 'confirm','style'=>'','id'=>"delete__".$key->report_id));
				?>
			</td>
			<td class="text-center">
			<?php
			if ($key->report_type != 'data'){
				# check if report published on dashboard?
				$result = $this->reports->my_dashboard_report($key->report_id);
	            if(!empty($result)){
					echo anchor("reports/status/".$key->report_id."/disable",'<span class="glyphicon green glyphicon-ok"></span><span class="invisible">1</span>', array('class' => 'confirm','style'=>'','id'=>"disable__".$key->report_id));
				}else{
					echo anchor("reports/status/".$key->report_id."/enable",'<span class="glyphicon red glyphicon-remove"></span><span class="invisible">0</span>', array('class' => 'confirm','style'=>'','id'=>"enable__".$key->report_id));
				}
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

			if ( actionPerformed == 'delete' ){
				var uri = '<?php echo site_url("reports/delete/");?>';
			}else{
				var uri = '<?php echo site_url("reports/status/");?>';
			}

			$.ajax({
	            type : 'GET',
				url : uri+"/"+currentId+"/"+actionPerformed,
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

<style type="text/css">
h3.title {
	text-transform: capitalize;
	font-weight: normal;
	color: #3fadf6;
	margin: 10px 100px 10px 0;
	padding: 0 0 20px;
	border-bottom: 1px solid #e1e8ed;
}
</style> 
<!-- Modal -->
<div id="myModal" class="modal sb nohf fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<button type="button" class="sb-close" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-body">
			<iframe frameborder="0"></iframe>
		</div><!-- .modal-body -->
    </div>
  </div>
</div>
<!--// Modal -->

<script>

	$('a.modal-iframe').on('click', function(e) {
		var src = $(this).attr('data-src');
		var height = $(this).attr('data-height') || 500;
		var width = $(this).attr('data-width') || '100%';
	
		$("#myModal iframe").attr({'src':src,
								   'height': height,
								   'width': width});
	});
	
	//show.bs.modal
	// This event fires immediately when the show instance method is called. If caused by a click, the clicked element is available as the relatedTarget property of the event.
	$('#myModal').on('show.bs.modal', function (e) { 
	  // do something...
	//  alert('shown.bs.modal');
		//var windowHeight = $(window).height();
		var h = $(window).height();
		$(this).find('.modal-body').height( h - 20);
	})


</script>

