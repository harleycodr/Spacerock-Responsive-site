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
        //editing tools start

        if ($action == "delete" AND $r)
        {
          mysql_query("DELETE FROM recipes_new WHERE ID = $r");

          header("Location: $domain/admintools/recipeadminnew.php");

        }

        elseif ($action=="adddishtype")
        {
			$name=$_POST['name'];
			
          if($result=mysql_query(" INSERT into recipes_dishtype SET
               name='$name'"))
               {
			     $insid=mysql_insert_id($mysql_link);
				// enter abbr
				   if($result2=mysql_query(" update recipes_dishtype SET
					abbr='dt$insid' where ID='$insid'"))
					{
						header("Location: $domain/admintools/recipeadminnew.php");
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

        }
        elseif($action=="addingredient")
        {
			$name=$_POST['name'];
          if($result=mysql_query(" INSERT into recipes_ingredient SET
               name='$name'"))
               {
				$insid=mysql_insert_id($mysql_link);
				// enter abbr
				   if($result2=mysql_query(" update recipes_ingredient SET
					abbr='in$insid' where ID='$insid'"))
					{
						header("Location: $domain/admintools/recipeadminnew.php");
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

        }

        elseif($action=="addlifestyle")
        {
			$name=$_POST['name'];
          if($result=mysql_query(" INSERT into recipes_lifestyle SET
               name='$name'"))
               {
				$insid=mysql_insert_id($mysql_link);
				// enter abbr
				if($result2=mysql_query(" update recipes_lifestyle SET
					abbr='ls$insid' where ID='$insid'"))
				{
					header("Location: $domain/admintools/recipeadminnew.php");
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

        }
		elseif($action=="add_single_ingredient")
		{
			$incredient_name=$_POST['ingredient_name'];
			if($result=mysql_query("INSERT
				into recipes_single_ingredients
				SET
				ingredient_name='".addslashes($ingredient_name)."'"))
				{
					$insid=mysql_insert_id($mysql_link);

					if($result2=mysql_query("update recipes_single_ingredients set
					abbr='ing$insid' where ID='$insid'"))
					{
						header("Location: $domain/admintools/recipeadminnew.php");
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


		}

        elseif($action=="deletedishtype")
        {
            if($result=mysql_query("DELETE
                from recipes_dishtype
                where ID='$d'"))
                {

                   header("Location: $domain/admintools/recipeadminnew.php");

				}
                else
                {
                  $goof=mysql_error();
                  $error="<b>Error:</b>  $goof\n";

                }
        }
        elseif($action=="deleteingredient")
        {
            if($result=mysql_query("DELETE
                from recipes_ingredient
                where ID='$i'"))
                {

                    header("Location: $domain/admintools/recipeadminnew.php");
                }
                else
                {
                  $goof=mysql_error();
                  $error="<b>Error:</b>  $goof\n";
                }

        }
        elseif($action=="deletelifestyle")
        {
            if($result=mysql_query("DELETE
                from recipes_lifestyle
                where ID='$l'"))
                {

                    header("Location: $domain/admintools/recipeadminnew.php");
                }

               else
               {
               	 $goof=mysql_error();
               	 $error="<b>Error:</b>  $goof\n";
               }
        }


		// deletion of single item categories start

		elseif($action=="deletesicat")
        {
            if($result=mysql_query("DELETE
                from recipes_single_ingredients_categories
                where ID='$catid'"))
                {

                    header("Location: $domain/admintools/recipeadminnew.php");
                }

               else
               {
               	 $goof=mysql_error();
               	 $error="<b>Error:</b>  $goof\n";
               }
        }
		// sicat del end
        //editing tools end

        // lets pull some stuff out of the db to use

        //dishtypes
        if($dishtypes=mysql_query(" SELECT name, ID from recipes_dishtype ORDER by name"))
        {
          while ($row = mysql_fetch_array($dishtypes))
            {
              $dishtypename=$row[0];
              $d=$row[1];

              // this is for the javascript call below after recipes
              $dselectid=$d;
              $dishtypeselects .= "<option value='$dselectid'>$dishtypename</option>";

              $existingdishtypes .= "<tr><td><img src=\"images/b_edit.png\" title=\"edit\" border=\"0\" class=\"pencil\" style=\"cursor:pointer; float:left;\" id=\"$d\" /></a><a href=\"$this_script?action=deletedishtype&d=$d\"><img src=\"images/b_drop.png\" title=\"delete\" border=\"0\" style=\"float:left;\"></a><span class=\"foo\">$dishtypename</span><span class=\"form_container\" style=\"display:none;\"><form><input type='text' name=\"inputname\" class=\"inputname\" value='$dishtypename' size='15' /><input type='hidden' name='inputid' value='$d' class=\"inputid\" /><input type='submit' value='Change' class='formbtn' ><input type=\"hidden\" name=\"dbtable\" value=\"recipes_dishtype\" class=\"dbtable\" /> </form></span></td></tr>\n";
            }
        }
        else
        {
          $goof=mysql_error();
          $error="<b>Error:</b>  $goof";
        }

     //categories

         if($result3=mysql_query(" SELECT name, ID from recipes_ingredient ORDER by name"))
         {
            $ccount=mysql_num_rows($result3);
            $division=$ccount/2;
            $limit=round($division);

            $ccount=1;
            $existingcategories .= "<div style=\"width:170px; float:left;padding:5px;outline solid thin;\">\n";
            $existingcategories .= "<table width=\"150\">\n";

            while ($row = mysql_fetch_array($result3))
              {
                $ingredientname=$row[0];
                $i=$row[1];

                $existingcategories .= "<tr><td><img src=\"images/b_edit.png\" title=\"edit\" border=\"0\" class=\"pencil\" style=\"cursor:pointer; float:left;\" id=\"$i\" /></a><a href=\"$this_script?action=deleteingredient&i=$i\"><img src=\"images/b_drop.png\" title=\"delete\" border=\"0\" style=\"float:left;\"></a><span class=\"foo\">$ingredientname</span><span class=\"form_container\" style=\"display:none;\"><form><input type='text' name=\"inputname\" class=\"inputname\" value='$ingredientname' size='15' /><input type='hidden' name='inputid' value='$i' class=\"inputid\" /><input type='submit' value='Change' class='formbtn' ><input type=\"hidden\" name=\"dbtable\" value=\"recipes_ingredient\" class=\"dbtable\" /> </form></span></td></tr>\n";


                if($ccount=="$limit")
                {
                    $existingcategories .= "</table></div><div style=\"width:170px; float:left;padding:5px;outline solid thin;\"><table width=\"150\">\n";
                    $ccount="1";
                }
                else
                {
                    $ccount=$ccount+1;
                }

             }
            $existingcategories .= "</table></div>";
		}
		else
		{
		  $goof=mysql_error();
		  $error="<b>Error:</b>  $goof\n";
		}

			// lifestyles
        if($result3=mysql_query(" SELECT name, ID from recipes_lifestyle ORDER by name"))
         {
            $ccount=mysql_num_rows($result3);
            $division=$ccount/2;
            $llimit=round($division);

            $lcount=1;
            $existinglifestyles .= "<div style=\"width:200px; float:left;padding:5px;\">\n";
            $existinglifestyles .= "<table>\n";

            while ($row = mysql_fetch_array($result3))
              {
                $lifestylename=$row[0];
                $l=$row[1];




				$existinglifestyles .= "<tr><td><img src=\"images/b_edit.png\" title=\"edit\" border=\"0\" class=\"pencil\" style=\"cursor:pointer; float:left;\" id=\"$l\" /></a><a href=\"$this_script?action=deletelifestyle&l=$l\"><img src=\"images/b_drop.png\" title=\"delete\" border=\"0\" style=\"float:left;\"></a><span class=\"foo\">$lifestylename</span><span class=\"form_container\" style=\"display:none;\"><form><input type='text' name=\"inputname\" class=\"inputname\" value='$lifestylename' size='15' /><input type='hidden' name='inputid' value='$l' class=\"inputid\" /><input type='submit' value='Change' class='formbtn' ><input type=\"hidden\" name=\"dbtable\" value=\"recipes_lifestyles\" class=\"dbtable\" /> </form></span></td></tr>\n";


                if($lcount=="$llimit")
                {
                    $existinglifestyles .= "</table></div><div style=\"width:250px; float:left;padding:5px;\"><table>\n";
                    $lcount="1";
                }
                else
                {
                    $lcount=$lcount+1;
                }

             }
            $existinglifestyles .= "</table></div>";
			// lifestyles end

          }
          else
          {
            $goof=mysql_error();
            $error="<b>Error:</b>  $goof 242\n";
          }


        if($result=mysql_query(" SELECT ID, name, homepage from recipes_new ORDER by name"))
        {
            while ($row = mysql_fetch_array($result))
            {
              $ID=$row[0];
              $recipe=stripslashes($row[1]);
              $homepage=$row[2];


              if($homepage=="1")
              {
                $tagit=" id=\"featured\"";
                $homepage="<img src=\"images/checkmark-sm.png\" />";
              }
              else
              {
                $homepage="&nbsp;";
                $tagit="";
              }

              $display .= "<tr><td align=center$tagit>$homepage</TD><TD><a href=\"/recipes11.php?recipe=$ID\" TARGET=\"_new\">$recipe</a></TD><td><a href=\"add_recipenew.php?r=$ID&action=edit\">Edit</a></TD><TD><a href=\"javascript:CheckDelete('$this_script?action=delete&r=$ID')\">Delete</a></td></tr>\n";
			}
        }
		else
		{
			$goof=mysql_error();
			$error="<b>Error:</b>  $goof 291";
		}

    }
    else
    {
        $error = "<b>Error:</b>  No database connection.\n";
    }
}
else
{
    include("loginerror.php");
}
$titletag="Recipe Admin";

include ("../headerinclude.php");
if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{
print <<<ENDTAG
<p><a href="index.php">Admin Home</a> > Recipe Admin</p>
<script>

    $swapscript

</script>
<script>
    $swapscriptc
</script>
<script>
  $recipedishtypejs
</script>
<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a recipe from the database. Do you want to proceed?"))
                        {
                          location.replace(redirect_url);
                        }
                        else
                        {
                          alert("Deletion cancelled.");
                        }
                    }

                    -->
</SCRIPT>

   <script LANGUAGE="JavaScript">

   <!--



        function SmallWindow1(wintype) {

        SmallWin=window.open(wintype,"SmallWin","toolbar=no,directories=no,status=no,scrollbars=yes,menubar=no,width=400,height=400"); SmallWin.window.focus() }


 -->

   </script>
   <script>
   	function showLbContent(){
   	  var param = location.href.split("?")[1].split("=")[1];
   	  if(param=="1") {
   	    document.getElementById("lbcontentdiv"). = "Categories";
   	  }
   	  else {
   	    document.getElementById("lbcontentdiv".="Not Categories";
   	  }
   	}
   </script>


<p><a href="#" onclick="lightboxShow('lightbox');">Single Ingredients</a>  <a href="menumanager.php">Manage Menus</a></p>
<!--form method="post">
  <input type="hidden" id="show" value="1" />
  <input type="submit" value=" Category " onclick="lightboxShow('llightbox');" />
</form-->
<div style="width:200px;float:left;padding:5px;">

    <h2>Dish Types:</h2>
    <table with="200">
    $existingdishtypes
    </table>


      <form action="$this_script?action=adddishtype" method="post">
      <div style="float:left; margin-right:3px;">
        <b>Add Dish Type:</b>
      <!--/div-->
      <div style="float:left; margin-right:3px;">
        <input type="text" name="name" size="20" />
      </div>
      <div style="float:left;">
        <input type="submit" value="Add" />
      </div>
      </form>
    </div>
</div>
<div style="width:370px;float:left;padding:5px;">


  <h2>Main Ingredient Categories:</h2>

  $existingcategories

<div style="float:left; margin-right:3px;">
      <form action="$this_script?action=addingredient" method="post">
      <b>Add Category:</b>
    <br />
      <input type="text" name="name" size="20" /><input type="submit" value="Add" /></form>
    </div>
    <div style="float:left;">

    </div></div>
  <div style="width:300px;float:left;padding:5px;">
  <h2>Lifestyles:</h2>

  $existinglifestyles


  <div style="clear:both; margin-left:auto; margin-right:auto;">
    <div style="float:left; margin-right:3px;">
      <form action="$this_script?action=addlifestyle" method="post">
      <b>Add Lifestyle:</b>
    </div>
    <div style="float:left; margin-right:3px;">
      <input type="text" name="name" size="20" />
    </div>
    <div style="float:left; width:370px;">
      <input type="submit" value="Add" /></form>
    </div>
  </div>
</div>
<!--/div-->
<div style="clear:both;"></div>
  <p style="text-align:center;"><a href="add_recipenew.php">Add New Recipe</a></p>

<p style="text-align:center;font-weight:bold;">Edit/Delete Recipes</p

<p><table width="800" border="1" align="center">
<TR VALIGN=TOP>
<TD ALIGN=CENTER>
  <B>Featured</B>
</TD>
<TD>
  <B>Recipe</B>
</TD>
<TD COLSPAN=2 ALIGN=CENTER>
  <B>Manage</B>
</TD>
</TR>
$display
</TABLE>
ENDTAG;
if($show=="category")
{
  $lb_content="Category";
}
print <<<ENDTAG
      <div id="lightbox">
        <div id="innercontent">
          <a href="javascript:void(0);" onclick="lightboxHide('lightbox');">Close me</a>

		  <iframe src="singleingredients.php" style="width:500px; height:800px;"></iframe>


          <div style="height:500px; background:#fff;" id="lbcontentdiv"></div>
        </div>
      </div>
ENDTAG;
}
include ("../footerinclude.php");

?>