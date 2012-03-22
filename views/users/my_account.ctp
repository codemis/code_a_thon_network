<div class="row-fluid">
	<div class="span11">
		<h1>My Account</h1>
	</div>
	<div class="span1">
		<?php echo $this->Html->Link('Edit', array('controller' => 'users', 'action' => 'edit', $user['User']['id']), array('class' => 'btn')); ?>
	</div>
</div>
<div class="well">
	<ul>
		<li>Username: <?php echo $user['User']['username']; ?></li>
		<li>Email: <?php echo $user['User']['email']; ?></li>
		<li>Date Joined: <?php echo $this->Time->niceShort($user['User']['created']); ?></li>
	</ul>
</div>