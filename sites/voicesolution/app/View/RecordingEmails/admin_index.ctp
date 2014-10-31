<div class="recordingEmails index">
	<h2><?php echo __('Recording Emails'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('recording_id'); ?></th>
			<th><?php echo $this->Paginator->sort('email_adds'); ?></th>
			<th><?php echo $this->Paginator->sort('email_header'); ?></th>
			<th><?php echo $this->Paginator->sort('email_message'); ?></th>
			<th><?php echo $this->Paginator->sort('date_created'); ?></th>
			<th><?php echo $this->Paginator->sort('date_modified'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($recordingEmails as $recordingEmail): ?>
	<tr>
		<td><?php echo h($recordingEmail['RecordingEmail']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($recordingEmail['Recording']['name'], array('controller' => 'recordings', 'action' => 'view', $recordingEmail['Recording']['id'])); ?>
		</td>
		<td><?php echo h($recordingEmail['RecordingEmail']['email_adds']); ?>&nbsp;</td>
		<td><?php echo h($recordingEmail['RecordingEmail']['email_header']); ?>&nbsp;</td>
		<td><?php echo h($recordingEmail['RecordingEmail']['email_message']); ?>&nbsp;</td>
		<td><?php echo h($recordingEmail['RecordingEmail']['date_created']); ?>&nbsp;</td>
		<td><?php echo h($recordingEmail['RecordingEmail']['date_modified']); ?>&nbsp;</td>
		<td><?php echo h($recordingEmail['RecordingEmail']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $recordingEmail['RecordingEmail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $recordingEmail['RecordingEmail']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $recordingEmail['RecordingEmail']['id']), null, __('Are you sure you want to delete # %s?', $recordingEmail['RecordingEmail']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Recording Email'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Recordings'), array('controller' => 'recordings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recording'), array('controller' => 'recordings', 'action' => 'add')); ?> </li>
	</ul>
</div>
