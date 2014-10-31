$(document).ready(function() {

	$('#color1').colorPicker();

	$('#color1').change(function(){
    	//alert("color changed");
    	$('.imagebig').css('background', this.value);
   });
	
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
			$('.imagebig').append('<img src="img/bg-' + bg + '.png">');
		}
	});

	$("#message").on('change keyup paste', function() {
    	// your code here
    	$('#bigtext').html(this.value);
	});

	$("#agentname").on('change keyup paste', function() {
    	// your code here
    	$('.agent-name').html(this.value);
	});

	$("#position").on('change keyup paste', function() {
    	// your code here
    	$('.agent-position').html(this.value);
	});


	$("#date").on('change keyup paste', function() {
    	// your code here
    	$('.date').html(this.value);
	});
	
	$('.print-butt').click(function() {
		window.print();
	});

});
