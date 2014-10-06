<?php

session_start();
include("includes/declarations.php");

include ("includes/dbconnect.php");

  $year=date("Y");
  $month=date("m");
  $date=date("d");
$name=$_POST['name'];
$email=$_POST['email'];

// check to make sure they aren't a spam bot
$sFormRef = getenv('HTTP_REFERER');
$iPos = strrpos($sFormRef,"/");
$sFormRef = substr($sFormRef,$iPos+1);

if(($sFormRef == "subscribe.php"))
{

	// check verification graphic

		if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
		// Insert you code for processing the form here, e.g emailing the submission, entering it into a database.
		// they typed in the right letters
		// check to see if they have already subscribed

			$duplicate=mysql_query("SELECT ID from mailinglist WHERE email='$email'");
			if (mysql_num_rows($duplicate) > 0)
			{
				$display .= "<p align=\"center\">Our records indicate you are already subscribed to this list.\n";
				$display .= "</br><a href=\"index.php\>Home</a></p>\n";
			}
			else
			{

				if (mysql_query("INSERT into mailinglist
					SET
					name = '$name',
					email = '$email',
					date=NOW()"))
					{
						$display .= "<P>Thank you for your subscription.\n";


					}
					else
					{
						$display .= "<P><FONT COLOR=\"red\"><B>Error:</B>  Database entry failed.\n";
					}

					$subid=mysql_insert_id($mysql_link);


		 // send a verification e-mail
						$to = "$email";


						$title = "$subjectline:  $subject";
						$headers = "From: do-not-reply@spacerock.com\n";
						$headers .="X-Mailer: PHP5\n";
						$headers .="MIME-Version: 1.0\n";
						$headers .="Content-type: multipart/alternative; boundary=\"=ABC_123\"\n\n";

						$message .="This is a multi-part message in MIME format.\n\n";

						$message .="--=ABC_123\n";

						$message .="Content-Type: text/plain; charset=\"iso-8859-1\"\n";
						$message .="Content-Transfer-Encoding: 7bit\n\n";
						$message .= "Thanks for subscribing to our mailinglist.\n\n";
						$message .= "You are receiving this message because you have subscribed to Spacerock.com.\n";
						$message .= "If you no longer wish to receive these messages, please click the link below to unsubscribe.\n";
						$message .= "If you cannot click the link below, please copy and paste it into your browser's location.\n";
						$message .= "<A HREF=\"http://www.spacerock.com/unsubscribe.php?ID=$subid&action=doublecheck\">Unsubscribe</A>\n";
						$message .="--=ABC_123\n";
						$message .="Content-Type: text/html; charset=\"iso-8859-1\"\n";
						$message .="Content-Transfer-Encoding: 7bit\n\n";

						$message .="<html><head><title>$subjectline:  $subject</title></head><body>\n";



					$to = "mbriones@gmail.com";
	//        $to = "mbriones@yourgreatwebsite.com";
					$headers = "From:  $email";
					$subject = "Spacerock.com E-=mail Subscription";
					$body .= "$name has signed up for your mailing list.\n";
					$body .= "http://www.spacerock.com.com/toolsuite/managemailinglist.php\n";
					mail($to, $subject, $body, $headers );
		 }
		unset($_SESSION['security_code']);
   }
    else
    {
		// Insert your code for showing an error message here
		$display .= "Sorry, you have provided an invalid security code";

    }
}
else
{
  $display = "<B>Unauthorized Page Referrer";
}

include ("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
print <<<ENDTAG
<title>Spacerock.com - Thank you for subscribing.</title>
ENDTAG;
include ("navinclude.php");
if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{
print <<<ENDTAG
<!--this is if there is a column-->
    <div id="sidecol" >


  <p><b>In this Section :</b>
			<br /><a href="messageme.php">Contact Me</a>
			<br /><a href="subscribe.php">Subscribe to my Mailing List</a></p>

      </div>

        <div id="maincolfull">



$display
</div>
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
?>