<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
	$action=$_GET['action'];
	$r=$_GET['r'];
	$t=$_REQUEST['t'];
	
// make db connection
    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == "delete")
        {
          mysql_query("DELETE FROM skinnyrecipes WHERE ID = $r");

          header("Location: $domain/admintools/manageskinnyrecipes.php");

        }
		elseif($action=="deletetype")
		{
			if($result=mysql_query("DELETE
				from skinny_recipe_types
				where id='$t'"))
				{
					header("Location: $domain/admintools/manageskinnyrecipes.php");
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof";
				}
		}

        $result=mysql_query(" SELECT id,
			name from skinny_recipes
			order by name");

            while ($row = mysql_fetch_array($result))
            {
				$r=$row[0];
				$name=stripslashes($row[1]);

    		      
				$display .= "<tr><td>$name</a></td><td><a href=\"addsrecipe.php?r=$r&action=edit\">Edit</a></td><td><a href=\"javascript:CheckDelete('manageskinnyrecipes.php?action=delete&r=$r')\">Delete</a></td></tr>";
          }
		  
		  if($result2=mysql_query("SELECT
			id,
			type
			from skinny_recipe_types
			order by type"))
			
			{
				while($row=mysql_fetch_array($result2))
				{
					$t=$row[0];
					$type=$row[1];
					
					$types .= "<tr><td>$type</a></td><td><a href=\"addskinnyrecipetypes.php?t=$t&action=edit\">Edit</a></td><td><a href=\"javascript:CheckDelete('manageskinnyrecipes.php?action=deletetype&t=$t')\">Delete</a></td></tr>";
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
        $error="<b>Error:</b>  No db connetion.\n";
    }
	
}
else
{
    $error = "<b>Error:</b>  You  must be logged in to view this page and contents.<br /><a href=\"index.php\">Continue</a>\n";

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
<p><a href="index.php">Admin Home</a> > Manage Skinny Recipes

<h2>Manage Skinny Recipes</h2>
<p class="tac"><a href="addsrecipe.php">Add New</a></p>
<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a skinny recipe from the database. Do you want to proceed?"))
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

<p><table width="600" border="1" align="center">
<tr VALIGN=TOP>
<td>
  <b>Name</b>
</td>
<td COLSPAN=2 ALIGN=CENTER>
  <B>Manage</B>
</td>
</tr>
$display
</table>

<p class="fwb tac">Recipe Types</p>
<p class="tac"><a href="addskinnyrecipetypes.php">Add New Type</a></p>
<table width="200" align="center" border="1">
$types
</table>
</article>
ENDTAG;

include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
}
?>