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
			echo '<p><strong>Meeting Title: </strong>'.$title.'</p><a href="'.site_url().'comments/'.$meeting_id.'">Back to comments</a>';
            ?>
            
            <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <!-- meeting comment -->
            <div class="form-group">
                <label class="col-lg-2 control-label">Comment</label>
                <div class="col-lg-10">
                    <textarea class="cleditor" name="meeting_comment_description" placeholder="meeting Content"><?php echo set_value('meeting_comment_description');?></textarea>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Add Comment
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>