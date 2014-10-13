<?php
session_start();
include ("../includes/dbconnect.php");
if($link)
{
    if($adminloggedin=="1")
    {
		
				
		if($action=="addnew")
		{
					if($result=mysql_query("INSERT into toolpage_links
					SET
					name='".addslashes($name)."',
					url='$url',
					category='$category',
					description='".addslashes($description)."'"))
					{
						header("Location:http://www.spacerock.com/toolpage/admin.php");
					}
					else
					{
						$goof=mysql_error();
						$error="<b>Error:</b>  $goof";
					}
					
		}
		elseif($action=="edit")
		{
					$formaction="makeedits";
					$heading="Edit";
					
					if($result=mysql_query("SELECT
						name,
						url,
						category,
						description
						from toolpage_links
						where id='$l'"))
						{
							while($row=mysql_fetch_array($result))
							{
								$linkname=stripslashes($row[0]);
								$url=$row[1];
								$category=$row[2];
								$description=$row[3];
								
								if($resultb=mysql_query("SELECT
									namd
									from toolpage_link_categories
									where id='$category'"))
									{
										while($row=mysql_fetch_array($restultb))
										{
											$linkcatname=stripslashes($row[0]);
										}
									
									}
									else
									{
										$goof=mysql_error();
										$error="<b>Error:</b>  $goof";
									}
								
								$catselected = "<option value=\"$category\">$linkcatname</option>\n";
							
							}
						
						}
						else
						{
							$goof=mysql_error();
							$error="<b>Error:</b>  $goof";
						}
				}
				elseif($action=="makeedits")
				{
					if($result=mysql_query("UPDATE toolpage_links
					SET
					name='".addslashes($name)."',
					url='$url',
					category='$category',
					description='".addslashes($description)."'
					where id='$l'"))
					{
						header("Location:http://www.spacerock.com/toolpage/admin.php");
					}
					else
					{
						$goof=mysql_error();
						$error="<b>Error:</b>  $goof";
					}
				}
				elseif(!$action)
				{
					$formaction="addnew";
					$heading="Add";
				}
				// get categories for select list
				if($resultcat=mysql_query("SELECT
					id,
					name
					from toolpage_link_categories
					order by name"))
					{
						while($row=mysql_fetch_array($resultcat))
						{
							$linkcatid=$row[0];
							$linkcatname=$row[1];
							
							$linkcatselects .= "<option value=\"$linkcatid\">$linkcatname</option>\n";
						}
					
					}
					else
					{
						$goof=mysql_error();
						$error="<b>Error:</b>  $goof";
					}
}
      else
      {
        $error .= "<p><b>Login:</b></p>\n";
        $error .="<form action=\"login.php\" method=\"post\">\n";
        $error .="<div style=\"width:200px; margin-left:auto; margin-right:auto; border:solid thin blue;padding:5px;\">\n";
        $error .="<table width=\"200\">\n";
        $error .="<tr>\n";
        $error .="<td>\n";
        $error .="<b>Username:</b>\n";
        $error .="</td>\n";
        $error .="<td>\n";
        $error .="<input type=\"text\" name=\"user\" size=\"10\" />\n";
        $error .="</td>\n";
        $error .="</tr>\n";
        $error .="<tr>\n";
        $error .=" <td>\n";
        $error .="<b>Password:</b>\n";
        $error .="</td>\n";
        $error .="<td>\n";
        $error .="<input type=\"password\" name=\"pass\" size=\"10\" />\n";
        $error .="</td>\n";
        $error .="</tr>\n";
        $error .="</table>\n";
        $error .="<div align=\"center\">\n";
        $error .="<input type=\"submit\" value=\"Login\" />\n";
        $error .="</div>\n";
        $error .="</div></form>\n";
    }
}
else
{
	$error = "<b>Error:</b>  No db connection.\n";
}

include("header.php");

if($error)
{
	print "$error";
}
else
{
print <<<ENDTAG
<p><a href="admin.php">Admin</a> > Add Online Resource/Link</p>
<form action="$PHP_SELF?action=$formaction" method="post">
<table>
<tr>
					<td>
						Name:
						<br /><input type="text" name="name" value="$linkname" size="20" />
					</td>
					<td>
						URL:
						<br />http://<input type="text" name="url" size="20" value="$url" />
					</td>
					<td>
						Category:
						<br /><select name="category">
						$catselected
						$linkcatselects
						</select>
					</td>
					</tr>
					<tr>
					<td colspan="3">
						<textarea name="description" rows="4" cols="40">$description</textarea>
					</td>
					</tr>
					</table>
					<p><input type="submit" value=" $heading "></p>
					</form>
ENDTAG;
}

?>