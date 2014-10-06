<?php

session_start();
	include("../includes/declarations.php");
	include("includes/declarations.php");

	$action=$_GET['action'];
	$a=$_GET['a'];
	$seasonal=$_POST['seasonal'];
	$startyear=$_POST['startyear'];
	$startmonth=$_POST['startmonth'];
	$startdate=$_POST['startdate'];
	$category=$_POST['category'];
	$title=$_POST['title'];
	$body=$_POST['body'];
	$rating=$_POST['rating'];
	$url=$_POST['url'];
	$homepage=$_POST['homepage'];
	
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    $thisyear=date(Y);
    $nextyear=$thisyear+1;
    include ("../includes/dbconnect.php");
    if($link)
    {
        if ($action == "makeedits")
        {
            
                if ($homepage == 'on')
                  {
                    $homepage = 'x';
					
                  }
                if ($staticurl=="on")
                {
                  $staticurl="1";
                }
				
                 if ($result=(mysql_query("UPDATE humor
                      SET
                        seasonal = '$seasonal',
                        displaystartdate = '$startyear$startmonth$startdate',
                        displayenddate = '$endyear$endmonth$enddate',
                        category = '$category',
                        title = '$title',
                        body = '".addslashes($body)."',
                        rating = '$rating',
                        url = '$url',
                        homepage = '$homepage',
                        staticurl='$staticurl'
                        WHERE ID='$a'")))


                    {
                           header("Location: $domain/admintools/humoradmin.php");


                    }
               
		}
        elseif($action=="addnew")
        {

        	//add new humor item
                if ($homepage == 'on')
                  {
                    $homepage = 'x';
                  }

              mysql_query("INSERT into humor
                           SET
                            seasonal = '$seasonal',
                            displaystartdate = '$startyear$startmonth$startdate',
                            displayenddate = '$endyear$endmonth$enddate',
                            category = '$category',
                            title = '$title',
                            rating = '$rating',
                            body = '".addslashes($body)."',
                            url = '$url',
                            homepage = '$homepage',
							date=NOW()");

                $r=mysql_insert_id($link);

        //        if ($body)
        //        {
        //          $url="humor.php?a=$r\n";

        //          mysql_query("UPDATE humor
        //            SET
        //            url='humor.php?a=$r'
        //            WHERE ID=$r");
        //        }


                             header("Location: $domain/admintools/humoradmin.php");

            }
          

        if ($action == 'edit')
        {
          // edit a humor item - get the data
			$formaction="makeedits";
			$submitvalue = "Make Edits";
            

              $single=mysql_query(" SELECT ID,
                                    seasonal,
                                    displaystartdate,
                                    displayenddate,
                                    category,
                                    title,
                                    body,
                                    url,
                                    rating,
                                    homepage
                                    from humor WHERE ID='$a'");

                                if (mysql_num_rows($single) > 0)

                                $ID = mysql_result($single,0,"ID");
                                $seasonal = mysql_result($single,0,"seasonal");
                                $displaystartdate = mysql_result($single,0,"displaystartdate");
                                $displayenddate = mysql_result($single,0,"displayenddate");
                                $category = mysql_result($single,0,"category");
                                $title = mysql_result($single,0,"title");
                                $body = mysql_result($single,0,"body");
                                $body = stripslashes($body);
                                $url = mysql_result($single,0,"url");
                                $rating = mysql_result($single,0,"rating");
                                $homepage = mysql_result($single,0,"homepage");
								
								if($getcatname=mysql_query("SELECT
									category
									from humorcategories
									where ID='$category'"))
									{
										$selectedcatname=stripslashes($row[0]);
										
										$selectedcat="<option value=\"$category\">$selectedcatname</option>\n";
									}
									else
									{
										$goof=mysql_error();
										$error="<b>Error:</b>  $goof";
									}
       
			$heading = "Edit $title";
        }

        else
        {
          $submitvalue=" Add humor item";
          $heading = " Add humor item";
		  $formaction="addnew";
		  
        }
		
		if($humorcat = mysql_query( "SELECT ID, category from humorcategories order by category" ))
		{

			while ($row = mysql_fetch_array($humorcat))
			{

				$catid=$row[0];
				$catname=stripslashes($row[1]);
				
				$catselects .= "<option value=\"$catid\">$catname</option>\n";
			


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
	<div id="alerts">
		<noscript>
			<p>
				<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
				support, like yours, you should still see the contents (HTML data) and you should
				be able to edit it normally, without a rich editor interface.
			</p>
		</noscript>
	</div>
<P><A HREF="index.php">Admin Home</A> > <A HREF="humoradmin.php">Manage Humor</A> > $heading

$heading

<P><FORM ACTION="add_humor.php?action=$formaction&a=$a" METHOD="POST">
<P><TABLE WIDTH=600 BORDER=1>
<TR VALIGN=TOP>
<TD>
  <B>Rating:</B>
</TD>
<TD>
  <SELECT NAME="rating">
  <OPTION VALUE="$rating">$rating
  <OPTION VALUE="G">G
  <OPTION VALUE="PG-13">PG-13
  <OPTION VALUE="PG">PG
  <OPTION VALUE="R">R
  <OPTION VALUE="X">X
</TD>
</TR>
  <TR VALIGN=TOP>
<TD WIDTH=100>
  <B>Seasonal?:</B>
<TD>
ENDTAG;

if ($seasonal)
{
  $checked=" CHECKED";
}
else
{
  $checked="";
}
if ($homepage)
{
  $hpchecked=" CHECKED";
}
else
{
  $hpchecked="";
}
print <<<ENDTAG

  <INPUT TYPE="radio" NAME="seasonal" VALUE="x"$hpchecked>Yes  <INPUT TYPE="radio" NAME="seasonal">No

</TD>
</TR>
<TR>
<TD>
  <B>Feature on home page?</B>
</TD>
<TD>
  <INPUT TYPE="checkbox" NAME="homepage"$checked>Yes!
</TD>
</TR>
<TR>
<TD>
  <B>Display Start Date:</B>
</TD>
<TD>
  <SELECT NAME="startmonth">  <B>Month:</B>
  <OPTION VALUE="">
  <OPTION VALUE="01">Jan
  <OPTION VALUE="02">Feb
  <OPTION VALUE="03">Mar
  <OPTION VALUE="04">Apr
  <OPTION VALUE="05">May
  <OPTION VALUE="06">June
  <OPTION VALUE="07">July
  <OPTION VALUE="08">Aug
  <OPTION VALUE="09">Sept
  <OPTION VALUE="10">Oct
  <OPTION VALUE="11">Nov
  <OPTION VALUE="12">Dec
  </SELECT>

  <B>Start Date</B>
  <BR><SELECT NAME="startdate">
  <OPTION VALUE="">
  <OPTION VALUE="01">1
    <OPTION VALUE="02">2
    <OPTION VALUE="03">3
    <OPTION VALUE="04">4
    <OPTION VALUE="05">5
    <OPTION VALUE="06">6
    <OPTION VALUE="07">7
    <OPTION VALUE="08">8
    <OPTION VALUE="09">9
    <OPTION VALUE="10">10
    <OPTION VALUE="11">11
    <OPTION VALUE="12">12
    <OPTION VALUE="13">13
    <OPTION VALUE="14">14
    <OPTION VALUE="15">15
    <OPTION VALUE="16">16
    <OPTION VALUE="17">17
    <OPTION VALUE="18">18
    <OPTION VALUE="19">19
    <OPTION VALUE="20">20
    <OPTION VALUE="21">21
    <OPTION VALUE="22">22
    <OPTION VALUE="23">23
    <OPTION VALUE="24">24
    <OPTION VALUE="25">25
    <OPTION VALUE="26">26
    <OPTION VALUE="27">27
    <OPTION VALUE="28">28
    <OPTION VALUE="29">29
    <OPTION VALUE="30">30
    <OPTION VALUE="31">31
    </SELECT>

    <B>Year</B>
    <BR><SELECT NAME="startyear">
  <OPTION VALUE="">
    <OPTION VALUE="$thisyear">$thisyear
    <OPTION VALUE="$nextyear">$nextyear
    </SELECT>
</TD>
</TR>
<TR>
<TD>
  <B>Display End Date:</B>
</TD>
<TD>
  <SELECT NAME="endmonth">  <B>Month:</B>
  <OPTION VALUE="">
  <OPTION VALUE="01">Jan
  <OPTION VALUE="02">Feb
  <OPTION VALUE="03">Mar
  <OPTION VALUE="04">Apr
  <OPTION VALUE="05">May
  <OPTION VALUE="06">June
  <OPTION VALUE="07">July
  <OPTION VALUE="08">Aug
  <OPTION VALUE="09">Sept
  <OPTION VALUE="10">Oct
  <OPTION VALUE="11">Nov
  <OPTION VALUE="12">Dec
  </SELECT>

  <B>Date</B>
  <BR><SELECT NAME="enddate">
  <OPTION VALUE="">
  <OPTION VALUE="01">1
    <OPTION VALUE="02">2
    <OPTION VALUE="03">3
    <OPTION VALUE="04">4
    <OPTION VALUE="05">5
    <OPTION VALUE="06">6
    <OPTION VALUE="07">7
    <OPTION VALUE="08">8
    <OPTION VALUE="09">9
    <OPTION VALUE="10">10
    <OPTION VALUE="11">11
    <OPTION VALUE="12">12
    <OPTION VALUE="13">13
    <OPTION VALUE="14">14
    <OPTION VALUE="15">15
    <OPTION VALUE="16">16
    <OPTION VALUE="17">17
    <OPTION VALUE="18">18
    <OPTION VALUE="19">19
    <OPTION VALUE="20">20
    <OPTION VALUE="21">21
    <OPTION VALUE="22">22
    <OPTION VALUE="23">23
    <OPTION VALUE="24">24
    <OPTION VALUE="25">25
    <OPTION VALUE="26">26
    <OPTION VALUE="27">27
    <OPTION VALUE="28">28
    <OPTION VALUE="29">29
    <OPTION VALUE="30">30
    <OPTION VALUE="31">31
    </SELECT>

    <B>Year</B>
    <BR><SELECT NAME="endyear">
  <OPTION VALUE="">
    <OPTION VALUE="$thisyear">$thisyear</option>
    <OPTION VALUE="$nextyear">$nextyear</option>
    </SELECT>
</TD>
</TR>
<TR VALIGN=TOP>
<TD>
  <B>Category:</B>
</TD>
<TD>
<select name="category">
<option value="$category">$selectedcatname</option>
$catselects
</select>
</TD>
</TR>

<TR>
<TD>
  <B>Title:</B>
</TD>
<TD>
  <INPUT TYPE="text" NAME="title" VALUE="$title" SIZE=60>
</TD>
</TR>
<TR VALIGN=TOP>
<TD>
  <B>Body:</B>
</TD>

<TD>
<textarea cols="80" name="body" rows="10">$body</textarea>
</TD>
</TR>
<TR>
<TD>
  <B>Or, URL:</B>
</TD>
<TD>
  <INPUT TYPE="text" NAME="url" VALUE="$url" SIZE=50>
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

include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
}

?>