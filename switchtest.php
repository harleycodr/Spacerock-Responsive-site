<?php

$i=$_GET['test'];

switch($i)
{
	case "g":
	echo "Show a gallery";
	break;
	case "":
	echo "Show all albums";
	break;
	case "p":
	echo "Show a single photo";
	break;
	default:
	echo "Unknown selector";
}
?>