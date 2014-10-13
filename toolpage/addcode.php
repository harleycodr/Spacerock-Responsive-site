<?php
session_start();
$adminloggedin=$_SESSION['adminloggedin'];
include ("../includes/dbconnect.php");

// include("../includes/declarations.php");

include("includes/tpdeclarations.php");

$domain="www.marianswebsite.com/spacerock";


if($link)
{
    if($adminloggedin=="1")
    {
        $loginlogout="<a href=\"logout.php\">Logout</a>&nbsp;&nbsp;<a href=\"admin.php\">Admin</a>\n";
        if($action=="edit")
        {
            

            $formaction="makeedits";
    	    if($result=mysql_query("SELECT
    		name,
            category,
            directions,
            code,
            description,
            comments,
            pre_code,
            directions2,
            directions3,
            code2,
            code3,
            pre_code2,
            pre_code3,
			demo_frame,
			download
            from toolpage_code
    		where id='$codeid'"))
    		{
    		  while($row=mysql_fetch_array($result))
              {
    			$name=stripslashes($row[0]);
                $category=$row[1];
                $directions=stripslashes($row[2]);
                $code=stripslashes($row[3]);
                $description=stripslashes($row[4]);
                $comments=stripslashes($row[5]);
                $pre_code=stripslashes($row[6]);
                $directions2=stripslashes($row[7]);
                $directions3=stripslashes($row[8]);
                $code2=stripslashes($row[9]);
                $code3=stripslashes($row[10]);
                $pre_code2=stripslashes($row[11]);
                $pre_code3=stripslashes($row[12]);
				$demo_frame=$row[13];
				$zip=$row[14];
                
                
                $directions = str_replace("<br />","\n",$directions);
                $directions2 = str_replace("<br />","\n",$directions2);
                $directions3 = str_replace("<br />","\n",$directions3);
/*                $code = str_replace("<","&lt;",$code);
                $code = str_replace(">","&gt;",$code);
                $code2 = str_replace("<br />","\n",$code2);
                $code2 = str_replace("<","&lt;",$code2);
                $code2= str_replace(">","&gt;",$code2);
                $code3 = str_replace("<br />","\n",$code3);
                $code3 = str_replace("<","&lt;",$code3);
                $code3 = str_replace(">","&gt;",$code3);*/
                $comments = str_replace("<br />","\n",$comments);
                $pre_code = str_replace("<br />","\n",$pre_code);
                $pre_code = str_replace("<","&lt;",$pre_code);
                $pre_code = str_replace(">","&gt;",$pre_code);
                $pre_code2 = str_replace("<br />","\n",$precode2);
                $pre_code2 = str_replace("<","&lt;",$pre_code2);
                $pre_code2 = str_replace(">","&gt;",$pre_code2);
                $pre_code3 = str_replace("<br />","\n",$precode3);
                $pre_code3 = str_replace("<","&lt;",$pre_code3);
                $pre_code3 = str_replace(">","&gt;",$pre_code3);
                $description = str_replace("<br />","\n",$description);
                
                $heading="Edit $name";
              }
             }
            else
            {
				$goof=mysql_error();
    			$error="<b>Error:</b>  $goof\n";
            }
    			
  		}
        elseif($action=="makeedits")
        {
		
			if($upload)
			{
				$thisyear=date(Y);
              $thismonth=date(m);
              $thisday=date(d);
              $thishour=date(G);
              $thisminute=date(i);
              $thissecond=date(s);
				
				
				$newfile="$thisyear$thismonth$thisday$thishour$thisminute$thissecond.zip";
				
				copy($upload, "/home/content/44/10809344/html/SPACEROCK/toolpage/uploads/$newfile");
			}
			else
			{
				$newfile=$oldzip;
			}
			
			
            $inputdirections = str_replace("\n","<br />",$directions);
            $inputdirections2 = str_replace("\n","<br />",$directions2);
            $inputdirections3 = str_replace("\n","<br />",$directions3);
            $inputcode = str_replace("<","&lt;",$code);
            $inputcode = str_replace(">","&gt;",$inputcode);
  //          $inputcode = str_replace("\n","<br />",$inputcode);
            $inputcode2 = str_replace("<","&lt;",$code2);
            $inputcode2 = str_replace(">","&gt;",$inputcode2);
            //$inputcode2 = str_replace("\n","<br />",$inputcode2);
            $inputcode3 = str_replace("<","&lt;",$code3);
            $inputcode3 = str_replace(">","&gt;",$inputcode3);
            //$inputcode3 = str_replace("\n","<br />",$inputcode3);
            $inputcomments = str_replace("\n","<br />",$comments);
            $pre_code = str_replace("<","&lt;",$pre_code);
            $pre_code = str_replace(">","&gt;",$pre_code);
//            $pre_code = str_replace("\n","<br />",$pre_code);
            $pre_code = str_replace(" ","&nbsp;",$pre_code);
            $pre_code2 = str_replace("<","&lt;",$pre_code2);
            $pre_code2 = str_replace(">","&gt;",$pre_code2);
 //           $pre_code2 = str_replace("\n","<br />",$pre_code2);
            $pre_code2 = str_replace(" ","&nbsp;",$pre_code2);
            $pre_code3 = str_replace("<","&lt;",$pre_code3);
            $pre_code3 = str_replace(">","&gt;",$pre_code3);
 //           $pre_code3 = str_replace("\n","<br />",$pre_code3);
            $pre_code = str_replace(" ","&nbsp;",$pre_code3);
            $inputdescription = str_replace("\n","<br />",$description);
			$demo_frame=$_REQUEST['demo_frame'];
            
            if($result=mysql_query("UPDATE
                toolpage_code
                set name='".addslashes($name)."',
                directions='".addslashes($inputdirections)."',
                directions2='".addslashes($inputdirections2)."',
                directions3='".addslashes($inputdirections3)."',
                code='".addslashes($inputcode)."',
                code2='".addslashes($inputcode2)."',
                code3='".addslashes($inputcode3)."',
                description='".addslashes($inputdescription)."',
                comments='".addslashes($inputcomments)."',
                pre_code='".addslashes($pre_code)."',
                pre_code2='".addslashes($pre_code2)."',
                pre_code3='".addslashes($pre_code3)."',
				demo_frame='$demo_frame',
				download='$newfile'
                where id='$codeid'"))
                {
                    header("Location:http://toolpage.spacerock.com/admin.php");
                }
                else
                {
                    $goof=mysql_error();
                    $error="<b>Error:</b>  $goof";
                }
        }
        elseif($action=="addnew")
        {
		
			if($upload)
			{
				
				$thisyear=date(Y);
              $thismonth=date(m);
              $thisday=date(d);
              $thishour=date(G);
              $thisminute=date(i);
              $thissecond=date(s);
				
				
				$newfile="$thisyear$thismonth$thisday$thishour$thisminute$thissecond.zip";

				
				
				
				copy($upload, "/home/content/44/10809344/html/SPACEROCK/toolpage/uploads/$newfile.zip");
			}
			
            $inputdirections = str_replace("\n","<br />",$directions);
            $inputdirections2 = str_replace("\n","<br />",$directions2);
            $inputdirections3 = str_replace("\n","<br />",$directions3);
            $inputcode = str_replace("<","&lt;",$code);
            $inputcode = str_replace(">","&gt;",$inputcode);
            //$inputcode = str_replace("\n","<br />",$inputcode);
            $inputcode2 = str_replace("<","&lt;",$code2);
            $inputcode2 = str_replace(">","&gt;",$inputcode2);
            //$inputcode2 = str_replace("\n","<br />",$inputcode2);
            $inputcode3 = str_replace("<","&lt;",$code3);
            $inputcode3 = str_replace(">","&gt;",$inputcode3);
            //$inputcode3 = str_replace("\n","<br />",$inputcode3);
            $inputcomments = str_replace("\n","<br />",$comments);
            $pre_code = str_replace("<","&lt;",$pre_code);
            $pre_code = str_replace(">","&gt;",$pre_code);
            //$pre_code = str_replace("\n","<br />",$pre_code);
            $pre_code = str_replace("\s","&nbsp;",$pre_code);
            $pre_code2 = str_replace("<","&lt;",$pre_code2);
            $pre_code2 = str_replace(">","&gt;",$pre_code2);
    //        $pre_code2 = str_replace("\n","<br />",$pre_code2);
            $pre_code = str_replace("\s","&nbsp;",$pre_code2);
            $pre_code2 = str_replace("<","&lt;",$pre_code3);
            $pre_code2 = str_replace(">","&gt;",$pre_code3);
            $pre_code2 = str_replace("\n","<br />",$pre_code3);
            $pre_code = str_replace("\s","&nbsp;",$pre_code3);
            $inputdescription = str_replace("\n","<br />",$description);
            
            if($result=mysql_query("INSERT into
                toolpage_code
                set name='".addslashes($name)."',
                directions='".addslashes($inputdirections)."',
                directions2='".addslashes($inputdirections2)."',
                directions3='".addslashes($inputdirections3)."',
                code='".addslashes($inputcode)."',
                code2='".addslashes($inputcode2)."',
                code3='".addslashes($inputcode3)."',
                description='".addslashes($inputdescription)."',
                comments='".addslashes($inputcomments)."',
                pre_code='".addslashes($pre_code)."',
                pre_code2='".addslashes($pre_code2)."',
                pre_code3='".addslashes($pre_code3)."',
                category='$catid',
				demo_frame='$demo_frame',
				download='$newfile'"))
                {
                    header("Location:http://toolpage.spacerock.com/admin.php");
                }
                else
                {
                    $goof=mysql_error();
                    $error="<b>Error:</b>  $goof";
                }
            
        }
        if(!$action)
        {
            $heading="Add New Code Snippet";
            $formaction="addnew&catid=$catid";
        }
		
		if($catid=="11")
		{
				if($result=mysql_query("SELECT
					id,
					name
					from toolpage_link_categories
					order by name"))
					{
						while($row=mysql_fetch_array($result))
						{
							$catid=$row[0];
							$catname=stripslashes($row[1]);
							
							$catselects.="<option value=\"$catid\">$catname</option>\n";
						}
					
					}
					else
					{
						$goof=mysql_error();
						$error="<b>Error:</b>  $goof";
					}
				
				if($action=="addnewlink")
				{
					if($result=mysql_query("INSERT into toolpage_links
					SET
					name='".addslashes($name)."',
					url='$url',
					category='$category',
					description='".addslashes($description)."'"))
					{
						header("Location:http://toolpage.spacerock.com/admin.php");
					}
					else
					{
						$goof=mysql_error();
						$error="<b>Error:</b>  $goof";
					}
					
				}
				elseif($action=="editlink")
				{
					$formaction="makelinkedits";
					
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
				elseif($action=="makelinkedits")
				{
					if($result=mysql_query("UPDATE toolpage_links
					SET
					name='".addslashes($name)."',
					url='$url',
					category='$category',
					description='".addslashes($description)."'
					where id='$l'"))
					{
						header("Location:http://$host/toolpage/admin.php");
					}
					else
					{
						$goof=mysql_error();
						$error="<b>Error:</b>  $goof";
					}
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
				
					$display .= "<p><a href=\"admin.php\">Admin</a> > Add Online Resource/Link</p>\n";
					$display .= "<form action=\"addcode.php?action=$formaction\" method=\"post\">\n";
					$display .= "<table>\n";
					$display .= "<tr>
					<td>
						Name:
						<br /><input type=\"text\" name=\"name\" value=\"$linkname\" size=\"20\" />
					</td>
					<td>
						URL:
						<br />http://<input type=\"text\" name=\"url\" size=\"20\" value=\"$url\" />
					</td>
					<td>
						Category:
						<br /><select name=\"category\">
						$catselected
						$linkcatselects
						</select>
					</td>
					</tr>
					<tr>
					<td colspan=\"3\">
						<textarea name=\"description\" rows=\"4\" cols=\"40\">$description</textarea>
					</td>
					</tr>
					</table>
					<p><input type=\"submit\" value=\" $heading \"></p>
					</form>\n";
			
		}
		else
		{
		
        
			$display .= "<p><a href=\"admin.php\">Admin</a> > $heading</p>
			<h1>$heading</h1>
			<form action=\"addcode.php?action=$formaction&codeid=$codeid\" method=\"post\" enctype=\"multipart/form-data\">
			<table width=\"700\" border=\"1\" align=\"center\">
			<tr valign=\"top\">
			<td>
				<b>Name:</b>
			</td>
			<td>
				<input type=\"text\" name=\"name\" value=\"$name\" size=\"80\" />
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Directions:</b>
				<br /><textarea name=\"directions\" rows=\"3\" cols=\"80\">$directions</textarea>
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Pre-Code to display outside the form (if any):</b>
				<br /><textarea name=\"pre_code\" rows=\"3\" cols=\"80\">$pre_code</textarea>
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Code to show in the form:</b>
				<br /><textarea name=\"code\" rows=\"3\" cols=\"80\">$code</textarea>
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Directions & Code Part 2:</b>
				<br /><textarea name=\"directions2\" rows=\"3\" cols=\"80\">$directions2</textarea>
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Pre-Code to display outside the form (if any):</b>
				<br /><textarea name=\"pre_code2\" rows=\"3\" cols=\"80\">$pre_code2</textarea>
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Code to show in the form:</b>
				<br /><textarea name=\"code2\" rows=\"3\" cols=\"80\">$code2</textarea>
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Directions & Code Part 3:</b>
				<br /><textarea name=\"directions3\" rows=\"3\" cols=\"80\">$directions3</textarea>
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Pre-Code to display outside the form (if any):</b>
				<br /><textarea name=\"pre_code3\" rows=\"3\" cols=\"80\">$pre_code3</textarea>
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Code to show in the form:</b>
				<br /><textarea name=\"code3\" rows=\"3\" cols=\"80\">$code3</textarea>
			</td>
			</tr>
			<tr>
			<td colspan=\"2\">
				<b>Comments:</b>
				<br /><textarea name=\"comments\" rows=\"3\" cols=\"80\">$comments</textarea>
			</td>
			</tr>
			<tr>
			<td>
				<b>Demo Frame URL:</b>
			</td>
			<td>
				<input type=\"text\" name=\"demo_frame\" size=\"20\" value=\"$demo_frame\" />
				<br /><b>ZIP of all files needed:</b>  <input type=\"file\" name=\"upload\">
				
				<input type=\"hidden\" name=\"oldupload\" value=\"$zip\"  />
			</td>
			</tr>
			</table>
			<div align=\"center\"><input type=\"submit\" value=\"$heading\"></div>
			</form>	\n";
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
    $display
ENDTAG;
}
print <<<ENDTAG
  </div><!--wholepage -->
  </div><!--bodywrap-->
</div><!--master-->
<script type="text/javascript">
    <!--
    	var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
    	//-->
    	</script>
</body>
</html>
ENDTAG;
?>