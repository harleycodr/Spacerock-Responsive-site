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
$titletag="Website Portfolio of Marian Stevens";


include("includes/portfolioconnect.php");
if($link)
{
$page=$_GET['page'];

if($this_page=="")
{
	$this_page="1";
}

if($link)
{

	if(!$page)
	{
		$offset_limit="LIMIT 12";
	}
	else
	{
		$this_page=$page;

		$figure_out=$page-1;

		$offset=12 * $figure_out;

		$offset_limit="LIMIT 12 OFFSET $offset";
		

	}
	if($result=mysql_query("SELECT
		name,
		url,
		screenshot,
		comments,
		industry,
		live,
		ID
		from portfolio
		WHERE display_in_portfolio='1'
		order by date desc $offset_limit"))
		{
			while($row=mysql_fetch_array($result))
			{
				$name=stripslashes($row[0]);
				$url=$row[1];
				$screenshot=$row[2];
				$comments=stripslashes($row[3]);
				$industry=$row[4];
				$live=$row[5];
				$siteID=$row[6];
				
				$display .= "<div class=\"thumbcell desktop_view\">\n";
				$display .= "<div class=\"portthumb\"  id=\"$siteID\" style=\"background:url(http://www.yourgreatwebsite.com/images/screenshots/med_$screenshot); background-repeat:no-repeat;\"><img src=\"images/shim.png\" height\"100\" width=\"100%\" id=\"$siteID\" title=\"Click to enlarge\" /></div>\n";
				if($live=="1")
				{
					$display .= "<br /><a href=\"http://$url\" target=\"_blank\">Visit Site</a></p>\n";
				}
				$display .= "</div><!--thumbcell desktop view-->\n";
				
				$display .= "<div class=\"thumbcell mobile_view\">\n";
				$display .= "<div class=\"portthumb\" style=\"background:url(http://www.yourgreatwebsite.com/images/screenshots/med_$screenshot); background-repeat:no-repeat;\"><img src=\"images/shim.png\" height\"100\" width=\"100%\" /></div>\n";
				if($live=="1")
				{
					$display .= "<br /><a href=\"http://$url\" target=\"_blank\">Visit Site</a></p>\n";
				}
				$display .= "</div><!--thumbcell desktop view-->\n";
								
				
				$lightboxes .= "<div class=\"lightbox\" id=\"site$siteID\"><div class=\"close\" id=\"close$siteID\"></div>\n";
				$lightboxes .= "<h3 class=\"tac\">$name</h3>\n";
				$lightboxes .= "<p class=\"tac\"><img src=\"http://www.yourgreatwebsite.com/images/screenshots/med_$screenshot\" title=\"$name\" </p>\n";
				$lightboxes .= "<p>$comments</p>\n";
				if($live=="1")
				{
					$lightboxes .= "</br><span  class=\"tac\"><a href=\"http://$url\" target=\"_blank\">Visit Site</a></span>\n";
				}
				$lightboxes .= "</p></div>\n";
			}
		}
		else
		{
			$goof=mysql_error();
			$error = "<b>Error:</b>  $goof\n";
		}
		// make the pagination
		if($result2=mysql_query("SELECT name from portfolio"))
		{
			$portcount=mysql_num_rows($result2);
		}
		else
		{
			$goof=mysql_error();
			$error="<b>Error:</b>  $goof";
		}
		$page_count=$portcount/12;
		$rounded=round($page_count);
		if($rounded<$page_count)
        {
            $page_count=$rounded+1;
        }
		
        $next_page=$this_page+1;

        $prev_page=$this_page-1;
        // if this isn npt the first page, make a link to the previous
        if($prev_page>0)
        {
            $pagination_links.="<a href=\"portfolio.php?page=$prev_page\"><</a>&nbsp;";

                // show pages before this page


                $pagination_counter=1;

                while($pagination_counter<$this_page)
                {
                    $pagination_links .= "<a href=\"portfolio.php?page=$pagination_counter\">$pagination_counter</a>&nbsp;&nbsp;";
                    $pagination_counter=$pagination_counter+1;
                }
                $pagination_links .= "<b>$this_page</b>&nbsp;&nbsp;";
            }
            else // this is page 1
            {
                $pagination_links.="<b>$this_page</b>&nbsp;&nbsp;";
            }


            // if this is not the last page, make a link to the next
            if($this_page<$page_count)
            {
              // show pages after
                $pagination_counter=$this_page+1;

                $last_page_limiter=$page_count+1;

                while($pagination_counter<$last_page_limiter)
                {
                    $pagination_links .= "<a href=\"portfolio.php?page=$pagination_counter\">$pagination_counter</a>&nbsp;&nbsp;";
                    $pagination_counter=$pagination_counter+1;
                }

              $pagination_links.="<a href=\"portfolio.php?page=$next_page\" title=\"next\">></a>";
            }
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
	<h1 class="tac">Website Portfolio</h1>
	<p class="tar">$pagination_links</p>
	
	$display
	
	<p class="tar" style="clear:both;">$pagination_links</p>
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
	$lightboxes
ENDTAG;
include("inclues/footerinc.php");
?>