<?php

include("includes/declarations.php");
$crawltsite=2;
require_once("/var/chroot/home/content/44/10809344/html/crawltrack/crawltrack.php");
$thismonth=date(m);
$thisday=date(d);
$thisdate="$thismonth$thisday";
$thisyear=date(Y);

$htoday="$thisyear$thismonth$thisday";
$crawltsite=1;

$today="$thisyear$thismonth$thisday";
$cid=$_POST['cid'];

$page=$_GET['page'];

$titletag = "My DVDs";
include("includes/moviedbconnect.php");
if($link)
{
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
      if($search=="1")
      {
        $thefirstquery="SELECT
               Title,
               runtime,
               Rating,
               Cover,
               ID,
               Synopsis,
               Media
             FROM
               ourmovies
               WHERE Title LIKE '%$searchrequest%'
            ORDER by Title $offset_limit";
      }
      
      elseif($cid>0)
      {
        $thefirstquery = "SELECT DISTINCT
           ourmovies.Title,
           hour(ourmovies.runtime) AS runhour,
		   minute(ourmovies.runtime) AS runmin,
           ourmovies.Rating,
           ourmovies.Cover,
           ourmovies.ID,
           ourmovies.Synopsis,
           ourmovies.Media,
		   location,
		   display_title
           FROM ourmovies
           LEFT JOIN moviesincategories ON moviesincategories.movieID = ourmovies.ID where moviesincategories.catid=$cid
           ORDER by ourmovies.Title $offset_limit";



        $thesecondquery="SELECT DISTINCT
                 ourmovies.Title
               FROM ourmovies
               LEFT JOIN moviesincategories ON moviesincategories.movieID = ourmovies.ID where moviesincategories.catid=$cid
               ORDER by ourmovies.Title";
        }
        elseif(!$cid || $cid=="0")
        {
            $thefirstquery="SELECT
               Title,
               hour(runtime) AS runhour,
			   minute(runtime) AS runmin,
               Rating,
               Cover,
               ID,
               Synopsis,
               Media,
			   location,
			   display_title,
			   year
             FROM
               ourmovies
            ORDER by Title $offset_limit";

            $thesecondquery="SELECT ID from ourmovies";
        }
        if($result=mysql_query("$thefirstquery"))

          	{
          	 $thecount=mysql_num_rows($result);
          		while($row=mysql_fetch_array($result))
          		{

          			$Title=stripslashes($row[0]);
          			$runhour=$row[1];
					$runmin=$row[2];
          			$Rating=$row[3];
          			$Cover=$row[4];
          			$m=$row[5];
          			$Synopsis=stripslashes($row[6]);
          			$Media=$row[7];
					$location=$row[8];
					$display_title=stripslashes($row[9]);
					$Year=$row[10];
					
					if($Media=="DVD")
					{
						$mediaicon="icon-dvd.png";
					}
					elseif($Media=="bluray")
					{
						$mediaicon="icon-bluray.png";
					}
					
					if($location=="Binder")
					{
						$location="Binder $m";
					}

                    // get teh category name
                    if($cid>0)
                    {
                        if($result2=mysql_query("SELECT
                        categoryname
                        from categories
                        where ID='$cid'"))
                        {
                            while($row=mysql_fetch_array($result2))
                            {
                              $displayedcategoryname=$row[0];
                            }
                        }
                        else
                        {
                            $goof=mysql_error();
                            $error="<b>Error:</b>  $goof";
                        }
                    }

    				if($Cover)
    				{
    					$coverdisplay = "<p style=\"text-align:center\"><img src=\"/images/covers/$Cover\" height=\"140\" style=\"border-radius:5px;-webkit-border-radius:5px; -moz-border-radius:5px;\" title=\"In $location\" /></p><p class=\"tac\"><img src=\"/images/$mediaicon\"   title=\"$Media\" /></p>\n";
    				}
    				elseif($Cover=="")
    				{
    					$coverdisplay = "<div style=\"width:100px;padding-top:50px;text-align:center;font-weight:bold;\">No Cover Available</div>";
    				}
					if($display_title)
					{
						$Title="$display_title";
					}
    				$display .= "<div class=\"moviecell\">\n";
    				$display .= "  <div class=\"moviecell_title\"><h4>$Title</h4>\n";
    				$display .= "   <div id=\"$m\" class=\"white_box\"><div class=\"arrow\"></div>\n";
                    $display .= "     <div class=\"white_content\">\n";
                    $display .= "        <p><b>$Title</b><br />Year:  $Year  Runtime:  $runhour:$runmin</p>  <p>$Synopsis</p>\n";
                    $display .= "     </div>\n";
                    $display .= "   </div>\n";
					$display .= "  </div><!--moviecell_title-->\n";

    				$display .= "  <div class=\"covercell\">$coverdisplay</div>\n";

                    $display .= "</div><!--moviecell-->";

					


          		}
          	}
          	else
          	{
          		$goof=mysql_error();
          		$error="<b>Error:</b>  $goof";
          	}
            // build page navigation
            // get a total item count

             if($resultlinks=mysql_query("$thesecondquery"))
               {
                  $thecount=mysql_num_rows($resultlinks);
               }
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
                $pagination_links.="<a href=\"dvds.php\"><img src=\"/images/arrow-first.png\" title=\"First page\" border=\"0\" /></a>&nbsp;<a href=\"dvds.php?page=$last_page\"><img src=\"/images/arrow-back.png\" title=\"Previous page\" border=\"0\" /></a>&nbsp;";

                // show pages before this page


                $pagination_counter=1;

                while($pagination_counter<$this_page)
                {
                    $pagination_links .= "<a href=\"dvds.php?page=$pagination_counter\">$pagination_counter</a>&nbsp;&nbsp;";
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
                    $pagination_links .= "<a href=\"dvds.php?page=$pagination_counter\">$pagination_counter</a>&nbsp;&nbsp;";
                    $pagination_counter=$pagination_counter+1;
                }

              $pagination_links.="<a href=\"dvds.php?page=$next_page\" title=\"next\"><img src=\"/images/arrow-next.png\" title=\"next\" border=\"0\" /></a>&nbsp;<a href=\"dvds.php?page=$page_count\" title=\"last\"><img src=\"/images/arrow-last.png\" title=\"Last page\" border=\"0\"></a>";
            }

    if($result2=mysql_query("SELECT
        ID,
        categoryname
        from categories
        order by categoryname"))
        {
            while($row=mysql_fetch_array($result2))
            {
                $c=$row[0];
                $categoryname=$row[1];



                $catselects .= "<option value=\"$c\" >$categoryname</option>\n";
            }
        }
        else
        {
            $goof=mysql_error();
            $error="<b>Error:</b>  $error";
        }
}
else
{
	$error = "<b>Error:</b>  No Database connection.\n";
}
include("includes/headerinc.php");

print <<<ENDTAG
<div class="clearfix"></div>
	<article id="content" class="clearfix">
ENDTAG;
if($error)
{
	print "<span class=\"error\">$error</span>\n";
}
else
{

print <<<ENDTAG
<p>$pagination_links</p>
<div id="movieholder">
$display
</div>
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("footerinc.php");
?>

