<?php
session_start();

	include("../includes/declarations.php");
	include("includes/declarations.php");
	$action=$_GET['action'];
	$b=$_GET['b'];
	
	
	$bookshelfdir="/home/content/44/10809344/html/SPACEROCK/bookshelf";
	
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{

	include ("fckeditor.php");

	include ("../includes/dbconnect.php");

	if ($action=="edit")
	{
		$formaction="makeedits";
		if($result=mysql_query("SELECT
			title,
			author_last,
			author_first,
			edition,
			month(date) AS month,
			year(date) AS year,
			cover,
			file,
			subtitle,
			coauthor_last,
			coauthor_first
			from bookshelf
			where id='$b'"))
			{
				while($row=mysql_fetch_array($result))
				{
					$title=stripslashes($row[0]);
					$author_last=$row[1];
					$author_first=$row[2];
					$edition=$row[3];
					$month=$row[4];
					$year=$row[5];
					$cover=$row[6];
					$file=$row[7];
					$subtitle=stripslashes($row[8]);
					$coauthor_last=$row[9];
					$coauthor_first=$row[10];
					
					$heading="Edit $title";
					
					if($cover)
					{
						$existingcover .= "<p>Existing Cover:\n";
						$existingcover .= "<br /><img src=\"../bookshelf/covers/tb_$cover\" />\n";
						$existingcover .= "<br />You can keep this one or upload a new one.<input type=\"hidden\" name=\"oldcover\" value=\"$cover\" /></p>\n";
					}
				}
			}
				
			else
			{
			  $goof=mysql_error();
				 $error="<b>Error:</b>  $goof\n";
			}
	}
	elseif ($action == "makeedits")
	{
		$title=$_POST['title'];
		$title=addslashes($title);
		$author_last=$_POST['author_last'];
		$coauthor_first=$_POST['author_first'];
		$coauthor_last=$_POST['coauthor_last'];
		$author_first=$_POST['coauthor_first'];
		$edition=$_POST['edition'];
		$month=$_POST['month'];
		$year=$_POST['year'];
		$file=$_FILES['file']['tmp_name'];
		$cover=$_FILES['cover']['tmp_name'];
		$oldcover=$_POST['oldcover'];
		$oldfile=$_POST['oldfile'];
		$subtitle=$_POST['subtitle'];
		$subtitle=addslashes($subtitle);
		
		$date="$year-$month-01";
				
		
		if($cover=="")
		{
			$has_cover="0";
		}
		else
		{
			$has_cover="1";
			$cover_type=$_FILES['cover']['type'];
		}
	    if($has_cover=="1")
	    {
			
	      include("bookcoverhandlerinc.php");
	    }
	    else
	    {
	      $newcoverfile="$oldcover";
	    }
		
		
		if($file=="")
		{
			$has_file="0";
			$newfile="$oldfile";
		}
		else
		{
			$has_file="1";
			
		}
		if($has_file=="1")
		{
			$newfile=str_replace(' ', '_', $title);
			$newfile="$newfile.pdf";
			copy($file, "$bookshelfdir/$newfile");
		}
		if ($result=mysql_query("UPDATE bookshelf
				  SET
					title='$title',
					author_last='$author_last',
					author_first='$author_first',
					edition='$edition',
					date='$date',
					cover='$newcoverfile',
					file='$newfile',
					coauthor_first='$coauthor_first',
					coauthor_last='$coauthor_last',
					subtitle='$subtitle'
					where id='$b'"))
					

			{
				header("Location:$domain/admintools/managebooks.php");
			
			}
			else
			{
				$goof=mysql_error();
				$error="<b>Error:</b>  $goof\n";
			}
	}		

	elseif($action=="addnew")
	{
		$title=$_POST['title'];
		$title=addslashes($title);
		$author_last=$_POST['author_last'];
		$author_first=$_POST['author_first'];
		$coauthor_last=$_POST['coauthor_last'];
		$author_first=$_POST['coauthor_first'];
		$subtitle=$_POST['subtitle'];
		$edition=$_POST['edition'];
		$month=$_POST['month'];
		$year=$_POST['year'];
		$file=$_FILES['file']['tmp_name'];
		$cover=$_FILES['cover']['tmp_name'];
		$subtitle=$_POST['subtitle'];
		$subtitle=addslashes($subtitle);
		
		$date="$year-$month-01";
				
		
		if($cover=="")
		{
			$has_cover="0";
		}
		else
		{
			$has_cover="1";
			$cover_type=$_FILES['cover']['type'];
		}
	    if($has_cover=="1")
	    {
			
	      include("bookcoverhandlerinc.php");
	    }
	    else
	    {
	      $newcoverfile="$oldcover";
	    }
		$newfile=str_replace(' ', '_', $title);
		
		$newfile="$newfile.pdf";
		
		copy($file, "$bookshelfdir/$newfile");

		if ($result=mysql_query("INSERT into bookshelf
				  SET
					title='$title',
					author_last='$author_last',
					author_first='$author_first',
					edition='$edition',
					date='$date',
					cover='$newcoverfile',
					file='$newfile',
					coauthor_first='$coauthor_first',
					coauthor_last='$coauthor_last',
					subtitle='$subtitle'"))
					

			{
				header("Location:$domain/admintools/managebooks.php");
			
			}
			else
			{
				$goof=mysql_error();
				$error="<b>Error:</b>  $goof\n";
			}
	}

	else
	{
		$formaction="addnew";
		$heading = " Add New Title";

	}

}
else
{
    include("loginerror.php");
}
$titletag="$heading";
include("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
print "<article id=\"content\">\n";

if ($error)
{
	print "<p style=\"color:red;\">$error</p>\n";
}
else
{

print <<<ENDTAG

<p><a href="index.php">Admin Home</A> > <A HREF="managebooks.php">Manage Bookshelf</A> > $heading</p>

<h2 class="tac">$heading</h2>

<div style="width:900px; margin-left:auto;margin-right:auto; "><!--big container-->
	<form action="addbook.php?b=$b&action=$formaction" method="post" enctype="multipart/form-data">

	

	<p><table width="800" border="1">
	<tr>
	<td>
		
		<input type="text" placeholder="Title" name="title" size="50" value="$title" />
		<br /><input type="text" placeholder="Subtitle" name="subtitle" size="50" value="$subtitle" />
	</td>
	<td>
		<input type="text" placeholder="Author, Last" name="author_last" value="$author_last" size="30" style=\"float:left;\"/>
		<input type="text" placeholder="Author, First" name="author_first" value="$author_first" size="30" style=\"float:left;\"/>
		<input type="text" placeholder="Co-Author, Last" name="coauthor_last" value="$coauthor_last" size="30"  style=\"float:left;\" />
		<input type="text" placeholder="Co-Author, First" name="coauthor_first" value="$coauthor_first" size="30"  style=\"float:left;\"/>
	</tr>
	
	<tr>
	<td>
		<b>Cover:</b>
		$existingcover
	</td>
	<td>
		
		<input type="file" name="cover" size="20" />
	</td>
	</tr>
	
	<tr valign="top">
	<td>
	  <input type="text" placeholder="Edition" size="20" value="$edition" />
	</td>
	<td>
		<input type="text" placeholder="Month" value="$month" size="5" name="month" />  <input type="text" placeholder="Year" value="$year" size="5" name="year" />

	</td>
	</tr>
	</table>
	<p><input type="file" name="file" /></p>
	<input type="hidden" name="oldfile" value="$file" />
	<p class="tac"><input type="submit" value=" $heading" /></p>
	
	</form>
	

	</div><!--end of big container-->
	</article><!--content-->
	
	      
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");


?>