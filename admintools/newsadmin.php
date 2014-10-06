<?php
session_start();
	include("../includes/declarations.php");
	include("includes/declarations.php");
	$action=$_GET['action'];
	$a=$_GET['a'];
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    // make db connection
    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == "delete" AND $a)
        {
          mysql_query("DELETE FROM news WHERE ID = $a");

          header("Location: $domain/admintools/newsadmin.php");

        }

        $result=mysql_query(" SELECT ID, title, url from news ORDER by date desc ");

                        while ($row = mysql_fetch_array($result))
                        {
                          $ID=$row[0];
                          $title=$row[1];
                          $url=$row[2];

                          $display .= "<TR><TD><a href=\"/news11.php?a=$ID\">$title</a></TD><TD><a href=\"add_news.php?a=$ID&action=edit\">Edit</a></TD><TD><a href=\"javascript:CheckDelete('$PHP_SELF?action=delete&a=$ID')\">Delete</a></TD></TR>";
                        }
    }
    else
    {
        $error="<b>Error:</b>  No DB link.";
    }
}
else
{
    include("loginerror.php");
}

include("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");

print <<<ENDTAG
<article id="content">
ENDTAG;
if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{

print <<<ENDTAG
<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a news item from the database. Do you want to proceed?"))
                        {
                          location.replace(redirect_url);
                        }
                        else
                        {
                          alert("Deletion cancelled.");
                        }
                    }

                    -->
</SCRIPT>

   <script LANGUAGE="JavaScript">

   <!--



        function SmallWindow1(wintype) {

        SmallWin=window.open(wintype,"SmallWin","toolbar=no,directories=no,status=no,scrollbars=yes,menubar=no,width=400,height=400"); SmallWin.window.focus() }


 -->

   </script>


<p><a href="index.php">Site Admin Home</a>
  <p><ul>
  <li><a href="add_news.php">Add News Item - a Page or URL</a>
  </ul>

<p><B>Edit/Delete news Items</B>

<p><TABLE WIDTH=600 BORDER=1>
$display
</TABLE>

ENDTAG;
print "</article>\n";
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");

?>