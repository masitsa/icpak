<?php
		if($meeting_id != NULL)
		{
			$result = ' <p><strong>Meeting Title: </strong>'.$title.'</p>';
		}
		
		else
		{
			$result = '';
		}
		
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
					  <th>Meeting Title</th>
					  <th>Viewer Name</th>
					  <th>meeting Date</th>
					  <th>Comment Date</th>
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
				$meeting_comment_id = $row->meeting_comment_id;
				$meeting_comment_id = $row->meeting_comment_id;
				$meeting_title = $row->meeting_title;
				$meeting_comment_status = $row->meeting_comment_status;
				$meeting_comment_user = $row->meeting_comment_user;
				$meeting_comment_description = $row->meeting_comment_description;
				$image = $row->meeting_image;
				
				//status
				if($meeting_comment_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($meeting_comment_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-comment/'.$meeting_comment_id.'/'.$meeting_id.'" onclick="return confirm(\'Do you want to activate '.$meeting_comment_user.' comment?\');">Activate</a>';
				}
				//create activated status display
				else if($meeting_comment_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-comment/'.$meeting_comment_id.'/'.$meeting_id.'" onclick="return confirm(\'Do you want to deactivate '.$meeting_comment_user.' comment?\');">Deactivate</a>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$meeting_title.'</td>
						<td>'.$meeting_comment_user.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->comment_created)).'</td>
						<td>'.$status.'</td>
						<td>
							
							<!-- Button to trigger modal -->
							<a href="#user'.$meeting_comment_id.'" class="btn btn-primary" data-toggle="modal">View</a>
							
							<!-- Modal -->
							<div id="user'.$meeting_comment_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">By '.$meeting_comment_user.' on '.date('jS M Y H:i a',strtotime($row->comment_created)).'</h4>
										</div>
										
										<div class="modal-body">
											<p>
											`'.$meeting_comment_description.'
											</p>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											'.$button.'
											<a href="'.site_url().'delete-comment/'.$meeting_comment_id.'/'.$meeting_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$meeting_comment_user.' comment?\');">Delete</a>
										</div>
									</div>
								</div>
							</div>
						
						</td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'delete-comment/'.$meeting_comment_id.'/'.$meeting_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$meeting_comment_user.' comment?\');">Delete</a></td>
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