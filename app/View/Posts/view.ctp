<table border="1" width="100">
	<tr>
		<td width="20%">Contributor</td>
		<td width="80%"><?php echo h($post['User']['username']); ?></td>
	</tr>
	<tr>
		<td>Title</td>
		<td><?php echo h($post['Post']['title']); ?></td>
	</tr>
	<tr>
		<td>Created</td>
		<td><?php echo $post['Post']['created']; ?></td>
	</tr>
	<tr>
		<td>Body</td>
		<td><?php echo h($post['Post']['body']); ?></td>
	</tr>
</table>
<?php echo $this->Html->link(
	'Return',
	array('controller' => 'posts', 'action' => 'index')
	);
?>
