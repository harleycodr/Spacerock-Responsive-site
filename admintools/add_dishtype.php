<?php
session_start();
include("includes/declarations.php");

$action=$_GET['action'];
$name=$_POST['name'];

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == 'add')
        {
            mysql_query(" INSERT into dishtype SET
                        name='$name'");

            $display .= "$name added to Dish Types";
            $display .= "<P><CENTER><A HREF=\"javascript:window.close()\">Close Window</A></CENTER>\n";

        }
        else
        {
            $display .= "<CENTER><B>Add Dish Type</B></CENTER>\n";
            $display .= "<FORM ACTION=\"$PHP_SELF?action=add\" METHOD=\"POST\">\n";
            $display .= "<TABLE WIDTH=350 BORDER=1>\n";
            $display .= "<TR VALIGN=TOP>\n";
            $display .= "<TD WIDTH=100><B>Dish Type:</B></TD>\n";
            $display .= "<TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=20></TD></TR>\n";
            $display .= "<TR VALIGN=TOP><TD COLSPAN=2 ALIGN=CENTER><INPUT TYPE=\"submit\" VALUE=\" Add Dish Type \"></TD></TR>\n";
            $display .= "</TABLE></FORM>\n";
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
print <<<ENDTAG
include ("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
print <<<ENDTAG
<title>marionswebsite.com title</title>
ENDTAG;

if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{

print <<<ENDTAG

<HTML>
<HEAD>
<TITLE>Add Dish Type</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
$display
</BODY>
</HTML>

ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
?>