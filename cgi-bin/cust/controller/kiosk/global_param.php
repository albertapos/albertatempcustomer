<?php
class ControllerKioskGlobalParam extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('kiosk/global_param');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/global_param');

		$this->getList();
	}

	public function add() {
		$this->load->language('kiosk/global_param');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/global_param');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_global_param->addGlobalParams($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('kiosk/global_param', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() { 
		$this->load->language('kiosk/global_param');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/global_param');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_global_param->editGlobalParams($this->request->get['UId'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('kiosk/global_param', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('kiosk/global_param');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/global_param');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $UId) {
				$this->model_kiosk_global_param->deleteGlobalParams($UId);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('kiosk/global_param', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'UId';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('kiosk/global_param', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('kiosk/global_param/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('kiosk/global_param/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['globals'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$gloabal_total = $this->model_kiosk_global_param->getTotalGlobalParams();

		$results = $this->model_kiosk_global_param->getGlobalParams($filter_data);

		foreach ($results as $result) {
			
			$data['globals'][] = array(
				'UId' => $result['UId'],
				'ParameterName'        => $result['ParameterName'],
				'ParameterValue'  => $result['ParameterValue'],
				'edit'        => $this->url->link('kiosk/global_param/edit', 'token=' . $this->session->data['token'] . '&UId=' . $result['UId'] . $url, true),
				'delete'      => $this->url->link('kiosk/global_param/delete', 'token=' . $this->session->data['token'] . '&UId=' . $result['UId'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_parametername'] = $this->language->get('column_parametername');
		$data['column_parametervalue'] = $this->language->get('column_parametervalue');
		$data['column_action'] = $this->language->get('column_action');
		
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $gloabal_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('kiosk/global_param', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($gloabal_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($gloabal_total - $this->config->get('config_limit_admin'))) ? $gloabal_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $gloabal_total, ceil($gloabal_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/global_param_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['UId']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');
		
		$data['entry_parametervalue'] = $this->language->get('entry_parametervalue');
		$data['entry_parametername'] = $this->language->get('entry_parametername');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['paramname'])) {
			$data['error_parametername'] = $this->error['paramname'];
		} else {
			$data['error_parametername'] = '';
		}

		if (isset($this->error['paramvalue'])) {
			$data['error_parametervalue'] = $this->error['paramvalue'];
		} else {
			$data['error_parametervalue'] = '';
		}

		if (isset($this->error['page'])) {
			$data['error_page'] = $this->error['page'];
		} else {
			$data['error_page'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('kiosk/global_param', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['UId'])) {
			$data['action'] = $this->url->link('kiosk/global_param/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('kiosk/global_param/edit', 'token=' . $this->session->data['token'] . '&UId=' . $this->request->get['UId'] . $url, true);
		}

		$data['cancel'] = $this->url->link('kiosk/global_param', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['UId']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$global_param_info = $this->model_kiosk_global_param->getGlobalParam($this->request->get['UId']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['UId'])) {
			$data['UId'] = $this->request->post['UId'];
		} elseif (!empty($global_param_info)) {
			$data['UId'] = $global_param_info['UId'];
		} else {
			$data['UId'] = '';
		}
		
		if (isset($this->request->post['ParameterName'])) {
			$data['ParameterName'] = $this->request->post['ParameterName'];
		} elseif (!empty($global_param_info)) {
			$data['ParameterName'] = $global_param_info['ParameterName'];
		} else {
			$data['ParameterName'] = '';
		}

		if (isset($this->request->post['ParameterValue'])) {
			$data['ParameterValue'] = $this->request->post['ParameterValue'];
		} elseif (!empty($global_param_info)) {
			$data['ParameterValue'] = $global_param_info['ParameterValue'];
		} else {
			$data['ParameterValue'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/global_param_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'kiosk/global_param')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

//		if ((utf8_strlen($this->request->post['ParameterName']) < 2) || (utf8_strlen($this->request->post['ParameterName']) > 50)) {
//			$this->error['paramname']= $this->language->get('error_parametername');
//		}
//		
//		if ((utf8_strlen($this->request->post['ParameterValue']) < 2) || (utf8_strlen($this->request->post['ParameterValue']) > 50)) {
//			$this->error['paramvalue']= $this->language->get('error_parametervalue');
//		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		
		if (!$this->user->hasPermission('modify', 'global_param')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
}
