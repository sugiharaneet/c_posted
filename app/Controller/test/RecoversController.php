<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class RecoversController extends AppController {
	public $uses = 'Email';

	public function index() {
		if (isset($this->request->data['User']['email'])) {
		       $this->Email->set($this->request->data['User']['email']);
		       if($this->Email->validates()){
				   $this->Flash->error(__('正しい形式でしろ！'));
				   return $this->redirect(array(
					   'action' => 'index', 'controller' => 'recovers'));
		       } else {
				   $this->Flash->success(__('バリデートsippai'));
		       }
		}

		#if($this->Validate->validates()){
		#       $this->Flash->error(__('バリデートseikou'));
		#} else {
		#       $this->Flash->success(__('バリデートsippai'));
		#}

		if (!empty($this->request->data['User']['email'])) {
			#$this->User->set($this->request->data);
			#if ($this->User->validates()) {
			#       $this->Flash->error(__('バリデートseikou'));
			#       return $this->redirect(array(
			#               'action' => 'recover', 'controller' => 'users'));
			#} else {
			#       $this->Flash->success(__('バリデートsippai'));
			#       return $this->redirect(array(
			#               'action' => 'recover', 'controller' => 'users'));
			#}
			$user = $this->User->find('first', array(
				'recursive' => -1,
				'conditions' => array(
						'User.email' => $this->request->data['User']['email'])
				));

			if ($user === true || !empty($user)) {
				$id = $user['User']['id'];
				$mail = $user['User']['email'];
				//有効期限をDBに挿入
				$now = time();
				$time = $now + (60 * 30);
				$data = array(
						'id' => $id,
						'pass_edit_limit' => $time
				);
				$this->User->save($data);

				$rand = mt_rand(1000, 9999);
				$mix = $id . $rand;
				$various = base64_encode($mix);

				$email = new CakeEmail();
				$email->transport('Mail');
				$email->from('isseiadgjl@gmail.com');
				$email->to($mail);
				$email->subject('Delivery of link for reset password');
				$messages = $email->send("https://procir-study.site/sugihara/cakephp/cakephp-2.x/users/recover?id=$various");
				$this->set('messages', $messages);

				$this->Flash->success(__('URL for reissue has been sent!'));
				return $this->redirect(array(
					'action' => 'login', 'controller' => 'users'));
			} else {
				$this->Flash->success(__('URL for reissue has been sent!'));
				return $this->redirect(array(
					'action' => 'login', 'controller' => 'users'));
			}
	}

	if (isset($_GET['id'])) {
			echo 'mmmmmmmm';
			$mixed = base64_decode($_GET['id']);
			$get_id = substr("$mixed", 0, -4);

			$user = $this->User->findById($get_id);
			$now2 = time();
			if ($user['User']['pass_edit_limit'] > $now2) {
				if ($this->request->is(array('post', 'put'))) {
					echo 'jjjjjj';
					$data = array(
						'id' => $get_id,
						'password' => $this->request->data['User']['password']
					);
					if ($this->User->save($data)) {
						$this->Flash->success(__('Your password has been updated!'));
						return $this->redirect(array(
							'action' => 'login', 'controller' => 'users'));
					}
				}
			} else {
					$this->Flash->error(__('You are not authorized to access that location.'));
					return $this->redirect(array(
						'action' => 'login', 'controller' => 'users'));
			}
		}
	}
}

