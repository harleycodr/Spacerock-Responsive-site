<?php

session_start();
	include("../includes/declarations.php");
	include("includes/declarations.php");
	$action=$_GET['action'];
	
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == 'add')
        {
			$category=$_POST['category'];
			
            mysql_query(" INSERT into humorcategories SET
                        category='$category'
                        ");

        $display .= "$category added to Humor Categories";
        $display .= "<p><a href=\"addhumorcat.php\">Add Another</a>\n";
        $display .= "<p><CENTER><a href=\"javascript:window.close()\">Close Window</a></CENTER>\n";

        }
        else
        {
        $display .= "<CENTER><B>Add Humor Category</B></CENTER>\n";
        $display .= "<form action=\"addhumorcat.php?action=add\" METHOD=\"POST\">\n";
        $display .= "<TABLE WIDTH=350 BORDER=1>\n";
        $display .= "<TR VALIGN=TOP>\n";
        $display .= "<TD WIDTH=100><B>Category:</B></TD>\n";
        $display .= "<TD><INPUT TYPE=\"text\" NAME=\"category\" SIZE=20></TD></TR>\n";
        $display .= "<TR VALIGN=TOP><TD COLSPAN=2 ALIGN=CENTER><INPUT TYPE=\"submit\" VALUE=\" Add Category \"></TD></TR>\n";
        $display .= "</TABLE></FORM>\n";

        }

        $showcats = mysql_query(" SELECT category from humorcategories order by category");
          while ($row = mysql_fetch_array($showcats))
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
print <<<ENDTAG

<HTML>
<HEAD>
<TITLE>Add Humor Category</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<p><a href="index.php">Admin Home</a> > <a href="humoradmin.php">Manage Humor</a> > Add Humor Category
$display

<p>Existing categories:
$displaycats
</BODY>
</HTML>

ENDTAG;


?>