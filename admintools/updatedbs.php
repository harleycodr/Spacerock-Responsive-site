<?php
// this utilitarian script is used by the inline editing json/ajax tables to update.
include("includes/declarations.php");

include ("../includes/dbconnect.php");

$dbtable=$_POST['dbtable'];

$name=$_POST['name'];
$d=$_POST['d'];
$action=$_POST['action'];
$catname=$_POST['catname'];
$ingredient_name=$_POST['ingredient_name'];
$displayname=$_POST['displayname'];

// add new single ingredients category

if($action=="addnew")
{
	if($result=mysql_query("INSERT
		into
		recipes_single_ingredients_categories
		set
		name='$catname'"))
		{
			echo "done";
		}
		else
		{
			echo "bad";
		}


}
// insert new ingredients into recipes_single_ingredients

elseif($action=="addnewing")
{
	if(!$displayname)
	{
		$displayname="$ingredient_name";
	}

		if($result=mysql_query("INSERT into
			recipes_single_ingredients
			set
			ingredient_name='".addslashes($ingredient_name)."', category='$category', displayname='".addslashes($displayname)."'"))
		{
			echo "yes";
		}
		else
		{
			echo "mysql_error()";
		}
}
elseif($action=="edit")
	{
		if(($dbtable=="recipes_dishtype") || ($dbtable=="recipes_ingredient") || ($dbtable=="recipes_lifestyles") || ($dbtable=="recipes_single_ingredients_categories"))
		{

			if($result=mysql_query("UPDATE
						$dbtable
						set
						name='$name'
						where ID='$d'"))
						{
						echo "yes";
						}
						else
						{
						echo 'mysql_error()';
						}


		}
		elseif($dbtable=="recipes_single_ingredients")
		{

				if($result=mysql_query("UPDATE
				recipes_single_ingredients
				set
				ingredient_name='".addslashes($name)."', displayname='".addslashes($displayname)."' where ID='$d' "))
				{
					echo "UPDATE
				recipes_single_ingredients
				set
				ingredient_name='$name', category='$category', displayname='$displayname' where ID='$d' ";
				}
				else
				{
					echo "mysql_error()";
				}
		}



	}
?>