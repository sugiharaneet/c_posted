<h1>Add Post</h1>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title', array('rows' => '2'));
echo $this->Form->input('body', array('rows' => '8'));
echo $this->Form->end('Save Post');
echo $this->Html->link('Return',
	array('controller' => 'posts', 'action' => 'index')
	);
?>
