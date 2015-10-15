<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Queries extends MX_Controller {
	
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
		
		$this->load->model('queries_model');
		$this->load->model('login_model');
		$this->load->model('email_model');
		
		$this->load->library('Mandrill', $this->config->item('mandrill_key'));
	}
    
	
	
	public function post_technical_query()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('query_subject', 'Subject', 'trim|required|xss_clean');
		$this->form_validation->set_rules('query_text', 'Query Details', 'trim|required|xss_clean');
		$this->form_validation->set_rules('member_id', 'Member ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('member_email', 'Member email', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->queries_model->post_technical_query())
			{
				
					$response['message'] = 'success';
					$response['result'] = 'You have successfully submited your question. The response shall be sent to the registered email';
				
			}
			
			else
			{
					$response['message'] = 'fail';
					$response['result'] = 'Unable to create account. Please try again';
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$response['message'] = 'fail';
			 	$response['result'] = $validation_errors;
			}
			
			//populate form data on initial load of page
			else
			{
				$response['message'] = 'fail';
				$response['result'] = 'Ensure that you have entered all the values in the form provided';
			}
		}
		echo json_encode($response);
	}

	public function post_standards_query()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('standard_query_subject', 'Subject', 'trim|required|xss_clean');
		$this->form_validation->set_rules('standards_query_text', 'Query Details', 'trim|required|xss_clean');
		$this->form_validation->set_rules('member_id', 'Member ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('member_email', 'Member email', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->queries_model->post_standards_query())
			{
				
					$response['message'] = 'success';
					$response['result'] = 'You have successfully submited your question. The response shall be sent to the registered email';
				
			}
			
			else
			{
					$response['message'] = 'fail';
					$response['result'] = 'Unable to create account. Please try again';
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$response['message'] = 'fail';
			 	$response['result'] = $validation_errors;
			}
			
			//populate form data on initial load of page
			else
			{
				$response['message'] = 'fail';
				$response['result'] = 'Ensure that you have entered all the values in the form provided';
			}
		}
		echo json_encode($response);
	}
	public function post_social_forum()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('member_text', 'Content', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->queries_model->post_social())
			{
				
					$response['message'] = 'success';
					$response['result'] = 'You have successfully submited your question.';
				
			}
			
			else
			{
					$response['message'] = 'fail';
					$response['result'] = 'Unable to create account. Please try again';
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$response['message'] = 'fail';
			 	$response['result'] = $validation_errors;
			}
			
			//populate form data on initial load of page
			else
			{
				$response['message'] = 'fail';
				$response['result'] = 'Ensure that you have entered all the values in the form provided';
			}
		}
		echo json_encode($response);
	}
	public function post_streaming_query()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('streaming_comment_user', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('streaming_comment_email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('streaming_comment_description', 'Question', 'trim|required|xss_clean');
		$this->form_validation->set_rules('speakers_name', 'Speakers Name', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->queries_model->post_streaming_event_query())
			{
				
					$response['message'] = 'success';
					$response['result'] = 'You have successfully submited your question.';
				
			}
			
			else
			{
					$response['message'] = 'fail';
					$response['result'] = 'Unable to create account. Please try again';
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$response['message'] = 'fail';
			 	$response['result'] = $validation_errors;
			}
			
			//populate form data on initial load of page
			else
			{
				$response['message'] = 'fail';
				$response['result'] = 'Ensure that you have entered all the values in the form provided';
			}
		}
		echo json_encode($response);
	}

	public function contact_us()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->queries_model->post_contact_us())
			{
				
					$response['message'] = 'success';
					$response['result'] = 'Thank you for contact us, we will address your issue and get back to you shortly.';
				
			}
			
			else
			{
					$response['message'] = 'fail';
					$response['result'] = 'Unable to create account. Please try again';
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$response['message'] = 'fail';
			 	$response['result'] = $validation_errors;
			}
			
			//populate form data on initial load of page
			else
			{
				$response['message'] = 'fail';
				$response['result'] = 'Ensure that you have entered all the values in the form provided';
			}
		}
		echo json_encode($response);

	}
	public function get_latest_social()
	{
		$social_forum = $this->queries_model->get_latest_social_forum();
		
		$v_data['social_forum'] = $social_forum;

		$response['message'] = 'success';
		$response['result'] = $this->load->view('icpak_social', $v_data, true);

		
		echo json_encode($response);
	}

	public function get_question_answer_form()
	{
		$active_sessions = $this->queries_model->get_active_session();
		
		$v_data['active_sessions'] = $active_sessions;


		$response['message'] = 'success';
		$response['result'] = $this->load->view('session_question', $v_data, true);

		
		echo json_encode($response);
	}
	public function post_session_question()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('member_name', 'Member Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('session_question', 'Session question', 'trim|required|xss_clean');
		$this->form_validation->set_rules('member_email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('session_code', 'Session Code', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->queries_model->post_session_question())
			{
				
					$response['message'] = 'success';
					$response['result'] = 'Thank you for asking your question.';
				
			}
			
			else
			{
					$response['message'] = 'fail';
					$response['result'] = 'Unable to create account. Please try again';
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$response['message'] = 'fail';
			 	$response['result'] = $validation_errors;
			}
			
			//populate form data on initial load of page
			else
			{
				$response['message'] = 'fail';
				$response['result'] = 'Ensure that you have entered all the values in the form provided';
			}
		}
		echo json_encode($response);

	}

	public function post_feedback()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|xss_clean');
		$this->form_validation->set_rules('feedback', 'feedback', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->queries_model->post_feedback())
			{
				
					$response['message'] = 'success';
					$response['result'] = 'Thank you for giving your feedback.';
				
			}
			
			else
			{
					$response['message'] = 'fail';
					$response['result'] = 'Unable to send feedback. Please try again';
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				$response['message'] = 'fail';
			 	$response['result'] = $validation_errors;
			}
			
			//populate form data on initial load of page
			else
			{
				$response['message'] = 'fail';
				$response['result'] = 'Ensure that you have entered all the values in the form provided';
			}
		}
		echo json_encode($response);
	}
	public function get_session_questions()
	{
		$active_sessions = $this->queries_model->get_active_session();
		
		$v_data['active_sessions'] = $active_sessions;

		$response['message'] = 'success';
		$response['result'] = $this->load->view('visible_question', $v_data, true);

		
		echo json_encode($response);
	}

	
}