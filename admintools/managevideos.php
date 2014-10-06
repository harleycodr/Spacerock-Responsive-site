<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    $action=$_GET['action'];
    $v=$_GET['v'];
    
    include ("../includes/dbconnect.php");
    if ($action == "delete" AND $v)
    {
      mysql_query("DELETE FROM videos WHERE ID = $v");
      
      header("Location: $domain/admintools/managevideos.php");
      
    }

    else
		{ 
			if ($result=mysql_query(" SELECT 
					ID, 
					title,
					featured
					from videos
					order by title"))
					{
                    while ($row = mysql_fetch_array($result))
                    {
                      $ID=$row[0];
                      $title=$row[1];
                      $featured=$row[2];
                      
                      if ($featured=="1")
                      {
                      	$flagged="x";
                      }
                      else
                      {
                      	$flagged="&nbsp;";
                      }	
                      
                      $display .= "<tr><td align=\"center\">$flagged</td><td align=center>$title</TD></TD><TD><a href=\"addvideo.php?v=$ID&action=edit\">Edit</a></TD><TD><a href=\"javascript:CheckDelete('managevideos.php?action=delete&v=$ID')\">Delete</a></TD></TR>\n";
                    }
			 }
			 else
			 {
				$error .= "<b>Error:</b>  Database query failed.\n";
			 }
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
<p><a href="index.php">Admin Home</a> > Manage Video Clips

<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a video from the database. Do you want to proceed?"))
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


  
  <p><ul>
  <li><a href="addvideo.php">Add New Video Clip</a>
  </ul>
  
<p><B>Edit/Delete Videos</B>

<p><TABLE WIDTH=600 BORDER=1>
<TR VALIGN=TOP>
<TD ALIGN=CENTER>
  <B>Featured on HP</B>
</TD>
<TD>
  <B>Title</B>
</TD>
<TD COLSPAN=2 ALIGN=CENTER>
  <B>Manage</B>
</TD>
</TR>
$display

</TABLE>

ENDTAG;
}
print "</article>\n";
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");

?>