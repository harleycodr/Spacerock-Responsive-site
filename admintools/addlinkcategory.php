<?php

session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_GET['action'];
$a=$_GET['a'];
$category=$_POST['category'];
$description=$_POST['description'];

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == 'add')
        {
            mysql_query(" INSERT into linkcategories SET
                        category='$category',
                        description = '".addslashes($description)."'");

        $display .= "$category added to Link Categories";
        $display .= "<p><a href=\"$PHP_SELF\">Add Another</a>\n";
        $display .= "<p><CENTER><a href=\"javascript:window.close()\">Close Window</a></CENTER>\n";

        }
        else
        {
        $display .= "<CENTER><B>Add Link Category</B></CENTER>\n";
        $display .= "<form action=\"addlinkcategory.php?action=add\" METHOD=\"POST\">\n";
        $display .= "<TABLE WIDTH=350 BORDER=1>\n";
        $display .= "<TR VALIGN=TOP>\n";
        $display .= "<TD WIDTH=100><B>Category:</B></TD>\n";
        $display .= "<TD><INPUT TYPE=\"text\" NAME=\"category\" SIZE=20></TD></TR>\n";
        $display .= "<TR><TD COLSPAN=2><B>Description:</B>\n";
        $display .= "<TEXTAREA NAME=\"description\" ROWS=4 COLS=30></TEXTAREA></TD></TR>\n";
        $display .= "<TR VALIGN=TOP><TD COLSPAN=2 ALIGN=CENTER><INPUT TYPE=\"submit\" VALUE=\" Add Category \"></TD></TR>\n";
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

<HTML>
<HEAD>
<TITLE>Add Link Category</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<p><a href="index.php">Admin Home</a> > <a href="recipeadmin.php">Manage Llinks</a> > Add Link Category

$display

</BODY>
</HTML>

ENDTAG;


?>