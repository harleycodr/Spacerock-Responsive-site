<?php
session_start();
$adminloggedin=$_SESSION['adminloggedin'];

$host = $_SERVER['HTTP_HOST'];

include ("../includes/dbconnect.php");
if($link)
{
    if($adminloggedin=="1")
    {
        $loginlogout="<a href=\"logout.php\">Logout</a>&nbsp;&nbsp;<a href=\"admin.php\">Admin</a>\n";

    	if($result=mysql_query("SELECT
    		id,
    		category_name
    		from toolpage_categories
    		order by sequence"))
    		{
    		  while($row=mysql_fetch_array($result))
              {
    			$catid=$row[0];
    			$category_name=stripslashes($row[1]);

    			$panels .= "<li class=\"TabbedPanelsTab\" tabindex=\"0\">$category_name</li>";

    			$display .= "<div class=\"TabbedPanelsContent\">";
    			$display .= "\t<h2>$category_name</h2>\n";
    			$display .= "<ul>\n";

    			if($result2=mysql_query("SELECT
                    name,
                    directions,
                    code,
                    description,
                    comments,
                    id,
                    pre_code,
                    directions2,
                    directions3,
                    code2,
                    code3,
                    pre_code2,
                    pre_code3,
					demo_frame,
					download
                    from toolpage_code
    				where category='$catid'
    				order by name"))
    				{
    				    $directions="";
                        $description="";
                        //$pre_code="";
                        $comments="";
    				    while($row=mysql_fetch_array($result2))
                        {
        					$name=stripslashes($row[0]);
        					$directions=stripslashes($row[1]);
        					$code=stripslashes($row[2]);
        					$description=stripslashes($row[3]);
        					$comments=stripslashes($row[4]);
        					$codeid=$row[5];
                            $pre_code=stripslashes($row[6]);
                            $directions2=stripslashes($row[7]);
                            $directions3=stripslashes($row[8]);
                            $code2=stripslashes($row[9]);
                            $code3=stripslashes($row[10]);
                            $pre_code2=stripslashes($row[11]);
                            $pre_code3=stripslashes($row[12]);
							$demo_frame=$row[13];
							$download=$row[14];
                    
        					$display .= "<li><a href=\"javascript:ShowContent('uniquename$codeid')\"><b>$name</a></b>\n";
        					$display .= "</li>";
            				$display .= "<div id=\"uniquename$codeid\" style=\"display:none; border:solid black thin;padding:5px; background:#ffffff; height:auto;\">\n";
              				$display .= "<div align=\"right\"><a href=\"javascript:HideContent('uniquename$codeid')\">Click to hide.</a></div>\n";
                            $display .= "$directions ";
                            if($pre_code)
                            {
                                $display .= "<p class=\"code\">$pre_code</p>";
                            }
                            if($code)
                            {
                      	        $display .= "<form>\n";
                                $display .= "<textarea name=\"yourForm\" rows=\"15\" cols=\"80\" wrap=virtual>\n";
                                $display .= "$code";
                                $display .= "</textarea>\n";
                                $display .= "<br /><input type=\"button\" value=\"Highlight All\" onClick=\"javascript:this.form.yourForm.focus();this.form.yourForm.select();\" />\n";
                                $display .= "</form>";
                            }
                            if($directions2)
                            {
                                $display .= "<p>$directions2</p>";
                                if($code2)
                                {
                          	        $display .= "<form>\n";
                                    $display .= "<textarea name=\"yourForm\" rows=\"15\" cols=\"80\" wrap=virtual>\n";
                                    $display .= "$code2";
                                    $display .= "</textarea>\n";
                                    $display .= "<br /><input type=\"button\" value=\"Highlight All\" onClick=\"javascript:this.form.yourForm.focus();this.form.yourForm.select();\" />\n";
                                    $display .= "</form>";

                                }
                                if($pre_code2)
                                {
                                    $display .= "<p class=\"code\">$pre_code2</p>";
                                }
                            }
                            if($directions3)
                            {
                                $display .= "<p>$directions2</p>";
                                if($code3)
                                {
                          	        $display .= "<form>\n";
                                    $display .= "<textarea name=\"yourForm\" rows=\"15\" cols=\"80\" wrap=virtual>\n";
                                    $display .= "$code3";
                                    $display .= "</textarea>\n";
                                    $display .= "<br /><input type=\"button\" value=\"Highlight All\" onClick=\"javascript:this.form.yourForm.focus();this.form.yourForm.select();\" />\n";
                                    $display .= "</form>";

                                }
                                if($pre_code3)
                                {
                                    $display .= "<p class=\"code\">$pre_code3</p>";
                                }
                            }
                            if($comments)
                            {
                                $display .= "<p>$comments</p>";
                            }
							if($demo_frame)
							{
								$display .= "<p><b>Demo:</b></p><iframe src=\"$demo_frame\" style=\"width:680px; min-height:800px;\"></iframe>\n";
							}
                            $display .= "<div align=\"right\"><a href=\"javascript:HideContent('uniquename$codeid')\">Click to hide.</a></div>\n";
							if($download)
							{
								$display .= "<div style=\"clear:both; width:100px float:left;height:32px;\"><div style=\"width:32px; float:left;\"><img src=\"images/download.png\" /></div><a href=\"uploads/$download\"><b>Download Files</b></a></div>\n";
							}
                            $display .= "</div>\n";
                        }
    				}
    				else
    				{
    					$goof=mysql_error();
    					$error="<b>Error:</b>  $goof\n";
    				}
    			$display .= "</ul>\n";
                $display .= "</div><!--code end for $category_name-->\n";
                }
    		}
    		else
    		{
    			$goof=mysql_error();
    			$error="<b>Error:</b>  $goof\n";
    		}
      }
      else
      {
		$adminloggedin;
        $error .= "<p class=\"fwb tac\">Login:</p>\n";
        $error .="<form action=\"login.php\" method=\"post\">\n";
        $error .="<div style=\"width:200px; margin-left:auto; margin-right:auto; border:solid thin blue;padding:5px;\">\n";
        $error .="<table width=\"200\">\n";
        $error .="<tr>\n";
        $error .="<td>\n";
        $error .="<b>Username:</b>\n";
        $error .="</td>\n";
        $error .="<td>\n";
        $error .="<input type=\"text\" name=\"user\" size=\"10\" id=\"username\" />\n";
        $error .="</td>\n";
        $error .="</tr>\n";
        $error .="<tr>\n";
        $error .=" <td>\n";
        $error .="<b>Password:</b>\n";
        $error .="</td>\n";
        $error .="<td>\n";
        $error .="<input type=\"password\" name=\"pass\" size=\"10\" />\n";
        $error .="</td>\n";
        $error .="</tr>\n";
        $error .="</table>\n";
        $error .="<div align=\"center\">\n";
        $error .="<input type=\"submit\" value=\"Login\" />\n";
        $error .="</div>\n";
        $error .="</div></form>\n";
    }
}
else
{
	$error = "<b>Error:</b>  No db connection.\n";
}

include("header.php");

if($error)
{
	print "$error";
}
else
{
print <<<ENDTAG
<p><a href="#" id="showpwgen">Password Generator</a></p>
    <a name="top"></a>
      <div id="TabbedPanels1" class="TabbedPanels">
   	    <ul class="TabbedPanelsTabGroup">
      		$panels
     	  </ul>
     	  <div class="TabbedPanelsContentGroup">
      		$display
        </div><!--tabbed panel content group end-->
   </div><!--tabbed panels-->
ENDTAG;
}
print <<<ENDTAG
  </div><!--wholepage -->
  </div><!--bodywrap-->
</div><!--master-->
<script type="text/javascript">
    <!--
    	var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
    	//-->
    	</script>
		
<div id="passwordmaker">
	<a href="#" id="closelb"><img src="images/close.png" border="0" class="closelb" /></a>
	<p><strong>Generate Strong Password</strong></p>
	
	<table width="300">
	<tr>
	<td>
		Length:
	</td>
	<td>
		<select name="length" id="pwl">
ENDTAG;
$count=1;
while($count<15)
{
	print "<option value=\"$count\">$count</option>";
	$count=$count+1;
}
print <<<ENDTAG
	</select>
	</td>
	</tr>
	<tr>
	<td colspan="2" id="password">
		
	</td>
	</tr>
	</table>
		
	
</div>
</body>
</html>
ENDTAG;
?>