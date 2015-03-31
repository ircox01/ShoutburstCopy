<div class="recordings form">
<?php echo $this->Form->create('Recording'); ?>
	<fieldset>
		<legend><?php echo __('Edit Recording'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('routing_plan');
		echo $this->Form->input('cli');
		echo $this->Form->input('company_id');
		echo $this->Form->input('date_created');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Recording.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Recording.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Recordings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
	</ul>
</div>
