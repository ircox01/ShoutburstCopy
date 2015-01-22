<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>js/fireworks/assets/styles.css"/>
<script src="<?php echo base_url()?>js/fireworks/assets/jquery-1.11.0.min.js"></script>
<!-- Load Canvas support for IE8 and below (IE9 support Canvas) -->
<!--[if lt IE 9]><script src="<?php echo base_url()?>js/fireworks/assets/excanvas.js"></script><![endif]-->
<script src="<?php echo base_url()?>js/fireworks/assets/fireworks.js"></script>
		        
<script src="http://www.google.com/jsapi"></script>
<script>google.load("swfobject", "2.2");</script>
		
<script type="text/javascript">
		var delay = <?php echo SCREEN_DELAY?>; //Your delay in milliseconds
		var URL = '<?php echo base_url().'wallboard'?>';
		setTimeout(function(){ window.location = URL; }, delay);
</script>
</head>
	
<body>
	<img id="toptext" src="<?php echo base_url()?>js/fireworks/assets/highscoretext.gif"/>
	<div id="city"></div>
	<canvas id="fireworks" data-text="<?php echo $wb['ticker_tape']?>"></canvas>
	<img id="logo" src="<?php echo base_url().USER_PHOTO.'/'.$wb['logo']?>"/>
	<div style="display:none;">
		<audio controls autoplay loop>
		  <source src="<?php echo base_url()?>js/fireworks/assets/cheering.mp3" type="audio/mpeg">
		</audio>
	</div>

</body>
</html>