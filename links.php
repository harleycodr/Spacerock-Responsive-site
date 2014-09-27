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


include("includes/dbconnect.php");
if($link)
{
 // count links for nice page division
  $linkcount = mysql_query(" SELECT ID from links ");
  $records=mysql_num_rows($linkcount);

  $division = $records / 3;
  $limit = round($division);

  $count="1";
  $col="1";
  $display .= "<div class=\"trpl_col\">\n";
     if($categorysort=mysql_query(" SELECT
        ID,
        category
        from linkcategories
        order by category"))
        {
			while($row=mysql_fetch_array($categorysort))
			{
				$ID=$row[0];
				$category=stripslashes($row[1]);


				$display .= "<h3>$category</h3>";
				$display .= "<ul>";
				$thiscatrunningcount=0;

				if($linklist=mysql_query("SELECT
					title,
					description,
					url
					from links
					where category='$ID'
					order by title"))
					{
						while($row=mysql_fetch_array($linklist))
						{
							$title=stripslashes($row[0]);
							$description=stripslashes($row[1]);
							$url=$row[2];

							$thiscatlinkcount=mysql_num_rows($linklist);

							$thiscatrunningcount=$thiscatrunningcount+1;

							$display .= "<li><a href=\"http://$url\" target=\"_blank\">$title</a>";
							if($description)
							{
								$display .= "<br />$descriptionn";
							}
							$display .= "</li>";



							if($count=="$limit")
							{
								$display .= "</ul></div><div class=\"middle_col">\n";

								if($thiscatrunningcount<$thiscatlinkcount)
								{
									$remainder=$thiscatlinkcount-$thiscatrunningcount;

									$display .= "<h3>$category <i>(continued)</i></h3>";
								}
								$display .= "<ul>";
								$count=1;
							}
							else
							{
						      $count=$count+1;
							}
						}
						$display .= "</ul>";
					}

					else
					{
						$goof=mysql_error();
						$error = "<b>Error:</b>  $goof";
					}
				}
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b>  $goof";
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

	$display-->
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("footerinc.php");
?>

