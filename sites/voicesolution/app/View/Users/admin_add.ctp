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
		echo $this->Form->input('company_id');		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

