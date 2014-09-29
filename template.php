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
	<aside id="in_this_section">
	
	</aside>
	<article id="content_col">
	
	</article>
<!--2 col end-->
<!-- otherwise just put the content here-->
	<!--$display-->
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("includes/footerinc.php");
?>

