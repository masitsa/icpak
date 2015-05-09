<?php
		
		$result = '<a href="'.site_url().'add-meeting-category" class="btn btn-success pull-right">Add Meeting Category</a>';
		
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
					  <th>Category Name</th>
					  <th>Parent</th>
					  <th>Date Created</th>
					  <th>Last Modified</th>
					  <th>Posts</th>
					  <th>Status</th>
					  <th colspan="3">Actions</th>
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
				$meeting_category_parent = $row->meeting_category_parent;
				$meeting_category_id = $row->meeting_category_id;
				$meeting_category_name = $row->meeting_category_name;
				$meeting_category_status = $row->meeting_category_status;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				$posts = $this->users_model->count_items('meeting', 'meeting_category_id = '.$meeting_category_id);
				
				if($meeting_category_parent == 0)
				{
					$parent = 'No Parent';
				}
				
				else
				{
					$parent = '-';
					foreach($categories_query->result() as $res)
					{
						if($meeting_category_parent == $res->meeting_category_id)
						{
							$parent = $res->meeting_category_name;
							$break;
						}
					}
				}
				
				//status
				if($meeting_category_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($meeting_category_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-meeting-category/'.$meeting_category_id.'" onclick="return confirm(\'Do you want to activate '.$meeting_category_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($meeting_category_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-meeting-category/'.$meeting_category_id.'" onclick="return confirm(\'Do you want to deactivate '.$meeting_category_name.'?\');">Deactivate</a>';
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
						<td>'.$meeting_category_name.'</td>
						<td>'.$parent.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
						<td>'.$posts.'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'edit-meeting-category/'.$meeting_category_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'delete-meeting-category/'.$meeting_category_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$meeting_category_name.'? This will delete all posts associated with this category.\');">Delete</a></td>
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
			$result .= "There are no meeting categories";
		}
		
		echo $result;
?>