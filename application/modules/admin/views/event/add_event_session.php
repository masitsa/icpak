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
	                <label class="col-lg-4 control-label">Event Session Name</label>
	                <div class="col-lg-8">
	                	<input type="text" class="form-control" name="event_session_name" placeholder="Session Name" value="<?php echo set_value('event_session_name');?>" required>
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-lg-4 control-label">Event Session Name</label>
	                <div class="col-lg-8">
	                	<input type="text" class="form-control" name="event_session_code" placeholder="Session Code" value="<?php echo set_value('event_code');?>" required>
	                </div>
	            </div>
	        </div>
	        <div class="col-lg-6">
	       		<div class="form-group">
	                <label class="col-lg-4 control-label">Event Name</label>
	                <div class="col-lg-8">
	                		<select class="form-control" name="event_id">
	                			<option value="0"> Select an event </option>
	                			<?php
	                			if($event_query->num_rows() > 0)
	                			{
	                				foreach ($event_query->result() as $key) {
	                					# code...
	                					$event_id = $key->event_id;
	                					$event_name = $key->event_name;
	                					?>
	                					<option value="<?php echo $event_id;?>"><?php echo $event_name;?></option>
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
	            <div class="form-group">
	                <label class="col-lg-4 control-label">Activate Session?</label>
	                <div class="col-lg-8">
	                    <div class="radio">
	                        <label>
	                            <input id="optionsRadios1" type="radio" checked value="1" name="event_session_status">
	                            Yes
	                        </label>
	                    </div>
	                    <div class="radio">
	                        <label>
	                            <input id="optionsRadios2" type="radio" value="0" name="event_session_status">
	                            No
	                        </label>
	                    </div>
	                </div>
	            </div>
	         </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Add Event
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>
</div>