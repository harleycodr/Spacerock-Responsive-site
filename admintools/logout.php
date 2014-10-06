<?php

session_start();
//include("variables.php");
	include("../includes/declarations.php");
	include("includes/declarations.php");


// make db connection
include ("../includes/dbconnect.php");
if($link)
{
    if($result=("UPDATE admintools_log
    SET
    time_out=NOW()
    where ID='$worksession_id'"))
    {
    
        
        unset ($_SESSION);
        session_destroy();
         header("Location:$domain/admintools");
        
    }
    else
    {
        $goof=mysql_error();
        print "$goof";
    }
}

else
{
    include("nodberror.php");
}
?>