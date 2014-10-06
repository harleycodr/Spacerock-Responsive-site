<?php


print_r($_POST);
print_r($_GET); 
print_r($_FILES);

$my_photo=$_REQUEST['image']['tmp_name'];

print "<p>THE NAME:  $image";
?>