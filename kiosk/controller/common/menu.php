<?php
class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['text_system'] = $this->language->get('text_system');
		
		$data['text_kiosk'] = $this->language->get('text_kiosk');
		$data['text_menus'] = $this->language->get('text_menus');
		$data['text_menu_item'] = $this->language->get('text_menu_item');
		
		$data['text_category'] = $this->language->get('text_category');
		$data['text_pages'] = $this->language->get('text_pages');
		$data['text_page_flow'] = $this->language->get('text_page_flow');
		
		$data['text_items'] = $this->language->get('text_items');
		$data['text_gloabal_param'] = $this->language->get('text_gloabal_param');
		$data['text_table_action'] = $this->language->get('text_table_action');
		
		$data['text_user'] = $this->language->get('text_user');
		$data['text_user_group'] = $this->language->get('text_user_group');
		$data['text_users'] = $this->language->get('text_users');
		
		

		$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);		
		$data['menus'] = $this->url->link('kiosk/menus', 'token=' . $this->session->data['token'], true);
		$data['menu_item'] = $this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'], true);
		$data['category'] = $this->url->link('kiosk/category', 'token=' . $this->session->data['token'], true);		
		$data['pages'] = $this->url->link('kiosk/pages', 'token=' . $this->session->data['token'], true);
		$data['page_flow'] = $this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'], true);
		$data['items'] = $this->url->link('kiosk/items', 'token=' . $this->session->data['token'], true);
		$data['gloabal_param'] = $this->url->link('kiosk/global_param', 'token=' . $this->session->data['token'], true);
		$data['table_action'] = $this->url->link('kiosk/table_action', 'token=' . $this->session->data['token'], true);
		
		
		$data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], true);
		$data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], true);


		return $this->load->view('common/menu', $data);
	}
}
