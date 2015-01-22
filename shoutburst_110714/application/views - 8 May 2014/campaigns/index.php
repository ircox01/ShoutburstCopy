<div id="container"> <?php echo heading('Campaigns', 3);?>
	
	<table>
		<tr>
        	<td><?php echo anchor("campaigns/add","Add New")?></td>
        </tr>
	</table>
    
    <?php if ( !empty($campaigns) ){ ?>
    <div id="dt_example">
		<div id="container">
			
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
                <tr>
                    <th>campaigns name</th>                    
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            	<?php foreach ($campaigns as $key){ ?>
            	 <tr class="odd_gradeX">
                    <td><?php echo $key->camp_name;?></td>
                    <td align="center"><?php echo anchor("campaigns/edit/".$key->camp_id,"Edit")?></td>                    
                </tr>
                <?php }?>
            </tbody>
            </table>
            
		</div>
	</div>
	<?php }else{ ?>
	<code>No campaigns exists.</code>
	<?php }?>	
</div>