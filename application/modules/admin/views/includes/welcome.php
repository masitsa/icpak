<?php
	// $active_flights = $this->login_model->get_active_flights();
	// $total_payments = number_format($this->login_model->get_total_payments(), 0, '.', ',');
    $active_members = $this->users_model->count_items('jos_users', 'activation IS NOT NULL ');
    $total_queries = $this->users_model->count_items('query', 'query_status = 1');

?>
            <!-- Page header start -->
            <div class="page-header">
                <div class="page-title">
                    <h3>ICPAK LIVE</h3>
                    <span>
					<?php 
					//salutation
					if(date('a') == 'am')
					{
						echo 'Good morning, ';
					}
					
					else if((date('H') >= 12) && (date('H') < 17))
					{
						echo 'Good afternoon, ';
					}
					
					else
					{
						echo 'Good evening, ';
					}
					echo $this->session->userdata('first_name');
					?>
                    </span>
                </div>
                <ul class="page-stats">
                    
                    <li>
                        <div class="summary">
                            <span>Total Queries</span>
                            <h3><?php echo $total_queries;?></h3>
                        </div>
                        <span id="sparklines2"></span>
                    </li>
                    <li>
                        <div class="summary">
                            <span>Active Members</span>
                            <h3><?php echo $active_members;?></h3>
                        </div>
                        <span id="sparklines1"></span>
                    </li>
                </ul>
            </div>
            <!-- Page header ends -->