<?php
session_start();
include("../includes/declarations.php");
include("includes/declarations.php");
$action=$_GET['action'];
$t=$_GET['t'];

$title=addslashes($_POST['title']);
$text=addslashes($_POST['text']);	
	
if($UMVpeMcm4GwCVCsuds36OQS5HmVNNI=="1")
{
    // $imagedir="/home/content/77/10286677/html/images/uploads";
	$imagemagickPath = "/usr/bin";
    include ("../includes/dbconnect.php");

    if ($link)
    {
    	if ($action=="edit")
    	{
    		$formaction="makeedits";
    		$heading = "Make Edits";

			
    		if ($single=mysql_query(" SELECT
    			title,
				text
    			from interesting_facts WHERE id='$t'"))


    			{
    				while ($row=mysql_fetch_array($single))
    				{
    					
    					$title=$row[0];
    					$text=stripslashes($row[1]);

  
    				}
    			}
    			else
    			{
    				$error .= "<B>Error:</B>  Database query failed for this trivia item.\n";
    			}
    	}
    	elseif ($action=="makeedits")
    	{
    

             if ($result=mysql_query("UPDATE interesting_facts
                  SET
                    title = '".addslashes($title)."',
                    text = '".addslashes($text)."'
                    WHERE id='$t'"))
    				{
    					header("Location: $domain/admintools/managetrivia.php");
    				}
    				else
    				{
						$goof=mysql_error();
    					$error .= "<b>Error:</b>  Database update failed.  $goof\n";
    				}
        }

        elseif ($action=="addnew")
        {

    	//add new news item

      
         
              if ($result=mysql_query("INSERT into interesting_facts
                           SET
                            date = NOW(),
                            title = '$title',
                            text = '$text'"))
         					{
								header("Location: $domain/admintools/managetrivia.php");
    						}
    						else
    						{
								$error .= "<b>Error:</b>  DB Insert failed.\n";
    						}

      }
    }
    else
    {
    	$error .= "<b>Error:</b>  Database connection failed.\n";
    }


    if (!$action)
    {
      $submitvalue=" Add Trivia item";
      $heading = " Add Trivia item";
      $formaction="addnew";

      $Month=date('m');
      $TheDate=date('d');
      $TheYear=date('Y');

      
    }
}
else
{
    include("loginerror.php");
}
print <<<ENDTAG
<article id="content">
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/sample.js" type="text/javascript"></script>
<link href="ckeditor/sample.css" rel="stylesheet" type="text/css"/>

ENDTAG;
include("../headerinclude.php");
if ($error)
{
	print "<font color=\"red\">$error</font>\n";
}
else
{
print <<<ENDTAG
<!-- This <div> holds alert messages to be display in the sample page. -->
	<div id="alerts">
		<noscript>
			<p>
				<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
				support, like yours, you should still see the contents (HTML data) and you should
				be able to edit it normally, without a rich editor interface.
			</p>
		</noscript>
	</div>
<a href="index.php">Admin home</a> > <a href="managetrivia.php">Manage Trivia</a> > $heading
$heading

<p><FORM ACTION="addtrivia.php?action=$formaction&t=$t" METHOD="POST">
<p><TABLE WIDTH=600 BORDER=1>

  <TR VALIGN=TOP>
<TD WIDTH=100>
  <B>Title:</B>
<TD>

  <INPUT TYPE="text" NAME="title" VALUE="$title" SIZE=40>

</TD>
</TR>

<TR VALIGN=TOP>
<TD>
  <B>Text</B>
</TD>

<TD>
<textarea cols="80" id="editor_kama" name="text" rows="10">$text</textarea>
				<script type="text/javascript">
				//<![CDATA[

					CKEDITOR.replace( 'text',
						{
							skin : 'kama'
						});

				//]]>
				</script>

</TD>
</TR>
<TR VALIGN=TOP>
<TD COLSPAN=2 ALIGN=CENTER>
  <INPUT TYPE="submit" VALUE=" $heading ">
</TD>
</TR>

</TABLE>
</FORM>
</article>
ENDTAG;
}
include ("/home/content/44/10809344/html/SPACEROCK/includes/footerinc.php");


?>