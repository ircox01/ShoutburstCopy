<div class="users form index">
	<!--?php echo $this->Session->flash('auth'); ?-->
	<h2> Member's Login </h2>
	<fieldset>
		<?php
			echo $this->Form->create('User', array(
				'action' => 'login',
				'id' => 'LoginForm'));
			echo $this->Form->input('username', array(
				'label' => __d('users', 'Username')));
			echo $this->Form->input('password',  array(
				'label' => __d('users', 'Password')));

			echo '<p>' . $this->Form->input('remember_me', array('type' => 'checkbox', 'label' =>  __d('users', 'Remember Me'))) . '</p>';
			echo '<p>' . $this->Html->link(__d('users', 'I forgot my password'), array('action' => 'reset_password')) . '</p>';

			echo $this->Form->end(__d('users', 'Login'));
		?>
	</fieldset>
</div>
