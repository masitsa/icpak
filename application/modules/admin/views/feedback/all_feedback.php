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
		if ($feedback->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Name</th>
					  <th>Email Address</th>
					  <th>Status</th>
					  <th colspan="1">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			foreach ($feedback->result() as $row)
			{
				$feedback_id = $row->feedback_id;
				$feedback_text = $row->feedback_text;
				$name = $row->name;
				$email = $row->email_address;
				$feedback_status = $row->feedback_status;
				//create deactivated status display
				if($row->feedback_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-event/'.$feedback_id.'" onclick="return confirm(\'Do you want to activate ?\');">Activate</a>';
				}
				//create activated status display
				else if($row->feedback_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'deactivate-event/'.$feedback_id.'" onclick="return confirm(\'Do you want to deactivate ?\');">Deactivate</a>';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$name.'</td>
						<td>'.$email.'</td>
						<td>'.$status.'</td>
						<td>
							<a  class="btn btn-sm btn-danger" id="open_visit'.$feedback_id.'" onclick="get_visit_trail('.$feedback_id.');">Open Question Trail</a>
							<a  class="btn btn-sm btn-danger" id="close_visit'.$feedback_id.'" style="display:none;" onclick="close_visit_trail('.$feedback_id.');">Close Question trail</a></td>
						</td>
					</tr> 
				';
			}
				$result .=
						'<tr id="visit_trail'.$feedback_id.'" style="display:none;">

							<td colspan="5">
								'.$feedback_text.'
							</td>
						</tr>';
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

<script type="text/javascript">

	function get_visit_trail(feedback_id){

		var myTarget2 = document.getElementById("visit_trail"+feedback_id);
		var button = document.getElementById("open_visit"+feedback_id);
		var button2 = document.getElementById("close_visit"+feedback_id);

		myTarget2.style.display = '';
		button.style.display = 'none';
		button2.style.display = '';
	}
	function close_visit_trail(feedback_id){

		var myTarget2 = document.getElementById("visit_trail"+feedback_id);
		var button = document.getElementById("open_visit"+feedback_id);
		var button2 = document.getElementById("close_visit"+feedback_id);

		myTarget2.style.display = 'none';
		button.style.display = '';
		button2.style.display = 'none';
	}
  </script>