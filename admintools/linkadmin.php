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
          mysql_query("DELETE FROM links WHERE ID = $a");

          header("Location: $domain/admintools/linkadmin.php");

        }

        if($result=mysql_query(" SELECT ID, category, title, description, url, homepage, rating from links order by title "))
		{

                        while ($row = mysql_fetch_array($result))
                        {
                          $ID=$row[0];
                          $category=$row[1];
                          $title=$row[2];
                          $description=$row[3];
                          $url=$row[4];
                          $homepage=$row[5];
                          $rating=$row[6];

                          if (!$homepage)
                          {
                            $homepage="&nbsp;";
                          }
                          if ($rating=="1")
                          {
                          	$rank="<IMG SRC=\"/images/saturn.gif\">\n";
                          }
                          elseif ($rating=="2")
                          {
                          	$rank="<IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\">\n";
                          }
                          elseif ($rating=="3")
                          {
                          	$rank="<IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\">\n";
                          }
                          elseif ($rating=="4")
                          {
                          	$rank="<IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\">\n";
                          }
                          elseif ($rating=="5")
                          {
                          	$rank="<IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\"><IMG SRC=\"/images/saturn.gif\">\n";
                          }

    		      else
    		      {
    		      	$rank="<CENTER>-</CENTER>";
    		      }

                          $display .= "<TR><TD>$rank</TD><TD ALIGN=CENTER>$homepage</TD><TD><a href=\"http://$url\" TARGET=\"_new\">$title</a></TD><TD><a href=\"add_link.php?a=$ID&action=edit\">Edit</a></TD><TD><a href=\"javascript:CheckDelete('$PHP_SELF?action=delete&a=$ID')\">Delete</a></TD></TR>";
                        }

    $categories=mysql_query(" SELECT category from linkcategories");
                          while ($row = mysql_fetch_array($categories))
                          {
                            $categoryname=$row[0];

                            $existingcategories .= "<li>$categoryname";
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
        $error="<b>Error:</b>  No db connection.\n";
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
<p><a href="index.php">Admin Home</a> > Link Admin

<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a link from the database. Do you want to proceed?"))
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

<p><a href="JavaScript:SmallWindow1('addlinkcategory.php')">Add Link Category</a>
<p><B>Existing Categories:</B>
  <ul>
    $existingcategories
  </ul>
<p><a href="add_link.php">Add New Link</a>
<p><B>Edit/Delete Links</B>

<p><TABLE WIDTH=600 BORDER=1 style="border:solid thin;">
<TR VALIGN=TOP>
<TD ALIGN=CENTER>
	<B>Rating</B>
</TD>
<TD ALIGN=CENTER>
  <B>Featured on HP</B>
</TD>
<TD>
  <B>Name</B>
</TD>
<TD COLSPAN=2 ALIGN=CENTER>
  <B>Manage</B>
</TD>
</TR>$display
</TABLE>
</article>
ENDTAG;

include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
}
?>