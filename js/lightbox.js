$(document).ready(function(){
	$('.portthumb').click(function(){
		var showsite=$(this).attr("id");
		$('#blackout').show();
		$('#site' + showsite + '').show();
		

	$('.close').click(function(){
		$('#blackout').hide();
		$('#site' + showsite + '').hide();
	});
/* close with escape key */
$(document).keyup(function(e) { 
        if (e.keyCode == 27) { // esc keycode
            $('#lightbox').hide();
            $('#blackout').hide();
			$('#site' + showsite + '').show();
        }
    });
});	
	
});