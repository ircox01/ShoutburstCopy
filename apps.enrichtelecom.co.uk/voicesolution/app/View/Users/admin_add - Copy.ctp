<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add'), array('class' => 'btn btn-default')); ?> </li>
	</ul>
</div>
<div class="col-lg-10">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add Company User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('contact_number');
		echo $this->Form->input('password');
	?>
	<div id="_isAdmin" class="input select">	
		<label for="UserIsadmin">Role</label>
		<select id="UserIsadmin" name="data[User][is_admin]">
			<option value="1">Admin</option>
			<option value="0">Client</option>
		</select></br>
	<?php
		
		echo $this->Form->input('company_id');		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
<script>

	$('#UserCompanyId').attr('disabled',true);
	$('#_isAdmin').change(function (){
		if($('#UserIsAdmin').val() == '1') {
			$('#UserCompanyId').attr('disabled',true);
		}else {
			$('#UserCompanyId').attr('disabled',false);
		}
	});
	
</script>
