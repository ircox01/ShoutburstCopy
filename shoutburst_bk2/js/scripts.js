var mySound = $(this).next('.glyphicon .glyphicon-play');
//$("body").removeClass('ua-sidebar');
//$(".main-nav-toggle").click(function(e){
//	$("body").toggleClass('ua-sidebar');
//	e.preventDefault();
//});
/*
$("#main-nav .nav a").click(function(){
	$("#main-nav .nav a").removeClass('active');
	$(this).addClass('active');
});
*/
$(".sound").click(function(){
	$(this).children('.glyphicon-play').toggleClass('glyphicon-pause');
});

$(".delete").click(function(){
	$(this).parents('tr').fadeOut();
});

/*
$(".on-off li.team").click(function(e){
	$(this).toggleClass('active');
	e.preventDefault();
});
*/

//Disable - Enable Side menu for development purpose
//$("body").removeClass('ua-sidebar');


//Main nav Toggle
$(".main-nav-toggle").click(function(e){
	// Check browser support
	if (typeof(Storage) != "undefined") {

		//Retrieve value
		var mainNavValue = localStorage.getItem("mainNavState");

		// Check if main nav menu visible or not then change value regarding that
		if ( mainNavValue == "ua-sidebar") {
			mainNavValue = "";
		} else {
			mainNavValue = "ua-sidebar";
		}

		// Store value
		localStorage.setItem('mainNavState', mainNavValue);

		// Retrieve
		$("body").removeClass('ua-sidebar');
		$("body").addClass(localStorage.getItem("mainNavState"));

	}
	else {
		alert('Sorry, your browser does not support Web Storage...');
	}

});

function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}

// NX: Fix for first page load display of LH menu
if(endsWith(document.referrer,"shoutburst/") || endsWith(document.referrer,".co.uk/")) {
	localStorage.setItem('mainNavState', "ua-sidebar");
}

$("body").addClass(localStorage.getItem("mainNavState"));



//Header Toggle
$(".header-toggle").click(function(e) {

	//Fix for Ian's Request of Top Menu closed as Standard

	/*
	// Check browser support
	if (typeof(Storage) != "undefined") {

		//Retrieve value
		var headerValue = localStorage.getItem("headerState");

		// Check if main nav menu visible or not then change value regarding that
		if ( headerValue == "header-show") {
			headerValue = "";
		} else {
			headerValue = "header-show";
		}

		// Store value
		localStorage.setItem('headerState', headerValue);

		// Retrieve
		$("body, .header-toggle").removeClass('header-show');
		$("body, .header-toggle").addClass(localStorage.getItem("headerState"));

	}
	else {
		alert('Sorry, your browser does not support Web Storage...');
	}
	*/

	localStorage.removeItem( 'headerState' );

	$("body, .header-toggle").toggleClass( 'header-show' );

});

$("body, .header-toggle").addClass(localStorage.getItem("headerState"));
