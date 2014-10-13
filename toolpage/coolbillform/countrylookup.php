<?php
include ("includes/dbconnect.php");
$rows = array();

$country=$_GET['_value'];

if($result=mysql_query("SELECT
	Region,
	Code
	from Regions
	where CountryID='$country' order by Region"))
	{
	while($row = mysql_fetch_array($result))
	{   
		$Region=$row[0];
		$Code=$row[1];
		
		$rows[] = array($Code=> $Code);
		
	}

echo json_encode($rows);


	}
	else
	{
	  $goof=mysql_error();
	  $error="<b>Error:</b>  $goof\n";
	}
	
	

?>