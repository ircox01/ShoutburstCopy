<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Company'), array('action' => 'add'), array('class' => 'btn btn-default')); ?></li>		
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>		
	</ul>
</div>
<div class="col-lg-10">
	<h2><?php echo __('Companies'); ?></h2>
	<div class="table-responsive">
		<table class="table">
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('status'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($companies as $company): ?>
			<tr>
				<td><?php echo h($company['Company']['id']); ?>&nbsp;</td>
				<td><?php echo h($company['Company']['name']); ?>&nbsp;</td>
				<td><?php echo h($company['Company']['status']); ?>&nbsp;</td>
				<td class="actions">
					<!--?php echo $this->Html->link(__('View'), array('action' => 'view', $company['Company']['id']), array('class' => 'btn btn-warning')); ?-->
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $company['Company']['id']), array('class' => 'btn btn-warning')); ?>
					<?php if(!$company['User']['company_id']) { 
						echo $this->Html->link(__('Add User'), array('controller'=>'users', 'action' => 'add', $company['Company']['id']), array('class' => 'btn btn-warning')); 
					} ?>
					<?php echo $this->Form->postLink(__('Deactivate'), array('action' => 'delete', $company['Company']['id']), array('class' => 'btn btn-warning'), null, __('Are you sure you want to delete # %s?', $company['Company']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<?php echo $this->element('pagination');?>
</div>