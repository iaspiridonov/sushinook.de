$(document).ready(function(){
	$("#description li a").click(function(){
		var selected = $(this).attr('href');
		$.scrollTo(selected, 500);
		return false;
	});
});
