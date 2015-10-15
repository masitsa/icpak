<?php

class event_session_model extends CI_Model 
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
	public function get_all_event_session($table, $where, $per_page, $page)
	{
		//retrieve all event
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('event_session_id','DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	
	
	/*
	*	Delete an existing event
	*	@param int $event_session_id
	*
	*/
	public function delete_event_session($event_session_id)
	{
		if($this->db->delete('event_session', array('event_session_id' => $event_session_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deevent_session_status event
	*	@param int $event_session_id
	*
	*/
	public function activate_event_session($event_session_id)
	{
		$data = array(
				'event_session_status' => 1
			);
		$this->db->where('event_session_id', $event_session_id);
		
		if($this->db->update('event_session', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an event_session_status event
	*	@param int $event_session_id
	*
	*/
	public function deactivate_event_session($event_session_id)
	{
		$data = array(
				'event_session_status' => 0
			);
		$this->db->where('event_session_id', $event_session_id);
		
		if($this->db->update('event_session', $data))
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
	public function add_event_session()
	{
		$data = array(
				'event_session_name'=>ucwords(strtolower($this->input->post('event_session_name'))),
				'event_session_code'=>$this->input->post('event_session_code'),
				'event_id'=>$this->input->post('event_id'),
				'event_session_status'=>$this->input->post('event_session_status')
			);
			
		if($this->db->insert('event_session', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	Edit an existing event
	*	@param int $event_session_id
	*
	*/
	public function edit_event_session($event_session_id)
	{
		$data = array(
					'event_session_name'=>ucwords(strtolower($this->input->post('event_session_name'))),
					'event_session_code'=>$this->input->post('event_session_code'),
					'event_id'=>$this->input->post('event_id'),
					'event_session_status'=>$this->input->post('event_session_status')
				);
		
		
		
		$this->db->where('event_session_id', $event_session_id);
		
		if($this->db->update('event_session', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function get_event_session($event_session_id)
	{
		//retrieve all events
		$this->db->from('event_session');
		$this->db->select('*');
		$this->db->where('event_session_id = '.$event_session_id);
		$query = $this->db->get();
		
		return $query;
	}
	public function get_active_sessions()
	{
		//retrieve all events
		$this->db->from('event_session');
		$this->db->select('*');
		// $this->db->where('event_session_status = 0');
		$query = $this->db->get();
		
		return $query;

	}
}
?>