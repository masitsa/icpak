<?php

class Login_model extends CI_Model 
{
	/*
	*	Check if member has logged in
	*
	*/
	public function check_member_login()
	{
		if($this->session->userdata('member_login_status'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Update user's last login date
	*
	*/
	private function update_user_login($user_id)
	{
		$data['last_login'] = date('Y-m-d H:i:s');
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data); 
	}
	
	/*
	*	Reset a user's password
	*
	*/
	public function reset_password($user_id)
	{
		$new_password = substr(md5(date('Y-m-d H:i:s')), 0, 6);
		
		$data['password'] = md5($new_password);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data); 
		
		return $new_password;
	}
	
	public function register_member_details()
	{
		$newdata = array(
			   'member_first_name'			=> $this->input->post('first_name'),
			   'member_last_name'			=> $this->input->post('last_name'),
			   'member_email'				=> strtolower($this->input->post('email')),
			   'member_password'			=> md5($this->input->post('password')),
			   'gender_id'					=> $this->input->post('gender_id'),
			   'member_phone'				=> $this->input->post('phone'),
			   'member_company'				=> $this->input->post('company'),
			   'created'     				=> date('Y-m-d H:i:s')
		   );

		if($this->db->insert('member', $newdata))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Validate a member's login request
	*
	*/
	public function validate_member($member_email, $member_password)
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('member_email' => strtolower($member_email), 'member_status' => 1, 'member_password' => md5($member_password)));
		$query = $this->db->get('member');
		
		//if users exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			
			//update user's last login date time
			$this->update_member_login($result[0]->member_id);
			return $result;
		}
		
		//if user doesn't exist
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Update user's last login date
	*
	*/
	private function update_member_login($member_id)
	{
		$data['last_login'] = date('Y-m-d H:i:s');
		$this->db->where('member_id', $member_id);
		$this->db->update('member', $data); 
	}
	
	/*
	*	Retrieve a single user by their email
	*	@param int $email
	*
	*/
	public function get_user_by_email($email)
	{
		//retrieve all users
		$this->db->where('member_email', $email);
		$query = $this->db->get('member');
		
		return $query;
	}
	
	public function reset_member_password()
	{
		$email = $this->input->post('member_email');
		//reset password
		$result = md5(date("Y-m-d H:i:s"));
		$pwd2 = substr($result, 0, 6);
		$pwd = md5($pwd2);
		
		$data = array(
				'member_password' => $pwd
			);
		$this->db->where('member_email', $email);
		
		if($this->db->update('member', $data))
		{
			//email the password to the user
			$user_details = $this->get_user_by_email($email);
			
			$user = $user_details->row();
			$user_name = $user->member_username;
			
			$cc = NULL;
			$name = $user_name;
			
			$subject = 'You requested a password reset';
			$message = '<p>You have password has been successfully reset.</p><p>Next time you log in to Nairobisingles please use <strong>'.$pwd2.'</strong> as your password. You can change your password to something more memorable in your profile section once you log in.</p>';
			
			$button = '<p><a class="mcnButton " title="Sign in" href="'.site_url().'sign-in" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Sign in</a></p>';
			$shopping = '<p>If you have any queries or concerns do not hesitate to get in touch with us at <a href="mailto:info@nairobisingles.com">info@nairobisingles.com</a> </p>';
			$sender_email = 'info@nairobisingles.com';
			$from = 'Nairobisingles';
			
			$response = $this->email_model->send_mandrill_mail($email, $name, $subject, $message, $sender_email, $shopping, $from, $button, $cc);
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function send_account_verification_email()
	{
		$email = $this->input->post('email');
		$name = $this->input->post('first_name');
		$cc = NULL;
		
		$subject = 'Please activate your account';
		$message = '<p>Welcome to Icpak Live.</p>
		<p>Please activate your account in order to access the full functions of our mobile application. You will be able to:
			<ol>
				<li>Get live feeds from Icpak</li>
				<li>Stream live events</li>
				<li>Watch previous meetings</li>
				<li>Post questions during seminars</li>
			</ol>
		</p>
		<p>To activate your account click on the button below</p>';
		
		$button = '<p><a class="mcnButton " title="Activate account" href="'.site_url().'mobile/login/activate_account" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Activate account</a></p>';
		$shopping = '<p>If you have any queries or concerns do not hesitate to get in touch with us at <a href="mailto:info@icpak.com">info@icpak.com</a> </p>';
		$sender_email = 'info@icpak.com';
		$from = 'Icpak';
		
		$response = $this->email_model->send_mandrill_mail($email, $name, $subject, $message, $sender_email, $shopping, $from, $button, $cc);
		
		return TRUE;
	}
}