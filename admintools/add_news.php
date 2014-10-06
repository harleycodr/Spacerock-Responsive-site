<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_GET['action'];
$a=$_GET['a'];

$image=$_FILES['image']['tmp_name'];
$monthdate=$_POST['monthdate'];
$month=$_POST['month'];
$year=$_POST['year'];
$title=$_POST['title'];
$subtitle=$_POST['subtitle'];
$abstract=$_POST['abstract'];
$body=$_POST['body'];
$type=$_POST['type'];
$photo_caption=$_POST['photo_caption'];
$oldimage=$_POST['oldimage'];

if($image=="")
{
	$has_image="0";
}
else
{
	$has_image="1";
	$image_type=$_FILES['image']['type'];
}
	
	
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
    			month(dateposted) AS month,
    			monthname(dateposted) AS monthname,
    			dayofmonth(dateposted) AS day,
    			year(dateposted) AS year,
    			title,
    			subtitle,
    			body,
    			abstract,
    			displayphoto,
    			photo_caption
    			from news WHERE ID='$a'"))


    			{
    				while ($row=mysql_fetch_array($single))
    				{
    					$month=$row[0];
    					$monthname=$row[1];
    					$day=$row[2];
    					$year=$row[3];
    					$title=$row[4];
    					$subtitle=stripslashes($row[5]);
    					$body=stripslashes($row[6]);
    					$abstract=stripslashes($row[7]);
    					$displayphoto=$row[8];
    					$photo_caption=stripslashes($row[9]);

    					if ($displayphoto)
    					{
    						$existingimage .="<p><b>Existing Image:</b>\n";
    						$existingimage .="<br /><img src=\"../images/uploads/$displayphoto\">\n";
    						$existingimage .="<input type=\"hidden\" name=\"oldimage\" value=\"$displayphoto\">\n";
    						$existingimage .= "<br />You can use this existing photo or upload a new one below.</p>\n";


    					}
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
      // image handling

          if ($has_image=="1")
          {
    //      	unlink ("/home/marian/images/uploads/$oldimage/");

                if ($image_type == "image/pjpeg")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/jpeg")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/jpg")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/gif")
                {
                  $extension = ".gif";
                }

                if ($image_type == "image/PJPEG")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/JPEG")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/GIF")
                {
                  $extension = "gif";
                }

    	            elseif ($image_type == "image/png")
    	            {
    	            	$extension=".png";
    	            }
    	            elseif ($image_type=="image/PNG")
    	            {
    	            	$extension=".png";
    	            }
                  $thisyear=date(Y);
                  $thismonth=date(m);
                  $thisday=date(d);
                  $thishour=date(G);
                  $thisminute=date(i);
                  $thissecond=date(s);

                  $newfile="$thisyear$thismonth$thisday$thishour$thisminute$thissecond$extension";

                  copy($image, "$imagedir/$newfile");

            // image magick start
            // let's make sure the uploaded file isn't gigantic
            // Make a large image
                      $size = GetImageSize( "$imagedir/$newfile" );
                      if ($size[0] > 600 || $size[1] > 600)
                      {
                        if($size[0] > $size[1])
                        {
                          $large_width = 500;
                          $large_height = (int)(500 * $size[1] / $size[0]);
                        }
                        else
                        {
                          $large_width = (int)(500 * $size[0] / $size[1]);
                          $large_height = 500;
                        }
                        


                        exec("$imagemagickPath/convert -geometry " .
                         "{$large_width}x{$large_height} " .
                         "$imagedir/$newfile $imagedir/lg-$newfile");
                      }
                      $size = GetImageSize( "$imagedir/$newfile" );
                      if ($size[0] > 300 || $size[1] > 300)
                      {
                        if($size[0] > $size[1])
                        {
                          $large_width = 300;
                          $large_height = (int)(300 * $size[1] / $size[0]);
                        }
                        else
                        {
                          $large_width = (int)(300 * $size[0] / $size[1]);
                          $large_height = 300;
                        }
                        


                        exec("$imagemagickPath/convert -geometry " .
                         "{$large_width}x{$large_height} " .
                         "$imagedir/$newfile $imagedir/$newfile");
                      }
					$image="$newfile";
    			 }
    			 else
    			 {
    				$image="$oldimage";
    			 }

             if ($result=mysql_query("UPDATE news
                  SET
                    title = '".addslashes($title)."',
                    subtitle = '".addslashes($subtitle)."',
                    abstract = '".addslashes($abstract)."',
                    body = '".addslashes($body)."',
                    displayphoto='$image',
                    photo_caption='".addslashes($photo_caption)."'
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

    	//add new news item

      // image handling

          if ($has_image=="1")
          {
                if ($image_type == "image/pjpeg")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/jpeg")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/jpg")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/gif")
                {
                  $extension = ".gif";
                }

                if ($image_type == "image/PJPEG")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/JPEG")
                  {
                    $extension = ".jpg";
                  }
                elseif ($image_type == "image/GIF")
                {
                  $extension = "gif";
                }

    	            elseif ($image_type == "image/png")
    	            {
    	            	$extension=".png";
    	            }
    	            elseif ($image_type=="image/PNG")
    	            {
    	            	$extension=".png";
    	            }
                  $thisyear=date(Y);
                  $thismonth=date(m);
                  $thisday=date(d);
                  $thishour=date(G);
                  $thisminute=date(i);
                  $thissecond=date(s);

                  $newfile="$thisyear$thismonth$thisday$thishour$thisminute$thissecond$extension";

                  copy($image, "$imagedir/$newfile");

            // image magick start
            // Make a large image
                      $size = GetImageSize( "$imagedir/$newfile" );
                      if ($size[0] > 500 || $size[1] > 500)
                      {
                        if($size[0] > $size[1])
                        {
                          $large_width = 500;
                          $large_height = (int)(500 * $size[1] / $size[0]);
                        }
                        else
                        {
                          $large_width = (int)(500 * $size[0] / $size[1]);
                          $large_height = 500;
                        }
                        $imagemagickPath = "/usr/local/bin";


                        exec("$imagemagickPath/convert -geometry " .
                         "{$large_width}x{$large_height} " .
                         "$imagedir/$newfile $imagedir/lg-$newfile");
                      }
            // let's make sure the uploaded file isn't gigantic
                      $size = GetImageSize( "$imagedir/$newfile" );
                      if ($size[0] > 300 || $size[1] > 300)
                      {
                        if($size[0] > $size[1])
                        {
                          $large_width = 300;
                          $large_height = (int)(300 * $size[1] / $size[0]);
                        }
                        else
                        {
                          $large_width = (int)(300 * $size[0] / $size[1]);
                          $large_height = 300;
                        }
                        


                        exec("$imagemagickPath/convert -geometry " .
                         "{$large_width}x{$large_height} " .
                         "$imagedir/$newfile $imagedir/med-$newfile");
                      }

        $image="$newfile";
              // end of screenshot handler
         }
              if ($result=mysql_query("INSERT into news
                           SET
                            date = '$year$month$monthdate',
                            month = '$month',
                            monthdate = '$monthdate',
                            year = '$year',
                            title = '".addslashes($title)."',
                            subtitle = '".addslashes($subtitle)."',
                            abstract = '".addslashes($abstract)."',
                            body = '".addslashes($body)."',
                            displayphoto = '$image',
                            type = '$type',
                            dateposted=NOW(),
                    		photo_caption='".addslashes($photo_caption)."'"))
         					{
								header("Location: $domain/admintools/newsadmin.php");
    						}
    						else
    						{
								$goof = mysql_error();
								$error .= "<b>Error:</b>  DB Insert failed. Don't know why.   $goof\n";
    						}

      }
    }
    else
    {
    	$error .= "<b>Error:</b>  Database connection failed.\n";
    }


    if (!$action)
    {
      $submitvalue=" Add news item";
      $heading = " Add news item";
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

<p><FORM ACTION="add_news.php?action=$formaction&a=$a" METHOD="POST" ENCTYPE="multipart/form-data">
<p><TABLE WIDTH=600 BORDER=1>
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
<TD>

  <INPUT TYPE="text" NAME="title" VALUE="$title" SIZE=40>

</TD>
</TR>
<TR>
<TD>
  <B>Display Photo</B>
  <br /><I>If any</I>
</TD>
<TD>
	$existingimage
  <INPUT TYPE="FILE" NAME="image" SIZE=40>

</TD>
</TR>
<tr valign="top">
<td colspan="2">
	<b>Photo Caption:</b>
	<br /><input type="text" name="photo_caption" value="$photo_caption" size="60" />
</td>
</tr>
<TR VALIGN=TOP>
<TD>
  <B>Abstract:</B>
</TD>

<TD>
<textarea cols="80" name="abstract" rows="10">$abstract</textarea>

</TD>
</TR>
<TR VALIGN=TOP>
<TD>
  <B>Pastable Body:</B>
</TD>
<TD>
<textarea cols="80" name="body" rows="10">$body</textarea></textarea>
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