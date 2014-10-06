<?php

session_start();
include("../includes/declarations.php");
include("includes/declarations.php");

$action=$_GET['action'];
$a=$_GET['a'];
$body=$_POST['body'];
$abstract=$_POST['abstract'];
$title=$_POST['title'];

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    include ("fckeditor.php");

    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == 'save')
          {
            if ($a)
              {


                 if ($result=(mysql_query("UPDATE rants
                      SET
                        abstract = '".addslashes($abstract)."',
                        body = '".addslashes($body)."'
                        WHERE ID='$a'")))


                    {
                           header("Location: $domain/admintools/rantadmin.php");


                    }
               }

            else
            {

        	//add new rant

              mysql_query("INSERT into rants
                           SET
        			date = NOW(),
        			title = '".addslashes($title)."',
        			abstract = '".addslashes($abstract)."',
        			body = '".addslashes($body)."'
                          ");


                             header("Location: $domain/admintools/rantadmin.php");

            }
          }

        if ($action == 'edit')
        {
          // edit a rant - get the data

                $single=mysql_query(" SELECT ID,
                                        date,
                                        title,
                                        abstract,
                                        body
                                        from rants WHERE ID='$a'");


                                if (mysql_num_rows($single) > 0)

                                $ID = mysql_result($single,0,"ID");
                                $date = mysql_result($single,0,"date");
                                $title = mysql_result($single,0,"title");
                                $abstract = mysql_result($single,0,"abstract");
                                $abstract = stripslashes($abstract);
                                $body = mysql_result($single,0,"body");
                                $body = stripslashes($body);
                                $submitvalue = "Make Edits";
                                $heading = "Edit $title";
                            {
                              $submitvalue=" Make Changes ";
                              $heading = "Edit Rant";
                            }

          }

        else
        {
          $submitvalue=" Add Rant";
          $heading = " Add Rant";
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
<P><A HREF="index.php">Admin Home</A> > <A HREF="rantadmin.php">Manage Rants</A> > $heading

$heading

<P><FORM ACTION="add_rant.php?action=save" METHOD="POST">
<INPUT TYPE="hidden" NAME="a" VALUE="$a">
<P><TABLE WIDTH=600 BORDER=1>
<TR VALIGN=TOP>
<TD WIDTH=100>
  <B>Rant Title:</B>
<TD>
  <INPUT TYPE="text" NAME="title" VALUE="$title" SIZE=40>
</TD>
</TR>

<TR VALIGN=TOP>
<TD>
	<B>Abstract:</B>
</TD>
<TD>
<textarea cols="80" name="abstract" rows="10">$abstract</textarea></TD>
</TR>
<TR VALIGN=TOP>
<TD>
  <B>Body:</B>
</TD>
<TD>
<textarea cols="80" id="editor_office2003" name="body" rows="10">$body</textarea>
				<script type="text/javascript">
				//<![CDATA[

					CKEDITOR.replace( 'body',
						{
							skin : 'office2003'
						});

				//]]>
				</script>
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