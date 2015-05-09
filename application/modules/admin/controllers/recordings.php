<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Recordings extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('recording_model');
		$this->load->model('users_model');
	}
    
	/*
	*
	*	Default action is to show all the recording
	*
	*/
	public function index() 
	{
		$where = 'recording_id > 0';
		$table = 'recording';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-recording';
		$config['total_rows'] = $this->recording_model->count_items($table, $where);
		$config['uri_segment'] = 2;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->recording_model->get_all_recording($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['recording'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('recording/all_recording', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'add-recording" class="btn btn-success pull-right">Add recording</a> There are no recordings';
		}
		$data['title'] = 'All recordings';
		
		$this->load->view('templates/general_admin', $data);
	}
    
    
	/*
	*
	*	Delete an existing recording page
	*	@param int $recording_id
	*
	*/
	public function delete_recording($recording_id) 
	{
		if($this->recording_model->delete_recording($recording_id))
		{
			$this->session->set_userdata('success_message', 'recording has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'recording could not be deleted');
		}
		
		redirect('all-recording');
	}
    
	/*
	*
	*	Activate an existing recording page
	*	@param int $recording_id
	*
	*/
	public function activate_recording($recording_id) 
	{
		if($this->recording_model->activate_recording($recording_id))
		{
			$this->session->set_userdata('success_message', 'recording has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'recording could not be activated');
		}
		
		redirect('all-recording');
	}
    
	/*
	*
	*	Deactivate an existing recording page
	*	@param int $recording_id
	*
	*/
	public function deactivate_recording($recording_id) 
	{
		if($this->recording_model->deactivate_recording($recording_id))
		{
			$this->session->set_userdata('success_message', 'recording has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'recording could not be disabled');
		}
		
		redirect('all-recording');
	}

	/*
	*
	*	Add a new user page
	*
	*/
	public function add_recording() 
	{
		//form validation rules
		$this->form_validation->set_rules('recording_link', 'Link', 'required|xss_clean');
		$this->form_validation->set_rules('recording_status', 'Status', 'required|xss_clean');
		$this->form_validation->set_rules('recording_title', 'Title', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if recording has valid login credentials
			if($this->recording_model->add_recording())
			{
				redirect('all-recording');
			}
			
			else
			{
				$data['error'] = 'Unable to add recording. Please try again';
			}
		}
		
		//open the add new recording page
		$data['title'] = 'Add New Recording';
		$data['content'] = $this->load->view('recording/add_recording', '', TRUE);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing recording page
	*	@param int $recording_id
	*
	*/
	public function edit_recording($recording_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('recording_link', 'Link', 'required|xss_clean');
		$this->form_validation->set_rules('recording_status', 'Status', 'required|xss_clean');
		$this->form_validation->set_rules('recording_title', 'Title', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if recording has valid login credentials
			if($this->recording_model->edit_recording($recording_id))
			{
				$this->session->set_recordingdata('success_message', 'recording edited successfully');
				$pwd_update = $this->input->post('admin_recording');
				if(!empty($pwd_update))
				{
					redirect('admin-profile/'.$recording_id);
				}
				
				else
				{
					redirect('all-recording');
				}
			}
			
			else
			{
				$data['error'] = 'Unable to add recording. Please try again';
			}
		}
		
		//open the add new recording page
		$data['title'] = 'Edit Recording';
		
		//select the recording from the database
		$query = $this->recording_model->get_recording($recording_id);
		if ($query->num_rows() > 0)
		{
			$v_data['recording'] = $query;
			$data['content'] = $this->load->view('recording/edit_recording', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'recording does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
	
}
?>