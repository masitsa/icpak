<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Event extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('event_model');
		$this->load->model('users_model');
	}
    
	/*
	*
	*	Default action is to show all the event
	*
	*/
	public function index() 
	{
		$where = 'event_id > 0';
		$table = 'icpak_event';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-event';
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
		$query = $this->event_model->get_all_event($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['event'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('event/all_event', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'add-event" class="btn btn-success pull-right">Add event</a> There are no events';
		}
		$data['title'] = 'All events';
		
		$this->load->view('templates/general_admin', $data);
	}
    
    public function add_event()
    {
    	//form validation rules
		$this->form_validation->set_rules('event_name', 'Event Name', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->event_model->add_event())
			{
				redirect('all-events');
			}
			
			else
			{
				$data['error'] = 'Unable to add event. Please try again';
			}
		}
		
		//open the add new user page
		$data['title'] = 'Add New event';
		$data['content'] = $this->load->view('event/add_event', '', TRUE);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing user page
	*	@param int $user_id
	*
	*/
	public function edit_event($event_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('event_name', 'Event Name', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->event_model->edit_user($event_id))
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
		$data['title'] = 'Edit Event';
		
		//select the user from the database
		$query = $this->event_model->get_event($event_id);
		if ($query->num_rows() > 0)
		{
			$v_data['event'] = $query->result();
			$data['content'] = $this->load->view('event/edit_event', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'user does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
	/*
	*
	*	Delete an existing event page
	*	@param int $event_id
	*
	*/
	public function delete_event($event_id) 
	{
		if($this->event_model->delete_event($event_id))
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
	public function activate_event($event_id) 
	{
		if($this->event_model->activate_event($event_id))
		{
			$this->session->set_userdata('success_message', 'event has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'event could not be activated');
		}
		
		redirect('all-event');
	}
    
	/*
	*
	*	Deactivate an existing event page
	*	@param int $event_id
	*
	*/
	public function deactivate_event($event_id) 
	{
		if($this->event_model->deactivate_event($event_id))
		{
			$this->session->set_userdata('success_message', 'event has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'event could not be disabled');
		}
		
		redirect('all-event');
	}
	
}
?>