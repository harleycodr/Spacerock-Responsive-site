	<?php
	
	include("includes/dbconnect.php");
	if($link)
	{
		if($result=mysql_query("SELECT
		CountryID,
		Country
		from Countries
		where CountryID!='254'
		order by Country"))
		{
			while($row=mysql_fetch_array($result))
			{
				$countryID=$row[0];
				$country=$row[1];

				$countryselects .= "<option value=\"$countryID\">$country</option>\n";
			}
		}
		else
		{
			$goof=mysql_error();
			$error="<b>Error:</b>  $goof";
		}
	}
	else
	{
		$error="<b>Error:</b>  No database connection.";
	}
print <<<ENDTAG
	<!DOCTYPE html>
	<head>
	<title>Cool form</title>
	<script src="js/jquery-1.8.2.min.js"></script>
	<script src="js/jquery.maskedinput.js"></script>
	<script src="js/chainedselects.js"></script>
	<script src="js/utils.js"></script>
	<link href="http://www.spacerock.com/toolpage/tools.css" rel="stylesheet" type="text/css" />
	</head>
	<body style="background:#fff;">
ENDTAG;
if($error)
{
	print "$error";
}
else
{
print <<<ENDTAG
	<table width="580" style="text-align:left; outline:solid thin;">
	<tr valign="top">
	<td width="290">
       <p>First Name:  *<br />
        <input type="text" name="first" size="30" id="first" />
        <div id="firsterror" style="display: none;"><span class="formerror">This field is required.</span></div>
    </td>
    <td width="290">
        <p>Last Name:  *<br />
         <input type="text" name="last" size="30" id="last" />
       <div id="lasterror" style="display: none;"><span class="formerror">This field is required</span></div>
    </td>
	</tr>
	<tr valign="top">
	<td>
    <p style="clear: both; font-size:11px;">Street Address  *
    <br /><input type="text" name="address1" size="30" id="address1" />
    <br /><input type="text" name="address2" size="30" id="address2" /></p>
    <div id="addresserror" style="display: none;"><span class="formerror">This field is required</span></div>
  </td>
  <td>
    <p style="font-size: 11px;">City  *
    <br /><input type="text" name="city" size="30" id="city" />
     <div id="cityerror" style="display: none;"><span class="formerror">This field is required</span></div>
  </td>
  </tr>
  
  <tr valign="top">
  <td colspan="2">
	  <table style="text-align:left;">
	  <tr valign="top">
	  <td width="60">
		<p>Country:*</p>
		</td>
		<td width="250">
		<p><select id="country" name="country">
		<option value=""></option>
		<option value="254">United States</option>
		$countryselects
		</select></p>
		<div id="countryerror" style="display: none;"><span class="formerror">This field is required</span></div>

		</td>
		
		<td style="text-align:right;">
			<p>State/Province*</b>
			<p style="font-size: 11px;">Postal Code:*
		</td>
		<td style="text-align:left;">
			<p><select name="state" id="state"></select>
			 <div id="stateerror" style="display: none;"><span class="formerror">This field is required</span></div></p>
			 
			<p/><input type="text" name="zip" size="10" id="zip" /></p>
			 <div id="ziperror" style="display: none;"><span class="formerror">This field is required</span></div>
		</td>
		</tr>
	</table>
</td>
</tr>
<tr valign="top">
	<td>
        <p style="font-size: 11px;">E-mail Address:  *
        <br /><input type="text" name="email" size="30" id="email" /></p>
        <div id="emailerror" style="display: none;"><span class="formerror">This field is required</span></div>
	</td>
	<td>
		<p style="font-size: 11px;">Phone Number  *
		<br /><input type="text" name="phone" size="30" id="phone" /></p>
		<div id="phoneerror" style="display: none;"><span class="formerror">This field is required</span></div>
	</td>
	</tr>
	<tr valign="top">
	<td>
		<p style="font-size: 11px;">Website Address:</p>
	</td>
	<td>
		<p style="font-size: 11px;">http://<input type="text" name="url" size="30" /></p>
	</td>
	</tr>
	</table>
</div>
</li>
<div style="clear: both;"></div>
<!-- bill to info-->
<li id="foli5" class="notranslate" style="margin-top:5px;">
  <span class="style9">
    <p style="font-weight:bold;">Billing Information:
  
    <br /><input type="checkbox" id="sbi" />Same as Contact Information</p>
  
    
    <div style="width:600px; float:left; outline:solid thin;">
	<table width="580" style="text-align:left;">
	<tr valign="top">
	<td width="290">
       <p>First Name:  *<br />
        <input type="text" name="billfirst" size="30" id="billfirst" />
        <div id="firsterror" style="display: none;"><span class="formerror">This field is required.</span></div>
    </td>
    <td width="290">
        <p>Last Name:  *<br />
         <input type="text" name="billlast" size="30" id="billlast" />
       <div id="lasterror" style="display: none;"><span class="formerror">This field is required</span></div>
    </td>
	</tr>
	<tr valign="top">
	<td>
  
  </span-->
    
    <p style="clear: both; font-size:11px;">Street Address  *
    <br /><input type="text" name="billaddress1" size="30" id="billaddress1" />
    <br /><input type="text" name="billaddress2" size="30" id="billaddress2" /></p>
    <div id="addresserror" style="display: none;"><span class="formerror">This field is required</span></div>
  </td>
  <td>
    <p style="font-size: 11px;">City  *
    <br /><input type="text" name="billcity" size="30" id="billcity" />
     <div id="cityerror" style="display: none;"><span class="formerror">This field is required</span></div>
  </td>
  </tr>
  
  <tr valign="top">
  <td colspan="2">
  <div id="thebillsection">
	  <table style="text-align:left;">
	  <tr valign="top">
	  <td>
		<p>Country:*</p>
		</td>
		<td>
		<p><input type="text" id="billcountry" name="billcountry">
		</p>
		<div id="countryerror" style="display: none;"><span class="formerror">This field is required</span></div>

		</td>
		
		<td style="text-align:right;">
			<p>State/Province*</b>
			<p style="font-size: 11px;">Postal Code:*
		</td>
		<td style="text-align:left;">
			<p><input type="text" id="billstate" />
			 <div id="stateerror" style="display: none;"><span class="formerror">This field is required</span></div></p>
			 
			
		</td>
		</tr>
	</table>
	</div>
	<p>Zip/Postal Code  <input type="text" name="billzip" size="10" id="billzip" /></p>
			 <div id="ziperror" style="display: none;"><span class="formerror">This field is required</span></div>
</td>
</tr>
	</table>
</div>
    

</
        </form> 
</body>
</html>
ENDTAG;
}
?>