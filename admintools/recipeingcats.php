<?php
include ("../includes/dbconnect.php");
$rows = array();

$category=$_GET['_value'];

if($result=mysql_query("SELECT
	ingredient_name,
	ID
	from recipes_single_ingredients
	where category='$category' order by ingredient_name"))
	{
	while($row = mysql_fetch_array($result))
	{
		$ingredient_name=$row[0];
		$ingID=$row[1];

		$rows[] = array($ingID=> $ingredient_name);
	}

echo json_encode($rows);


	}
	else
	{
	  $goof=mysql_error();
	  $error="<b>Error:</b>  $goof\n";
	}



?>