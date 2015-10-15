<?php
$result = '';
if($active_sessions->num_rows() > 0){
	$total_points = 0;
	
	foreach ($active_sessions->result() as $row)
	{

		$event_session_id = $row->event_session_id;
		$event_session_status = $row->event_session_status;
		$event_session_code = $row->event_session_code;


		$result .='<h3> '.$event_session_code.' </h3>';

		$query = $this->queries_model->get_latest_session_question($event_session_code);
		if($query->num_rows() > 0){
		
			foreach ($query->result() as $row_two)
			{
				$session_question = $row_two->session_question;
				$email = $row_two->email;
				$name = $row_two->name;

				$result .= '<ul class="comments">';
				$result .= '
							<li class="comment_row question" >
			                   <div class="comm_content"><p>'.$session_question.' asked by <a href="#">'.$name.'</a></p></div>
			                </li>
							';

				$result .= ' </ul>';
			}
		}else
		{
			$result .='No questions made active';
		}
	}
}


echo $result;

?>