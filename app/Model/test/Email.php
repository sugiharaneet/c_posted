<?php
App::uses('AppModel', 'Model');

class Email extends AppModel {
	public $useTable = 'false';
	public $name = 'Email';

	public $_schema = array(
		'email' => array(
			'type' => 'string',
			'length' => 255
		)
	);

	public $validate = array(
		'email' => array(
			'rule' => array('email'),
			'message' => '正しいメールアドレスを入力してください',
#			'allowEmpty'=> false,
#			'required' => true,
		));
}
