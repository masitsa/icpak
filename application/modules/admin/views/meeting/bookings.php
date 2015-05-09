<?php
		if($meeting_id != NULL)
		{
			$result = '<a href="'.base_url().'all-meetings" class="btn btn-primary pull-right" >Back to meeting list</a> ';
		}
		
		else
		{
			$result = '';
		}
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			

		    if($meeting_id != NULL)
			{
				$result .= 
				'
					<table class="table table-hover table-bordered table-responsive">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Contact person </th>
						  <th>Email</th>
						  <th>Phone</th>
						  <th>Date booked</th>
						  <th>Status</th>
						  <th colspan="5">Actions</th>
						</tr>
					  </thead>
					  <tbody>
				';
			}
			else
			{
				$result .= 
				'
					<table class="table table-hover table-bordered table-responsive">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Meeting Title</th>
						  <th>Contact person </th>
						  <th>Email</th>
						  <th>Phone</th>
						  <th>Date booked</th>
						  <th>Status</th>
						  <th colspan="5">Actions</th>
						</tr>
					  </thead>
					  <tbody>
				';

			}
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
				$booking_id = $row->booking_id;
				$company = $row->company;
				$postal_address = $row->postal_address;
				$postal_code = $row->postal_code;
				$town = $row->town;
				$country_id = $row->country_id;
				$contact_person = $row->contact_person;
				$contact_person_telephone = $row->contact_person_telephone;
				$contact_email = $row->contact_email;
				$payment_id = $row->payment_id;
				$currency_id = $row->currency_id;
				$booking_status = $row->booking_status;
				$meeting_id = $row->meeting_id;
				$booking_created = $row->booking_created;
				$delegates = $this->meeting_model->get_all_delegates($booking_id);
				
				
				

			
				//status
				if($booking_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($booking_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-booking/'.$booking_id.'/'.$meeting_id.'" onclick="return confirm(\'Do you want to activate '.$contact_person.' booking?\');">Activate</a>';
				}
				//create activated status display
				else if($booking_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-booking/'.$booking_id.'/'.$meeting_id.'" onclick="return confirm(\'Do you want to deactivate '.$contact_person.' booking?\');">Deactivate</a>';
				}
				//if users exist display them
				$meeting_booking_description = '';
				if ($delegates->num_rows() > 0)
				{
					$counter = 0;
					$meeting_booking_description .= 
					'
						<table class="table table-hover table-bordered table-responsive">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Delegate Name</th>
							  <th>Email</th>
							  <th>Is Member</th>
							</tr>
						  </thead>
						  <tbody>
					';
					foreach ($delegates->result() as $roww)
					{
						$member_no = $roww->member_no;
						$delegate_id = $roww->delegate_id;
						$is_member = $roww->is_member;
						$title_id = $roww->title_id;
						$title_name = $roww->title_name;
						$surname = $roww->surname;
						$other_names = $roww->other_names;
						$delegate_status = $roww->delegate_status;
						$delegate_email = $roww->delegate_email;
						$booking_id = $roww->booking_id;
						$counter = $counter+1;
						if($is_member == 1)
						{
							$member_status = '<span class="label label-success">member</span>';
						}
						else
						{
							$member_status = '<span class="label label-info">not member</span>';
						}
						$meeting_booking_description .= 
						'<tr>
							<td>'.$counter.'</td>
							<td>'.$title_name.' '.$surname.' '.$other_names.'</td>
							<td>'.$delegate_email.'</td>
							<td>'.$member_status.'</td>
						 </tr>';
					}

					$meeting_booking_description .= 
					'
					  </tbody>
					</table>
					';
				}
				else
				{
					$meeting_booking_description = 'No delegates';
				}
				$count++;
				
				if($meeting_id != NULL)
				{
					$result .= 
					'
						<tr>
							<td>'.$count.'</td>
							<td>'.$contact_person.'</td>
							<td>'.$contact_email.'</td>
							<td>'.$contact_person_telephone.'</td>
							<td>'.date('jS M Y H:i a',strtotime($row->booking_created)).'</td>
							<td>'.$status.'</td>
							<td>
								
								<!-- Button to trigger modal -->
								<a href="#user'.$booking_id.'" class="btn btn-primary" data-toggle="modal">View</a>
								
								<!-- Modal -->
								<div id="user'.$booking_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title">By '.$contact_person.' on '.date('jS M Y H:i a',strtotime($row->booking_created)).'</h4>
											</div>
											
											<div class="modal-body">

												'.$meeting_booking_description.'
											
											</div>
											<div class="modal-footer">
											</div>
										</div>
									</div>
								</div>
							
							</td>
							<td>'.$button.'</td>
							<td><a href="'.site_url().'delete-booking/'.$booking_id.'/'.$meeting_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$contact_person.' booking?\');">Delete</a></td>
						</tr> 
					';
				}
				else
				{

					$result .= 
					'
						<tr>
							<td>'.$count.'</td>
							<td>'.$meeting_title.'</td>
							<td>'.$contact_person.'</td>
							<td>'.$contact_email.'</td>
							<td>'.$contact_person_telephone.'</td>
							<td>'.date('jS M Y H:i a',strtotime($row->booking_created)).'</td>
							<td>'.$status.'</td>
							<td>
								
								<!-- Button to trigger modal -->
								<a href="#user'.$booking_id.'" class="btn btn-primary" data-toggle="modal">View</a>
								
								<!-- Modal -->
								<div id="user'.$booking_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title">By '.$contact_person.' on '.date('jS M Y H:i a',strtotime($row->booking_created)).'</h4>
											</div>
											
											<div class="modal-body">
												<p>
												`'.$meeting_booking_description.'
												</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											</div>
										</div>
									</div>
								</div>
							
							</td>
							<td>'.$button.'</td>
							<td><a href="'.site_url().'delete-booking/'.$booking_id.'/'.$meeting_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$contact_person.' booking?\');">Delete</a></td>
						</tr> 
					';

				}
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