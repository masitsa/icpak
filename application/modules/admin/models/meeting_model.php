<?php

class Meeting_model extends CI_Model 
{	
	/*
	*	Retrieve all active categories
	*
	*/
	public function get_all_active_categories()
	{
		$this->db->where('meeting_category_status = 1');
		$this->db->order_by('meeting_category_name');
		$query = $this->db->get('meeting_category');
		
		return $query;
	}
	
	public function get_all_meeting_categories($meeting_category_id)
	{
		$this->db->where('meeting_category.meeting_category_id = '.$meeting_category_id.' OR meeting_category.meeting_category_parent = '.$meeting_category_id);
		$this->db->order_by('meeting_category_parent, meeting_category_name');
		$query = $this->db->get('meeting_category');
		
		return $query;
	}
	
	/*
	*	Retrieve all active categories
	*
	*/
	public function get_all_active_category_parents()
	{
		$this->db->where('meeting_category_status = 1 AND meeting_category_parent = 0');
		$this->db->order_by('meeting_category_name');
		$query = $this->db->get('meeting_category');
		
		return $query;
	}
	
	/*
	*	Retrieve all active children
	*
	*/
	public function get_all_active_category_children($meeting_category_id)
	{
		$this->db->where('meeting_category_status = 1 AND meeting_category_parent = '.$meeting_category_id);
		$this->db->order_by('meeting_category_name');
		$query = $this->db->get('meeting_category');
		
		return $query;
	}
	/*
	*	Retrieve all active meetings
	*
	*/
	public function all_active_meetings()
	{
		$this->db->where('meeting_status = 1');
		$query = $this->db->get('meeting');
		
		return $query;
	}
	
	/*
	*	Retrieve latest meeting
	*
	*/
	public function latest_meeting()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('meeting');
		
		return $query;
	}
	
	/*
	*	Retrieve all meetings
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_meetings($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('meeting.*, meeting_category.meeting_category_name');
		$this->db->where($where);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new meeting
	*	@param string $image_name
	*
	*/
	public function add_meeting($image_name, $thumb_name)
	{
		$meeting_content = strip_tags($this->input->post('meeting_content'));
		$data = array(
				'meeting_title'=>$this->input->post('meeting_title'),
				'meeting_status'=>$this->input->post('meeting_status'),
				'telephone'=>$this->input->post('telephone'),
				'meeting_location'=>$this->input->post('meeting_location'),
				'contact_person'=>$this->input->post('contact_person'),
				'meeting_date'=>$this->input->post('meeting_date'),
				'meeting_end_date'=>$this->input->post('meeting_end_date'),
				'times'=>$this->input->post('times'),
				'meeting_content'=>$meeting_content,
				'meeting_category_id'=>$this->input->post('meeting_category_id'),
				'created'=>date('Y-m-d'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'meeting_thumb'=>$thumb_name,
				'meeting_image'=>$image_name
			);
			
		if($this->db->insert('meeting', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing meeting
	*	@param string $image_name
	*	@param int $meeting_id
	*
	*/
	public function update_meeting($image_name, $thumb_name, $meeting_id)
	{
		$meeting_content = strip_tags($this->input->post('meeting_content'));
		$data = array(
				'meeting_title'=>$this->input->post('meeting_title'),
				'meeting_status'=>$this->input->post('meeting_status'),
				'telephone'=>$this->input->post('telephone'),
				'meeting_location'=>$this->input->post('meeting_location'),
				'contact_person'=>$this->input->post('contact_person'),
				'meeting_date'=>$this->input->post('meeting_date'),
				'meeting_end_date'=>$this->input->post('meeting_end_date'),
				'times'=>$this->input->post('times'),
				'meeting_content'=>$meeting_content,
				'meeting_category_id'=>$this->input->post('meeting_category_id'),
				'created'=>date('Y-m-d'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'meeting_thumb'=>$thumb_name,
				'meeting_image'=>$image_name
			);
			
		$this->db->where('meeting_id', $meeting_id);
		if($this->db->update('meeting', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single meeting's details
	*	@param int $meeting_id
	*
	*/
	public function get_meeting($meeting_id)
	{
		//retrieve all users
		$this->db->from('meeting');
		$this->db->select('*');
		$this->db->where('meeting_id = '.$meeting_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing meeting's comments
	*	@param int $meeting_id
	*
	*/
	public function delete_meeting_comments($meeting_id)
	{
		if($this->db->delete('meeting_comment', array('meeting_id' => $meeting_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing meeting
	*	@param int $meeting_id
	*
	*/
	public function delete_meeting($meeting_id)
	{
		if($this->db->delete('meeting', array('meeting_id' => $meeting_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated meeting
	*	@param int $meeting_id
	*
	*/
	public function activate_meeting($meeting_id)
	{
		$data = array(
				'meeting_status' => 1
			);
		$this->db->where('meeting_id', $meeting_id);
		
		if($this->db->update('meeting', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated meeting
	*	@param int $meeting_id
	*
	*/
	public function deactivate_meeting($meeting_id)
	{
		$data = array(
				'meeting_status' => 0
			);
		$this->db->where('meeting_id', $meeting_id);
		
		if($this->db->update('meeting', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Retrieve comments
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_comments($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('meeting.meeting_title, meeting.created, meeting.meeting_image, meeting_comment.*');
		$this->db->where($where);
		$this->db->order_by('comment_created', 'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	
	
	/*

	*	Retrieve comments
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_bookings($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('meeting.meeting_title, meeting.created, meeting.meeting_image, meeting_booking.*');
		$this->db->where($where);
		$this->db->order_by('booking_created', 'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new comment
	*	@param int $meeting_id
	*
	*/
	public function add_comment_admin($meeting_id)
	{
		$data = array(
				'meeting_comment_description'=>$this->input->post('meeting_comment_description'),
				'comment_created'=>date('Y-m-d H:i:s'),
				'meeting_comment_user'=>$this->session->userdata('first_name'),
				'meeting_comment_email'=>$this->session->userdata('email'),
				'meeting_id'=>$meeting_id
			);
			
		if($this->db->insert('meeting_comment', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	Add a new delegates
	*	@param int $booking_id
	*
	*/
	public function get_all_delegates($booking_id)
	{
		//retrieve all users
		$this->db->from('delegate,title');
		$this->db->select('*');
		$this->db->where('title.title_id = delegate.title_id AND booking_id ='.$booking_id);
		$this->db->order_by('delegate_id', 'DESC');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Add a new comment
	*	@param int $meeting_id
	*
	*/
	public function add_comment_user($meeting_id)
	{
		$data = array(
				'meeting_comment_description'=>$this->input->post('meeting_comment_description'),
				'comment_created'=>date('Y-m-d H:i:s'),
				'meeting_comment_user'=>$this->input->post('name'),
				'meeting_comment_email'=>$this->input->post('email'),
				'meeting_comment_status'=>0,
				'meeting_id'=>$meeting_id
			);
			
		if($this->db->insert('meeting_comment', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function get_comment_title($meeting_id)
	{
		if($meeting_id > 0)
		{
			$query = $this->get_meeting($meeting_id);
			
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$title = $row->meeting_title;
			}
			
			else
			{
				$title = '';
			}
		}
			
		else
		{
			$title = '';
		}
		
		return $title;	
	}
	
	/*
	*	Delete an existing comment
	*	@param int $meeting_comment_id
	*
	*/
	public function delete_comment($meeting_comment_id)
	{
		if($this->db->delete('meeting_comment', array('meeting_comment_id' => $meeting_comment_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated comment
	*	@param int $meeting_comment_id
	*
	*/
	public function activate_comment($meeting_comment_id)
	{
		$data = array(
				'meeting_comment_status' => 1
			);
		$this->db->where('meeting_comment_id', $meeting_comment_id);
		
		if($this->db->update('meeting_comment', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated comment
	*	@param int $meeting_comment_id
	*
	*/
	public function deactivate_comment($meeting_comment_id)
	{
		$data = array(
				'meeting_comment_status' => 0
			);
		$this->db->where('meeting_comment_id', $meeting_comment_id);
		
		if($this->db->update('meeting_comment', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}


	/*
	*	Delete an existing comment
	*	@param int $meeting_comment_id
	*
	*/
	public function delete_booking($booking_id)
	{
		if($this->db->delete('meeting_booking', array('booking_id' => $booking_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated booking
	*	@param int $booking_id
	*
	*/
	public function activate_booking($booking_id)
	{
		$data = array(
				'booking_status' => 1
			);
		$this->db->where('booking_id', $booking_id);
		
		if($this->db->update('meeting_booking', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated booking
	*	@param int $booking_id
	*
	*/
	public function deactivate_booking($booking_id)
	{
		$data = array(
				'booking_status' => 0
			);
		$this->db->where('booking_id', $booking_id);
		
		if($this->db->update('meeting_booking', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	
	public function update_views_count($meeting_id)
	{
		//get count of views
		$this->db->where('meeting_id', $meeting_id);
		$query = $this->db->get('meeting');
		$row = $query->row();
		$total = $row->meeting_views;
		
		//increment comments
		$total++;
		
		//update
		$data = array(
				'meeting_views' => $total
			);
		$this->db->where('meeting_id', $meeting_id);
		
		if($this->db->update('meeting', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Retrieve all categories
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_categories($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('meeting_category_name', 'ASC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new category
	*	@param int $meeting_id
	*
	*/
	public function add_meeting_category()
	{
		$data = array(
				'meeting_category_name'=>$this->input->post('meeting_category_name'),
				'meeting_category_status'=>$this->input->post('meeting_category_status'),
				'meeting_category_parent'=>$this->input->post('meeting_category_parent'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		if($this->db->insert('meeting_category', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing category
	*	@param int $meeting_category_id
	*
	*/
	public function update_meeting_category($meeting_category_id)
	{
		$data = array(
				'meeting_category_name'=>$this->input->post('meeting_category_name'),
				'meeting_category_status'=>$this->input->post('meeting_category_status'),
				'meeting_category_parent'=>$this->input->post('meeting_category_parent'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		$this->db->where('meeting_category_id', $meeting_category_id);
		if($this->db->update('meeting_category', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single category's details
	*	@param int $meeting_category_id
	*
	*/
	public function get_meeting_category($meeting_category_id)
	{
		//retrieve all users
		$this->db->from('meeting_category');
		$this->db->select('*');
		$this->db->where('meeting_category_id = '.$meeting_category_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing meeting's comments by category id
	*	@param int $meeting_category_id
	*
	*/
	public function delete_category_meeting_comments($meeting_category_id)
	{
		$this->db->where(array('meeting_category_id' => $meeting_category_id));
		$this->db->select('meeting_id');
		$query = $this->db->get('meeting');
		$row = $query->row();
		$meeting_id = $row->meeting_id;
		
		if($this->db->delete('meeting_comment', array('meeting_id' => $meeting_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing meeting
	*	@param int $meeting_category_id
	*
	*/
	public function delete_category_meetings($meeting_category_id)
	{
		if($this->db->delete('meeting', array('meeting_category_id' => $meeting_category_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing category
	*	@param int $meeting_category_id
	*
	*/
	public function delete_meeting_category($meeting_category_id)
	{
		if($this->db->delete('meeting_category', array('meeting_category_id' => $meeting_category_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated category
	*	@param int $meeting_category_id
	*
	*/
	public function activate_meeting_category($meeting_category_id)
	{
		$data = array(
				'meeting_category_status' => 1
			);
		$this->db->where('meeting_category_id', $meeting_category_id);
		
		if($this->db->update('meeting_category', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated category
	*	@param int $meeting_category_id
	*
	*/
	public function deactivate_meeting_category($meeting_category_id)
	{
		$data = array(
				'meeting_category_status' => 0
			);
		$this->db->where('meeting_category_id', $meeting_category_id);
		
		if($this->db->update('meeting_category', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Retrieve recent meetings
	*
	*/
	public function get_recent_meetings()
	{
		$this->db->from('meeting');
		$this->db->select('meeting.*');
		$this->db->where('meeting_status = 1');
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('', 3);
		
		return $query;
	}
	
	/*
	*	Retrieve popular meetings
	*
	*/
	public function get_popular_meetings()
	{
		$this->db->from('meeting');
		$this->db->select('meeting.*');
		$this->db->where('meeting_status = 1');
		$this->db->order_by('meeting_views', 'DESC');
		$query = $this->db->get('', 3);
		
		return $query;
	}
	
	/*
	*	Retrieve related meetings
	*
	*/
	public function get_related_meetings($meeting_category_id, $meeting_id)
	{
		$this->db->from('meeting, meeting_category');
		$this->db->select('meeting.*');
		$this->db->where('meeting.meeting_id <> '.$meeting_id.' AND meeting.meeting_status = 1 AND meeting.meeting_category_id = meeting_category.meeting_category_id AND (meeting_category.meeting_category_id = '.$meeting_category_id.' OR meeting_category.meeting_category_parent = '.$meeting_category_id.')');
		$this->db->order_by('meeting.created', 'DESC');
		$query = $this->db->get('', 4);
		
		return $query;
	}
	
	/*
	*	Retrieve comments
	* 	@param int $meeting_id
	*
	*/
	public function get_meeting_comments($meeting_id)
	{
		//retrieve all users
		$this->db->from('meeting_comment');
		$this->db->select('meeting_comment.*');
		$this->db->where('meeting_comment_status = 1 AND meeting_id = '.$meeting_id);
		$this->db->order_by('comment_created', 'DESC');
		$query = $this->db->get();
		
		return $query;
	}
	public function upload_meeting_image($meeting_path)
	{
		//upload product's gallery images
		$resize['width'] = 1000;
		$resize['height'] = 430;
		
		if(isset($_FILES['meeting_image']['tmp_name']))
		{
			$file_name = $this->session->userdata('meeting_file_name');
			if(!empty($file_name))
			{
				//delete any other uploaded image
				$this->file_model->delete_file($meeting_path."\\".$this->session->userdata('meeting_file_name'));
				
				//delete any other uploaded thumbnail
				$this->file_model->delete_file($meeting_path."\\thumbnail_".$this->session->userdata('meeting_file_name'));
			}
			//Upload image
			$response = $this->file_model->upload_file($meeting_path, 'meeting_image', $resize);
			if($response['check'])
			{
				$file_name = $response['file_name'];
				$thumb_name = $response['thumb_name'];
				
				//crop file to 1920 by 1010
				$response_crop = $this->file_model->crop_file($meeting_path."\\".$file_name, $resize['width'], $resize['height']);
				
				if(!$response_crop)
				{
					$this->session->set_userdata('meeting_error_message', $response_crop);
				
					return FALSE;
				}
				
				else
				{	
					//Set sessions for the image details
					$this->session->set_userdata('meeting_file_name', $file_name);
					$this->session->set_userdata('meeting_thumb_name', $thumb_name);
				
					return TRUE;
				}
			}
		
			else
			{
				$this->session->set_userdata('meeting_error_message', $response['error']);
				
				return FALSE;
			}
		}
		
		else
		{
			$this->session->set_userdata('meeting_error_message', '');
			return FALSE;
		}
	}
}
?>