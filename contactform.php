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


$name=$_REQUEST['name'];
$email=$_REQUEST['email'];
$message=$_REQUEST['message'];
$url=$_REQUEST['url'];


if(isset($url))
{
	// it's spam
	$display .= "<p>Thank you</p>\n";
}
else
{
	$to="mstevens713@gmail.com";
	$headers="From:  $email";
	$subject="Spacerock Website Inquiry";
	$body .= "Name:  $name\n";
	$body .= "E-mail:  $email\n";
	$body .= "Message:  $message\n";
	
	if(mail($to, $subject, $body, $headers))
	{
		$titletag = "Thanks for your message, $name";
		$display .= "<h1 class=\"tac\">Thank you for your message!</h1>\n";
		$display .= "<p>We will get back to you shortly!  Feel free to look around - there's a lot here.</p>\n";
	}
	else
	{
		$error = "<b>Error:</b>  Mail not sent.\n";
	}
}

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

	$display
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("../includes/footerinc.php");
?>

