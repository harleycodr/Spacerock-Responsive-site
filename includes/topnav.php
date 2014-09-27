<?php

$thisyear=date(Y);
$howmanyyears=$thisyear-1996;

// temporary testing urls

$newsurl="news11.php";
$homeurl="index.php";
$abouturl="who11.php";
$contacturl="contact11.php";
$recipesurl="recipes11beta.php";
$linksurl="links11.php";
$videosurl="videos11.php";
$collectionsurl="collections11.php";
$humorurl="humor11.php";
$moviesurl="movies11.php";
// MySQL Stuff

include ("includes/dbconnect.php");
if($mysql_link)
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

                        $newsmenulinks .= "<p><a href=\"/$newsurl?n=$aid\">$artitle$atsuffix</a></p>\n";
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
			
                    $picdisplay .= "<div class=\"col_1\"><a href=\"photos.php?action=g&id=$g\"><img src=\"/photos/$leadpic\" width=\"100\" title=\"$gallery_name\"></a><br />$gallery_name</div>\n";
                }
				$picdisplay .= "<div class=\"col_1\"><a href=\"photos.php\">All Albums</a>
            }
            else
            {
                $goof=mysql_error();
                $error="<b>Error:</b>  $goof\n";
            }

	mysql_close($mysql_link);

}
else
{
	$error = "<b>Error:</b>  No database connection.  navigation2.php\n";
}

print <<<ENDTAG
<!--navigation Start-->

    <ul id="menu">
   	    <li><a href="$newsurl" class="drop">News</a>
            <div class="dropdown_2columns"><!-- first drop down container-->
            <h2><b>Spacerock News and Stuff</b></h2>
                <div class="col_1">
                    <p><b>Last Few Articles:</b>
                     $newsmenulinks

                     </p>
                 </div>
                 <div class="col_1">
                 <p><b>Archived By Year</b>	<br />
				   $myearlyarchives</p>
                 </div>
                 <div class="col_2">
                   <p><a href="$newsurl?show=all"><h4>All Archives...</b></a></h4>
                   This site goes back $howmanyyears years!  It's seen a lot of change and so have I.</p>
				</div>
            </div> <!--end of first drop down-->
        </li><!--end of news items-->


        <li><a href="photos.php" class="drop">Photos</a>
          <div class="dropdown_5columns">
            <div class="col_5">
              <p><b>Latest Photo Albums</b>
            </div>
                $picdisplay

          </div>

        </li><!--end of photos-->

       	<li><a href="#" class="drop">About Me</a>
            <div class="dropdown_2columns"><!--about me dropdown-->
        		<div class="col_2">
                  <p><b>From who I am to what I do</b><p>
                </div>
                <div class="col_1">
                   <p><a href="/$abouturl">About Me</a></p>
                   <p><b>Web Development</b>
                   <br /><a href="portfolio.php">Portfolio</a>
				   <a href="playground">Code Portfolio</a>
    				<a href="/resume11.php">Resume</a></p>
       		     </div>
            </div><!--END OF ABOUT ME container-->
        </li><!--about me item end-->

       	<li><a href="#" class="drop">Collections</a>
            <div class="dropdown_4columns">
                <div class="col_4">
                  <h2>A unique collection of Stuff - from links to recipes to funny stuff</h2>
                </div>
                <div class="col_1">
                  <p><b><a href="/$recipesurl">Recipes</a></b>
                  I have collected many recipes over the year and have them here, in a printable format too!</p>

				  <p><b><a href="/bookshelf">Bookshelf</a></b>
				  Login required.  Lots of good geek reference materials here.</p>
                </div>
                <div class="col_1">
                  <p><b><a href="/rants11.php">Rants/Raves</a></b>
                  Rants about stuff in life.</p>
                </div>

                <div class="col_1">
                  <p><b><a href="/$humorurl">Funny Stuff</a></b>
                  Random emails I've received and share</p>
                  <p><b><a href="$linksurl">Favorite Links</a></b>
                  Have had to reconstruct this but it's growing again.</p>
                </div>
                <div class="col_1">
                  <p><b><a href="/$videosurl">Video Clips</a></b>
                  Some of my favorite YouTube clips appear here, including some of my very own.  Brutus gets vacuumed....</p>
                </div>
                <div class="col_1">
                    <p><b><a href="/$moviesurl">DVD Collection</a></b>
                    Want to borrow a DVD?  Check out what I have and you can sign one out.</p>
                </div>
            </div><!--end of collections div and dropdown-->
         </li><!--end of collections li-->
  	    <li><a href="/$contacturl">Contact Me</a></li>
    </ul>
   <div id="navtriangle"></div>

ENDTAG;
?>