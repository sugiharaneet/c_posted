<h1>Blog posts</h1>
<h3>
	<?php
		if ($auth) {
			echo 'Welcome!! ' . $auth['username'] . ' !';
		}
	?>
</h3>
<p>
	<?php
		echo $this->Html->link(
			'Post',
			array('controller' => 'posts', 'action' => 'add')
			);
	?>
</p>
<?php
	if (!isset($auth)) {
		echo $this->Html->link(
			'Sign in',
			array('controller' => 'users', 'action' => 'add')
			);
		echo '/' . $this->Html->link(
			'Login',
			array('controller' => 'users', 'action' => 'login')
			);
	}
?>
<table>
	<tr>
		<th>Id</th>
		<th>Contributor</th>
		<th>Title</th>
		<th>Delete/Edit</th>
		<th>Created</th>
	</tr>

	<?php foreach ($posts as $post): ?>
	<tr>
		<td><?php echo $post['Post']['id']; ?></td>
		<td><?php echo $this->Html->link($post['User']['username'],
			array('controller' => 'users', 'action' => 'index', $post['Post']['user_id'])); ?></td>
		<td>
			<?php echo $this->Html->link($post['Post']['title'],
			array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?>
		</td>
		<td>
			<?php if ($post['Post']['user_id'] == $auth['id']): ?>
				<?php
					echo $this->Form->postLink(
						'Delete',
						array('action' => 'delete', $post['Post']['id']),
						array('confirm' => 'Are you sure?')
						) . '/';

					echo $this->Html->link(
						'Edit',
						array('action' => 'edit', $post['Post']['id'])
						);
				?>
			<?php endif; ?>
		</td>
		<td><?php echo $post['Post']['created']; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<p>
	<?php
		if (isset($auth)) {
			echo $this->Html->link('Logout', array('action' => 'logout', 'controller' => 'users'));
		}
	?>
</p>
