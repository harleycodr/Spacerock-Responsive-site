<?php
$thispage=$_SERVER['PHP_SELF'];
$currentpage="http://www.spacerock.com$thispage";
// current working directory 
$currentdir = getcwd();
if($currentdir == "/home/content/44/10809344/html/SPACEROCK/admintools")
{
	$toolsuite=1;
}

include("dbconnect.php");
if($link)
{
		if($resulta=mysql_query("SELECT
            title,
            ID
            from
            news
            order by date DESC LIMIT 5 offset 1"))
            {
                $colcount=mysql_num_rows($resulta);
                if($colcount>0)
                {

                    while($row=mysql_fetch_array($resulta))
                    {
                        $atitle=stripslashes($row[0]);
                        $aid=$row[1];

						$charcount=strlen($atitle);

						$position=18;

						$trimmed="$atitle";
						$artitle= substr($trimmed, 0, $position);

						if($charcount>18)
						{
							$atsuffix="...";
						}
						else
						{
							$atsuffix="";
						}
						$newsmenulinks .= "<li><a href=\"/news.php?n=$aid\">$artitle$atsuffix</a></li>\n";
                    }

                }
            }
            else
            {
                $goof=mysql_error();
                $error="<b>Error:</b>  $error";
            }
// yearly archives
            if($resulty=mysql_query("SELECT
                DISTINCT
                year(date)
                from news
                order by year(date) DESC LIMIT 8"))
                {
                    while($row=mysql_fetch_array($resulty))
                    {
                        $newsyear=$row[0];

                         if($newsyear)
                         {
                            $myearlyarchives .= "<a href=\"/$newsurl?year=$newsyear\">$newsyear</a>\n";
                         }
                    }
                }
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}

// some photos
       if($result=mysql_query("SELECT
            category_id,
            category_name,
            leadpic
            from gallery_category
            order by category_id DESC LIMIT 5"))
            {
                while($row=mysql_fetch_array($result))
                {
                    $g=$row[0];
                    $gallery_name=stripslashes($row[1]);
                    $leadpic=$row[2];

                    $picdisplay .= "<li><a href=\"/photos.php?g=$g\">$gallery_name</a></li>\n";
                }
            }
            else
            {
                $goof=mysql_error();
                $error="<b>Error:</b>  $goof\n";
            }

	mysql_close($link);
}
else
{
	$error = "<b>Error:</b>  No Database connection.\n";
}
print <<<ENDTAG
<!DOCTYPE html>

<html>
<head>
<title>Welcome to Spacerock.com - $titletag This Page:  $currentpage  Basepath:  $homepage</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<script src="js/utils.js"></script>
<script src="js/lightbox.js"></script>
<script src="js/mobilenav.js"></script>
<script src="js/desktopnav.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="shortcut icon" href="favicon.ico" />
<link rel=stylesheet type="text/css" href="http://www.spacerock.com/css/styles.css" />
ENDTAG;
if($toolsuite=="1")
{
print <<<ENDTAG
<script type="text/javascript" src="http://www.spacerock.com/admintools/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>

ENDTAG;
}
print <<<ENDTAG
</head>
<body>
<div id="blackout"></div>
ENDTAG;
include("/home/content/44/10809344/html/SPACEROCK/includes/lightboxes.php");
print <<<ENDTAG
<!--mobilenav start-->
<header id="banner_container">
	<header id="banner">
		<header id="banner_logo">
ENDTAG;
if($currentpage=="$homepage")
{
print  "<img src=\"/images/header.png\" />\n";

}
else
{
	print  "<a href=\"index.php\"><img src=\"/images/header.png\" border=\"0\" title=\"Return to Home\" /></a>\n";
}
print <<<ENDTAG
		</header>
		<header id="tagline">
			Welcome to my Eclectic World!
		</header>
	</header><!--banner end-->
<!--desktop nav start-->
<nav id="desktopnav">
			<ul class="navparent">
                <li><a href="#" id="news" title="Click to expand">News  <span class="navarrow">&#9658;</span></a>
					<ul id="navchild_news" class="navchild">
						$newsmenulinks
					</ul>
				</li>
            </div>
			</ul>
            
			<ul class="navparent">
				<li><a href="#" id="photos" title="Click to expand">Photos <span class="navarrow">&#9658;</span></a>
					<ul id="navchild_photos" class="navchild">
						$picdisplay
						<li><a href="photos.php">All Albums</a></li>
					</ul>  
				</li>
			</ul>
              
			<ul class="navparent">
				<li><a href="#" id="about" title="Click to expand">About Me <span class="navarrow">&#9658;</span></a>
					<ul class="navchild" id="navchild_about">
					<li><a href="about.php">About Me</a></li>
					<li><a href="portfolio.php">Web Portfolio</a></li>
					<li><a href="playground" target="_blank">Code Portfolio</a></li>
				</ul>
				</li>
			</ul>
            
			<ul class="navparent">
				<li>
					<a href="#" id="collections" title="Click to expand">Collections <span class="navarrow">&#9658;</span></a>
					<ul class="navchild" id="navchild_collections">
						<li><a href="recipes.php">Recipes</a></li>
						<!--li><a href="bookshelf.php">Bookshelf</a></li-->
						<li><a href="rants.php">Rants/Raves</a></li>
						<li><a href="funny.php">Funny Stuff</a></li>
						<li><a href="fave-links.php">Favorite Links</a></li>
						<li><a href="videoclips.php">Video Clips</a></li>
						<li><a href="dvds.php">DVD Library</a></li>
					</ul>
				</li>
			</ul> 
            <div class="navparent" id="contact">
                <a href="#" class="showcontact">Contact Me</a>
            </div>
		<header id="banner_icons">
			
			<p><div class="banner_icon banner_icon_home"><a href="index.php" title="Return to Home Page">&nbsp;</a></div></p>
			<p><div class="banner_icon banner_icon_email"><a href="mailto:mstevens@spacerock.com" title="Email Me">&nbsp;</a></div></p>
			<p><div id="searchbox">
				<form method="get" action="search.php">
				<div id="searchformfield">
					<input type="text" id="searchstring"   placeholder="Search Spacerock.com" />
				</div>
				<input class="banner_icon_search" type="submit" title="Search" />&nbsp;</span></form>
			</div></p>
		</header>
</nav><!--desktop nav end-->
<nav id="mobilenavarea">
		<div id="mobilenavtopbar">
			<div style="float:left; width:20%;">
				<div id="lines"></div>
			</div>
		</div>
		
		<nav id="mobilenav">
			<div class="mobilenavparent">
                <a href="news.php" id="news">News</a>
			</div>
            <div id="child_news" class="child">
                $newslinks
            </div>
			<div class="mobilenavparent">
					 <a href="photos.php" id="photos">Photos</a>
			</div>
            <div id="child_photos" class="child">
                $albumlinks
            </div>    
			<div class="mobilenavparent">
					 <a href="about.php" id="about">About Me</a>
			</div>
            <div class="child" id="child_about">
                <p><a href="bio">? About Me</a></p>
                <p><a href="webportfolio">? Web Portfolio</a></p>
                <p><a href="playground">? Code Portfolio</a></p>
            </div>
			<div class="mobilenavparent">
					 <a href="#" id="collections">Collections</a>
			</div> 
			<div class="child" id="child_collections">
				<p><a href="recipes.php">Recipes</a></p>
				<!--p><a href="bookshelf.php">Bookshelf</a></p-->
				<p><a href="rants.php">Opinion</a></p>
				<p><a href="funny.php">Funny Stuff</a></p>
				<p><a href="fave-links.php">Favorite Links</a></p>
				<p><a href="videoclips.php">Video Clips</a></p>
				<p><a href="dvds.php">DVD Library</a></p>
			</div>
            <div class="mobilenavparent" id="contact">
                <a href="mailto:mstevens713@gmail.com">Contact Me</a>
            </div>
		</nav>
</nav>
<!--mobilenav end-->
</header><!--banner_container-->
ENDTAG;
?>