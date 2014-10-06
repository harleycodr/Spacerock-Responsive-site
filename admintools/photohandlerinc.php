<?php

$photodir="$imagedir";
$photomagickPath = "/usr/bin";
      if ($photo_type == "image/pjpeg")
        {
          $extension = ".jpg";
        }
      elseif ($photo_type == "image/jpeg")
        {
          $extension = ".jpg";
        }
      elseif ($photo_type == "image/jpg")
        {
          $extension = ".jpg";
        }
      elseif ($photo_type == "image/gif")
      {
        $extension = ".gif";
      }

      if ($photo_type == "image/PJPEG")
        {
          $extension = ".jpg";
        }
      elseif ($photo_type == "image/JPEG")
        {
          $extension = ".jpg";
        }
      elseif ($photo_type == "image/GIF")
      {
        $extension = "gif";
      }

        $thisyear=date(Y);
        $thismonth=date(m);
        $thisday=date(d);
        $thishour=date(G);
        $thisminute=date(i);
        $thissecond=date(s);

        $newfile="$thisyear$thismonth$thisday$thishour$thisminute$thissecond$extension";

        copy($photo, "$photodir/$newfile");

  // image magick start
  // let's make sure the uploaded file isn't gigantic
            $size = GetImageSize( "$photodir/$newfile" );
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


exec("$photomagickPath/convert -geometry " .
 "{$large_width}x{$large_height} " .
 "$photodir/$newfile $photodir/$newfile");
            }
          // create medium image
  // let's make sure the uploaded file isn't gigantic
            $size = GetImageSize( "$photodir/$newfile" );
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



exec("$photomagickPath/convert -geometry " .
 "{$large_width}x{$large_height} " .
 "$photodir/$newfile $photodir/med_$newfile");
            }
          // create thumb
  // let's make sure the uploaded file isn't gigantic
            $size = GetImageSize( "$photodir/$newfile" );
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


		exec("$photomagickPath/convert -geometry " .
		 "{$large_width}x{$large_height} " .
		 "$photodir/$newfile $photodir/tb_$newfile");
	    }
            $updatedimage="$newfile";
    // end of screenshot handler
   $photoupload=$newfile;
?>