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
	              	'.$post_content.'
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