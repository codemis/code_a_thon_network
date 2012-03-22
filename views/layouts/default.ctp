<!DOCTYPE html>
<html>
	<head>
		<title><?php __('Code-A-Thon Network :: '); ?>
		<?php echo $title_for_layout; ?></title>
		<!--[if lt IE 9]>
	    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
	  <![endif]-->
		<?php
			echo $this->Html->css(array('bootstrap.min','application'));
			echo $this->Html->script(array('jquery.min', 'bootstrap.min', 'cakebootstrap', 'application'));
			echo $scripts_for_layout;
		?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
	    <div class="navbar-inner">
	      <div class="container">
	        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </a>
	        <a class="brand" href="#">Code-A-Thon Network</a>
	        <div class="nav-collapse">
	          <ul class="nav">
	            <li><?php echo $this->Html->link('Home', '/'); ?></li>
	          </ul>
						<ul class="nav pull-right">
							<?php if($session->read('Auth.User.id')): ?>
								<li><?php echo $this->Html->link("Welcome ".$session->read('Auth.User.username'), array('controller' => 'users', 'action' => 'my_account', 'admin' => false)); ?></li>
								<li><?php echo $this->Html->link('Sign Out', array('controller' => 'users', 'action' => 'sign_out', 'admin' => false)); ?></li>
							<?php else: ?>
								<li><div><?php echo $this->Html->link('Join the Network', array('controller' => 'users', 'action' => 'join', 'admin' => false), array('class' => 'btn btn-primary')); ?></div></li>
							<?php endif; ?>
						</ul>
	        </div>
	      </div>
	    </div>
	  </div>
	  <div class="container">
			<div class="row-fluid">
				<div class="span3"><?php echo $this->element('../users/_sidebar_sign_in'); ?></div>
				<div class="span9">
					<?php echo $this->Session->flash(); ?>
					<?php echo $content_for_layout; ?>
				</div>
			</div>
		</div>
	</body>
</html>