<?php
include ("../includes/dbconnect.php");
$name=$_POST['name'];
$d=$_POST['d'];

$result=mysql_query("UPDATE
                dishtype
                set
                name='$name'
                where ID='$d'");





?>