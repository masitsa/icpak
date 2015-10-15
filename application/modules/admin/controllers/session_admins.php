<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Session_admins extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('event_model');
		$this->load->model('event_session_model');
		$this->load->model('users_model');
		$this->load->model('session_admins_model');
	}
    
	/*
	*
	*	Default action is to show all the event
	*
	*/
	public function index() 
	{
		$where = 'event_session.event_session_id = session_admin.event_session_id AND users.user_id = session_admin.admin_id';
		$table = 'session_admin,event_session,users';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-session-admin';
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
		$query = $this->session_admins_model->get_all_session_admins($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['event_session'] = $query;

			$v_data['page'] = $page;
			$data['content'] = $this->load->view('event/all_session_admins', $v_data, true);
		}
		
		else
		{
			$data['content'] = ' <a href="'.base_url().'add-session-admin" class="btn btn-success pull-right">Add session admin</a> <br/>There are no session admins';
		}
		$data['title'] = 'All event session';
		
		$this->load->view('templates/general_admin', $data);
	}
    
    public function add_session_admin()
    {
    	//form validation rules
		$this->form_validation->set_rules('event_session_id', 'Session Name', 'required|xss_clean');
		$this->form_validation->set_rules('admin_id', 'Admin Name', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->session_admins_model->add_session_admin())
			{
				redirect('all-session-admin');
			}
			
			else
			{
				$data['error'] = 'Unable to add event. Please try again';
			}
		}
		
		//open the add new user page
		$data['title'] = 'Add New event session';
		$v_data['event_query'] = $this->event_session_model->get_active_sessions();
		$v_data['admin_query'] = $this->users_model->get_active_admins();
		$data['content'] = $this->load->view('event/add_session_admin', $v_data, TRUE);
		$this->load->view('templates/general_admin', $data);
	}
    
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
		
		redirect('all-session-admin');
	}
    
	
}
?>