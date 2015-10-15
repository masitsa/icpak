<?php
if ($query->num_rows() > 0)
{
            
	foreach ($query->result() as $row)
	{
		$article_id = $row->article_id;
        $article_title = $row->article_title;
        $article_author = $row->article_author;
        $article_description = $row->article_description;
        $article_short_desc = $row->article_short_desc;

        $article_date = $row->article_date;
        $meeting_date = date('jS M Y',strtotime($row->article_date));

        // get the articles attached to this 

        $attachments = $this->resources_model->get_attachments($article_id);
       

        // $meeting_mini_string = (strlen($meeting_content) > 15) ? substr($meeting_content,0,50).'...' : $meeting_content;
   		$title = strip_tags($row->article_title,'<p><a>');
        $mini_title = (strlen($title) > 30) ? substr($title,0,52).'...' : $title;
	}
	$result = '<h2 class="page_title">'.strip_tags($title).'</h2>
	 
		          <div class="post_single">
		                 
		            <div class="page_content"> 

		              <div class="entry">
		              	'.$article_description.'
		              </div>
		            </div>
		             <div class="page_content">';
		             	if ($attachments->num_rows() > 0)
						{
						       
								$result .=' 
				             	<ul class="simple_list">';
				             		foreach ($attachments->result() as $row_item)
									{

										$article_id = $row_item->article_id;
								        $kb_download = $row_item->kb_download;
								        $ext = $row_item->ext;
								        $hits = $row_item->hits;
								        $download_title = $row_item->download_title;

				             			// $result .='<li><a href="#" onclick="window.open("http://www.icpak.com/download.php?a_id='.$article_id.'&download='.$kb_download.', "_system", "location=yes"")">'.$download_title.'</a> </li>';
				             			$result .="<li><a href='#' onclick='get_download(".$article_id.",".$kb_download.");'>".$download_title."</a></li>";

				             		}
				             	$result .='	
				             	<ul>';
				         }
				     $result .='
		             </div>
		            
		          </div>
	          ';
}else
{
	$result = 'Data not found';
}
echo $result;
?>