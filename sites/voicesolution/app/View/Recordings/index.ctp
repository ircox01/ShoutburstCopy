<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Recording Emails'), array('controller' => 'recordingemails','action' => 'index'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('New Recording Email'), array('controller' => 'recordingemails','action' => 'add'), array('class' => 'btn btn-default')); ?></li>
		<!--li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recording'), array('action' => 'add'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li-->
		
	</ul>
</div>

<div class="col-lg-10">
	<h2><?php echo __('Recordings'); ?></h2>
	<div class="table-responsive">
		<table class="table">
			<tr>
	
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('routing_plan'); ?></th>
					<th><?php echo $this->Paginator->sort('cli'); ?></th>					
					<th><?php echo $this->Paginator->sort('date_created'); ?></th>					
			</tr>
			<?php foreach ($recordings as $recording): ?>
			<tr>
				<td><?php echo h($recording['Recording']['id']); ?>&nbsp;</td>
				<td><?php echo h($recording['Recording']['name']); ?>&nbsp;</td>
				<td><?php echo h($recording['Recording']['routing_plan']); ?>&nbsp;</td>
				<td><?php echo h($recording['Recording']['cli']); ?>&nbsp;</td>				
				<td><?php echo h($recording['Recording']['date_created']); ?>&nbsp;</td>
				
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
</div>
