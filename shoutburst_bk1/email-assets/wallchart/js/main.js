$(document).ready(function() {
	
	$('.ui-elements a').click(function(){

		//alert("Click en: " + $(this).attr('id') );
		var bg = $(this).attr('id');
		
		if(bg != 0) {

			$('.five-el a').removeClass("selected");
			$(this).addClass("selected");

			$('#bigtext').removeClass();
			$('#smalltext').removeClass();

			$('#bigtext').addClass('text-big-' + bg);
			$('#smalltext').addClass('text-small-' + bg);

			$('.imagebig').empty();
			$('.imagebig').append('<img src="img/bg-' + bg + '.jpg">');
		}
	});

	$("#message").on('change keyup paste', function() {
    	// your code here
    	$('#bigtext').html(this.value);
	});
	
	$('.print-butt').click(function() {
		window.print();
	});

});
