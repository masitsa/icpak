<?php

class member_model extends CI_Model 
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
	*	Retrieve all member
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_member($table, $where, $per_page, $page)
	{
		//retrieve all member
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('registerDate','DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	
	
	/*
	*	Delete an existing member
	*	@param int $member_id
	*
	*/
	public function delete_member($member_id)
	{
		if($this->db->delete('jos_users', array('member_id' => $member_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a demember_status member
	*	@param int $member_id
	*
	*/
	public function activate_member($member_id)
	{
		$data = array(
				'member_status' => 1
			);
		$this->db->where('member_id', $member_id);
		
		if($this->db->update('jos_users', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an member_status member
	*	@param int $member_id
	*
	*/
	public function deactivate_member($member_id)
	{
		$data = array(
				'member_status' => 0
			);
		$this->db->where('member_id', $member_id);
		
		if($this->db->update('jos_users', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
}
?>