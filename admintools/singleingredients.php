<?php
session_start();
include("includes/declarations.php");
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{


  $action=$_GET['action'];
  $r=$_GET['r'];
  $c=$_GET['c'];
  $d=$_GET['d'];
  include ("../includes/dbconnect.php");
  if($mysql_link)
	{

	if($action=="deletesingleingredient")
        {
            if($result=mysql_query("DELETE
                from recipes_single_ingredients
                where ID='$ing'"))
                {

                    header("Location: http://www.spacerock.com/admintools/singleingredients.php");
                }

               else
               {
               	 $goof=mysql_error();
               	 $error="<b>Error:</b>  $goof\n";
               }
        }

 // 	single ingredients categories for lightbox
		if($result3=mysql_query(" SELECT name, ID from recipes_single_ingredients_categories ORDER by name"))
        {
            $ccount=mysql_num_rows($result3);
            $division=$ccount/2;
            $climit=round($division);

            $ccount=1;
            $existingsicats .= "<div style=\"width:200px; float:left;padding:5px;\">\n";
            $existingsicats .= "<table>\n";

            while ($row = mysql_fetch_array($result3))
            {
                $catname=$row[0];
                $catid=$row[1];




				$existingsicats .= "<tr><td><img src=\"images/b_edit.png\" title=\"edit\" border=\"0\" class=\"pencil\" style=\"cursor:pointer; float:left;\" id=\"cat$catid\" /></a><a href=\"$PHP_SELF?action=deletesicat&cat=$catid\"><img src=\"images/b_drop.png\" title=\"delete\" border=\"0\" style=\"float:left;\"></a><span class=\"foo\">$catname</span><span class=\"form_container\" style=\"display:none;\"><form><input type='text' name=\"inputname\" class=\"inputname\" value=\"$catname\" size=\"15\" />\n";

				$existingsicats .= "<input type='hidden' name='inputid' value='$catid' class=\"inputid\" /><input type='submit' value='Change' class='formbtn' ><input type=\"hidden\" name=\"dbtable\" value=\"recipes_single_ingredients_categories\" class=\"dbtable\" /> </form></span></td></tr>\n";

				$singlecats .= "<option value=\"$catid\">$catname</option>\n";

                if($ccount=="$climit")
				{
				  $existingsicats .= "</table></div><div style=\"width:200px; float:left; padding:5px;\">";
				}
				else
				{
					$ccount=$ccount+1;
				}

            }
            $existingsicats .= "</table></div>";
			// existing cats end
		}
		else
		{
		  $goof=mysql_error();
		  $error="<b>Error:</b>  $goof\n";
		}

		  // single ingredients for lightbox listing
		if($result3=mysql_query(" SELECT ingredient_name, ID,category, displayname from recipes_single_ingredients ORDER by ingredient_name"))
        {
            $ccount=mysql_num_rows($result3);
            $division=$ccount/2;
            $llimit=round($division);

            $lcount=1;
            $existingsingleingredients .= "<div style=\"width:200px; float:left;padding:5px;clear:both;\">\n";
            $existingsingleingredients .= "<table>\n";

            while ($row = mysql_fetch_array($result3))
            {
                $ingredient_name=$row[0];
                $ing=$row[1];
				$category=$row[2];
				$displayname=stripslashes($row[3]);

				if($thename=mysql_query("SELECT
					name
					from recipes_single_ingredients_categories where ID='$category'"))
				{
					while($row=mysql_fetch_array($thename))
					{
						$rsicatname=$row[0];
					}
				}

					else
					{
					  $goof=mysql_error();
					  $error="<b>Error:</b>  $goof\n";
					}

					$singlecatselected = "<option value=\"$category\">$rsicatname</option>\n";


					$existingsingleingredients .= "<tr><td><img src=\"images/b_edit.png\" title=\"edit\" border=\"0\" class=\"pencil\" style=\"cursor:pointer; float:left;\" id=\"ing$ing\" /></a><a href=\"$PHP_SELF?action=deletesingleingredient&ing=$ing\"><img src=\"images/b_drop.png\" title=\"delete\" border=\"0\" style=\"float:left;\"></a><span class=\"foo\">$ingredient_name</span><span class=\"form_container\" style=\"display:none;\"><form><input type='text' name=\"inputname\" class=\"inputname\" value=\"$ingredient_name\" size=\"15\" /><br /><input type='text' name=\"displayname\" class=\"displayname\" value=\"$displayname\" size=\"15\" /><br />Display Name\n";

					$existingsingleingredients .= "<input type='hidden' name='inputid' value='$ing' class=\"inputid\" /><input type='submit' value='Change' class='formbtn' ><input type=\"hidden\" name=\"dbtable\" value=\"recipes_single_ingredients\" class=\"dbtable\" /> </form></span></td></tr>\n";


                    if($lcount=="$llimit")
					{
					  $existingsingleingredients .= "</table></div><div style=\"width:200px; float:left; padding:5px;\"><table>\n";
					  $lcount=0;
					}
					else
					{
						$lcount=$lcount+1;
					}



			   // single ingredients end

			}
			$existingsingleingredients .="</table></div><div style=\"clear:both;\"></div>\n";
		}
		else
		{
			$goof=mysql_error();
			$error="<b>Error:</b>  $goof 242\n";
		}
	}
	else
	{
		$error = "<b>Error:</b.  No db connection.\n";
	}

print <<<ENDTAG
<!doctype html>
<head>
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.spacerock.com/style11.css" />

    <link rel="stylesheet" type="text/css" href="http://www.spacerock.com/nav3.css" />
    <link rel="stylesheet" type="text/css" href="http://www.spacerock.com/lightbox.css" />

	<script language="JavaScript" type="text/javascript" src="/js/jquery.chainedSelects.js"></script>

    <link rel="stylesheet" href="http://www.spacerock.com/css/admintools.css" />
	<script src="/lightbox.js"></script>
		<script type="text/javascript">
			function showStuff(id) {
				document.getElementById(id).style.display = 'block';
			}
		</script>

		<script type="text/javascript">
			function hideStuff(id) {
				document.getElementById(id).style.display = 'none';
			}
		</script>
		<script src="$domain/js/spacerock2011utils.js"></script>
		<style>
			#holder {
				background:#fff;
			}
		</style>
</head>
<body background="#ffffff">
ENDTAG;
if($error)
{
	print "$error";
}
else
{
print <<<ENDTAG
<div id="holder">
<h2>Manage Single Ingredients</h2>
<p><a href="#categories">Categories</a></p>

			$existingsingleingredients
			<div id="list"></div>
			<div style="clear:both;"></div>
			<p><b>Add Single Ingredient</b></p>
			<form>
			  <div style="float:left; margin-right:3px;">

			  <!--/div-->
			  <div style="float:left; margin-right:3px;">
				<input type="text" name="ingredient_name" size="20" id="ingfield" /><br />Name
			  </div>
			  <div style="float:left; margin-right:3px;">
				<input type="text" name="displayname" size="20" id="dnfield" /><br />Display Name
			  </div>
			  <div style="float:left; margin-right:3px;">
				<select name="category" id="catfield">$singlecats</select><br />Category
			  </div>
			  <div style="float:left;">
				<input type="submit" value="Add" id="submiting" />
			  </div>
			  </form>
			</div>
			<div style="clear:both;"></div>
			<a name="categories"></a>
			<h2>Single Ingredient Categories</h2>
			$existingsicats
			<div id="catlist"></div>
			<div style="clear:both;"></div>
			<p><b>Add Single Ingredient Category</b></p>
			<form>
			  <div style="float:left; margin-right:3px;">

			  <!--/div-->
			  <div style="float:left; margin-right:3px;">
				<input type="text" name="catname" size="20" id="newcatfield" />
			  </div>
			  <div style="float:left;">
				<input type="submit" value="Add" id="submitcat" />
			  </div>
			  </form>
			</div>
	</div><!--holder-->
</body></html>
ENDTAG;
}
}
?>