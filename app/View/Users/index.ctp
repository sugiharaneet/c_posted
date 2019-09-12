<h1>User Page!</h1>
<table border="1" width="100">
	<tr>
		<td width="15%">username</td>
		<td><?php echo $user['User']['username']; ?></td>
	</tr>
	<tr>
		<td>image</td>
		<td>
			<?php
				if (isset($user['User']['filename'])) {
				echo $this->Html->image('/upimg/' . $user['User']['filename'],
					array('alt' => 'baz',
					'width' => '400px',
					'height' => '300px'));
				} else {
					echo '未登録';
				}
			?>
		</td>
	</tr>
	<tr>
		<td>email</td>
		<td><?php echo $user['User']['email']; ?></td>
	</tr>
	<tr>
		<td>comment</td>
		<td>
			<?php
				if (isset($user['User']['comment'])) {
					echo $user['User']['comment'];
				} else {
					echo '未登録';
				}
			?>
		</td>
	</tr>
</table>
<p>
	<?php
		echo $this->Html->link(
			'Return',
			array('controller' => 'posts', 'action' => 'index')
			);
		if ($auth['id'] == $user['User']['id']) {
			echo '/' . $this->Html->link(
				'Edit',
				array('controller' => 'users', 'action' => 'edit', $user['User']['id'])
				);
		}
	?>
</p>
