<h2>Recovery Password</h2>
<?php
if (empty($_GET['id'])) {
	echo 'Please enter your registered email address';
	echo $this->Form->create('User');
	echo $this->Form->input('email');
	echo $this->Form->end('Send');
} else {
	echo 'please enter a new password!';
	echo $this->Form->create('User');
	echo $this->Form->input('password');
	echo $this->Form->end('update');
}
