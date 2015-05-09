<div class="row">
    <div class="col-lg-12">
     <a href="<?php echo site_url();?>meetings" class="btn btn-primary pull-right">Back to meetings</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
      <style type="text/css">
	  	.add-on{cursor:pointer;}
	  </style>
      <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
      <div class="padd">
        <!-- Adding Errors -->
        <?php
        if(isset($error)){
            echo '<div class="alert alert-danger">'.$error.'</div>';
        }
        
        $validation_errors = validation_errors();
        
        if(!empty($validation_errors))
        {
            echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
        }
        ?>
        
        <?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
        <div class="row">
            <div class="row">
                <div class="col-lg-6">
                    <!-- meeting category -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">meeting Category</label>
                        <div class="col-lg-8">
                        	<?php echo $categories;?>
                        </div>
                    </div>
                    <!-- meeting Name -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Meeting Title</label>
                        <div class="col-lg-8">
                        	<input type="text" class="form-control" name="meeting_title" placeholder="Meeting Title" value="<?php echo set_value('meeting_title');?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Contact Person</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="contact_person" placeholder="Contact Person" value="<?php echo set_value('contact_person');?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Telephone</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="telephone" placeholder="Telephone number" value="<?php echo set_value('telephone');?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Activate meeting?</label>
                        <div class="col-lg-8">
                            <input type="radio" name="meeting_status" checked  value="1"> Yes
                            <input type="radio" name="meeting_status" value="1"> No
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Meeting location</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="meeting_location" placeholder="Meeting location" value="<?php echo set_value('meeting_location');?>" required>
                        </div>
                    </div>
                    <!-- Image -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Meeting Date</label>
                        
                        <div class="col-lg-8">
                            <div id="datetimepicker1" class="input-append">
                                <input data-format="yyyy-MM-dd" class="form-control" type="text" name="meeting_date"  id="datepicker" placeholder="Meeting Date" value="<?php echo set_value('meeting_date');?>">
                                <span class="add-on">
                                    &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Activate checkbox -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Meeting End Date</label>
                        
                        <div class="col-lg-8">
                            <div id="datetimepicker1" class="input-append">
                                <input data-format="yyyy-MM-dd" class="form-control" type="text" name="meeting_end_date" id="datepicker" placeholder="Meeting  End Date" value="<?php echo set_value('meeting_end_date');?>">
                                <span class="add-on">
                                    &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-lg-4 control-label">Start time : </label>
                            
                        <div class="col-lg-8">
                            <div id="datetimepicker2" class="input-append">
                               <input data-format="hh:mm" class="picker" id="times" name="times"  type="text" class="form-control"><br/>
                               <span class="add-on" style="cursor:pointer;">
                                 &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                 </i>
                               </span>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- meeting content -->
                <div class="form-group">
                    <label class="col-lg-2 control-label">Meeting Content</label>
                    <div class="col-lg-8" style="height:auto;">
                        <textarea class="cleditor" name="meeting_content" placeholder="meeting Content"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-actions center-align">
                    <button class="submit btn btn-primary" type="submit">
                        Add a new meeting
                    </button>
                </div>
            </div>
        </div>
        <?php echo form_close();?>
	</div>
    </div>
</div>