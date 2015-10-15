<?php

class event_model extends CI_Model 
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
	public function get_all_event($table, $where, $per_page, $page)
	{
		//retrieve all event
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('event_id','DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	
	
	/*
	*	Delete an existing event
	*	@param int $event_id
	*
	*/
	public function delete_event($event_id)
	{
		if($this->db->delete('icpak_event', array('event_id' => $event_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deevent_status event
	*	@param int $event_id
	*
	*/
	public function activate_event($event_id)
	{
		$data = array(
				'event_status' => 1
			);
		$this->db->where('event_id', $event_id);
		
		if($this->db->update('icpak_event', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an event_status event
	*	@param int $event_id
	*
	*/
	public function deactivate_event($event_id)
	{
		$data = array(
				'event_status' => 0
			);
		$this->db->where('event_id', $event_id);
		
		if($this->db->update('icpak_event', $data))
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
	public function add_event()
	{
		$data = array(
				'event_name'=>ucwords(strtolower($this->input->post('event_name'))),
				'event_status'=>$this->input->post('event_status')
			);
			
		if($this->db->insert('icpak_event', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	Edit an existing event
	*	@param int $event_id
	*
	*/
	public function edit_event($event_id)
	{
		$data = array(
					'event_name'=>ucwords(strtolower($this->input->post('event_name'))),
					'event_status'=>$this->input->post('event_status')
				);
		
		
		
		$this->db->where('event_id', $event_id);
		
		if($this->db->update('icpak_event', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function get_event($event_id)
	{
		//retrieve all events
		$this->db->from('icpak_event');
		$this->db->select('*');
		$this->db->where('event_id = '.$event_id);
		$query = $this->db->get();
		
		return $query;
	}
	public function get_active_events()
	{
		$this->db->from('icpak_event');
		$this->db->select('*');
		$this->db->where('event_status = 0');
		$query = $this->db->get();
		
		return $query;
	}
}
?>