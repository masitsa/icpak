          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the category details
			$event_id = $event[0]->event_id;
			$event_name = $event[0]->event_name;
			$event_status = $event[0]->event_status;
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
				$event_id = set_value('event_id');
				$event_name = set_value('event_name');
				$event_status = set_value('event_status');
				
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
            }
			
            ?>
            
            <?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <!-- Category Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Event Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="event_name" placeholder="Event Name" value="<?php echo $event_name;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate Event ?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                        	<?php
                            if($event_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="event_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="event_status">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($event_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="event_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="event_status">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit Event
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>