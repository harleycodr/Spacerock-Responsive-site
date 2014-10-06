<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");

$action=$_GET['action'];
$a=$_GET['a'];

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == "delete" AND $a)
        {
          mysql_query("DELETE FROM humor WHERE ID = $a");

          header("Location: $domain/admintools/humoradmin.php");

        }

        else
    		{
    			if ($result=mysql_query(" SELECT ID, title, url, homepage, staticurl from humor order by title"))
    			{
    				$staticurl="";
    				$homepage="";
                        while ($row = mysql_fetch_array($result))
                        {
                          $ID=$row[0];
                          $title=$row[1];
                          $url=$row[2];
                          $homepage=$row[3];
                          $staticurl=$row[4];

                          if (!$homepage)
                          {
                            $homepage="&nbsp";
                          }
                          if ($staticurl)
                          {
                          	$url=$staticurl;
                          }
                          else
                          {
                          	$url=$url;
                          }
                          $display .= "<tr><td align=center>$homepage</td><td><a href=\"../$url\">$title</a></td><td><a href=\"add_humor.php?a=$ID&action=edit\">Edit</a></td><td><a href=\"javascript:CheckDelete('$PHP_SELF?action=delete&a=$ID')\">Delete</a></td></tr>\n";
                        }
    			 }
    			 else
    			 {
    				$error .= "<b>Error:</b>  Database query failed.\n";
    			 }
    			}
				
		$humorcats=mysql_query(" SELECT category from humorcategories order by category");
		  while ($row = mysql_fetch_array($humorcats))
		  {
			$category=$row[0];
			$displaycats .= "<br />$category\n";
		  }
    }
    else
    {
        include("nodberror.php");
    }
 }
 else
 {
    include("loginerror.php");
 }
include("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
<article id="content">
ENDTAG;

if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{
print <<<ENDTAG
<p><a href="index.php">Admin Home</a> > Humor Admin

<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a humor item from the database. Do you want to proceed?"))
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

<p><B>Peripheral Tools:</B>
<p><B>Humor Categories:</B>
$displaycats
<ul>
  <li><a href="JavaScript:SmallWindow1('addhumorcat.php')">Add Category</a>
  </ul>

  <p><ul>
  <li><a href="add_humor.php">Add New Humor Item</a>
  </ul>

<p><B>Edit/Delete Humor Items</B>

<p><table width=600 border=1>
<tr valign=top>
<td align=center>
  <b>Featured on HP</b>
</td>
<td>
  <b>Title</b>
</td>
<td colspan=2 align=center>
  <b>Manage</b>
</td>
</tr>
$display

</table>
</article>
ENDTAG;

include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
}
?>