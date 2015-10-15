<?php

$result ='	<div class="buttons-row">
                    <a href="#tab1" class="tab-link active button" >Ask Question</a>
                    <a href="#tab2" class="tab-link button" >Active Session Questions</a>

              </div>
              
              <div class="tabs-simple">
                    <div class="tabs">
                          <div id="tab1" class="tab active">
                            	<div id="session_response"></div>
                              		<div class="contactform">';
										if($this->session->userdata('member_id') < 1)
										{

											$result .= '
													<form class="cmxform" id="question_answer_form" method="post" action="">
													    <label>Name:</label>
													    <input type="text" name="member_name" id="member_name" value="" class="form_input required" />
													    <label>Email:</label>
													    <input type="email" name="member_email" id="member_email" value="" class="form_input required" />
													    <label>Session Code:</label>
													    <input type="text" name="session_code" id="session_code" value="" class="form_input required" />
													    <input type="hidden" name="is_member" id="is_member" value="0" class="form_input " />
													    <label>Question:</label>
													    <textarea name="session_question" id="session_question" class="form_textarea textarea required" rows="" cols=""></textarea>
													    <input type="submit" name="submit" class="form_submit" id="submit" value="Send" />
													</form>';
										}
										else
										{
											$profile_query= $this->login_model->get_profile_details();

											if ($profile_query->num_rows() > 0)
											{
												foreach ($profile_query->result()as $key ) {
													
													$member_email = $key->email;
													$member_id = $key->id;
													$member_first_name = $key->name;
												    $member_no = $key->username;
											    # code...
												}

											$result .= '
													<form class="cmxform" id="question_answer_form" method="post" action="">
													  	 <label>Member Email:</label>
													    <input type="hiddem" name="member_email" id="member_email" value="'.$member_email.'" class="form_input " readonly/>
													    <label>Session Code:</label>
													    <input type="text" name="session_code" id="session_code" value="" class="form_input required" />
													    <label>Question:</label>
													    <textarea name="session_question" id="session_question" class="form_textarea textarea required" rows="" cols=""></textarea>
													    <input type="submit" name="submit" class="form_submit" id="submit" value="Send" />
													    <input type="hidden" name="member_name" id="member_name" value="'.$member_first_name.'" class="form_input " />
													    <input type="hidden" name="is_member" id="is_member" value="'.$member_id.'" class="form_input" />
													   
													</form>';
											}
											else
											{
												$result .= 'Your details could not be confirmed';
											}
										}
									$result .= '
								</div>
                          </div>
                          <div id="tab2" class="tab">';
                       
							if($active_sessions->num_rows() > 0){
								$total_points = 0;
								
								foreach ($active_sessions->result() as $row)
								{

									$event_session_id = $row->event_session_id;
									$event_session_status = $row->event_session_status;
									$event_session_code = $row->event_session_code;


									$result .='<h3> '.$event_session_code.' </h3>';

									$query = $this->queries_model->get_latest_session_question($event_session_code);
									if($query->num_rows() > 0){
									
										foreach ($query->result() as $row_two)
										{
											$session_question = $row_two->session_question;
											$email = $row_two->email;
											$name = $row_two->name;

											$result .= '<ul class="comments">';
											$result .= '
														<li class="comment_row question" >
										                   <div class="comm_content"><p>'.$session_question.' asked by <a href="#">'.$name.'</a></p></div>
										                </li>
														';

											$result .= ' </ul>';
										}
									}else
									{
										$result .='No questions made active';
									}
								}
							}

						$result .='
                            	
                          </div>
                       </div>
              </div>';
echo $result;
?>