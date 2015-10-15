<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Members extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('member_model');
		$this->load->model('users_model');
	}
    
	/*
	*
	*	Default action is to show all the member
	*
	*/
	public function index() 
	{
		$where = 'id > 0';
		$table = 'jos_users';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-member';
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
		$query = $this->member_model->get_all_member($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['member'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('member/all_member', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'add-member" class="btn btn-success pull-right">Add Member</a> There are no Members';
		}
		$data['title'] = 'All Members';
		
		$this->load->view('templates/general_admin', $data);
	}
    
    
	/*
	*
	*	Delete an existing member page
	*	@param int $member_id
	*
	*/
	public function delete_member($member_id) 
	{
		if($this->member_model->delete_member($member_id))
		{
			$this->session->set_userdata('success_message', 'Member has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Member could not be deleted');
		}
		
		redirect('all-member');
	}
    
	/*
	*
	*	Activate an existing member page
	*	@param int $member_id
	*
	*/
	public function activate_member($member_id) 
	{
		if($this->member_model->activate_member($member_id))
		{
			$this->session->set_userdata('success_message', 'Member has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Member could not be activated');
		}
		
		redirect('all-member');
	}
    
	/*
	*
	*	Deactivate an existing member page
	*	@param int $member_id
	*
	*/
	public function deactivate_member($member_id) 
	{
		if($this->member_model->deactivate_member($member_id))
		{
			$this->session->set_userdata('success_message', 'Member has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Member could not be disabled');
		}
		
		redirect('all-member');
	}
	
}
?>