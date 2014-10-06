<?php
include ("../includes/dbconnect.php");
$name=$_POST['name'];
$d=$_POST['d'];

if($result=mysql_query("UPDATE
                recipes_dishtype
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



?>