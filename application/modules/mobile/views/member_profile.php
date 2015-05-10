<?php
if ($profile_query->num_rows() > 0)
{
	$result = $profile_query->result();
	$member_email = $result[0]->member_email;
	$member_id = $result[0]->member_id;
	$member_first_name = $result[0]->member_first_name;
	$member_last_name = $result[0]->member_last_name;
	$member_company = $result[0]->member_company;
    $member_phone = $result[0]->member_phone;
    $gender_id = $result[0]->gender_id;
    $member_no = $result[0]->member_no;

    if($gender_id == 1)
    {
    	$gender = 'Mr.';
    }
    else
    {
    	$gender = 'Mrs.';
    }
	$result = '<h2 class="page_title">'.$gender.' '.$member_first_name.' '.$member_last_name.'</h2> 
	     
	  <div class="page_content"> 

		<div class="buttons-row">
	        <a href="#tab1" class="tab-link active button">My Profile</a>
	        <a href="#tab2" class="tab-link button">CPD</a>
	  </div>
	  
	  <div class="tabs-animated-wrap">
	        <div class="tabs">
	              <div id="tab1" class="tab active">
					<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
		              </p>
		              <h3>Bio Information:</h3>
		              <ul class="simple_list">
		              <li>Email: '.$member_email.'</li>
		              <li>Phone: '.$member_phone.'</li>
		              <li>Current Company : '.$member_company.'</li>
		              </ul>
		          </div>
		          <div id="tab2" class="tab">';
		          $cpd_query = $this->login_model->get_cpd_info($member_no);
		          if($cpd_query->num_rows() > 0){
					foreach ($cpd_query->result() as $cpd_row)
					{
						$years = $cpd_row->years;
	
			          $result .= '
			          			  <h3>CPD Statement '.$years.':</h3>';

			          			  $cpd_query_result = $this->login_model->get_cpd_details($years,$member_no);
			          			 if($cpd_query_result->num_rows() > 0){
			          			 	$result .= '<ul class="simple_list">';
			          			 	$counter = 0;
				          			  foreach ($cpd_query_result->result() as $cpd_info_row)
									  {

									  	    $ActivityName = $cpd_info_row->ActivityName;
						                    $FromDate = $cpd_info_row->FromDate;
						                    $cpd = $cpd_info_row->cpd;
						                    $ToDate = $cpd_info_row->ToDate;
						                    $counter++;
							              $result .= '<li> '.$counter.' : '.$ActivityName.' :  '.$cpd.' points</li>';
							         }
							         $result .= '</ul>';
							     }
							     else
							     {
							     		$result .= 'You have no points';
							     }
					 }
				   }
				 $result .='
		          </div>
		     </div>

		</div>
	</div>';
}
else
{
	$result = 'No data found';
}
echo $result;
?>


