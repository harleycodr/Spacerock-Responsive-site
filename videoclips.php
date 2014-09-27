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
$view=$_REQUEST['view'];
$v=$_REQUEST['v'];




include("includes/dbconnect.php");
if($link)
{
	switch($view)
	{
		case "v":
		      if ($single=mysql_query(" SELECT
                    title,
                    bigsource,
                    rating,
					description
                    from videos WHERE ID='$v'"))
		{
			while ($row=mysql_fetch_array($single))
			{
				$title=stripslashes($row[0]);
				$embedsource=$row[1];
				$rating=$row[2];
				$description=stripslashes($row[3]);
				
				$titletag="Favorite video clips:  $title";

				$display = "<p><a href=\"videoclips.php\">Videos</a> > $title</p>";
				$display .= "<h3>$title</span></center></h3>\n
				<p><center>$embedsource</center></p>\n
				<p>$description</p>\n";
			}

          }
          else
          {
              $error .= "<b>Error:</b>  Query for this video failed.\n";
          }	
		break;
		case "":
		$leftcol="0";
      	$count=0;
		$display .= "<h1>Video Clips</h1>\n";

		$display .= "<p class=\"fsi\">The following are favorite video clips of mine.</p>\n";
		$display .= "<div class=\"dbl_col_layout\">\n";
      	if ($result=mysql_query("SELECT
		title,
		embedsource,
		description,
		ID
		from videos
		order by title"))
      	{
			$vcount=mysql_num_rows($result);
			$division = $vcount / 2;
			$limit = round($division);
			
      		while ($row=mysql_fetch_array($result))
      		{
      			$title=stripslashes($row[0]);
      			$embedsource=$row[1];
      			$description=stripslashes($row[2]);
      			$ID=$row[3];

      				$display .= "<p><span class=\"fwb\"><a href=\"$videosurl?view=v&v=$ID\">$title</a></span><br />$description</p>\n";
					$count=$count+1;
      				if ($count=="$limit")
      				{
						$display .= "</div><div class=\"dbl_col_layout\">\n";
						$count=0;
      				}
      			}
      			$display.= "</div>\n";
      		}
      		else
      		{
      			$error .= "<b>Error:</b>  DB query failed.\n";
      		}
		break;
	}	// end of switch

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
$display
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("footerinc.php");
?>

