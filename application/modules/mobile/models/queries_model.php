<?php

class Queries_model extends CI_Model 
{
	
	
	public function post_technical_query()
	{
		$newdata = array(
			   'query_subject'			=> $this->input->post('query_subject'),
			   'query_text'			=> $this->input->post('query_text'),
			   'query_text'			=> $this->input->post('member_id'),
			   'query_item_id'			=> 1,
			   'query_date'			=> date('Y-m-d')
		   );

		if($this->db->insert('query', $newdata))
		{

			$email = $this->input->post('member_email');
		
			
			$this->db->where('member_email', $email);
			$query = $this->db->get('member');
			
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$member_id = $row->member_id;
				$member_first_name = $row->member_first_name;
				$member_last_name = $row->member_last_name;
				$cc = NULL;
				
				$subject = 'Query Received';
				$message = '<p>Hi '.$member_first_name.',</p>
				<p> You query has been received and our staff member is working on a response for you.</p>
				<p>The response shall be sent to this email within 24 hours</p>
				<p>Thank you for using this service</p>';
				
				$button = '';
				$name = 'ICPAK';
				$shopping = '<p>If you have any queries or concerns do not hesitate to get in touch with us at <a href="mailto:info@icpak.com">info@icpak.com</a> </p>';
				$sender_email = 'info@icpak.com';
				$from = 'ICPAK';
				
				$response = $this->email_model->send_mandrill_mail($email, $name, $subject, $message, $sender_email, $shopping, $from, $button, $cc);
				
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	public function post_standards_query()
	{
		$newdata = array(
			   'query_subject'		=> $this->input->post('standard_query_subject'),
			   'query_text'			=> $this->input->post('standards_query_text'),
			   'query_text'			=> $this->input->post('member_id'),
			   'query_item_id'			=> 2,
			   'query_date'			=> date('Y-m-d')
		   );

		if($this->db->insert('query', $newdata))
		{

			$email = $this->input->post('member_email');
		
			
			$this->db->where('member_email', $email);
			$query = $this->db->get('member');
			
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$member_id = $row->member_id;
				$member_first_name = $row->member_first_name;
				$member_last_name = $row->member_last_name;
				$cc = NULL;
				
				$subject = 'Query Received';
				$message = '<p>Hi '.$member_first_name.',</p>
				<p> You query has been received and our staff member is working on a response for you.</p>
				<p>The response shall be sent to this email within 24 hours</p>
				<p>Thank you for using this service</p>';
				
				$button = '';
				$name = 'ICPAK';
				$shopping = '<p>If you have any queries or concerns do not hesitate to get in touch with us at <a href="mailto:info@icpak.com">info@icpak.com</a> </p>';
				$sender_email = 'info@icpak.com';
				$from = 'ICPAK';
				
				$response = $this->email_model->send_mandrill_mail($email, $name, $subject, $message, $sender_email, $shopping, $from, $button, $cc);
				
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	public function post_streaming_event_query()
	{

		$newdata = array(
		   'streaming_comment_user'		=> $this->input->post('streaming_comment_user'),
		   'streaming_comment_email'			=> $this->input->post('streaming_comment_email'),
		   'streaming_comment_description'			=> $this->input->post('streaming_comment_description'),
		   'speakers_name'			=>  $this->input->post('speakers_name'),
		   'streaming_id' => $this->input->post('streaming_id'),
		   'streaming_created'			=> date('Y-m-d H:i:s')
	   );

		if($this->db->insert('streaming_comment', $newdata))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function post_contact_us()
	{
		$newdata = array(
		   'name'		=> $this->input->post('name'),
		   'email'			=> $this->input->post('email'),
		   'message'			=> $this->input->post('message'),
		   'created'			=> date('Y-m-d H:i:s')
	   );

		if($this->db->insert('contact_us', $newdata))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}