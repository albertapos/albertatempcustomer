<?php
class ControllerAlbertatestAlbertaListing extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('albertatest/alberta_listing');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}
	  
	protected function getList() {

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('albertatest/alberta_listing', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['listings'] = array();

		/*$data['listings'][0]['name'] = 'Purchase Order';
		$data['listings'][0]['link'] = $this->url->link('albertatest/purchase_order', 'token=' . $this->session->data['token'] . $url, true);*/
		//$data['listings'][0]['name'] = 'Credit Card Report';
		//$data['listings'][0]['link'] = $this->url->link('albertatest/credit_card_report', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('albertatest/alberta_listing', $data));
	}
	
}
