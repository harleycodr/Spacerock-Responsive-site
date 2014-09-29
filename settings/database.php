<?php
	$database="searchspacerock";
	$mysql_user = "searchspacerock";
	$mysql_password = "L0v3cats!";
	$mysql_host = "searchspacerock.db.10809344.hostedresource.com";
	$mysql_table_prefix = "";



	$success = mysql_pconnect ($mysql_host, $mysql_user, $mysql_password);
	if (!$success)
		die ("<b>Cannot connect to database, check if username, password and host are correct.</b>");
    $success = mysql_select_db ($database);
	if (!$success) {
		print "<b>Cannot choose database, check if database name is correct.";
		die();
	}
?>

