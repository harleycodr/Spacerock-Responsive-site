<?php

print <<<ENDTAG
<div class="lightbox" id="contactbox" style="display:none;">
	<a href="#" id="close">Close</a>
	<h3 class="tac">Contact Me</h3>
	<form action="contactform.php" method="post">
	<div id="formcontainer">
		<p><input type="text" name="name" placeholder="Your Name" size="50" /></p>
		<p><input type="email" name="email" placeholder="Your E-mail Address" size="50" /></p>
		<p><textarea name="message" placeholder="Your Message" rows="4" cols="40"></textarea></p>
		<p class="hidden"><input type="url" name="url" /></p>
		<p class="tac"><input type="submit" value="Send" class="contactbtn" /></p>
	</div>
</div>
ENDTAG;
?>