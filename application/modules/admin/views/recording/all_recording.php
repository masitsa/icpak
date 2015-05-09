<?php	
		$result = '<a href="'.site_url().'add-recording" class="btn btn-success pull-right">Add Recording</a>';
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
		
		//if recording exist display them
		if ($recording->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Recording title</th>
					  <th>Date Created</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			foreach ($recording->result() as $row)
			{
				$recording_id = $row->recording_id;
				$recording_title = $row->recording_title;
				//create derecording_status status display
				if($row->recording_status == 0)
				{
					$status = '<span class="label label-important">Derecording_status</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-recording/'.$recording_id.'" onclick="return confirm(\'Do you want to activate '.$recording_title.'?\');">Activate</a>';
				}
				//create recording_status status display
				else if($row->recording_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-recording/'.$recording_id.'" onclick="return confirm(\'Do you want to deactivate '.$recording_title.'?\');">Deactivate</a>';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->recording_title.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'edit-recording/'.$recording_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'delete-recording/'.$recording_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$recording_title.'?\');">Delete</a></td>
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
			$result .= "There are no recording";
		}
		
		echo $result;
?>