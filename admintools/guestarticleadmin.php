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
          mysql_query("DELETE FROM guest_articles WHERE ID = $a");

          header("Location: $domain/admintools/guestarticleadmin.php");

        }

        $result=mysql_query(" SELECT ID, title from guest_articles ORDER by date desc ");

                        while ($row = mysql_fetch_array($result))
                        {
                          $a=$row[0];
                          $title=stripslashes($row[1]);

                          $display .= "<TR><TD><a href=\"/guestarticles.php?a=$a\">$title</a></TD><TD><a href=\"addguestarticle.php?a=$a&action=edit\">Edit</a></TD><TD><a href=\"javascript:CheckDelete('guestarticleadmin.php?action=delete&a=$a')\">Delete</a></TD></TR>";
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
                        if (confirm("You are about to permanently delete a guest article from the database. Do you want to proceed?"))
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
  <li><a href="addguestarticle.php">Add Guest Article</a>
  </ul>

<p><B>Edit/Delete Guest Article</B>

<p><TABLE WIDTH=600 BORDER=1>
$display
</TABLE>
</article>
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");

?>