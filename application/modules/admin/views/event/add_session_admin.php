          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
<div class="col-lg-12">
	<a href="<?php echo base_url();?>all-event-session" class="btn btn-success pull-right">Back to event session</a> 
</div>
<div class="col-lg-12">
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
            }
            ?>
            
            <?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <!-- Category Name -->
            
	        <div class="col-lg-6">
	       		<div class="form-group">
	                <label class="col-lg-4 control-label">Session Name</label>
	                <div class="col-lg-8">
	                		<select class="form-control" name="event_session_id">
	                			<option value="0"> Select an event </option>
	                			<?php
	                			if($event_query->num_rows() > 0)
	                			{
	                				foreach ($event_query->result() as $key) {
	                					# code...
	                					$event_session_id = $key->event_session_id;
	                					$event_session_name = $key->event_session_name;
	                					$event_session_code = $key->event_session_code;
	                					?>
	                					<option value="<?php echo $event_session_id;?>"><?php echo $event_session_code;?></option>
	                					<?php
	                				}
	                			}
	                			else
	                			{

	                			}
	                			?>
	                		</select>
	                </div>
	            </div>
            </div>
            <div class="col-lg-6">
	            <div class="form-group">
	                <label class="col-lg-4 control-label">Admin Name?</label>
	                <div class="col-lg-8">
	                    <select class="form-control" name="admin_id">
                			<option value="0"> Select an admin </option>
                			<?php
                			if($admin_query->num_rows() > 0)
                			{
                				foreach ($admin_query->result() as $key_admin) {
                					# code...
                					$user_id = $key_admin->user_id;
                					$first_name = $key_admin->first_name;
                					$other_names = $key_admin->other_names;
                					?>
                					<option value="<?php echo $user_id;?>"><?php echo $first_name;?> <?php echo $other_names?></option>
                					<?php
                				}
                			}
                			else
                			{

                			}
                			?>
                		</select>
	                </div>
	            </div>
	         </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Assign admin to event
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>
</div>