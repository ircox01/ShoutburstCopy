<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Emails'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('List Recordings'), array('controller' => 'recordings', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>		
	</ul>
</div>
<div class="col-lg-10">
<?php echo $this->Form->create('Recording'); ?>
	<fieldset>
		<legend><?php echo __('Add Recording'); ?></legend>
	<?php
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

