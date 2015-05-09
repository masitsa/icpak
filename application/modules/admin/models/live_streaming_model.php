<?php

class Live_streaming_model extends CI_Model 
{

	public function add_event_streaming()
	{

		// check if there are any streaming event now.

		$checker = $this->check_live_event();

		if($checker == TRUE)
		{

			$data = array(
					'event_name'=>$this->input->post('event_name'),
					'event_description'=>$this->input->post('event_description'),
					'activate_stream'=>$this->input->post('activated'),
					'streamer_link'=>$this->input->post('event_link'),
					'created'=>date('Y-m-d H:i:s'),
					'streaming_status' => 1,
					'created_by'=>1
				);
				
			if($this->db->insert('now_streaming', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else
		{
				return FALSE;
		}
	}
	public function check_live_event()
	{
		//retrieve all users
		$this->db->from('now_streaming');
		$this->db->select('*');
		$this->db->where('streaming_status = 1');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			// remove unaploead this link
			foreach ($query->result() as $value) {
				# code...
				$live_stream_id = $value->live_stream_id;

				$data = array(
					'activate_stream' => 1,
					'streaming_status' => 0
				);
				$this->db->where('live_stream_id', $live_stream_id);
				
				$this->db->update('now_streaming', $data);
				
			return TRUE;
			}
		}
		else
		{
			return TRUE;
		}
	}	

	public function get_now_streaming_meeting()
	{
		//retrieve all users
		$this->db->from('now_streaming');
		$this->db->select('*');
		$this->db->where('streaming_status = 1');
		$query = $this->db->get();

		return $query;
	}
	public function get_livestream_comments($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('now_streaming.event_name, now_streaming.event_description, streaming_comment.*');
		$this->db->where($where);
		$this->db->order_by('streaming_created', 'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
}