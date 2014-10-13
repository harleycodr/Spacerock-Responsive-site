<?php
session_start();
$host = $_SERVER['HTTP_HOST'];
// include("../includes/declarations.php");
$domain="http://www.marianswebsite.com/spacerock";
$adminloggedin=$_SESSION['adminloggedin'];
include ("../includes/dbconnect.php");
$action=$_GET['action'];
$codeid=$_GET['codeid'];
$linkcatid=$_GET['linkcatid'];
$catid=$_GET['catid'];


if($link)
{
    if($adminloggedin=="1")
    {
        $loginlogout="<a href=\"logout.php\">Logout</a>&nbsp;&nbsp;<a href=\"admin.php\">Admin</a>\n";
    
        if($action=="deletecat")
        {
            if($result=mysql_query("DELETE
                from toolpage_categories
                where id='$catid'"))
                {
                    header("Location:$domain/toolpage/admin.php");
                }
                else
                {
                    $goof=mysql_error();
                    $error="<b>Error:</b>  $goof";
                }
        }
        elseif($action=="deletecode")
        {
            if($result=mysql_query("DELETE
                from toolpage_code
                where id='$codeid'"))
                {
                    header("Location:$domain/toolpage/admin.php");
                }
                else
                {
                    $goof=mysql_error();
                    $error="<b>Error:</b>  $goof";
                }
            
        }
		elseif($action=="deletelinkcat")
		{
			if($result=mysql_query("DELETE
				from toolpage_link_categories
				where id='$linkcatid'"))
				{
					header("Location:http://$domain/toolpage/admin.php");
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof";
				}
		}
		elseif($action=="deletelink")
		{
			if($result=mysql_query("DELETE
				from toolpage_links
				where id='$l'"))
				{
					header("Location:http://$domain/toolpage/admin.php");
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof";
				}
		}
    	if($result=mysql_query("SELECT
    		id,
    		category_name
    		from toolpage_categories
    		order by sequence"))
    		{
    		  while($row=mysql_fetch_array($result))
              {
    			$catid=$row[0];
    			$category_name=stripslashes($row[1]);
                
                $categories .= "<tr><td>$category_name</td><td><a href=\"addcat.php?action=edit&catid=$catid\">Edit</a></td><td><a href=\"javascript:CheckCatDelete('admin.php?action=deletecat&catid=$catid')\">Delete</a></td></tr>";
				if($catid=="11")
				{
					$addtext="Add a Link to this Tab";
					$scriptcall="addlink.php";
				}
				else
				{
					$addtext="Add Code to this Tab";
					$scriptcall="addcode.php";
				}
    			$display .= "<table width=\"600\"><tr bgcolor=\"#7bb9f9\"><td width=\"400\"><b>$category_name</b></td><td align=\"right\" colspan=\"2\"><a href=\"$scriptcall?catid=$catid$xtraaction\">$addtext</a></td></tr>\n";
               
                if($catid=="11")
				{
					if($result4=mysql_query("SELECT
						id,
						name
						from toolpage_links
						order by name"))
						{
							while($row=mysql_fetch_array($result4))
							{
								$l=$row[0];
								$name=stripslashes($row[1]);
								
								$display .= "<tr><td>$name</td>
								<td><a href=\"addlink.php?action=edit&l=$l\">Edit</a></td><td><a href=\"javascript:CheckLinkDelete('admin.php?action=deletelink&l=$l')\">Delete</a></td></tr>\n";
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
					if($result2=mysql_query("SELECT
						name,
						id
						from toolpage_code
						where category='$catid'
						order by name"))
						{
							while($row=mysql_fetch_array($result2))
							{
								$name=stripslashes($row[0]);
								$codeid=$row[1];
								

								$display .= "<tr><td>$name</td><td><a href=\"addcode.php?action=edit&codeid=$codeid\">Edit</a></td><td><a href=\"javascript:CheckCodeDelete('admin.php?action=deletecode&codeid=$codeid')\">Delete</a></td></tr>\n";
							}
						}
						else
						{
							$goof=mysql_error();
							$error="<b>Error:</b>  $goof\n";
						}
				}
    			}
                $display .= "</table>";
    		}
    		else
    		{
    			$goof=mysql_error();
    			$error="<b>Error:</b>  $goof\n";
    		}
			
			// link categories
			if($resultlinkcats=mysql_query("SELECT
				id,
				name
				from toolpage_link_categories
				order by name"))
				{
					while($row=mysql_fetch_array($resultlinkcats))
					{
						$linkcatid=$row[0];
						$linkcatname=stripslashes($row[1]);
						
						$linkcatdisplay .= "<tr><td>$linkcatname</td><td><a href=\"addlinkcat.php?action=edit&linkcatid=$linkcatid\">Edit</a></td><td><a href=\"javascript:CheckLinkCatDelete('admin.php?action=deletelinkcat&linkcatid=$linkcatid')\">Delete</a></td></tr>\n";
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
    <div style="width:310px; float:left;"><p style="text-align:center;"><b>Categories:</b>
    <br /><a href="addcat.php">Add</a></p>
    <table width="300" align="center" border="1">
    $categories
    </table>
    </div>
	<div style="width:310px; float:left; margin-left:10px;"><p style="text-align:center;"><b>Link/Online Resource Categories</b>
		<br /><a href="addlinkcat.php">Add</a></p>
		<table width="300" align="center" border="1".
		$linkcatdisplay
		</table>
	</div>
	<div style="clear:both;"></div>
	<div style="width:600px; clear:both;">
    <p style="text-align:center;"><b>Code Snippets</b></p>
    
    $display
	
	</div>
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