 <?php


//  $from_name = "marttkip@gmail.com";        
// $from_address = "marttkip@gmail.com";        
// $to_name = "Joseph";        
// $to_address = "joe@example.com";        
// $startTime = "11/12/2013 18:00:00";        
// $endTime = "11/12/2013 19:00:00";        
// $subject = "My Test Subject";        
// $description = "My Awesome Description";        
// $location = "Joe's House";
// $this->site_model->sendIcalEvent($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location);


$meeting_detail = $this->events_model->get_event_name($meeting_id);
 $heading_data = '';
if ($meeting_detail->num_rows() > 0)
{
    foreach ($meeting_detail->result() as $row)
    {
        $meeting_id = $row->meeting_id;
        $meeting_date = $row->meeting_date;
        $meeting_status = $row->meeting_status;
        $end_date = $row->end_date;
        $country_id = $row->country_id;
        $country_name = $row->country_name;

        $event_type_id = $row->event_type_id;
        $event_type_name = $row->event_type_name;
        $agency_id = $row->agency_id;

        $agency_name = $row->agency_name;
        $location = $row->location;
        $subject = $row->subject;
        $parent_meeting = $row->parent_meeting;
        // get the parent meeting name
        $meeting_name = $this->events_model->get_parent_meeting_name($parent_meeting);
        // get the parent meeting ends

        // 


        $meeting_date = date('j M Y',strtotime($meeting_date));
        $end_date = date('j M Y',strtotime($end_date));

    }
    $heading_data = '<div class="hgroup title">
				         <h4>Subject : '.$subject.'</h4>
				         <p><span>Event Dates : </span> '.$meeting_date.' - '.$end_date.'</p>
				          <p><span>Event type :</span> '.$event_type_name.', <span>Agency :</span> '.$agency_name.'</p>
				         <p><span>Country :</span> '.$country_name.',<span> Location : <span/> '.$location.'</p>
				        
				    </div>';
}

// follwo up actions start

// check if there is a follow up meeting
   $check_follow = $this->events_model->check_for_followup_meetings($meeting_id);
// end of checking 

 if($check_follow > 0)
 {
 	$button_front = '<a href="'.base_url().'view-meeting/'.$check_follow.'" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-long-arrow-right"></i> Next child meeting</a>';
 	$button_back = '<a href="'.base_url().'all-events" class="btn btn-info btn-sm"><i class="fa fa-fw fa-mail-reply"></i> Back to events list</a>';
 	$previous_followup = $this->events_model->check_for_prev_followup_meetings_parent($check_follow);
	if($previous_followup > 0)
	{

 		// since there is a next get the previous one
		// means that there is a previous followup
		$button_back .= '<a href="'.base_url().'view-meeting/'.$previous_followup.'" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-long-arrow-left"></i> Prev child meeting</a>'; 
	}
	else
	{
		$button_back .= '';
	}
 }
 else
 {

 	$button_front = '';
 	$button_back = '<a href="'.base_url().'all-events" class="btn btn-info btn-sm"><i class="fa fa-fw fa-mail-reply"></i> Back to events list</a>';
 }

// check if this is a follow up meeting
  $check_if_followup = $this->events_model->check_if_followup_meetings($meeting_id);

 if($check_if_followup > 0 )
 {
 	// parent_id == $checkoiffollowup

 	// get the next and previous follow up
 	// get the next 
 	 $next_followup = $this->events_model->check_for_followup_meetings($check_if_followup);

 	if($next_followup > 0 and $next_followup != $meeting_id)
 	{
 		$button_front = '';
 		$button_front = '<a href="'.base_url().'view-meeting/'.$next_followup.'" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-long-arrow-right"></i> Next child meeting</a>';
 		$button_back = '<a href="'.base_url().'view-meeting/'.$check_if_followup.'" class="btn btn-info btn-sm"><i class="fa fa-fw fa-mail-reply"></i> Back to parent meeting</a>';
 		// since there is a next get the previous one
 		$previous_followup = $this->events_model->check_for_prev_followup_meetings($next_followup,$check_if_followup);
 		if($previous_followup > 0)
 		{
 			// means that there is a previous followup
 			$button_back .= '<a href="'.base_url().'view-meeting/'.$previous_followup.'" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-long-arrow-left"></i> Prev child meeting</a>'; 
 		}
 		else
 		{
 			$button_back .= '';
 		}
 	}
 	else
 	{
 		$button_front = '';
 		$button_back = '';
 		$button_back = '<a href="'.base_url().'view-meeting/'.$check_if_followup.'" class="btn btn-info btn-sm"><i class="fa fa-fw fa-mail-reply"></i> Back to parent event</a>';

 	}
 	// previous follow up 
 	
 }
 else
 {

 }
// end of checking 

// end of follow up actions 
?>


 <div class="container-fluid">
	<div class="row" style="margin-bottom:5px">
	 	<div class="col-md-12 col-lg-12">
	 		<div class="pull-left">
	 		 <?php echo $button_back;?>
	 		 
	 		</div>
	 		<div class="pull-right">
	 			<?php echo $button_front;?>
	 			<a class="btn btn-success btn-sm"  data-toggle="modal" data-target=".add-event"><i class="fa fa-fw fa-plus-square"></i> Add a follow meeting</a>
	 				<div class="modal fade add-event" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
					    <div class="modal-content">
					      
							 <div class="modal-header">
					            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					            <div class="hgroup title">
					                 <h4>Creating a follow-up meeting for <?php echo $subject;?></h4>
					            </div>
					        </div>

							 <form enctype="multipart/form-data" product_id="" action="<?php echo base_url();?>add-event"  id = "product_review_form" method="post">
					      		

					            <div class="modal-body">
					            	<!-- <div class="row">
					            		 <div class="col-sm-12">
						            		 <div class="form-group margin-none">
			                                    <label for="reservationtime">Meeting Dates:</label>
			                                    <div class="input-group">
			                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			                                        <input type="text" name="reservation" id="reservationtime" class="form-control" value="07-10-2014 1:00 PM - 07-10-2014 1:30 PM" />
			                                    </div>
			                                </div>
			                              </div>
					            	</div> -->
					                <div class="row">

					                    <div class="col-sm-6">
					                        <div class="control-group">
					                            <label class="control-label">Meeting Date</label>
					                            <div class="controls">
													<div class='input-group date' >
														<input type='text' id='datepicker' name="meeting_date" class="form-control" />
														<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
					                            </div>
					                        </div>

					                    </div>

					                    <div class="col-sm-6">
					                        <div class="control-group">
					                            <label class="control-label">End Date</label>
					                            <div class="controls">
													<div class='input-group date' >
														<input type='text' id='datepicker2' name="end_date" class="form-control" />
														<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					                <div class="row">
					                    <div class="col-sm-6">
					                        <div class="control-group">
					                            <label for="review_text" class="control-label">Parent meeting</label>
					                            <div class="controls">
					                            	<select class="form-control" name="meeting_id">
					                            		<option value="<?php echo $meeting_id;?>"><?php echo $subject;?></option>
					                              		  	
					                              </select>	  
					                            </div>
					                        </div>

					                    </div>
					                    <div class="col-sm-6">
					                        <div class="control-group">
					                            <label for="review_text" class="control-label">Events Type</label>
					                            <div class="controls">
					                            	<select class="form-control" name="event_type_id">
					                              		<?php
					                              		//if users exist display them
														if ($event_types->num_rows() > 0)
														{
															foreach ($event_types->result() as $evt)
															{
																$event_type_id = $evt->event_type_id;
																$event_type_name = $evt->event_type_name;
																?>
																<option value="<?php echo $event_type_id;?>"><?php echo $event_type_name;?></option>
																<?php
															}
														}
					                              		?>     	
					                              </select>	  
					                            </div>
					                        </div>

					                    </div>
					                </div>

					                <div class="row">
					                    <div class="col-sm-6">
					                        <div class="control-group">
					                            <label for="review_author_name" class="control-label">Country</label>
					                            <div class="controls">
					                             <select class="form-control" name="country_id">
					                              		<?php
					                              		//if users exist display them
														if ($countries->num_rows() > 0)
														{
															foreach ($countries->result() as $cont)
															{
																$country_id = $cont->country_id;
																$country_name = $cont->country_name;
																?>
																<option value="<?php echo $country_id;?>"><?php echo $country_name;?></option>
																<?php
															}
														}
					                              		?>     	
					                              </select>
					                            </div>
					                        </div>
					                    </div>

					                    <div class="col-sm-6">
					                        <div class="control-group">
					                            <label for="review_author_email" class="control-label">Agency</label>
					                            <div class="controls">
													<select class="form-control" name="agency_id">
					                              		<?php
					                              		//if users exist display them
														if ($agencies->num_rows() > 0)
														{
															foreach ($agencies->result() as $agents)
															{
																$agency_id = $agents->agency_id;
																$agency_name = $agents->agency_name;
																?>
																<option value="<?php echo $agency_id;?>"><?php echo $agency_name;?></option>
																<?php
															}
														}
					                              		?>     	
					                              </select>	                            
					                             </div>
					                        </div>
					                    </div>
					                </div>

					                
					                  <div class="row">
					                    <div class="col-sm-6">
					                        <div class="control-group">
					                            <label for="review_text" class="control-label">Location</label>
					                            <div class="controls">
					                            	<input type="text" class="form-control col-md-12" name="location">
					                            </div>
					                        </div>

					                    </div>
					                    <div class="col-sm-6">
					                        <div class="control-group">
					                            <label for="review_text" class="control-label">Subject</label>
					                            <div class="controls">
					                            	<input type="text" class="form-control col-md-12" name="subject">
					                            </div>
					                        </div>

					                    </div>
					                </div>

					            </div>

					            <div class="modal-footer">
					                <div class="pull-right">
					                    <button class="btn btn-primary" type="submit" onclick="">Submit Meeting info</button>
					                </div>
					            </div>                         
						</form>
		 
					    </div>
					  </div>
					</div>
	 		</div>
	 	</div>
	</div>
	<div class="row">
	 	<div class="col-md-12 col-lg-12">
		 	<div class="panel panel-default">
			 	<div class="modal-header">
				    <?php echo $heading_data;?>
				</div>
				<div class="modal-body">
				    <div role="tabpanel">

				      <!-- Nav tabs -->
				      <ul class="nav nav-tabs" role="tablist">
				      	<li role="presentation" class="active"><a href="#agenda" aria-controls="agenda" role="tab" data-toggle="tab">Agenda</a></li>
				        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Convenors</a></li>
				        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Attendees</a></li>
				        <li role="presentation"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Minutes</a></li>
				        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Action points</a></li>
				        <li role="presentation"><a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">Attachments</a></li>
				        <li role="presentation"><a href="#meeting_stats" aria-controls="meeting_stats" role="tab" data-toggle="tab"> Statistics & Reviews</a></li>
				      	<li role="presentation"><a href="#followups" aria-controls="followups" role="tab" data-toggle="tab">Follow up meetings</a></li>

				      </ul>


				      <!-- Tab panes -->
				      <div class="tab-content">
				      	 <div role="tabpanel" class="tab-pane active" id="agenda">
				      	 	 <form enctype="multipart/form-data" meeting_id="<?php echo $meeting_id;?>" action="<?php echo base_url();?>save-meeting-agenda/<?php echo $meeting_id;?>"  id = "meeting_agenda_form" method="post">

				                <div class="row">
				                    <div class="col-sm-12">
				                    	<div class="row">
				                   		 	<div class="col-sm-12">
						                    	<!-- javascript model -->
		                        				<?php echo $this->load->view('show_agenda');?>
						                    	<!-- end of this script -->
						                    </div>
						                </div>
						                 <div class="row">
						                     <div class="col-sm-12">
						                        <div class="control-group">
						                        <label for="review_text" class="control-label"></label>

						                            <div class="controls">
						                                <div class="pull-right">
						                                    <button class="btn btn-success btn-sm" type="submit">Update meeting agenda</button>
						                                      <!-- <a hred="#" class="btn btn-large btn-success btn-sm" onclick="save_meeting_notes(<?php echo $meeting_id;?>)">Save Nurse Notes</a> -->
						                                </div>
						                            </div>
						                        </div>

						                    </div>
						                </div>
				                    </div>
				                   
				                </div>
				            </form>
				              	<div class="row">
				                	  <div class="col-sm-12">

				                	  	<h4>Attachments</h4>

				                	  	 <a class="btn btn-xs btn-primary col-md-3 pull-left" onclick="upload_function_div(1)" style="display:block" id="upload_button">Upload new attachment</a>
				                	  	 <a  class="btn btn-xs btn-warning col-md-3 pull-left" onclick="upload_function_div(2)" style="display:none" id="close_button">Close</a>

				                	  </div>
				                	</div>
				                	<div class="row">
				                	  <div class="col-sm-12">
				                	  	<div id="upload_form" style="display:none">
											<script type = "text/javascript" src = "//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.js"></script>
											<br/>
											 <!-- AJAX Response will be outputted on this DIV container -->
											    <div class = "upload-image-messages"></div>

											    <div class = "col-md-6">
											        <!-- Generate the form using form helper function: form_open_multipart(); -->
											        <!-- <?php echo form_open_multipart('upload/do_upload', array('class' => 'upload-image-form'));?> -->
											        <form enctype="multipart/form-data" meeting_id="<?php echo $meeting_id;?>" action="<?php echo base_url();?>site/upload/do_upload/<?php echo $meeting_id;?>"  id = "agenda_attachment_form" method="post" class="upload-image-form">
											            <input type="file" multiple = "multiple" accept = "image/*" class = "form-control" name="uploadfile[]" size="20" /><br />
											            <input type="submit" name = "submit" value="Upload" class = "btn btn-primary" />
											        </form>

											        <script>                    
											        jQuery(document).ready(function($) {

											            var options = {
											                beforeSend: function(){
											                    // Replace this with your loading gif image
											                    $(".upload-image-messages").html('<p><img src = "<?php echo base_url() ?>assets/loading.gif" class = "loader" /></p>');
											                },
											                complete: function(response){
											                    // Output AJAX response to the div container
											                    $(".upload-image-messages").html(response.responseText);
											                    $('html, body').animate({scrollTop: $(".upload-image-messages").offset().top-100}, 150);
											                    
											                }
											            };  
											            // Submit the form
											            $(".upload-image-form").ajaxForm(options);  

											            return false;
											            
											        });
											        </script>
											    </div>
				                	  	</div>
				                	  </div>
				                	</div>
					                <div class="col-sm-12">
					                	<!-- ajax load all the uploads -->
					                		<div id="show_agenda_uploads"></div>
					                	<!-- end of uploads ajax -->
					                </div>
				                <div class="row">
				                	  <div class="col-sm-12">
				                    	<h4>Meeting comments</h4>
				                    	 <div id="view_message">
										 <?php
										$query = $this->social_model->get_all_meeting_comments($meeting_id);
										// var_dump($query) or die();
										if($query->num_rows() > 0)
										{
										    foreach ($query->result() as $key) {
										        # code...
										        $agenda_comment_id = $key->agenda_comment_id;
										        $agenda_comment_description = $key->agenda_comment_description;
										        $agenda_comment_user = $key->agenda_comment_user;
										        $agenda_comment_email = $key->agenda_comment_email;
										        $comment_created = $key->comment_created;

										        $difference = $this->messages_model->dateDiff($comment_created, $time2 = date("Y-m-d H:i:s"));
										        
										        echo '
										        <div class="media">
										            <div class="media-body message">
										                <div class="panel panel-default">
										                    <div class="panel-heading panel-heading-white">
										                        <div class="pull-right">
										                            <small class="text-muted">'.$difference.'</small>
										                        </div>
										                        <a href="#">'.$agenda_comment_user.'</a>
										                    </div>
										                    <div class="panel-body">
										                        '.$agenda_comment_description.'
										                    </div>
										                </div>
										            </div>
										        </div>
										        ';
										    }
										}
										else
										{

										}
										 ?>
										</div>
				                    </div>
				                </div>
				             
				      	 </div>
				        <div role="tabpanel" class="tab-pane" id="home">
				           <form enctype="multipart/form-data" meeting_id="<?php echo $meeting_id;?>" action="<?php echo base_url();?>save-meeting-notes/<?php echo $meeting_id;?>"  id = "meeting_notes_form" method="post">

				                <div class="row">
				                    <div class="col-sm-12">
				                    	<!-- javascript model -->
                        				<?php echo $this->load->view('show_minutes');?>
				                    	<!-- end of this script -->
				                    </div>
				                </div>
				                <div class="row">
				                     <div class="col-sm-12">
				                        <div class="control-group">
				                        <label for="review_text" class="control-label"></label>

				                            <div class="controls">
				                                <div class="pull-right">
				                                    <button class="btn btn-primary btn-sm" type="submit">Edit meeting details</button>
				                                      <!-- <a hred="#" class="btn btn-large btn-success btn-sm" onclick="save_meeting_notes(<?php echo $meeting_id;?>)">Save Nurse Notes</a> -->
				                                </div>
				                            </div>
				                        </div>

				                    </div>
				                </div>
				             </form>
				         </div>
				        <div role="tabpanel" class="tab-pane" id="profile">
				        	<!-- facilitators div -->
				        	<div id='facilitators'></div>
				        	<!-- facilitators div -->
				        </div>
				        <div role="tabpanel" class="tab-pane" id="messages">
				           
				        <!-- attendees div  -->
				        	<div id='attendees'></div>
				        <!-- end of attendees div -->
				        </div>
				        <div role="tabpanel" class="tab-pane" id="settings">
		   			      <!-- action points -->
		   			      	<div id="action_points"></div>
		   			      <!-- end of action points -->
				        </div>
				        <div role="tabpanel" class="tab-pane" id="attachments">
				            <!-- meeting attachments -->
				            	<div id="attachments"></div>
				            <!-- meeting attachments -->
				        </div>
				         <div role="tabpanel" class="tab-pane" id="followups">
				         	<div class="row">
				                <div class="col-sm-12">
				                	<?php echo $this->load->view('show_follow_up_meetings');?>
				                </div>
				            </div>
				         </div>
				          <div role="tabpanel" class="tab-pane" id="meeting_stats">
				         	<div class="row">
				                <div class="col-sm-12">
				                		
										  
										    <div class="col-sm-12">
						                		 <div class="col-md-6 col-lg-6">
						                		 	<?php 
						                		 		// get all the action point status
						                		 		$action_points_array = $this->action_point_model->get_action_statuses();

						                		 		if($action_points_array->num_rows() > 0)
						                		 		{
						                		 			$parameters2 ='';
						                		 			foreach ($action_points_array->result() as $key) {
						                		 				# code...
						                		 				$action_status_id = $key->action_status_id;
						                		 				$action_status_name = $key->action_status_name;

						                		 				// count all the relevant action points stated 
						                		 				$counter = $this->action_point_model->get_count_action_point_status($action_status_id,$meeting_id);

						                		 				$parameters2 .= "['".$action_status_name."',     ".$counter."],";
						                		 			}
						                		 		}

						                		 		// var_dump($parameters2) or die();
						                		 	?>
									         		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
												    <script type="text/javascript">
												      google.load("visualization", "1", {packages:["corechart"]});
												      google.setOnLoadCallback(drawChart);
												      function drawChart() {
												        var data = google.visualization.arrayToDataTable([
												          ['Action point Status', 'Total number'],
													      <?php echo $parameters2;?>
												        ]);

												        var options = {
												          title: 'Meeting action points statistics',
												          is3D: true,
												        };

												        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
												        chart.draw(data, options);
												      }
												    </script>
												    <div id="piechart_3d" style="width: auto; height: auto;"></div>
												 </div>
												  <div class="col-md-6 col-lg-6">
										  				<div id="tasks_to_review"></div>
										  		 </div>
											</div>
								   </div>
					            </div>
					         </div>
				      </div>


				    </div>
				</div>
		 	</div>
		</div>
	</div>
</div>
<div class="modal fade add-acction-point" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <div class="hgroup title">
                 <h3>Action point </h3>
            </div>
        </div>
            <form enctype="multipart/form-data" meeting_id="<?php echo $meeting_id;?>" action="<?php echo base_url();?>add-action-point/<?php echo $meeting_id;?>"  id = "action_point_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                 <label class="control-label">Assign to</label>
                                <div class="controls">
                                	<select name="assigned_to" id="assigned_to" class="form-control">
                                    	<option value="">--Select person to assign the task--</option>

	                                    <?php
	                                     $attendee_query = $this->attendee_model->get_active_attendees($meeting_id);
	                                    
	                                    if($attendee_query->num_rows() > 0)
	                                    {
	                                        foreach($attendee_query->result() as $attend)
	                                        {
	                                            $attendee_id = $attend->attendee_id;
	                                            $attendee_first_name = $attend->attendee_first_name;
	                                            $attendee_last_name = $attend->attendee_last_name;
	                                            $attendee_title = $attend->attendee_title;
	                                            
	                                            $name = $attendee_title.' '.$attendee_first_name.' '.$attendee_first_name;
	                                            echo '<option value="'.$attendee_id.'">'.$name.'</option>';
	                                           
	                                        }
	                                    }
	                                ?>
	                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                                    <div class="control-group">
                                        <label class="control-label">End Date</label>
                                        <div class="controls">
                                            <div class='input-group date' >
                                                <input type='text' id='datepicker3' name="end_date" class="form-control" placeholder="YYYY-mm-dd"/>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <label class="control-label">Priority</label>
                                <div class="controls">
                                   <select name="priority_status_id" id="priority_status_id" class="form-control">
                                    <option value="">--Select priority--</option>
                                    <?php
                                    $priority_status_query = $this->action_point_model->get_priority_statuses();
                                    $action_status_query = $this->action_point_model->get_action_statuses();
                                    
                                    if($priority_status_query->num_rows() > 0)
                                    {
                                        foreach($priority_status_query->result() as $res)
                                        {
                                            $priority_status_id2 = $res->priority_status_id;
                                            $priority_status_name = $res->priority_status_name;
                                            
                                            if($priority_status_id2 == $priority_status_id)
                                            {
                                                echo '<option value="'.$priority_status_id2.'" selected="selected">'.$priority_status_name.'</option>';
                                            }
                                            
                                            else
                                            {
                                                echo '<option value="'.$priority_status_id2.'">'.$priority_status_name.'</option>';
                                            }
                                        }
                                    }
                                ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <label class="control-label">Action Status</label>
                                <div class="controls">
                                   <select name="actions_status_id" id="actions_status_id" class="form-control">
                                    <option value="">--Select action--</option>
                                <?php
                                    if($action_status_query->num_rows() > 0)
                                    {
                                        foreach($action_status_query->result() as $res)
                                        {
                                            $actions_status_id2 = $res->action_status_id;
                                            $action_status_name = $res->action_status_name;
                                            
                                            if($actions_status_id2 == $actions_status_id)
                                            {
                                                echo '<option value="'.$actions_status_id2.'" selected="selected">'.$action_status_name.'</option>';
                                            }
                                            
                                            else
                                            {
                                                echo '<option value="'.$actions_status_id2.'">'.$action_status_name.'</option>';
                                            }
                                        }
                                    }
                                ?>
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-group">
                                 <label class="control-label">Note</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="action_point_notes" id="action_point_notes" placeholder="point 1, point 2" value="">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button class="btn btn-danger btn-sm" type="submit"  data-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary btn-sm" type="submit" onclick="">Add action point</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</div>
<script text="javascript">

$(document).ready(function(){
  meeting_facilitator(<?php echo $meeting_id;?>);
  meeting_attendees(<?php echo $meeting_id;?>);
  meeting_action_points(<?php echo $meeting_id;?>);
  meeting_attachments(<?php echo $meeting_id;?>);
  show_agenda_uploads(<?php echo $meeting_id;?>);
  tasks_to_review();
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  $(function() {
    $( "#datepicker2" ).datepicker();
  });
  $(function() {
    $( "#datepicker3" ).datepicker();
  });

 
});
function check_attendee_type(type_id){
    var myTarget2 = document.getElementById("tnc_member_div");

    var myTarget3 = document.getElementById("other_member_div");

    if(type_id == 1)
    {
        myTarget2.style.display = 'block';
        myTarget3.style.display = 'none';
    }
    else
    {
        myTarget2.style.display = 'none';
        myTarget3.style.display = 'block';
    }

    
}

function upload_function_div(type_id){
    var myTarget2 = document.getElementById("upload_form");

    var myTarget3 = document.getElementById("close_button");
    var myTarget4 = document.getElementById("upload_button");

    if(type_id == 1)
    {
        myTarget2.style.display = 'block';
        myTarget3.style.display = 'block';
        myTarget4.style.display = 'none';
    }
    else
    {
       	myTarget2.style.display = 'none';
        myTarget3.style.display = 'none';
        myTarget4.style.display = 'block';
    }

    
}
function meeting_facilitator(meeting_id){

    var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var url = "<?php echo base_url();?>meeting-facilitators/"+meeting_id;

            
    if(XMLHttpRequestObject) {
        
        var obj = document.getElementById("facilitators");
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                obj.innerHTML = XMLHttpRequestObject.responseText;
               
             
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}

function show_agenda_uploads(meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var url = "<?php echo base_url();?>meeting-agenda-attachments/"+meeting_id;

            
    if(XMLHttpRequestObject) {
        
        var obj = document.getElementById("show_agenda_uploads");
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                obj.innerHTML = XMLHttpRequestObject.responseText;
               
             
            }
        }
                
        XMLHttpRequestObject.send(null);
    }	
}
function meeting_attachments(meeting_id){

    var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var url = "<?php echo base_url();?>meeting-attachments/"+meeting_id;

            
    if(XMLHttpRequestObject) {
        
        var obj = document.getElementById("attachments");
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                obj.innerHTML = XMLHttpRequestObject.responseText;
               
             
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function meeting_attendees(meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var url = "<?php echo base_url();?>meeting-attendees/"+meeting_id;
    // window.alert(url);
            
    if(XMLHttpRequestObject) {
        
        var obj = document.getElementById("attendees");
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                obj.innerHTML = XMLHttpRequestObject.responseText;
               
             
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function meeting_action_points(meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var url = "<?php echo base_url();?>meeting-action-points/"+meeting_id;
    // window.alert(url);
            
    if(XMLHttpRequestObject) {
        
        var obj = document.getElementById("action_points");
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                obj.innerHTML = XMLHttpRequestObject.responseText;
               
             
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}

function deactivate_facilitator(facilitator_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>deactivate-facilitator/"+facilitator_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_facilitator(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function activate_facilitator(facilitator_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>activate-facilitator/"+facilitator_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_facilitator(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function delete_facilitator(facilitator_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>delete-facilitator/"+facilitator_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_facilitator(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}

function deactivate_attendee(attendee_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>deactivate-attendee/"+attendee_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_attendees(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function activate_attendee(attendee_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>activate-attendee/"+attendee_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_attendees(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function delete_attendee(attendee_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>delete-attendee/"+attendee_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_attendees(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
// start of action point actions
function deactivate_action_point(action_point_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>deactivate-action-point/"+action_point_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_action_points(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function activate_action_point(action_point_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>activate-action-point/"+action_point_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_action_points(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function delete_action_point(action_point_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>delete-action-point/"+action_point_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_action_points(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
// end of action points actions

// start of attachments actions
function deactivate_attachment(attachment_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>deactivate-attachment/"+attachment_id+"/"+meeting_id;

    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_attachments(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function activate_attachment(attachment_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>activate-attachment/"+attachment_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_attachments(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function delete_attachment(attachment_id,meeting_id)
{
	var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "<?php echo base_url();?>delete-attachment/"+attachment_id+"/"+meeting_id;
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                meeting_attachments(meeting_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
function tasks_to_review(){

        var XMLHttpRequestObject = false;
            
        if (window.XMLHttpRequest) {
        
            XMLHttpRequestObject = new XMLHttpRequest();
        } 
            
        else if (window.ActiveXObject) {
            XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
        }

        var url = "<?php echo base_url();?>tasks-to-review";

                
        if(XMLHttpRequestObject) {
            
            var obj = document.getElementById("tasks_to_review");
                    
            XMLHttpRequestObject.open("GET", url);
                    
            XMLHttpRequestObject.onreadystatechange = function(){
                
                if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                    obj.innerHTML = XMLHttpRequestObject.responseText;
                   
                 
                }
            }
                    
            XMLHttpRequestObject.send(null);
        }
    }
 function send_notification(action_status,meeting_id,attendee_id,action_point_id)
    {
        var XMLHttpRequestObject = false;
        
        if (window.XMLHttpRequest) {
        
            XMLHttpRequestObject = new XMLHttpRequest();
        } 
            
        else if (window.ActiveXObject) {
            XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var url = "<?php echo base_url();?>send-other-notification/"+action_status+"/"+meeting_id+"/"+attendee_id+"/"+action_point_id;
        if(XMLHttpRequestObject) {
                    
            XMLHttpRequestObject.open("GET", url);
                    
            XMLHttpRequestObject.onreadystatechange = function(){
                
                if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                    tasks_to_review();
                }
            }
                    
            XMLHttpRequestObject.send(null);
        }
    }
    function mark_as_complete(action_point_id)
    {
        var XMLHttpRequestObject = false;
        
        if (window.XMLHttpRequest) {
        
            XMLHttpRequestObject = new XMLHttpRequest();
        } 
            
        else if (window.ActiveXObject) {
            XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var url = "<?php echo base_url();?>mark-as-complete/"+action_point_id;
        if(XMLHttpRequestObject) {
                    
            XMLHttpRequestObject.open("GET", url);
                    
            XMLHttpRequestObject.onreadystatechange = function(){
                
                if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                    tasks_to_review();
                }
            }
                    
            XMLHttpRequestObject.send(null);
        }
    }
// end of attachment actions
</script>
  <!-- jQuery UI -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/themes/bluish/"?>style/jquery-ui.css"> 
  <!-- Calendar -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/themes/bluish/"?>style/fullcalendar.css">