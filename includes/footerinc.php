<?php
print <<<ENDTAG
	<footer id="pagefooter">
		<p><a href="news.php">News</a>
		<a href="photos.php">Photos</a>
		<a href="about.php">About Me</a>
		<a href="collections.php">Collections</a>
		<a href="#" id="showcontactform">Contact Me</a>
		<br /><a href="index.php">Home</a></p>
		<p><a href="index.php"><img src="images/saturn.png" border="0" title="Click here to return to home page" />
		<br />Copyright 1996-$thisyear
		<br />Marian J. Stevens</p>
	</footer>

<script>
	setTimeout("Validate_Submit()", 5000);

	function Validate_Submit()
	{
		document.getElementById('hidden_field').value = 'SecretValue';
	}
</script>
<script src="js/lightbox.js"></script>
    <script type="text/javascript">
        function showStuff(id) {
            document.getElementById(id).style.display = 'block';
        }
    </script>

    <script type="text/javascript">
        function hideStuff(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
</body>
</html>
ENDTAG;
?>