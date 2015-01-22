


<!-- Modal -->
<div id="myModal" class="modal sb fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">      
	  <div class="modal-body">
	  	<p>Please Wait...</p>
	  </div>
    </div>
  </div>
</div>
<!--// Modal -->
<div id="content">
  <div class="container">
    <div class="row content-header">
		<a href="#myModal" id='modal1' class="sb-btn btn-primary" role="button" data-toggle="modal">Add New User</a>
<a href="#" class="main-nav-toggle"></a><?php echo heading('&nbsp;&nbsp;&nbsp;&nbsp;'.'Users', 1);?>
		<?php echo $this->session->flashdata('message');?>
	</div>


	<div id="message" class="deleted" style="display:none;">User Deleted successfully.</div>


    <div class="row content-body">
      <div class="col-md-12">
        <table class="table table-striped table-bordered dataTable" id="usersDatatable">
          <thead>
            <tr>
            <th style="display: none;">ID</th>
              <th>User name</th>
              <th>PIN</th>
              <th>Username</th>
              <th>Email</th>
              <th>Virtual Team Tags</th>
              <th>Actual Team Tags</th>
              
              <th>Access Level</th>
              <th>Action</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $key){ ?>
            <tr class="<?php echo $key->user_id;  ?>">
              <td style="display: none;"><?php echo $key->user_id;?></td>
              <td><?php echo $key->full_name;?></td>
              <td><?php echo $key->user_pin;?></td>
              <td><?php echo $key->user_name;?></td>
              <td><?php echo $key->email;?></td>
              <td><?=$tagmap[$key->user_id]?> </td>
              <td><?=$actualtagmap[$key->user_id]?> </td>
              
              <td><?php if($key->acc_id==COMP_MANAGER.",".COMP_AGENT){echo 'Admin/Manager/Agent';} else {if($key->acc_id == COMP_MANAGER) echo 'Manager';else if($key->acc_id == COMP_ADMIN) echo "Admin"; else echo 'Agent';}?></td>
				<td align="center">
				<!-- <a href="#myModal" id="modal2" class="edit" role="button" agentId='<?php #echo $key->user_id;?>' data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a> -->
				<a href="#myModal" id="modal2" role="button" agentId='<?php echo $key->user_id;?>' data-toggle="modal"><span class="glyphicon black glyphicon-pencil"></span></a>
				|
				<?php 
            	if($key->status==1){
						echo anchor("users/delete/".$key->user_id."/disable",'<span class="glyphicon red glyphicon-remove"></span>', array('class' => 'confirm','style'=>'','id'=>"disable__".$key->user_id));
					}else{
						echo anchor("users/delete/".$key->user_id."/enable",'<span class="glyphicon green glyphicon-ok"></span>', array('class' => 'confirm','style'=>'','id'=>"enable__".$key->user_id));
					}
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
<script>
		jQuery('body').on('click','a#modal2[data-toggle="modal"]',function(e){
			 var agentId	=	jQuery(this).attr('agentId');
			 var action = '<?php echo site_url('users/edit');?>'+"/"+agentId;
			 jQuery.ajax({
			  url : action,
			  type: "GET",
			  success: function(response) {
			   jQuery('.modal-content').html(response);
			   jQuery("div#myModal>div.modal-header>h3#myModalLabel").html('User Update');
			  }
			 });
			 e.preventDefault();
		});
		
		//edit modal
		jQuery('body').on('click','a#modal1[data-toggle="modal"]',function(e){
			 var action = '<?php echo site_url('users/add');?>'
			 jQuery.ajax({
			  url : action,
			  type: "GET",
			  success: function(response) {
			   jQuery('.modal-content').html(response);	
			   jQuery("div#myModal>div.modal-header>h3#myModalLabel").html('Add User');			   
			  }
			 });
			 e.preventDefault();
		});
		
		jQuery('#myModal').on('hide', function() {
				jQuery('.modal-content').html('Please Wait...');
				jQuery("div#myModal>div.modal-header>h3#myModalLabel").html('');	
			}).on('hidden', function(){
				jQuery('.modal-content').html('Please Wait...');
				jQuery("div#myModal>div.modal-header>h3#myModalLabel").html('');
			});
			
		//confirm box for enable and disable agent
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
					
				 jQuery.ajax({
				  url : url,
				  type: "GET",
				  success: function(response) {
				  
						if(actionPerformed=='disable'){
							/*var action = '<?php echo site_url("users/delete/");?>'+"/"+currentId+"/enable";							
							jQuery('#'+id).attr('href',action);
							jQuery('#'+id).html('<span class="glyphicon glyphicon-ok"></span>');
							jQuery('#'+id).css('color','green');									
							jQuery('#'+id).attr('id','enable__'+currentId);*/
							$("."+currentId).hide();
							$(".deleted").show();
							
						}else if(actionPerformed=='enable'){
						
							var action = '<?php echo site_url("users/delete/");?>'+"/"+currentId+"/disable";
							
							jQuery('#'+id).attr('href',action);
							jQuery('#'+id).html('<span class="glyphicon glyphicon-remove"></span>');							
							jQuery('#'+id).css('color','red');		
							jQuery('#'+id).attr('id','disable__'+currentId);
						}
						
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
