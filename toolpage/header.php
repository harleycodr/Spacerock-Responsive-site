<?php

/**
 * @author Your Great Website.com
 * @copyright 2011
 */

print <<<ENDTAG
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Mark Carter" />
<title>Marian's Swiss Army Knife</title>
<script src="js/jquery-1.9.1.min.js"></script>
<script src="js/utils.js"></script>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="tools.css" rel="stylesheet" type="text/css" />
<link href="css/lightbox.css" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="favicon.ico" />
<script type="text/javascript" language="JavaScript"><!--
function HideContent(d) {
document.getElementById(d).style.display = "none";
}
function ShowContent(d) {
document.getElementById(d).style.display = "block";
}
function ReverseDisplay(d) {
if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }
else { document.getElementById(d).style.display = "none"; }
}
//--></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function CheckCatDelete(redirect_url)
{
    if (confirm("You are about to permanently delete a code category from the toolpage. Do you want to proceed?"))
    {
      location.replace(redirect_url);
    }
    else
    {
      alert("Deletion cancelled.");
    }
}

-->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
function CheckCodeDelete(redirect_url)
{
    if (confirm("You are about to permanently delete code from the toolpage. Do you want to proceed?"))
    {
      location.replace(redirect_url);
    }
    else
    {
      alert("Deletion cancelled.");
    }
}

-->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
function CheckLinkCatDelete(redirect_url)
{
    if (confirm("You are about to permanently delete a link category from the toolpage. Do you want to proceed?"))
    {
      location.replace(redirect_url);
    }
    else
    {
      alert("Deletion cancelled.");
    }
}

-->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
function CheckLinkDelete(redirect_url)
{
    if (confirm("You are about to permanently delete a link from the toolpage. Do you want to proceed?"))
    {
      location.replace(redirect_url);
    }
    else
    {
      alert("Deletion cancelled.");
    }
}

-->
</SCRIPT>


</head>

<body>
<div id="blackout"></div>
<div id="master">
  <div id="header">
		<a href="index.php"><img src="images/swissarmyknife.jpg" align="left" border="0" /></a><h3>Marian's Swiss Army Knife</h3>
		<b>HTML/CSS/PHP/MySQL/JavaScript...and other junk</b>
        <div id="loginbox">$loginlogout</div>
 	</div>
  <div id="bodywrap">
  <div id="wholepage">
ENDTAG;

?>