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
$action=$_REQUEST['action'];
$today="$thisyear$thismonth$thisday";

$r=$_REQUEST['r'];
$min=$_REQUEST['min'];
$ls=$_REQUEST['ls'];
$dt=$_REQUEST['dt'];
$name=$_REQUEST['name'];

include("includes/dbconnect.php");
if($link)
{
	switch($action)
	{
		case "r":
			$bcarg="$camefrom";
			$bclink="$name";
			if($result=mysql_query("SELECT
				name,
				description,
				contributor,
				preparation,
				homepage,
				photo,
				servings
				from recipes_new
				where ID='$r'"))
				{
					while($row=mysql_fetch_array($result))
					{

						$recipename=stripslashes($row[0]);
						$description=stripslashes($row[1]);
						$contributor=stripslashes($row[2]);
						$preparation=stripslashes($row[3]);
						$homepage=$row[4];
						$photo=$row[5];
						$servings = $row[6];

						if(!$photo)
						{
							$photodisplay = "<img src=\"/images/Place_setting_mockup.gif\" alt=\"$recipename - no photo available\" width=\"200\" />";
						}
						else
						{
							$photodisplay = "<img src=\"/images/uploads/$photo\" alt=\"$recipename\" width=\"200\" />";
						}
						if($servings>0)
						{
							$servingsdisplay = "<p><i>Makes $servings servings.</i></p>\n";
						}

						if($ingpull=mysql_query("SELECT
							ingID,
							seq,
							qty,
							unit,
							preparation,
							ID,
							qty_high
							from
							recipes_ingredients_in_recipes
							where recipeID='$r' order by seq"))
							{
								$records=mysql_num_rows($ingpull);
								
								$division = $records/2;
								
								$limit=round($division);
								
								
								$ingdisplay .= "<p><b>Ingredients:</b>\n";
								
								$ingdisplay .= "<div class=\"ingcols\">\n";
								$ingcount="1";
								
								while($row=mysql_fetch_array($ingpull))
								{
									$ingID=$row[0];
									$seq=$row[1];
									$qty=$row[2];
									$unit=$row[3];
									$ingpreparation=stripslashes($row[4]);
									$xrefID=$row[5];
									$qty_high=$row[6];

									// get the name
									if($resultingname=mysql_query("SELECT
										displayname
										from recipes_single_ingredients
										where ID='$ingID'"))
										{
											while($row=mysql_fetch_array($resultingname))
											{
												$ingname=stripslashes($row[0]);
											}
										}
										else
										{
											$goof=mysql_error();
											$error="<b>Error:</b>  $goof\n";
										}
										
										if($qty_high>0)
										{
											$qtydisp="$qty - $qty_high";
										}
										else
										{
											$qtydisp = "$qty";
										}

										$ingdisplay.="<br />$qtydisp $unit $ingname $ingpreparation \n";
											
										$listlines .= "<br />$qtydisp $unit $ingname $ingpreparation \n";
											
										if($ingcount=="$limit")
										{
											$ingdisplay .= "</div><div class=\"ingcols\">";
											$ingcount="1";
										}
										else
										{
											$ingcount=$ingcount+1;
										}
								}
								
								$ingdisplay .= "</p></div><div style=\"clear:both;\"></div>\n";
								
							
						}

						else
						{
						  $goof=mysql_error();
						  $error="<b>Error:</b>  $goof\n";
						}

					// main column recipe display

					$breadcrumb = "<p><a href=\"recipes.php\">Recipes </a> > > $recipename<span style=\"width:50px; float:right;\"><a href=\"#\" id=\"print_printable\"><img src=\"/images/print_page.png\" border=\"0\"></a></span><span style=\"width:20px; float:right;\"><a href=\"#\" id=\"make_list\"><img src=\"/images/shopping_list.png\" border=\"0\"></a></span></p>\n";
	

					$display .= "<div class=\"printable\">\n";
					$titletagmention="$recipename";

					$display .= "<h2 class=\"tac\">$recipename</h2>";

					$display .= "<div style=\"width:200px; float:left; margin:0 5px; \">$photodisplay</div>\n";



					if($contributor)
					{
						$display .= "<b>Contributed by:</b>  $contributor</p>";
					}
					$display .= "<p>$description</p><div style=\"clear:both\"></div>";
					$display .= "$ingdisplay";
					$display .= "<p><b>Preparation:</b><br />$preparation";
					$display .= "$servingsdisplay";

					$display .="</div><!--printable-->\n";
				}
			}
			else
			{
				$goof=mysql_error();
				$error = "<b>Error:</b>  $goof\n";
			}
		break;
		case "dt":
			$titletag ="Recipes by dishtype:  $name";
			$breadcrumb = "<p><a href=\"recipes11beta.php?page=landing\">Recipes</a> > $name</p>\n";
			$display .= "<h2>$name</h2>\n";
			if($result=mysql_query("SELECT
				DISTINCT recipes_in_dishtypes.recipeID,
				recipes_new.name,
				recipes_new.description
				FROM recipes_new
				LEFT JOIN recipes_in_dishtypes ON recipes_in_dishtypes.recipeID = recipes_new.ID
				WHERE recipes_in_dishtypes.dishtypeID = '$dt'
				AND recipes_in_dishtypes.recipeID IS NOT NULL
				ORDER BY recipes_new.name"))
				{
					
					while($row=mysql_fetch_array($result))
					{
						$recipeID=stripslashes($row[0]);
						$recipeName=$row[1];
						$recipedesc=stripslashes($row[2]);

						$display .= "<p><a href=\"recipes.php?action=r&r=$recipeID\">$recipeName</a><br />$recipedesc</p>\n";
					}
					
				}
				else
				{
					$goof=mysql_error();
					$error ="<b>Eror:</b>  $goof";
				}
				$leftcol=0;
				$displaydt .= "</p>\n";
		break;
		case "min":
			$titletag="Recipes by $name";
			$display .= "<h2>$name</h2>\n";
			$breadcrumb = "<p><a href=\"recipes.php\">Recipes</a> > $name</p>\n";
			if($result2=mysql_query("SELECT
				DISTINCT recipes_in_ingredient.recipeID,
				recipes_new.name,
				recipes_new.description
				FROM recipes_new
				LEFT JOIN recipes_in_ingredient ON recipes_in_ingredient.recipeID = recipes_new.ID
				WHERE recipes_in_ingredient.ingredientID = '$min'
				AND recipes_in_ingredient.recipeID IS NOT NULL
				ORDER BY recipes_new.name"))
				{
					$display .= "<p>\n";
					while($row=mysql_fetch_array($result2))
					{
						$recipeID=stripslashes($row[0]);
						$recipeName=$row[1];
						$recipedesc=stripslashes($row[2]);

						$display .= "<p><a href=\"recipes.php?action=r&r=$recipeID\">$recipeName</a><br />$recipedesc</p>\n";
					}
					
				}
				else
				{
					$goof=mysql_error();
					$error ="<b>Eror:</b>  $goof";
				}
				$leftcol=0;
				$displaying .= "</p>\n";
		break;
		case "ls":
			$titletag="Recipes by Lifestyle";
			$breadcrumb = "<p><a href=\"recipes.php\">Recipes</a> > $name</p>\n";
			$display .= "<h2>$name</h2>\n";

			if($result=mysql_query("SELECT
				DISTINCT recipes_in_lifestyles.recipeID,
				recipes_new.name,
				recipes_new.description
				FROM recipes_new
				LEFT JOIN recipes_in_lifestyles ON recipes_in_lifestyles.recipeID = recipes_new.ID
				WHERE recipes_in_lifestyles.categoryID = '$ls'
				AND recipes_in_lifestyles.recipeID IS NOT NULL
				ORDER BY recipes_new.name"))
			{
				
				while($row=mysql_fetch_array($result))
				{
					$recipeID=stripslashes($row[0]);
					$recipeName=$row[1];
					$recipedesc=stripslashes($row[2]);

					$display .= "<p><a href=\"recipes.php?action=r&r=$recipeID\">$recipeName</a><br />$recipedesc</p>\n";
				}
				
			}
			else
			{
				$goof=mysql_error();
				$error ="<b>Eror:</b>  $goof";
			}
			$leftcol=0;

				$display .= "</p>\n";	
		break;
		case "":
		$cols=1;
		$titletag="All Recipes";
		$display .= "<h1 class=\"tac\">All Recipes</h1>\n";
		if($result=mysql_query("SELECT
			ID,
			name
			from recipes_new
			order by name"))
			{
				$count=mysql_num_rows($result);
				
				

			  $division = $count / 3;
			  $limit = round($division);

			  $count="0";
			  $display .= "<div class=\"recipe_cols\">\n";
				while($row=mysql_fetch_array($result))
				{
					$r=$row[0];
					$name=stripslashes($row[1]);
					
					$display .= "<p><a href=\"recipes.php?action=r&r=$r\">$name</a> </p>\n";
					
					$count=$count+1;
			
					if($count>"$limit")
					{
						$display .= "</div><div style=\"width:220px; float:left; margin:0 5px;\">\n";
						$count="0";
					}
			
				}
				if($count<"$limit")
				{
			$display .= "</div>\n";
				}
				
			}
			else
			{
				$goof=mysql_error();
				$error="<b>Error:</b>  $goof";
			}
			break;
			
	} // end of switch
	//leftcol display start
	if($result=mysql_query("SELECT
	ID,
	name
	from recipes_dishtype
	order by name"))
	{
		$leftcoldisplay .= "<p><b>Dishes</b>";
		while($row=mysql_fetch_array($result))
		{
			$dt=$row[0];
			$dtname=$row[1];

			$leftcoldisplay .= "<br /><a href=\"recipes.php?action=dt&dt=$dt&name=$dtname\">$dtname</a>";
		}
		$leftcoldisplay .= "</p>\n";
	}
	else
	{
	  $goof=mysql_error();
	  $error="<b>Error:</b>  $goof\n";
	}
	if($result2=mysql_query("SELECT
	ID,
	name
	from recipes_ingredient
	order by name"))
	{
		$leftcoldisplay .= "<p><b>Ingredients</b>\n";
		while($row=mysql_fetch_array($result2))
		{
			$min=$row[0];
			$minname=$row[1];

			$leftcoldisplay .= "<br /><a href=\"recipes.php?action=min&min=$min&name=$minname\">$minname</a>\n";
		}
			$leftcoldisplay .= "</p>\n";
	}
	else
	{
		$goof=mysql_error();
		$error="<b>Error:</b>  $goof\n";
	}

	if($result3=mysql_query("SELECT
			ID,
			name
			from recipes_lifestyle
			order by name"))
			{
				$leftcoldisplay .= "<p><b>Lifestyle</b>\n";
				while($row=mysql_fetch_array($result3))
				{
					$ls=$row[0];
					$lsname=$row[1];

					$leftcoldisplay .= "<br /><a href=\"recipes.php?action=ls&ls=$ls&name=$lsname&view=1\">$lsname</a>\n";
				}
				$leftcoldisplay .= "</p>\n";
				$leftcoldisplay .= "<p><a href=\"recipes.php\">Show All</a></p>\n";
			}
			else
			{
			  $goof=mysql_error();
			  $error="<b>Error:</b>  $goof\n";
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
		<aside id="in_this_section">
			$leftcoldisplay
		</aside>
		<article id="content_col">
			$display
		</article>

ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("inclues/footerinc.php");
?>