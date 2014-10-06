<?php
session_start();
	include("../includes/declarations.php");
	include("includes/declarations.php");
	$action=$_GET['action'];
	$a=$_GET['t'];
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    // make db connection
    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == "delete" AND $t)
        {
          mysql_query("DELETE FROM news WHERE ID = $a");

          header("Location: $domain/admintools/managetrivia.php");

        }

        $result=mysql_query(" SELECT id, title, text from interesting_facts ORDER by date desc ");

                        while ($row = mysql_fetch_array($result))
                        {
                          $id=$row[0];
                          $title=stripslashes($row[1]);
                          $text=stripslashes($row[2]);

                          $display .= "<TR><TD>$title</TD><TD><a href=\"addtrivia.php?t=$id&action=edit\">Edit</a></TD><TD><a href=\"javascript:CheckDelete('managetrivia.php?action=delete&t=$id')\">Delete</a></TD></TR>";
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
</article>
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
                        if (confirm("You are about to permanently delete a trivia item from the database. Do you want to proceed?"))
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
  <li><a href="addtrivia.php">Add Trivia Item</a>
  </ul>

<p><B>Edit/Delete Trivia Items</B>

<p><TABLE WIDTH=600 BORDER=1>
$display
</TABLE>

ENDTAG;
}
print "</article>\n";
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");

?>