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
				$member_username = $row->member_username;
				$member_other_names = $row->member_other_names;
				$member_email = $row->member_email;
				$member_phone = $row->member_phone;
				$member_status = $row->member_status;
				$member_company = $row->member_company;
				$member_id = $row->member_id;
				$member_no = $row->member_no;
				//create deactivated status display
				if($row->member_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-member/'.$member_id.'" onclick="return confirm(\'Do you want to activate '.$member_username.'?\');">Activate</a>';
				}
				//create activated status display
				else if($row->member_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-member/'.$member_id.'" onclick="return confirm(\'Do you want to deactivate '.$member_username.'?\');">Deactivate</a>';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$member_no.'</td>
						<td>'.$row->member_username.' '.$row->member_other_names.'</td>
						<td>'.$member_email.'</td>
						<td>'.$member_phone.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_login)).'</td>
						<td>'.$status.'</td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'delete-member/'.$member_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$member_username.'?\');">Delete</a></td>
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