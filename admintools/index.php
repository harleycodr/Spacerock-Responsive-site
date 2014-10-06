<?php
session_start();
include("includes/declarations.php");
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{

// make db connection
include ("../includes/dbconnect.php");
  if ($link)
  {
    $display .= "<p><B>Manage Content $UMVpeMcm4GwCVCsuds36OQS5HmVNNI</B>
    <p>Welcome, $adminusername<br />$logged</p><ul>";
    $display .="<div style=\"float:right;width:200px;\"><a href=\"logout.php\">Logout</a></div>\n";
    
    if($recipes_rights=="1")
    {
        $display .= "<li><a href=\"recipeadmin.php\">Manage Recipes</a></li>\n";
		$display .= "<li><a href=\"manageskinnyrecipes.php\">Manage Skinny Recipes</a></li>\n";
		$display .= "<ul><li><a href=\"recipeadminnew.php\">Manage Recipes - New System - BETA</a><br />Yeah Bryan, this is the one. ^..^</li></ul>\n";
    }
    if($rants_rights=="1")
    {
        $display .= "<li><a href=\"rantadmin.php\">Manage Rants</a></li>\n";
    }
    if($sites_brag_rights=="1")
    {
        $display .= "<li><a href=\"managemysites.php\">Manage My Sites Brag Page</a></li>\n";
    }
    if($humor_rights=="1")
    {
        $display .= "<li><a href=\"humoradmin.php\">Manage Humor</a></li>\n";
    }
    if($kitchen_cab_rights=="1")
    {
        $display .= "<li><a href=\"managekitchencabinet.php\">Manage Kitchen Cabinet Recipes</a></li>\n";
    }
    if($snapple_caps_rights=="1")
    {
        $display .= "<li><a href=\"managesnapplecaps.php\">Manage Snapple Caps</a></li>\n";
    }
    if($links_rights=="1")
    {
        $display .= "<li><a href=\"linkadmin.php\">Manage Links</a></li>\n";
    }
    if($photos_rights=="1")
    {
        $display .= "<li><a href=\"../photoadmin\">Manage Photos</a></li>\n";

    }
    if($news_rights=="1")
    {
        $display .= "<li><a href=\"newsadmin.php\">Manage News</a></li>\n";
		$display .= "<li><a href=\"guestarticleadmin.php\">Manage Guest Articles</a></li>\n";
    }
    if($dvds_rights=="1")
    {
        $display .= "<li><a href=\"movieindex.php\">DVD Collection</a></li>\n";
    }
    if($mailing_list_rights=="1")
    {
        $display .= "<li><a href=\"managemailinglist.php\">Manage/View Mailing List</a></li>\n";
    }
    if($video_clips_rights=="1")
    {
        $display .= "<li><a href=\"managevideos.php\">Manage Video Clips</a></li>\n";
    }
    if($bookshelf_rights=="1")
    {
        $display .= "<li><a href=\"managebooks.php\">Manage Bookshelf</a></li>\n";
    }
	$display .= "<li><a href=\"managetrivia.php\">Manage Trivia</a></li>\n";
    $display .= "</ul>\n";

 /*   if($users_rights=="1")
    {
        $display .= "<form action=\"makehtpass.php\" method=\"post\">
        <p><b>Create Admin User:</b></p>
        <table width=\"700\" border=\"1\">
        <tr>
        <td>
        	<b>User Name:</b>
        </td>
        <td>
        	<input type=\"text\" size=\"20\" name=\"user\" />
        </td>
        <td>
            <b>Email:</b>
        </td>
        <td>
            <input type=\"text\" size=\"20\" name=\"email\" />
        </td>
        </tr>

        <tr>
        <td>
        	<b>Password:</b>
        </td>
        <td>
        	<input type=\"password\" size=\"20\" name=\"pass1\"/>
        </td>
        <td>
        	<b>Type password again:</b>
        </td>
        <td>
        	<input type=\"password\" size=\"20\" name=\"pass2\"/>
        </td>
        </tr>
        <tr valign=\"top\">
        <td colspan=\"4\">
            <b>Admin Rights:</b>
            <table width=\"700\">
            <tr>
            <td>
                <input type=\"checkbox\" name=\"recipes\" />Recipes
            </td>
            <td>
                <input type=\"checkbox\" name=\"rants\" />Rants
            </td>
            <td>
                <input type=\"checkbox\" name=\"sites_brag\" />Sites Brag
            </td>
            <td>
                <input type=\"checkbox\" name=\"humor\" />Humor
            </td>
            </tr>
            <tr valign=\"top\">
            <td>
                <input type=\"checkbox\" name=\"kitchen_cabinet\" />Kitchen Cabinet
            </td>
            <td>
                <input type=\"checkbox\" name=\"snapple_caps\" />Snapple Caps
            </td>
            <td>
                <input type=\"checkbox\" name=\"links\" />Links
            </td>
            <td>
                <input type=\"checkbox\" name=\"photos\" />Photos
            </td>
            </tr>
            <tr valign=\"top\">
            <td>
                <input type=\"checkbox\" name=\"news\" />News
            </td>
            <td>
                <input type=\"checkbox\" name=\"dvds\" />DVD collection
            </td>
            <td>
                <input type=\"checkbox\" name=\"mailing_list\" />Mailing List
            </td>
            <td>
                <input type=\"checkbox\" name=\"video_clips\" />Video Clips
            </td>
            </tr>
            </table>

        </table>
        <input type=\"submit\" value=\"Create User \" />
        </form>\n";
        } */
    }
    else
    {
    	$error .= "<b>Error:</b>  DB connection failed.\n";
    }

}
else
{

       $error="Spacerock.com Admin Login</h2> 
        <form action=\"login.php?page=main\" method=\"post\"><table width=\"280\">
        <tr>
            <td>
                <b>Username:</b>
            </td>
            <td>
                <input type=\"text\" name=\"user\" size=\"15\" autofocus />
             </td>
             </tr>
             <tr>
            <td>
                <b>Password:</b>
            </td>
            <td>
                <input type=\"password\" name=\"pass\" size=\"15\" />
            </td>
            </tr>
            </table>
            <div align=\"center\"><p><input type=\"submit\" value=\"Login\" />
            </form>

    </div>\n";
    $error .= "<p><a href=\"/admintools/forgotpassword.php\">Forgot Password</a></p>\n";
}
$user=$REMOTE_USER;
$titletag="Admin Tools";
include ("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
print "<article id=\"content\">\n";
if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{
print <<<ENDTAG
$display
ENDTAG;
print "</article><!--content end==>\n";
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
}
?>