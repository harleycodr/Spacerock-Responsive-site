<?php
session_start();
	include("../includes/declarations.php");
	include("includes/declarations.php");
	$action=$_GET['action'];
	$m=$_GET['m'];
	$oldcover=$_POST['oldcover'];
	$watched=$_POST['watched'];
	$flag=$_POST['flag'];
	$favorite=$_POST['favorite'];
	$title=$_POST['title'];
	$title=addslashes($title);
	$format=$_POST['format'];
	$rating=$_POST['rating'];
	$year=$_POST['year'];
	$runtime=$_POST['runtime'];
	$synopsis=$_POST['synopsis'];
	$location=$_POST['location'];
	$display_title=$_POST['display_title'];

	$cover=$_FILES['cover']['tmp_name'];
	if($cover=="")
	{
		$has_cover="0";
	}
	else
	{
		$has_cover="1";
		$cover_type=$_FILES['cover']['type'];
		
		if ($cover_type == "image/pjpeg")
        {
          $extension = ".jpg";
        }
		elseif ($cover_type == "image/jpeg")
        {
          $extension = ".jpg";
        }
		elseif ($cover_type == "image/jpg")
        {
          $extension = ".jpg";
        }
		  elseif ($cover_type == "image/gif")
		  {
			$extension = ".gif";
		  }

		if ($cover_type == "image/PJPEG")
        {
          $extension = ".jpg";
        }
		elseif ($cover_type == "image/JPEG")
        {
          $extension = ".jpg";
        }
		elseif ($cover_type == "image/GIF")
		  {
			$extension = "gif";
		  }
		elseif ($cover_type == "image/png")
		{
			$extension=".png";
		}
		elseif ($cover_type=="image/PNG")
		{
			$extension=".png";
		}
	}
	
	
	
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
	$coverdir = "/home/content/44/10809344/html/SPACEROCK/images/covers";


	include ("../includes/moviedbconnect.php");
    if($link)
    {
	
		
        if($action=="edit")
        {
			//$refpage=$_SERVER['HTTP_REFERER'];
			
            $formaction = "makeedits";
            $submitvalue = "Edit Title ";
		    $pagetitle = "Make Edits";


		  if ($result = mysql_query("select
				 Title,
				 Media,
				 Rating,
				 runtime,
				 Cover,
				 Synopsis,
				 Year,
				 watched,
				 flag,
                 favorite,
				 display_title,
				 location
			   FROM
				 ourmovies
			   WHERE
				 ID = '$m'"))
			{
    			while($row=mysql_fetch_array($result))
                {
    				$title=stripslashes($row[0]);
                    $media=$row[1];
                    $rating=$row[2];
                    $runtime=$row[3];
                    $cover=$row[4];
                    $synopsis=stripslashes($row[5]);
                    $year=$row[6];
                    $watched=$row[7];
                    $flag=$row[8];
                    $favorite=$row[9];
					$display_title=stripslashes($row[10]);
					$location=$row[11];
                }
   			 }
	         else
	         {
	            $goof=mysql_error();
   				echo "Error:  $goof  First query";
             }

				if ($cover != '')
				  {
					$coverdisplay .="<img src=\"../images/covers/$cover\" \>";
					$coverdisplay .="<br /><input type=\"hidden\" name=\"oldcover\" value=\"$cover\">\n";
					$coverdisplay .="<br /><b>Change Cover:</b>  <input type=\"file\" name=\"cover\">\n";
				  }
				else
				  {
					$coverdisplay="<input type=\"file\" name=\"cover\">";
				  }
			   if ($watched == 'x')
			   {
				 $watchchecked=' checked';
			   }
			   if ($flag == '1')
			   {
				 $flagchecked=' checked';
			   }
			   if ($favorite == '1')
			   {
				 $favoritechecked=' checked';
			   }

			 if ($result = mysql_query("
						select
						  categories.abbr,
						  categories.categoryname,
						  moviesincategories.movieid
						FROM
						  categories
						  LEFT JOIN moviesincategories ON
							categories.ID = moviesincategories.catid AND
							moviesincategories.movieid = '$m'
						ORDER BY
						  categories.categoryname"))
			   {
				 while ($row = mysql_fetch_array($result))
				   {
					 if ($row["movieid"] == $m)
					   {
						 $checked = " checked";

					   }
					 else
					   {
						 $checked = "";
					   }

					   $display .="<input type=\"checkbox\" name=\"".$row["abbr"]."\"$checked>".$row["categoryname"]."<br />\n";
					 }
			   }
			   else
			   {
					$goof=mysql_error();
					$error = "<b>Error:</b>  $goof Cat query\n";
			   }
        }
        elseif($action=="makeedits")
        {
            mysql_query("DELETE from moviesincategories WHERE movieid = '$m'");

	  //now let us put the categories currently selected in
			if ($result = mysql_query( "select abbr, ID from categories order by categoryname" ))
			{
				while ($row = mysql_fetch_array($result))
				{
				

					 //if ($$row['abbr'] == "on")
					 $abbr=$row[0];
					 $catid=$row[1];
					 
					if($_POST[$abbr]=="on")
					{
						
				//insert into moviesincategories
					   
					   mysql_query("INSERT INTO moviesincategories SET
						catid='$catid',
						movieid='$m'");
					   
					}
				}
			}
			else
			{
				$goof=mysql_error();
				$error="<b>Error:</b>  $goof";
			}
			
			if ($has_cover=="1")
			{
				$cover="$cover";
				$cover_name=stripslashes($title);
				$cover_name=preg_replace("/[^a-zA-Z0-9.]/", "", $cover_name);
				
				$cover_name="$cover_name$extension";
				@copy("$cover" , "$coverdir/$cover_name");


				$cover="$cover_name";
			}
			else
			{
				$cover_name ="$oldcover";
			}

			if ($watched == 'on')
			{
				$watched='x';
			}
			if ($flag=="on")
			{
				$flag='1';
			}
			if ($favorite=="on")
			{
				$favorite='1';
			}
			if($result=mysql_query( "UPDATE ourmovies SET
						  Title = '$title',
						  Media = '$format',
						  Rating = '$rating',
						  Year = '$year',
						  runtime = '$runtime',
						  Cover = '$cover_name',
						  Synopsis = '$synopsis',
						  watched='$watched',
						  flag='$flag',
						  location='$location',
                          favorite='$favorite',
						  display_title='".addslashes($display_title)."'
						  WHERE ID = '$m'"))
						  {
							header ("Location:$domain/admintools/movieindex.php");
							//header("Location:$refpage");
							  exit;
						  }
						  else
						  {
							$goof=mysql_error();
							$error = "<b>Error:</b>  $goof\n";
						  }

				
			
		}
        elseif($action=="addnew")
		{


			  //category add
					if ($result = mysql_query( "select abbr, categoryname, ID from categories order by categoryname" ))
					{
					while ($row = mysql_fetch_array($result))
					  {

						 if ($$row['abbr'] == "on")

					//insert into moviesincategories
						   {
						   mysql_query("INSERT INTO moviesincategories SET
							catid='".$row['ID']."',
							movieid='$m'");
						   }
					   }
					}

					if ($has_cover=="1")
					{
								$cover="$cover";
								$cover_name=stripslashes($title);
								$cover_name=preg_replace("/[^a-zA-Z0-9.]/", "", $cover_name);
								@copy("$cover" , "$coverdir/$cover_name");


								
					}
					else
					{
						$cover ="$oldcover";
					}

					if ($watched == 'on')
					{
					  $watched='x';
					}
					if ($flag=="on")
					{
						$flag='1';
					}
					if ($favorite=="on")
					{
						$favorite='1';
					}
					  if($result=mysql_query( "INSERT into ourmovies SET
								  Title = '$title',
								  Media = '$format',
								  Rating = '$rating',
								  Year = '$year',
								  runtime = '$runtime',
								  Cover = '$cover_name',
								  Synopsis = '".addslashes($synopsis)."',
								  watched='$watched',
								  flag='$flag',
								  location='$location',
		                          favorite='$favorite',
								  display_title='".addslashes($display_title)."'"))
								  {
								  $m=mysql_insert_id($link);

								  //category add
								  if ($result = mysql_query( "select abbr, ID from categories order by categoryname" ))
								  {
								  	while ($row = mysql_fetch_array($result))
								  	{
										$abbrdb=$row[0];
										$catid=$row[1];
										
										
											if ($_POST[$abbrdb] == "on")
											
											//insert into moviesincategories
											{
											
												mysql_query("INSERT INTO moviesincategories SET
												catid='$catid',
												movieid='$m'");
											}
										
									}
									
									  header ("Location:$domain/admintools/movieindex.php");
									  exit;
								  }
								  else
								  {
									$goof=mysql_error();
									$error = "<b>Error:</b>  Line 368 $goof\n";
									
								  }

					}
					else
					{
						$goof=mysql_error();
						$error = "<b>Error:</b>  $goof around 181\n";
						
					}

        }

     if(!$action)
	 {
	 		//add a new record provide form layout and options for adding a new record
	 			$submitvalue = "Add Movie ";
	 			$pagetitle = "Add New Movie";
	 			$formaction="addnew";

	 		  $catcount = mysql_query(" SELECT ID from categories ");
	 			$records=mysql_num_rows($catcount);

	 			$division = $records / 2;
	 			$limit = round($division);
	 			$lineheight = $limit * 40;

	 		  $display .= "<div style=\"width:150px;float:left;\"><p>\n";
	 		  $count=0;

	 			$categories = mysql_query( "select abbr, categoryname from categories order by categoryname" );
	 			$coverdisplay = "<input type=\"file\" name=\"cover\">";
	 			while ($row = mysql_fetch_array($categories))
	 			{
	 			  $count=$count+1;
	 			  $display .="<input type=\"checkbox\" name=\"".$row["abbr"]."\">".$row["categoryname"]."<br />\n";
	 				if($count=="$limit")
	 				{
	 					$display .= "</p></div><div style=\"width:150px;float:left;\"><p>\n";
	 					$count="0";
	 				}
	 				else
	 				{
	 					$count=$count+1;
	 				}

	 			}
	 			if($count=="$limit")
	 			{
	 				print "</div>\n";
	 			}
	 			  if ($cover_name != "")
	 			  {

	 					  @copy("$cover" , "$coverdir/$cover_name");

	 		  //                    or die("Couldn't Upload Your File.");

	 			  $cover="$cover_name";
	 			  }
	 			 if ($watched=="on")
	 			 {
	 			   $watched='x';
	 			 }
	 			 if ($flag=="on")
	 			 {
	 				$flag="1";
	 			 }
	 			 if ($favorite="on")
	 			 {
	 				$favorite="1";
	 			 }
	 			 if($action=="add")
	 			 {
	 			  if ($result1=mysql_query( "INSERT into ourmovies SET
	 						Title = '$title',
	 						Media = '$format',
	 						Rating = '$Rating',
	 						Year = '$year',
	 						runtime = '$runtime',
	 						Cover = '$cover',
	 						Synopsis = '".addslashes($synopsis)."',
	 						adddate = NOW(),
	 						watched = '$watched',
	 						flag='$flag',
	 						location='$location',
	                        favorite='$favorite',
							display_title='".addslashes($display_title)."' "))
	 				{

	 				  $m=mysql_insert_id($link);

	 				  if ($result = mysql_query( "select
	 					abbr
	 						ID
	 						from categories
	 						order by categoryname" ))
	 				  {
	 					while ($row = mysql_fetch_array($result))
	 					{

	 						$abbr=$row[0];



	 					if ($$row[0] == "on")
	 					// if($theabbr=="on")
	 						//insert into moviesincategories
	 						 {
	 							 $diditwork="yes";
	 							 if($result2=mysql_query("INSERT INTO
	 								moviesincategories SET
	 							  catid='$catID',
	 							  movieid='$m'"))
	 							  {
	 								   // print "$diditwork";

	 									header ("Location:$domain/admintools/movieindex.php");

	 							  }
	 							  else
	 							  {
	 								 $goof=mysql_error();
	 								$error= "<b>Error:  $goof ";
	 							  }
	 						 }


	 				}

	 			  }
	 			  else
	 			  {
	 				$goof=mysql_error();
	 				$error= "<b>Error:  $goof ";
	 			  }
	 			/*print_r($_POST);
	 			print_r($_GET);
	 			print "Did it work:  $diditwork";*/
	 			}
	 			else
	 			{
	 			   $goof=mysql_error();
	 				$error= "<b>Error:  $goof ";
	 			}

	 		   }
		  }
	}


    else
    {
        $error="<b>Error:</b>  No db connection.";
    }

}
else
{
    include("loginerror.php");
}
include("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
print "
<article id=\"content\">\n";
if($error)
{
    print "$error";
}
else
{
print <<<ENDTAG

<p>
<a href="index.php">Website Admin Home</a> > <a href="movieindex.php">Manage DVDs</a> > $pagetitle</p>
   <p><span class="headline">$pagetitle</span> $showme
  <p><form action="$PHP_SELF?action=$formaction&m=$m" method="post" enctype="multipart/form-data">

	<input type="hidden" name="refpage" value="$refpage" />
  <P><INPUT TYPE="checkbox" NAME="flag"$flagchecked>  Flag to watch&nbsp;&nbsp;<input type="checkbox" name="favorite"$favoritechecked \>Mark as a Favorite
  <BR><TABLE WIDTH="750" BORDER=1>
    <tr valign="top">
    <td colspan="2">
      <p><b>Category:</b></p>
      $display

    </td>
    </tr>
    <TR VALIGN=TOP>
    <TD WIDTH=100>
      <B>Title:</B>
    </TD>
    <TD WIDTH=500>
      <INPUT TYPE="text" NAME="title" VALUE="$title" SIZE=50>
    </TD>
    </TR>
	<TR VALIGN=TOP>
    <TD WIDTH=100>
      <B>Display Title:</B>
    </TD>
    <TD WIDTH=500>
      <INPUT TYPE="text" NAME="display_title" VALUE="$display_title" SIZE=50>
    </TD>
    </TR>
<tr>
<td>
   <b>Stored Location:</b>
</td>
<td>
	<select name="location">
		<option value="$location">$location</option>
		<option value="DVD Spinner">DVD Spinner</option>
		<option value="Binder">Binder</option>
	</select>
</td>
</tr>
    <tr valign=top>
    <td>
      <b>Format</b>
    </td>
    <td>
      <select name="format">
		<option value="$media">$media</option>
        <option value="bluray">Blu-Ray</option>
        <OPTION VALUE="DVD">DVD</option>
        <OPTION VALUE="VHS">VHS</option>
      </SELECT>
    </TD>
    </TR>
    <TR VALIGN=TOP>
    <TD>
      <B>Year</B>  <INPUT TYPE="text" NAME="year" VALUE="$year">
       <BR><B>Rating:</B>
       <SELECT NAME="rating">
         <OPTION VALUE="$rating">$rating
         <OPTION VALUE="G">G
         <OPTION VALUE="PG-13">PG-13
         <OPTION VALUE="PG">PG
         <OPTION VALUE="R">R
         <OPTION VALUE="Not Rated">Not Rated
       </SELECT>
       <BR><B>Runtime:</B>  <INPUT TYPE="text" NAME="runtime" VALUE="$runtime">
       <BR><B>Watched?</B>  <INPUT TYPE="checkbox"
NAME="watched"$watchchecked">Yes
    </TD>
    <TD>
      <B>Synopsis:</B>
<textarea cols="80" id="editor_kama" name="synopsis" rows="10">$synopsis</textarea>
				<script type="text/javascript">
				//<![CDATA[

					CKEDITOR.replace( 'synopsis',
						{
							skin : 'kama'
						});

				//]]>
				</script>

    </TD>
    </TR>
    <TR VALIGN=TOP>
    <TD>
      <B>Cover Art:</B>
    </TD>
    <TD>
      $coverdisplay
    </TD>
    </TR>
    </TABLE>
ENDTAG;


print "<BR><INPUT TYPE=\"submit\" VALUE=\" $submitvalue \">;
print "</article>\n";
}
include ("../footerinclude.php");


?>