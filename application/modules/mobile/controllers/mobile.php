<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Mobile extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('admin/users_model');
		$this->load->model('mobile_model');
		
		//path to image directory
	}

	public function login($user_name,$password)
	{


		$data['result']= $this->load->view('mobile/login', '', true);
		echo  json_encode($data);
	}
    
}