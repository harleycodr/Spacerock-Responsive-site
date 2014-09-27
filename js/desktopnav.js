$(document).ready(function(){
	$('.navparent a').click(function(){
      var id =  $(this).attr('id');
      id = id.split('_');
      $('#navchild_'+id[0]).slideToggle();
	});
		
});

