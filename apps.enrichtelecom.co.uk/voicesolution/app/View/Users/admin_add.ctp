<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add'), array('class' => 'btn btn-default')); ?> </li>
	</ul>
</div>
<div class="col-lg-10">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add Company User'); ?></legend>
	<?php	
		echo $this->Form->input('username',array('label' => 'Call Manager Login'));
		echo $this->Form->input('password', array('label' => 'Call Manager Password'));
		//echo $this->Form->input('contact_number');
	?>
	<div id="_contactDiv" class="input text">
		<label for="UserContactNumber">Contact Number</label>
		<p>
			<input id="UserContactNumber" type="text" maxlength="250" name="data[User][contact_number][]">
		</p>
	</div>
	
	<a onclick="return false;" id="_addContant" type="button" class="btn btn-primary btn-small" ><i class="icon-plus"></i> Add contact </a>
	<input type="hidden" id="UserIsadmin" name="data[User][is_admin]" value="0" />
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

<?php
        echo $this->Html->css('jquery-ui');
		echo $this->Html->script('jquery-1.9.1');
		echo $this->Html->script('jquery-ui');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
    ?>
<script  type="text/javascript">
	 $( document ).ready(function() {
		i = $('#_contactDiv p').size() + 1;
		$('#_addContant').click(function() {
			$('<p><input id="UserContactNumber" type="text" required="required" maxlength="500" name="data[User][contact_number][]"><a type="button"  class="_rem btn btn-primary btn-small" name="id'+ i + '"onclick="return false;">Remove</a></p>').appendTo('#_contactDiv');
			i++;
			return false;
		});
		$('._rem').on('click',(function() {
			if( i > 2 ) {
				$(this).parents('p').remove();
				i--;
			}
			
		}));
	});
	
	$(document).on('click', "._rem", function () {
		if( i > 2 ) {
				$(this).parents('p').remove();
				i--;
			}
		return false;
	});
	
</script>