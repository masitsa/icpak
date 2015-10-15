<?php 

$result = '<div class="page_content"> 
            <div class="buttons-row">
                    <a href="#tab3" class="tab-link active button">ICPAK News</a>
                    <a href="#tab4" class="tab-link button">Econnect News</a>
              </div>
              
              <div class="tabs-simple">
                    <div class="tabs">
                      <div id="tab3" class="tab active">
                            <div class="blog-posts-events" id="icpaknews">';

                            if ($query->num_rows() > 0)
                            {
            
                            $result .=' 

                                  <ul class="posts">';
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

                                        $post_content = $row->fulltext;
                                         $date = date('jS M Y',strtotime($row->created));
                                        $publish_up = date('jS M Y',strtotime($row->publish_up));
                                         $day = date('j',strtotime($row->created));
                                         $month = date('M',strtotime($row->created));

                                        $mini_string = (strlen($post_content) > 15) ? substr($post_content,0,50).'...' : $post_content;
                                        $title = $row->title;
                                        $mini_title = (strlen($title) > 15) ? substr($title,0,50).'...' : $title;
                                        $result .='
                                            <li>
                                                <div class="post_entry">
                                                    <div class="post_date">
                                                        <span class="day">'.$day.'</span>
                                                        <span class="month">'.$month.'</span>
                                                    </div>
                                                    <div class="post_title">
                                                    <!--<h2><a href="blog-single.html?id='.$id.'">'.strip_tags($mini_title).'</a></h2>-->
                                                    <h3><a href="blog-single.html?id='.$id.'" onclick="get_news_description('.$id.')">'.strip_tags($mini_title).'</a></h3>
                                                        Views : '.$hits.' Published : '.$publish_up.'
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
                              
                            
                        </div>
                        <div id="tab4" class="tab">
                           <div class="blog-posts-ecconect" id="icpakecconect">';
                           if ($econnect_query->num_rows() > 0)
                            {
            
                            $result .='

                              <ul class="posts-ecconect"  id="icpakecconect">';
                                  foreach ($econnect_query->result() as $row_ecconect)
                                    {
                                         $id = $row_ecconect->id;
                                        $title = $row_ecconect->title;
                                        $alias = $row_ecconect->alias;
                                        $title_alias = $row_ecconect->title_alias;
                                        $urls = $row_ecconect->urls;

                                        // $introtext = $row_ecconect->introtext;
                                        $fulltext  = $row_ecconect->fulltext;
                                         // $fulltext = htmlentities($fulltext, UTF-8);
                                        $state = $row_ecconect->state;
                                        $sectionid = $row_ecconect->sectionid;
                                        $mask = $row_ecconect->mask;
                                        
                                        $hits = $row_ecconect->hits;
                                        $metadata = $row_ecconect->metadata;
                                        $metadesc = $row_ecconect->metadesc;
                                        $access = $row_ecconect->access;

                                        $post_content = $row_ecconect->fulltext;
                                         $date = date('jS M Y',strtotime($row_ecconect->created));
                                          $publish_upe = date('jS M Y',strtotime($row_ecconect->publish_up));
                                         $day = date('j',strtotime($row_ecconect->created));
                                         $month = date('M',strtotime($row_ecconect->created));

                                        $mini_string = (strlen($post_content) > 15) ? substr($post_content,0,50).'...' : $post_content;
                                        $title = $row_ecconect->title;
                                        $mini_title2 = (strlen($title) > 15) ? substr($title,0,50).'...' : $title;
                                        $result .='
                                            <li>
                                                <div class="post_entry">
                                                    <div class="post_date">
                                                        <span class="day">'.$day.'</span>
                                                        <span class="month">'.$month.'</span>
                                                    </div>
                                                    <div class="post_title">
                                                    <h3><a href="blog-single.html?id='.$id.'" onclick="get_news_description('.$id.')">'. strip_tags($mini_title2).'</a></h3>
                                                        Views : '.$hits.' Published : '.$publish_upe.'
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
                      </div> 
                    </div>
                </div>

            </div>';
echo $result;