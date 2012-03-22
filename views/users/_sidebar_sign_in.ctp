<?php if($session->read('Auth.User.id')): ?>
	&nbsp;
<?php else: ?>
<div id="sign_in_options_wrapper">
	<div id="sign_in_form_wrapper">
		<h3>Sign In</h3>
		<?php echo $this->element('../users/_sign_in_form', array('form_class' => 'form-vertical')); ?>
		<a href="#" class="show_sign_in_option" rel="resend_activation_wrapper">Resend Activation</a> | <a href="#" class="show_sign_in_option" rel="forgot_password_wrapper">Forgot Password</a>
	</div>
	<div id="resend_activation_wrapper" class="hide">
		<h3>Resend Activation</h3>
		<?php echo $this->element('../users/_resend_activation_form', array('form_class' => 'form-vertical')); ?>
		<a href="#" class="show_sign_in_option" rel="sign_in_form_wrapper">Sign In</a>  | <a href="#" class="show_sign_in_option" rel="forgot_password_wrapper">Forgot Password</a>
	</div>
</div>
<?php endif; ?>
