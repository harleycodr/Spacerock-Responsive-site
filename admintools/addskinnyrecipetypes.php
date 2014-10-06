<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_REQUEST['action'];
$t=$_REQUEST['t'];


	
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    // $imagedir="/home/content/77/10286677/html/images/uploads";
	$imagemagickPath = "/usr/bin";
    include ("../includes/dbconnect.php");

    if ($link)
    {
    	if ($action=="edit")
    	{
    		$formaction="makeedits";
    		$heading = "Make Edits";

			
    		if ($single=mysql_query(" SELECT
    			type
				from skinny_recipe_types
				where id='$t'"))


    			{
    				while ($row=mysql_fetch_array($single))
    				{
    					$type=$row[0];

 
    				}
    			}
    			else
    			{
    				$error .= "<B>Error:</B>  Database query failed for this recipe.\n";
    			}

    	}
    	elseif ($action=="makeedits")
    	{
			$type=$_REQUEST['type'];
      
             if ($result=mysql_query("UPDATE skinny_recipe_types
				SET
				type='$type'
				where id='$t'"))
    			{
    				header("Location: $domain/admintools/manageskinnyrecipes.php");
    			}
    			else
    			{
					$goof=mysql_error();
    					$error .= "<b>Error:</b>  Database update failed.  $goof\n";
    			}
        }

        elseif ($action=="addnew")
        {

			$type=$_REQUEST['type'];
      
             if ($result=mysql_query("INSERT INTO skinny_recipe_types
				SET
				type='$type'"))
    			{
    				header("Location: $domain/admintools/manageskinnyrecipes.php");
    			}
    			else
    			{
					$goof=mysql_error();
    					$error .= "<b>Error:</b>  Database update failed.  $goof\n";
    			}

      }
    }
    else
    {
    	$error .= "<b>Error:</b>  Database connection failed.\n";
    }


    if (!$action)
    {
      $submitvalue=" Add Skinny Recipe Type";
      $heading = " Add Skinny Recipe Type";
      $formaction="addnew";

     
    }
}
else
{
    include("loginerror.php");
}
print <<<ENDTAG

ENDTAG;
include("../headerinclude.php");
print "<article id=\"content\">\n";
if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{
print <<<ENDTAG
<!-- This <div> holds alert messages to be display in the sample page. -->
	<div id="alerts">
		<noscript>
			<p>
				<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
				support, like yours, you should still see the contents (HTML data) and you should
				be able to edit it normally, without a rich editor interface.
			</p>
		</noscript>
	</div>
<a href="index.php">Admin home</a> > <a href="manageskinnyrecipes.php">Manage Skinny Recipes</a> > $heading
$heading

<p><FORM ACTION="addskinnyrecipetypes.php?action=$formaction&t=$t" METHOD="POST">

<p><TABLE WIDTH=300 BORDER=1>
  <TR VALIGN=TOP>
<TD WIDTH=100>
  <p><B>Type:</B>
  <br /><INPUT TYPE="text" NAME="type" VALUE="$type" SIZE=40>

</TD>
</TR>
</table>
<p class="tac"><INPUT TYPE="submit" VALUE=" $heading "></p>
</FORM>
</article>
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");


?>