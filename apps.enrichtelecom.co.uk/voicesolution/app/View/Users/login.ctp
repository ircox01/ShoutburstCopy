<div>
	<h1 style="color:#000;">		
		<span  style="color:#000;">
			Login
		</span>
	</h1>
	<div class="well">
		<?php echo $this->Session->flash('auth'); ?>
	   <fieldset>                                
		<?php

			echo $this->Form->create('User', array(
				'action' => 'login',
				'inputDefaults'=>array(
					'div'=>array('class'=>'form-group'),
					'class'=>'form-control placeholder'
				),
				'id' => 'LoginForm'));
			echo $this->Form->input('username', array(
				'label' => __d('username', 'Username')));
			echo $this->Form->input('password',  array(
				'label' => __d('users', 'Password')));
			?>
			<div class="checkbox">
				<label>
					<?php echo $this->Form->input('remember_me', array('type' => 'checkbox', 'label' =>false,'div'=>false,'class'=>false));?>
					Remember me
				</label>
			</div>
			<button class="btn btn-primary col-lg-12 btn-large" type="submit">Sign In<i class="icon-signin"></i></button>
			<?php

			//echo $this->Form->hidden('User.return_to', array(
			//    'value' => $return_to));                                    
			echo $this->Form->end(null);
		?>
		<?php echo $this->Html->link(__d('users', 'Forgot your password?'), array('action' => 'reset_password'),array('class'=>'btn btn-link'));?>                               
	</div>
	
	<div class="col-lg-4">&nbsp;</div><!-- spacer -->
</div>
