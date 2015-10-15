<?php

class News_model extends CI_Model 
{

	/*
	*	Update user's last login date
	*
	*/
	public function get_news()
	{
		$this->db->where('catid = 38 AND year(created) >= 2015');
	 	$this->db->order_by('created','DESC');
		$query = $this->db->get('jos_content');
		
		return $query;
	}

	/*
	*	Update user's last login date
	*
	*/
	public function get_ecconect_news()
	{
		$this->db->where('catid = 46 AND year(created) >= 2015');
	 	$this->db->order_by('created','DESC');
		$query = $this->db->get('jos_content');
		
		return $query;
	}
	public function get_news_detail($id)
	{
		$this->db->where('id = '.$id);
		$query = $this->db->get('jos_content');
		return $query;
	}

	public function count_unread_news()
	{
		$this->db->where('catid = 46 AND year(created) >= 2015');
	 	$this->db->order_by('created','DESC');
		$query = $this->db->get('jos_content');	

		return $query->num_rows();	
	}

}