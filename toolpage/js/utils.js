/* generate password */
$(document).ready(function() {
	$('#pwl').change(function(){
		var pwl=$('#pwl').val();
		
		var dataString='pwl='+pwl;
		$.ajax({
			type:  "POST",
			url:"pwgen.php",
			data:dataString,
			success:  function(data)
			
			$('#password').html('<input type=text size=30 id=password value='+ data + '>')
			
		});
	});
});

/* show pwform */
$(document).ready(function() {
	$('#showpwgen').click(function(){
		$('#blackout').show();
		$('#passwordmaker').show();
	});
	
	$('#closelb').click(function(){
		$('#blackout').hide();
		$('#passwordmaker').hide();
	});
});
