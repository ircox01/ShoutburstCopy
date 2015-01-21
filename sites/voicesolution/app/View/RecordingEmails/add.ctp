<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Emails'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('List Recordings'), array('controller' => 'recordings', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>		
	</ul>
</div>

<div class="col-lg-10">
<?php echo $this->Form->create('RecordingEmail'); ?>
	<fieldset>
		<legend><?php echo __('Add Recording Email'); ?></legend>
	<?php
		//echo $this->Form->input('recording_id');
		//echo $this->Form->input('email_adds');
		
	?>
		<div class="input select">
			<label for="RecordingEmailRecordingId">Recording</label>
			<select id="RecordingRecordingId" name="data[RecordingEmail][recording_id]">
			<?php foreach ($recordings as $recording): ?>
				<option value="<?php echo $recording['Recording']['id'] ?>"><?php echo $recording['Recording']['name'] ?></option>
			<?php endforeach; ?>
			</select>
		</div>
		<div  id="p_scents" class="input text required">
			
			<label id="_lblEmails" for="RecordingEmailEmailAdds">Email Adds</label>
			<p>
			<input id="RecordingEmailAdds" type="text" required="required" maxlength="500" name="data[RecordingEmail][email_adds][]">			
			</p>
		</div>
		<a onclick="return false;" id="_addContant" type="button" class="btn btn-primary btn-small" ><i class="icon-plus"></i> Add Email </a>
		
	<?php
		echo $this->Form->input('email_header');
		echo $this->Form->input('email_message');				
	?>
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
		i = $('#p_scents p').size() + 1;
		$('#_addContant').click(function() {
			$('<p><input id="RecordingEmailAdds" type="text" required="required" maxlength="500" name="data[RecordingEmail][email_adds][]"><a type="button"  class="_rem btn btn-primary btn-small" name="id'+ i + '"onclick="return false;">Remove</a></p>').appendTo('#p_scents');
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
