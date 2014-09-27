/* resume slider */
$(document).ready(function(){
	$('.resume_section').click(function(){
		var contentToShow=$(this).attr("id");
		$('#'+contentToShow+'_content').slideToggle();
	});
});
/* netflix-esque dvd display */

  $(document).ready(function(){
    $('.moviecell_title').hover(function() {
     var $div = $(this);
     $div.find('.white_box').css({
         'display': 'block'
     });
    }, function(){ $(this).find('.white_box').css({ 'display':'none'}); });
});

$(document).ready(function(){
	$('#selectCategory').change(function(){
		$('#selectform').submit();
	});
});
// news item single display page - decides how to display the image if there is one.

$(document).ready(function() {


    var height = $("#mainpic").height();
    var width = $("#mainpic").width();
    $('#picsize').append('The size of this pic is height:' + height + ' width: ' + width);
    var cssWidth=width+'px';
    if (width < 600) {
        $("#mainpic").css({
            float: 'left',
            padding: '5px'
        });
    }
    else {
       if(width>600)
       {
         var cssWidth=600+'px';
         $("#mainpic").css({ width:'600px' });
         
       }
       $("#mainpicholder").css ({ width:cssWidth, marginLeft:'auto', marginRight:'auto' });
    }
});
