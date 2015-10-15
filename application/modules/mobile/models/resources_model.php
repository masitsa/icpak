<?php

class Resources_model extends CI_Model 
{

	/*
	*	Update user's last login date
	*
	*/
	public function get_resources()
	{
		$this->db->where('show_in = 1');
		// $this->db->table(''); 
		// $this->db->order_by('blog_category_name');
		$query = $this->db->get('kb_article');
		
		return $query;
	}

	public function get_resources_detail($id)
	{

		$this->db->where('article_id = '.$id);
		$query = $this->db->get('kb_article');
		return $query;
	}
	public function get_attachments($id)
	{

		$this->db->select('kb_download.download_id as kb_download, kb_download.ext as ext, kb_download.download_hits as hits, kb_download.download_title as  download_title, kb_attachment.article_id  as article_id');
		$this->db->where('kb_download.download_id = kb_attachment.download_id AND kb_attachment.article_id = '.$id);
		$this->db->order_by('kb_download.download_title', 'ASC');
		$query = $this->db->get('kb_download,kb_attachment');
		return $query;

	}

}