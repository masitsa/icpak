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

	/*
	*	Reset a user's password
	*
	*/
	public function get_profile_details()
	{
		// 9530
		$this->db->where('id = '.$this->session->userdata('member_id'));
		$query = $this->db->get('jos_users');
		
		return $query;
	}
	public function get_cpd_info($member_no)
	{
		$this->db->select('year AS years');
		$this->db->where('year >= "2012" AND `RegNo` = "'.$member_no.'"');
		$this->db->group_by('year');
		$this->db->order_by('year','ASC');
		$query = $this->db->get('vw_cpehours');
		
		return $query;
	}
	public function get_cpd_details($year,$member_no)
	{
		$this->db->select('*');
		$this->db->where('year <= "'.$year.'" AND `RegNo` = "'.$member_no.'"');
		$query = $this->db->get('vw_cpehours');
		
		return $query;
	}
	public function get_from_question($member_id)
	{
		$this->db->select('*');
		$this->db->where('member_id = '.$member_id);
		$query = $this->db->get('cpd_question');
		
		return $query;
	}

	public function register_member_details()
	{
		// AND username = "'.$this->input->post('member_no').'"
		$this->db->select('*');
		$this->db->where('email = "'.$this->input->post('email').'" ');
		$query = $this->db->get('jos_users');
		
		return $query;

		
	}
	public function post_cpd_query()
	{
		$this->db->select('*');
		$this->db->where('member_id = '.$this->session->userdata('member_id').' AND question = "'.$this->input->post('question').'" ');
		$query = $this->db->get('cpd_question');
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			$newdata = array(
			   'question' =>  $this->input->post('question'),
			   'member_id' => $this->input->post('member_id'),
			   'date_asked'	=> date('Y-m-d H:i:s')
		   	);

			if($this->db->insert('cpd_question', $newdata))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}

		}

		

	}

	// public function register_member_details()
	// {
	// 	$newdata = array(
	// 		   'member_first_name'			=> $this->input->post('first_name'),
	// 		   'member_last_name'			=> $this->input->post('last_name'),
	// 		   'member_email'				=> strtolower($this->input->post('email')),
	// 		   'member_password'			=> md5($this->input->post('password')),
	// 		   'gender_id'					=> $this->input->post('gender_id'),
	// 		   'member_no'					=> $this->input->post('member_no'),
	// 		   'member_phone'				=> $this->input->post('phone'),
	// 		   'member_company'				=> $this->input->post('company'),
	// 		   'created'     				=> date('Y-m-d H:i:s')
	// 	   );

	// 	if($this->db->insert('member', $newdata))
	// 	{
	// 		return TRUE;
	// 	}
	// 	else
	// 	{
	// 		return FALSE;
	// 	}
	// }


	
	/*
	*	Validate a member's login request
	*
	*/
	// public function validate_member($member_email, $member_password)
	// {
	// 	//select the user by email from the database
	// 	$this->db->select('*');
	// 	$this->db->where(array('member_email' => strtolower($member_email), 'member_status' => 1, 'member_password' => md5($member_password)));
	// 	$query = $this->db->get('member');
		
	// 	//if users exists
	// 	if ($query->num_rows() > 0)
	// 	{
	// 		$result = $query->result();
			
	// 		//update user's last login date time
	// 		$this->update_member_login($result[0]->member_id);
	// 		return $result;
	// 	}
		
	// 	//if user doesn't exist
	// 	else
	// 	{
	// 		return FALSE;
	// 	}
	// }


	/*
	*	Validate a member's login request
	*
	*/
	public function validate_member($member_no, $member_password)
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('username' =>strtolower($member_no),'password' => md5($member_password)));
		$query = $this->db->get('jos_users');
		
		//if users exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			
			//update user's last login date time
			// $this->update_member_login($result[0]->member_id);
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
			$message = '<p>You have password has been successfully reset.</p><p>Next time you log in to ICPAK LIVE please use <strong>'.$pwd2.'</strong> as your password. You can change your password to something more memorable in your profile section once you log in.</p>';
			
			$button = '<p><a class="mcnButton " title="Sign in" href="'.site_url().'sign-in" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Sign in</a></p>';
			$shopping = '<p>If you have any queries or concerns do not hesitate to get in touch with us at <a href="mailto:info@nairobisingles.com">info@nairobisingles.com</a> </p>';
			$sender_email = 'icpak@icpak.com';
			$from = 'ICPAK LIVE';
			
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
		
		$this->db->where('email', $email);
		$query = $this->db->get('jos_users');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$name = $row->name;
			$id = $row->id;
			$username = $row->username;
			
			$cc = NULL;

			$token = $this->generateRandomString($email,10);
			
			$subject = 'Please activate your account';
			$message = '<p> Hello '.$name.',</p>
			<p>A request has been made to reset your ICPAK account password.</p>
			<p>To activate your account click on the button below</p>
			<p><a   href="http://www.icpak.com/index.php?option=com_resetpassword&task=confirmtoken&token='.$token.'" target="_blank" >Activate account</a></p>';
			
			$shopping = '<p>If you have any queries or concerns do not hesitate to get in touch with us at <a href="mailto:icpak@icpak.com">icpak@icpak.com</a> </p>';
			$sender_email = 'icpak@icpak.com';
			$from = 'ICPAK LIVE';
			

			// upadte the table 

			

			$today = date('Y-m-d H:i:s');
			$newTime = strtotime('+2 weeks', strtotime($today));
			
		   	$this->db->where('user_id',$id);
			$this->db->delete('jos_resetpasswordtoken');

			$newdata = array(
			   'user_id'		=> $id,
			   'token'		=> $token,
			   'expire'			=> $today
		   	);
			$this->db->insert('jos_resetpasswordtoken', $newdata);

			$newdata = array(
			   'user_id'		=> $id,
			   'date'			=> $today
		   	);
			$this->db->insert('jos_resetpasswordlog', $newdata);

			// $response = $this->email_model->send_mandrill_mail($email, $name, $subject, $message, $sender_email, $shopping, $from, $button, $cc);
			include ('mailer/class.phpmailer.php');

			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->CharSet = 'UTF-8';
			$mail->Host       = "mail.safaricombusiness.co.ke"; // SMTP server example
			$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
			$mail->SMTPAuth   = false;                  // enable SMTP authentication
			$mail->Port       = 25;
			                    // set the SMTP port for the GMAIL server
			$mail->SetFrom("memberservices@icpak.com");

			$mail->AddAddress($email);


			$mail->IsHTML(true);
			$mail->Subject = 'ICPAK LIVE activate account';
			$mail->Body = $message;


			$mail->Send();
						
			return TRUE;
		}
		
	}
	public function generateRandomString($email,$length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString.md5($email);
	}
}