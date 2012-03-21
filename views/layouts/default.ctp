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
			echo $this->Html->script(array('jquery.min', 'bootstrap.min', 'cakebootstrap'));
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
	        </div>
	      </div>
	    </div>
	  </div>
	  <div class="container">
			<?php if($this->Session->flash()): ?>
	      <div class="alert alert-success">
	        <a class="close" data-dismiss="alert">×</a>
	        <?php echo $this->Session->flash(); ?>
	      </div>
			<?php endif; ?>
			<?php echo $content_for_layout; ?>
	  </div>
	</body>
</html>