<?php
session_start();

	include("../includes/declarations.php");
	include("includes/declarations.php");
	
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
	$action=$_GET['action'];
	$r=$_GET['r'];
	$ID=$_GET['ID'];

	include ("fckeditor.php");

	include ("../includes/dbconnect.php");

	if ($action=="editing")
	{
		$qty=$_POST['qty'];
		$unit=$_POST['unit'];
		$seq=$_POST['seq'];
		$qty_high=$_POST['qty_high'];
		$preparation=$_POST['preparation'];
		
		if($delete=="on")
		{
			if($result=mysql_query("DELETE
				from recipes_ingredients_in_recipes
				where ID='$ID'"))
				{
					header("Location: $domain/admintools/add_recipenew.php?r=$r&action=edit");
				}
				else
				{
				  $goof=mysql_error();
				  $error="<b>Error:</b>  $goof\n";
				}

		}
		else
		{
			if($result=mysql_query("UPDATE
			recipes_ingredients_in_recipes
			set qty='$qty',
			unit='$unit',
			seq='$seq',
			qty_high='$qty_high',
			preparation='".addslashes($preparation)."'
			where ID='$ID'"))
			{
				header("Location: $domain/admintools/add_recipenew.php?r=$r&action=edit");
			}
			else
			{
			  $goof=mysql_error();
			  $error="<b>Error:</b>  $goof\n";
			}
		}


	}
	elseif ($action == "makeedits")
	{
		$qty=$_POST['qty'];
		$unit=$_POST['unit'];
		$seq=$_POST['seq'];
		$qty_high=$_POST['qty_high'];
		$preparation=$_POST['preparation'];
		$homepage=$_POST['homepage'];
		$featured=$_POST['featured'];
		$photo=$_FILES['photo']['tmp_name'];
		$contributor=$_POST['contributor'];
		$servings=$_POST['servings'];
		$wwpoints=$_POST['wwpoints'];
		include("ingdeclarations.php");
		
		if($photo=="")
		{
			$has_photo="0";
		}
		else
		{
			$has_photo="1";
			$photo_type=$_FILES['photo']['type'];
		}
	    if($has_photo=="1")
	    {
			
	      include("photohandlerinc.php");
	    }
	    else
	    {
	      $photoupload="$oldphoto";
	    }

		if ($homepage == "on")
		{
			$homepage="x";
		}
		else
		{
			$homepage="";
		}
		
		
		if($featured=="on")
		{
			$clearf=mysql_query("UPDATE recipes_new
				set featured=''
				where featured='1'");
				
				$featured="1";
		}
		if($wwpoints)
		{
			$wwrated="1";
		}
		

		if ($result=(mysql_query("UPDATE recipes_new
				  SET
					name = '$recipename',
					contributor = '$contributor',
					description = '".addslashes($description)."',
					preparation = '".addslashes($recpreparation)."' ,
					homepage = '$homepage',
					photo='$photoupload',
					servings='$servings',
					featured='$featured',
					wwpoints='$wwpoints',
					wwrated='$wwrated'
					WHERE ID='$r'")))

		{

			// add ingredients
			// put info in the crossref tables

			// cobrands - need to create abbr for this the var is decb and the id number
			
			if($wipeout=mysql_query("DELETE
						from recipes_in_cobrands
						where recipeID='$r'"))
			{

				if($result=mysql_query("SELECT
					site_name, dcb, ID from recipes_cobrand_sites order by site_name"))
				{
					while($row=mysql_fetch_array($result))
					{
						if($$row['dcb'] == "on")
										// insert into xref
						{
							mysql_query("INSERT into recipes_in_cobrands SET
							recipeID='$r',
							cobrandID='".$row['ID']."'");
						}
					}
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}
			}
			// recipes_in_ingredient  recipeID ingredientID

			if($wipeout=mysql_query("DELETE
						from recipes_in_ingredient
						where recipeID='$r'"))
			{

				if($result=mysql_query("SELECT
					name, abbr, ID from recipes_ingredient order by name"))
				{
					while($row=mysql_fetch_array($result))
					{
						if($$row['abbr'] == "on")
										// insert into xref
						{
							mysql_query("INSERT into recipes_in_ingredient SET
							recipeID='$r',
							ingredientID='".$row['ID']."'");
						}
					}
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}
			}
			else
			{
				$goof=mysql_error();
				$error="<b>Error:</b>  $goof\n";
			}


			// recipes_in_lifestyles  recipeID categoryID  recipes_lifestyles ID name abbr
			if($wipeout=mysql_query("DELETE
				from recipes_in_lifestyles
				where recipeID='$r'"))
			{
				if($result2=mysql_query("SELECT
				name, abbr, ID from recipes_lifestyle order by name"))
				{
					while($row=mysql_fetch_array($result2))
					{
						if($$row['abbr'] == "on")
							// insert into xref
						{
							mysql_query("INSERT into recipes_in_lifestyles SET
							recipeID='$r',
							categoryID='".$row['ID']."'");
						}
					}
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}
			}
			else
			{
				$goof=mysql_error();
				$error="<b>Error:</b>  $goof\n";
			}

			// recipes_in_dishtypes  recipeID dishtypeID  recipes_dishtype ID name abbr
			if($wipeout=mysql_query("DELETE
					from recipes_in_dishtypes
					where recipeID='$r'"))
			{
				if($result3=mysql_query("SELECT
					name, abbr, ID from recipes_dishtype order by name"))
				{
					while($row=mysql_fetch_array($result3))
					{
						if($$row['abbr'] == "on")
						// insert into xref
						{
							mysql_query("INSERT into recipes_in_dishtypes SET
							recipeID='$r',
							dishtypeID='".$row['ID']."'");
						}
					}
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}

			}
			else
			{
				$goof=mysql_error();
				$error="<b>Error:</b>  $goof\n";
			}


			// recipes_ingredients_in_recipes ingID recipeID seq qty unit preparation  recipes_single_ingredients ID ingredient_name description abbrev category

			// get highest sequence of existing ingredients
			if($hs=mysql_query("SELECT
						ID
						from recipes_ingredients_in_recipes
						where recipeID='$r'"))
			{
				$ingnumber=mysql_num_rows($hs);
			}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}

				$seq=$ingnumber+1;

				if($ingredient1)
				{
					
					mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient1',
						seq='$seq',
						unit='$unit1',
						qty='$qty1',
						qty_high='$qty_high1',
						preparation='$prepreparation1',
						recipeID='$r'");

						$seq=$seq+1;
				}

				if($ingredient2)
				{
					mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient2',
						seq='$seq',
						unit='$unit2',
						qty='$qty2',
						qty_high='$qty_high2',
						preparation='$preparation2',
						recipeID='$r'");


						$seq=$seq+1;
				}
				if($ingredient3)
				{
					mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient3',
						seq='$seq',
						unit='$unit3',
						qty='$qty3',
						qty_high='$qty_high3',
						preparation='$preparation3',
						recipeID='$r'");


						$seq=$seq+1;
				}
				if($ingredient4)
				{
					mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient4',
						seq='$seq',
						unit='$unit4',
						qty='$qty4',
						qty_high='$qty_high4',
						preparation='$preparation4',
						recipeID='$r'");

						$seq=$seq+1;

				}
				if($ingredient5)
				{
					mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient5',
						seq='$seq',
						unit='$unit5',
						qty='$qty5',
						qty_high='$qty_high5',
						preparation='$preparation5',
						recipeID='$r'");


					$seq=$seq+1;
				}
				if($ingredient6)
				{
					mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient6',
						seq='$seq',
						unit='$unit6',
						qty='$qty6',
						qty_high='$qty_high6',
						preparation='$preparation6',
						recipeID='$r'");


					$seq=$seq+1;
				}
				if($ingredient7)
				{
					mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient7',
						seq='$seq',
						unit='$unit7',
						qty='$qty7',
						qty_high='$qty_high7',
						preparation='$preparation7',
						recipeID='$r'");


					$seq=$seq+1;

				}
				if($ingredient8)
				{
						mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient8',
						seq='$seq',
						unit='$unit8',
						qty='$qty8',
						qty_high='$qty_high8',
						preparation='$preparation8',
						recipeID='$r'");

					$seq=$seq+1;

				}
				if($ingredient9)
				{
					mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient9',
						seq='$seq',
						unit='$unit9',
						qty='$qty9',
						qty_high='$qty_high9',
						preparation='$preparation9',
						recipeID='$r'");


					$seq=$seq+1;
				}
				if($ingredient10)
				{
					mysql_query("INSERT
						into recipes_ingredients_in_recipes SET
						ingID='$ingredient10',
						seq='$seq',
						unit='$unit10',
						qty='$qty10',
						qty_high='$qty_high10',
						preparation='$preparation10',
						recipeID='$r'");



				}

				header("Location: http://www.spacerock.com/admintools/recipeadminnew.php");


		}
		else
		{
		  $goof=mysql_error();
		  $error="<b>Error:</b>  $goof\n";
		}

	}

	elseif($action=="addnew")
	{
		$qty=$_POST['qty'];
		$unit=$_POST['unit'];
		$seq=$_POST['seq'];
		$qty_high=$_POST['qty_high'];
		$preparation=$_POST['preparation'];
		$homepage=$_POST['homepage'];
		$featured=$_POST['featured'];
		$photo=$_FILES['photo']['tmp_name'];
		$contributor=$_POST['contributor'];
		$servings=$_POST['servings'];
		$wwpoints=$_POST['wwpoints'];
		
		if($wwpoints)
		{
			$wwrated="1";
		}
		
		if($featured=="on")
		{
			$clearf=mysql_query("UPDATE recipes_new
				set featured=''
				where featured='1'");
				
				$featured="1";
		}

		//add new recipe
			if ($homepageyes == on)
			{
			  $homepage="x";
			}
			else
			{
			  $homepage="";
			}
			if($photo)
			{
			  include("photohandlerinc.php");
			}
			if($wwpoints)
			{
				$wwrated="1";
			}
			if (mysql_query("INSERT into recipes_new
					SET
					name='".addslashes($recipename)."',
					contributor = '$contributor',
					description = '".addslashes($description)."',
					preparation = '".addslashes($recpreparation)."',
					homepage = '$homepage',
					date_added=NOW(),
					photo='$photoupload',
					servings='$servings',
					wwpoints='$wwpoints',
					wwrated='$wwrated'"))


			{
				// put info in the crossref tables
				$r=mysql_insert_id($link);
				
				if($result=mysql_query("SELECT
					site_name, dcb, ID from recipes_cobrand_sites order by site_name"))
				{
					while($row=mysql_fetch_array($result))
					{
						if($$row['dcb'] == "on")
										// insert into xref
						{
							mysql_query("INSERT into recipes_in_cobrands SET
							recipeID='$r',
							cobrandID='".$row['ID']."'");
						}
					}
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}

				// recipes_in_ingredient  recipeID ingredientID

				if($result=mysql_query("SELECT
					name, abbr, ID from recipes_ingredient order by name"))
				{
					while($row=mysql_fetch_array($result))
					{
						if($$row['abbr'] == "on")
							// insert into xref
						{
							mysql_query("INSERT into recipes_in_ingredient SET
							recipeID='$r',
							ingredientID='".$row['ID']."'");
						}
					}
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}

				// recipes_in_lifestyles  recipeID categoryID  recipes_lifestyles ID name abbr
				if($result2=mysql_query("SELECT
					name, abbr, ID from recipes_lifestyle order by name"))
				{
					while($row=mysql_fetch_array($result2))
					{
						if($$row['abbr'] == "on")
							// insert into xref
						{
							mysql_query("INSERT into recipes_in_lifestyles SET
							recipeID='$r',
							categoryID='".$row['ID']."'");
						}
					}
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}
				// recipes_in_dishtypes  recipeID dishtypeID  recipes_dishtype ID name abbr

				if($result3=mysql_query("SELECT
					name, abbr, ID from recipes_dishtype order by name"))
				{
					while($row=mysql_fetch_array($result3))
					{
						if($$row['abbr'] == "on")
							// insert into xref
						{
							mysql_query("INSERT into recipes_in_dishtype SET
							recipeID='$r',
							dishtypeID='".$row['ID']."'");
						}
					}
				}
				else
				{
					$goof=mysql_error();
					$error="<b>Error:</b>  $goof\n";
				}

				// recipes_ingredients_in_recipes ingID recipeID seq qty unit preparation  recipes_single_ingredients ID ingredient_name description abbrev category





				if($ingredient1)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient1',
					seq='$seq1',
					unit='$unit1',
					preparation='$preparation1',
					qty='$qty1',
					qty_high='$qty_high1',
					recipeID='$r'");


				}

				if($ingredient2)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient2',
					seq='$seq2',
					unit='$unit2',
					preparation='$preparation2',
					qty='$qty2',
					qty_high='$qty_high2',
					recipeID='$r'");


				}
				if($ingredient3)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient3',
					seq='$seq3',
					unit='$unit3',
					preparation='$preparation3',
					qty='$qty3',
					qty_high='$qty_high3',
					recipeID='$r'");


				}
				if($ingredient4)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient4',
					seq='$seq4',
					unit='$unit4',
					preparation='$preparation4',
					qty='$qty4',
					qty_high='$qty_high4',
					recipeID='$r'");


				}
				if($ingredient5)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient5',
					seq='$seq5',
					unit='$unit5',
					preparation='$preparation5',
					qty='$qty5',
					qty_high='$qty_high5',
					recipeID='$r'");


				}
				if($ingredient6)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient6',
					seq='$seq6',
					unit='$unit6',
					preparation='$preparation6',
					qty='$qty6',
					qty_high='$qty_high6',
					recipeID='$r'");


				}
				if($ingredient7)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient7',
					seq='$seq7',
					unit='$unit7',
					preparation='$preparation7',
					qty='$qty7',
					qty_high='$qty_high7',
					recipeID='$r'");


				}
				if($ingredient8)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient8',
					seq='$seq8',
					unit='$unit8',
					preparation='$preparation8',
					qty='$qty8',
					qty_high='$qty_high8',
					recipeID='$r'");


				}
				if($ingredient9)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient9',
					seq='$seq9',
					unit='$unit9',
					preparation='$preparation9',
					qty='$qty9',
					qty_high='$qty_high9',
					recipeID='$r'");


				}
				if($ingredient10)
				{
					mysql_query("INSERT
					into recipes_ingredients_in_recipes SET
					ingID='$ingredient10',
					seq='$seq10',
					unit='$unit10',
					preparation='$preparation10',
					qty='$qty10',
					qty_high='$qty_high10',
					recipeID='$r'");


				}


				header("Location:http://www.spacerock.com/admintools/recipeadminnew.php");

			}
			else
			{
			  $goof=mysql_error();
			  $error="<b>Error:</b>  $goof\n";
			}



	}


	elseif ($action == 'edit')
	{
		$formaction="makeedits";
		$more = "Add More";
		$editlink = "<p><a href=\"#editings\">Edit Existing</a></p>\n";

	  // edit a recipe - get the data
			if ($homepage)
			{
			  $homepage="x";
			}

			$single=mysql_query(" SELECT * from recipes_new WHERE ID='$r'");

			while ($row = mysql_fetch_array($single))
			{
				$ID=$row[0];
				$recipename=$row[1];
				$description=stripslashes($row[2]);
				$contributor=$row[3];
				$ingredients=stripslashes($row[4]);
				$recpreparation=stripslashes($row[5]);
				$homepage=$row[6];
				$date_added=$row[7];
				$photo=$row[8];
				$servings=$row[9];
				$featured=$row[10];
				$wwpoints=$row[11];
				
				if($featured=="1")
				{
					$rchecked=" checked";
				}

				$heading="Edit $name";

				if($photo)
				{
					$existingphoto.="<p><b>Existing Photo:</b>\n";
					$existingphoto .= "<br /><img src=\"/images/uploads/$photo\" width=\"350\" />\n";
					$existingphoto .= "<input type=\"hidden\" name=\"oldphoto\" value=\"$photo\" />\n";
					$existingphoto .= "<br />You can keep the one above or upload a new one here;\n";
				}
				else
				{
					$existingphoto .= "<p><b>Upload a Photo:</b>  (Optional) \n";
				}


			  if ($homepage=="1")
			  {
				$hpchecked=" checked";
			  }
			  else
			  {
				$hpchecked="";
			  }

			}
		// let's check our cross ref tables

		// recipes_dishtype

		if($result=mysql_query("SELECT
				recipes_dishtype.abbr,
				recipes_dishtype.name,
				recipes_in_dishtypes.recipeID
			FROM
				recipes_dishtype
				LEFT JOIN recipes_in_dishtypes ON
				recipes_dishtype.ID = recipes_in_dishtypes.dishtypeID AND
				recipes_in_dishtypes.recipeID = '$r'
				ORDER BY
				recipes_dishtype.name"))
				{


					while($row=mysql_fetch_array($result))
					{
						$dtabbr=$row[0];
						$dtname=$row[1];
						$dtrecipeID=$row[2];

						if($dtrecipeID == "$r")
						{
							$checked=" checked";
						}
						else
						{
							$checked="";
						}



						$display_recipe_dishtype .= "<p><input type=\"checkbox\" name=\"$dtabbr\"$checked>$dtname</p>\n";
					}
				}
				else
				{
				  $goof=mysql_error();
				  $error="<b>Error:</b>  $goof\n";
				}

		// recipes_ingredient
		if($result=mysql_query("SELECT
				recipes_ingredient.abbr,
				recipes_ingredient.name,
				recipes_in_ingredient.recipeID
			FROM
				recipes_ingredient
				LEFT JOIN recipes_in_ingredient ON
				recipes_ingredient.ID = recipes_in_ingredient.ingredientID AND
				recipes_in_ingredient.recipeID = '$r'
				ORDER BY
				recipes_ingredient.name"))
				{


					while($row=mysql_fetch_array($result))
					{
						$inabbr=$row[0];
						$inname=$row[1];
						$inrecipeID=$row[2];

						if($inrecipeID == "$r")
						{
							$checked=" checked";
						}
						else
						{
							$checked="";
						}



						$display_recipe_ingredient .= "<p><input type=\"checkbox\" name=\"$inabbr\"$checked>$inname</p>\n";
					}
				}
				else
				{
				  $goof=mysql_error();
				  $error="<b>Error:</b>  $goof\n";
				}
		// recipes lifestyles
				if($result=mysql_query("SELECT
				recipes_lifestyle.abbr,
				recipes_lifestyle.name,
				recipes_in_lifestyles.recipeID
			FROM
				recipes_lifestyle
				LEFT JOIN recipes_in_lifestyles ON
				recipes_lifestyle.ID = recipes_in_lifestyles.categoryID AND
				recipes_in_lifestyles.recipeID = '$r'
				ORDER BY
				recipes_lifestyle.name"))
				{


					while($row=mysql_fetch_array($result))
					{
						$lsabbr=$row[0];
						$lsname=$row[1];
						$lsrecipeID=$row[2];

						if($lsrecipeID == "$r")
						{
							$checked=" checked";
						}
						else
						{
							$checked="";
						}



						$display_recipe_lifestyle .= "<p><input type=\"checkbox\" name=\"$lsabbr\"$checked>$lsname</p>\n";
					}
				}
				else
				{
				  $goof=mysql_error();
				  $error="<b>Error:</b>  $goof\n";
				}
				
		// recipes cobrands
		
		if($result7=mysql_query("SELECT
				recipes_cobrand_sites.dcb,
				recipes_cobrand_sites.site_name,
				recipes_in_cobrands.recipeID
			FROM
				recipes_cobrand_sites
				LEFT JOIN recipes_in_cobrands ON
				recipes_cobrand_sites.ID = recipes_in_cobrands.cobrandID AND
				recipes_in_cobrands.recipeID = '$r'
				ORDER BY
				recipes_cobrand_sites.site_name"))
				{
					while($row=mysql_fetch_array($result7))
					{
						$dcb=$row[0];
						$dcb_site_name=stripslashes($row[1]);
						$dcbrecipeID=$row[2];
						
						if($dcbrecipeID=="$r")
						{
							$dcbchecked=" checked";
						}
						
						$dcbdisplay .= "<input type=\"checkbox\" name=\"$dcb\"$dcbchecked \>$dcb_site_name  ";
					}
				}
				else
				{
				  $goof=mysql_error();
				  $error="<b>Error:</b>  $goof\n";
				}
				
		// ingredients table

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
				$howmanyings=mysql_num_rows($ingpull);

				if($howmanyings>0)
				{

					while($row=mysql_fetch_array($ingpull))
					{
						$ingID=$row[0];
						$seq=$row[1];
						$qty=$row[2];
						$unit=$row[3];
						$preparation=stripslashes($row[4]);
						$xrefID=$row[5];
						$qty_high=$row[6];

						// get the name
						if($resultingname=mysql_query("SELECT
							ingredient_name
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


							$recings.="<form action=\"$PHP_SELF?ID=$xrefID&action=editing&r=$r\" method=\"post\"><tr><td><input type=\"text\" name=\"seq\" value=\"$seq\" size=\"3\"></td><td>$ingname</td><td><input type=\"text\" name=\"qty\" value=\"$qty\" size=\"10\" /></td><td><input type=\"text\" name=\"qty_high\" value=\"$qty_high\" size=\"10\" /></td><td><input type=\"text\" name=\"unit\" value=\"$unit\" size=\"10\" /></td><td><input type=\"text\" name=\"preparation\" value=\"$preparation\" size=\"20\" /></td><td><input type=\"checkbox\" name=\"delete\"> Delete</a></td><td><input type=\"submit\" value=\"change\" /></td</tr></form>\n";
					}

				}
				else
				{
					$recings .= "<tr><td style=\"text-align:center; font-weight:italic;\">No Ingredents Listed</td></tr>\n";
				}
			}
			else
			{
			  $goof=mysql_error();
			  $error="<b>Error:</b>  $goof\n";
			}
	}

	else
	{
		$formaction="addnew";
		$heading = " Add New Recipe";

		// get the categoriztion checkboxes

		if($result1=mysql_query("SELECT
			name,
			abbr
			from recipes_dishtype
			order by name"))
			{
				while($row=mysql_fetch_array($result1))
				{
					$dtname=$row[0];
					$dtabbr=$row[1];

					$display_recipe_dishtype .= "<p><input type=\"checkbox\" name=\"$dtabbr\" />$dtname</p>\n";
				}
			}
			else
			{
			  $goof=mysql_error();
			  $error="<b>Error:</b>  $goof\n";
			}
			// recipe_ingredient
		if($result1=mysql_query("SELECT
			name,
			abbr
			from recipes_ingredient
			order by name"))
			{
				while($row=mysql_fetch_array($result1))
				{
					$inname=$row[0];
					$inabbr=$row[1];

					$display_recipe_ingredient .= "<p><input type=\"checkbox\" name=\"$inabbr\" />$inname</p>\n";
				}
			}
			else
			{
			  $goof=mysql_error();
			  $error="<b>Error:</b>  $goof\n";
			}



		// lifestyle list

		if($result1=mysql_query("SELECT
			name,
			abbr
			from recipes_lifestyle
			order by name"))
		{
			while($row=mysql_fetch_array($result1))
			{
				$lsname=$row[0];
				$lsabbr=$row[1];

				$display_recipe_lifestyle .= "<p><input type=\"checkbox\" name=\"$lsabbr\" />$lsname</p>\n";
			}
		}
		else
		{
			$goof=mysql_error();
			$error="<b>Error:</b>  $goof\n";
		}
		// dcbs
		if($result3=mysql_query("SELECT
			ID,
			site_name,
			dcb
			from recipes_cobrand_sites
			order by site_name"))
			{
				while($row=mysql_fetch_array($result3))
				{
					$dcbID=$row[0];
					$dcbname=stripslashes($row[1]);
					$dcb=$row[2];
					
					$dcbdisplay .= "<input type=\"checkbox\" name=\"$dcb\">$dcbname  ";
				}
			}
			else
			{
			  $goof=mysql_error();
			  $error="<b>Error:</b>  $goof\n";
			}
			

	}
	// category pulldowns for all pages - edit or add
			// recipe single ingredient category pulldown
		if($result2=mysql_query("SELECT
			ID,
			name
			from recipes_single_ingredients_categories
			order by name"))
			{
				while($row=mysql_fetch_array($result2))
				{
					$catID=$row[0];
					$catname=$row[1];

					$catselects .= "<option value=\"$catID\">$catname</option>\n";

				}
			}
			else
			{
			  $goof=mysql_error();
			  $error="<b>Error:</b>  $goof\n";
			}
			
	


}
else
{
    include("loginerror.php");
}
$titletag="$heading";
include("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
print "<article id=\"content\">\n";
if ($error)
{
	print "<p style=\"color:red;\">$error</p>\n";
}
else
{

print <<<ENDTAG
<p><a href="#" onclick="lightboxShow('lightbox');">Single Ingredients</a></p>

<p><a href="index.php">Admin Home</A> > <A HREF="recipeadminnew.php">Manage recipes</A> > $heading

$heading

<div style="width:900px; margin-left:auto;margin-right:auto; "><!--big container-->
	<p><form action="$PHP_SELF?action=$formaction&r=$r" method="post" enctype="multipart/form-data">
	<p>weight Waters Point Value:  <input type="text" size="3" name="wwpoints" value="$wwpoints" /></p>
	<p><input type="checkbox" name="homepage"$hpchecked />  Feature on Home Page  <input type="checkbox" name="featured"$rchecked />Feature on main Recipe Page</p>
	<p><b>Recipe Name:</b>  <input type="text" name="recipename" value="$recipename" size="40" />&nbsp;&nbsp;
	<b>Contributor:</b>  <input type="text" name="contributor" value="$contributor" size="20" />  <b>How many servings:</b><input type="text" name="servings" value="$servings" size="3" /></p>
	<p><b>Share with these other sites:</b>  $dcbdisplay</p>
	
		<div style="width:300px; float:left;">
			<p><b>Dish Type</b></p>

			$display_recipe_dishtype
		</div>
		<div style="width:300px; float:left;">
			<p><b>Main Ingredient</b></p>
			$display_recipe_ingredient
		</div>
		<div style="width:300px; float:left;">
			<p><b>Lifestyle</b></p>
			$display_recipe_lifestyle
		</div>
		<div style="clear:both;"></div>





	<p><table width="800" border="1">

	<tr>
	<td>
		<b>Photo:</b>
	</td>
	<td>
		$existingphoto
		<br /><input type="file" name="photo" size="20" />
	</td>
	</tr>
	<tr valign="top">
	<td colspan="2">
	  <b>Description:</b>
	  <p>
ENDTAG;


	$oFCKeditor = new FCKeditor('description') ;
	$oFCKeditor->BasePath = '/admintools/';

	//$oFCKeditor->Value = 'oFCKeditor';

	$oFCKeditor->Value = $description;
	$oFCKeditor->Width  = '100%' ;
	$oFCKeditor->Height = '200' ;
	$oFCKeditor->Create() ;

print <<<ENDTAG
	</p>
	</td>
	</tr>
ENDTAG;

print <<<ENDTAG
	<tr valign="top">
	<td colspan="2">
		<table>
		<tr>
		  <b>$more Ingredients:</b>$editlink

			<table>
ENDTAG;
$ingcount=1;
	while($ingcount<11)
	{

	print "<tr valign=\"top\">
				<td>
					<p>Ingredient Type:
					<br /><select name=\"ingcat\" id=\"ingcat$ingcount\">
					<option value=\"\">Please select</option>
					$catselects
					</select>
					<br>Ingredient:
					<br /><select name=\"ingredient$ingcount\" id=\"ingredient$ingcount\" style=\"display:none;\"></select><input type=\"hidden\" name=\"seq$ingcount\" value=\"$ingcount\" />
				</td>
				<td>
					<p>Qty:<br />
					<input type=\"text\" size=\"3\" name=\"qty$ingcount\" /></p>
				</td>
				<td>
					<p>Qty (high end):<br />
					<input type=\"text\" size=\"3\" name=\"qty_high$ingcount\" /></p>
				</td>
				<td>
					<p>Unit:<br /><input type=\"text\" size=\"10\" name=\"unit$ingcount\" /></p>
				</td>
				<td>
					<p>Preparation:<br /><input type=\"text\" name=\"preparation$ingcount\" size=\"40\" />
					<br />i.e. chopped, minced, cubed, etc.</p>
				</td>
				</tr>";
		$ingcount=$ingcount+1;
	}
print "</table></td></tr>\n";

print <<<ENDTAG
	<tr valign="top">
	<td colspan="2">
	  <b>Preparation:</b>
	<p><textarea name="recipepreparatin"></textarea>
	</p>
	</td>
	</tr>


	<tr valign="top">
	<td colspan="2" align=center>
	  <input type="submit" value=" $heading" />
	</td>
	</tr>

	</table>
	</form>
	<p><a name="editings"><b>Existing Ingredients</b></a></p>
	<table style="border:solid thin gray;width:800px;">
	<tr style="text-align:center; font-weight:bold;">
	<td>
		Sequence
	</td>
	<td>
		Ingredient
	</td>
	<td>
		Qty
	</td>
	<td>
		Qty (high)
	</td>
	<td>
		Unit
	</td>
	<td>
		Prep
	</td>
	<td colspan="2">
		Manage
	</td>
	</tr>
	$recings
	</table>

	</div><!--end of big container-->
	
	      <div id="lightbox">
        <div id="innercontent">
          <a href="javascript:void(0);" onclick="lightboxHide('lightbox');">Close me</a>
		  
		  <iframe src="singleingredients.php" style="width:500px; height:800px;"></iframe>
			
			
          <div style="height:500px; background:#fff;" id="lbcontentdiv"></div>
        </div>
      </div>
     </article>
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");


?>