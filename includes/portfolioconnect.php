<?php

  $user = "YGWdb";
  $pass = "vV6M7NhtmDQy7!";
  $db = "YGWdb";
  $link = mysql_connect( "YGWdb.db.10809344.hostedresource.com", $user, $pass );
  if ( ! $link )
  die ( "Could not connect to db");
  mysql_select_db( $db, $link )
  or die ("Could not open $db:  ".mysql_error() );
  
  ?>