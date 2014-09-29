<?php

include("includes/declarations.php");
$crawltsite=2;
require_once("/var/chroot/home/content/44/10809344/html/crawltrack/crawltrack.php");
$thismonth=date(m);
$thisday=date(d);
$thisdate="$thismonth$thisday";
$thisyear=date(Y);

$htoday="$thisyear$thismonth$thisday";
$crawltsite=1;

$today="$thisyear$thismonth$thisday";
$titletag="";

include("includes/dbconnect.php");
if($link)
{
// get snapple cap
        if ($snapplecap=mysql_query("SELECT
			text
			from snapplecaps
			order by rand() limit 1"))
			{
				while ($row=mysql_fetch_array($snapplecap))
				{
					$sc=stripslashes($row[0]);
				}
			}
			else
			{
                $goof=mysql_error();
				$error .= "<b>Error:</b>  Snaple cap query failed.  $goof";
			}
        //get rants
        if($leadrant=mysql_query(" SELECT
            ID,
            title,
            abstract
            from rants ORDER by ID DESC LIMIT 1"))
            {
                while ($row = mysql_fetch_array($leadrant))
                {

                    $leadrantid=$row[0];
                    $title=stripslashes($row[1]);
                    $abstract=stripslashes($row[2]);

                    $leadrantdisplay .= "<p class=\"fwb\">$title\n";
                    $leadrantdisplay .= "<br />$abstract</p>\n";
                    $leadrantdisplay .= "<p class=\"tar fsi\"><a href=\"rants.php?r=$leadrantid\"><i>more...</i></a></p>\n";
                }
            }
			else
			{
                $goof=mysql_error();
				$error .= "<b>Error:</b>  Rant query failed.  $goof";
			}

            if($rantraves=mysql_query(" SELECT
                ID,
                title
                from rants  WHERE ID != $leadrantid
                ORDER by ID DESC LIMIT 1"))
                {
                    while ($row = mysql_fetch_array($rantraves))
                    {
                      $rantid=$row[0];
                      $ranttitle=stripslashes($row[1]);

                      $rantlist .= "<li><a href=\"$ranturl?rant=$rantid\">$ranttitle</a></li>\n";
                    }
                }
    			else
    			{
                    		$goof=mysql_error();
    				$error .= "<b>Error:</b>  $goof";
    			}
            if($photoalbum=mysql_query(" SELECT
            category_id,
            leadpic,
            category_name
            FROM gallery_category where feature='x'"))
            {
              while ($row = mysql_fetch_array($photoalbum))
                {
                  $cid=$row[0];
                  $leadpic=$row[1];
                  $albumname=stripslashes($row[2]);

                  $featuredphoto.="<p class=\"tac\"><a href=\"photos.php?action=g&g=$cid\"><img src=\"/photos/$leadpic\" border=\"0\" alt=\"featured photo album\" width=\"160\" /></a></p>\n";
            			$featuredphoto.="<p class=\"tac\">$albumname</p>";
                }
                $filecount=0;
                if ($photogalleryscriptmaker=mysql_query("SELECT
                        photo_filename,
                        photo_id,
                        photo_caption
                        from gallery_photos
			             WHERE photo_category=$cid"))
			     {
			         $numberoffiles=mysql_num_rows($photogalleryscriptmaker);
                     while ($row=mysql_fetch_array($photogalleryscriptmaker))
                     {
                        $filecount=$filecount+1;

                        $photofile=$row[0];
                        $photoid=$row[1];
                        $photocaption=stripslashes($row[2]);

                        $demogalleryscript .= "\t\tvar img$photoid = {\n";
                        $demogalleryscript .= "\t\tplayer:     'img',\n";
                        $demogalleryscript .= "\t\tcontent:    'photos/$photofile',\n";
                        $demogalleryscript .= "\t\ttitle:      '$photocaption'\n";
                        $demogalleryscript .= "\t};\n\n";

                        if ($filecount < $numberoffiles)
                        {
                            $comma=", ";
                        }
                        else
                        {
                            $comma="";
                        }

                        $openvar .= "img$photoid$comma";



                    }
                }
                else
                {
                    $error .= "<b>Error:</b>  Photogallery query failed.\n";
                }
            }
            else
            {
            $error .= "<b>Error:</b>  Photoalbum query failed.\n";
            }
    //get lead story
            if($newsitems=mysql_query(" SELECT ID,
                url,
                monthname(dateposted) AS month,
                dayofmonth(dateposted) AS day,
                year(dateposted) AS year,
                title,
                abstract,
                displayphoto,
                photo_caption
                from news
                ORDER by ID DESC LIMIT 1"))
            {
                while ($row = mysql_fetch_array($newsitems))
                {
                    $leadstoryid=$row[0];
                    $url=$row[1];
                    $month=$row[2];
                    $monthdate=$row[3];
                    $year=$row[4];
                    $title=stripslashes($row[5]);
                    $abstract=stripslashes($row[6]);
                    $displayphoto=$row[7];
         			$photo_caption=stripslashes($row[8]);

         			if ($photo_caption)
         			{
        				$caption = "<h3>$photo_caption</h3>\n";
         			}

            // lead story includes snapplecap

                    $leadstory .= "<h2 class=\"tac\">$title</h2>\n";
                    $leadstory .= "<p><img src=\"/images/uploads/$displayphoto\" class=\"newsphoto\" title=\"$photo_caption\"  style=\"padding:2px;\" /><br /><span class=\"caption\">$caption</span></p>\n";
                    $leadstory .= "<br /><b><i>Posted:  $month $monthdate, $year</i></b>\n";
                    $leadstory .= "<p>$abstract</p>";
                    $leadstory .= "<div class=\"newslink\"><a href=\"news.php?n=$leadstoryid\"><i>More</i></a></p></div>\n";
                    $leadstory .= " <aside id=\"snapplecap\"><p class=\"fwb fsi\">Did you know....</p>\n";
                    $leadstory .= " <div class=\"snapplecap\">\n";
                    $leadstory .= "$sc\n";
                    $leadstory .= "</div></aside>\n";
                    $leadstory .= "</div><!--abstract-->";
                    
               }
            }
            else
            {
                $error .= "<b>Error:</b>  Lead Story query failed.\n";
            }
	// guest article
		if($guestresult=mysql_query("SELECT
			id,
			abstract,
			author,
			title
			from guest_articles
			order by date desc limit 1"))
			{
				while($row=mysql_fetch_array($guestresult))
				{
					$a=$row[0];
					$abstract=stripslashes($row[1]);
					$author=$row[2];
					$title=stripslashes($row[3]);
					
					
					$guestarticle .= "<p><span  class=\"fwb\">$title</span>\n";
					$guestarticle .= "<br />by $author\n";
					$guestarticle .= "<br />$abstract\n";
					$guestarticle .= "<span class=\"tar\"><a href=\"articles.php?a=$a\">Read More</a></span></p>\n";
					
				}
			}
			else
			{
				$goof=mysql_error();
				$error="<b>Error:</b>  $goof";
			}
			
			// get top rated links
            if ($favelinks=mysql_query("SELECT ID, url, title from links ORDER by rating DESC LIMIT 3"))
            {
            	while ($row=mysql_fetch_array($favelinks))
            	{
            		$faveid=$row[0];
            		$faveurl=$row[1];
            		$favetitle=$row[2];

            		$fablinks.="<span class=\"list\"><a href=\"$linksurl\" target=\"_blank\">$favetitle</a></span><br />\n";
            	}
            }
            else
            {
            	$error .= "<b>Error:</b>  Fave links query failed horribly.\n";
            }
            // get video  
            if ($featuredvideo=mysql_query("SELECT
                 title,
                 embedsource
                 from videos
                 where featured='1'"))
                 {
                 	while ($row=mysql_fetch_array($featuredvideo))
                 	{
                 		$vidtitle=stripslashes($row[0]);
                 		$embedvidsrc=$row[1];
						
						$embedvidsrc=str_replace("200", "100%",$embedvidsrc);
						
                 	}
                 }
                 else
                 {
                 	$error .= "<b>Error:</b>  Video query failed.\n";
                 }
            //humor items to show
            if ($thismonth=="12")
            {
            	if ($thisday<26)
            	{
            		$humoritems=mysql_query("SELECT ID, title from humor where category=13 ORDER by title");
            		while ($row=mysql_fetch_array($humoritems))
            		  {
            			$humorid=$row[0];
            			$humortitle=$row[1];

            			$humordisplay .= "<br /><span class=\"list\"><a href=\"$humorurl?humor=$humorid\">$humortitle</a></span>\n";
            		  }
            	}
            	else
            	{
            		$humoritems=mysql_query("SELECT ID, title, category, url from humor where homepage='x' OR $today > displaystartdate AND $today < displayenddate ORDER by ID DESC");
            		while ($row=mysql_fetch_array($humoritems))
            		  {
            			$humorid=$row[0];
            			$humortitle=$row[1];
						$humorcat=$row[2];
						$url=$row[3];
						
						if($humorcat=="3")
						{
							$humordisplay .= "<br /><span class=\"list\"><a href=\"$url\">$humortitle</a></span>\n";
						}
						else
						{
							$humordisplay .= "<br /><span class=\"list\"><a href=\"$humorurl?h=$humorid\">$humortitle</a></span>\n";
						}
            		  }
            	}
            }
            else
            {
            	$humoritems=mysql_query("SELECT ID, title, category, url from humor where homepage='x' OR $today > displaystartdate AND $today < displayenddate ORDER by ID DESC limit 5");
            	while ($row=mysql_fetch_array($humoritems))
            	  {
            		$humorid=$row[0];
            		$humortitle=$row[1];
					$humorcat=$row[2];
					$url=$row[3];
					
					
            		if($humorcat=="3")
					{
						$humordisplay .= "<br /><span class=\"list\"><a href=\"$url\">$humortitle</a></span></li>\n";
					}
					else
					{
						$humordisplay .= "<br /><span class=\"list\"><a href=\"$humorurl?h=$humorid\">$humortitle</a></span></li>\n";
					}
            	  }
            }
			
}
else
{
	$error = "<b>Error:</b>  No Database connection.\n";
}
include("includes/headerinc.php");

print <<<ENDTAG
<div class="clearfix"></div>
	<article id="content">
	
	
ENDTAG;
if($error)
{
	print "<span class=\"error\">$error</span>\n";
}
else
{

print <<<ENDTAG
	<article class="left_col">
		<article class="middle_col" id="leftsmalldevice">
			<h1 class="tac">The Latest</h1>
			$leadstory
			<h2 class="tac">Opinion</h2>
			$leadrantdisplay
		</article>
ENDTAG;
include("includes/weatherwidget.php");
print <<<ENDTAG
	
		<article class="storybox">
			<h2>Guest Article</h2>
			$guestarticle
		</article>
		<article class="storybox">
			<h1 class="tac">Featured Video</h1>
			<h2 class="tac">$vidtitle</h2>
            $embedvidsrc
			<p><a href="videos.php">More Video Faves</a></p>
		</article>
	</article>
	<article class="middle_col" id="middledesktop">
			<h1 class="tac">The Latest</h1>
			$leadstory
			<h2 class="tac">Opinion</h2>
			$leadrantdisplay
		</article>
	<article class="right_col">
		<article class="storybox">
			<h2 class="tac">Featured Photo Album</h2>
			$featuredphoto
		</article>
		<article class="storybox">
			<h2 class="tac">Favorites on the Web</h1>
			$fablinks
		</article>
		
		<article class="storybox">
			<h2 class="tac">Funny Stuff</h2>
			$humordisplay
		</article>
		<article class="storybox">
			<h2 class="tac">Sign Up for my Mailing List</h2>
			<p>I promise I won't spam you!</p>
			<form action="subscribe.php" method="post">
			<input type="hidden" value="" id="hidden_field" />
			<p><input type="text" name="first" class="subscribeinput" placeholder="First Name" /></p>
			<p><input type="text" name="last" class="subscribeinput" placeholder="Last Name" /></p>
			<p><input type="email" name="email" class="subscribeinput" placeholder="e-mail" /></p>
			<p class="tac"><input type="submit" value="Subscribe" id="subscribe_submit" /></p></form>
			
		
		</article>
	</article>
	<aside id="sister_sites">
		<h1 class="tac">Sister Sites</h1>
		<div class="sister_site">
			<a href="http://www.mariansrecipebox.com" target="_blank"><img src="images/mariansrecipebox.jpg" title="Marian's Recipe Box BETA - A social networking site for those who love to cook" border="0" /></a>
		</div>
		<div class="sister_site">
			<a href="http://www.la-cocina.net" target="_blank"><img src="images/la-cocina-tile.png" title="LaCocina - Authentic Mexican Recipes" border="0" /></a>
		</div>
		<div class="sister_site">
			<a href="http://www.grillingirl.com" target="_blank"><img src="images/grillingirl.jpg" border="0" title="Grillingirl - recipes from the grill" /></a>
		</div>
		<div class="sister_site">
			<a href="http://www.paneintheglass-sg.com" target="_blank"><img src="images/panetile.jpg" border="0" title="Pane in the Glass Stained Glass" /></a>
		</div>
		
			
		</aside><!--sister_sites-->
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("includes/footerinc.php");
?>

