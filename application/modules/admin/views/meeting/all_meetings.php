<div class="span12">
<a href="<?php echo site_url();?>add-meeting" class="btn btn-success pull-right">Add meeting</a>
</div>
<div class="span12">
<?php
		
		$result = '';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered table-responsive">
				  <thead>
					<tr>
					  <th>#</th>
					 <!-- <th>Image</th> -->
					  <th>Category</th>
					  <th>meeting Title</th>
					  <th>Date Created</th>
					  <th>Views</th>
					  <th>Comments</th>
					  <th>Bookings</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			//get all administrators
			$administrators = $this->users_model->get_all_administrators();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$meeting_id = $row->meeting_id;
				$meeting_category_name = $row->meeting_category_name;
				$meeting_title = $row->meeting_title;
				$meeting_status = $row->meeting_status;
				$meeting_views = $row->meeting_views;
				$image = $row->meeting_image;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				$comments = $this->users_model->count_items('meeting_comment', 'meeting_id = '.$meeting_id);
				$bookings = $this->users_model->count_items('meeting_booking', 'meeting_id = '.$meeting_id);
				
				//status
				if($meeting_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($meeting_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-meeting/'.$meeting_id.'" onclick="return confirm(\'Do you want to activate '.$meeting_title.'?\');">Activate</a>';
				}
				//create activated status display
				else if($meeting_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-meeting/'.$meeting_id.'" onclick="return confirm(\'Do you want to deactivate '.$meeting_title.'?\');">Deactivate</a>';
				}
				
				//creators & editors
				if($admins != NULL)
				{
					foreach($admins as $adm)
					{
						$user_id = $adm->user_id;
						
						if($user_id == $created_by)
						{
							$created_by = $adm->first_name;
						}
						
						if($user_id == $modified_by)
						{
							$modified_by = $adm->first_name;
						}
					}
				}
				
				else
				{
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<!-- <td><img src="'.base_url()."assets/images/meetings/thumbnail_".$image.'"></td>-->
						<td>'.$meeting_category_name.'</td>
						<td>'.$meeting_title.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.$meeting_views.'</td>
						<td>'.$comments.'</td>
						<td>'.$bookings.'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'bookings/'.$meeting_id.'" class="btn btn-sm btn-default">Bookings</a></td>
						<td><a href="'.site_url().'edit-meeting/'.$meeting_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td><a href="'.site_url().'comments/'.$meeting_id.'" class="btn btn-sm btn-warning">Comments</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'delete-meeting/'.$meeting_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$meeting_title.'? This will also delete all comments associated with this meeting\');">Delete</a></td>
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
			$result .= "There are no meetings";
		}
		
		echo $result;
?>
<br>
</div>