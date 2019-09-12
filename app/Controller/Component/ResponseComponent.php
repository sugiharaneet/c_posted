<?php
class ResponseComponent extends Component {
	public function getReturn() {
		return $this->redirect(array('action' => 'login', 'controller' => 'users'));
	}
}
