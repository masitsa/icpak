
<?php	

		$result = '';
		$success = $this->session->userdata('success_message');
		
		if(!empty($success))
		{
			echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
			$this->session->unset_userdata('success_message');
		}
		
		$error = $this->session->userdata('error_message');
		
		if(!empty($error))
		{
			echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
			$this->session->unset_userdata('error_message');
		}

		$session_questions = $this->account_model->get_session_questions($event_session_code);
		
		//if member exist display them
		if ($session_questions->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Name</th>
					  <th>Email</th>
					  <th colspan="2">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			foreach ($session_questions->result() as $row_question)
			{
				$session_question_id = $row_question->session_question_id;
				$session_question = $row_question->session_question;
				$name = $row_question->name;

				$email = $row_question->email;
				$is_member = $row_question->is_member;
				$is_visible = $row_question->is_visible;
				$question_answer = $row_question->question_answer;
				//create deactivated status display
				if($row_question->is_visible == 0)
				{
					$status = '<span class="label label-important">Visible</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-event-session/'.$session_question_id.'" onclick="return confirm(\'Do you want to activate question?\');">Activate</a>';
				}
				//create activated status display
				else if($row_question->is_visible == 1)
				{
					$status = '<span class="label label-success">Not Visible</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-event-session/'.$session_question_id.'" onclick="return confirm(\'Do you want to deactivate question?\');">Deactivate</a>';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$name.'</td>
						<td>'.$email.'</td>
						<td>'.$status.'</td>
						<td>'.$button.'</td>
					</tr> 
					<tr>
						<td colspan="6">
							<form session_question_id="'.$session_question_id.'" enctype="multipart/form-data"  action="'.base_url().'respond-to-question/'.$session_question_id.'"  id = "response_to_question" method="post">
								Question : '.$session_question.'
								<textarea class="cleditor" name="question_answer" placeholder="Post Content"> '.$question_answer.'</textarea>
								 Make Visible <input id="optionsRadios1" type="radio" checked value="1" name="visible_status">Yes <input id="optionsRadios1" type="radio"  value="2" name="visible_status"> No <br/>
								 Remove from list <input id="optionsRadios1" type="radio"  value="1" name="list_status">Yes <input id="optionsRadios1" type="radio" checked value="2" name="list_status"> No <br/>
								<button type="submit" class="btn btn-success" name="submit">Update answer</button>
							</form>
						</td>
					</tr>
				';
			}
			
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no events";
		}
		
		echo $result;
?>
