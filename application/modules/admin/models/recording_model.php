<?php

class recording_model extends CI_Model 
{
	/*
	*	Count all items from a table
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function count_items($table, $where, $limit = NULL)
	{
		if($limit != NULL)
		{
			$this->db->limit($limit);
		}
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	/*
	*	Retrieve all recording
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_recording($table, $where, $per_page, $page)
	{
		//retrieve all recording
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('created','DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	/*
	*	Retrieve a single user
	*	@param int $user_id
	*
	*/
	public function get_recording($recording_id)
	{
		//retrieve all recordings
		$this->db->from('recording');
		$this->db->select('*');
		$this->db->where('recording_id = '.$recording_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing recording
	*	@param int $recording_id
	*
	*/
	public function delete_recording($recording_id)
	{
		if($this->db->delete('recording', array('recording_id' => $recording_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a derecording_status recording
	*	@param int $recording_id
	*
	*/
	public function activate_recording($recording_id)
	{
		$data = array(
				'recording_status' => 1
			);
		$this->db->where('recording_id', $recording_id);
		
		if($this->db->update('recording', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an recording_status recording
	*	@param int $recording_id
	*
	*/
	public function deactivate_recording($recording_id)
	{
		$data = array(
				'recording_status' => 0
			);
		$this->db->where('recording_id', $recording_id);
		
		if($this->db->update('recording', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	Add a new user to the database
	*
	*/
	public function add_recording()
	{
		$data = array(
				'recording_link'=>$this->input->post('recording_link'),
				'recording_status'=>$this->input->post('recording_status'),
				'recording_title'=>$this->input->post('recording_title'),
				'created'=>date('Y-m-d H:i:s')
			);
			
		if($this->db->insert('recording', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	Add a new user to the database
	*
	*/
	public function edit_recording($recording_id)
	{
		$data = array(
				'recording_link'=>$this->input->post('recording_link'),
				'recording_status'=>$this->input->post('recording_status'),
				'recording_title'=>$this->input->post('recording_title'),
				'created'=>date('Y-m-d H:i:s')
			);
			
		$this->db->where('recording_id', $recording_id);
		
		if($this->db->update('recording', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}


	
}
?>