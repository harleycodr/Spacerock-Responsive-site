<?php
session_start();
$userinput=$_REQUEST['user'];
$passinput=$_REQUEST['pass'];
$page=$_REQUEST['page'];
//include("includes/declarations.php");
$domain="http://www.spacerock.com";

// make db connection
include ("/home/content/44/10809344/html/SPACEROCK/includes/dbconnect.php");
if ($link)
{
    if($result=mysql_query("SELECT
        id,
        password
        from admin_users
        where username='$userinput'"))
        {
            $usercount=mysql_num_rows($result);
            if($usercount>0)
            {
                while($row=mysql_fetch_array($result))
                {
                    $uid=$row[0];
                    $password=$row[1];

                    if($passinput=="$password")
                    {
                        $username=$userinput;


                        if($rights=mysql_query("SELECT
                            recipes,
                            rants,
                            sites_brag,
                            humor,
                            kitchen_cab,
                            snapple_caps,
                            links,
                            photos,
                            news,
                            garden,
                            dvds,
                            mailing_list,
                            video_clips,
                            users,
							bookshelf							
							from admin_rights
                            where user_id='$uid'"))
                            {
                                while($row=mysql_fetch_array($rights))
                                {
                                    $recipes_rights=$row[0];
                                    $rants_rights=$row[1];
                                    $sites_brag_rights=$row[2];
                                    $humor_rights=$row[3];
                                    $kitchen_cab_rights=$row[4];
                                    $snapple_caps_rights=$row[5];
                                    $links_rights=$row[6];
                                    $photos_rights=$row[7];
                                    $news_rights=$row[8];
                                    $garden_rights=$row[9];
                                    $dvds_rights=$row[10];
                                    $mailing_list_rights=$row[11];
                                    $video_clips_rights=$row[12];
                                    $users_rights=$row[13];
									$bookshelf_rights=$row[14];

									$_SESSION['UMVpeMcm4GwCVCsuds36OQS5HmVNNI']="1";

									$_SESSION['recipes_rights']="$recipes_rights";

									$_SESSION['rants_rights']="$rants_rights";

									$_SESSION['sites_brag_rights']="$sites_brag_rights";

									$_SESSION['humor_rights']="$humor_rights";

                                    $_SESSION['kitchen_cab_rights']="$kitchen_cab_rights";

                                    $_SESSION['snapple_caps_rights']="$snapple_cap_rights";

                                    $_SESSION['links_rights']="$links_rights";

                                    $_SESSION['photos_rights']="$photos_rights";

                                    $_SESSION['news_rights']="$news_rights";

                                    $_SESSION['dvds_rights']="$dvds_rights";

                                    $_SESSION['mailing_list_rights']="$mailing_list_rights";

                                    $_SESSION['video_clips_rights']="$video_clips_rights";

                                    $_SESSION['users_rights']="$users_rights";

                                    $_SESSION['adminusername']="$username";
																		
				$_SESSION['bookshelf_rights']="$bookshelf_rights";
									
                                    if($page)
                                    {
                                        if($page=="photo")
                                        {
                                            $pageurl="photoadmin/index.php";
                                        }
                                        header("Location:$domain/admintools/");
                                    }

                                }
                            }
                            else
                            {
                                $goof=mysql_error();
                                $error .= "<b>Error:</b>  $goof";
                            }
                        // log user login
                        if($result2=mysql_query("INSERT
                            into admintools_log SET
                            time_in=NOW(),
                            uid='$userinput'"))
                            {
								$worksession_id=mysql_insert_id($link);
								$_SESSION['worksession_id']="$worksession_id";

								$_SESSION['logged']="Visit Logged.  Worksession ID:  $worksession_id";


                            }
                            else
                            {
                                $goof=mysql_error();
                                $error = "<b>Error:</b>  $goof";
                            }
                    }
                    else
                    {
                        include("loginerror.php");
                        $error.= "<p><b>Error:</b>  Incorrect password.  ";
                        $error.= "<br /><a href=\"forgotpassword.php\">Forgot Password</a></p>\n";
                    }
                }
            }
            else
            {

                $error .= "<p><b>Error:</b>  Unknown Username.  $userinput\n";
                $error .= "<br /><a href=\"forgotusername.php\">Forgot Username</a><br /> $usercount</p>\n";
            }
        }
        else
        {
            $goof=mysql_error();
            $error = "<b>Error:</b>  $goof\n";
        }
}
else
{
	$error .= "<b>Error:</b>  DB connection failed.\n";
}
$user=$REMOTE_USER;
include ("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
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
<p><B>Manage Content</B>
<p>Welcome, $adminusername >br />$logged</p>
<p><ul>
  <li><a href="recipeadmin.php">Manage Recipes</a>
  <li><a href="rantadmin.php">Manage Rants</a>
  <li><a href="managemysites.php">Manage My Sites Brag Page</a>
  <li><a href="humoradmin.php">Manage Humor</a>
  <li><a href="managekitchencabinet.php">Manage Kitchen Cabinet Recipes</a>
  <li><a href="managesnapplecaps.php">Manage Snapple Caps</a>
  <li><a href="linkadmin.php">Manage Links</a>
  <li><a href="/photoadmin">Manage Photos</a>
  <li><a href="newsadmin.php">Manage News</a>
  <li><a href="gardenadmin.php">Garden</a>
  <li><a href="movieindex.php">DVD Collection</a>
  <li><a href="managemailinglist.php">Manage/View Mailing List</a></li>
  <li><a href="managevideos.php">Manage Video Clips</a></li>
</ul>

<form action="makehtpass.php" method="post">
<p><b>Create Admin User:</b></p>
<table width="300" border="1">
<tr>
<td>
	<b>User Name:</b>
</td>
<td>
	<input type="text" size="20" name="user" />
</td>
</tr>
<tr>
<td>
	<b>Password:</b>
</td>
<td>
	<input type="password" size="20" name="pass1"/>
</td>
</tr>
<tr>
<td>
	<b>Type password again:</b>
</td>
<td>
	<input type="password" size="20" name="pass2"/>
</td>
</tr>
</table>
<input type="submit" value="Create User " />
</form>
</article>
ENDTAG;

include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
}
?>