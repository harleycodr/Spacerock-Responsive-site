<?php

$host = $_SERVER['HTTP_HOST'];

if($host=="www.spacerock.com")
{
	$domain="http://$host";
}
elseif($host=="marianswebsite.com")
{
	$domain="http://$host/SPACEROCK";
}
$adminloggedin=$_SESSION['adminloggedin'];