<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Recover extends AppModel {
	public $useTable = 'false';
	public $name = 'Recover';

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
			'allowEmpty'=> false,
			'required' => true,
		));
}
