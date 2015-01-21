<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Recording Email'), array('action' => 'add'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('List Recordings'), array('controller' => 'recordings', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>		
	</ul>
</div>


<div class="col-lg-10">
	<h2><?php echo __('Recording Emails'); ?></h2>
	<div class="table-responsive">
		<table class="table">
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('recording_id'); ?></th>
				<th><?php echo $this->Paginator->sort('email_adds'); ?></th>
				<th><?php echo $this->Paginator->sort('email_header'); ?></th>
				<th><?php echo $this->Paginator->sort('email_message'); ?></th>
				<th><?php echo $this->Paginator->sort('status'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($recordingEmails as $recordingEmail): ?>
				
			<tr>
				<td><?php echo h($recordingEmail['RecordingEmail']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($recordingEmail['Recording']['name'], array('controller' => 'recordings', 'action' => 'view', $recordingEmail['Recording']['id'])); ?>
				</td>
				<td>
					<div><?php $emails = json_decode($recordingEmail['RecordingEmail']['email_adds']);
						foreach($emails as $email): ?>
						<p> <?php echo h($email)  ?> </p>
						<?php endforeach; ?>
					</div>
				</td>
				<td><?php echo h($recordingEmail['RecordingEmail']['email_header']); ?>&nbsp;</td>
				<td><?php echo h($recordingEmail['RecordingEmail']['email_message']); ?>&nbsp;</td>
				<td><?php echo $recordingEmail['RecordingEmail']['status'] == 0 ? 'pending' : 'sent'; ?>&nbsp;</td>
				<td class="actions">
					<!--?php echo $this->Html->link(__('View'), array('action' => 'view', $recordingEmail['RecordingEmail']['id']), array('class' => 'btn btn-warning')); ?-->
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $recordingEmail['RecordingEmail']['id']), array('class' => 'btn btn-warning')); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $recordingEmail['RecordingEmail']['id']), array('class' => 'btn btn-warning'), null, __('Are you sure you want to delete # %s?', $recordingEmail['RecordingEmail']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<?php echo $this->element('pagination');?>
</div>

