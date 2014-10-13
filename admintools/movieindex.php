<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_GET['action'];
$a=$_GET['a'];
$m=$_GET['m'];

$thismonth=date(m);
$thisday=date(d);
$thisdate="$thismonth$thisday";
$thisyear=date(Y);
$page=$_GET['page'];
// $this_page=$_GET['this_page'];

//include ("movies/dynamicheader.php");

include ("../includes/moviedbconnect.php");
if ($link)
{
	if($action=="delete")
	{
		if($result=mysql_query("DELETE
		from
		ourmovies
		where ID='$m'"))
		{
			header("Location:$domain/admintools/movieindex.php");
		}
		else
		{
			$goof=mysql_error();
			$error="<b>Error:</b>  $goof";
		}
	}
      if(!$page)
      {
         $offset_limit="LIMIT 20";
    
         $this_page=1;
    
      }
      else
      {
        $this_page=$page;
    
        $figure_out=$page-1;
    
        $offset=20 * $figure_out;
    
        $offset_limit="LIMIT 20 OFFSET $offset";
      }
        if ($MOVIES = mysql_query("
             SELECT
               ID,
               Title,
               Year,
               runtime,
               Synopsis,
               Rating,
               Media,
               Borrower,
               Cover,
			   display_title
             FROM
               ourmovies
            ORDER by Title $offset_limit"))
          	{
          		while($row=mysql_fetch_array($MOVIES))
          		{
    
          			$m=$row[0];
          			$Title=stripslashes($row[1]);
          			$Year=$row[2];
          			$runtime=$row[3];
          			$Synopsis=stripslashes($row[4]);
          			$Rating=$row[5];
          			$Media=$row[6];
          			$Borrower=$row[7];
          			$Cover=$row[8];
					$display_title=stripslashes($row[9]);
    
    				
    				if($Cover=="")
    				{
    					$coverdisplay = "(Need Cover)";
    				}
					if($display_title)
					{
						$Title=$display_title;
					}
    				$display .= "<tr><td>$Title</td><td><a href=\"addmovie.php?m=$m&action=edit\">Edit</a></td><td><a href=\"javascript:CheckDelete('movieindex.php?action=delete&m=$m')\">Delete</a></td></tr>\n";    
          		}
          	}
          	else
          	{
          		$goof=mysql_error();
          		$error="<b>Error:</b>  $goof";
          	}
            // build page navigation
    
            if($thecount=mysql_query("SELECT ID
            from ourmovies"))
            {
                $thecount=mysql_num_rows($thecount);
    
                $page_count=$thecount/20;
    
                $rounded=round($page_count);
    
                if($rounded<$page_count)
                {
                    $page_count=$rounded+1;
                }
            }
    
            $next_page=$this_page+1;
    
            $prev_page=$this_page-1;
    
            // if this isn't the first page, make a link to the previous
            if($prev_page>0)
            {
                $pagination_links.="<a href=\"$PHP_SELF\"><<</a>&nbsp;&nbsp;<a href=\"$PHP_SELF?page=$prev_page\"><</a>&nbsp;&nbsp;";
    
                // show pages before this page
    
    
                $pagination_counter=1;
    
                while($pagination_counter<$this_page)
                {
                    $pagination_links .= "<a href=\"$PHP_SELF?page=$pagination_counter\">$pagination_counter</a>&nbsp;&nbsp;";
                    $pagination_counter=$pagination_counter+1;
                }
                $pagination_links .= "<b>$this_page</b>&nbsp;&nbsp;";
            }
            else // this is page 1
            {
                $pagination_links.="<b>$this_page</b>&nbsp;&nbsp;";
            }
    
    
            // if this isn't the last page, make a link to the next
            if($this_page<$page_count)
            {
              // show pages after
                $pagination_counter=$this_page+1;
    
                $last_page_limiter=$page_count+1;
    
                while($pagination_counter<$last_page_limiter)
                {
                    $pagination_links .= "<a href=\"$PHP_SELF?page=$pagination_counter\">$pagination_counter</a>&nbsp;&nbsp;";
                    $pagination_counter=$pagination_counter+1;
                }
    
              $pagination_links.="<a href=\"$PHP_SELF?page=$next_page\">></a>&nbsp;&nbsp;<a href=\"$PHP_SELF?page=$page_count\">>></a>";
            }
    
}
else
{
	$error = "<b>Error:</b>  No DB Connection.\n";
}
$metadescription="";

include("/home/content/44/10809344/html/SPACEROCK/includes/headerinc.php");
print "<article id=\"content\">\n";

if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{
print <<<ENDTAG
<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckDelete(redirect_url)
                    {
                        if (confirm("You are about to permanently delete a dvd from the database. Do you want to proceed?"))
                        {
                          location.replace(redirect_url);
                        }
                        else
                        {
                          alert("Deletion cancelled.");
                        }
                    }

                    -->
</SCRIPT>
<div id="wholepage">
<p><a href="index.php">Site Admin Home</a></p>
    <h2>Manage DVD Collection</h2>
    <p style="text-align:center;"><a href="addmovie.php">Add Title</a></p>
    <div class="pagination">
        $pagination_links
    </div>
    <table width="600" border="1" align="center">
    	$display
    </table>
    <div class="pagination">
    $pagination_links
    </div>
ENDTAG;
}
print "</article>\n";
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");

?>