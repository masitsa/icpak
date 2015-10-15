<?php

$result = '
<h2 class="page_subtitle">Pro social</h2>
          	<div class="buttons-row">
                    <a href="#tab1" class="tab-link active button">Technical Query</a>
                    <a href="#tab2" class="tab-link button">Standards Query</a>
                    <a href="#tab3" class="tab-link button" onclick="">Social Forum</a>

              </div>
              
              <div class="tabs-simple">
                    <div class="tabs">
                          <div id="tab1" class="tab active">
                                <h4>Technical Query</h4>
                                <div id="technical_response"></div>
          					            <div class="contactform">
          						            <form class="cmxform" id="technical_query" method="post" action="">
          							            <label>Subject:</label>
          							            <input type="text" name="query_subject" id="query_subject" value="" class="form_input required" />
          							            <label>Body:</label>
          							            <textarea name="query_text" id="query_text" class="form_textarea textarea required" rows="" cols=""></textarea>
          							            <input type="submit" name="submit" class="form_submit" id="submit" value="Send" />
          							            <input class="" type="hidden" name="member_email" id="social_member_email1" value="" />
          							            <input class="" type="hidden" name="member_id" id="social_member_id1" value="" />
          							            <label id="loader" style="display:none;"><img src="images/loader.gif" alt="Loading..." id="LoadingGraphic" /></label>
          						            </form>
          					            </div>
                          </div>
    
                          <div id="tab2" class="tab">
                                <h4>Standards Query</h4>
                                <div id="standards_response"></div>
          					            <div class="contactform">
          						            <form class="cmxform" id="standards_query_form" method="post" action="">
          							            <label>Subject:</label>
          							            <input type="text" name="standard_query_subject" id="standard_query_subject" value="" class="form_input required" />
          							            <label>Body:</label>
          							            <textarea name="standards_query_text" id="standards_query_text" class="form_textarea textarea required" rows="" cols=""></textarea>
          							            <input type="submit" name="submit" class="form_submit" id="submit" value="Send" />
          							            <input class="" type="hidden" name="member_email" id="social_member_email2" value="" />
                                    <input class="" type="hidden" name="member_id" id="social_member_id2" value="" />
                                    <label id="loader" style="display:none;"><img src="images/loader.gif" alt="Loading..." id="LoadingGraphic" /></label>
          						            </form>
          					            </div>
                          </div> 
                          <div id="tab3" class="tab">
						 	<div id="social_response"></div>
						    <div class="contactform">
						      <form class="cmxform" id="social_forum_form" method="post" action="">
						        <label>Status:</label>
						        <textarea name="member_text" id="member_text" class="form_textarea textarea required" rows="" cols=""></textarea>
						        <input type="submit" name="submit" class="form_submit" id="submit" value="Send" />
						        <label id="loader" style="display:none;"><img src="images/loader.gif" alt="Loading..." id="LoadingGraphic" /></label>
						      </form>
						    </div>
								<h3>Members forum</h3>';
								if ($social_forum->num_rows() > 0)
						                {

						                $result .=' 

						                       <ul class="comments">';

										        foreach ($social_forum->result() as $row)
						                        {
						                            $member_id  = $row->member_id;
										            $comment = $row->comment;
										            $name = $row->name;

										            if($member_id == $this->session->userdata('member_id'))
										            {	
										            	$result .= '
												            	<li class="comment_row">
													                  <div class="comm_avatar"><img src="images/icons/black/user.png" alt="" title="" border="0" /></div>
													                  <div class="comm_content"><p> '.$comment.' <a href="#">Me</a></p></div>
													            </li>

										            			';

										            }
										            else
										            {
										            	$result .= '
												            	<li class="comment_row">
													                 <div class="comm_content"><p> '.$comment.' <a href="#">'.$name.'</a></p></div>
													                 <div class="comm_avatar"><img src="images/icons/black/user.png" alt="" title="" border="0" /></div>

													            </li>

										            			';

										            }

										        }
								           $result .='
								              <div class="clear"></div>
								          </ul>';
								     }
								     else
								     {
								     	$result .= 'No comments yet';
								     }
								 $result .= '    
								 </div> 
                    </div>
              </div>';
echo $result;

?>