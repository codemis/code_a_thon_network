<h3>Reset Password</h3>
<?php 
	echo $form->create('User', array('action' => 'reset_password'));
	echo $form->input('password_original', array('type' => 'password', 'label' => 'Password'));
	echo $form->input('password_confirmation', array('type' => 'password'));
	echo $form->input('id', array('value' => $id));
	echo $form->hidden('url',array('value' => $url));
 	echo $form->end('Reset Password');
?>