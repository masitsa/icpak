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
		if ($member->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Member No.</th>
					  <th>Name</th>
					  <th>Email</th>
					  <th>Phone number</th>					  
					  <th>Last Login</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			foreach ($member->result() as $row)
			{
				$member_no = $row->username;
				$name = $row->name;
				$email = $row->email;
				$id = $row->id;
				$lastvisitDate = $row->lastvisitDate;
				$registerDate = $row->registerDate;
				$usertype = $row->usertype;
				//create deactivated status display
				if($row->block == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-member/'.$id.'" onclick="return confirm(\'Do you want to activate '.$name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($row->block == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-member/'.$id.'" onclick="return confirm(\'Do you want to deactivate '.$name.'?\');">Deactivate</a>';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$member_no.'</td>
						<td>'.$row->name.' </td>
						<td>'.$email.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->registerDate)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->lastvisitDate)).'</td>
						<td>'.$status.'</td>
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
			$result .= "There are no member";
		}
		
		echo $result;
?>