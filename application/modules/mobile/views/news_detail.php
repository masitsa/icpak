<?php
if ($query->num_rows() > 0)
{
            
	foreach ($query->result() as $row)
	{
		$id = $row->id;
		$title = $row->title;
		$alias = $row->alias;
		$title_alias = $row->title_alias;
		$urls = $row->urls;

		// $introtext = $row->introtext;
		$fulltext  = $row->fulltext;
		 // $fulltext = htmlentities($fulltext, UTF-8);
		$state = $row->state;
		$sectionid = $row->sectionid;
		$mask = $row->mask;

		$hits = $row->hits;
		$metadata = $row->metadata;
		$metadesc = $row->metadesc;
		$access = $row->access;

		$post_content = $row->introtext;
		 $date = date('jS M Y',strtotime($row->created));
		 $day = date('j',strtotime($row->created));
		 $month = date('M',strtotime($row->created));

		$mini_string = (strlen($post_content) > 15) ? substr($post_content,0,50).'...' : $post_content;
		$title = $row->title;
		$mini_title = (strlen($title) > 15) ? substr($title,0,50).'...' : $title;
	}
	$result = '<h2 class="page_title">'.strip_tags($title).'</h2>
	 
	          <div class="post_single">
	                 
	            <div class="page_content"> 

	              <div class="entry">
	              	'.strip_tags($post_content,'<p><a>').'
	              </div>
	            </div>
	            
	          </div>
	          
	          
	          <div class="page_content"> 
	          
	          <div class="buttons-row">
	                <a href="#tab1" class="tab-link active button">Leave a comment</a>
	                <a href="#tab2" class="tab-link button">Comments</a>
	          </div>
	          
	          <div class="tabs-animated-wrap">
	                <div class="tabs">
	                      <div id="tab1" class="tab active">
	                            <div class="commentform">
	                            <form id="CommentForm" method="post" action="">
	                            <label>Name:</label>
	                            <input type="text" name="CommentName" id="CommentName" value="" class="form_input" />
	                            <label>Email:</label>
	                            <input type="text" name="CommentEmail" id="CommentEmail" value="" class="form_input" />
	                            <label>Comment:</label>
	                            <textarea name="Comment" id="Comment" class="form_textarea" rows="" cols=""></textarea>
	                            <input type="submit" name="submit" class="form_submit" id="submit" value="Submit" />
	                            </form>
	                            </div>
	                      </div>

	                      <div id="tab2" class="tab">
	                            <ul class="comments">
	                                <li class="comment_row">
	                                    <div class="comm_avatar"><img src="images/icons/black/user.png" alt="" title="" border="0" /></div>
	                                    <div class="comm_content"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam velit sapien, eleifend in by <a href="#">John Doe</a></p></div>
	                                </li>
	                                <li class="comment_row">
	                                    <div class="comm_avatar"><img src="images/icons/black/user.png" alt="" title="" border="0" /></div>
	                                    <div class="comm_content"><p>Consectetur adipiscing elit. Nam velit sapien, eleifend in by <a href="#">John Doe</a></p></div>
	                                </li>
	                                <li class="comment_row">
	                                    <div class="comm_avatar"><img src="images/icons/black/user.png" alt="" title="" border="0" /></div>
	                                    <div class="comm_content"><p>Nam velit sapien, eleifend in by <a href="#">John Doe</a></p></div>
	                                </li>
	                                <div class="clear"></div>
	                            </ul>
	                      </div> 
	                </div>
	          </div>
	      
	         </div>';
}else
{
	$result = 'Data not found';
}
echo $result;
?>