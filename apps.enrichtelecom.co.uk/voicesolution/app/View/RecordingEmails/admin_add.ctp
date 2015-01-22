<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Recording Emails'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('List Recordings'), array('controller' => 'recordings', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recording'), array('controller' => 'recordings', 'action' => 'add'), array('class' => 'btn btn-default')); ?> </li>
	</ul>
</div>
<div class="col-lg-10">
<?php echo $this->Form->create('RecordingEmail'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Recording Email'); ?></legend>
	<?php
		echo $this->Form->input('recording_id');
		echo $this->Form->input('email_adds');
		echo $this->Form->input('email_header');
		echo $this->Form->input('email_message');
		
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
