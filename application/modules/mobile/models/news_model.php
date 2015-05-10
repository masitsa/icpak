<?php

class News_model extends CI_Model 
{

	/*
	*	Update user's last login date
	*
	*/
	public function get_news()
	{
		$this->db->where('catid = 38');
		// $this->db->table(''); 
		// $this->db->order_by('blog_category_name');
		$query = $this->db->get('jos_content');
		
		return $query;
	}

	/*
	*	Update user's last login date
	*
	*/
	public function get_ecconect_news()
	{
		$this->db->where('catid = 46');
		// $this->db->table(''); 
		// $this->db->order_by('blog_category_name');
		$query = $this->db->get('jos_content');
		
		return $query;
	}
	public function get_news_detail($id)
	{

		$this->db->where('id = '.$id);
		$query = $this->db->get('jos_content');
		return $query;
	}

}