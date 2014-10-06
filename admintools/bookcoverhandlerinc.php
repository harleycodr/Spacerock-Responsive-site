<?php
if($host=="localhost")
{
	$coverdir="/wamp/www/spacerock/bookshelf/covers";
}
else
{
	$coverdir="/home/content/44/10809344/html/SPACEROCK/bookshelf/covers";
}
$covermagickPath = "/usr/bin";
      if ($cover_type == "image/pjpeg")
        {
          $extension = ".jpg";
        }
      elseif ($cover_type == "image/jpeg")
        {
          $extension = ".jpg";
        }
      elseif ($cover_type == "image/jpg")
        {
          $extension = ".jpg";
        }
      elseif ($cover_type == "image/gif")
      {
        $extension = ".gif";
      }

      if ($cover_type == "image/PJPEG")
        {
          $extension = ".jpg";
        }
      elseif ($cover_type == "image/JPEG")
        {
          $extension = ".jpg";
        }
      elseif ($cover_type == "image/GIF")
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

        $newcoverfile="$thisyear$thismonth$thisday$thishour$thisminute$thissecond$extension";

        copy($cover, "$coverdir/$newcoverfile");

  // image magick start
  // let's make sure the uploaded file isn't gigantic
            $size = GetImageSize( "$coverdir/$newcoverfile" );
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


exec("$covermagickPath/convert -geometry " .
 "{$large_width}x{$large_height} " .
 "$coverdir/$newcoverfile $coverdir/$newcoverfile");
            }
          // create medium image
  // let's make sure the uploaded file isn't gigantic
            $size = GetImageSize( "$coverdir/$newcoverfile" );
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



exec("$covermagickPath/convert -geometry " .
 "{$large_width}x{$large_height} " .
 "$coverdir/$newcoverfile $coverdir/med_$newcoverfile");
            }
          // create thumb
  // let's make sure the uploaded file isn't gigantic
            $size = GetImageSize( "$coverdir/$newcoverfile" );
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


		exec("$covermagickPath/convert -geometry " .
		 "{$large_width}x{$large_height} " .
		 "$coverdir/$newcoverfile $coverdir/tb_$newcoverfile");
	    }
            $updatedimage="$newcoverfile";
    // end of screenshot handler
   
?>