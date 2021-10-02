<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['text_footer'] = $this->language->get('text_footer');

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
		    $data['dashboard_url'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'] , true);
			$data['text_version'] = sprintf($this->language->get('text_version'), VERSION);
		} else {
		    $data['dashboard_url'] = '';
			$data['text_version'] = '';
		}
		
		return $this->load->view('common/footer', $data);
	}
}
