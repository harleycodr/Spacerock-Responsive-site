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

	<aside id="in_this_section">
		<h2>In This Section</h2>
		<p><a href="portfolio.php">Web Portfolio</a></p>
		<p><a href="/playground" target="_blank">Code Portfoliio</a>
		<br />(opens new window)</p>
		<p><a href="resume.php">Resume</a></p>
	</aside>
	<article id="content_col">
		<h1 class="tac">About Me</h1>
		<p><img src="images/meflag.jpg" class="img_right" />My name is Marian and I like developing websites. My hobbies and interests besides the internet and fun with web pages include riding my Harley, watching auto racing, fitness, healthy cooking, writing programs, stained glass, desktop publishing, my cats, fine (and not so fine) wines, vegetable gardening, canning and preserving, and making an extra dollar when I can.</p>

		<p>Things I like: Writing code, camping, playing with my cats, searching for my tortoise (and finding him) riding my Harley, cooking, creating, curling up with a good 'junk food for the mind' romantic novel, and creating stained glass pieces.</p>

		<p>Things I don't like: Driving, traffic jams, dogs, rude people, tense moments, stupid people, having tons of Tupperware but no lids to match, new years eve parties and people on cell phones in restaurants.</p>

		<p>I've grown a bit since the picture above <grin>. You can always find out what the latest and greatest site improvements(?) have occurred by checking my <a href="news.php">news page</a>. You can also find me on <a href="http://www.facebook.com/marian.briones" target="_blank">Facebook</a>.</p>
	
	</article>

ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("includes/footerinc.php");
?>

