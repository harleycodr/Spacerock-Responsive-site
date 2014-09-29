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
$titletag="Photos";

$action=$_GET['action'];
$g=$_GET['g'];
$p=$_GET['p'];
$albumname=$_GET['albumname'];
$page=$_REQUEST['page'];

include("includes/dbconnect.php");
if($link)
{
	switch($action)
	{
		case "g":
		$display .= "<p><a href=\"photos.php\">All Albums</a></p>\n";
		
		if($result=mysql_query("SELECT
		category_name,
		description
		from gallery_category
		where category_id='$g' $offset_limit"))
		{
			while($row=mysql_fetch_array($result))
			{
				$category_name=stripslashes($row[0]);
				$description=stripslashes($row[1]);
				
				$display .= "<h1 class=\"tac\">$category_name</h1>\n";
				$display .= "<p>$description</p>\n";
			}
		}
		else
		{
			$goof=mysql_error();
			$error = "<b>Error:</b>  $goof\n";
		}
		if($result2=mysql_query("SELECT
			photo_id,
			photo_filename,
			photo_caption
			from gallery_photos
			where photo_category='$g' order by photo_id DESC"))
			{
				while($row=mysql_fetch_array($result2))
				{
					$p=$row[0];
					$filename=$row[1];
					$caption=stripslashes($row[2]);
					
					
					$display .= "<div class=\"photocell\">\n";
					$display .= "<p><a href=\"photos.php?action=p&p=$p&albumname=$category_name\"><img src=\"/photos/tb_$filename\" title=\"caption\" /></a></p>\n";
					$display .= "</div>\n";
				}
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b>  $goof\n";
			}
		break;
		case "p":
		if($result=mysql_query("SELECT
			photo_filename,
			photo_caption,
			photo_category
			from gallery_photos
			where photo_id='$p'"))
			{
				while($row=mysql_fetch_array($result))
				{
					$filename=$row[0];
					$caption=stripslashes($row[1]);
					$g=$row[2];
					
					$display .= "<p><a href=\"photos.php\">All Albums</a> > <a href=\"photos.php?action=g&g=$g&albumname=$albumname\">$albumname</a>\n";
					
					$display .= "<p class=\"tac\"><img src=\"/photos/$filename\" />\n";
					if($caption)
					{
						$display .= "<br />$caption\n";
					}
					$display .= "</p>\n";
				}
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b>  $goof\n";
			}
		break;
		case "":
		
		include("includes/pagination.php");
		
		$display .= "<div class=\"photonav\">$pagination_links</div>";
		$display .= "<div class=\"clearfix\" style=\"min-height:1em;\"></div>\n";
		if($result=mysql_query("SELECT
			category_id,
			category_name,
			leadpic
			from gallery_category
			order by category_id desc $offset_limit"))
			{
				while($row=mysql_fetch_array($result))
				{
					$g=$row[0];
					$category_name=$row[1];
					$leadpic=$row[2];
					
					$display .= "<div class=\"photocell\">\n";
					$display .= "<a href=\"photos.php?action=g&g=$g\"><img src=\"/photos/$leadpic\" /></a><p><span class=\"caption\">$category_name</span></p>\n";
					$display .= "</div>\n";
				}
				$display .= "<div class=\"photonav\">$pagination_links</div>";
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b>  $goof\n";
			}
		default:
		
		
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
<!-- use this for 2 col -->
	<!--aside id="in_this_section">
	
	</aside>
	<article id="content_col">
	
	</article-->
<!--2 col end-->
<!-- otherwise just put the content here-->
	$display
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("includes/footerinc.php");
?>

