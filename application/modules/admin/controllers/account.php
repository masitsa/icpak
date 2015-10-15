<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Account extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('account_model');
	}

	public function index()
	{
		$where = 'event_session.event_session_id = session_admin.event_session_id AND icpak_event.event_id = event_session.event_id AND session_admin.admin_id  = '.$this->session->userdata('user_id');
		$table = 'event_session,session_admin,icpak_event';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'sessions';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
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
		$query = $this->account_model->get_all_assigned_sessions($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['event_session'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('session/my_sessions', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'add-user" class="btn btn-success pull-right">Add Administrator</a> There are no administrators';
		}
		$data['title'] = 'All assigned sessions';
		
		$this->load->view('templates/facilitators_page', $data);
	}
	public function respond_to_question($question_id)
	{

		//form validation rules
		$this->form_validation->set_rules('question_answer', 'Other Names', 'required|xss_clean');
		$this->form_validation->set_rules('visible_status', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('list_status', 'First Name', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->account_model->respond_to_question($question_id))
			{
				$data['result'] = 'Your update was successfull';
			}
			
			else
			{
				$data['result'] = 'Problem with sending your answer. Please try again';
			}
		}
		else
		{
			$data['result'] = 'Something went wrong. Ensure you have filled in all the fields';
		}
		echo json_encode($data);

	}
}