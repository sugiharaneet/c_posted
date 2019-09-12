<?php
echo $this->Form->create('User', array('type' => 'file'));
echo $this->Form->input('filename', array('type' => 'file', 'label' => 'Image'));
echo $this->Form->input('comment', array('type' => 'text', 'rows' => '8'));
echo $this->Form->end('Save');
?>
