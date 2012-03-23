<h1>Current Users</h1>
<p>
<?php
echo $paginator->counter(array('format' => __('Page %page% of %pages%', true)));
?></p>
<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th><?php echo $paginator->sort('username');?></th>
			<th><?php echo $paginator->sort('name');?></th>
			<th><?php echo $paginator->sort('email');?></th>
			<th><?php echo $paginator->sort('Active','active');?></th>
			<th><?php echo $paginator->sort('Joined','created');?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 0;
		foreach ($users as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
			<tr<?php echo $class;?>>
				<td>
					<?php echo $user['User']['username']; ?>
				</td>
				<td>
					<?php echo $user['User']['name']; ?>
				</td>
				<td>
					<?php echo $user['User']['email']; ?>
				</td>
				<td>
					<?php echo $this->UsersView->activeState($user['User']['active']); ?>
				</td>
				<td>
					<?php echo $this->Time->niceShort($user['User']['created']); ?>
				</td>
				<td class="actions">
					<?php 
						if($session->read('Auth.User.id') != $user['User']['id']):
							if ($user['User']['active'] == 0):
								echo $html->link(__('Activate', true), array('action' => 'admin_change_state', $user['User']['id'], 1)); 
							elseif($user['User']['active'] == 1):
								echo $html->link(__('Suspend', true), array('action' => 'admin_change_state', $user['User']['id'], 2)); 
							elseif($user['User']['active'] == 2):
								echo $html->link(__('Reactivate', true), array('action' => 'admin_change_state', $user['User']['id'], 1)); 
							endif;
						endif;
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<div class="paging">
	<?php echo $paginator->prev('&laquo; '.__('previous', true), array('escape' => false), null, array('class'=>'disabled', 'escape' => false));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' &raquo;', array('escape' => false), null, array('class'=>'disabled', 'escape' => false));?>
</div>