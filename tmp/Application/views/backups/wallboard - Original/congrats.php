<title>SHOUTBURST | High Score</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>js/fireworks/assets/styles.css"/>
<script src="<?php echo base_url()?>js/fireworks/assets/jquery-1.11.0.min.js"></script>
<!-- Load Canvas support for IE8 and below (IE9 support Canvas) -->
<!--[if lt IE 9]><script src="<?php echo base_url()?>js/fireworks/assets/excanvas.js"></script><![endif]-->
<script src="<?php echo base_url()?>js/fireworks/assets/fireworks.js"></script>
		        
<script src="http://www.google.com/jsapi"></script>
<script>google.load("swfobject", "2.2");</script>
		
<script type="text/javascript">
//		var delay = <?php //echo SCREEN_DELAY?>; //Your delay in milliseconds
//		var URL = '<?php //echo $_SERVER['HTTP_REFERER'];//base_url().'wallboard'?>';
		
//		setTimeout(function(){ window.location = URL; }, delay);
</script>
</head>

<?php

//$wb['ticker_tape'] = "Well done|{$congrats_list[0]->full_name}|You scored|{$congrats_list[0]->total_score}|Thats awesome!";
$names =array();
$scores = array();
foreach ($congrats_list as $congrats) {
//	echo $congrats->full_name. " " . $congrats->total_score . "<br />";
	$names[] = $congrats->full_name;
	$scores[] = $congrats->total_score;
}

$names_array = json_encode($names);
$scores_array = json_encode($scores);


?>
<script>

var names_array = <?=$names_array?>;
var scores_array = <?=$scores_array?>;


</script>

	
<body>
	<img id="toptext" src="<?php echo base_url()?>js/fireworks/assets/highscoretext.gif"/>
	<div id="city"></div>
	<div id="ccontainer"><canvas id="fireworks" data-text=".."></canvas></div>
	
<?php
if(isset($wb['logo']) && !empty($wb['logo']))
{	?>
<img id="logo" src="<?php echo base_url().USER_PHOTO.'/'.$wb['logo'];?>"/>
	
<?php
}
?>
	<div style="display:none;">
		<audio controls autoplay loop>
		  <source src="<?php echo base_url()?>js/fireworks/assets/cheering.mp3" type="audio/mpeg">
		</audio>
	</div>

</body>

<script>


WALLINTERVAL = 45000

    function reload_js(src) {
        $('script[src="' + src + '"]').remove();
        $('<script>').attr('src', src).appendTo('head');
    }



for (i = 0;i < names_array.length;i++) {

    var canvas_out = 'Well done|'+names_array[i]+'|You scored|'+scores_array[i];

    setTimeout(function(canvas_html) {
	  
	$("#fireworks").attr("data-text",canvas_html);
	var fireworksCanvas = $("#fireworks"),
        fireworksText = fireworksCanvas.attr('data-text');
        FireworkDisplay.launchText(fireworksCanvas, fireworksText);


    }, WALLINTERVAL * i, canvas_out);    

}

    setTimeout(function() {

	revert_url = "<?php echo base_url()?>wallboard/launch/<?=$nextslug?>";
	window.location = revert_url;

    }, WALLINTERVAL * i);


</script>



</html>
