<?php
$d=$_POST['d'];
$d=$_GET['d'];
include ("../includes/dbconnect.php");

/**
 * @author Your Great Website.com
 * @copyright 2011
 */
$result=mysql_query("SELECT
                    *
                    from dishtype
                    where ID='$d'");

                    $array=mysql_fetch_array($result);

   $newdtname=$array[1];
   echo json_encode($array);
//  echo $newdtname;

?>