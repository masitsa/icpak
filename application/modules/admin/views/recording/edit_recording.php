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
            <?php
			 if($recording->num_rows() > 0)
            {
                foreach ($recording->result() as $key) {
                    # code...

                    $recording_id = $key->recording_id;
                    $recording_link = $key->recording_link;
                    $recording_status = $key->recording_status;
                    $recording_title = $key->recording_title;
                    $created = $key->created;
                ?>
                <div class="row">
                    <div class="row ">
                        <div class="col-lg-6">
                            <!-- post category -->
                            <!-- First Name -->
                           <!-- First Name -->
		                <div class="form-group">
		                    <label class="col-lg-4 control-label">Recording Title</label>
		                    <div class="col-lg-8">
		                        <input type="text" name="recording_title" class="form-control" placeholder=" Name of event" value="<?php echo $recording_title;?>" />
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-lg-4 control-label">Stream link</label>
		                    <div class="col-lg-8">
		                        <input type="text" name="recording_link" class="form-control" placeholder=" Link value" value="<?php echo $recording_link;?>" />
		                    </div>
		                </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Activate live stream?</label>
                                <div class="col-lg-8">

                                    <div class="radio">
                                        <label>
                                            <?php
                                            if($recording_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="recording_status">';}
                                            else{echo '<input id="optionsRadios1" type="radio" value="1" name="recording_status">';}
                                            ?>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <?php
                                            if($recording_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="recording_status">';}
                                            else{echo '<input id="optionsRadios1" type="radio" value="0" name="recording_status">';}
                                            ?>
                                            No
                                        </label>
                                    </div>
                                </div>
                             </div>
                            <div class="form-actions center-align">
                                <button class="submit btn btn-success" type="submit">
                                   Update recorded video

                                </button>
                            </div>
                          
                        </div>
                        <div class="col-lg-6">
                            <!-- post category -->
                            <!-- First Name -->
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <iframe width="100%" height="315" src="http://www.youtube.com/embed/<?php echo $recording_link;?>" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                <?php

            	}
            }
            else
            {
            }
            ?>
             <?php echo form_close();?>
		  </div>
    </div>
</div>
