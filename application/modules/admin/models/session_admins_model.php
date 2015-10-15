<?php

class Session_admins_model extends CI_Model 
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
	*	Retrieve all event
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_session_admins($table, $where, $per_page, $page)
	{
		//retrieve all event
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('session_admin_id','DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	
	
	/*
	*	Delete an existing event
	*	@param int $session_admin_id
	*
	*/
	public function delete_session_admin($session_admin_id)
	{
		if($this->db->delete('session_admin', array('session_admin_id' => $session_admin_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a desession_admin_status event
	*	@param int $session_admin_id
	*
	*/
	public function activate_session_admin($session_admin_id)
	{
		$data = array(
				'session_admin_status' => 1
			);
		$this->db->where('session_admin_id', $session_admin_id);
		
		if($this->db->update('session_admin', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an session_admin_status event
	*	@param int $session_admin_id
	*
	*/
	public function deactivate_session_admin($session_admin_id)
	{
		$data = array(
				'session_admin_status' => 0
			);
		$this->db->where('session_admin_id', $session_admin_id);
		
		if($this->db->update('session_admin', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	Add a new event to the database
	*
	*/
	public function add_session_admin()
	{
		$data = array(
				'admin_id'=>$this->input->post('admin_id'),
				'event_session_id'=>$this->input->post('event_session_id')
			);
			
		if($this->db->insert('session_admin', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	Edit an existing event
	*	@param int $session_admin_id
	*
	*/
	public function edit_session_admin($session_admin_id)
	{
		$data = array(
					'admin_id'=>$this->input->post('admin_id'),
					'event_session_id'=>$this->input->post('event_session_id')
				);
		
		
		
		$this->db->where('session_admin_id', $session_admin_id);
		
		if($this->db->update('session_admin', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function get_session_admin($session_admin_id)
	{
		//retrieve all events
		$this->db->from('session_admin');
		$this->db->select('*');
		$this->db->where('session_admin_id = '.$session_admin_id);
		$query = $this->db->get();
		
		return $query;
	}
	
}
?>