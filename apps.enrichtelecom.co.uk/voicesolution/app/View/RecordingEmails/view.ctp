<div class="recordingEmails view">
<h2><?php echo __('Recording Email'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($recordingEmail['RecordingEmail']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Recording'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recordingEmail['Recording']['name'], array('controller' => 'recordings', 'action' => 'view', $recordingEmail['Recording']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email Adds'); ?></dt>
		<dd>
			<?php echo h($recordingEmail['RecordingEmail']['email_adds']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email Header'); ?></dt>
		<dd>
			<?php echo h($recordingEmail['RecordingEmail']['email_header']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email Message'); ?></dt>
		<dd>
			<?php echo h($recordingEmail['RecordingEmail']['email_message']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Created'); ?></dt>
		<dd>
			<?php echo h($recordingEmail['RecordingEmail']['date_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Modified'); ?></dt>
		<dd>
			<?php echo h($recordingEmail['RecordingEmail']['date_modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($recordingEmail['RecordingEmail']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Recording Email'), array('action' => 'edit', $recordingEmail['RecordingEmail']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Recording Email'), array('action' => 'delete', $recordingEmail['RecordingEmail']['id']), null, __('Are you sure you want to delete # %s?', $recordingEmail['RecordingEmail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Recording Emails'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recording Email'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recordings'), array('controller' => 'recordings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recording'), array('controller' => 'recordings', 'action' => 'add')); ?> </li>
	</ul>
</div>
