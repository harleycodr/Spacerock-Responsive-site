<?php

session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_GET['dothis'];
$s=$_GET['s'];

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{

    include ("../includes/dbconnect.php");
    
    if ($link)
    {
    
    	if ($action=="delete")
    	{
    		if ($result=mysql_query("DELETE
    					from mailinglist
    					where ID='$s'"))
    					{
    						header ("Location:$domain/admintools/managemailinglist.php");
    					}
    	}
    	else
    	{
    		if ($result=mysql_query("SELECT
    	      ID,
    	      name,
    	      email,
    	      month(date) AS month,
    	      dayofmonth(date) AS day,
    	      year(date) AS year
    	      from mailinglist
    	      ORDER by name"))
    	      {
    	      	while ($row=mysql_fetch_array($result))
    	      	{
    	      		$ID=$row[0];
    	      		$name=$row[1];
    	      		$email=$row[2];
    	      		$month=$row[3];
    	      		$day=$row[4];
    	      		$year=$row[5];
    	      		
    	      		if ($month)
    	      		{
          			$datesubbed="$month/$day/$year";
    	      		}
    	      		else
    	      		{
    	      			$datesubbed="-";
    	      		}	
    	      		
    	      		$display .= "<tr><td>$name</td><td><a href=\"mailto:$email\">$email</a></td><td>$datesubbed</td><td><a href=\"addsubscriber.php?dothis=edit&s=$ID\">Edit</a></td><td><a href=\"javascript:CheckDelete('managemailinglist.php?dothis=delete&s=$ID')\">Delete</a></td></tr>\n";
    	      		
    	      		$count=mysql_num_rows($result);
    	      	}
    	      }
    	}
    }
    else
    {
    	$error .= "<b>Error:</b>  Database connection failed.\n";
    }

}
else
{
    
    include("loginerror.php");
}
include("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
print <<<ENDTAG
<article id="content">
<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a subscriber  from the database. Do you want to proceed?"))
                        {
                          location.replace(redirect_url);
                        }
                        else
                        {
                          alert("Deletion cancelled.");
                        }
                    }

 </script>
ENDTAG;
if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{
print <<<ENDTAG
<p><a href="index.php">Admin home</a> > Manage Mailing List</p>

<p align="center"><span class="headline">Manage Mailing List</span>
<br /><a href="addsubscriber.php">Add Subscriber</a></p>
<p><i>$count subscribers</i></p>
<p><table width=400 border=1 align=center>
$display
</td>
</tr>
</table>
</p>
</article>

ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");


?>