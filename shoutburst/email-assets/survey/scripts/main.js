$(document).ready(function() {
	
	'use strict';


	document.showView = function(vista) {
    	//$(".main-content").empty();

    	$('.main-content').transition({
			perspective: '99px',
			rotateY: '180deg',
			easing: 'ease',
			duration:300,
			opacity: 0,
			complete: function() {
				$(".main-content").empty();
				$.ajax({
					url: vista,
					beforeSend: function() {
						//Loading...
					},
					cache: false
				})
					.done(function(html) {
						$(".main-content").prepend(html);
						$(".main-content").transition({
							opacity: 1,
							rotateY:'360deg',
							delay:100,
							duration:300,
							easing: 'ease',
							perspective:'100px',
							complete: function() {

							}
						});
					});
			}
		});	
    }

	$("#DateCountdown").TimeCircles({
	    "animation": "smooth",
	    "bg_width": 0.2,
	    "fg_width": 0.03,
	    "start": false,
	    "circle_bg_color": "#90989F",
	    "time": {
	        "Days": {
	            "text": "Days",
	            "color": "#40484F",
	            "show": false
	        },
	        "Hours": {
	            "text": "Hours",
	            "color": "#40484F",
	            "show": false
	        },
	        "Minutes": {
	            "text": "Minutes",
	            "color": "#40484F",
	            "show": false
	        },
	        "Seconds": {
	            "text": "Seconds",
	            "color": "#86d84a",
	            "show": true
	        }
	    }
	});

	//$("#DateCountdown").TimeCircles().start();

	$("#btn-start-survey").click(function(){ 
		$("#DateCountdown").TimeCircles().start(); 
		//document.showView("second.html");
		document.showView("second.html");
		event.preventDefault(); 
	});

	

});