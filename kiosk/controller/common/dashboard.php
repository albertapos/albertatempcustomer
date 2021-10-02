<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');
        $this->load->model('kiosk/stores');
        
        if($this->request->server['REQUEST_METHOD'] == 'POST'){
			$userid = $this->session->data['user_id'];
			$storeid = $this->request->post['change_store_id'];
			$this->user->change_store($storeid);
			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
		}
        
        $data['user_stores'] = array();
        if($this->session->data['user_id'])
        {
            $getStoresByUser = $this->model_kiosk_stores->getStoresByUser($this->session->data['user_id']);
            $data['user_stores'] = $getStoresByUser;
            $this->session->data['user_stores'] = $getStoresByUser;
            if($this->session->data['SID'] == "" && count($getStoresByUser) > 0)
            {
                $this->session->data['SID'] = $getStoresByUser[0]['id'];
                $storeid = $getStoresByUser[0]['id'];
			    $this->user->change_store($storeid);
                $this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
            }
            
        }
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_map'] = $this->language->get('text_map');
		$data['text_activity'] = $this->language->get('text_activity');
		$data['text_recent'] = $this->language->get('text_recent');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}

		$data['token'] = $this->session->data['token'];


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		//$data['order'] = $this->load->controller('dashboard/order');
		//$data['sale'] = $this->load->controller('dashboard/sale');
		//$data['customer'] = $this->load->controller('dashboard/customer');
		//$data['online'] = $this->load->controller('dashboard/online');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('common/dashboard', $data));
	}

}