<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<!--li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), array('class' => 'btn btn-default'), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li-->
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add'), array('class' => 'btn btn-default')); ?> </li>
	</ul>
</div>
<div class="col-lg-10">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('contact_number');
		//echo $this->Form->input('password');
		echo $this->Form->input('company_id');
		//echo $this->Form->input('date_created');
		//echo $this->Form->input('date_modified');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

