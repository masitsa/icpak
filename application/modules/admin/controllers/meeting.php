<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Meeting extends admin {
	var $meetings_path;
	var $meetings_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('meeting_model');
		$this->load->model('file_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->meetings_path = realpath(APPPATH . '../assets/images/meetings');
		$this->meetings_location = base_url().'assets/images/meetings';
	}
    
	/*
	*
	*	Default action is to show all the meetings
	*
	*/
	public function index() 
	{
		$where = 'meeting.meeting_category_id = meeting_category.meeting_category_id';
		$table = 'meeting, meeting_category';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-meetings';
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
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->meeting_model->get_all_meetings($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('meeting/all_meetings', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'add-meeting" class="btn btn-success pull-right">Add meeting</a>There are no meetings';
		}
		$data['title'] = 'All meetings';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new meeting
	*
	*/
	public function add_meeting() 
	{
		$this->session->unset_userdata('meeting_error_message');
		
		//upload image if it has been selected
		$response = $this->meeting_model->upload_meeting_image($this->meetings_path);
		if($response)
		{
			$v_data['meeting_image_location'] = $this->meeting_location.$this->session->userdata('meeting_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['meeting_image_error'] = $this->session->userdata('meeting_error_message');
		}
		
		$meeting_error = $this->session->userdata('meeting_error_message');
		
		//form validation rules
		$this->form_validation->set_rules('meeting_category_id', 'meeting Category', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_date', 'Meeting Date', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_end_date', 'Meeting End Date', 'required|xss_clean');
		$this->form_validation->set_rules('contact_person', 'Contact Person', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_location', 'Meeting Location', 'required|xss_clean');
		$this->form_validation->set_rules('telephone', 'Telephone', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_title', 'meeting Name', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_status', 'meeting Status', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_content', 'meeting Description', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$file_name = $this->session->userdata('meeting_file_name');
			$thumb_name = $this->session->userdata('meeting_thumb_name');
			
			if($this->meeting_model->add_meeting($file_name, $thumb_name))
			{
				$this->session->set_userdata('success_message', 'meeting added successfully');
				redirect('all-meetings');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add meeting. Please try again');
			}
		}
		
		//open the add new meeting
		$data['title'] = 'Add New meeting';
		$categories_query = $this->meeting_model->get_all_active_categories();
		if($categories_query->num_rows > 0)
		{
			$categories = '<select class="form-control" name="meeting_category_id">';
			
			foreach($categories_query->result() as $res)
			{
				$categories .= '<option value="'.$res->meeting_category_id.'">'.$res->meeting_category_name.'</option>';
			}
			$categories .= '</select>';
			
			$v_data['categories'] = $categories;
			$data['content'] = $this->load->view('meeting/add_meeting', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Please add meeting categories to continue. Add categories <a href="'.site_url().'add-meeting-category">here</a>';
		}
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing meeting
	*	@param int $meeting_id
	*
	*/
	public function edit_meeting($meeting_id) 
	{
		$this->session->unset_userdata('meeting_error_message');
		
		//upload image if it has been selected
		$response = $this->meeting_model->upload_meeting_image($this->meetings_path);
		if($response)
		{
			//$v_data['meeting_image_location'] = $this->meeting_location.$this->session->userdata('meeting_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['meeting_image_error'] = $this->session->userdata('meeting_error_message');
		}
		
		$meeting_error = $this->session->userdata('meeting_error_message');
		//form validation rules
		$this->form_validation->set_rules('meeting_category_id', 'meeting Category', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_date', 'Meeting Date', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_end_date', 'Meeting End Date', 'required|xss_clean');
		$this->form_validation->set_rules('contact_person', 'Contact Person', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_location', 'Meeting Location', 'required|xss_clean');
		$this->form_validation->set_rules('telephone', 'Telephone', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_title', 'meeting Name', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_status', 'meeting Status', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_content', 'meeting Description', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{

			$file_name = $this->session->userdata('meeting_file_name');
			if(!empty($file_name))
			{
				$thumb_name = $this->session->userdata('meeting_thumb_name');
			}
			
			else{
				$file_name = $this->input->post('current_image');
				$thumb_name = 'thumbnail_'.$this->input->post('current_image');
			}
			//update meeting
			if($this->meeting_model->update_meeting($file_name, $thumb_name, $meeting_id))
			{
				$this->session->set_userdata('success_message', 'meeting updated successfully');
				redirect('all-meetings');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update meeting. Please try again');
			}
		}
		
		//open the add new meeting
		$data['title'] = 'Edit meeting';
		
		//select the meeting from the database
		$query = $this->meeting_model->get_meeting($meeting_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['meeting'] = $query->result();
			
			$categories_query = $this->meeting_model->get_all_active_categories();
			if($categories_query->num_rows > 0)
			{
				$categories = '<select class="form-control" name="meeting_category_id">';
				
				foreach($categories_query->result() as $res)
				{
					if($v_data['meeting'][0]->meeting_category_id == $res->meeting_category_id)
					{
						$categories .= '<option value="'.$res->meeting_category_id.'" selected="selected">'.$res->meeting_category_name.'</option>';
					}
					else
					{
						$categories .= '<option value="'.$res->meeting_category_id.'">'.$res->meeting_category_name.'</option>';
					}
				}
				$categories .= '</select>';
				
				$v_data['categories'] = $categories;
			
				$data['content'] = $this->load->view('meeting/edit_meeting', $v_data, true);
			}
			
			else
			{
				$data['content'] = 'Please add meeting categories to continue. Add categories <a href="'.site_url().'add-meeting-category">here</a>';
			}
		}
		
		else
		{
			$data['content'] = 'meeting does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing meeting
	*	@param int $meeting_id
	*
	*/
	public function delete_meeting($meeting_id)
	{
		//delete meeting image
		$query = $this->meeting_model->get_meeting($meeting_id);
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			$image = $result[0]->meeting_image;
			
			$this->load->model('file_model');
			//delete image
			$this->file_model->delete_file($this->meetings_path."\\".$image);
			//delete thumbnail
			$this->file_model->delete_file($this->meetings_path."\\thumbnail_".$image);
		}
		//delete meetings of that category
		$this->meeting_model->delete_meeting_comments($meeting_id);
		$this->meeting_model->delete_meeting($meeting_id);
		$this->session->set_userdata('success_message', 'meeting has been deleted');
		redirect('all-meetings');
	}
    
	/*
	*
	*	Activate an existing meeting
	*	@param int $meeting_id
	*
	*/
	public function activate_meeting($meeting_id)
	{
		$this->meeting_model->activate_meeting($meeting_id);
		$this->session->set_userdata('success_message', 'meeting activated successfully');
		redirect('all-meetings');
	}
    
	/*
	*
	*	Deactivate an existing meeting
	*	@param int $meeting_id
	*
	*/
	public function deactivate_meeting($meeting_id)
	{
		$this->meeting_model->deactivate_meeting($meeting_id);
		$this->session->set_userdata('success_message', 'meeting disabled successfully');
		redirect('all-meetings');
	}
    
	/*
	*
	*	meeting Comments
	*
	*/
	public function comments($meeting_id = NULL) 
	{
		$where = 'meeting.meeting_id = meeting_comment.meeting_id';
		if($meeting_id == NULL)
		{
			$segment = 2;
		}
		
		else
		{
			$where .= ' AND meeting_comment.meeting_id = '.$meeting_id;
			$segment = 3;
		}
		$table = 'meeting_comment, meeting';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'comments/'.$meeting_id;
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
		$query = $this->meeting_model->get_comments($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$v_data['meeting_id'] = $meeting_id;
			$v_data['title'] = $this->meeting_model->get_comment_title($meeting_id);
			$data['content'] = $this->load->view('meeting/comments', $v_data, true);
		}
		
		else
		{
			if($meeting_id != NULL)
			{
				$data['content'] = '<a href="'.site_url().'add-comment/'.$meeting_id.'" class="btn btn-success pull-right">Add Comment</a>There are no comments';
			}
			
			else
			{
				$data['content'] = 'There are no comments';
			}
		}
		$data['title'] = 'Comments';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new comment
	*
	*/
	public function add_comment($meeting_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('meeting_comment_description', 'Description', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{	
			if($this->meeting_model->add_comment_admin($meeting_id))
			{
				$this->session->set_userdata('success_message', 'Comment added successfully');
				redirect('comments/'.$meeting_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add comment. Please try again');
			}
		}
		
		//open the add new meeting
		$data['title'] = 'Add Comment';
		$v_data['meeting_id'] = $meeting_id;
		$v_data['title'] = $this->meeting_model->get_comment_title($meeting_id);
		$data['content'] = $this->load->view('meeting/add_comment', $v_data, true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing comment
	*	@param int $meeting_comment_id
	*	@param int $meeting_id
	*
	*/
	public function delete_comment($meeting_comment_id, $meeting_id = NULL)
	{
		$this->meeting_model->delete_comment($meeting_comment_id);
		$this->session->set_userdata('success_message', 'Comment has been deleted');
		redirect('comments/'.$meeting_id);
	}
    
	/*
	*
	*	Activate an existing comment
	*	@param int $meeting_comment_id
	*	@param int $meeting_id
	*
	*/
	public function activate_comment($meeting_comment_id, $meeting_id = NULL)
	{
		$this->meeting_model->activate_comment($meeting_comment_id);
		$this->session->set_userdata('success_message', 'Comment activated successfully');
		redirect('comments/'.$meeting_id);
	}
    
	/*
	*
	*	Deactivate an existing comment
	*	@param int $meeting_comment_id
	*	@param int $meeting_id
	*
	*/
	public function deactivate_comment($meeting_comment_id, $meeting_id = NULL)
	{
		$this->meeting_model->deactivate_comment($meeting_comment_id);
		$this->session->set_userdata('success_message', 'Comment disabled successfully');
		redirect('comments/'.$meeting_id);
	}
    



    /*
	*
	*	meeting bookings
	*
	*/
	public function bookings($meeting_id = NULL) 
	{
		$where = 'meeting.meeting_id = meeting_booking.meeting_id';
		if($meeting_id == NULL)
		{
			$segment = 2;
		}
		
		else
		{
			$where .= ' AND meeting_booking.meeting_id = '.$meeting_id;
			$segment = 3;
		}
		$table = 'meeting_booking, meeting';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'bookings/'.$meeting_id;
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
		$query = $this->meeting_model->get_bookings($table, $where, $config["per_page"], $page);
		$v_data['title'] = $this->meeting_model->get_comment_title($meeting_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$v_data['meeting_id'] = $meeting_id;
			
			$data['content'] = $this->load->view('meeting/bookings', $v_data, true);
		}
		
		else
		{
			if($meeting_id != NULL)
			{
				$data['content'] = '<a href="'.site_url().'meetings" class="btn btn-success pull-right">Back to meeting list</a> <br>There are no bookings yet';
			}
			
			else
			{
				$data['content'] = 'There are no bookings yet';
			}
		}
		$data['title'] = 'Bookings for '.$v_data['title'];
		
		$this->load->view('templates/general_admin', $data);
	}

		/*
	*
	*	Delete an existing comment
	*	@param int $meeting_comment_id
	*	@param int $meeting_id
	*
	*/
	public function delete_booking($booking_id, $meeting_id = NULL)
	{
		$this->meeting_model->delete_booking($booking_id);
		$this->session->set_userdata('success_message', 'Booking has been deleted');
		redirect('bookings/'.$meeting_id);
	}
    
	/*
	*
	*	Activate an existing booking
	*	@param int $booking_id
	*	@param int $meeting_id
	*
	*/
	public function activate_booking($booking_id, $meeting_id = NULL)
	{
		$this->meeting_model->activate_booking($booking_id);
		$this->session->set_userdata('success_message', 'Booking activated successfully');
		redirect('bookings/'.$meeting_id);
	}
    
	/*
	*
	*	Deactivate an existing booking
	*	@param int $booking_id
	*	@param int $meeting_id
	*
	*/
	public function deactivate_booking($booking_id, $meeting_id = NULL)
	{
		$this->meeting_model->deactivate_booking($booking_id);
		$this->session->set_userdata('success_message', 'Booking disabled successfully');
		redirect('bookings/'.$meeting_id);
	}
    
	/*
	*
	*	meeting Categories
	*
	*/
	public function categories() 
	{
		$where = 'meeting_category_id > 0';
		$table = 'meeting_category';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'meeting-categories';
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
		$query = $this->meeting_model->get_all_categories($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$v_data['categories_query'] = $this->meeting_model->get_all_active_categories();
			$data['content'] = $this->load->view('meeting/all_categories', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'add-meeting-category" class="btn btn-success pull-right">Add Meeting Category</a>There are no categories';
		}
		$data['title'] = 'All Categories';
		
		$this->load->view('templates/general_admin', $data);
	}
	
	public function add_meeting_category()
	{
		//form validation rules
		$this->form_validation->set_rules('meeting_category_parent', 'Parent Category', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_category_name', 'Category Name', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_category_status', 'Category Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{	
			if($this->meeting_model->add_meeting_category())
			{
				$this->session->set_userdata('success_message', 'Category added successfully');
				redirect('meeting-categories');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add category. Please try again');
			}
		}
		
		//open the add new meeting
		$data['title'] = 'Add meeting category';
		$categories_query = $this->meeting_model->get_all_active_categories();
		$categories = '<select class="form-control" name="meeting_category_parent"><option value="0">No Parent</option>';
		if($categories_query->num_rows > 0)
		{
			
			foreach($categories_query->result() as $res)
			{
				$categories .= '<option value="'.$res->meeting_category_id.'">'.$res->meeting_category_name.'</option>';
			}
		}
		$categories .= '</select>';
		
		$v_data['categories'] = $categories;
		$data['content'] = $this->load->view('meeting/add_category', $v_data, true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing meeting category
	*	@param int $meeting_category_id
	*
	*/
	public function edit_meeting_category($meeting_category_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('meeting_category_parent', 'Parent Category', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_category_name', 'Category Name', 'required|xss_clean');
		$this->form_validation->set_rules('meeting_category_status', 'Category Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update meeting
			if($this->meeting_model->update_meeting_category($meeting_category_id))
			{
				$this->session->set_userdata('success_message', 'Category updated successfully');
				redirect('meeting-categories');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update category. Please try again');
			}
		}
		
		//open the add new meeting
		$data['title'] = 'Edit Category';
		
		//select the meeting from the database
		$query = $this->meeting_model->get_meeting_category($meeting_category_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['category'] = $query->result();
			$categories_query = $this->meeting_model->get_all_active_categories();
			$categories = '<select class="form-control" name="meeting_category_parent"><option value="0">No Parent</option>';
			if($categories_query->num_rows > 0)
			{
				
				foreach($categories_query->result() as $res)
				{
					if($v_data['category'][0]->meeting_category_parent == $res->meeting_category_id)
					{
						$categories .= '<option value="'.$res->meeting_category_id.'" selected="selected">'.$res->meeting_category_name.'</option>';
					}
					
					else
					{
						$categories .= '<option value="'.$res->meeting_category_id.'">'.$res->meeting_category_name.'</option>';
					}
				}
			}
			$categories .= '</select>';
			
			$v_data['categories'] = $categories;
			
			$data['content'] = $this->load->view('meeting/edit_meeting_category', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'meeting does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing category
	*	@param int $meeting_category_id
	*
	*/
	public function delete_meeting_category($meeting_category_id)
	{
		//delete meetings of that category
		$this->meeting_model->delete_category_meeting_comments($meeting_category_id);
		$this->meeting_model->delete_category_meetings($meeting_category_id);
		$this->meeting_model->delete_meeting_category($meeting_category_id);
		$this->session->set_userdata('success_message', 'Category has been deleted');
		redirect('meeting-categories');
	}
    
	/*
	*
	*	Activate an existing category
	*	@param int $meeting_category_id
	*
	*/
	public function activate_meeting_category($meeting_category_id)
	{
		$this->meeting_model->activate_meeting_category($meeting_category_id);
		$this->session->set_userdata('success_message', 'Category activated successfully');
		redirect('meeting-categories');
	}
    
	/*
	*
	*	Deactivate an existing category
	*	@param int $meeting_category_id
	*
	*/
	public function deactivate_meeting_category($meeting_category_id)
	{
		$this->meeting_model->deactivate_meeting_category($meeting_category_id);
		$this->session->set_userdata('success_message', 'Category disabled successfully');
		redirect('meeting-categories');
	}
	function add_slide($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		$data['meeting_location'] = 'http://placehold.it/300x300';
		
		
		$this->form_validation->set_rules('check', 'check', 'trim|xss_clean');
		$this->form_validation->set_rules('meeting_name', 'Title', 'trim|xss_clean');
		$this->form_validation->set_rules('meeting_description', 'Description', 'trim|xss_clean');

		if ($this->form_validation->run())
		{	
			if(empty($meeting_error))
			{
				$data2 = array(
					'meeting_name'=>$this->input->post("meeting_name"),
					'meeting_description'=>$this->input->post("meeting_description"),
					'meeting_image_name'=>$this->session->userdata('meeting_file_name')
				);
				
				$table = "meeting";
				$this->administration_model->insert($table, $data2);
				$this->session->unset_userdata('meeting_file_name');
				$this->session->unset_userdata('meeting_thumb_name');
				$this->session->unset_userdata('meeting_error_message');
				
				redirect('administration/meeting/4/5');
			}
		}
		
		$table = "meeting";
		$where = "meeting_id > 0";
		$items = "*";
		$order = "meeting_id";
		
		$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$meeting = $this->session->userdata('meeting_file_name');
		
		if(!empty($meeting))
		{
			$data['meeting_location'] = $this->meeting_location.$this->session->userdata('meeting_file_name');
		}
		$data['error'] = $meeting_error;
		
		$this->load_head();
		$this->load->view("meeting/add_slide", $data);
		$this->load_foot();
	}
}
?>