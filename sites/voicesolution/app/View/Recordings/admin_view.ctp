<div class="recordings view">
<h2><?php echo __('Recording'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($recording['Recording']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($recording['Recording']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Routing Plan'); ?></dt>
		<dd>
			<?php echo h($recording['Recording']['routing_plan']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cli'); ?></dt>
		<dd>
			<?php echo h($recording['Recording']['cli']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recording['Company']['name'], array('controller' => 'companies', 'action' => 'view', $recording['Company']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Created'); ?></dt>
		<dd>
			<?php echo h($recording['Recording']['date_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($recording['Recording']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Recording'), array('action' => 'edit', $recording['Recording']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Recording'), array('action' => 'delete', $recording['Recording']['id']), null, __('Are you sure you want to delete # %s?', $recording['Recording']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Recordings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recording'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
	</ul>
</div>
