<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['text_footer'] = $this->language->get('text_footer');

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$data['text_version'] = sprintf($this->language->get('text_version'), VERSION);
		} else {
			$data['text_version'] = '';
		}
		if(isset($this->session->data['token'])){
			$data['dashboard_url'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'] , true);
			$data['alberta_listing'] = $this->url->link('albertatest/alberta_listing', 'token=' . $this->session->data['token'] , true);
		}else{
			$data['dashboard_url'] = '';
			$data['alberta_listing'] = '';
		}
		
		return $this->load->view('common/footer', $data);
	}
}
