<?php

class Query_model extends CI_Model 
{

	/*
	*	Retrieve all meetings
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_technical_query($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('query.query_id', 'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}


	/*
	*	Delete an existing query
	*	@param int $query_id
	*
	*/
	public function delete_query($query_id)
	{
		if($this->db->delete('query', array('query_id' => $query_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated query
	*	@param int $query_id
	*
	*/
	public function activate_query($query_id)
	{
		$data = array(
				'query_status' => 1
			);
		$this->db->where('query_id', $query_id);
		
		if($this->db->update('query', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated query
	*	@param int $query_id
	*
	*/
	public function deactivate_query($query_id)
	{
		$data = array(
				'query_status' => 0
			);
		$this->db->where('query_id', $query_id);
		
		if($this->db->update('query', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}


	/*
	*	Delete an existing query
	*	@param int $query_id
	*
	*/
	public function delete_standards_query($query_id)
	{
		if($this->db->delete('query', array('query_id' => $query_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated query
	*	@param int $query_id
	*
	*/
	public function activate_standards_query($query_id)
	{
		$data = array(
				'query_status' => 1
			);
		$this->db->where('query_id', $query_id);
		
		if($this->db->update('query', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated query
	*	@param int $query_id
	*
	*/
	public function deactivate_standards_query($query_id)
	{
		$data = array(
				'query_status' => 0
			);
		$this->db->where('query_id', $query_id);
		
		if($this->db->update('query', $data))
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
	public function get_query($query_id)
	{
		//retrieve all users
		$this->db->from('query,member');
		$this->db->select('*');
		$this->db->where('query.member_id = member.member_id AND query_id = '.$query_id);
		$query = $this->db->get();
		
		return $query;
	}

	/*
	*
	*	Meeting reminder Email
	*
	*/
	public function send_query_responses($query_id) 
	{
		$this->load->model('admin/email_model');
		$this->load->library('Mandrill', $this->config->item('mandrill_key'));
		
		// get meeting details
		$meeting_detail = $this->get_query($query_id);
		if ($meeting_detail->num_rows() > 0)
		{
			foreach ($meeting_detail->result() as $row)
			{
				$member_username = $row->member_username;
				$member_other_names = $row->member_other_names;
				$member_email = $row->member_email;
				$member_phone = $row->member_phone;
				$member_status = $row->member_status;
				$member_company = $row->member_company;
				$query_subject = $row->query_subject;
				$query_text = $row->query_text;
				$query_date = $row->query_date;
				$query_status = $row->query_status;
				$query_id = $row->query_id;
				$member_no = $row->member_no;
				$query_response = $row->query_response;
				$query_item_id = $row->query_item_id;


				
			}
		}
		
		
		$subject = "Response to your  ".$query_subject." query";
		$message = '
				<p>The response on the subjected <strong>'.$query_subject.'</strong> according to your query:  '.$query_text.' is:</p>
				<p>'.$this->input->post('post_content').' </p>
				';
		$sender_email = "info@icpak.com";
		$shopping = "";
		$from = "Customer care";
		
		$button = '';




		$response = $this->email_model->send_mandrill_mail($member_email, "Hi ".$member_username, $subject, $message, $sender_email, $shopping, $from, $button);
		
		return $response;
	}
}