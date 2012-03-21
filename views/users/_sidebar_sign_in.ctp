<?php if($session->read('Auth.User.id')): ?>
	
<?php else: ?>
	<h3>Sign In</h3>
	<?php echo $this->element('../users/_sign_in_form', array('form_class' => 'form-vertical')); ?>
<?php endif; ?>