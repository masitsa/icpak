 <a href="<?php echo base_url();?>add-event-session" class="btn btn-success pull-right">Add event session</a> 
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
					  <th>Event Name</th>
					  <th>Event Session Name</th>
					  <th>Event Session Code</th>
					  <th>Status</th>
					  <th colspan="2">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			foreach ($event_session->result() as $row)
			{
				$event_id = $row->event_id;
				$event_name = $row->event_name;
				$event_session_status = $row->event_session_status;

				$event_session_id = $row->event_session_id;
				$event_session_name = $row->event_session_name;
				$event_session_code = $row->event_session_code;
				//create deactivated status display
				if($row->event_session_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-event-session/'.$event_session_id.'" onclick="return confirm(\'Do you want to activate '.$event_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($row->event_session_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-event-session/'.$event_session_id.'" onclick="return confirm(\'Do you want to deactivate '.$event_name.'?\');">Deactivate</a>';
				}
				$button2 = '<a class="btn btn-success" href="'.site_url().'edit-event-session/'.$event_session_id.'" >Edit Session</a>';
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$event_name.'</td>
						<td>'.$event_session_name.'</td>
						<td>'.$event_session_code.'</td>
						<td>'.$status.'</td>
						<td>'.$button2.'</td>
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