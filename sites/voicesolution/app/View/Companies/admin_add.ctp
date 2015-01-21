<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Companies'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></li>		
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add'), array('class' => 'btn btn-default')); ?> </li>
	</ul>
</div>
<div class="col-lg-10">
<?php echo $this->Form->create('Company'); ?>
	<fieldset>
		<legend><?php echo __('Add Company'); ?></legend>
	<?php
		echo $this->Form->input('name');		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

