<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
	$action=$_GET['action'];
	$b=$_GET['b'];
	
// make db connection
    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == "delete" AND $b)
        {
          mysql_query("DELETE FROM bookshelf WHERE ID = $b");

          header("Location: $domain/admintools/managebooks.php");

        }

        $result=mysql_query(" SELECT id,
			title, subtitle from bookshelf
			order by title");

            while ($row = mysql_fetch_array($result))
            {
				$b=$row[0];
				$title=stripslashes($row[1]);
				$subtitle=stripslashes($row[2]);

    		      
				$display .= "<tr><td>$title $subtitle</a></td><td><a href=\"addbook.php?b=$b&action=edit\">Edit</a></td><td><a href=\"javascript:CheckDelete('managebooks.php?action=delete&b=$b')\">Delete</a></td></tr>";
          }

    }
    else
    {
        $error="<b>Error:</b>  No db conetion.\n";
    }
}
else
{
    $error = "<b>Error:</b>  You  must be logged in to view this page and contents.<br /><a href=\"index.php\">Continue</a>\n";

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
<p><a href="index.php">Admin Home</a> > Manage Bookshelf

<h2>Manage Bookshelf</h2>
<p class="tac"><a href="addbook.php">Add New</a></p>
<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a book from the database. Do you want to proceed?"))
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


<p><table width="600" border="1">
<tr VALIGN=TOP>
<td>
  <b>Title</b>
</td>
<td COLSPAN=2 ALIGN=CENTER>
  <B>Manage</B>
</td>
</tr>
$display
</table>
</article>
ENDTAG;

include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
}
?>