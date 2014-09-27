<?php
	// build nav
	    if(!$page)
		{
			$offset_limit="LIMIT 20";
			
			$this_page=1;
		}
		else
		{
			$this_page=$page;

			$figure_out=$page-1;

			$offset=20 * $figure_out;

			$offset_limit="LIMIT 20 OFFSET $offset";
		}
       if($albumcount=mysql_query("SELECT
            category_id
            from gallery_category"))
            {
                //while($row=mysql_fetch_array($albumcount))
                //{
                    $thecount=mysql_num_rows($albumcount);
                    
                    $page_count=$thecount/20;

                    $rounded=round($page_count);
    
                   if($rounded<$page_count)
                   {
                     $page_count=$rounded+1;
                   }
    
                     $next_page=$this_page+1;
    
                    $prev_page=$this_page-1;
    
                    // if this isn't the first page, make a link to the previous
                    if($prev_page>0)
                    {
                        $pagination_links.="<a href=\"photos.php\"><img src=\"/images/arrow-first.png\" title=\"First page\" border=\"0\" /></a>&nbsp;<a href=\photos.php?page=$last_page\"><img src=\"/images/arrow-back.png\" title=\"Previous page\" border=\"0\" /></a>&nbsp;";
        
                        // show pages before this page
        
        
                        $pagination_counter=1;
        
                        while($pagination_counter<$this_page)
                        {
                            $pagination_links .= "<a href=\"photos.php?page=$pagination_counter\">$pagination_counter</a>&nbsp;&nbsp;";
                            $pagination_counter=$pagination_counter+1;
                        }
                        $pagination_links .= "<b>$this_page</b>&nbsp;&nbsp;";
                    }
                    else // this is page 1
                    {
                        $pagination_links.="<b>$this_page</b>&nbsp;&nbsp;";
                    }
    
    
                // if this isn't the last page, make a link to the next
					if($this_page<$page_count)
					{
					  // show pages after
						$pagination_counter=$this_page+1;
		
						$last_page_limiter=$page_count+1;
		
						while($pagination_counter<$last_page_limiter)
						{
							$pagination_links .= "<a href=\"photos.php?page=$pagination_counter\">$pagination_counter</a>&nbsp;&nbsp;";
							$pagination_counter=$pagination_counter+1;
						}
		
					  $pagination_links.="<a href=\"photos.php?page=$next_page\" title=\"next\"><img src=\"/images/arrow-next.png\" title=\"next\" border=\"0\" /></a>&nbsp;<a href=\"photos.php?page=$page_count\" title=\"last\"><img src=\"/images/arrow-last.png\" title=\"Last page\" border=\"0\"></a>";
					}
                    
                    
                //}
            }
			else
            {
              $goof=mysql_error();
              $error="<b>Error:</b>  $goof\n";
            }
            
?>