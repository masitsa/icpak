<?php
if ($query->num_rows() > 0)
{
            
	foreach ($query->result() as $row)
	{
		$id = $row->id;
	    $categoryID = $row->categoryID;
	    $date1 = $row->date1;
	    $date2 = $row->date2;
	    $date3 = $row->date3;

	    $from_time = $row->from_time;
	    $to_time = $row->to_time;
	    $entryName = $row->entryName;
	    $entryPlace = $row->entryPlace;
	    $entryLatLon = $row->entryLatLon;
	    
	    $entryInfo = $row->entryInfo;
	    $contactName = $row->contactName;
	    $contactEmail = $row->contactEmail;
	    $contactWebSite = $row->contactWebSite;
	    $contactTelephone = $row->contactTelephone;
	    $entryAddress = $row->entryAddress;
	    $price = $row->price;
	    $meeting_date = date('jS M Y',strtotime($row->date1));
	    $meeting_date = date('jS M Y',strtotime($row->date1));
	    $day = date('j',strtotime($row->date1));
	    $month = date('M',strtotime($row->date1));
	    $meeting_content = $row->entryInfo;
	    if(is_int($day))
	     {
	        $day = '0$day';
	     }
	     else
	     {
	        $day = $day;
	     }

	    // $meeting_mini_string = (strlen($meeting_content) > 15) ? substr($meeting_content,0,50).'...' : $meeting_content;
		$title = strip_tags($row->entryName,'<p><a>');
	    $mini_title = (strlen($title) > 15) ? substr($title,0,50).'...' : $title;
	}
	$result = '<h2 class="page_title">'.strip_tags($title).'</h2>
	 
	          <div class="post_single">
	                 
	            <div class="page_content"> 

	              <div class="entry">
	              <h3>Event Detail:</h3>
	              <ul class="simple_list">
		              <li>Dates : '.$meeting_date.'</li>
		              <li>Place : '.$entryPlace.'</li>
		              <li>Contact Person : '.$contactName.'</li>
		              <li>Telephone : '.$contactTelephone.'</li>
	              </ul>
	              	'.$meeting_content.'
	              </div>
	            </div>
	            
	          </div>
	          ';
}else
{
	$result = 'Data not found';
}
echo $result;
?>