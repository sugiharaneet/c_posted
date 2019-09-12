<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'A username is required'
			),
			array(
				'rule' => 'isUnique',
				'message' => 'The name is already registered. Please specify not to duplicate.'
			)
		),
		'email' => array(
			array(
				'rule' => 'notBlank',
				'message' => 'A email is required'
			),
			array(
				'rule' => 'email',
				'message' => 'Please enter the correct email address'
			),
			array(
				'rule' => 'isUnique',
				'message' => 'The email is already registered. Please specify not to duplicate.'
			)
		),
		'password' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'A password is required'
			)
		)
	);

	public function isOwnedBy($post, $user) {
		return $this->field('id', array('id' => $post, 'User.id' => $user)) !== false;
	}

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']);
		}
		return true;
	}
}
