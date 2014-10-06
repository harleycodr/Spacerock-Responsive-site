<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_GET['action'];
$s=$_GET['s'];

$image=$_FILES['image']['tmp_name'];

if($image=="")
{
  $has_image="0";
}
else
{
  $has_image="1";
  $image_type=$_FILES['image']['type'];
  
}
$sitename=$_POST['sitename'];
$description=$_POST['description'];
$url=$_POST['url'];
$year=$_POST['year'];
$month=$_POST['month'];
$day=$_POST['day'];

if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
	

    $imagedir="/home/content/44/10809344/html/spacerock/images/uploads";
    include ("../includes/dbconnect.php");

    if ($link)
    {
      if ($action == "edit")
      {
        $formaction="makeedits";
        $heading="Edit Site Info";

    // imagehandling code


        if ($result=mysql_query("SELECT
                                sitename,
                                description,
                                screenshot,
                                month(date) as month,
                                dayofmonth(date) as day,
                                year(date) as year,
                                url
                                from mysites
                                WHERE ID='$s'"))
                                {
                                  while ($row=mysql_fetch_array($result))
                                  {
                                    $sitename=stripslashes($row[0]);
                                    $description=stripslashes($row[1]);
                                    $screenshot=$row[2];
                                    $month=$row[3];
                                    $day=$row[4];
                                    $year=$row[5];
                                    $url=$row[6];

                                    if ($screenshot)
                                    {
                                      $existingimage .= "<B>Existing Image:</B>  <br /><IMG SRC=\"../images/uploads/tb_$screenshot\">\n";
                                      $existingiamge .= "<br />You can keep this image, or click browse below to locate and upload a new image.\n";
                                    }

                                  }
                                }
                                else
                                {
                                  $error .= "<B>Error:</B>  Database query failed!\n";
                                }
      }
      elseif ($action == "makeedits")
      {
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
				   elseif ($cover_type == "image/png")
				{
					$extension=".png";
				}
				elseif ($cover_type=="image/PNG")
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
                         "$imagedir/$newfile $imagedir/$newfile");
                      }
      // create medium image
            // let's make sure the uploaded file isn't gigantic
                      $size = GetImageSize( "$imagedir/$newfile" );
                      if ($size[0] > 250 || $size[1] > 250)
                      {
                        if($size[0] > $size[1])
                        {
                          $large_width = 250;
                          $large_height = (int)(250 * $size[1] / $size[0]);
                        }
                        else
                        {
                          $large_width = (int)(250 * $size[0] / $size[1]);
                          $large_height = 250;
                        }
                        $imagemagickPath = "/usr/bin";


                        exec("$imagemagickPath/convert -geometry " .
                         "{$large_width}x{$large_height} " .
                         "$imagedir/$newfile $imagedir/med_$newfile");
                      }
      // create thumb
            // let's make sure the uploaded file isn't gigantic
                      $size = GetImageSize( "$imagedir/$newfile" );
                      if ($size[0] > 100 || $size[1] > 100)
                      {
                        if($size[0] > $size[1])
                        {
                          $large_width = 100;
                          $large_height = (int)(100 * $size[1] / $size[0]);
                        }
                        else
                        {
                          $large_width = (int)(100 * $size[0] / $size[1]);
                          $large_height = 100;
                        }
                        $imagemagickPath = "/usr/bin";


                        exec("$imagemagickPath/convert -geometry " .
                         "{$large_width}x{$large_height} " .
                         "$imagedir/$newfile $imagedir/tb_$newfile");
                      }
        $updatedimage="$newfile";
              // end of screenshot handler
        }
       else
         {
           $updatedimage="$oldimage";
         }


        if ($result=mysql_query("UPDATE mysites
                                    SET
                                    sitename='".addslashes($sitename)."',
                                    description='".addslashes($description)."',
                                    screenshot='$updatedimage',
                                    url='$url',
                                    date='$year-$month-$day'
                                    WHERE ID='$s'"))
                                    {
                                      header ("Location:  $domain/admintools/managemysites.php");
                                    }
                                    else
                                    {
                                      $error .= "<B>Error:</B>  Database update failed.\n";
                                    }

      }
      elseif ($action == "addnew")
      {

      // handle that image

            if ($image)
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
				   elseif ($cover_type == "image/png")
				{
					$extension=".png";
				}
				elseif ($cover_type=="image/PNG")
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
                          $imagemagickPath = "/usr/bin";


                          exec("$imagemagickPath/convert -geometry " .
                           "{$large_width}x{$large_height} " .
                           "$imagedir/$newfile $imagedir/$newfile");
                        }
        // create medium image
              // let's make sure the uploaded file isn't gigantic
                        $size = GetImageSize( "$imagedir/$newfile" );
                        if ($size[0] > 250 || $size[1] > 250)
                        {
                          if($size[0] > $size[1])
                          {
                            $large_width = 250;
                            $large_height = (int)(250 * $size[1] / $size[0]);
                          }
                          else
                          {
                            $large_width = (int)(250 * $size[0] / $size[1]);
                            $large_height = 250;
                          }
                          $imagemagickPath = "/usr/bin";


                          exec("$imagemagickPath/convert -geometry " .
                           "{$large_width}x{$large_height} " .
                           "$imagedir/$newfile $imagedir/med_$newfile");
                        }
        // create thumb
              // let's make sure the uploaded file isn't gigantic
                        $size = GetImageSize( "$imagedir/$newfile" );
                        if ($size[0] > 100 || $size[1] > 100)
                        {
                          if($size[0] > $size[1])
                          {
                            $large_width = 100;
                            $large_height = (int)(100 * $size[1] / $size[0]);
                          }
                          else
                          {
                            $large_width = (int)(100 * $size[0] / $size[1]);
                            $large_height = 100;
                          }
                          $imagemagickPath = "/usr/local/bin";


                          exec("$imagemagickPath/convert -geometry " .
                           "{$large_width}x{$large_height} " .
                           "$imagedir/$newfile $imagedir/tb_$newfile");
                        }
          $image="$newfile";
                // end of screenshot handler
         }
        if ($result=mysql_query("INSERT into mysites
                                    SET
                                    sitename='".addslashes($sitename)."',
                                    description='".addslashes($description)."',
                                    screenshot='$image',
                                    url='$url',
                                    date='$year-$month-$day'"))
                                    {
                                      header ("Location:  $domain/admintools/managemysites.php");
                                    }
                                    else
                                    {
                                      $error .= "<B>Error:</B>  Database insert failed.\n";
                                    }

      }
    }
    else
    {
      $error .="<B>Error:</B>  Database connection failed.\n";
    }

    if (!$action)
    {
      $formaction="addnew";
      $heading="Add New Site";
    }
    $mcount=1;
    while ($mcount<13)
    {
    	$monthselects .= "<option VALUE=\"$mcount\">$mcount</option>\n";
    	$mcount=$mcount+1;
    }
    $dcount=1;
    while ($dcount<32)
    {
    	$dayselects .= "<option VALUE=\"$dcount\">$dcount</option>\n";
    	$dcount=$dcount+1;
    }
    $thisyear=date(Y);
    $limit=$thisyear+6;
    while ($thisyear<$limit)
    {
    	$yearselects .= "<option VALUE=\"$thisyear\">$thisyear</option>\n";
    	$thisyear=$thisyear+1;
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
  print "<FONT COLOR=\"red\">$error</FONT>\n";
}
else
{
print <<<ENDTAG


<CENTER><SPAN CLASS="headline">E-Z Suite page Management - Adding one of my sites</SPAN></CENTER>
<p><a href="managemysites.php">Manage My Sites on my brag page</a> > $heading
<p><CENTER><B>$heading</B></CENTER>

<p><form action="addsite.php?action=$formaction&s=$s" method="post" enctype="multipart/form-data">
<TABLE WIDTH=600 BORDER=1 ALIGN=CENTER>
<TR VALIGN=TOP>
<TD>
  <B>Site Name:</B>
</TD>
<TD>
  <INPUT TYPE="text" NAME="sitename" VALUE="$sitename" SIZE=30>
</TD>
</TR>
<TR VALIGN=TOP>
<TD>
  <B>Site URL:</B>
</TD>
<TD>
  http://<INPUT TYPE="text" NAME="url" VALUE="$url" SIZE=30>
</TD>
</TR>
<TR VALIGN=TOP>
<TD>
  <B>Screenshot</B>
</TD>
<TD>
  $existingimage
  <INPUT TYPE="file" NAME="image" SIZE=20>
  <INPUT TYPE="hidden" NAME="oldimage" VALUE="$screenshot">
</TD>
</TR-->
<TR VALIGN=TOP>
<TD COLSPAN=2>
  <B>Description:</B>
<textarea cols="80" id="editor_office2003" name="description" rows="10">$description</textarea>
				<script type="text/javascript">
				//<![CDATA[

					CKEDITOR.replace( 'description',
						{
							skin : 'office2003'
						});

				//]]>
				</script>
</TD>
</TR>
<tr valign="top">
<td>
	<B>Launch Date:</b>
</td>
<td>
	<table>
	<td>
		<select name="month">
		<option value="$month">$month</option>
		$monthselects
		</select>
	</td>
	<td>
		<select name="day">
		<option value="$day">$day</option>
		$dayselects
		</select>
	</td>
	<td>
		<input type="text" name="year" value="$year" size=5>
		<br>Year
	</td>
	</tr>
	</table>
</td>
</tr>
</TABLE>
<p><CENTER><INPUT TYPE="submit" VALUE="$heading"></FORM>
</article>
ENDTAG;
}

include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");
?>