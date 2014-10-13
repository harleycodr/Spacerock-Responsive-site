$(document).ready(function(){
    
 
	// same for billing info
	
	$("#sbi").click(function(){
		var first=$("#first").val();
		var last=$("#last").val();
		var address1=$("#address1").val();
		var address2=$("#address2").val();
		var city=$("#city").val();
		var state=$("#state").val();
		var zip=$("#zip").val();
		var country=$("#country").val();
		
		$("#billfirst").val(first);
		$("#billlast").val(last);
		$("#billaddress1").val(address1);
		$("#billaddress2").val(address2);
		$("#billcity").val(city);
		$("#billstate").val(state);
		$("#billcountry").val(country);
		$("#billzip").val(zip);
		
		
		// look up country name and stuff
		
					jQuery('#state').val(state);
			var dataString='CountryID='+country;
			
			var i="";
			
			var url='lookupcountryname.php';	
	
		    jQuery.ajax({
				type: 'get',
				url:url,
				data:dataString,
				dataType: 'json',
				success: function(data)
				{

				//var cname=data[0];
				
				var p=eval (data);
                console.log(data);
			    for(i in p)
				{
					jQuery('#thebillsection').html('<p>Country:<br /><input type=text name=mailcountry value='+p[i].countryname+' /></p><p>State<br /><input type=text name=mailstate value='+state+' /></p>');
				}
				}
				
			});
		// lookup end
		
	});
	
		// form field validation
		
		
});
		$("#first").blur(function(){
			var first=$("#first").val();
			if(first==="")
			{
				$("#firsterror").show();
			}
			else
			{
				$("#firsterror").hide();
			}
		});
		
		$("#last").blur(function(){
			var last=$("#last").val();
			if(last==="")
			{
				$("#lasterror").show();
			}
			else
			{
				$("#lasterror").hide();
			}
		});
		
		$("#address1").blur(function(){
			var address=$("#address1").val();
			if(address==="")
			{
				$("#addresserror").show();
			}
			else
			{
				$("#addresserror").hide();
			}
		});
		
		$("#city").blur(function(){
			var city=$("#city").val();
			if(city==="")
			{
				$("#cityerror").show();
			}
			else
			{
				$("#cityerror").hide();
			}
		});
		$("#state").blur(function(){
			var state=$("#state").val();
			if(state==="")
			{
				$("#stateerror").show();
			}
			else
			{
				$("#stateerror").hide();
			}
		});
		$("#zip").blur(function(){
			var zip=$("#zip").val();
			if(zip==="")
			{
				$("#ziperror").show();
			}
			else
			{
				$("#ziperror").hide();
			}
		});
		$("#country").blur(function(){
			var country=$("#country").val();
			if(country==="")
			{
				$("#countryerror").show();
			}
			else
			{
				$("#countryerror").hide();
			}
		});
		$("#email").blur(function(){
			var email=$("#email").val();
			if(email==="")
			{
				$("#emailerror").show();
			}
			else
			{
				$("#emailerror").hide();
			}
		});
		$("#phone").blur(function(){
			var phone=$("#phone").val();
			if(phone==="")
			{
				$("#phoneerror").show();
			}
			else
			{
				$("#phoneerror").hide();
			}
		});
		$("#resale_no").blur(function(){
			var resale_no=$("#resale_no").val();
			if(resale_no==="")
			{
				$("#resale_noerror").show();
			}
			else
			{
				$("#resale_noerror").hide();
			}
		});
		
// country - province lookup jQuery select menus

	jQuery(document).ready(function() {
	  jQuery('#country').chainSelect('#state','countrylookup.php',
			{
					before:function (target) //before request hide the target combobox and display the loading message
					{
							jQuery("#loading1").css("display","block");
							jQuery(target).css("display","none");
					},
					after:function (target) //after request show the target combobox and hide the loading message
					{
							jQuery("#loading1").css("display","none");
							jQuery(target).css("display","inline");
					}
			});
		
		jQuery('#billcountry').chainSelect('#billstate','countrylookup.php',
			{
					before:function (target) //before request hide the target combobox and display the loading message
					{
							jQuery("#loading1").css("display","block");
							jQuery(target).css("display","none");
					},
					after:function (target) //after request show the target combobox and hide the loading message
					{
							jQuery("#loading1").css("display","none");
							jQuery(target).css("display","inline");
					}
			});

		});
		
// stuff for masked input js
$(document).ready(function(){
	jQuery(function($){
   $("#phone").mask("(999) 999-9999");
});
});