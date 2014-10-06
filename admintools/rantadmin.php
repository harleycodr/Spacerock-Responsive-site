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
          mysql_query("DELETE FROM rants WHERE ID = $a");

          header("Location: $domain/admintools/rantadmin.php");

        }

        $result=mysql_query(" SELECT ID, date, title from rants order by date DESC");

                        while ($row = mysql_fetch_array($result))
                        {
                          $ID=$row[0];
                          $date=$row[1];
                          $title=stripslashes($row[2]);

                          $display .= "<TR><TD>$date:  <a href=\"../rants.php?a=$ID\">$title</a></TD><TD><a href=\"add_rant.php?a=$ID&action=edit\">Edit</a></TD><TD><a href=\"javascript:CheckDelete('$PHP_SELF?action=delete&a=$ID')\">Delete</a></TD></TR>";
                        }
    }
    else
    {
        $error = "<b>Error:</b>  No DB connection.";
    }
}
 else
 {
    include("$loginerror.php");
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
<p><a href="index.php">Admin Home</a> > Rant Admin

<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a rant from the database. Do you want to proceed?"))
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

<p><a href="add_rant.php">Add New Rant</a>
<p><B>Edit/Delete Rant Articles</B>

<p><TABLE WIDTH=600 BORDER=1>
$display
</TABLE>

ENDTAG;
}
print "</article>\n";
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");

?>