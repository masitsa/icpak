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
		if ($event->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Event Name</th>
					  <th>Status</th>
					  <th colspan="2">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			foreach ($event->result() as $row)
			{
				$event_id = $row->event_id;
				$event_name = $row->event_name;
				$event_status = $row->event_status;
				//create deactivated status display
				if($row->event_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-event/'.$event_id.'" onclick="return confirm(\'Do you want to activate '.$event_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($row->event_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-event/'.$event_id.'" onclick="return confirm(\'Do you want to deactivate '.$event_name.'?\');">Deactivate</a>';
				}
				$button2 = '<a class="btn btn-success" href="'.site_url().'edit-event/'.$event_id.'" >Edit Event</a>';
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$event_name.'</td>
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