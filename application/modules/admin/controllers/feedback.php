<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Feedback extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('feedback_model');
		$this->load->model('users_model');
	}
    
	/*
	*
	*	Default action is to show all the event
	*
	*/
	public function index() 
	{
		$where = 'feedback_id > 0';
		$table = 'feedback';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'feedback';
		$config['total_rows'] = $this->feedback_model->count_items($table, $where);
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
		$query = $this->feedback_model->get_all_feedback($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['feedback'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('feedback/all_feedback', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'There are no feedbacks yet';
		}
		$data['title'] = 'All feedbacks';
		
		$this->load->view('templates/general_admin', $data);
	}
    
}