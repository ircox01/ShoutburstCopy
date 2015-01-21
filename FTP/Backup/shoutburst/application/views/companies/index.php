<div id="content">
  <div class="container">
	<div class="row content-header">
		<?php echo anchor("companies/account_setup","Add New Company", array("class"=>"sb-btn btn-primary"))?>
		<?php echo heading('Companies', 1);?>
		<?php echo $this->session->flashdata('message');?>
	</div>
	<?php if ( !empty($companies) ){ ?>
    <div class="row content-body">
		<div class="col-md-12">
		  <table class="table table-striped table-bordered dataTable" id="example">
			<thead>
				<tr>
                    <th>Company Name</th>
                    <th>Action</th>
                </tr>
			</thead>
			<tbody>
				<?php foreach ($companies as $key){ ?>
				<tr>
				  <td><?php echo $key->comp_name;?></td>
                    <td align="center">
                    	<?php echo anchor("companies/edit/".$key->comp_id,'<span class="glyphicon black glyphicon-pencil"></span>').' | '?>
                    	<?php 
							if($key->status==1){
								echo anchor("companies/delete/".$key->comp_id."/disable",'<span class="glyphicon red glyphicon-remove"></span>', array('class' => 'confirm','style'=>'','id'=>"disable__".$key->comp_id));
							}else{
								echo anchor("companies/delete/".$key->comp_id."/enable",'<span class="glyphicon green glyphicon-ok"></span>', array('class' => 'confirm','style'=>'','id'=>"enable__".$key->comp_id));
							}
						?>
                    </td>
				</tr>
            	<?php }?>
			</tbody>
          </table>
		</div>
    </div>
    <?php }else{ ?>
		<code>No company exists.</code>
	<?php }?>
  </div>
</div>

	<script>
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
							
							
							var action = '<?php echo site_url("companies/delete/");?>'+"/"+currentId+"/enable";
							
							jQuery('#'+id).attr('href',action);
							jQuery('#'+id).html('<span class="glyphicon glyphicon-ok"></span>');
							jQuery('#'+id).css('color','green');									
							jQuery('#'+id).attr('id','enable__'+currentId);
							
						}else if(actionPerformed=='enable'){
						
							var action = '<?php echo site_url("companies/delete/");?>'+"/"+currentId+"/disable";
							
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
</div>
