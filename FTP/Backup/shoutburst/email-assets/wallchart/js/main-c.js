$(document).ready(function() {

	// $('#color1').colorPicker();

	// $('#color1').change(function(){
 //    	//alert("color changed");
 //    	$('.imagebig').css('background', this.value);
 //   });
	
	$('.ui-elements a').click(function(){

		//alert("Click en: " + $(this).attr('id') );
		var bg = $(this).attr('id');
		
		if(bg != 0) {

			$('.five-el a').removeClass("selected");
			$(this).addClass("selected");

			$('#agenttext').removeClass();
			$('#certdesc').removeClass();

			$('#agenttext').addClass('agentname-big-' + bg);
			$('#certdesc').addClass('certificate-description-' + bg);

			$('.imagebig').empty();
			$('.imagebig').append('<img src="img/certificates/certificates-' + bg + '.png">');
		}
	});

	$("#message").on('change keyup paste', function() {
    	// your code here
    	$('#certdesc').html(this.value);
	});

	$("#agentname").on('change keyup paste', function() {
    	// your code here
    	$('#agenttext').html(this.value);
	});

	// $("#position").on('change keyup paste', function() {
 //    	// your code here
 //    	$('.agent-position').html(this.value);
	// });


	// $("#date").on('change keyup paste', function() {
 //    	// your code here
 //    	$('.date').html(this.value);
	// });
	
	$('.print-butt').click(function() {
		window.print();
	});

});
