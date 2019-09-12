<h2>Recovery Password</h2>
<?php
	echo 'Please enter your registered email address';
	echo $this->Form->create('User');
	echo $this->Form->input('email');
	echo $this->Form->end('Send');
?>

