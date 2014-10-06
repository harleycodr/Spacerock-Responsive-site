<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_REQUEST['action'];
$r=$_REQUEST['r'];


	
	
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    include ("../includes/dbconnect.php");

    if ($link)
    {
		
		include("includes/utils.php");
    	if ($action=="edit")
    	{
    		$formaction="makeedits";
    		$heading = "Make Edits";

			
    		if ($single=mysql_query(" SELECT
    			name,
				rating,
				ingredients,
				prep,
				ppv,
				servings,
				serving_size,
				type,
				marinate,
				prep_time,
				cook_time,
				source,
				source_url
				from skinny_recipes
				where id='$r'"))

    			{
    				while ($row=mysql_fetch_array($single))
    				{
    					$name=stripslashes($row[0]);
						$rating=$row[1];
						$ingredients=stripslashes($row[2]);
						$prep=stripslashes($row[3]);
						$ppv=$row[4];
						$servings=$row[5];
						$serving_size=$row[6];
						$type=$row[7];
						$marinate=$row[8];
						$prep_time=$row[9];
						$cook_time=$row[10];
						$source=$row[11];
						$source_url=$row[12];
						
						if($marinate=="1")
						{
							$marinate="Yes";
						$marinate="<option value=\"1\">Yes</option>\n";
						}
						else
						{
							$marinate="No";
						$marinate="<option value=\"\">No</option>\n";
						}
						
						
						$typename=getTypeName($type);
						
						$typeselected="<option value=\"$type\">$typename</option>\n";
						
						if($rating=="0")
						{
							$ratingselects="<option value=\"$rating\">Haven't Tried</option>\n";
						}
    					elseif($rating=="1")
						{
							$ratingselects="<option value=\"$rating\">&#9733;</option>\n";
						}
						elseif($rating=="2")
						{
							$ratingselects="<option value=\"$rating\">&#9733; &#9733;</option>\n";
						}
						elseif($rating=="3")
						{
							$ratingselects="<option value=\"$rating\">&#9733; &#9733; &#9733;</option>\n";
						}
						elseif($rating=="4")
						{
							$ratingselects="<option value=\"$rating\">&#9733; &#9733; &#9733; &#9733;</option>\n";
						}
						elseif($rating=="5")
						{
							$ratingselects="<option value=\"$rating\">&#9733; &#9733; &#9733; &#9733; &#9733;</option>\n";
						}
    				}
    			}
    			else
    			{
    				$error .= "<B>Error:</B>  Database query failed for this recipe.\n";
    			}

    	}
    	elseif ($action=="makeedits")
    	{
			$name=$_REQUEST['name'];
			$rating=$_REQUEST['rating'];
			$ingredients=$_REQUEST['ingredients'];
			$prep=$_REQUEST['prep'];
			$ppv=$_REQUEST['ppv'];
			$servings=$_REQUEST['servings'];
			$serving_size=$_REQUEST['serving_size'];
			$type=$_REQUEST['type'];
			$marinate=$_REQUEST['marinate'];
			$prep_time=$_REQUEST['prep_time'];
			$cook_time=$_REQUEST['cook_time'];
			$source=$_REQUEST['source'];
			$source_url=$_REQUEST['source_url'];
			
			if($marinate=="on")
			{
				$marinate="1";
			}
      
             if ($result=mysql_query("UPDATE skinny_recipes
				SET
				name='".addslashes($name)."',
				rating='$rating',
				ingredients='".addslashes($ingredients)."',
				prep='".addslashes($prep)."',
				ppv='$ppv',
				servings='$servings',
				serving_size='$serving_size',
				marinate='$marinate',
				prep_time='$prep_time',
				cook_time='$cook_time',
				type='$type',
				source='$source',
				source_url='$source_url'
				where id='$r'"))
    			{
    				header("Location: $domain/admintools/manageskinnyrecipes.php");
    			}
    			else
    			{
					$goof=mysql_error();
    					$error .= "<b>Error:</b>  Database update failed.  $goof\n";
    			}
        }

        elseif ($action=="addnew")
        {
			
			$name=$_REQUEST['name'];
			$rating=$_REQUEST['rating'];
			$ingredients=$_REQUEST['ingredients'];
			$prep=$_REQUEST['prep'];
			$ppv=$_REQUEST['ppv'];
			$servings=$_REQUEST['servings'];
			$serving_size=$_REQUEST['serving_size'];
			$type=$_REQUEST['type'];
			$marinate=$_REQUEST['marinate'];
			$prep_time=$_REQUEST['prep_time'];
			$cook_time=$_REQUEST['cook_time'];
			$source=$_REQUEST['source'];
			$source_url=$_REQUEST['source_url'];
			
			if($marinate=="on")
			{
				$marinate="1";
			}
      
             if ($result=mysql_query("INSERT INTO skinny_recipes
				SET
				name='".addslashes($name)."',
				rating='$rating',
				ingredients='".addslashes($ingredients)."',
				prep='".addslashes($prep)."',
				ppv='$ppv',
				servings='$servings',
				serving_size='$serving_size',
				marinate='$marinate',
				prep_time='$prep_time',
				cook_time='$cook_time',
				type='$type',
				source='$source',
				source_url='$source_url'"))
    			{
    				header("Location: $domain/admintools/manageskinnyrecipes.php");
    			}
    			else
    			{
					$goof=mysql_error();
    					$error .= "<b>Error:</b>  Database update failed.  $goof\n";
    			}

      }
    }
    else
    {
    	$error .= "<b>Error:</b>  Database connection failed.\n";
    }


    if (!$action)
    {
      $submitvalue=" Add Skinny Recipe";
      $heading = " Add Skinny Recipe";
      $formaction="addnew";
	  
	  $selectedrating .= "<option value=\"\">Haven't Tried</option>\n";
	  $selectedrating.="<option value=\"\">Please Rate</option>\n";

     
    }
	if($result3=mysql_query("SELECT
		id,
		type
		from skinny_recipe_types
		order by type"))
		{
			while($row=mysql_fetch_array($result3))
			{
				$t=$row[0];
				$type=$row[1];
				
				$types .= "<option value=\"$t\">$type</option>\n";
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
    include("loginerror.php");
}
print <<<ENDTAG
<article id="content">

ENDTAG;
include("../headerinclude.php");
if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{
print <<<ENDTAG
<!-- This <div> holds alert messages to be display in the sample page. -->
	<div id="alerts">
		<noscript>
			<p>
				<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
				support, like yours, you should still see the contents (HTML data) and you should
				be able to edit it normally, without a rich editor interface.
			</p>
		</noscript>
	</div>
<a href="index.php">Admin home</a> > <a href="manageskinnyrecipes.php">Manage Skinny Recipes</a> > $heading
$heading

<p><FORM ACTION="addsrecipe.php?action=$formaction&r=$r" METHOD="POST">
<div style="width:200px; float:left;">
	Rating: 
	<select name="rating">
		$ratingselects
		<option value="1">&#9733;</option>
		<option value="2">&#9733; &#9733;</option>
		<option value="3">&#9733; &#9733; &#9733;</option>
		<option value="4">&#9733; &#9733; &#9733; &#9733;</option>
		<option value="5">&#9733; &#9733; &#9733; &#9733; &#9733;</option>
		<option value="">Haven't tried</option>
	</select>
</div>
<div style="width:200px; float:left;">
	Marinate:  <select name="marinate">
		$marinate
		<option value="1">Yes</option>
		<option value="">No</option>
	</select>
</div>
<div style="width:200px; float:left;">
	Prep Time:  <input type="text" name="prep_time" value="$prep_time" size="10" />
</div>
<div style="width:200px; float:left;">
	Cook Time:  <input type="text" name="cook_time" value="$cook_time" size="10" />
</div>
<div style="clear:both;"></div>
<p><TABLE WIDTH=800 BORDER=1>
  <TR VALIGN=TOP>
<TD WIDTH=100>
  <p><B>Name:</B>
  <br /><INPUT TYPE="text" NAME="name" VALUE="$name" SIZE=40>
  <br /><select name="type">
  $typeselected
  $types
  </select></p>

</TD>
<td>
	<p><b>PPV</b>  <input type="text"  name="ppv" value="$ppv" size="5" />
	<br /><b>Serving Size:</b>  <input type="text" name="serving_size" value="$serving_size" size="20" />
	<br /><br>Total Servings:</b>  <input type="text" name="servings" value="$servings" size="20" /></p>
</td>
</TR>

<TR VALIGN=TOP>
<TD colspan="2">
  <B>Ingredients:</B>
<textarea cols="80" id="editor_kama" name="ingredients" rows="10">$ingredients</textarea>
				<script type="text/javascript">
				//<![CDATA[

					CKEDITOR.replace( 'ingredients',
						{
							skin : 'kama'
						});

				//]]>
				</script>

</TD>
</TR>
<TR VALIGN=TOP>
<TD colspan="2">
  <B>Preparation:</B>
	<textarea cols="80" id="editor_office2003" name="prep" rows="10">$prep</textarea>
				<script type="text/javascript">
				//<![CDATA[

					CKEDITOR.replace( 'prep',
						{
							skin : 'office2003'
						});

				//]]>
				</script>
</TD>
</TR>
<TR VALIGN=TOP>
<TD>
  <b>Source:</b>
  <br /><input type="text" name="source" value="$source" size="40" />
</TD>
<td>
	<b>Source URL:</b>
	<br />http://<input type="text" name="source_url" value="$source_url" size="40" />
</td>
</TR>
</TABLE>
<p class="tac"><INPUT TYPE="submit" VALUE=" $heading "></p>
</FORM>
</article>

ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");


?>