<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Query extends admin {
	var $meetings_path;
	var $meetings_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('query_model');
		$this->load->model('file_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->meetings_path = realpath(APPPATH . '../assets/images/meetings');
		$this->meetings_location = base_url().'assets/images/meetings';
	}

	/*
	*
	*	meeting technical_query
	*
	*/
	public function technical_query() 
	{
		$where = 'query.query_item_id = 1 AND member.member_id = query.member_id';

		
		$segment = 2;
		
		$table = 'query, member';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'technical-queries';
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
		$query = $this->query_model->get_technical_query($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('query/technical_query', $v_data, true);
		}
		
		else
		{
			
				$data['content'] = 'There are no technical queries';
			
		}
		$data['title'] = 'Technical queries';
		
		$this->load->view('templates/general_admin', $data);
	}
	/*
	*
	*	Delete an existing comment
	*	@param int $query_id
	*	@param int $meeting_id
	*
	*/
	public function delete_query($query_id)
	{
		$this->query_model->delete_query($query_id);
		$this->session->set_userdata('success_message', 'Query has been deleted');
		redirect('technical-queries');
	}
    
	/*
	*
	*	Activate an existing query
	*	@param int $query_id
	*	@param int $meeting_id
	*
	*/
	public function activate_query($query_id)
	{
		$this->query_model->activate_query($query_id);
		$this->session->set_userdata('success_message', 'Query activated successfully');
		redirect('technical-queries');
	}
    
	/*
	*
	*	Deactivate an existing query
	*	@param int $query_id
	*	@param int $meeting_id
	*
	*/
	public function deactivate_query($query_id)
	{
		$this->query_model->deactivate_query($query_id);
		$this->session->set_userdata('success_message', 'Query disabled successfully');
		redirect('technical-queries');
	}




	/*
	*
	*	meeting technical_query
	*
	*/
	public function standards_query() 
	{
		$where = 'query_item_id = 2 AND member.member_id = query.member_id';
		
		$segment = 2;
		
		$table = 'query, member';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'standards-queries';
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
		$query = $this->query_model->get_technical_query($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('query/standards_query', $v_data, true);
		}
		
		else
		{
			
				$data['content'] = 'There are no standards queries';
			
		}
		$data['title'] = 'Standards queries';
		
		$this->load->view('templates/general_admin', $data);
	}
	/*
	*
	*	Delete an existing comment
	*	@param int $query_id
	*	@param int $meeting_id
	*
	*/
	public function delete_standards_query($query_id)
	{
		$this->query_model->delete_standards_query($query_id);
		$this->session->set_userdata('success_message', 'Query has been deleted');
		redirect('standards-queries');
	}
    
	/*
	*
	*	Activate an existing query
	*	@param int $query_id
	*	@param int $meeting_id
	*
	*/
	public function activate_standards_query($query_id)
	{
		$this->query_model->activate_standards_query($query_id);
		$this->session->set_userdata('success_message', 'Query activated successfully');
		redirect('standards-queries');
	}
    
	/*
	*
	*	Deactivate an existing query
	*	@param int $query_id
	*	@param int $meeting_id
	*
	*/
	public function deactivate_standards_query($query_id)
	{
		$this->query_model->deactivate_standards_query($query_id);
		$this->session->set_userdata('success_message', 'Query disabled successfully');
		redirect('standards-queries');
	}

	
	public function send_query_response($query_id)
	{
		if($this->query_model->send_query_responses($query_id)){
			$this->session->set_userdata('success_message', 'Response has been successfully sent');
			
			$data['result'] = 'success';
		}
		else
		{
			$this->session->set_userdata('error_message', 'Response has not been sent');
			
			$data['result'] = 'failure';
		}
		
		
		echo json_encode($data);
	}

}