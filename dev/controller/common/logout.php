<?php
class ControllerCommonLogout extends Controller {
	public function index() {
		$this->user->logout();

		unset($this->session->data['token']);
		unset($this->session->data['db2']);
		unset($this->session->data['db_hostname2']);
		unset($this->session->data['db_username2']);
		unset($this->session->data['db_password2']);
		unset($this->session->data['db_database2']);
		unset($this->session->data['storename']);

		$this->response->redirect($this->url->link('common/login', '', true));
	}
}