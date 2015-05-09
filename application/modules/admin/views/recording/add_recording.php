 <div class="row">
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
            
            <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
			 <div class="row">
		        <div class="row ">
		            <div class="col-lg-10">
		                <!-- post category -->
		                <!-- First Name -->
		                <div class="form-group">
		                    <label class="col-lg-4 control-label">Recording Title</label>
		                    <div class="col-lg-8">
		                        <input type="text" name="recording_title" class="form-control" placeholder=" Name of event"/>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-lg-4 control-label">Stream link</label>
		                    <div class="col-lg-8">
		                        <input type="text" name="recording_link" class="form-control" placeholder=" Link value"/>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-lg-4 control-label">Activate live stream?</label>
		                    <div class="col-lg-8">
		                        <input type="radio" name="recording_status"  checked value="1"> Yes
		                        <input type="radio" name="recording_status"  value="2"> No
		                    </div>
		                 </div>
		                <div class="form-actions center-align">
		                    <button class="submit btn btn-success" type="submit">
		                        Add recording
		                    </button>
		                </div>
		              
		            </div>
		        </div>
		      </div>
            <?php echo form_close();?>
		  </div>
    </div>
</div>
