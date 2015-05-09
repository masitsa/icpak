<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {
	
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
		
		$this->load->model('login_model');
		$this->load->model('email_model');
	}
    
	/*
	*
	*	Default action is to go to the home page
	*
	*/
	public function login_member($member_email = '', $member_password = '') 
	{
		$result = $this->login_model->validate_member($member_email, $member_password);
		
		if($result != FALSE)
		{
			//create user's login session
			$newdata = array(
                   'member_login_status'    => TRUE,
                   'member_username'     	=> $result[0]->member_username,
                   'member_email'     		=> $result[0]->member_email,
                   'member_id'  			=> $result[0]->member_id,
                   'member_code'  			=> md5($result[0]->member_id)
               );
			$this->session->set_userdata($newdata);
			
			$response['message'] = 'success';
			$response['result'] = $newdata;
		}
		
		else
		{
			$response['message'] = 'fail';
			$response['result'] = 'You have entered incorrect details. Please try again';
		}
		
		//echo $_GET['callback'].'(' . json_encode($response) . ')';
		echo json_encode($response);
	}
	
	public function dummy()
	{
		$return[0]['firstName'] = 'James';
		$return[0]['lastName'] = 'King';
		$return[1]['firstName'] = 'Eugene';
		$return[1]['lastName'] = 'Lee';
		$return[2]['firstName'] = 'Julie';
		$return[2]['lastName'] = 'Taylor';
		
		echo json_encode($return);
	}
	
	public function register_user()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('gender_id', 'Gender', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
		$this->form_validation->set_rules('company', 'Company', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[member.member_email]|required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->login_model->register_member_details())
			{
				if($this->login_model->validate_member($this->input->post('email'),$this->input->post('password')))
				{	
					$this->load->model('site/payments_model');
					//grant 100 chat credits for the first 100 users
					if($this->payments_model->first_hundred($this->session->userdata('member_id')))
					{
					}
					
					else
					{
					}
					$response['message'] = 'success';
					$response['result'] = 'You have successfully created your account. We need some info from you so that we can link you with people looking for you';
				}
				else
				{
					$data['message'] = 'fail';
					$data['result'] = 'Please sign in to access your account';
				}
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to create account. Please try again');
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$response['message'] = 'fail';
				$response['result'] = 'Ensure that you have entered all the values in the form provided';
			}
			
			//populate form data on initial load of page
			else
			{
				$response['message'] = 'fail';
			 	$response['result'] = $validation_errors;
			}
		}
		echo json_encode($response);
	}
}