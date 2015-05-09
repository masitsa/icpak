<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Live_streaming extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('live_streaming_model');
	}
    
	/*
	*
	*	Default action is to show all the users
	*
	*/
	public function index() 
	{



		//open the add new user page
		//form validation rules
		$this->form_validation->set_rules('event_name', 'Event Name', 'required|xss_clean');
		$this->form_validation->set_rules('event_link', 'Event link', 'required|xss_clean');
		$this->form_validation->set_rules('activated', 'Activated', 'xss_clean');
		$this->form_validation->set_rules('event_description', 'Description', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->live_streaming_model->add_event_streaming())
			{
				redirect('live-stream');
			}
			
			else
			{
				$data['error'] = 'Unable to add user. Please try again';
			}
		}

		$where = 'now_streaming.live_stream_id = streaming_comment.streaming_id AND now_streaming.streaming_status = 1';
		
		$table = 'streaming_comment, now_streaming';
		$segment = 2;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'live-stream';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
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
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $data["links"] = $this->pagination->create_links();
		$v_data['questions_query'] = $this->live_streaming_model->get_livestream_comments($table, $where, $config["per_page"], $page);

		$v_data['live_stream'] = $this->live_streaming_model->get_now_streaming_meeting();
		$v_data['page'] = $page;
		//open the add new user page
		$data['title'] = 'Streaming now';
		$data['content'] = $this->load->view('live_streaming/streaming', $v_data, TRUE);
		$this->load->view('templates/general_admin', $data);
	}
	public function add_live_stream()
	{

		//form validation rules
		$this->form_validation->set_rules('event_name', 'Event Name', 'required|xss_clean');
		$this->form_validation->set_rules('event_link', 'Event link', 'required|xss_clean');
		$this->form_validation->set_rules('activated', 'Activated', 'xss_clean');
		$this->form_validation->set_rules('event_description', 'Description', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->live_streaming_model->add_event_streaming())
			{
				redirect('all-users');
			}
			
			else
			{
				$data['error'] = 'Unable to add user. Please try again';
			}
		}
		$v_data['live_stream'] = $this->live_streaming_model->get_now_streaming_meeting();
		
		//open the add new user page
		$data['title'] = 'Streaming now';
		$data['content'] = $this->load->view('live_streaming/streaming', $v_data, TRUE);
		$this->load->view('templates/general_admin', $data);
	}
}