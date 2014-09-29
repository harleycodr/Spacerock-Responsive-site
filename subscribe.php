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


$first=$_REQUEST['first'];
$last=$_REQUEST['last'];
$email=$_REQUEST['email'];



include("includes/dbconnect.php");
if($link)
{
	if($result=mysql_query("INSERT
		into mailinglist
		set
		first='$first',
		last='$last',
		email='$email',
		date=NOW()"))
		{
			$to="mstevens713@gmail.com";
			$headers="From:  $email";
			$subject="Spacerock Mailing List Signup";
			$body .= "Name:  $name\n";
			$body .= "E-mail:  $email\n";
			
			if(mail($to, $subject, $body, $headers))
			{
				$titletag = "Thanks for your message, $name";
				$display .= "<h1 class=\"tac\">Thank you for joining my Mailing list!</h1>\n";
				$display .= "<p>You can unsubscribe at any time,  Feel free to look around - there's a lot here.</p>\n";
			}
			else
			{
				$error = "<b>Error:</b>  Mail not sent.\n";
			}
			
		}
		else
		{
			$goof=mysql_error();
			$error = "<b>Error:</b>  $goof\n";
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

	$display
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("includes/footerinc.php");
?>

