 <a href="<?php echo base_url();?>add-session-admin" class="btn btn-success pull-right">Add session admin</a> 
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
		
		//if member exist display them
		if ($event_session->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Session Name</th>
					  <th>Session Code</th>
					  <th>Admin Name</th>
					  <th colspan="2">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			foreach ($event_session->result() as $row)
			{
				$event_id = $row->event_id;
				

				$event_session_id = $row->event_session_id;
				$event_session_name = $row->event_session_name;
				$first_name = $row->first_name;
				$other_names = $row->other_names;
				$session_admin_id = $row->session_admin_id;
				$event_session_code = $row->event_session_code;
				$button = '<a class="btn btn-info" href="'.site_url().'delete-session-admin/'.$session_admin_id.'" onclick="return confirm(\'Do you want to deactivate '.$first_name.'?\');">Remove admin</a>';
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$event_session_name.'</td>
						<td>'.$event_session_code.'</td>
						<td>'.$first_name.' '.$other_names.'</td>
						<td>'.$button.'</td>
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