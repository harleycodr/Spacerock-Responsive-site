<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_GET['action'];
$a=$_GET['a'];

$month=$_POST['month'];
$day=$_POST['day'];
$year=$_POST['year'];
$title=$_POST['title'];
$author=$_POST['author'];
$abstract=$_POST['abstract'];
$body=$_POST['body'];
	
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
    			month(date) AS month,
    			monthname(date) AS monthname,
    			dayofmonth(date) AS day,
    			year(date) AS year,
    			title,
    			author,
    			body,
    			abstract
    			from guest_articles WHERE ID='$a'"))


    			{
    				while ($row=mysql_fetch_array($single))
    				{
    					$month=$row[0];
    					$monthname=$row[1];
    					$day=$row[2];
    					$year=$row[3];
    					$title=$row[4];
						$author=$row[5];
    					$body=stripslashes($row[6]);
    					$abstract=stripslashes($row[7]);

    					
    				}
    			}
    			else
    			{
    				$error .= "<B>Error:</B>  Database query failed for this news item.\n";
    			}


    		$monthselect="<OPTION VALUE=\"$month\">$monthname\n";
    		$monthdateselect="<OPTION VALUE=\"$day\">$day\n";
    		$yearselect="$year";
    	}
    	elseif ($action=="makeedits")
    	{
      

             if ($result=mysql_query("UPDATE guest_articles
                  SET
                    title = '".addslashes($title)."',
                    abstract = '".addslashes($abstract)."',
                    body = '".addslashes($body)."',
                    author='$author'
                    WHERE ID='$a'"))
    				{
    					header("Location: $domain/admintools/newsadmin.php");
    				}
    				else
    				{
						$goof=mysql_error();
    					$error .= "<b>Error:</b>  Database update failed.  $goof\n";
    				}
        }

        elseif ($action=="addnew")
        {

    	

          
            if ($result=mysql_query("INSERT into guest_articles
				SET
                title = '".addslashes($title)."',
                abstract = '".addslashes($abstract)."',
                body = '".addslashes($body)."',
                author='$author'"))
         		{
					header("Location: $domain/admintools/guestarticleadmin.php");
    			}
    			else
    			{
					$goof=mysql_error();
					$error .= "<b>Error:</b>  DB Insert failed.  $goof\n";
    			}

      }
    }
    else
    {
    	$error .= "<b>Error:</b>  Database connection failed.\n";
    }


    if (!$action)
    {
      $submitvalue=" Add Guest Article";
      $heading = " Add Gust Article";
      $formaction="addnew";

      $Month=date('m');
      $TheDate=date('d');
      $TheYear=date('Y');

      $monthselect="<option value=\"$Month\">$Month\n";
      $monthdateselect="<option value=\"$TheDate\">$TheDate\n";
      $year=date(Y);
    }
}
else
{
    include("loginerror.php");
}
print <<<ENDTAG
<title>Spacerock.com $heading</title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/sample.js" type="text/javascript"></script>
<link href="ckeditor/sample.css" rel="stylesheet" type="text/css"/>

ENDTAG;
include ("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
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
<a href="index.php">Admin home</a> > <a href="newsadmin.php">Manage News</a> > $heading
$heading

<p><FORM ACTION="addguestarticle.php?action=$formaction&a=$a" METHOD="POST">
<p><TABLE WIDTH=900 BORDER=1>
<TR VALIGN=TOP>
<TD>
  <B>Date:</B>
</TD>
<TD>
  <B>Month:</B>
 <SELECT NAME="month">
$monthselect
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
  <SELECT NAME="monthdate">
  $monthdateselect
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

    <B>Year</B>  <INPUT TYPE="text" NAME="year" VALUE="$year"> (4 digit)

</TD>
</TR>
  <TR VALIGN=TOP>
<TD WIDTH=100>
  <B>Title:</B>

  <br /><INPUT TYPE="text" NAME="title" VALUE="$title" SIZE=40>

</TD>
<td>
	<b>Author:</b>
	<br /><input type="text" name="author" value="$author" size="40" />
</td>
</TR>

<TR VALIGN=TOP>
<TD>
  <B>Abstract:</B>
</TD>

<TD>
<textarea name="abstract" rows="10">$abstract</textarea>

</TD>
</TR>
<TR VALIGN=TOP>
<TD>
  <B>Pastable Body:</B>
</TD>
<TD>
<textarea cols="80" name="body" rows="10">$body</textarea>
</TD>
</TR>
<TR VALIGN=TOP>
<TD COLSPAN=2 ALIGN=CENTER>
  <INPUT TYPE="submit" VALUE=" $heading ">
</TD>
</TR>

</TABLE>
</FORM>
</article>
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");


?>