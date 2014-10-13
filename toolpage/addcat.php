<?php
session_start();
include ("../includes/dbconnect.php");
if($link)
{
    if($adminloggedin=="1")
    {
        $loginlogout="<a href=\"logout.php\">Logout</a>&nbsp;&nbsp;<a href=\"admin.php\">Admin</a>\n";
        if($action=="edit")
        {
            $formaction="makeedits";
    	    if($result=mysql_query("SELECT
    		category_name,
            sequence
    		from toolpage_categories
    		where id='$catid'"))
    		{
    		  while($row=mysql_fetch_array($result))
              {
    			$category_name=stripslashes($row[0]);
                $sequence=$row[1];
                
                $heading="Edit $category_name";
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
            if($result=mysql_query("UPDATE
                toolpage_categories
                set category_name='".addslashes($category_name)."',
                sequence='$sequence'
                where id='$catid'"))
                {
                    header("Location:http://www.spacerock.com/toolpage/admin.php");
                }
                else
                {
                    $goof=mysql_error();
                    $error="<b>Error:</b>  $goof";
                }
        }
        elseif($action=="addnew")
        {
            if($result=mysql_query("INSERT into
                toolpage_categories
                set category_name='".addslashes($category_name)."',
                sequence='$sequence'"))
                {
                    header("Location:http://www.spacerock.com/toolpage/admin.php");
                }
                else
                {
                    $goof=mysql_error();
                    $error="<b>Error:</b>  $goof";
                }
            
        }
        if(!$action)
        {
            $heading="Add New Category";
            $formaction="addnew";
        }
        
        $display .= "<p><a href=\"admin.php\">Admin</a> > $heading</p>
        <h1>$heading</h1>
        <form action=\"$PHP_SELF?action=$formaction&catid=$catid\" method=\"post\">
        <table width=\"300\" border=\"1\" align=\"center\">
        <tr valign=\"top\">
        <td>
            <b>Seqence:</b>
            <br /><input type=\"text\" name=\"sequence\" value=\"$sequence\" size=\"3\" />
        </td>
        <td>
            <b>Category Name:</b>
        </td>
        <td>
            <input type=\"text\" name=\"category_name\" value=\"$category_name\" size=\"20\" />
        </td>
        </tr>
        </table>
        <div align=\"center\"><input type=\"submit\" value=\"$heading\"></div>
        </form>	\n";
        
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