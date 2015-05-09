
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
            if($live_stream->num_rows() > 0)
            {
                foreach ($live_stream->result() as $key) {
                    # code...

                    $live_stream_id = $key->live_stream_id;
                    $event_name = $key->event_name;
                    $event_description = $key->event_description;
                    $activate_stream = $key->activate_stream;
                    $streamer_link = $key->streamer_link;
                    $created = $key->created;
                    $created_by = $key->created_by;
                    $users = $key->users;
                    $streaming_status = $key->streaming_status;
                }
                ?>
                <div class="row">
                    <div class="row ">
                        <div class="col-lg-6">
                            <!-- post category -->
                            <!-- First Name -->
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Event name</label>
                                <div class="col-lg-8">
                                    <input type="text" name="event_name" class="form-control" placeholder=" Name of event" value="<?php echo $event_name;?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Live stream link</label>
                                <div class="col-lg-8">
                                    <input type="text" name="event_link" class="form-control" placeholder=" Link value" value="<?php echo $streamer_link;?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Activate live stream?</label>
                                <div class="col-lg-8">

                                    <div class="radio">
                                        <label>
                                            <?php
                                            if($activate_stream == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="activate_stream">';}
                                            else{echo '<input id="optionsRadios1" type="radio" value="1" name="activated">';}
                                            ?>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <?php
                                            if($activate_stream == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="activated">';}
                                            else{echo '<input id="optionsRadios1" type="radio" value="0" name="activated">';}
                                            ?>
                                            No
                                        </label>
                                    </div>
                                </div>
                             </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Event Description</label>
                                <div class="col-lg-8">
                                    <textarea name="event_description" class="form-control" rows="7" placeholder=" description"/> </textarea>
                                </div>
                            </div>
                            <div class="form-actions center-align">
                                <button class="submit btn btn-success" type="submit">
                                   Stop Braodcasting

                                </button>
                            </div>
                          
                        </div>
                        <div class="col-lg-6">
                            <!-- post category -->
                            <!-- First Name -->
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <iframe width="100%" height="315" src="http://www.youtube.com/embed/<?php echo $streamer_link;?>" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                <?php

            }
            else
            {
                ?>
                <div class="row">
                    <div class="row ">
                        <div class="col-lg-6">
                            <!-- post category -->
                            <!-- First Name -->
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Event name</label>
                                <div class="col-lg-8">
                                    <input type="text" name="event_name" class="form-control" placeholder=" Name of event"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Live stream link</label>
                                <div class="col-lg-8">
                                    <input type="text" name="event_link" class="form-control" placeholder=" Link value"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Activate live stream?</label>
                                <div class="col-lg-8">
                                    <input type="radio" name="activated"  checked value="1"> Yes
                                    <input type="radio" name="activated"  value="2"> No
                                </div>
                             </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Event Description</label>
                                <div class="col-lg-8">
                                    <textarea name="event_description" class="form-control" rows="7" placeholder=" description"/> </textarea>
                                </div>
                            </div>
                            <div class="form-actions center-align">
                                <button class="submit btn btn-success" type="submit">
                                    Save and start bradcasting
                                </button>
                            </div>
                          
                        </div>
                        <div class="col-lg-6">
                            <!-- post category -->
                            <!-- First Name -->
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <iframe width="100%" height="315" src="http://www.youtube.com/embed/8AaLMBz283w" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                <?php

            }
            ?>
             
            <?php echo form_close();?>
		</div>
        <div class="padd">
            <?php
                
                //if users exist display them
                $result ='';
                if ($questions_query->num_rows() > 0)
                {
                    $count = $page;
                    
                    $result .= 
                    '
                        <table class="table table-hover table-bordered table-responsive">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Viewer Name</th>
                              <th>meeting Date</th>
                              <th>Comment Date</th>
                              <th>Status</th>
                              <th colspan="5">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                    ';
                    foreach ($questions_query->result() as $row)
                    {
                        $streaming_comment_id = $row->streaming_comment_id;
                        $event_name = $row->event_name;
                        $streaming_comment_status = $row->streaming_comment_status;
                        $streaming_comment_user = $row->streaming_comment_user;
                        $streaming_comment_description = $row->streaming_comment_description;
                        
                        //status
                        if($streaming_comment_status == 1)
                        {
                            $status = 'Active';
                        }
                        else
                        {
                            $status = 'Disabled';
                        }
                        
                        //create deactivated status display
                        if($streaming_comment_status == 0)
                        {
                            $status = '<span class="label label-important">Deactivated</span>';
                            // $button = '<a class="btn btn-info" href="'.site_url().'activate-comment/'.$streaming_comment_id.'/'.$live_stream_id.'" onclick="return confirm(\'Do you want to activate '.$streaming_comment_user.' comment?\');">Activate</a>';
                        }
                        //create activated status display
                        else if($streaming_comment_status == 1)
                        {
                            $status = '<span class="label label-success">Active</span>';
                            // $button = '<a class="btn btn-info" href="'.site_url().'deactivate-comment/'.$streaming_comment_id.'/'.$live_stream_id.'" onclick="return confirm(\'Do you want to deactivate '.$streaming_comment_user.' comment?\');">Deactivate</a>';
                        }
                        
                        $count++;
                        $result .= 
                        '
                            <tr>
                                <td>'.$count.'</td>
                                <td>'.$event_name.'</td>
                                <td>'.$streaming_comment_user.'</td>
                                <td>'.date('jS M Y H:i a',strtotime($row->streaming_created)).'</td>
                                <td>'.date('jS M Y H:i a',strtotime($row->streaming_created)).'</td>
                                <td>'.$status.'</td>
                                <td>
                                    
                                    <!-- Button to trigger modal -->
                                    <a href="#user'.$streaming_comment_id.'" class="btn btn-primary" data-toggle="modal">View</a>
                                    
                                    <!-- Modal -->
                                    <div id="user'.$streaming_comment_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">By '.$streaming_comment_user.' on '.date('jS M Y H:i a',strtotime($row->streaming_created)).'</h4>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    <p>
                                                    `'.$streaming_comment_description.'
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    
                                                    <a href="'.site_url().'delete-comment/'.$streaming_comment_id.'/'.$live_stream_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$streaming_comment_user.' comment?\');">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                </td>
                                <td><a href="'.site_url().'delete-comment/'.$streaming_comment_id.'/'.$live_stream_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$streaming_comment_user.' comment?\');">Delete</a></td>
                            </tr> 
                        ';
                    }
                    
                    $result .= 
                    '
                                  </tbody>
                                </table>
                    ';
                }
                
                else
                {
                    $result .= "There are no meetings";
                }
                
                echo $result;
        ?>
        </div>
    </div>
</div>
