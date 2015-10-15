<?php

$result = '<div class="page_content"> 
      
		    <div class="blog-posts">';
		       if ($query->num_rows() > 0)
                {

                $result .=' 

                      <ul class="posts-resources">';

				         foreach ($query->result() as $row)
                        {
                            $article_id = $row->article_id;
				            $article_title = $row->article_title;
				            $article_author = $row->article_author;
				            $article_description = $row->article_description;
				            $article_short_desc = $row->article_short_desc;

				            $article_date = $row->article_date;
				            $meeting_date = date('jS M Y',strtotime($row->article_date));
				           

				            // $meeting_mini_string = (strlen($meeting_content) > 15) ? substr($meeting_content,0,50).'...' : $meeting_content;
				       		$title = strip_tags($row->article_title,'<p><a>');
                            $mini_title = (strlen($title) > 30) ? substr($title,0,52).'...' : $title;
                            $result .='
                                <li>
                                    <div class="post_entry">
                                    	<div class="post_image">
                                            <div class="feat_small_icon"><img src="images/icons/black/download.png" alt="" title="" /></div>
                                        </div>
                                    	
                                        <div class="post_title_resourses">
                                       		<h3><a href="article-single.html?a_id='.$article_id.'" onclick="get_resources_description('.$article_id.')">'.strip_tags($mini_title,'<p><a>').'</a></h3>
                                       		
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
                        $result .= "There are no articles";
                    }
            $result .= '                
				</div>';
	echo $result;
?>