<?php 
	echo $form->create('User', array('action' => 'resend_activation'));
	echo $form->input('email', array('type' => 'text'));
	echo $form->end('Resend Activation');
?>