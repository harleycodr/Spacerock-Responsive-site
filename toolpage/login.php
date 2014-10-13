<?php
/**
 * @author Your Great Website.com
 * @copyright 2011
 */
 session_start();
$userentered=$_POST['user'];
$passentered=$_POST['pass'];

$host = $_SERVER['HTTP_HOST'];
include("../includes/declarations.php");
include ("../includes/dbconnect.php");
if($link)
{
    if($result=mysql_query("SELECT
        username,
        password
        from toolpage_admin
        where username='$userentered'"))
        {
            $usercount=mysql_num_rows($result);
            if($usercount=="0")
            {
                $error = "<b>Error:</b>  User $userentered not found.";
            }
            else
            {
                while($row=mysql_fetch_array($result))
                {
                    $username=$row[0];
                    $password=$row[1];
                    
                    if($password=="$passentered")
                    {
						$_SESSION['adminloggedin']="1";
                        header("Location:$domain/toolpage/index.php");
                    }
                    else
                    {
                        $error = "<b>Error:</b>  Incorrect Password.";
                        $error .= "<br /><a href=\"https://p3smysqladmin01.secureserver.net/p41/113/index.php?db=marian713&lang=en-iso-8859-1&convcharset=iso-8859-1&collation_connection=utf8_unicode_ci&token=00ca80e9cf68c82000e926f903ed57a9\">Admin Login</a></p>\n";
                    }
                }
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
    $error = "<b>Error:</b>  No database connection.";
}
if($error)
{
  include("header.php");
  print "$error";
  print "</body></html>";
}

?>