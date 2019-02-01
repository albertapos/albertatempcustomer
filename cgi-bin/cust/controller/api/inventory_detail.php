<?php
class ControllerApiInventoryDetail extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/inventory_detail');

		if ($this->session->data['token'] == $this->request->get['token']) {

			$post = json_decode(file_get_contents("php://input"));
				
			$post = (array) $post; // cast (convert) the object to an array
			
			if($post['sid'] !='' && $post['tranid']!='')
			{					
				$data = $this->model_api_inventory_detail->getInventoryDetail($post['sid'],$post['tranid']);
				
				if(count($data) > 0)
				{
					http_response_code(200);
				}else{
					$data['error'] = 'Not Found';
					http_response_code(404);
				}
			}else{
				$data['error'] = 'Incorrect or Partial Content';
				http_response_code(206);
			}
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Unauthorized';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}
}
