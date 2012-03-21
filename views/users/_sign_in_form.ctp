<?php echo $this->Form->create('User', array('action' => 'sign_in', 'class' => $form_class));?>
	<?php
		echo $this->Form->input('username', array('type' => 'text'));
		echo $this->Form->input('password', array('type' => 'password'));
	?>
<?php echo $this->Form->end('Sign In');?>