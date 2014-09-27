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
$titletag="";

$n=$_REQUEST['n'];
$y=$_REQUEST['y'];
$page=$_REQUEST['page'];
// determine whether this is going to be a one or two column page
$referring_page=$_SERVER['HTTP_REFERER'];


include("includes/dbconnect.php");
if($link)
{
	if($n)
	{
		if($result=mysql_query("SELECT
			monthname(dateposted) as month,
			day(dateposted) as day,
			year(dateposted) as year,
			title,
			abstract,
			body,
			displayphoto,
			photo_caption
			from news
			where ID='$n'"))
			{
				while($row=mysql_fetch_array($result))
				{
					$month=$row[0];
					$day=$row[1];
					$year=$row[2];
					$thistitle=stripslashes($row[3]);
					$abstract=stripslashes($row[4]);
					$body=stripslashes($row[5]);
					$displayphoto=$row[6];
					$photo_caption=stripslashes($row[7]);
					
					$display .= "<h1 class=\"tac\">$thistitle</h1>\n";
					$display .= "<h3 class=\"tar\">Posted $month $day, $year</h3>\n";
					$display .= "<p class=\"tac\"><img src=\"/images/uploads/$displayphoto\" title=\"$photo_caption\" />\n";
					if($photo_caption)
					{
						$display .= "<br />$photo_caption\n";
					}
					$display .= "</p>\n";
					if($referring_page != $basepath)  // don't show abstract if they came from the home page - they've seen it.
					{
						$display .= "<p>$abstract</p>\n";
					}
					$display .= "<p>$body</p>\n";
				}
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b> $goof";
			}
			// get previous archives
			if($result2=mysql_query("SELECT
				title,
				ID
				from news where ID !=$n
				order by dateposted DESC LIMIT 15"))
				{
					while($row=mysql_fetch_array($result2))
					{
						$title=stripslashes($row[0]);
						$n=$row[1];
						
						$leftcol .= "<p><a href=\"news.php?n=$n\">$title</a></p>\n";
					}
				}
				else
				{
					$goof=mysql_error();
					$error = "<b>Error:</b> $goof";

			
			
				}
	}
	elseif ($y) // show by year
	{
		if($result=mysql_query("SELECT
			ID,
			title,
			monthname(dateposted) as month,
			day(dateposted) as day,
			year(dateposted) as year,
			displayphoto,
			abstract
			from news
			where year='$y'
			order by date DESC"))
			{
				while($row=mysql_fetch_array($result))
				{
					$n=$row[0];
					$title=stripslashes($row[1]);
					$month=$row[2];
					$day=$row[3];
					$year=$row[4];
					$displayphoto=$row[5];
					$abstract=stripslashes($row[6]);
					
					$display .= "<article class=\"posting\">\n";
					$display .= "<p><a href=\"news.php?n=$n\">$title</a><br />Posted $month $day, $year</p>\n";
					$display .= "<p><img src=\"/images/uploads/$displayphoto\">$abstract</p>\n";
					$display .= "<p class=\"tar fsi\"><a href=\"news.php?n=$n\">More</p>\n";
					$display .= "</article><!--posting end-->\n";
				}
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b>  $goof\n";
			}
	}
	else // show whole list
	{
		$listall="1";
		
		// pagination stuff start
		if(!$page)
		{
			$offset_limit="LIMIT 10";

			$this_page=1;

		}
		else
		{
			$this_page=$page;

			$figure_out=$page-1;

			$offset=10 * $figure_out;

			$offset_limit="LIMIT 10 OFFSET $offset";
		}
		
		if($result2=mysql_query("SELECT ID from news"))
		{
		   $count=mysql_num_rows($result2);
		}
		$page_count=$count/9;
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
			$pagination_links.="<a href=\"news.php?page=$last_page\"><</a> ";

		// show pages before this page


		$pagination_counter=1;

		while($pagination_counter<$this_page)
		{
			$pagination_links .= "<a href=\"news.php?page=$pagination_counter\">$pagination_counter</a>  ";
			$pagination_counter=$pagination_counter+1;
		}
		$pagination_links .= "<b>$this_page</b>  ";
			}
			else // this is page 1
			{
		$pagination_links.="<b>$this_page</b>  ";
			}


			// if this isn't the last page, make a link to the next
			if($this_page<$page_count)
			{
			  // show pages after
			$pagination_counter=$this_page+1;

			$last_page_limiter=$page_count+1;

			while($pagination_counter<$last_page_limiter)
			{
				$pagination_links .= "<a href=\"news.php?page=$pagination_counter\">$pagination_counter</a>  ";
				$pagination_counter=$pagination_counter+1;
			}

			  $pagination_links.="<a href=\"news.php?page=$next_page\" title=\"next\">></a>";
			}	
		else
		{
			$goof=mysql_error();
			$error="<b>Error:</b>  $goof";
		}
		// pagination stuff end
		if($result=mysql_query("SELECT
			ID,
			title,
			monthname(dateposted) as month,
			day(dateposted) as day,
			year(dateposted) as year,
			displayphoto,
			abstract
			from news
			order by dateposted DESC $offset_limit"))
			{
				while($row=mysql_fetch_array($result))
				{
					$n=$row[0];
					$title=stripslashes($row[1]);
					$month=$row[2];
					$day=$row[3];
					$year=$row[4];
					$displayphoto=$row[5];
					$abstract=stripslashes($row[6]);
					
					$display .= "<article class=\"posting\">\n";
					$display .= "<p><a href=\"news.php?n=$n\">$title</a><br />Posted $month $day, $year</p>\n";
					$display .= "<p><img src=\"/images/uploads/$displayphoto\">$abstract</p>\n";
					$display .= "<p class=\"tar fsi\"><a href=\"news.php?n=$n\">More</p>\n";
					$display .= "</article><!--posting end-->\n";
				}
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b>  $goof\n";
			}
	}
	
	// yearly archive listing for left col
	if($result3=mysql_query("SELECT
		DISTINCT
		year(dateposted)
		from news
		order by year(dateposted) DESC"))
		{
			while($row=mysql_fetch_array($result3))
			{
				$y=$row[0];
						
				$yearlyarchives .= "<p><a href=\"news.php?y=$y\">$y</a></p>\n";
			}
		}
		else
		{
			$goof=mysql_error();
			$error = "<b>Error:</b> $goof";
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
ENDTAG;

print <<<ENDTAG
	<aside id="in_this_section">
		<h1>Most Recent</h1>
		$leftcol
		
		<h1>Yearly Archives</h1>
		$yearlyarchives
	</aside>
	<article id="content_col">
ENDTAG;
if($listall=="1")
{
	print "<h1 class=\"tac\">All News Items</h1>\n";
	print "<p>$pagination_links</p>\n";
}
else
{
	print "<p class=\"breadcrumb\"><a href=\"news.php\">News</a> > $thistitle</p>\n";
}
print <<<ENDTAG

	$display
ENDTAG;
if($listall=="1")
{
	print "<p>$pagination_links</p>\n";
}
print <<<ENDTAG
	</article>
	
	</article><!--content end-->
ENDTAG;
}
include("footerinc.php");
?>