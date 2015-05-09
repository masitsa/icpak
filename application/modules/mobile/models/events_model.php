<?php

class Events_model extends CI_Model 
{

	/*
	*	Update user's last login date
	*
	*/
	public function get_events()
	{
		$this->db->where('date1 >= "'.date('Y-m-d').'"');
		$this->db->order_by('date1','ASC');
		$query = $this->db->get('jos_simplecal');
		
		return $query;
	}


}