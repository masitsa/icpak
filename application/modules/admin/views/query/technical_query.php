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
					  <th>Member No.</th>
					  <th>Member Name</th>
					  <th>Subject</th>
					  <th>Date Posted</th>
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
				$member_username = $row->member_username;
				$member_other_names = $row->member_other_names;
				$member_email = $row->member_email;
				$member_phone = $row->member_phone;
				$member_status = $row->member_status;
				$member_company = $row->member_company;
				$query_subject = $row->query_subject;
				$query_text = $row->query_text;
				$query_date = $row->query_date;
				$query_status = $row->query_status;
				$query_id = $row->query_id;
				$member_no = $row->member_no;
				$query_response = $row->query_response;
				
				
				$response = '';
				if(!empty($query_response))
				{
					$response .= '<span class="bold">  Response</span>
							<textarea class="cleditor" name="post_content" placeholder="Post Content">'.$query_response.'</textarea>';
				}	
				else
				{
					$response .= '<span class="bold"> Response </span>
							<textarea class="cleditor" name="post_content" placeholder="Post Content"></textarea>';
				}
				//status
				if($query_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($query_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-query/'.$query_id.'" onclick="return confirm(\'Do you want to activate '.$query_subject.'?\');">Activate</a>';
				}
				//create activated status display
				else if($query_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-query/'.$query_id.'" onclick="return confirm(\'Do you want to deactivate '.$query_subject.'?\');">Deactivate</a>';
				}
				
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$member_no.'</td>
						<td>'.$member_username.' '.$member_other_names.'</td>
						<td>'.$query_subject.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->query_date)).'</td>
						<td>'.$status.'</td>
						<td>
							<a  class="btn btn-sm btn-success" id="open_query'.$query_id.'" onclick="get_query_details('.$query_id.');">View query detail</a>
							<a  class="btn btn-sm btn-warning" id="close_query'.$query_id.'" style="display:none;" onclick="close_query_detail('.$query_id.');">Close query details</a></td>
						</td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'delete-query/'.$query_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$query_subject.'? .\');">Delete</a></td>
					</tr> 
				';
				$result .=
						'<tr id="query_detail'.$query_id.'" style="display:none;">

							<td colspan="9">
								<div class="row">
									<div class="col-md-12">
										<p><span class="bold">Query : </span>
										'.$query_text.'
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										'.$response.'
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<button class="btn btn-success align-center" type="submit"> Submit and send response</button>
									</div>
								</div>
							</td>

						</tr>';
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


  <script type="text/javascript">

	function get_query_details(query_id){
		var myTarget2 = document.getElementById("query_detail"+query_id);
		var button = document.getElementById("open_query"+query_id);
		var button2 = document.getElementById("close_query"+query_id);

		myTarget2.style.display = '';
		button.style.display = 'none';
		button2.style.display = '';
	}
	function close_query_detail(query_id){

		var myTarget2 = document.getElementById("query_detail"+query_id);
		var button = document.getElementById("open_query"+query_id);
		var button2 = document.getElementById("close_query"+query_id);

		myTarget2.style.display = 'none';
		button.style.display = '';
		button2.style.display = 'none';
	}
  </script>