<?php
// When is Thanksgiving?
//We determine what day of the week the first falls on
$thisyear=date('Y');
$xmas.=$thisyear;
$xmas .="1225";
 $day_of_week = date('D', $first_day) ;

 //Based upon this, we add the appropriate number of days to get to the forth Thursday of the month

 switch($day_of_week){
 case "Sun": $add = 25; break;
 case "Mon": $add = 24; break;
 case "Tue": $add = 23; break;
 case "Wed": $add = 22; break;
 case "Thu": $add = 21; break;
 case "Fri": $add = 27; break;
 case "Sat": $add = 26; break;
 }

 $Thanksday = 1 + $add;
$thanksmonth="11";

$thanksgiving="$thisyear$thanksmonth$Thanksday";

// end of thanksgiving function

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
$view=$_REQUEST['view'];
$h=$_REQUEST['h'];
$hcat=$_REQUEST['hcat'];
$hcatname=$_REQUEST['hcatname'];

include("includes/dbconnect.php");
if($link)
{
	switch($view)
	{
		case "h":
		$columns="2";
		
        if($result=mysql_query("SELECT
            category,
            title,
            body from humor where ID=$h"))
            {
                while($row=mysql_fetch_array($result))
                {
                    $category=$row[0];
                    $title=stripslashes($row[1]);
                    $body=stripslashes($row[2]);
					
					$titletag="$hcatname - $title";
                    $display.="<p><a href=\"funny.php\">Funny Stuff</a> > <a href=\"funny.php?view=hcat&hcat=$hcat&hcatname=$hcatname\">$hcatname</a> > $title</p>";

                    $display.= "<h3>$title</h3>";
                    $display.= "<p>$body</p>";

                 }
            }
            else
            {
                $goof=mysql_error();
                $error="<b>Error:</b>  $goof";
            }

            // get other stuff from that category for the left column
            if($result2=mysql_query("SELECT
                        title,
                        url,
                        staticurl,
                        ID
                        from humor
                        where category=$category  AND ID !=$h
                        order by title"))
                        {
				$samecatitems=mysql_num_rows($result2);
				if($samecatitems>0)
				{
					$columns=2;
					$leftcol .= "<p class=\"fwb\">In This Section...</p>\n";
								
				}
				else
				{
					$columns=1;
				}
                            while($row=mysql_fetch_array($result2))
                            {
                                $ltitle=stripslashes($row[0]);
                                $url=$row[1];
                                $staticurl=$row[2];
                                $lh=$row[3];

                                if(($staticurl=="1") || ($category=="3"))
                                {
                                    $href="$url";
									$target="target=\"_blank\"";
                                }
                                else
                                {
                                    $href="funny.php?view=h&h=$lh&hcatname=$hcatname&hcat=$hcat";
                                }
                                $leftcol .= "<p><a href=\"$href\" $target>$ltitle</a></p>\n";
                            }
                        }
                        else
                        {
                            $goof=mysql_error();
                            $error="<b>Error:</b>  $goof";
                        }
		break;
		case "hcat":
		$columns=2;
		$titletag="Humor:  $hcatname";
		$display .= "<p><a href=\"funny.php\">Funny Stuff</a> > <a href=\"funny.php?view=hcat&hcat=$hcat&hcatname=$hcatname\">$hcatname</a></p>\n";
		if($result=mysql_query("SELECT
			ID,
			title
			from 
			humor
			where 
			category='$hcat'"))
			{
				$itemcount=mysql_num_rows($result);
				
				$division=$itemcount/2;
				$limit=round($division);
				$count=0;
				
				$display .= "<h1 class=\"tac\">$hcatname</h1>\n";
				$display .= "<div class=\"dbl_col_layout\">\n";
				while($row=mysql_fetch_array($result))
				{
					$h=$row[0];
					$title=stripslashes($row[1]);
					
					$display .= "<p><a href=\"funny.php?view=h&h=$h&hcatname=$hcatname&hcat=$hcat\">$title</a></p>\n";
					$count=$count+1;
					if($count=="$limit")
					{
						$display .= "</div><div class=\"dbl_col_layout\">\n";
						$count=0;
					}
				}
				$display .= "</div>\n";
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b>  $goof\n";
			}
			// left col layout to show other categories
			$leftcol .= "<p class=\"tac fwb\">Categories</p>\n";
			
			$thismonth=date(m);
			$thisday=date(d);
			$today="$thisyear$thismonth$thisday";
			if($today>$thanksgiving)
			{
				if($today>$xmas)
				{
					$selector="AND ID !='13'";
				}
			}
			elseif($today<$thanksgiving)
			{
				$selector="AND ID!='13'";
			}
			if($sth=mysql_query("SELECT
				ID,
				category
				from humorcategories
				where category !='$hcat' $selector order by category"))
				{
					while($row=mysql_fetch_array($sth))
					{
						$hcat=$row[0];
						$category=stripslashes($row[1]);
						
						$leftcol .= "<p><a href=\"funny.php?view=hcat&hcat=$hcat\">$category</a></p>\n";
					}
				}
				else
				{
					$goof=mysql_error();
					$error = "<b>Error:</b>  $goof\n";
				}
		break;
		case "":
		$columns="1";
		$titletag="Funny stuff I've collected over the years";
		$thismonth=date(m);
		$thisday=date(d);
		$today="$thisyear$thismonth$thisday";
		if($today>$thanksgiving)
		{
			if($today>$xmas)
			{
				$selector="where ID !='13'";
			}
		}
		elseif($today<$thanksgiving)
		{
			$selector="where ID!='13'";
		}
		$display .= "<h1 class=\"tac\">Funny Stuff</h1>\n";
		if($result=mysql_query("SELECT
			ID,
			category
			from humorcategories $selector
			order by category"))
			{
				$catcount=mysql_num_rows($result);
				$division=$catcount/2;
				$limit=round($division);
				$count=0;
				
				$display .= "<div class=\"dbl_col_layout\">\n";
				while($row=mysql_fetch_array($result))
				{
					$hcat=stripslashes($row[0]);
					$category=stripslashes($row[1]);
					
					$display .="<p class=\"fwb tac\"><a href=\"funny.php?view=hcat&hcat=$hcat&hcatname=$category\">$category</a></p>\n";
					$count=$count+1;
					if($count=="$limit")
					{
						$display .= "</div><div class=\"dbl_col_layout\">\n";
						$count=0;
					}
				}
				$display .= "</div>\n";
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b>  $goof\n";
			}
		break;
	}// end of switch
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
	if($columns=="2")
	{
print <<<ENDTAG
		<!-- use this for 2 col -->
		<aside id="in_this_section">
			$leftcol
			
		</aside>
		<article id="content_col">
			$display
		</article>
ENDTAG;
	}
	elseif($columns=="1")
	{
print <<<ENDTAG
	$display
ENDTAG;
	}
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("inclues/footerinc.php");
?>

