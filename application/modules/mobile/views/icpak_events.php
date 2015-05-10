<?php

$result = '<div class="page_content"> 
      
		    <div class="blog-posts">';
		       if ($query->num_rows() > 0)
                {

                $result .=' 

                      <ul class="posts-events">';

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
                            $result .='
                                <li>
                                    <div class="post_entry">
                                        <div class="post_date">
                                            <span class="day">'.$day.'</span>
                                            <span class="month">'.$month.'</span>
                                        </div>
                                        <div class="post_title">
                                       		<h2><a href="blog-single.html?id='.$id.'" onclick="get_events_description('.$id.')">'.strip_tags($mini_title,'<p><a>').'</a></h2>
                                        </div>
                                    </div>
                                </li>';
                        }
                        $result .='
                      </ul>
                    <div class="clear"></div>  
	                    <div id="loadMore"><img src="images/load_posts.png" alt="" title="" /></div> 
	                    <div id="showLess"><img src="images/load_posts_disabled.png" alt="" title="" /></div> 
                    </div>
                      ';
                    }
                    else
                    {
                        $result .= "There are no blog categories";
                    }
            $result .= '                
				</div>';
	echo $result;
?>