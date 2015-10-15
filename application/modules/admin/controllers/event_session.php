<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Event_session extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('event_model');
		$this->load->model('event_session_model');
		$this->load->model('users_model');
	}
    
	/*
	*
	*	Default action is to show all the event
	*
	*/
	public function index() 
	{
		$where = 'event_session_id > 0 AND icpak_event.event_id = event_session.event_id';
		$table = 'event_session,icpak_event';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-event-session';
		// $config['total_rows'] = $this->users_model->count_items($table, $where);
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
		$query = $this->event_session_model->get_all_event_session($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['event_session'] = $query;

			$v_data['page'] = $page;
			$data['content'] = $this->load->view('event/all_event_session', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'There are no events';
		}
		$data['title'] = 'All event session';
		
		$this->load->view('templates/general_admin', $data);
	}
    
    public function add_event_session()
    {
    	//form validation rules
		$this->form_validation->set_rules('event_session_name', 'Event Session Name', 'required|xss_clean');
		$this->form_validation->set_rules('event_session_code', 'Session Code', 'required|xss_clean');
		$this->form_validation->set_rules('event_id', 'Event Name', 'required|xss_clean');
		$this->form_validation->set_rules('event_session_status', 'Event Session Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->event_session_model->add_event_session())
			{
				redirect('all-events');
			}
			
			else
			{
				$data['error'] = 'Unable to add event. Please try again';
			}
		}
		
		//open the add new user page
		$data['title'] = 'Add New event session';
		$v_data['event_query'] = $this->event_model->get_active_events();
		$data['content'] = $this->load->view('event/add_event_session', $v_data, TRUE);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing user page
	*	@param int $user_id
	*
	*/
	public function edit_event_session($event_session_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('event_session_name', 'Event Session Name', 'required|xss_clean');
		$this->form_validation->set_rules('event_session_code', 'Session Code', 'required|xss_clean');
		$this->form_validation->set_rules('event_id', 'Event Name', 'required|xss_clean');
		$this->form_validation->set_rules('event_session_status', 'Event Session Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->event_session_model->edit_event_session($event_session_id))
			{
				$this->session->set_userdata('success_message', 'Event edited successfully');
				redirect('all-events');
				
			}
			
			else
			{
				$data['error'] = 'Unable to add user. Please try again';
			}
		}
		
		//open the add new user page
		$data['title'] = 'Edit Event Session';
		
		//select the user from the database
		$query = $this->event_session_model->get_event_session($event_session_id);
		if ($query->num_rows() > 0)
		{
			$v_data['event_data'] = $query->result();
			$v_data['event_query'] = $this->event_model->get_active_events();
			$data['content'] = $this->load->view('event/edit_event_session', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'event session does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
	/*
	*
	*	Delete an existing event page
	*	@param int $event_id
	*
	*/
	public function delete_event_session($event_session_id) 
	{
		if($this->event_session_model->delete_event_session($event_session_id))
		{
			$this->session->set_userdata('success_message', 'event has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'event could not be deleted');
		}
		
		redirect('all-event');
	}
    
	/*
	*
	*	Activate an existing event page
	*	@param int $event_id
	*
	*/
	public function activate_event_session($event_session_id) 
	{
		if($this->event_session_model->activate_event_session($event_session_id))
		{
			$this->session->set_userdata('success_message', 'event has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'event could not be activated');
		}
		
		redirect('all-event-session');
	}
    
	/*
	*
	*	Deactivate an existing event page
	*	@param int $event_id
	*
	*/
	public function deactivate_event_session($event_session_id) 
	{
		if($this->event_session_model->deactivate_event_session($event_session_id))
		{
			$this->session->set_userdata('success_message', 'event has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'event could not be disabled');
		}
		
		redirect('all-event-session');
	}
	
}
?>