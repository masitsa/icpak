<?php

class Account_model extends CI_Model 
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
	*	Retrieve all users
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_assigned_sessions($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('event_session.event_session_id', 'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	public function get_session_questions($event_session_code)
	{
		//retrieve all users
		$this->db->from('session_question');
		$this->db->select('*');
		$this->db->where('event_session_code = "'.$event_session_code.'"');
		$query = $this->db->get();
		
		return $query;
	}
	public function respond_to_question($question_id)
	{
		$data['question_answer'] = $this->input->post('question_answer');
		
		$this->db->where('session_question_id', $question_id);
		
		if($this->db->update('session_question', $data))
		{
			$return['result'] = TRUE;
		}
		else{
			$return['result'] = FALSE;
			$return['message'] = 'Oops something went the response could not be sent. Please try again';
		}
		return $return;
	}
}
?>