<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout');
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Flash->error(__('Invalid username or password, try again'));
			}
		}
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved'));
				if ($this->Auth->login()) {
					$this->redirect($this->Auth->redirect());
				}
			}
			$this->Flash->error(
				__('The user could not be saved. Please, try again.')
			);
		}
	}

	public function index($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid user'));
		}
		$user = $this->User->findById($id);
		if (!$user) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $user);
	}

	public function edit($id = null) {
		$user_data = $this->User->findById($id);
		$initial_comment = $user_data['User']['comment'];
		$initial_image = $user_data['User']['filename'];

		if ($this->request->is(array('post', 'put'))) {
			if (!empty($this->request->data['User']['filename']['name'])) {
				$extension = $this->request->data('User.filename.type');
				$check_array = array(
					1 => 'image/jpeg',
					2 => 'image/jpg',
					3 => 'image/gif',
					4 => 'image/png');
				if (!array_search($extension, $check_array)) {
					$this->Flash->error(__('Please insert an image file!'));
					return $this->redirect(array('action' => 'edit', 'controller' => 'users', $id));
				}

				$path = WWW_ROOT . 'upimg';
				$img = $this->request->data('User.filename.tmp_name');
				$date = new DateTimeImmutable();
				$date_now = $date->format('YmdHisu');
				$name = base64_encode($date_now);
				$uploadfile = $path . '/' . $name;

				if (!move_uploaded_file($img, $uploadfile)) {
					$this->Flash->error(__('Could not upload!'));
					return $this->redirect(array('action' => 'edit', 'controller' => 'users', $id));
				}
				$this->request->data['User']['filename'] = $name;
			}

			if (empty($this->request->data['User']['comment'])) {
				$this->request->data['User']['comment'] = $initial_comment;
			}
			if (isset($this->request->data['User']['filename']['error'])) {
				 $this->request->data['User']['filename'] = $initial_image;
			}

			$data = array(
				'id' => $id,
				'filename' => $this->request->data['User']['filename'],
				'comment' => $this->request->data['User']['comment']
			);

			if ($this->User->save($data)) {
				$this->Flash->success(__('Image has been updated!'));
				return $this->redirect(array('action' => 'index', 'controller' => 'users', $id));
			} else {
				$this->Flash->error(__('Could not upload!'));
			}
		} else {
			$this->request->data = $this->User->findById($id);
		}
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('edit'))) {
			$edit_id = $this->request->params['pass'][0];
			if ($edit_id === $user['id']) {
				return true;
			}
		}
		return parent::isAuthorized($user);
	}

	public function _return() {
		$this->Flash->success(__('URL for reissue has been sent!'));
		return $this->redirect(array(
			'action' => 'login', 'controller' => 'users'));
	}

	public function recover() {
		if (!empty($this->request->data['User']['email'])) {
			if (!filter_var($this->request->data['User']['email'], FILTER_VALIDATE_EMAIL)) {
				$this->Flash->error(__('Please enter your email address in the correct format!'));
				return $this->redirect(array(
					'action' => 'recover', 'controller' => 'users'));
			}
			$user = $this->User->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'User.email' => $this->request->data['User']['email'])
				));

			if ($user === true || !empty($user)) {
				$id = $user['User']['id'];
				$mail = $user['User']['email'];
				$now = time();
				$time = $now + (60 * 30);
				$rand = mt_rand(100, 9999);
				$code = base64_encode($rand);

				$data = array(
					'id' => $id,
					'pass_edit_limit' => $time,
					'pass_edit_code' => $rand
				);
				$this->User->save($data);

				$email = new CakeEmail();
				$email->transport('Mail');
				$email->from('sugi@gmail.com');
				$email->to($mail);
				$email->subject('Delivery of link for reset password');
				$messages = $email->send("Please change your password at the link destination.
					https://procir-study.site/sugihara/cakephp/cakephp-2.x/users/reset?code=$code");
				$this->set('messages', $messages);

				$this->_return();
			} else {
				$this->_return();
			}
		}
	}

	public function _invalid() {
		$this->Flash->error(__('invalid access. Please try again.'));
		return $this->redirect(array(
			'action' => 'login', 'controller' => 'users'));
	}

	public function reset() {
		if (!empty($this->request->query('code'))) {
			$get_code = base64_decode($this->request->query('code'));
			$user = $this->User->find('first', array(
				'conditions'=> array('pass_edit_code' => $get_code)));
			$now2 = time();
			if ($user['User']['pass_edit_limit'] > $now2) {
				if ($this->request->is(array('post', 'put'))) {
					$data = array(
						'id' => $user['User']['id'],
						'password' => $this->request->data['User']['password']
					);
					if ($this->User->save($data)) {
						$this->Flash->success(__('Your password has been updated!'));
						return $this->redirect(array(
							'action' => 'login', 'controller' => 'users'));
					}
				}
			} else {
				$this->_invalid();
			}
		} else {
			$this->_invalid();
		}
	}
}
