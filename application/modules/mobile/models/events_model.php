<?php

class Events_model extends CI_Model 
{

	/*
	*	Update user's last login date
	*
	*/
	public function get_events()
	{
		$this->db->where('date1 >= "'.date('Y-m-d').'" AND jos_simplecal_categories.categoryID = jos_simplecal.categoryID');
		$this->db->order_by('date1','ASC');
		$query = $this->db->get('jos_simplecal,jos_simplecal_categories');
		
		return $query;
	}
	public function get_event_detail($id)
	{
		$this->db->where('jos_simplecal_categories.categoryID = jos_simplecal.categoryID AND id = '.$id);
		$query = $this->db->get('jos_simplecal,jos_simplecal_categories');
		return $query;

	}

}