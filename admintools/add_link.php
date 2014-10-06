<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_GET['action'];
$a=$_GET['a'];
$title=addslashes($_POST['title']);
$category=$_POST['category'];
$description=$_POST['description'];
$url=$_POST['url'];
$homepage=$_POST['homepage'];
$rating=$_POST['rating'];

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{

    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == 'makeedits')
        {
        	if ($homepage=="on")
        	{
        		
        		$homepage="x";
        					
        	}
                 if ($result=(mysql_query("UPDATE links
                      SET
                        title = '$title',
                        category = '$category',
                        description = '".addslashes($description)."',
                        url = '$url',
                        homepage = '$homepage',
                        rating='$rating'
                        WHERE ID='$a'")))


                    {
                           header("Location: $domain/admintools/linkadmin.php");


                    }
              
		}
        elseif($action=="addnew")
        {

        	//add new link
        	if ($homepage=="on")
        	{
        		
        		$homepage="x";
        	}

              if (mysql_query("INSERT into links
                           SET
                            title = '$title',
                            category = '$category',
                            description = '".addslashes($description)."',
                            url = '$url',
                            homepage = '$homepage',
                            rating='$rating',
                            date=NOW()
                          "))


                   {
                    header("Location: $domain/admintools/linkadmin.php");
                   }
                   else
                   {
                   	$error .= "<B>Error:</B>  Insert failed.\n";
                   }

        }
          

        elseif ($action == 'edit')
        {
          // edit a rant - get the data
			$formaction="makeedits";
			
              $single=mysql_query(" SELECT ID, category, title, description, url, homepage, rating from links WHERE ID='$a'");

                              while ($row = mysql_fetch_array($single))
                              {
                                $ID=$row[0];
                                $thiscategory=$row[1];
                                $title=stripslashes($row[2]);
                                $description=stripslashes($row[3]);
                                $url=$row[4];
                                $homepage=$row[5];
                                $rating=$row[6];

                                if ($homepage=="x")
                                {
                                  $hpchecked=" checked";
                                }
								
								if($result2=mysql_query("SELECT
									category
									from linkcategories
									where ID='$thiscategory'"))
									{
										while($row=mysql_fetch_array($result2))
										{
											$categoryname=stripslashes($row[0]);
										}
									}
          $submitvalue = "Make Edits";
          $heading = "Edit $title";
                             }

          }

        elseif(!$action)
        {
          $submitvalue=" Add Link";
		  $formaction="addnew";
          $heading = "<p class=\"tac fwb\">Add Link</p>";
        }
		
		if($result3=mysql_query("SELECT
			ID,
			category
			from linkcategories
			order by category"))
			{
				while($row=mysql_fetch_array($result3))
				{
					$catid=$row[0];
					$category_name=stripslashes($row[1]);
					
					$catselects .= "<option value=\"$catid\">$category_name</option>\n";
				}
			}
    }
    else
    {
        $error = "<b>Error:</b>  No DB connection.\n";
    }
}
else
{
    include("loginerror.php");
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
<P><A HREF="index.php">Admin Home</A> > <A HREF="linkadmin.php">Manage Links</A> > $heading

$heading

<P><FORM ACTION="add_link.php?action=$formaction&a=$a" METHOD="POST">
<P><TABLE WIDTH=600 BORDER=1>
<TR VALIGN=TOP>
<TD>
  <B>Category:</B>
</TD>
<TD>
<select name="category">
<option value="$thiscategory">$categoryname</option>
$catselects
</select>
</td>

 <P><INPUT TYPE="checkbox" NAME="homepage"$hpchecked>  <B>Show on home page</B>
 </TD>

 </TR>
 <TR VALIGN=TOP>
<TD WIDTH=100>
  <B>Title:</B>
<TD>
  <INPUT TYPE="text" NAME="title" VALUE="$title" SIZE=40>  <B>Rating:</B>  <SELECT NAME="rating"<OPTION VALUE=\"$rating\">$rating</OPTION><OPTION VALUE="1">1</OPTION><OPTION VALUE="2">2</OPTION><OPTION VALUE="3">3</OPTION><OPTION VALUE="4">4</OPTION><OPTION VALUE="5">5</OPTION></SELECT>
</TD>
</TR>

<TR VALIGN=TOP>
<TD>
	<B>Description:</B>
</TD>
<TD>
<textarea cols="80" name="description" rows="10">$description</textarea>


</TD>
</TR>
<TR VALIGN=TOP>
<TD>
  <B>URL:</B>
</TD>
<TD>
  http://<INPUT TYPE="text" NAME="url" SIZE=30 VALUE="$url">
</TD>
</TR>
<TR VALIGN=TOP>
<TD COLSPAN=2 ALIGN=CENTER>
  <INPUT TYPE="submit" VALUE=" $submitvalue ">
</TD>
</TR>

</TABLE>
</FORM>
</article>
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");


?>