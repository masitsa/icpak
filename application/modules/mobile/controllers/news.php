<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MX_Controller {
	
	function __construct()
	{
		parent:: __construct();
		
		// Allow from any origin
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}
	
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
			exit(0);
		}
		
		$this->load->model('news_model');
		$this->load->model('email_model');
	}
    
	/*
	*
	*	Default action is to go to the home page
	*
	*/
	public function get_icpak_news() 
	{
		$query = $this->news_model->get_news();
		$econnect_query = $this->news_model->get_ecconect_news();
		
		$v_data['query'] = $query;
		$v_data['econnect_query'] = $econnect_query;

		$response['message'] = 'success';
		$response['result'] = $this->load->view('icpak_news', $v_data, true);

		
		echo json_encode($response);
	}
	
	public function get_news_detail($id)
	{
		$query = $this->news_model->get_news_detail($id);
		
		$v_data['query'] = $query;
		$v_data['id'] = $id;
		$response['message'] = 'success';
		$response['result'] = $this->load->view('news_detail', $v_data, true);

		
		echo json_encode($response);

	}
	
	
}