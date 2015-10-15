<?php

class Feedback_model extends CI_Model 
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
	public function get_all_feedback($table, $where, $per_page, $page)
	{
		//retrieve all event
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('feedback_id','DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
}
?>