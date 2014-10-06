<?php
    session_cache_expire( 20 );
    session_start(); // NEVER FORGET TO START THE SESSION!!!
    $inactive = 600;
    if(isset($_SESSION['start']) )
    {
	    $session_life = time() - $_SESSION['start'];
	    if($session_life > $inactive)
	    {
	    	header("Location: /admintools/index.php");
    	 }
    }
    $_SESSION['start'] = time();

    if($_SESSION['valid_user'] != true)
    {

      header('Location: /admintools/index.php');

    }
?>