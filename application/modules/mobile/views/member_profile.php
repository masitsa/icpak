<?php
if ($profile_query->num_rows() > 0)
{
	$result = $profile_query->result();
	$member_email = $result[0]->email;
	$member_id = $result[0]->id;
	$member_first_name = $result[0]->name;
    $member_no = $result[0]->username;

    
	$result = '<h2 class="page_title"> '.$member_first_name.'</h2> 
	     
	  <div class="page_content"> 

		<div class="buttons-row">
	        <a href="#tab1" class="tab-link active button">My Profile</a>
	        <a href="#tab2" class="tab-link button">CPD Statement</a>
	        <a href="#tab3" class="tab-link button">CPD Queries</a>
	  </div>
	  
	  <div class="tabs-animated-wrap">
	        <div class="tabs">
	              <div id="tab1" class="tab active">
					
		              <h3>Bio Information:</h3>
		              <ul class="simple_list">
		              <li>Name: '.$member_first_name.'</li>
		              <li>Email: '.$member_email.'</li>
		              <li>Member No.: '.$member_no.'</li>
		              </ul>
		          </div>
		          <div id="tab2" class="tab">';
		          $cpd_query = $this->login_model->get_cpd_info($member_no);
		          if($cpd_query->num_rows() > 0){
		          	$total_points = 0;
		          	 
					foreach ($cpd_query->result() as $cpd_row)
					{
						$years = $cpd_row->years;
	
			          $result .= '
			          			  <h3>CPD Statement '.$years.':</h3>';

			          			  $cpd_query_result = $this->login_model->get_cpd_details($years,$member_no);
			          			 
			          			 if($cpd_query_result->num_rows() > 0){
			          			 	$result .= '<ul class="simple_list">';
			          			 	$counter = 0;
			          			 	$sub_total = 0;
				          			  foreach ($cpd_query_result->result() as $cpd_info_row)
									  {

									  	    $ActivityName = $cpd_info_row->ActivityName;
						                    $cpd = $cpd_info_row->cpd;
						                    $sub_total = $sub_total + $cpd;
						                    $counter++;
							              $result .= '<li>  '.$ActivityName.' : <span id="colored"> '.$cpd.' points </span></li>';
							         }
							         $result .= '</ul>';
							         $result .= '<div class="sub-total"><h3 > '.$years.' Sub total points : '.$sub_total.'</h3></div>';
							     }
							     else
							     {
							     		$result .= 'You have no points';
							     }
							$total_points = $total_points + $sub_total;
					 }
					 $result .= '<div class="grand-total"> <h3> Grand total points : '.$total_points.'</h3> </div>';
				   }
				 $result .='
          			
			          
			          </div> 
			          <div id="tab3" class="tab">
			          	<div id="cpdquery_response"></div>
			            <div class="contactform">
				            <form class="cmxform" id="cpd_query_form" method="post" action="">
					           
					            <input type="hidden" name="member_id" id="member_id" value="'.$member_id.'" class="form_input required" />
					            <label>Question:</label>
					            <textarea name="question" id="question" class="form_textarea textarea required" rows="" cols=""></textarea>
					            <input type="submit" name="submit" class="form_submit" id="submit" value="Submit Query" />
					           
				            </form>
				            <h3>Questions & Responses</h3>';
				             $question_query = $this->login_model->get_from_question($member_id);
					          if($question_query->num_rows() > 0){
					          	$total_points = 0;
					          	$result .= '<ul class="comments">';
								foreach ($question_query->result() as $question_row)
								{
					            
					            	$question_id = $question_row->question_id;
					            	$question = $question_row->question;
					            	$question_answer = $question_row->question_answer;
					            	$answered_by = $question_row->answered_by;

					            	$date_asked = $question_row->date_asked;
					            	$date_answered = $question_row->date_answered;
					            	$question_status = $question_row->question_status;

					            	$result .= '
					            				<li class="comment_row question" >
				                                   <div class="comm_content"><p>'.$question.'</p></div>
				                                </li>
					            				';

					            	if(!empty($answered_by))
					            	{
					            		$result .= '
					            				<li class="comment_row response" >
				                                   <div class="comm_content"><p>'.$question_answer.'</p></div>
				                                </li>
					            				';
					            	}
					            	else
					            	{
					            		
					            	}
					           	}
					           }
                               $result .= ' 
                                <div class="clear"></div>
                            </ul>
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


