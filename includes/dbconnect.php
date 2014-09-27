<?php

$host = $_SERVER['HTTP_HOST'];
	
	
	
	$dbhost="spacerockdb.db.10809344.hostedresource.com";
	
	$user="spacerockdb";
	$pass="C@tlov3r";

// make db connection
	$link = mysql_connect($dbhost, $user, $pass);   
	mysql_select_db(spacerockdb) or die("Could not select database spacerockdb mysql_connect($dbhost, $user, $pass); $host");
	

?>