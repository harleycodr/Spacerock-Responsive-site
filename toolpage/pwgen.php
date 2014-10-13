<?php
$pwl=$_REQUEST['pwl'];
echo createPassword($pwl);

function createPassword($pwl) {
	$chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$i = 0;
	$password = "";
	while ($i <= $pwl) {
		$password .= $chars{mt_rand(0,strlen($chars))};
		$i++;
	}
	return $password;
}
 
$password = createPassword($pwl);

echo "$password";



?>