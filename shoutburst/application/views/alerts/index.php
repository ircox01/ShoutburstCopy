<!-- Modal -->
<div id="myModal" class="modal sb fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
    
<!--// Modal -->
<div id="content">
  <div class="container">
    <div class="row content-header">
		<a href="#myModal" id='modal1' class="sb-btn sb-btn-blue" role="button" data-toggle="modal">Add New Alert</a>
<a href="#" class="main-nav-toggle"></a><?php echo heading('&nbsp;&nbsp;&nbsp;&nbsp;'.'Alerts', 1);?>
		<?php echo $this->session->flashdata('message');?>
	</div>
    <div class="row content-body">
      <div class="col-md-12">
        <table class="table table-striped table-bordered dataTable" id="alertsDatatable">
          <thead>
            <tr>
            <th style="display: none;">ID</th>
              <th>Alert Name</th>
              <th>Status</th>
              <th>Added By</th>
              <th>Added Date</th>
              <th>Score Type</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody><?php foreach($data as $alert) {?>
            <tr>
               <td style="display: none;"><?php echo $alert['alert_id'];?></td>
              <td><?php echo $alert['alert_name'];?></td>
              <td><?php echo ($alert['status']==1)?"Active":"Inactive";?></td>
              <td><?php echo $alert['full_name'];?></td>
              <td><?php echo $alert['createdon'];?></td>
              <td><?php echo str_replace(",", "", $alert['filter_conditions']);?></td>              
			  <td align="center">
				<a href="#myModal" id="modal2" class="edit" role="button" agentId="<?php echo $alert['alert_id'];?>" data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a>
                |
              <?php	echo anchor("alerts/delete/".$alert['alert_id']."/disable",'<span class="glyphicon red glyphicon-remove"></span>', array('class' => 'confirm','style'=>'','id'=>"disable__".$alert['alert_id']));
              ?>
			  </td>              
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div><!-- .row -->
  </div><!-- .container -->
</div><!-- #content -->

<script type="text/javascript">
$('#send_email').click(function () {
    $("#email").toggle(this.checked);
});
$('#send_sms').click(function () {
    $("#sms").toggle(this.checked);
});


jQuery('body').on('click','a#modal1[data-toggle="modal"]',function(e){
	 var action = '<?php echo site_url('alerts/add');?>'
	 jQuery.ajax({
	  url : action,
	  type: "GET",
	  success: function(response) {
	   jQuery('.modal-content').html(response);	
	   jQuery("div#myModal>div.modal-header>h3#myModalLabel").html('Add Alert');			   
	  }
	 });
	 e.preventDefault();
});

jQuery('body').on('click','a#modal2[data-toggle="modal"]',function(e){
	 var agentId	=	jQuery(this).attr('agentId');
	 var action = '<?php echo site_url('alerts/edit');?>'+"/"+agentId;
	 jQuery.ajax({
	  url : action,
	  type: "GET",
	  success: function(response) {
	   jQuery('.modal-content').html(response);
	   jQuery("div#myModal>div.modal-header>h3#myModalLabel").html('Update Alert');
	  }
	 });
	 e.preventDefault();
});


//confirm box for enable and disable agent
jQuery(".confirm").confirm({
	text: "Are you sure you want to perform this action?",
	title: "Confirmation required",
	confirm: function( urlAndid)
	{
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
			
		 jQuery.ajax({
		  url : url,
		  type: "GET",
		  success: function(response)
		  {		  
				if(actionPerformed=='disable')
				{
					var action = '<?php echo site_url("alerts/delete/");?>'+"/"+currentId+"/enable";							
					jQuery('#'+id).attr('href',action);
					jQuery('#'+id).html('<span class="glyphicon glyphicon-ok"></span>');
					jQuery('#'+id).css('color','green');									
					jQuery('#'+id).attr('id','enable__'+currentId);
					
				}else if(actionPerformed=='enable')
				{				
					var action = '<?php echo site_url("alerts/delete/");?>'+"/"+currentId+"/disable";
					
					jQuery('#'+id).attr('href',action);
					jQuery('#'+id).html('<span class="glyphicon glyphicon-remove"></span>');							
					jQuery('#'+id).css('color','red');		
					jQuery('#'+id).attr('id','disable__'+currentId);
				}
				window.location="alerts";	
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
