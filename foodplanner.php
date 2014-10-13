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
	if($result1=mysql_query("SELECT
		id,
		type
		from skinny_recipe_types
		order by type"))
		{
			while($row=mysql_fetch_array($result1))
			{
				$typeid=$row[0];
				$type=$row[1];
				
				if($result=mysql_query("SELECT
					id,
					name,
					rating,
					ingredients,
					prep,
					ppv,
					marinate,
					source
					from skinny_recipes
					where type='$typeid'
					order by name"))
					{
						$types=mysql_num_rows($result);
						if($types>0)
						{
							$selections .= "<p class=\"fwb\">$type</p>\n";
							
							while($row=mysql_fetch_array($result))
							{
								$r=$row[0];
								$name=stripslashes($row[1]);
								$rating=$row[2];
								$ingredients=stripslashes($row[3]);
								$prep=stripslashes($row[4]);
								$ppv=$row[5];
								$marinate=$row[6];
								$source=$row[7];
								
								if($source)
								{
									$sourcedisp = "<span class=\"fwb\">Source:</span>  $source\n";
								}
								
								if($rating=="0")
								{
									$stars="Not Rated\n";
								}
								elseif($rating=="1")
								{
									$stars="&#9733;\n";
								}
								elseif($rating=="2")
								{
									$stars="&#9733; &#9733;\n";
								}
								elseif($rating=="3")
								{
									$stars="&#9733; &#9733; &#9733;\n";
								}
								elseif($rating=="4")
								{
									$stars="&#9733; &#9733; &#9733; &#9733;\n";
								}
								elseif($rating=="5")
								{
									$stars="&#9733; &#9733; &#9733; &#9733; &#9733;\n";
								}
								
								$selections .= "<p id=\"$r\" draggable=\"true\">$ppv PPV $name</p>\n";
								$selections .= "<div style=\"display:none;\" class=\"tooltag\" id=\"tag$r\">\n";
								$selections .= "<p>Rating:  $stars<br />$sourcesisp\n";
								$selections .= "</div>\n";
								$hiddendivs .= "<span class=\"ingredients\" id=\"ing$r\">$ingredients</span>\n";
								
								
							}
						}
					}
					else
					{
						$goof=mysql_error();
						$error="<b>Error:</b>  $goof";
					}
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
	$error = "<b>Error:</b>  No Database connection.\n";
}
include("includes/headerinc.php");

print <<<ENDTAG
<div class="clearfix"></div>
	<article id="content" class="clearfix">
ENDTAG;
if($error)
{
	print "<span class=\"error\">$error</span>\n";
}
else
{

print <<<ENDTAG

<!-- otherwise just put the content here-->
	<h2>Menu Manager</h2>
<script language="JavaScript">
		<!-- Begin
		if (window.print) {
		document.write('<form>'
		+ '<p class="tac"><input type=button name=print value="Print Menu"'
		+ 'onClick="javascript:window.print()"></p></form>');
		}
		// End -->
		</script>
		<p class="tac"><a href="#" id="openshoppinglist">Shopping List</a></p>
<div  id="choices">
	<p class="fwb">Drag a meal to one of the days.</p>
	$selections
</div>
<div style="width:700px; float:left;outline:solid thin;overflow:hidden;">
	
	<div id="weeklymenu">
		<div id="monday" class="days">
			<p class="fwb">Sunday</p>
		</div>
		<div id="monday" class="days">
			<p class="fwb">Monday</p>
		</div>
		<div id="tuesday" class="days">
			<p class="fwb">Tuesday</p>
		</div>
		<div id="wednesday" class="days">
			<p class="fwb">Wednesday</p>
		</div>
		<div id="thursday" class="days">
			<p class="fwb">Thursday</p>
		</div>
		<div id="friday" class="days">
			<p class="fwb">Friday</p>
		</div>
		<div id="monday" class="days">
			<p class="fwb">Saturday</p>
		</div>
		<div id="monday" class="days">
			<p class="fwb">Staples/other</p>
		</div>
	</div>
	<!--div id="shoppinglist">
		<p class="fwb tac">Shopping List</p>
		
		$hiddendivs
		
	</div-->
	<div id="menu_mgr_shopping_list" style="display:none;">
		<p class="tar"><a href="#" id="closethislist">Close</a></p>
		<p><a href="#" id="printme">Print</a></p>
		<p class="tac fwb">Shopping List</p>
		$hiddendivs
	</div>
	
</div>
<!-- page content end -->
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("includes/footerinc.php");
?>

