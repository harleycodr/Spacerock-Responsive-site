<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    $v=$_GET['v'];
    $action=$_GET['action'];
    
    include ("../includes/dbconnect.php");
    if ($link)
    {
		$featured=$_POST['featured'];
        $title=$_POST['title'];
        $embedsource=$_POST['embedsource'];
        $rating=$_POST['rating'];
        $description=$_POST['description'];
        $bigsource=$_POST['bigsource'];
        $youtubeURL=$_POST['youtubeURL'];
        $thumb=$_POST['thumb'];
        $v=$_GET['v'];
		
    	if ($action=="edit")
    	{
    		$formaction="makeedits";
    		$heading="Edit Video Info";
    
    			if ($result=mysql_query(" SELECT
    					ID,
    					title,
    					featured,
    					embedsource,
    					rating,
    					description,
    					bigsource,
                        youtubeURL,
                        thumb
    					from videos
    					WHERE
    					ID='$v'"))
    					{
                        while ($row = mysql_fetch_array($result))
                        {
                          $ID=$row[0];
                          $title=stripslashes($row[1]);
                          $featured=$row[2];
                          $embedsource=$row[3];
                          $rating=$row[4];
                          $description=stripslashes($row[5]);
                          $bigsource=$row[6];
                          $youtubeURL=stripslashes($row[7]);
                          $thumb=$row[8];
                          if ($featured=="1")
                          {
                          	$featuredchecked=" checked";
                          }
                        }
    			 		}
    			 else
    			 {
    				$error .= "<b>Error:</b>  Database query failed.\n";
    			 }
    		}
    		elseif($action=="makeedits")
    		{
    		  
              
    			if ($featured=="on")
    			{
    				$featured="1";
    				$killfeature=mysql_query("UPDATE
    					 videos
    					 set featured='0'");
    			}
    			if ($result=mysql_query("UPDATE
    						videos
    						SET
    						title='".addslashes($title)."',
    						featured='$featured',
    						embedsource='$embedsource',
    						rating='$rating',
    						description='".addslashes($description)."',
    						bigsource='$bigsource',
                            youtubeURL='".addslashes($youtubeURL)."',
                            thumb='$thumb'
    						WHERE ID='$v'"))
    						{
    							header ("Location:$domain/admintools/managevideos.php");
    						}
    						else
    						{
    							$error .= "<b>Error:</b>  DB Update failed.\n";
    						}
    		}
    		elseif ($action=="addnew")
    		{
                  
    			if ($featured=="on")
    			{
    				$killfeature=mysql_query("UPDATE
    					 videos
    					 set featured='0'");
						 
					$featured="1";
					
    			}
    			if ($result=mysql_query("INSERT into
    						videos
    						SET
    						title='".addslashes($title)."',
    						featured='$featured',
    						embedsource='$embedsource',
    						rating='$rating',
    						description='".addslashes($description)."',
    						bigsource='$bigsource',
                            youtubeURL='".addslashes($youtubeURL)."',
                            thumb='$thumb'"))
    						{
    							header ("Location:$domain/admintools/managevideos.php");
    						}
    						else
    						{
    							$error .= "<b>Error:</b>  DB Insert failed.\n";
    						}
    
    		}
    		elseif (!$action)
    		{
    			$formaction="addnew";
    			$heading="Add Video";
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
<p><a href="index.php">Admin Home</a> > <a href="managevideos.php">Manage Video Clips</a> > $heading


<p><center><span class="headline">$heading</span></center></p>

<form action="addvideo.php?action=$formaction&v=$v" method="post">
<p><table width="400" border="1" align="center">
<tr valign="top">
<td align="right">
	<b>Title:</b>
</td>
<td>
	<input type="text" name="title" value="$title" size="30">
</td>
</tr>
<tr valign="top">
<td colspan="2">
	<input type="checkbox" name="featured"$featuredchecked> Feature on home page
</td>
</tr>
<tr valign="top">
<td align="right">
    Full Thumb URL:
</td>
<td>
    http://<input type="text" name="thumb" value="$thumb" size="30" />
</td>
</tr>
<tr valign="top">
<td colspan="2">
	<b>Embed Source:  (for full image)</b>
	<br />Paste original YouTube source here
	<br /><textarea name="bigsource" rows="10" cols="40" wrap="virtual">$bigsource</textarea>
</td>
</tr>
<tr valign="top">
<td colspan="2">
	<b>Embed Source:  (for small image)</b>
	<br />Important:  Make sure width is set at no more than 200!
	<br /><textarea name="embedsource" rows="10" cols="40" wrap="virtual">$embedsource</textarea>
</td>
</tr><tr valign="top">
<td colspan="2">
	<b>YouTube URL:  (for mobile version of site)</b>
	<br />http://<input type="text" name="youtubeURL" size="40" value="$youtubeURL" />
</td>
</tr>
<tr valign="top">
<td align="right">
	<b>Rating:</b>
</td>
<td>
	<select name="rating">
	<option value="G">G</option>
	<option value="PG-13">PG-13</option>
	<option value="PG">PG</option>
	<option value="R">R</option>
	</select>
</td>
</tr>
<tr valign="top">
<td colspan="2">
	<textarea name="description" rows="4" cols="40" wrap="virtual">$description</textarea>
</td>
</tr>
</table>
<br /><center><input type="submit" value=" $heading "></center></form>
</article>
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
?>