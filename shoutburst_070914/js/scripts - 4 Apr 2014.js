var mySound = $(this).next('.glyphicon .glyphicon-play');

$(".main-nav-toggle").click(function(e){
	$("body").toggleClass('ua-sidebar');
	e.preventDefault();
});

$("#main-nav .nav a").click(function(){
	$("#main-nav .nav a").removeClass('active');
	$(this).addClass('active');
});

$(".sound").click(function(){
	$(this).children('.glyphicon-play').toggleClass('glyphicon-pause');
});

$(".delete").click(function(){
	$(this).parents('tr').fadeOut();
});
