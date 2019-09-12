<div class = "users form">
	<?php echo $this->Flash->render('auth'); ?>
	<?php echo $this->Form->create('User'); ?>
		<fieldset>
			<legend>
				<?php echo __('Please enter your username and password'); ?>
			</legend>
			<?php
				echo $this->Form->input('username');
				echo $this->Form->input('password');
			?>
		</fieldset>
	<?php
		echo $this->Form->end(__('login'));
		echo $this->Html->link(
			'I forgot my password',
			array('action' => 'recover'));
	?>
</div>
