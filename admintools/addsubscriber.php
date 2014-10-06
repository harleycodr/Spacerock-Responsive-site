<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_GET['dothis'];
$s=$_GET['s'];
$name=$_POST['name'];
$email=$_POST['email'];

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{

    $action=$_GET['dothis'];
    $s=$_GET['s'];
    
    include ("../includes/dbconnect.php");
    
    if ($link)
    {
    
    	if ($action=="edit")
    	{
    		$formaction="makeedits";
    		$heading="Edit subscriber Info";
    		
    		if ($result=mysql_query("SELECT
    					name,
    					email
    					from mailinglist
    					WHERE ID='$s'"))
    					{
    						while ($row=mysql_fetch_array($result))
    						{
    							$name=$row[0];
    							$email=$row[1];
    						}
    					}
                        else
                        {
                            $goof=mysql_error();
                            $error .= "<b>Error:</b>  $goof";
                        }
    	}
    	elseif ($action=="makeedits")
    	{
    	   $name=$_POST['name'];
           $email=$_POST['email'];
           
    		if ($result=mysql_query("UPDATE mailinglist
    			 SET
        	     	name='$name',
        	        email='$email'
  				  WHERE ID='$s'"))
    	      {
    	      	header ("Location:$domain/admintools/managemailinglist.php");
    	      }
    	      else
    	      {
    	        $goof=mysql_error();
    	      	$error .= "<b>Error:</b>  Database update failed.  $goof\n";
    	      }
    	}
    	elseif ($action=="addnew")
    	{
    	   $name=$_POST['name'];
           $email=$_POST['email'];
           
    		if ($result=mysql_query("INSERT into mailinglist
    			 SET
    	     	name='$name',
				email='$email',
				date=NOW()"))
    	      {
    	      	header ("Location:$domain/admintools/managemailinglist.php");
    	      }
    	      else
    	      {
    	        $goof=mysql_error();
    	      	$error .= "<b>Error:</b>  Database insert failed.  $goof\n";
    	      }
    	
    	}
		elseif(!$action)
		{
			$heading="Add Subscriber";
			$formaction="addnew";
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
ENDTAG;

if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{


print <<<ENDTAG
<p><a href="index.php">Admin home</a> > <a href="managemailinglist.php">Manage Mailing List</a> > $heading</p>

<p align="center"><span class="headline">$heading</span></p>

<p><form action="addsubscriber.php?dothis=$formaction&s=$s" method="post">
<table width=400 border=1 align=center>
<tr valign="top">
<td width=200>
	<b>Name:</b>
	<br /><input type="text" name="name" size="20" value="$name">
</td>
<td width=200>
	<b>Email:</b>
	<br /><input type="text" name="email" size="20" value="$email">
</td>
</tr>
</table>
<br /><center><input type="submit" value="$heading"></form>
</article>
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");


?>