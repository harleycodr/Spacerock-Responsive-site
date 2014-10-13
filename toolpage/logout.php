<?php
session_start();
include("../includes/declarations.php");

/**
 * @author Your Great Website.com
 * @copyright 2011
 */

unset ($_SESSION);

session_destroy();

header("Location:$domain/toolpage/toolpage.php");

?>