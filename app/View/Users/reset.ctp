<h2>Recovery Password</h2>
<?php
echo 'please enter a new password!';
echo $this->Form->create('User');
echo $this->Form->input('password');
echo $this->Form->end('update');
?>
