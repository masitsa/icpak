 <?php
$result = '';
if($query->num_rows() > 0)
{
    foreach ($query->result() as $key) {
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
    
		 $result .='

			 <div class="page_content">
			        <h3>'.$event_name.'</h3>
			        <div class="videocontainer">
			        <iframe width="100%" height="300" src="http://www.youtube.com/embed/'.$streamer_link.'" frameborder="0"></iframe>
			        </div>
			       <div class="contactform">
			        <input type="button" data-popup=".popup-event-question" class="open-popup form_submit" name="submit" class="form_submit" id="submit" value="Ask a question" />

			       </div>
			 </div>
		  ';
	}
}
else
{
	$result = 'No streaming event currently';
}
echo $result;

?>