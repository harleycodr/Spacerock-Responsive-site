<?php

include ("../includes/dbconnect.php");

if($link)
{
    $thisurl=$_SERVER["PHP_SELF"];

    $ip = getenv('REMOTE_ADDR');

    if($result=mysql_query("INSERT
        into attempts
        SET
        date=NOW(),
        time=NOW(),
        ip='$ip',
        page='$thisurl'"))
        {
            $to="mstevens713@gmail.com";
            $subject="Login attempt to $thisurl";
            $body="Someone tried to login to $thisurl from IP $ip.";

            if(mail($to, $subject, $body, $headers ))
            {
                $error .= "<b>Error:</b>  You  must be logged in to view this page and contents.  I don't know why someone wants to hack into a middle-aged woman's just for fun site anyway.  Come on now.  </p>\n";
                $error .= "<p><b>You are Here</b></p></header><meta name=\"viewport\" content=\"width=620\" />

													<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=false\"></script>
															<article>
																<p>Finding your location: <span id=\"status\">checking...</span></p>
															</article>
													<script>
													function success(position) {
														var s = document.querySelector('#status');

														if (s.className == 'success') {
															// not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back
															return;
														}

														s.innerHTML = \"found you!\";
														s.className = 'success';

														var mapcanvas = document.createElement('div');
														mapcanvas.id = 'mapcanvas';
														mapcanvas.style.height = '400px';
														mapcanvas.style.width = '560px';

														document.querySelector('article').appendChild(mapcanvas);

														var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
														var myOptions = {
															zoom: 15,
															center: latlng,
															mapTypeControl: false,
															navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
															mapTypeId: google.maps.MapTypeId.ROADMAP
														};
														var map = new google.maps.Map(document.getElementById(\"mapcanvas\"), myOptions);

														var marker = new google.maps.Marker({
																position: latlng,
																map: map,
																title:\"You are here!\"
														});
													}

													function error(msg) {
														var s = document.querySelector('#status');
														s.innerHTML = typeof msg == 'string' ? msg : \"failed\";
														s.className = 'fail';

														// console.log(arguments);
													}

													if (navigator.geolocation) {
														navigator.geolocation.getCurrentPosition(success, error);
													} else {
														error('not supported');
													}

													</script>\n";
                $debug = "It worked.  Check your email.  $ip, $thisurl";
            }
            $debug = "Hmmmm";
        }
        else
        {
            $error = "<b>Blah.  Didn't work.</b>";
        }
}
else
{
    $debug="DB Connection didn't cut it.";
}
    print "<html><head><title>Debug</title></head><body>";
    print "$debug";
    print "</body>";

?>