<?php
include("includes/dbconnect.php");
$rows=array();

$CountryID=$_GET['CountryID'];

if($link)
{
	if($result=mysql_query("SELECT
		FIPS104
		from Countries
		where CountryID='$CountryID'"))
		{
		  $c.= "[";
			while($row=mysql_fetch_array($result))
			{
				$countryname=$row[0];
			
				//$rows[] = array($CountryID=> $countryname);
				// $rows[] = array(countryname=>$countryname);
				$c .= "{\"countryname\":\"$countryname\"}";
			}
			$c .= "]";
			
			
		}
		//echo json_encode($rows);
		echo $c;
}
else
{
	$error="<b>Error:</b>  No database connection.";
}
?>