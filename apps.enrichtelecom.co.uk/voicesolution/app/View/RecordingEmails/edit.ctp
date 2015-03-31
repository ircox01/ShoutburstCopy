<div class="col-lg-2">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<!--li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('RecordingEmail.id')), array('class' => 'btn btn-default'), null, __('Are you sure you want to delete # %s?', $this->Form->value('RecordingEmail.id'))); ?></li-->
		<li><?php echo $this->Html->link(__('List Recording Emails'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->Html->link(__('List Recordings'), array('controller' => 'recordings', 'action' => 'index'), array('class' => 'btn btn-default')); ?> </li>
		<!--li><?php echo $this->Html->link(__('New Recording'), array('controller' => 'recordings', 'action' => 'add'), array('class' => 'btn btn-default')); ?> </li-->
	</ul>
</div>
<div class="col-lg-10">
<?php echo $this->Form->create('RecordingEmail'); ?>
	<fieldset>
		<legend><?php echo __('Edit Recording Email'); ?></legend>
	<?php
		echo $this->Form->input('id');
	?>
		<div class="input select">
			<label for="RecordingEmailRecordingId">Recording</label>
			<select id="RecordingEmailRecordingId" name="data[RecordingEmail][recording_id]">
			<?php foreach ($recordings as $recording): ?>
				<option value="<?php echo $recording['Recording']['id'] ?>"><?php echo $recording['Recording']['name'] ?></option>
			<?php endforeach; ?>
			</select>
		</div>
		<div  id="p_scents" class="input text required">
			<label id="_lblEmails" for="RecordingEmailEmailAdds">Email Adds</label>
			<?php $emails = json_decode($recordingEmail['RecordingEmail']['email_adds']);
				if(count($emails) > 1) { 
					foreach($emails as $email): ?>
					<p>
						<input value="<?php echo $email; ?>" id="RecordingEmailEmailAdds" type="text" required="required" maxlength="500" name="data[RecordingEmail][email_adds][]">
						<a type="button" class="_rem btn btn-primary btn-small" name="id'+ i + '"onclick="return false;">Remove</a>
					</p>
					<?php endforeach; ?>
				<?php					
				} else { ?>
					<p>
						<input id="RecordingEmailEmailAdds" type="text" required="required" maxlength="500" value="<?php echo $emails[0]; ?>" name="data[RecordingEmail][email_adds][]">			
					</p>
				<?php
				}
				?>			
		</div>
		<a onclick="return false;" id="_addContant" type="button" class="btn btn-primary btn-small" ><i class="icon-plus"></i> Add Email </a>
	<?php
		//echo $this->Form->input('recording_id');
		//echo $this->Form->input('email_adds');
		echo $this->Form->input('email_header');
		echo $this->Form->input('email_message');		
		//echo $this->Form->input('date_created');
		//echo $this->Form->input('date_modified');
		//echo $this->Form->input('status');
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

