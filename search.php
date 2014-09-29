<?php

include("includes/declarations.php");
$crawltsite=2;
require_once("/var/chroot/home/content/44/10809344/html/crawltrack/crawltrack.php");
$thismonth=date(m);
$thisday=date(d);
$thisdate="$thismonth$thisday";
$thisyear=date(Y);

$htoday="$thisyear$thismonth$thisday";
$crawltsite=1;

$today="$thisyear$thismonth$thisday";
$titletag="Spacerock.com - Search Results";

/*******************************************
* Sphider Version 1.3.x
* This program is licensed under the GNU GPL.
* By Ando Saabas          ando(a t)cs.ioc.ee
********************************************/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(E_ALL);
$include_dir = "./includes";
include ("$include_dir/commonfuncs.php");
//extract(getHttpVars());

if (isset($_GET['query']))
	$query = $_GET['query'];
if (isset($_GET['search']))
	$search = $_GET['search'];
if (isset($_GET['domain']))
	$domain = $_GET['domain'];
if (isset($_GET['type']))
	$type = $_GET['type'];
if (isset($_GET['catid']))
	$catid = $_GET['catid'];
if (isset($_GET['category']))
	$category = $_GET['category'];
if (isset($_GET['results']))
	$results = $_GET['results'];
if (isset($_GET['start']))
	$start = $_GET['start'];
if (isset($_GET['adv']))
	$adv = $_GET['adv'];


$include_dir = "./includes";
$template_dir = "./templates";
$settings_dir = "./settings";
$language_dir = "./languages";


require_once("$settings_dir/database.php");
require_once("$language_dir/en-language.php");
require_once("$include_dir/searchfuncs.php");
require_once("$include_dir/categoryfuncs.php");


include "$settings_dir/conf.php";

//include "$template_dir/$template/header.html";

include "$language_dir/$language-language.php";


if ($type != "or" && $type != "and" && $type != "phrase") {
	$type = "and";
}

if (preg_match("/[^a-z0-9-.]+/", $domain)) {
	$domain="";
}


if ($results != "") {
	$results_per_page = $results;
}

if (get_magic_quotes_gpc()==1) {
	$query = stripslashes($query);
}

if (!is_numeric($catid)) {
	$catid = "";
}

if (!is_numeric($category)) {
	$category = "";
}



if ($catid && is_numeric($catid)) {

	$tpl_['category'] = sql_fetch_all('SELECT category FROM '.$mysql_table_prefix.'categories WHERE category_id='.(int)$_REQUEST['catid']);
}

$count_level0 = sql_fetch_all('SELECT count(*) FROM '.$mysql_table_prefix.'categories WHERE parent_num=0');
$has_categories = 0;

if ($count_level0) {
	$has_categories = $count_level0[0][0];
}



// require_once("$template_dir/$template/search_form.html");


function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    }



function poweredby () {
	global $sph_messages;
    //If you want to remove this, please donate to the project at http://www.sphider.eu/donate.php
    print $sph_messages['Powered by'];?>  <a href="http://www.sphider.eu/"><img src="sphider-logo.png" border="0" style="vertical-align: middle" alt="Sphider"></a>

    <?php
}


function saveToLog ($query, $elapsed, $results) {
        global $mysql_table_prefix;
    if ($results =="") {
        $results = 0;
    }
    $query =  "insert into ".$mysql_table_prefix."query_log (query, time, elapsed, results) values ('$query', now(), '$elapsed', '$results')";
	mysql_query($query);

	echo mysql_error();

}

switch ($search) {
	case 1:

		if (!isset($results)) {
			$results = "";
		}
		$search_results = get_search_results($query, $start, $category, $type, $results, $domain);
		require("$template_dir/$template/search_results.html");
	break;
	default:
		if ($show_categories) {
			if ($_REQUEST['catid']  && is_numeric($catid)) {
				$cat_info = get_category_info($catid);
			} else {
				$cat_info = get_categories_view();
			}
			require("$template_dir/$template/categories.html");
		}
	break;
	}
include("includes/dbconnect.php");
if($link)
{

}
else
{
	$error = "<b>Error:</b>  No Database connection.\n";
}
include("includes/headerinc.php");

print <<<ENDTAG
<div class="clearfix"></div>
	<article id="content" class="clearfix">
ENDTAG;
if($error)
{
	print "<span class=\"error\">$error</span>\n";
}
else
{

print <<<ENDTAG
<!-- use this for 2 col -->
	<aside id="in_this_section">
	
	</aside>
	<article id="content_col">
	
	</article>
<!--2 col end-->
<!-- otherwise just put the content here-->
	<!--$display-->
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("includes/footerinc.php");
?>

