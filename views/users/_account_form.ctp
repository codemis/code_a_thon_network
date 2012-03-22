<?php 	
	echo $form->create('User');
	echo $form->input('username', array('type' => 'text'));
	echo $form->input('name', array('type' => 'text'));
	echo $form->input('email', array('type' => 'text'));
	echo $form->input('password_original', array('type' => 'password', 'label' => 'New Password'));
	echo $form->input('password_confirmation', array('type' => 'password', 'label' => 'Confirm Password'));
	if($change_pass == 1):
		echo $form->input('changePass', array('label'=>'Change Password','type'=>'checkbox','value'=>'1', 'div' => 'checkbox')); 
	endif;
?>
<?php echo $form->end($btn_txt); ?>