<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    $imagedir="/home/content/44/10809344/html/spacerock/images/uploads";
    include ("../includes/dbconnect.php");
    include ("fckeditor.php");
    $action=$_GET['action'];
    $s=$_GET['s'];
    
    if ($link)
    {
      if ($action == "delete")
      {
    		if ($result=mysql_query("DELETE
    		      from mysites
    		      WHERE ID='$s'"))
    		      {
    		      	header ("Location:$domain/admintools/managemysites.php");
    		      }
    		      else
    		      {
    		      	$error.= "<b>Error:</b>  DB Deletion failed.\n";
    		      }
    	}
    	else
    	{
       
        if ($result=mysql_query("SELECT
                                ID,
                                sitename,
                                url
                                from mysites
                                ORDER by sitename"))
                                {
                                  while ($row=mysql_fetch_array($result))
                                  {
                                    $ID=$row[0];
                                    $sitename=stripslashes($row[1]);
                                    $url=$row[2];
                                    
                                    $display .= "<tr valign=\"top\"><td><a href=\"http://$url\" target=\"_blank\">$sitename</a></td><td><a href=\"addsite.php?action=edit&s=$ID\">Edit</a></td><td><a href=\"javascript:CheckDelete('managemysites.php?action=delete&s=$ID')\">Delete</a></td></tr>\n";
                                    
                                  }
                                }
                                else
                                {
                                  $error .= "<B>Error:</B>  Database query failed!\n";          
                                }
    
      }
    }
    else
    {
      $error .="<B>Error:</B>  Database connection failed.\n";
    }
}
else
{
    include("loginerror.php");
}


include("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
print <<<ENDTAG
<article id="content">
<script language="JavaScript">
<!--
function CheckDelete(redirect_url)
{
    if (confirm("You are about to permanently delete a site from the brag list. Do you want to proceed?"))
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

ENDTAG;

if ($error)
{
  print "<FONT COLOR=\"red\">$error</FONT>\n";
}
else
{
print <<<ENDTAG


<CENTER><SPAN CLASS="headline">E-Z Suite page Management - Adding one of my sites</SPAN></CENTER>
<p><a href="index.php">Site admin home</a> > Manage My Sites on my brag page
<p><CENTER><B>Manage My Sites (Brag Page content)</B>
<br /><a href="addsite.php">Add Site</a></CENTER>

<table width=400 align=center border=1>
$display
</table>
</article>
ENDTAG;
}

include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
?>